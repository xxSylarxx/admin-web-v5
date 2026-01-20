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
    <!-- <script src="https://cdn.tiny.cloud/1/4jir7ejemp31jvj04zn828qhjaqwe3bm9ekj7c14bs2k9sgc/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script> -->
    <!-- <script src="https://cdn.tiny.cloud/1/geeflj0hdxizy8u2pbnupzeow61l4yctse06a1k4qtqbirmh/tinymce/5/tinymce.min.js"></script> -->
    <script src="https://cdn.tiny.cloud/1/4jir7ejemp31jvj04zn828qhjaqwe3bm9ekj7c14bs2k9sgc/tinymce/5/tinymce.min.js" referrerpolicy="origin" crossorigin="anonymous"></script>
</head>

<body>

    <script src="<?= PATH_PUBLIC ?>/js/bootstrap.min.js"></script>
    <script async src="<?= PATH_PUBLIC ?>/js/sweetalert2.min.js"></script>

    <?php include_once PATH_ROOT . '/views/admin/header.php'; ?>
    <?php include_once PATH_ROOT . '/views/admin/menu.php'; ?>

    <!-- ESTILOS -->
    <style>
        #txtcuerpo {
            display: none;
        }

        #imgPortada {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }

        #titulo {
            font-size: 16px;
            border: none;
            border-bottom: 1px solid rgb(126, 126, 126);
            border-radius: 0px;
            font-weight: bold;
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
            border: 1px solid rgb(150, 150, 150);
            white-space: nowrap;
            padding: .6em .9em;
            border-radius: 3px;
        }

        #modalFiles div.file-item:hover {
            color: var(--color3);
            border: 1px solid var(--color3);
            cursor: pointer;
        }

        #modalFiles div.file-item a {
            color: rgb(25, 25, 25);
        }

        #modalFiles div.file-item:hover a {
            color: var(--color3);
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
    </style>

    <!-- CUERPO -->
    <section class="content" id="app">

        <div id="preloader">
            <div class="loading">
                <div class="circle"></div>
            </div>
        </div>

        <form id="formPub" action="/pub/preview" method="post" target="_blank" onsubmit="vistaPrevia(event)" autocomplete="off" onkeypress="return event.keyCode != 13;">
            <div class="d-flex align-items-center">
                <div class="tab-titulo">
                    <?= $this->translate('EDITOR') ?>
                </div>
                <div class="ms-auto d-flex align-items-center">
                    <button class="btn btn-info text-white" type="button" data-bs-toggle="modal" data-bs-target="#modalFiles"><i class="fas fa-search"></i></i>&nbsp; <?= $this->translate('Buscar archivos') ?></button>
                    <button class="btn btn-danger text-white mx-3" type="submit"><i class="far fa-eye"></i>&nbsp; <?= $this->translate('Vista previa') ?></button>
                    <button class="btn btn-success text-white" type="button" onclick="guardarPub('<?= $this->dataPub['action'] ?>')"><i class="fas fa-save"></i>&nbsp; <?= $this->translate('Guardar publicación') ?></button>
                </div>
            </div>
            <hr>
            <div class="d-flex pt-2 pb-4">
                <div style="width: 285px;">
                    <div class="card bg-light shadow-sm">
                        <div class="card-header">
                            <span class="fw-bold" style="font-size: 13px;"><i class="fas fa-bars"></i>&nbsp; <?= $this->translate('DETALLES') ?></span>
                        </div>
                        <div class="card-body">
                            <span><?= $this->translate('Categoría') ?> :</span>
                            <?php if (PUB_SUB_CATEG) { ?>
                                <select class="form-select mt-1 mb-3" name="idcatg">
                                    <?php foreach ($this->listCategorias as $key => $categ) : ?>
                                        <optgroup label="<?= $categ['nombre'] ?>">
                                            <?php foreach ($categ['subs'] as $key => $sub) : ?>
                                                <option value="<?= $sub['idcatg'] ?>" <?= $this->dataPub['idcatg'] == $key ? 'selected' : '' ?>><?= $sub['nombre'] ?></option>
                                            <?php endforeach; ?>
                                        </optgroup>
                                    <?php endforeach; ?>
                                </select>
                            <?php } else { ?>
                                <select class="form-select mt-1 mb-3" name="idcatg">
                                    <?php foreach ($this->listCategorias as $key => $categ) :
                                        if ($categ['estado'] == 'I') {
                                            continue;
                                        }
                                    ?>
                                        <option value="<?= $key ?>" <?= $this->dataPub['idcatg'] == $key ? 'selected' : '' ?>><?= $categ['nombre'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            <?php } ?>
                            <span><?= $this->translate('Fecha de publicación') ?> :</span>
                            <input type="datetime-local" class="form-control mt-1 mb-3" name="fecpub" value="<?= \Admin\Core\Funciones::parseDateTime($this->dataPub['fecpub']) ?>">
                            <span><?= $this->translate('Detalle') ?> :</span>
                            <textarea class="form-control mt-1 mb-3" rows="1" name="detalle" id="detalle" maxlength="170" placeholder="Opcional"><?= $this->dataPub['detalle'] ?></textarea>
                            <span><?= $this->translate('Imágen de portada') ?> :</span>
                            <input type="text" class="form-control mt-1 mb-2" name="portada" id="portada" value="<?= $this->dataPub['portada'] ?>" oninput="changePortada(this.value)" placeholder="<?= $this->translate('Link de imagen') ?>">
                            <img class="mt-2" src="<?= $this->dataPub['portada'] ?>" onerror="this.src = `https://placehold.co/320x220`" id="imgPortada">
                            <!-- hidden -->
                            <textarea name="cuerpo" id="txtcuerpo"></textarea>
                            <input type="hidden" name="idpub" value="<?= $this->dataPub['idpub'] ?>">
                        </div>
                    </div>
                </div>
                <div class="ps-4" style="width: calc(100% - 285px);">
                    <input type="text" class="form-control mb-3 text-uppercase" id="titulo" name="titulo" value="<?= $this->dataPub['titulo'] ?>" placeholder="<?= $this->translate('Titulo de publicación') ?>" required>
                    <textarea id="editor"><?php echo $this->dataPub['cuerpo'] ?></textarea>
                </div>
            </div>
        </form>

        <div class="modal fade" id="modalFiles" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Seleccionar archivos</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="w-100 pt-3 px-3">
                        <div class="d-flex align-items-center">
                            <div class="input-group me-3" style="width: 16%;">
                                <span class="input-group-text bg-white"><i class="far fa-folder-open"></i></span>
                                <select class="form-select" onchange="cambiarFiles(this.value)">
                                    <option value="I"><?= $this->translate('Imágenes') ?></option>
                                    <option value="V"><?= $this->translate('Videos') ?></option>
                                    <option value="D"><?= $this->translate('Documentos') ?></option>
                                </select>
                            </div>
                            <div class="ms-auto"><?= $this->translate('Mostrando') ?> <span id="cantFiles"></span> <?= strtolower($this->translate('de')) ?> <span id="totalFiles">0</span></div>
                        </div>
                        <hr>
                    </div>
                    <div class="modal-body pt-0">
                        <div class="row px-2 pb-1" id="row-files"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        const modalFiles = new bootstrap.Modal(document.getElementById('modalFiles'));
        const detalle = document.querySelector("#detalle");
        detalle.addEventListener('input', textAreaResize, false);
        detalle.style.height = `${detalle.scrollHeight}px`;
        let cantFiles = document.getElementById('cantFiles');
        let totalFiles = document.getElementById('totalFiles');
        let listFiles = [];

        // run tinymce
        tinymce.init({
            selector: '#editor',
            height: 600,
            menubar: true,
            language: 'es',
            encoding: 'UTF-8',
            plugins: [
                'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                'insertdatetime', 'media', 'table', 'help', 'wordcount'
            ],
            toolbar: 'undo redo | blocks fontsize | bold italic forecolor backcolor | ' +
                'alignleft aligncenter alignright alignjustify | ' +
                'bullist numlist outdent indent | table image link | removeformat code | help',
            content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; font-size: 15px; line-height: 1.6; padding: 10px; }',

            // Configuración de tablas
            table_toolbar: 'tableprops tabledelete | tableinsertrowbefore tableinsertrowafter tabledeleterow | tableinsertcolbefore tableinsertcolafter tabledeletecol',
            table_default_attributes: {
                border: '1'
            },
            table_default_styles: {
                'border-collapse': 'collapse',
                'width': '100%'
            },
            table_class_list: [{
                    title: 'Ninguna',
                    value: ''
                },
                {
                    title: 'Tabla Bootstrap',
                    value: 'table'
                },
                {
                    title: 'Tabla Rayada',
                    value: 'table table-striped'
                },
                {
                    title: 'Tabla Bordeada',
                    value: 'table table-bordered'
                },
            ],
            object_resizing: true,
            fix_list_elements: true,
            media_dimensions: true,
            forced_root_block: 'div',
            paste_as_text: true,
            paste_remove_styles: true,
            paste_remove_styles_if_webkit: true,
            default_link_target: "_blank",
        });

        const vistaPrevia = (e) => {
            e.preventDefault();
            let cuerpo = tinyMCE.get('editor').getContent();
            document.getElementById('txtcuerpo').value = cuerpo;
            e.target.submit();
        }

        const sweetAlert = (mensaje, icon) => {
            Swal.fire({
                icon: icon,
                text: mensaje,
                allowOutsideClick: false
            }).then((result) => {
                if (result.isConfirmed) {
                    if (icon === 'success') {
                        location.href = '/admin/publicacion/all';
                    }
                }
            });;
        }

        const cambiarFiles = (value) => {
            if (value == 'I') {
                listFiles = [];
                listFilesJson('img/galeria/', value);
            } else if (value == 'V') {
                listFiles = [];
                listFilesJson('video/', value);
            } else if (value == 'D') {
                listFiles = [];
                listFilesJson('files/', value);
            }
        }

        const changePortada = (value) => {
            if (value.substring(0, 19) == 'https://img.youtube') {
                document.getElementById("imgPortada").src = value;
            } else {
                let videoId = value.match(/(?:https?:\/{2})?(?:w{3}\.)?youtu(?:be)?\.(?:com|be)(?:\/watch\?v=|\/)([^\s&]+)/);
                if (videoId != null) {
                    let thumb = `https://img.youtube.com/vi/${videoId[1]}/hqdefault.jpg`;
                    document.getElementById("portada").value = thumb;
                    document.getElementById("imgPortada").src = thumb;
                } else {
                    document.getElementById('imgPortada').setAttribute('src', value);
                }
            }
        }

        const listFilesJson = (path, type) => {
            const data = new FormData();
            const total = listFiles.length;
            data.append('path', path);
            const ruta = type == 'I' ? '/admin/archivos/listar/' + total : '/admin/archivos/listar';
            fetch(ruta, {
                method: 'POST',
                body: data
            }).then(function(res) {
                return res.text();
            }).then(function(res) {
                try {
                    const result = JSON.parse(res);
                    if (type == 'I') {
                        if (result.files.length > 0) {
                            listFiles = listFiles.concat(result.files);
                            cantFiles.innerText = listFiles.length;
                            totalFiles.innerText = result.total;
                        } else {
                            sweetAlert(`<?= $this->translate('No hay más archivos para mostrar') ?>`, 'warning');
                        }
                    } else {
                        cantFiles.innerText = result.length;
                        totalFiles.innerText = result.length;
                        listFiles = result;
                    }
                    listFilesHTML(type);
                } catch (error) {
                    sweetAlert(res, 'error');
                }
            });
        }

        const guardarPub = (action) => {
            if (document.getElementById('titulo').value == '') {
                sweetAlert('<?= $this->translate('Publicación registrada') ?>', 'warning');
                return;
            }
            const cuerpo = tinyMCE.get('editor').getContent();
            document.getElementById('txtcuerpo').value = cuerpo;
            const data = new FormData(document.getElementById('formPub'));
            fetch(`/admin/publicacion/${action}`, {
                method: 'POST',
                body: data
            }).then(function(res) {
                return res.text();
            }).then(function(res) {
                if (res.trim() == 'OK') {
                    sweetAlert('<?= $this->dataPub['action'] == 'guardar' ? $this->translate('Publicación registrada') : $this->translate('Publicación actualizada') ?>', 'success');
                } else {
                    sweetAlert(res, 'error')
                }
            });
        }

        /* function listFilesHTML(type) {
            let html = ``;
            if (type == 'I') {
                listFiles.forEach((file, index) => {
                    html += `<div class="col-sm-2" style="padding: 2px;"><div class="file-item-img">
                    <a href="javascript:void(0)" class="copy-link-btn" onclick="copiarEnlace('${file.path}');" title="Copiar enlace">
                        <i class="fas fa-copy"></i>
                    </a>
                    <img src="${file.path}" title="${file.name}" onclick="agregarItem('${file.path}', '${type}')"></div></div>`;
                });
                html += `<div class="col-sm-2" style="padding: 2px;">
                    <div class="file-item-img end text-center" onclick="listFilesJson('img/galeria/', '${type}')">
                    <div class="d-flex flex-column align-items-center justify-content-center h-100">
                    <span class="fs-2"><i class="far fa-arrow-alt-circle-right"></i></span><span>Buscar más</span></div></div></div>`;
            } else {
                listFiles.forEach((file, index) => {
                    html += `<div class="col-sm-3" style="padding: 6px;">
                        <div class="file-item" onclick="agregarItem('${file.path}', '${file.type}')">
                            <i class="${file.icon} fs-3"></i>
                            <div class="file-item-detalle" title="${file.name}">
                                <a href="${file.path}" onclick="return false;">${file.name}</a>
                                <div style="font-size: 13px;">${file.size}</div>
                            </div>
                        </div>
                    </div>`;
                });
            }
            document.getElementById('row-files').innerHTML = html;
        } */
        function listFilesHTML(type) {
            let html = ``;
            if (type == 'I') {
                listFiles.forEach((file, index) => {
                    html += `<div class="col-sm-2" style="padding: 2px;">
                <div class="file-item-img">
                    <a href="javascript:void(0)" class="copy-link-btn" onclick="copiarEnlace('${file.path}', event);" title="Copiar enlace">
                        <i class="fas fa-copy"></i>
                    </a>
                    <img src="${file.path}" title="${file.name}" onclick="agregarItem('${file.path}', 'I')">
                </div>
            </div>`;
                });
                html += `<div class="col-sm-2" style="padding: 2px;">
            <div class="file-item-img end text-center" onclick="listFilesJson('img/galeria/', '${type}')">
                <div class="d-flex flex-column align-items-center justify-content-center h-100">
                    <span class="fs-2"><i class="far fa-arrow-alt-circle-right"></i></span>
                    <span>Buscar más</span>
                </div>
            </div>
        </div>`;
            } else {
                listFiles.forEach((file, index) => {
                    html += `<div class="col-sm-3" style="padding: 6px;">
                <div class="file-item" onclick="agregarItem('${file.path}', '${file.type}')">
                    <i class="${file.icon} fs-3"></i>
                    <div class="file-item-detalle" title="${file.name}">
                        <a href="${file.path}" onclick="return false;">${file.name}</a>
                        <div style="font-size: 13px;">${file.size}</div>
                    </div>
                </div>
            </div>`;
                });
            }
            document.getElementById('row-files').innerHTML = html;
        }

        function copiarEnlace(path, event) {
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
            let aux = document.createElement("input");
            aux.setAttribute("value", link);
            document.body.append(aux);
            aux.select();
            document.execCommand("copy");
            aux.remove();
            Swal.fire({
                icon: 'success',
                title: "<?= $this->translate('Enlace copiado al portapapeles'); ?>",
                toast: true,
                position: 'top-end',
                timer: 1500,
                showConfirmButton: false
            });
        }

        function mostrarError(link) {
            Swal.fire({
                icon: 'warning',
                title: "<?= $this->translate('No se pudo copiar automáticamente'); ?>",
                html: `<?= $this->translate('Por favor, copia manualmente este enlace:'); ?><br>
               <input type="text" value="${link}" id="enlaceManual" class="form-control mt-2" readonly>
               <button class="btn btn-primary mt-2" onclick="copiarManual()"><?= $this->translate('Copiar'); ?></button>`,
                showConfirmButton: false,
                showCloseButton: true
            });
        }

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

        function agregarItem(url, tipo) {
            let html = tinyMCE.get('editor').getContent();
            if (tipo == 'I') {
                html += `<div><img src="${url}" width="85%"></div>`;
            } else if (tipo == 'mp4') {
                html += `<div><video src="${url}" width="100%" height="420" controls></video></div>`;
            } else if (tipo == 'pdf') {
                html += `<div><iframe src="${url}" width="100%" height="720" frameborder="0"></iframe></div>`;
            } else {
                html += `<div><a href="${url}" target="_blank">${url}</a></div>`;
            }
            tinyMCE.get('editor').setContent(html);
            modalFiles.hide();
        }



        function textAreaResize() {
            this.style.height = 'auto';
            this.style.height = this.scrollHeight + 'px';
        }

        listFilesJson('img/galeria/', 'I');

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