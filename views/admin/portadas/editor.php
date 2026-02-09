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

    <script src="<?= PATH_PUBLIC ?>/js/jquery.min.js"></script>
    <script src="<?= PATH_PUBLIC ?>/js/bootstrap.min.js"></script>
    <script async src="<?= PATH_PUBLIC ?>/js/sweetalert2.min.js"></script>

    <?php include_once PATH_ROOT . '/views/admin/header.php'; ?>
    <?php include_once PATH_ROOT . '/views/admin/menu.php'; ?>

    <style>
        .imagen-preview {
            width: 100%;
            max-height: 300px;
            object-fit: cover;
            border-radius: 5px;
            margin-top: 10px;
            border: 1px solid #ddd;
        }

        #modalFiles .file-item {
            border: 1px solid rgb(222, 222, 222);
            border-radius: 5px;
            overflow: hidden;
            transition: all 0.18s ease-out;
            will-change: auto;
            contain: layout style paint;
        }

        #modalFiles .file-item:hover {
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            transform: translateY(-3px) translateZ(0);
        }

        #modalFiles .file-item:hover img {
            transform: scale3d(1.06, 1.06, 1);
        }

        #modalFiles .file-item img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 5px;
            transition: transform 0.18s ease-out;
            background: #f0f0f0;
            transform: translateZ(0);
            will-change: transform;
        }

        #modalFiles .file-item img[data-src] {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: loading 1.5s infinite;
        }

        @keyframes loading {
            0% {
                background-position: 200% 0;
            }

            100% {
                background-position: -200% 0;
            }
        }

        #modalFiles .file-item.selected {
            border: 3px solid var(--color3);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }

        #modalFiles .file-item-end {
            height: 150px;
            background-color: rgb(230, 230, 230);
            border-radius: 5px;
            transition: all 0.18s ease-out;
            cursor: pointer;
            transform: translateZ(0);
        }

        #modalFiles .file-item-end:hover {
            background-color: rgb(200, 200, 200);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            transform: translateY(-3px) translateZ(0);
        }

        /* Optimización de scroll performance */
        #modalFiles .modal-body {
            overflow-y: auto;
            overflow-x: hidden;
            -webkit-overflow-scrolling: touch;
            transform: translateZ(0);
            will-change: scroll-position;
        }

        #modalFiles .row {
            contain: layout style;
        }

        #modalFiles .col-sm-3 {
            contain: layout style paint;
        }
    </style>

    <section class="content">
        <div class="d-flex align-items-center mb-3">
            <div class="tab-titulo">
                <?= $this->dataPortada['idportada'] ? 'EDITAR PORTADA' : 'NUEVA PORTADA' ?>
            </div>
            <div class="ms-auto">
                <a href="/admin/portadas" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </div>
        </div>
        <hr>

        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <form id="formPortada">
                            <input type="hidden" name="idportada" value="<?= $this->dataPortada['idportada'] ?>">

                            <div class="row">
                                <div class="col-md-6 mb-3" hidden>
                                    <label class="form-label fw-bold">Identificador de Página <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="pagina"
                                        value="<?= $this->dataPortada['pagina'] ?>"
                                        placeholder="ej: nosotros, servicios, contacto" required>
                                    <!-- <small class="text-muted">Sin espacios, solo letras minúsculas. Debe coincidir con el archivo PHP</small> -->
                                </div>

                                <div class="col-md-6 mb-3" hidden>
                                    <label class="form-label fw-bold">Nombre Descriptivo <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="nombre"
                                        value="<?= $this->dataPortada['nombre'] ?>"
                                        placeholder="ej: Nosotros, Servicios" required>
                                    <!-- <small class="text-muted">Nombre que aparece en el admin</small> -->
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Título de la Portada</label>
                                <input type="text" class="form-control" name="titulo"
                                    value="<?= $this->dataPortada['titulo'] ?>"
                                    placeholder="ej: Nosotros, Nuestros Servicios">
                                <small class="text-muted">Título que se muestra en la portada</small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Subtítulo</label>
                                <textarea class="form-control" name="subtitulo" rows="2"
                                    placeholder="ej: Conoce más sobre nuestra institución"><?= $this->dataPortada['subtitulo'] ?></textarea>
                                <small class="text-muted">Descripción breve que aparece debajo del título</small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">URL de la Imagen <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="imagen" id="urlImagen"
                                        value="<?= $this->dataPortada['imagen'] ?>"
                                        placeholder="https://ejemplo.com/imagen.jpg o /public/img/portadas/imagen.jpg"
                                        onchange="actualizarPreview()" required>
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalFiles">
                                        <i class="fas fa-search"></i> Buscar
                                    </button>
                                </div>
                                <small class="text-muted">URL externa o ruta local del servidor</small>

                                <?php if (!empty($this->dataPortada['imagen'])) : ?>
                                    <img src="<?= $this->dataPortada['imagen'] ?>" alt="Preview" class="imagen-preview" id="imagePreview">
                                <?php else : ?>
                                    <img src="https://via.placeholder.com/800x300?text=Vista+Previa" alt="Preview" class="imagen-preview" id="imagePreview">
                                <?php endif; ?>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Estado</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="estado"
                                        id="estadoCheck" value="A"
                                        <?= $this->dataPortada['estado'] == 'A' ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="estadoCheck">
                                        Activo (visible en la web)
                                    </label>
                                </div>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save"></i> Guardar Portada
                                </button>
                                <a href="/admin/portadas" class="btn btn-secondary">
                                    Cancelar
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <i class="fas fa-info-circle"></i> Información
                    </div>
                    <div class="card-body">
                        <h6 class="fw-bold">Tamaño recomendado:</h6>
                        <p class="mb-3">1920x400 píxeles</p>

                        <h6 class="fw-bold">Formatos soportados:</h6>
                        <p class="mb-3">JPG, PNG, GIF, WEBP</p>

                        <!-- <h6 class="fw-bold">Identificador de página:</h6>
                        <p class="mb-3">Debe coincidir con el nombre del archivo PHP de tu landing. Por ejemplo, si tu landing se llama "nosotros.php", el identificador debe ser "nosotros".</p> -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal de Galería -->
        <div class="modal fade" id="modalFiles" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fas fa-images"></i> Seleccionar imagen de portada
                        </h5>
                        <div style="width:70%;display:flex;justify-content:flex-end;">
                            <a href="/admin/archivos?tab=portadas" class="btn btn-primary">
                                <i class="fas fa-upload"></i> Ir a subir imágenes
                            </a>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row px-2" id="row-files">
                        </div>
                    </div>
                    <div class="modal-footer d-flex align-items-center">
                        <a href="javascript:void(0)" onclick="insertarLink()">
                            <i class="fas fa-link"></i>&nbsp; Insertar imagen vía link externo
                        </a>
                        <span class="ms-auto">
                            Mostrando <span id="cantFiles">0</span> de <span id="totalFiles">0</span>
                        </span>
                    </div>
                </div>
            </div>
        </div>

    </section>

    <script>
        let listFiles = [];
        let cantFiles = document.getElementById('cantFiles');
        let totalFiles = document.getElementById('totalFiles');

        const seleccionarImagen = (url, element) => {
            // Actualizar input y preview
            document.getElementById('urlImagen').value = url;
            actualizarPreview();

            // Marcar imagen seleccionada
            document.querySelectorAll('.file-item').forEach(item => {
                item.classList.remove('selected');
            });
            element.classList.add('selected');


            setTimeout(() => {
                bootstrap.Modal.getInstance(document.getElementById('modalFiles')).hide();
            }, 300);
        }

        const insertarLink = () => {
            const url = prompt('Ingrese la URL de una imagen externa:', 'https://');
            if (url && url.length > 0 && url !== 'https://') {
                document.getElementById('urlImagen').value = url;
                actualizarPreview();
                bootstrap.Modal.getInstance(document.getElementById('modalFiles')).hide();
            } else if (url !== null) {
                Swal.fire({
                    icon: 'warning',
                    text: 'Debe ingresar una URL válida',
                });
            }
        }

        const actualizarPreview = () => {
            const url = document.getElementById('urlImagen').value;
            const preview = document.getElementById('imagePreview');
            if (url.trim()) {
                preview.src = url;
                preview.onerror = function() {
                    this.src = 'https://via.placeholder.com/800x300?text=Error+al+cargar+imagen';
                };
            } else {
                preview.src = 'https://via.placeholder.com/800x300?text=Vista+Previa';
            }
        }

        const listFilesJson = (path) => {
            const data = new FormData();
            const total = listFiles.length;
            data.append('path', path);
            const ruta = '/admin/archivos/listar/' + total;
            fetch(ruta, {
                    method: 'POST',
                    body: data
                }).then(res => res.text())
                .then(res => {
                    try {
                        const result = JSON.parse(res);
                        if (result.files && result.files.length > 0) {
                            listFiles = listFiles.concat(result.files);
                            cantFiles.innerText = listFiles.length;
                            totalFiles.innerText = result.total;
                            listFilesHTML();
                        } else {
                            Swal.fire({
                                icon: 'info',
                                text: 'No hay más archivos para mostrar',
                                timer: 2000
                            });
                        }
                    } catch (error) {
                        Swal.fire({
                            icon: 'error',
                            text: res || 'Error al cargar archivos'
                        });
                    }
                });
        }

        const listFilesHTML = () => {
            const container = document.getElementById('row-files');
            let html = '';
            let imageCount = 0;

            listFiles.forEach((file, index) => {
                if (file.type && ['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(file.type.toLowerCase())) {
                    // Lazy loading: solo las primeras 12 imágenes se cargan inmediatamente
                    const imgAttr = imageCount < 12 ?
                        `src="${file.path}"` :
                        `data-src="${file.path}" src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100' height='150'%3E%3C/svg%3E"`;

                    html += `<div class="col-sm-3 pb-2 p-2">
                        <div class="file-item" onclick="seleccionarImagen('${file.path}', this)">
                            <img ${imgAttr} alt="${file.name}" title="${file.name}" loading="lazy" class="lazy-img">
                        </div>
                    </div>`;
                    imageCount++;
                }
            });

            // Agregar botón "Buscar más"
            html += `<div class="col-sm-3 pb-2 p-2">
                <div class="file-item-end text-center d-flex flex-column align-items-center justify-content-center" 
                     onclick="listFilesJson('img/portadas/')">
                    <span class="fs-2"><i class="far fa-arrow-alt-circle-right"></i></span>
                    <span class="mt-2">Buscar más</span>
                </div>
            </div>`;

            // Usar requestAnimationFrame para optimizar rendering
            requestAnimationFrame(() => {
                container.innerHTML = html;
                requestAnimationFrame(() => initLazyLoading());
            });
        }

        // Intersection Observer para lazy loading optimizado
        let imageObserver = null;

        function initLazyLoading() {
            // Limpiar observer anterior si existe
            if (imageObserver) {
                imageObserver.disconnect();
            }

            const lazyImages = document.querySelectorAll('img[data-src]');

            // Si no hay imágenes pendientes, salir
            if (lazyImages.length === 0) {
                return;
            }

            if ('IntersectionObserver' in window) {
                imageObserver = new IntersectionObserver((entries, observer) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const img = entry.target;
                            // Cargar imagen
                            img.src = img.dataset.src;
                            img.removeAttribute('data-src');
                            observer.unobserve(img);

                            // Si ya no quedan imágenes por cargar, desconectar observer completamente
                            const remainingImages = document.querySelectorAll('img[data-src]');
                            if (remainingImages.length === 0) {
                                observer.disconnect();
                                imageObserver = null;
                            }
                        }
                    });
                }, {
                    root: document.querySelector('#modalFiles .modal-body'),
                    rootMargin: '150px',
                    threshold: 0.01
                });

                lazyImages.forEach(img => imageObserver.observe(img));
            } else {
                // Fallback para navegadores antiguos
                lazyImages.forEach(img => {
                    img.src = img.dataset.src;
                    img.removeAttribute('data-src');
                });
            }
        }

        // Cargar archivos iniciales al abrir modal
        document.getElementById('modalFiles').addEventListener('show.bs.modal', function() {
            if (listFiles.length === 0) {
                listFilesJson('img/portadas/');
            }
        });

        document.getElementById('formPortada').addEventListener('submit', async (e) => {
            e.preventDefault();

            const formData = new FormData(e.target);

            // Ajustar el estado
            const estadoCheck = document.getElementById('estadoCheck');
            formData.set('estado', estadoCheck.checked ? 'A' : 'I');

            const idportada = formData.get('idportada');
            const url = idportada ? '/admin/portadas/actualizar' : '/admin/portadas/guardar';

            try {
                const response = await fetch(url, {
                    method: 'POST',
                    body: formData
                });

                const result = await response.text();

                if (result.trim() === 'OK') {
                    Swal.fire({
                        icon: 'success',
                        text: idportada ? 'Portada actualizada correctamente' : 'Portada guardada correctamente',
                        timer: 2000
                    }).then(() => {
                        window.location.href = '/admin/portadas';
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        text: result
                    });
                }
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    text: 'Error al procesar la solicitud'
                });
            }
        });
    </script>

</body>

</html>