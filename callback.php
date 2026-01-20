<?php

session_start();

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/core/Config.php';

use Facebook\Facebook;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Exceptions\FacebookResponseException;

$fb = new Facebook([
    'app_id' => FB_APP_ID,
    'app_secret' => FB_APP_SECRET,
    'default_graph_version' => 'v3.2'
]);

$helper = $fb->getRedirectLoginHelper();

if (isset($_GET['code'])) {
    try {
        if (isset($_SESSION['facebook_access_token'])) {
            $accessToken = $_SESSION['facebook_access_token'];
        } else {
            $accessToken = $helper->getAccessToken();
        }
    } catch (FacebookResponseException $e) {
        die('Graph returned an error: ' . $e->getMessage());
    } catch (FacebookSDKException $e) {
        die('Facebook SDK returned an error: ' . $e->getMessage());
    }
}

if (isset($accessToken)) {
    if (isset($_SESSION['facebook_access_token'])) {
        $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
    } else {
        $_SESSION['facebook_access_token'] = (string) $accessToken;
        $oAuth2Client = $fb->getOAuth2Client();
        $longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($_SESSION['facebook_access_token']);
        $_SESSION['facebook_access_token'] = (string) $longLivedAccessToken;
        $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
    }

    try {
        $graphResponse = $fb->get('/me?fields=name,first_name,last_name,email,link,gender,picture');
        $fbUsuario = $graphResponse->getGraphUser();
        $dataUsuario = array(
            'fb_user_uid' => isset($fbUsuario['id']) ? $fbUsuario['id'] : null,
            'fb_user_full_name' => isset($fbUsuario['name']) ? $fbUsuario['name'] : null,
            'fb_user_first_name' => isset($fbUsuario['first_name']) ? $fbUsuario['first_name'] : null,
            'fb_user_last_name' => isset($fbUsuario['last_name']) ? $fbUsuario['last_name'] : null,
            'fb_user_email' => isset($fbUsuario['email']) ? $fbUsuario['email'] : '',
            'fb_user_picture' => isset($fbUsuario['picture']['url']) ? $fbUsuario['picture']['url'] : null
        );
        $_SESSION['fb_user_data'] = json_encode($dataUsuario, JSON_UNESCAPED_UNICODE);
        header('Location: /admin/feed');
    } catch (FacebookResponseException $e) {
        session_destroy();
        die('Graph returned an error: ' . $e->getMessage());
    } catch (FacebookSDKException $e) {
        die('Facebook SDK returned an error: ' . $e->getMessage());
    }
} else {
    die('Error! No se pudo obtener el token');
}
