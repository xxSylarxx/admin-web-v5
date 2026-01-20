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
    <script async src="<?= PATH_PUBLIC ?>/js/sweetalert2.min.js"></script>
    <script src="https://cdn.tiny.cloud/1/4jir7ejemp31jvj04zn828qhjaqwe3bm9ekj7c14bs2k9sgc/tinymce/5/tinymce.min.js" referrerpolicy="origin" crossorigin="anonymous"></script>

    <?php include_once PATH_ROOT . '/views/admin/header.php'; ?>
    <?php include_once PATH_ROOT . '/views/admin/menu.php'; ?>

    <style>
        .section-card {
            border: none;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            border-radius: 8px;
        }
        .section-card .card-header {
            background: var(--color3);
            color: white;
            font-weight: bold;
            border-radius: 8px 8px 0 0;
        }

        #modalFiles .file-item-img {
            border-radius: 1px;
            overflow: hidden;
        }

        #modalFiles .file-item-img:hover {
            cursor: pointer;
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

    <section class="content">
        <div class="d-flex align-items-center mb-3">
            <div class="tab-titulo">
                <?= $this->translate('LANDING ADMISIÓN') ?>
            </div>
            <div class="ms-auto">
                <button class="btn btn-info text-white" type="button" data-bs-toggle="modal" data-bs-target="#modalFiles">
                    <i class="fas fa-search"></i> Buscar archivos
                </button>
                <a href="/admin/portadas" class="btn btn-outline-primary ms-2">
                    <i class="fas fa-image"></i> Gestionar Portada
                </a>
                <button type="submit" form="formGeneral" class="btn btn-danger btn-lg ms-2">
                    <i class="far fa-eye"></i> Vista Previa
                </button>
                <button type="button" class="btn btn-success btn-lg ms-2" onclick="guardarContenido()">
                    <i class="fas fa-save"></i> Guardar Contenido
                </button>
            </div>
        </div>
        <hr>

        <div class="alert alert-info pb-2">
            <i class="fas fa-info-circle"></i>
            <strong>Nota:</strong> Edita el contenido de la landing de Admisión.
            La portada se gestiona desde <a href="/admin/portadas">Portadas</a>.
        </div>

        <!-- Editor de Contenido -->
        <div class="card section-card">
            <div class="card-header">
                <i class="fas fa-edit"></i> Contenido de Admisión
            </div>
            <div class="card-body">
                <form id="formGeneral" action="/admision" method="post" target="_blank">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Título:</label>
                        <input type="text" class="form-control" id="titulo" name="titulo" value="<?= $this->dataAdmision['titulo'] ?? '' ?>" placeholder="Ej: PROCESO DE ADMISIÓN 2026">
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Contenido:</label>
                        <textarea class="form-control tinymce-editor" id="editor" name="cuerpo"><?= $this->dataAdmision['cuerpo'] ?? '' ?></textarea>
                        <small class="text-muted">Puedes agregar texto, tablas, imágenes, listas y más usando el editor.</small>
                    </div>
                    
                    <!-- hidden para vista previa -->
                    <textarea name="cuerpo_preview" id="txtcuerpo" style="display: none;"></textarea>
                    <input type="hidden" name="titulo_preview" id="txttitulo">
                    <input type="hidden" name="preview" value="1">
                </form>
            </div>
        </div>

    </section>

    <!-- Modal Archivos -->
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
                                <option value="I">Imágenes</option>
                                <option value="V">Videos</option>
                                <option value="D">Documentos</option>
                            </select>
                        </div>
                        <div class="ms-auto">Mostrando <span id="cantFiles"></span> de <span id="totalFiles">0</span></div>
                    </div>
                    <hr>
                </div>
                <div class="modal-body pt-0">
                    <div class="row px-2 pb-1" id="row-files"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const modalFiles = new bootstrap.Modal(document.getElementById('modalFiles'));
        let cantFiles = document.getElementById('cantFiles');
        let totalFiles = document.getElementById('totalFiles');
        let listFiles = [];

        // Inicializar TinyMCE
        tinymce.init({
            selector: '#editor',
            height: 600,
            menubar: true,
            language: 'es',
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
            table_class_list: [
                {title: 'Ninguna', value: ''},
                {title: 'Tabla Bootstrap', value: 'table'},
                {title: 'Tabla Rayada', value: 'table table-striped'},
                {title: 'Tabla Bordeada', value: 'table table-bordered'},
            ]
        });

        // Vista previa
        const vistaPrevia = (e) => {
            e.preventDefault();
            
            // Sincronizar TinyMCE
            tinymce.triggerSave();
            
            // Obtener valores
            let cuerpo = tinymce.get('editor').getContent();
            let titulo = document.getElementById('titulo').value;
            
            // Asignar a campos hidden
            document.getElementById('txtcuerpo').value = cuerpo;
            document.getElementById('txttitulo').value = titulo;
            
            // Submit del formulario
            document.getElementById('formGeneral').submit();
        }

        // Guardar contenido
        const guardarContenido = () => {
            tinymce.triggerSave();
            const formData = new FormData(document.getElementById('formGeneral'));
            
            // Remover campos de preview
            formData.delete('cuerpo_preview');
            formData.delete('titulo_preview');
            formData.delete('preview');
            
            fetch('/admin/admision/actualizar', {
                method: 'POST',
                body: formData
            })
            .then(res => res.text())
            .then(res => {
                if (res.trim() === 'OK') {
                    Swal.fire({
                        icon: 'success',
                        text: 'Contenido actualizado correctamente',
                        timer: 2000
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        text: 'Error al actualizar'
                    });
                }
            });
        }

        // Evento submit para vista previa
        document.getElementById('formGeneral').addEventListener('submit', vistaPrevia);

        // Funciones de archivos
        const cambiarFiles = (value) => {
            listFiles = [];
            if (value == 'I') {
                listFilesJson('img/galeria/', value);
            } else if (value == 'V') {
                listFilesJson('video/', value);
            } else if (value == 'D') {
                listFilesJson('files/', value);
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
                            Swal.fire({
                                icon: 'warning',
                                text: 'No hay más archivos para mostrar'
                            });
                        }
                    } else {
                        cantFiles.innerText = result.length;
                        totalFiles.innerText = result.length;
                        listFiles = result;
                    }
                    listFilesHTML(type);
                } catch (error) {
                    Swal.fire({
                        icon: 'error',
                        text: res
                    });
                }
            });
        }

        function listFilesHTML(type) {
            let html = ``;
            if (type == 'I') {
                listFiles.forEach((file, index) => {
                    html += `<div class="col-sm-2" style="padding: 2px;"><div class="file-item-img">
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
        }

        function agregarItem(url, tipo) {
            let html = tinymce.get('editor').getContent();
            if (tipo == 'I') {
                html += `<div><img src="${url}" width="85%"></div>`;
            } else if (tipo == 'mp4') {
                html += `<div><video src="${url}" width="100%" height="420" controls></video></div>`;
            } else if (tipo == 'pdf') {
                html += `<div><iframe src="${url}" width="100%" height="720" frameborder="0"></iframe></div>`;
            } else {
                html += `<div><a href="${url}" target="_blank">${url}</a></div>`;
            }
            tinymce.get('editor').setContent(html);
            modalFiles.hide();
        }

        // Cargar archivos iniciales
        listFilesJson('img/galeria/', 'I');
    </script>

</body>

</html>
