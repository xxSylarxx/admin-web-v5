<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex" />
    <title>ADMIN - <?= mb_strtoupper(EMPRESA, 'UTF-8') ?></title>
    <link rel="shortcut icon" href="<?= PATH_PUBLIC ?>/img/icons/escudo.png" type="image/png">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css">
    <link rel="stylesheet" href="<?= PATH_PUBLIC ?>/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= PATH_PUBLIC ?>/css/admin.css">
    <link rel="stylesheet" href="<?= PATH_PUBLIC ?>/css/sweetalert2.min.css">
</head>

<body>

    <script async src="<?= PATH_PUBLIC ?>/js/sweetalert2.min.js"></script>
    <script src="<?= PATH_PUBLIC ?>/js/vue.min.js"></script>

    <?php include_once PATH_ROOT . '/views/admin/header.php'; ?>
    <?php include_once PATH_ROOT . '/views/admin/menu.php'; ?>

    <!-- ESTILOS -->
    <style>
        #fileupload {
            display: none;
        }

        .list-group-item {
            border: none;
            line-height: 28px;
        }

        .list-group-item.active {
            background-color: var(--color3);
            border-radius: 2px;
            cursor: pointer;
        }

        .list-group-item:not(.active):hover {
            cursor: pointer;
            background-color: rgb(239, 239, 239);
            border-radius: 2px;
        }

        td>.btn-sm {
            width: 32px;
            height: 32px;
        }
    </style>

    <!-- CUERPO -->
    <section class="content" id="app">
        <div id="preloader">
            <div class="loading">
                <div class="circle"></div>
            </div>
        </div>
        <div class="d-flex align-items-center">
            <div class="tab-titulo">
                <?= $this->translate('ARCHIVOS') ?>
            </div>
            <div class="ms-auto d-flex align-items-center">
                <div class="me-3">
                    <input type="search" class="form-control" placeholder="<?= $this->translate('Buscar archivo') ?>" v-model="files_buscar">
                </div>
                <label class="btn btn-success text-white" for="fileupload" style="font-size: 14.5px;">
                    <span><i class="fas fa-cloud-upload-alt"></i></span>
                    <span class="ms-1" id="load-text"><?= $this->translate('Cargar archivos') ?></span>
                </label>
                <input type="file" id="fileupload" size="92000" accept=".png, .jpg, .jpeg" @change.prevent="cargarArchivo()" multiple>
            </div>
        </div>
        <hr>
        <div class="d-flex pb-3">
            <div style="width: 210px;">
                <div style="position: sticky; top: 5.5em;">
                    <div class="text-primary mb-2 fw-bold">Files</div>
                    <!-- <ul class="list-group list-group-flush mb-3">
                        <li class="list-group-item active" @click="listarArchivos('img/galeria/', 0, '.png, .jpg, .jpeg')"><i class="far fa-folder-open"></i>&nbsp; <?= $this->translate('Imágenes') ?></li>
                        <li class="list-group-item" @click="listarArchivos('img/banner/', 1, '.png, .jpg, .jpeg')"><i class="far fa-folder-open"></i>&nbsp; Banner</li>
                        <li class="list-group-item" @click="listarArchivos('video/', 2, 'video/mp4')"><i class="far fa-folder-open"></i>&nbsp; <?= $this->translate('Videos') ?></li>
                        <li class="list-group-item" @click="listarArchivos('files/', 3, '.pdf, .zip')"><i class="far fa-folder-open"></i>&nbsp; <?= $this->translate('Documentos') ?></li>
                    </ul> -->
                    <ul class="list-group list-group-flush mb-3">
                        <li class="list-group-item active" @click="listarArchivos('img/galeria/', 0, '.png, .jpg, .jpeg')"><i class="far fa-folder-open"></i>&nbsp; <?= $this->translate('Imágenes') ?></li>
                        <li class="list-group-item" @click="listarArchivos('img/banner/', 1, '.png, .jpg, .jpeg')"><i class="far fa-folder-open"></i>&nbsp; Banner</li>
                        <li class="list-group-item" @click="listarArchivos('img/portadas/', 2, '.png, .jpg, .jpeg')"><i class="far fa-image"></i>&nbsp; Portadas</li>
                        <li class="list-group-item" @click="listarArchivos('video/', 3, 'video/mp4')"><i class="far fa-folder-open"></i>&nbsp; <?= $this->translate('Videos') ?></li>
                        <li class="list-group-item" @click="listarArchivos('files/', 4, '.pdf, .zip')"><i class="far fa-folder-open"></i>&nbsp; <?= $this->translate('Documentos') ?></li>
                    </ul>
                    <!-- <div class="text-primary mb-2 fw-bold">Opciones</div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Opcion</li>
                    </ul> -->
                </div>
            </div>
            <div class="ps-4" style="width: calc(100% - 210px);">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="font-size: 13px;"><?= $this->translate('NOMBRE') ?></th>
                                <th class="text-center" style="font-size: 13px; width: 90px; min-width: 90px;"><?= $this->translate('TIPO') ?></th>
                                <th class="text-center" style="font-size: 13px; width: 120px; min-width: 120px;">SIZE</th>
                                <th class="text-center" style="font-size: 13px; width: 170px; min-width: 170px;"><?= $this->translate('MODIFICACIÓN') ?></th>
                                <th class="text-center" style="font-size: 13px; width: 170px; min-width: 170px;"><?= $this->translate('OPCIONES') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, index) in filterFiles">
                                <td><a :href="item.path" target="_blank">{{item.name}}</a></td>
                                <td class="text-center">{{item.type}}</td>
                                <td class="text-center">{{item.size}}</td>
                                <td class="text-center">{{item.date}}</td>
                                <td class="text-center">
                                    <button class="btn btn-outline-secondary btn-sm" title="Copiar enlace" @click="copiarEnlace(item.path)"><i class="far fa-copy"></i></button>
                                    <a :href="item.path" class="btn btn-outline-info btn-sm mx-1" title="Descargar" :download="item.name"><i class="fas fa-arrow-down"></i></a>
                                    <button class="btn btn-outline-danger btn-sm" title="Eliminar" @click="eliminarArchivo(item.path)" :disabled="item.remove"><i class="far fa-trash-alt"></i></button>
                                </td>
                            </tr>
                            <tr v-show="filterFiles.length == 0">
                                <td colspan="5" class="text-center"><?= $this->translate('No se encontraron resultados') ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>


    <script>
        new Vue({
            el: '#app',
            data: () => {
                return {
                    files_list: [],
                    filesObj: {
                        key: 0,
                        path: 'img/galeria/',
                        accept: '.png, .jpg, .jpeg'
                    },
                    files_buscar: ''
                }
            },
            created() {

                const urlParams = new URLSearchParams(window.location.search);
                const tab = urlParams.get('tab');
                
                if (tab === 'portadas') {
                    this.listarArchivos('img/portadas/', 2, '.png, .jpg, .jpeg');
                } else if (tab === 'banner') {
                    this.listarArchivos('img/banner/', 1, '.png, .jpg, .jpeg');
                } else if (tab === 'videos') {
                    this.listarArchivos('video/', 3, 'video/mp4');
                } else if (tab === 'documentos') {
                    this.listarArchivos('files/', 4, '.pdf, .zip');
                } else {
                    this.listarArchivos(this.filesObj.path, this.filesObj.key, this.filesObj.accept);
                }
            },
            computed: {
                filterFiles: function() {
                    return this.files_list.filter(file => file.name.match(this.files_buscar));
                }
            },
            methods: {
                listarArchivos(path, key, accept) {
                    this.cambiarClass(key);
                    this.filesObj.path = path;
                    this.filesObj.key = key;
                    this.filesObj.accept = accept;
                    document.getElementById('fileupload').setAttribute("accept", accept);
                    const vue = this;
                    const data = new FormData();
                    data.append('path', path);
                    fetch('/admin/archivos/listar', {
                        method: 'POST',
                        body: data
                    }).then(function(res) {
                        return res.text();
                    }).then(function(res) {
                        try {
                            vue.files_list = JSON.parse(res);
                        } catch (error) {
                            vue.sweetAlert(res, 'error');
                        }
                    });
                },
                cargarArchivo() {
                    const vue = this;
                    const uri = "/admin/archivos/guardar";
                    const files = document.getElementById("fileupload").files;
                    
                    if (files.length === 0) return;

                    // Validar tamaño de todos los archivos
                    for (let i = 0; i < files.length; i++) {
                        const sizekb = parseInt(files[i].size / 1024);
                        if (sizekb > 92000) {
                            this.sweetAlert("<?= $this->translate('El archivo') ?> '" + files[i].name + "' <?= $this->translate('supera el límite del peso permitido, Max(12MB)') ?>", "warning");
                            return;
                        }
                    }

                    // Subir archivos uno por uno
                    document.getElementById("fileupload").disabled = true;
                    let uploadedCount = 0;
                    let failedFiles = [];

                    const uploadFile = (index) => {
                        if (index >= files.length) {
                            // Todos los archivos procesados
                            document.getElementById("fileupload").disabled = false;
                            document.getElementById("fileupload").value = ''; // Limpiar el input
                            vue.listarArchivos(vue.filesObj.path, vue.filesObj.key);
                            
                            if (failedFiles.length === 0) {
                                vue.sweetAlert(uploadedCount + ' <?= $this->translate('archivo(s) subido(s) correctamente') ?>', 'success');
                            } else {
                                vue.sweetAlert(uploadedCount + ' <?= $this->translate('archivo(s) subido(s)') ?>. <?= $this->translate('Fallaron') ?>: ' + failedFiles.join(', '), 'warning');
                            }
                            document.getElementById("load-text").innerText = "<?= $this->translate('Cargar archivos') ?>";
                            return;
                        }

                        const fileup = files[index];
                        const fileName = vue.formatName(fileup.name);
                        const http = new XMLHttpRequest();
                        const data = new FormData();

                        http.open("post", uri);
                        data.append("file_path", vue.filesObj.path);
                        data.append("file_name", fileName);
                        data.append("archivo", fileup);

                        http.upload.addEventListener("progress", function(e) {
                            let status = Math.round((e.loaded / e.total) * 100);
                            document.getElementById("load-text").innerText = "<?= $this->translate('Subiendo') ?> (" + (index + 1) + "/" + files.length + ") " + status + "%";
                        });

                        http.addEventListener("load", function() {
                            let res = http.responseText;
                            if (res.trim() == 'OK') {
                                uploadedCount++;
                            } else {
                                failedFiles.push(fileName);
                            }
                            // Subir el siguiente archivo
                            uploadFile(index + 1);
                        });

                        http.addEventListener("error", function() {
                            failedFiles.push(fileName);
                            uploadFile(index + 1);
                        });

                        http.send(data);
                    };

                    // Iniciar la carga del primer archivo
                    uploadFile(0);
                },
                eliminarArchivo(path) {
                    let vue = this;
                    Swal.fire({
                        icon: 'question',
                        text: '<?php echo $this->translate('¿Está seguro de eliminar este archivo?'); ?>',
                        showDenyButton: true,
                        allowOutsideClick: false,
                        confirmButtonText: '<?php echo $this->translate('Aceptar'); ?>',
                        denyButtonText: '<?php echo $this->translate('Cancelar'); ?>',
                    }).then(async (result) => {
                        if (result.isConfirmed) {
                            const data = new FormData();
                            data.append("file_path", path);
                            fetch('/admin/archivos/eliminar', {
                                method: 'POST',
                                body: data
                            }).then(function(res) {
                                return res.text();
                            }).then(function(res) {
                                if (res.trim() == "OK") {
                                    vue.listarArchivos(vue.filesObj.path, vue.filesObj.key);
                                    vue.sweetAlert("<?php echo $this->translate('Archivo eliminado'); ?>", "success");
                                } else {
                                    vue.sweetAlert(res, "error");
                                }
                            });
                        }
                    });
                },
                formatName(str) {
                    str = str.replace(/\s+/g, '-');
                    str = str.normalize("NFD").replace(/[\u0300-\u036f]/g, '');
                    return str;
                },
                copiarEnlace(path) {
                    let link = location.origin + path;
                    let aux = document.createElement("input");
                    aux.setAttribute("value", link);
                    document.body.append(aux);
                    aux.select();
                    document.execCommand("copy");
                    aux.remove();
                    this.sweetAlert("<?= $this->translate('Enlace copiado al portapapeles'); ?>", "success");
                },
                cambiarClass(key) {
                    let items = document.querySelectorAll('.list-group-item');
                    items.forEach((element, index) => {
                        if (index == key) {
                            element.classList.add('active');
                        } else {
                            element.classList.remove('active');
                        }
                    });
                },
                sweetAlert(mensaje, icon) {
                    Swal.fire({
                        icon: icon,
                        text: mensaje,
                    });
                }
            }
        });
        setTimeout(() => {
            let loader = document.getElementById('preloader');
            loader.style.opacity = '0';
            setTimeout(() => {
                loader.style.display = 'none';
            }, 500);
        }, 2500);
    </script>

</body>

</html>