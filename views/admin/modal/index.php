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

    <script src="<?= PATH_PUBLIC ?>/js/bootstrap.min.js"></script>
    <script src="<?= PATH_PUBLIC ?>/js/vue.min.js"></script>
    <script async src="<?= PATH_PUBLIC ?>/js/sweetalert2.min.js"></script>

    <?php include_once PATH_ROOT . '/views/admin/header.php'; ?>
    <?php include_once PATH_ROOT . '/views/admin/menu.php'; ?>

    <style>
        #modalFiles .file-item-img {
            border-radius: 1px;
            overflow: hidden;
            transform: translateZ(0);
            will-change: transform;
            contain: layout style paint;
        }

        #modalFiles .file-item-img:hover {
            cursor: pointer;
        }

        #modalFiles .file-item-img.end {
            height: 120px;
            background-color: rgb(230, 230, 230);
        }

        #modalFiles .file-item-img:hover img {
            transform: scale3d(1.12, 1.12, 1);
        }

        #modalFiles .file-item-img img {
            width: 100%;
            height: 120px;
            object-fit: cover;
            border-radius: 1px;
            transition: transform .2s ease-in-out;
            transform: translateZ(0);
            will-change: transform;
        }

        #modalFiles .file-item-img img[data-src] {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite;
        }

        @keyframes shimmer {
            0% {
                background-position: 200% 0;
            }

            100% {
                background-position: -200% 0;
            }
        }

        #modalFiles div.file-item {
            display: flex;
            flex-direction: row;
            align-items: center;
            border: 1px solid rgb(140, 140, 140);
            white-space: nowrap;
            padding: .6em .9em;
            border-radius: 3px;
        }

        #modalFiles div.file-item:hover {
            color: var(--color3);
            border: 1px solid var(--color3);
            cursor: pointer;
        }

        #modalFiles div.file-item-detalle {
            margin-left: 12px;
            max-width: 100%;
            text-overflow: ellipsis;
            overflow: hidden;
        }

        #modalFiles img.selected {
            filter: grayscale(250%);
        }

        .modal-body {
            overflow-y: auto;
            overflow-x: hidden;
            transform: translateZ(0);
            -webkit-overflow-scrolling: touch;
            will-change: scroll-position;
        }

        .responsive {
            position: relative;
            height: 0;
            overflow: hidden;
            padding-bottom: 56.2%;
            margin-bottom: 20px;
        }

        .responsive iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        #cantFiles {
            font-size: 15px;
        }
    </style>

    <section class="content" id="app">

        <div id="preloader">
            <div class="loading">
                <div class="circle"></div>
            </div>
        </div>

        <div class="d-flex align-items-center">
            <div class="tab-titulo">
                POP-UP
            </div>
            <div class="ms-auto">
                <button class="btn btn-danger text-white me-2" data-bs-toggle="modal" data-bs-target="#modalFiles"><i class="fas fa-search"></i> <?= $this->translate('Buscar en archivos') ?></button>
                <button class="btn btn-success text-white" @click="guardarModal()"><i class="fas fa-save"></i>&nbsp; <?= $this->translate('Actualizar') ?> Pop-up</button>
            </div>
        </div>
        <hr>
        <div class="d-flex pt-2 pb-4">
            <div class="pe-4" style="width: 300px;">
                <div style="position: sticky; top: 6em;">
                    <div class="card bg-light shadow-sm">
                        <div class="card-header">
                            <span class="fw-bold" style="font-size: 13px;"><i class="fas fa-bars"></i>&nbsp; <?= $this->translate('OPCIONES') ?></span>
                        </div>
                        <class class="card-body">
                            <span>Titulo:</span>
                            <input type="text" class="form-control mb-3 mt-1" v-model="modalTitulo" autocomplete="off" :disabled="!modalHeader">
                            <span>Animación:</span>
                            <select class="form-select mb-3 mt-1" v-model="modalAnimation" name="animation">
                                <option value="animate__bounceInDown">Slide Down</option>
                                <option value="animate__bounceInUp">Slide Up</option>
                                <option value="animate__slideInLeft">Slide Left</option>
                                <option value="animate__zoomIn">Zoom In</option>
                                <option value="animate__flipInY">Flip In</option>
                            </select>
                            <hr>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="checkVisible" v-model="modalVisible">
                                <label class="form-check-label" for="checkVisible">
                                    Ventana visible
                                </label>
                            </div>
                            <hr>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="checkHeader" v-model="modalHeader">
                                <label class="form-check-label" for="checkHeader">
                                    Mostrar encabezado
                                </label>
                            </div>
                            <hr>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="checkMargen" v-model="modalMargen">
                                <label class="form-check-label" for="checkMargen">
                                    Mostrar margen
                                </label>
                            </div>
                            <hr>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="checkCarousel" v-model="modoCarousel">
                                <label class="form-check-label" for="checkCarousel">
                                    Slider de imágenes
                                </label>
                            </div>
                        </class>
                    </div>
                </div>
            </div>
            <div id="content-grid" style="width: calc(100% - 300px);">
                <div class="modal-content  w-75 mx-auto pb-0">
                    <button class="btn btn-sm btn-outline-info" title="Limpiar" @click="limpiarPopUp()" style="position: absolute; margin-left: -44px;"><i class="fas fa-eraser"></i></button>
                    <div class="modal-header border-0" v-show="modalHeader">
                        <h5 class="modal-title">{{modalTitulo}}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body <?= $this->dataModal['margen'] == 'N' ? 'p-0' : null ?>" id="mod-body"><?= $this->dataModal['cuerpo'] ?></div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalFiles" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><?= $this->translate('Buscar archivos') ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="w-100 pt-3 px-3 pb-1">
                        <div class="d-flex align-items-center">
                            <div class="input-group me-3" style="width: 16%;">
                                <span class="input-group-text bg-white"><i class="far fa-folder-open"></i></span>
                                <select class="form-select" v-model="modoFiles" :disabled="modoCarousel">
                                    <option value="I"><?= $this->translate('Imágenes') ?></option>
                                    <option value="V"><?= $this->translate('Videos') ?></option>
                                    <option value="D"><?= $this->translate('Documentos') ?></option>
                                </select>
                            </div>
                            <button v-show="modoFiles == 'I'" class="btn btn-info" @click="insertarxLink()"><i class="far fa-image"></i>&nbsp; <?= $this->translate('Insertar por link') ?></button>
                            <button v-show="modoFiles == 'V'" class="btn btn-info" @click="insertarYoutube()"><i class="fab fa-youtube"></i>&nbsp; <?= $this->translate('Video de youtube') ?></button>
                            <div class="ms-auto"><?= $this->translate('Mostrando') ?> {{listFiles.length}} <?= strtolower($this->translate('de')) ?> {{totalFiles}}</div>
                        </div>
                        <hr>
                    </div>
                    <div class="modal-body pt-0">
                        <div class="row px-2 pb-1" v-if="modoFiles == 'I'">
                            <div class="col-sm-2" v-for="(item, index) in listFiles" style="padding: 2px;">
                                <div class="file-item-img">
                                    <img :data-src="item.miniatura || item.path" :src="index < 12 ? (item.miniatura || item.path) : ''" :title="item.name" :id="'img' + item.id" @click="agregarItem(item.path, 'img',item.id)">
                                </div>
                            </div>
                            <div class="col-sm-2" style="padding: 2px;">
                                <div class="file-item-img end text-center" @click="listFilesJson('img/galeria/')">
                                    <div class="d-flex flex-column align-items-center justify-content-center h-100">
                                        <span class="fs-2"><i class="far fa-arrow-alt-circle-right"></i></span>
                                        <span>Buscar más</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row px-2" v-else>
                            <div class="col-sm-3" v-for="(item, index) in listFiles" style="padding: 6px;">
                                <div class="file-item" @click="agregarItem(item.path, item.type)">
                                    <span class="fs-3"><i :class="item.icon"></i></span>
                                    <div class="file-item-detalle" :title="item.name">
                                        <div>{{item.name}}</div>
                                        <div style="font-size: 13px;">{{item.size}}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
    </section>


    <script>
        new Vue({
            el: '#app',
            data() {
                return {
                    listFiles: [],
                    modoFiles: 'I',
                    totalFiles: 0,
                    modalTitulo: '<?= $this->dataModal['titulo'] ?>',
                    modalHeader: <?= $this->dataModal['header'] == 'S' ? 'true' : 'false' ?>,
                    modalMargen: <?= $this->dataModal['margen'] == 'S' ? 'true' : 'false' ?>,
                    modalVisible: <?= $this->dataModal['visible'] == 'S' ? 'true' : 'false' ?>,
                    modoCarousel: <?= $this->dataModal['slider'] == 'S' ? 'true' : 'false' ?>,
                    modalAnimation: '<?= $this->dataModal['animation'] ?>',
                    listCarousel: []
                }
            },
            created() {
                this.listFilesJson('img/galeria/');
            },
            updated() {
                this.$nextTick(() => {
                    initLazyLoading();
                });
            },
            watch: {
                modoFiles: function(value) {
                    if (value == 'I') {
                        this.listFiles = [];
                        this.listFilesJson('img/galeria/');
                    } else if (value == 'V') {
                        this.listFiles = [];
                        this.listFilesJson('video/');
                    } else if (value == 'D') {
                        this.listFiles = [];
                        this.listFilesJson('files/');
                    }
                },
                modoCarousel: function(value) {
                    this.modoFiles = 'I';
                },
                modalMargen: function(value) {
                    if (!value) {
                        document.getElementById('mod-body').classList.add('p-0');
                    } else {
                        document.getElementById('mod-body').classList.remove('p-0');
                    }
                }
            },
            methods: {
                listFilesJson(path) {
                    const vue = this;
                    const data = new FormData();
                    const total = this.listFiles.length;
                    data.append('path', path);
                    fetch('/admin/archivos/listar/' + total, {
                        method: 'POST',
                        body: data
                    }).then(function(res) {
                        return res.text();
                    }).then(function(res) {
                        try {
                            const result = JSON.parse(res);
                            if (result.files.length > 0) {
                                vue.listFiles = vue.listFiles.concat(result.files);
                                vue.totalFiles = result.total;
                            } else {
                                vue.sweetAlert(`<?= $this->translate('No hay más archivos para mostrar') ?>`, 'warning');
                            }
                        } catch (error) {
                            vue.sweetAlert(res, 'error');
                        }
                    });
                },
                agregarItem(path, tipo, cod) {
                    let html = '';
                    if (this.modoFiles == 'I') {
                        if (this.modoCarousel) {
                            this.listCarousel.push({
                                id: cod,
                                img: path

                            });
                            // agregar class 'selected' a la imagen
                            let element = document.getElementById('img' + cod);
                            element.classList.add('selected');
                            // -- end --
                            html += `<div id="carouselModal" class="carousel slide" data-bs-ride="carousel"><div class="carousel-inner">`;
                            this.listCarousel.forEach((obj, index) => {
                                html += `<div class="carousel-item ${index == 0 ? 'active' : ''}"><img src="${obj.img}" class="d-block w-100"></div>`;
                            });
                            html += `</div><button class="carousel-control-prev" type="button" data-bs-target="#carouselModal" data-bs-slide="prev"> <span class="carousel-control-prev-icon" aria-hidden="true"></span> <span class="visually-hidden">Previous</span></button><button class="carousel-control-next" type="button" data-bs-target="#carouselModal" data-bs-slide="next"><span class="carousel-control-next-icon" aria-hidden="true"></span><span class="visually-hidden">Next</span></button></div>`;
                        } else {
                            html = `<img src="${path}" width="100%">`;
                        }
                    } else if (this.modoFiles == 'V') {
                        html = `<video src="${path}" width="100%" autoplay muted controls></video>`;
                    } else if (this.modoFiles == 'D') {
                        if (tipo == 'pdf') {
                            html = `<iframe src="${path}" width="100%" height="730" frameborder="0"></iframe>`;
                        } else {
                            this.sweetAlert('Selecciona un documento de formato PDF', 'warning');
                            return;
                        }
                    }
                    this.isYoutube = false;
                    document.getElementById('mod-body').innerHTML = html;
                },
                guardarModal() {
                    const vue = this;
                    const data = new FormData();
                    data.append('id', '1');
                    data.append('titulo', this.modalTitulo);
                    data.append('tipo', this.modoFiles);
                    data.append('cuerpo', document.getElementById('mod-body').innerHTML);
                    data.append('header', this.modalHeader ? 'S' : 'N');
                    data.append('margen', this.modalMargen ? 'S' : 'N');
                    data.append('slider', this.modoCarousel ? 'S' : 'N');
                    data.append('visible', this.modalVisible ? 'S' : 'N');
                    data.append('animation', this.modalAnimation);
                    fetch('/admin/modal/guardar', {
                        method: 'POST',
                        body: data
                    }).then(function(res) {
                        return res.text();
                    }).then(function(res) {
                        if (res.trim() == 'OK') {
                            vue.sweetAlert('<?= $this->translate('Cambios guardados correctamente') ?>', 'success');

                        } else {
                            vue.sweetAlert(res, 'error');
                        }
                    });

                },
                insertarxLink() {
                    if (this.modoFiles == 'I') {
                        const link = prompt(`<?= $this->translate('Ingrese la url de la imagen') ?>`, '');
                        if (link.length > 0) {
                            this.agregarItem(link, 'img');
                        }
                    }
                },
                insertarYoutube() {
                    if (this.modoFiles == 'V') {
                        const link = prompt(`<?= $this->translate('Ingrese link del video de youtube') ?>`, '');
                        if (link.length > 0) {
                            let videoId = link.match(/(?:https?:\/{2})?(?:w{3}\.)?youtu(?:be)?\.(?:com|be)(?:\/watch\?v=|\/)([^\s&]+)/);
                            if (videoId != null) {
                                let embed = `https://www.youtube.com/embed/${videoId[1]}`;
                                let iframe = `<div class="responsive"><iframe src="${embed}" allowfullscreen></iframe></div>`;
                                document.getElementById('mod-body').innerHTML = iframe;
                            } else {
                                this.sweetAlert('<?= $this->translate('Enlace de video no válido') ?>', 'warning');
                            }
                        }
                    }
                },
                limpiarPopUp() {

                    if (this.modoCarousel) {
                        this.listCarousel = [];

                    }

                    document.getElementById('mod-body').innerHTML = '';




                },
                sweetAlert(mensaje, icon) {
                    Swal.fire({
                        icon: icon,
                        text: mensaje,
                    });
                    setTimeout(() => {
                        document.location.reload();
                    }, 1800);

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

        let lazyObserver = null;

        function initLazyLoading() {
            if (lazyObserver) {
                lazyObserver.disconnect();
            }

            const lazyImages = document.querySelectorAll('#modalFiles img[data-src]');
            if (lazyImages.length === 0) return;

            lazyObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        requestAnimationFrame(() => {
                            img.src = img.dataset.src;
                            img.removeAttribute('data-src');
                        });
                        observer.unobserve(img);
                    }
                });
            }, {
                root: document.querySelector('#modalFiles .modal-body'),
                rootMargin: '150px',
                threshold: 0.01
            });

            lazyImages.forEach(img => lazyObserver.observe(img));
        }
    </script>
</body>

</html>