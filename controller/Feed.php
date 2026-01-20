<?php

use Admin\Core\View;
use Admin\Core\Controller;

use Facebook\Facebook;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Exceptions\FacebookResponseException;

class Feed extends Controller
{

    function __construct()
    {
        parent::sesionActiva();
        if (empty(FB_APP_ID) || empty(FB_APP_SECRET)) {
            die('Error, you need the ID code and secret key of the app');
        }
    }

    private function initLogueo()
    {

        $fb = new Facebook([
            'app_id' => FB_APP_ID,
            'app_secret' => FB_APP_SECRET,
            'default_graph_version' => 'v3.2'
        ]);

        $helper = $fb->getRedirectLoginHelper();
        $permisos = ['email'];

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

        if (!isset($accessToken)) {
            $loginURL = $helper->getLoginUrl(FB_REDIRECT_URL, $permisos);
            return $loginURL;
        }
    }

    public function index()
    {
        $loginURL = null;
        $fb_user_data = null;
        if (isset($_SESSION['fb_user_data'])) {
            $fb_user_data = json_decode($_SESSION['fb_user_data'], true);
        } else {
            $loginURL = $this->initLogueo();
        }
        $view = new View();
        $view->setName(__CLASS__);
        $view->setVariable('loginURl', $loginURL);
        $view->setVariable('fb_user_data', $fb_user_data);
        $view->render('feed/index');
    }
}
