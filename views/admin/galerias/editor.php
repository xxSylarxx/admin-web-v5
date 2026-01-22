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
        #content-grid {
            columns: <?= $this->galeria['ncolum'] ?>;
            column-gap: 6px;
        }

        #content-grid div.options {
            z-index: 1;
            position: absolute;
            width: 100%;
            height: 100%;
            justify-content: center;
            align-items: center;
            display: flex;
            background: rgba(0, 0, 0, .6);
            opacity: 0;
            transition: opacity .3s ease-in-out;
            color: white;
        }

        div.options a {
            color: white;
            cursor: pointer;
            font-size: 1.8em;
        }

        #content-grid>div.item:hover div.options {
            opacity: 1;
        }

        #content-grid>div.item {
            -webkit-column-break-inside: avoid;
            page-break-inside: avoid;
            break-inside: avoid;
            margin-bottom: 6px;
            overflow: hidden;
            transition: all .5s ease;
            position: relative;
        }

        #content-grid img {
            object-fit: cover;
            border-radius: 3px;
            height: <?= $this->galeria['modo'] == 'A' ? 'auto' : '260px' ?>;
        }

        #modalFiles .file-item-img {
            border-radius: 1px;
            overflow: hidden;
            position: relative;
        }

        #modalFiles .file-item-img:hover {
            cursor: pointer;
        }

        #modalFiles .file-item-img .copy-link-btn {
            position: absolute;
            top: 5px;
            right: 5px;
            background: var(--color2);
            color: white;
            border: none;
            padding: 6px 10px;
            border-radius: 4px;
            cursor: pointer;
            opacity: 0;
            transition: opacity 0.2s;
            z-index: 10;
            font-size: 14px;
        }

        #modalFiles .file-item-img:hover .copy-link-btn {
            opacity: 1;
        }

        #modalFiles .file-item-img .copy-link-btn:hover {
            background: var(--color2);
            transform: scale(1.05);
        }


        #modalFiles .file-item-img.end {
            height: 120px;
            background-color: rgb(230, 230, 230);
        }

        #modalFiles .file-item-img:hover img {
            transform: scale(1.12);
        }

        #modalFiles .file-item-img img {
            width: 100%;
            height: 120px;
            object-fit: cover;
            border-radius: 1px;
            transition: transform .2s ease-in-out;
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

        #cantFiles {
            font-size: 15px;
        }

        #modalFiles img.selected {
            filter: grayscale(250%);
        }

        #imgPortada {
            width: 100%;
            max-height: 200px;
            object-fit: cover;
            border-radius: 5px;
            border: 1px solid #ddd;
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
                <?= $this->translate('CREAR GALERÍA') ?>
            </div>
            <div class="ms-auto">
                <button class="btn btn-danger text-white me-2" data-bs-toggle="modal" data-bs-target="#modalFiles"><i class="fas fa-search"></i> <?= $this->translate('Buscar en archivos') ?></button>
                <button class="btn btn-success text-white" @click="guardarGaleria()"><i class="fas fa-save"></i>&nbsp; <?= $this->translate('Guardar galería') ?></button>
            </div>
        </div>
        <hr>
        <div class="d-flex pt-2 pb-3">
            <div class="pe-4" style="width: 300px;">
                <div style="position: sticky; top: 6em;">
                    <div class="card bg-light shadow-sm">
                        <div class="card-header">
                            <span class="fw-bold" style="font-size: 13px;"><i class="fas fa-bars"></i>&nbsp; <?= $this->translate('OPCIONES') ?></span>
                        </div>
                        <form id="formDatos" class="card-body" onkeypress="return event.keyCode != 13;">
                            <span><?= $this->translate('Titulo de galería') ?>:</span>
                            <input type="text" class="form-control mb-3 mt-1" name="titulo" id="titulo" value="<?= $this->galeria['titulo'] ?>" autocomplete="off">

                            <span><?= $this->translate('Categoría') ?>:</span>
                            <select class="form-select mt-1 mb-3" name="idcatg">
                                <option value="">Sin categoría</option>
                                <?php foreach ($this->listCategorias as $key => $categ) :
                                    if ($categ['estado'] == 'I') {
                                        continue;
                                    }
                                ?>
                                    <option value="<?= $categ['idcatg'] ?>" <?= $this->galeria['idcatg'] == $categ['idcatg'] ? 'selected' : '' ?>><?= $categ['nombre'] ?></option>
                                <?php endforeach; ?>
                            </select>

                            <span><?= $this->translate('Imagen de la Portada') ?>:</span>
                            <input type="text" class="form-control mt-1 mb-2" name="portada" id="portada" value="<?= $this->galeria['portada'] ?>" @input="changePortada($event.target.value)" autocomplete="off" placeholder="URL de imagen de portada">
                            <img class="my-2" :src="portadaPreview" @error="portadaPreview = 'https://placehold.co/320x220'" id="imgPortada">
                            <span><?= $this->translate('Detalle') ?>:</span>
                            <textarea class="form-control mt-1 mb-3" rows="2" name="detalle" placeholder="Opcional"><?= $this->galeria['detalle'] ?></textarea>
                            <span><?= $this->translate('Modo de galería') ?>:</span>
                            <select class="form-select mt-1 mb-3" name="modo" @change="cambiarModo($event)">
                                <option value="A" <?= $this->galeria['modo'] == 'A' ? 'selected' : '' ?>>Collage</option>
                                <option value="B" <?= $this->galeria['modo'] == 'B' ? 'selected' : '' ?>>Cuadrícula</option>
                            </select>
                            <span><?= $this->translate('Nro. columnas') ?> (max 7):</span>
                            <input type="number" class="form-control mt-1" name="ncolum" @input="cambiarColumnas($event)" min="0" max="7" value="<?= $this->galeria['ncolum'] ?>">
                            <input type="hidden" name="idgaleria" value="<?= $this->galeria['idgaleria'] ?>">
                        </form>
                    </div>
                </div>
            </div>
            <div id="content-grid" style="width: calc(100% - 300px);">
                <div class="item" v-for="(item, index) in listGallery">
                    <div class="options">
                        <a title="Eliminar" @click="eliminarItem(index)"><i class="far fa-trash-alt"></i></a>
                    </div>
                    <img :src="item.portada" width="100%">
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
                            <div class="input-group me-3" style="width: 15%;">
                                <span class="input-group-text bg-white"><i class="far fa-folder-open"></i></span>
                                <select class="form-select" v-model="modoFiles">
                                    <option value="I"><?= $this->translate('Imágenes') ?></option>
                                    <option value="V"><?= $this->translate('Videos') ?></option>
                                </select>
                            </div>
                            <button v-show="modoFiles == 'I'" class="btn btn-info" @click="insertarxLink()"><i class="far fa-image"></i>&nbsp; <?= $this->translate('Insertar por link') ?></button>
                            <div class="ms-auto"><?= $this->translate('Mostrando') ?> {{listFiles.length}} <?= strtolower($this->translate('de')) ?> {{totalFiles}}</div>
                        </div>
                        <hr>
                    </div>
                    <div class="modal-body pt-0">
                        <div class="row px-2 pb-1" v-if="modoFiles == 'I'">
                            <div class="col-sm-2" v-for="(item, index) in listFiles" :key="index" style="padding: 2px;">
                                <div class="file-item-img">
                                    <a href="javascript:void(0)" class="copy-link-btn" @click.stop="copiarEnlace(item.path, $event)" title="Copiar enlace">
                                        <i class="fas fa-copy"></i>
                                    </a>
                                    <img :src="item.path" :id="'img' + item.id" :title="item.name" @click="agregarItem(item.path, 'I', item.id)">
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
                                <div class="file-item" @click="agregarItem(item.path, 'V')">
                                    <i class="fas fa-film fs-3"></i>
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
                    listGallery: JSON.parse(`<?= $this->galeria['cuerpo'] ?>`),
                    modoFiles: 'I',
                    totalFiles: 0,
                    portadaPreview: '<?= !empty($this->galeria['portada']) ? $this->galeria['portada'] : 'https://placehold.co/320x220' ?>',
                }
            },
            created() {
                this.listFilesJson('img/galeria/');
            },
            watch: {
                modoFiles: function(value) {
                    if (value == 'I') {
                        this.listFiles = [];
                        this.listFilesJson('img/galeria/');
                    } else if (value == 'V') {
                        this.listFiles = [];
                        this.listFilesJson('video/');
                    }
                }
            },
            methods: {
                agregarItem(path, tipo, cod) {
                    let portada = '';
                    if (tipo == 'V' || tipo == 'Y') {
                        portada = '<?= PATH_PUBLIC ?>/img/icons/admin_portada_video.png';
                    } else {
                        portada = path;
                    }
                    this.listGallery.push({
                        id: cod,
                        tipo: tipo,
                        content: path,
                        portada: portada
                    });
                    // agregar class 'selected' a la imagen
                    let element = document.getElementById('img' + cod);
                    element.classList.add('selected');
                    // -- end --
                },
                eliminarItem(index) {
                    if (!this.listGallery[index]) {
                        console.error("Índice inválido:", index);
                        return;
                    }

                    let id = this.listGallery[index].id;
                    let element = document.getElementById('img' + id);

                    if (element) {
                        element.classList.remove('selected'); // ✅ Solo si el elemento existe
                    } else {
                        console.warn("No se encontró el elemento con id:", 'img' + id);
                    }

                    this.listGallery.splice(index, 1);
                },
                cambiarModo(event) {
                    const modo = event.target.value;
                    const listItems = document.querySelectorAll("#content-grid img");
                    if (modo == 'A') {
                        listItems.forEach(element => {
                            element.style.height = 'auto';

                        });
                    } else if (modo == 'B') {
                        listItems.forEach(element => {
                            element.style.height = '260px';
                        });
                    }
                },
                cambiarColumnas(event) {
                    let valor = event.target.value.trim()
                    if (/^[1-9]\d*$|^$/.test(valor)) {
                        if (valor >= 1 && valor <= 7) {
                            document.getElementById('content-grid').style.columns = valor;
                        } else {
                            this.sweetAlert(`<?= $this->translate('El rango de columnas es de 1 a 7') ?>`, 'warning');
                            document.getElementById('content-grid').style.columns = '3';
                        }
                    } else {
                        this.sweetAlert(`<?= $this->translate('Ingrese solo números') ?>`, 'warning');
                        document.getElementById('content-grid').style.columns = '3';
                    }
                },
                guardarGaleria() {
                    vue = this;
                    if (document.getElementById('titulo').value.length == 0) {
                        vue.sweetAlert('<?= $this->translate("Ingrese el titulo de la galería") ?>', 'warning');
                        document.getElementById('titulo').focus();
                        return;
                    }
                    if (this.listGallery.length == 0) {
                        vue.sweetAlert('<?= $this->translate("No ha seleccionado ningún item en la galería") ?>', 'warning');
                        return;
                    }
                    const form = new FormData(document.getElementById('formDatos'));
                    form.append('cuerpo', JSON.stringify(vue.listGallery));
                    fetch('/admin/galerias/<?= $this->galeria['action'] ?>', {
                        method: 'POST',
                        body: form
                    }).then(function(res) {
                        return res.text();
                    }).then(function(res) {
                        if (res.trim() == 'OK') {
                            vue.sweetAlert('<?= $this->galeria['action'] == 'guardar' ? $this->translate('Galería registrada') : $this->translate('Galería actualizada') ?>', 'success');
                        } else {
                            vue.sweetAlert(res, 'error');
                        }
                    });
                },
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
                insertarxLink() {
                    if (this.modoFiles == 'I') {
                        const link = prompt(`<?= $this->translate('Ingrese la URL de la imagen') ?>`, '');
                        if (link.length > 0) {
                            this.agregarItem(link, 'I');
                        }
                    }
                },
                sweetAlert(mensaje, icon) {
                    Swal.fire({
                        icon: icon,
                        text: mensaje,
                        allowOutsideClick: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            if (icon === 'success') {
                                location.href = '/admin/galerias';
                            }
                        }
                    });
                },
                saludo(item) {
                    alert("la posicion de la imagen es " + item);
                },
                copiarEnlace(path, event) {
                    if (event) {
                        event.stopPropagation();
                        event.preventDefault();
                    }
                    let link = path;
                    if (!path.startsWith('http://') && !path.startsWith('https://')) {
                        if (!path.startsWith('/')) {
                            path = '/' + path;
                        }
                        link = location.origin + path;
                    }
                    // Buscar el modal
                    let modal = document.getElementById('modalFiles');
                    // Crear el input temporal dentro del modal
                    let aux = document.createElement("input");
                    aux.setAttribute("value", link);
                    modal.appendChild(aux);
                    aux.focus();
                    aux.select();
                    let copied = false;
                    try {
                        copied = document.execCommand("copy");
                    } catch (e) {
                        copied = false;
                    }
                    aux.remove();
                    if (copied) {
                        Swal.fire({
                            icon: 'success',
                            title: "<?= $this->translate('Enlace copiado al portapapeles'); ?>",
                            toast: true,
                            position: 'top-end',
                            timer: 1500,
                            showConfirmButton: false
                        });
                    } else {
                        this.mostrarError(link);
                    }
                },
                mostrarError(link) {
                    Swal.fire({
                        icon: 'warning',
                        title: "<?= $this->translate('No se pudo copiar automáticamente'); ?>",
                        html: `<?= $this->translate('Por favor, copia manualmente este enlace:'); ?><br>
                       <input type="text" value="${link}" id="enlaceManual" class="form-control mt-2" readonly>
                       <button class="btn btn-primary mt-2" onclick="copiarManual()"><?= $this->translate('Copiar'); ?></button>`,
                        showConfirmButton: false,
                        showCloseButton: true
                    });
                },
                changePortada(value) {
                    if (!value || value.trim() === '') {
                        this.portadaPreview = 'https://placehold.co/320x220?text=Vista+Previa';
                        return;
                    }
                    if (value.substring(0, 19) == 'https://img.youtube') {
                        this.portadaPreview = value;
                    } else {
                        let videoId = value.match(/(?:https?:\/{2})?(?:w{3}\.)?youtu(?:be)?\.(?:com|be)(?:\/watch\?v=|\/)([^\s&]+)/);
                        if (videoId != null) {
                            let thumb = `https://img.youtube.com/vi/${videoId[1]}/hqdefault.jpg`;
                            document.getElementById('portada').value = thumb;
                            this.portadaPreview = thumb;
                        } else {
                            this.portadaPreview = value;
                        }
                    }
                }
            }
        });

        function copiarManual() {
            const input = document.getElementById('enlaceManual');
            input.select();
            input.setSelectionRange(0, 99999);
            try {
                document.execCommand('copy');
                Swal.fire({
                    icon: 'success',
                    title: "<?= $this->translate('¡Copiado!'); ?>",
                    toast: true,
                    position: 'top-end',
                    timer: 1500,
                    showConfirmButton: false
                });
            } catch (err) {
                console.error('Error al copiar manualmente: ', err);
            }
        }

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