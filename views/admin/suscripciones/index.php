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
        <div class="tab-titulo pb-2" style="text-align:start;">
                        <?= $this->translate('SUSCRIPCIONES') ?>
                    </div>
        <div class="d-flex align-items-center justify-content-between">

            <div class="d-flex align-items-center  gap-2">
                <!--  <div>
                    <input type="search" class="form-control" placeholder="<//?= $this->translate('Buscar correo o nombre') ?>" v-model="searchTerm" style="width: 200px;">
                </div>
                     -->
                <!-- Filtro de asunto -->
                <select class="form-select" v-model="filtroAsunto" style="width: 170px;">
                    <option value="">Todos los asuntos</option>
                    <option v-for="asunto in asuntosUnicos" :key="asunto" :value="asunto">{{ asunto || 'Sin asunto' }}</option>
                </select>

                <!-- Filtro de nivel -->
                <select class="form-select" v-model="filtroNivel" style="width: 180px;">
                    <option value="">Todos los niveles</option>
                    <option v-for="nivel in nivelesUnicos" :key="nivel" :value="nivel">{{ nivel || 'Sin nivel' }}</option>
                </select>

                <!-- Filtro de grado -->
                <select class="form-select" v-model="filtroGrado" style="width: 180px;">
                    <option value="">Todos los grados</option>
                    <option v-for="grado in gradosUnicos" :key="grado" :value="grado">{{ grado || 'Sin grado' }}</option>
                </select>

                <!-- Filtros de fecha -->
                <label for="fechaDesde" class="text-nowrap"><?= $this->translate('Desde:') ?></label>
                <input type="date" id="fechaDesde" class="form-control" v-model="fechaDesde" style="width: 150px;">

                <label for="fechaHasta" class="text-nowrap"><?= $this->translate('Hasta:') ?></label>
                <input type="date" id="fechaHasta" class="form-control" v-model="fechaHasta" style="width: 150px;">

                <!-- Botón limpiar filtros -->
                <button v-if="searchTerm || fechaDesde || fechaHasta || filtroAsunto || filtroNivel || filtroGrado" type="button" class="btn btn-outline-secondary btn-sm" @click="limpiarFiltros()" title="Limpiar filtros">
                    <i class="fas fa-times"></i> Limpiar
                </button>

                <!-- Botones de exportación -->
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-success text-white" @click="exportar('xlsx')" title="Exportar a Excel">
                        <i class="fas fa-file-excel"></i> Excel
                    </button>
                    <button type="button" class="btn btn-info text-white" @click="exportar('csv')" title="Exportar a CSV">
                        <i class="fas fa-file-csv"></i> CSV
                    </button>
                    <button type="button" class="btn btn-danger text-white" @click="exportarPDF()" title="Exportar a PDF">
                        <i class="fas fa-file-pdf"></i> PDF
                    </button>
                </div>
            </div>
        </div>
        <hr>

        <div class="d-flex align-items-center mb-3">
            <div>
                <span class="fw-bold"><?= $this->translate('Total') ?>:</span> {{filteredSuscripciones.length}}
            </div>
            <div v-if="selectedSuscripciones.length > 0" class="ms-3">
                <button class="btn btn-danger btn-sm" @click="eliminarSeleccionados">
                    <i class="far fa-trash-alt"></i> <?= $this->translate('Eliminar seleccionados') ?> ({{selectedSuscripciones.length}})
                </button>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width:32px; text-align:center;">
                            <input type="checkbox" v-model="allSelected" @change="toggleAll">
                        </th>
                        <th style="font-size: 13px; width: 60px;"><?= $this->translate('ITEM') ?></th>
                        <th style="font-size: 13px;"><?= $this->translate('NOMBRES') ?></th>
                        <th style="font-size: 13px;"><?= $this->translate('APELLIDOS') ?></th>
                        <th style="font-size: 13px;"><?= $this->translate('EMAIL') ?></th>
                        <th style="font-size: 13px;"><?= $this->translate('NIVEL') ?></th>
                        <th style="font-size: 13px;"><?= $this->translate('GRADO') ?></th>
                        <th style="font-size: 13px;"><?= $this->translate('ASUNTO') ?></th>
                        <th style="font-size: 13px; width: 170px;"><?= $this->translate('FECHA') ?></th>
                        <th class="text-center" style="font-size: 13px; width: 120px;"><?= $this->translate('OPCIONES') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, index) in paginatedSuscripciones" :key="item.idsuscripcion">
                        <td style="text-align:center;">
                            <input type="checkbox" v-model="selectedSuscripciones" :value="item.idsuscripcion">
                        </td>
                        <td><i class="fas fa-mail-bulk"></i></td>
                        <td>{{item.nombres || '-'}}</td>
                        <td>{{item.apellidos || '-'}}</td>
                        <td>{{item.correo || item.email || '-'}}</td>
                        <td>{{item.nivel || '-'}}</td>
                        <td>{{item.grado || '-'}}</td>
                        <td>{{item.asunto || '-'}}</td>
                        <td>{{item.fecha_suscripcion}}</td>
                        <td class="text-center">
                            <button v-if="item.consulta" class="btn btn-outline-info btn-sm me-1" title="<?= $this->translate('Ver consulta') ?>" @click="verConsulta(item)">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-outline-danger btn-sm" title="<?= $this->translate('Eliminar') ?>" @click="eliminarSuscripcion(item.idsuscripcion)">
                                <i class="far fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
                    <tr v-show="filteredSuscripciones.length == 0">
                        <td colspan="10" class="text-center"><?= $this->translate('No se encontraron resultados') ?></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        <div v-if="filteredSuscripciones.length > perPage" class="d-flex justify-content-between align-items-center mt-3">
            <div>
                <?= $this->translate('Mostrando') ?> {{(currentPage - 1) * perPage + 1}} - {{Math.min(currentPage * perPage, filteredSuscripciones.length)}} <?= $this->translate('de') ?> {{filteredSuscripciones.length}}
            </div>
            <nav>
                <ul class="pagination mb-0">
                    <li class="page-item" :class="{disabled: currentPage === 1}">
                        <a class="page-link" href="#" @click.prevent="currentPage = 1">&laquo;</a>
                    </li>
                    <li class="page-item" :class="{disabled: currentPage === 1}">
                        <a class="page-link" href="#" @click.prevent="currentPage--">&lsaquo;</a>
                    </li>
                    <li class="page-item" v-for="page in visiblePages" :key="page" :class="{active: page === currentPage}">
                        <a class="page-link" href="#" @click.prevent="currentPage = page">{{page}}</a>
                    </li>
                    <li class="page-item" :class="{disabled: currentPage === totalPages}">
                        <a class="page-link" href="#" @click.prevent="currentPage++">&rsaquo;</a>
                    </li>
                    <li class="page-item" :class="{disabled: currentPage === totalPages}">
                        <a class="page-link" href="#" @click.prevent="currentPage = totalPages">&raquo;</a>
                    </li>
                </ul>
            </nav>
            <div>
                <select class="form-select form-select-sm" v-model.number="perPage" style="width: auto;">
                    <option :value="10">10</option>
                    <option :value="25">25</option>
                    <option :value="50">50</option>
                    <option :value="100">100</option>
                </select>
            </div>
        </div>
    </section>
    <script>
        new Vue({
            el: '#app',
            data: () => {
                return {
                    suscripciones: <?= json_encode($this->listSuscripciones) ?>,
                    searchTerm: '',
                    fechaDesde: '',
                    fechaHasta: '',
                    filtroAsunto: '',
                    filtroNivel: '',
                    filtroGrado: '',
                    selectedSuscripciones: [],
                    allSelected: false,
                    currentPage: 1,
                    perPage: 25
                }
            },
            computed: {
                filteredSuscripciones() {
                    let filtered = this.suscripciones;

                    if (this.searchTerm) {
                        const search = this.searchTerm.toLowerCase();
                        filtered = filtered.filter(item =>
                            (item.nombres && item.nombres.toLowerCase().includes(search)) ||
                            (item.apellidos && item.apellidos.toLowerCase().includes(search)) ||
                            (item.nombre_completo && item.nombre_completo.toLowerCase().includes(search)) ||
                            (item.correo && item.correo.toLowerCase().includes(search)) ||
                            (item.email && item.email.toLowerCase().includes(search))
                        );
                    }

                    if (this.filtroAsunto) {
                        filtered = filtered.filter(item => item.asunto === this.filtroAsunto);
                    }

                    if (this.filtroNivel) {
                        filtered = filtered.filter(item => item.nivel === this.filtroNivel);
                    }

                    if (this.filtroGrado) {
                        filtered = filtered.filter(item => item.grado === this.filtroGrado);
                    }

                    if (this.fechaDesde || this.fechaHasta) {
                        filtered = filtered.filter(item => {
                            const fechaItem = item.fecha_suscripcion.split(' ')[0];

                            if (this.fechaDesde && this.fechaHasta) {
                                return fechaItem >= this.fechaDesde && fechaItem <= this.fechaHasta;
                            } else if (this.fechaDesde) {
                                return fechaItem >= this.fechaDesde;
                            } else if (this.fechaHasta) {
                                return fechaItem <= this.fechaHasta;
                            }
                            return true;
                        });
                    }

                    return filtered;
                },
                totalPages() {
                    return Math.ceil(this.filteredSuscripciones.length / this.perPage);
                },
                paginatedSuscripciones() {
                    const start = (this.currentPage - 1) * this.perPage;
                    const end = start + this.perPage;
                    return this.filteredSuscripciones.slice(start, end);
                },
                visiblePages() {
                    const pages = [];
                    const total = this.totalPages;
                    const current = this.currentPage;
                    const delta = 2;

                    for (let i = Math.max(2, current - delta); i <= Math.min(total - 1, current + delta); i++) {
                        pages.push(i);
                    }

                    if (current - delta > 2) {
                        pages.unshift('...');
                    }
                    if (current + delta < total - 1) {
                        pages.push('...');
                    }

                    pages.unshift(1);
                    if (total > 1) pages.push(total);

                    return pages.filter((v, i, a) => a.indexOf(v) === i);
                },
                // Obtener valores únicos de asuntos
                asuntosUnicos() {
                    const asuntos = [...new Set(this.suscripciones.map(item => item.asunto).filter(Boolean))];
                    return asuntos.sort();
                },
                // Obtener valores únicos de niveles
                nivelesUnicos() {
                    const niveles = [...new Set(this.suscripciones.map(item => item.nivel).filter(Boolean))];
                    return niveles.sort();
                },
                // Obtener valores únicos de grados
                gradosUnicos() {
                    const grados = [...new Set(this.suscripciones.map(item => item.grado).filter(Boolean))];
                    return grados.sort();
                }
            },
            watch: {
                selectedSuscripciones(val) {
                    this.allSelected = val.length === this.paginatedSuscripciones.length && val.length > 0;
                },
                filteredSuscripciones() {
                    this.currentPage = 1;
                    this.selectedSuscripciones = [];
                    this.allSelected = false;
                },
                perPage() {
                    this.currentPage = 1;
                }
            },
            methods: {
                toggleAll() {
                    if (this.allSelected) {
                        this.selectedSuscripciones = this.paginatedSuscripciones.map(s => s.idsuscripcion);
                    } else {
                        this.selectedSuscripciones = [];
                    }
                },
                eliminarSuscripcion(id) {
                    Swal.fire({
                        icon: 'warning',
                        title: '<?= $this->translate('¿Estás seguro?') ?>',
                        text: '<?= $this->translate('Esta acción eliminará el registro de forma permanente.') ?>',
                        showCancelButton: true,
                        confirmButtonText: '<?= $this->translate('Sí, eliminar') ?>',
                        cancelButtonText: '<?= $this->translate('Cancelar') ?>',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const formData = new URLSearchParams();
                            formData.append('idsuscripcion', id);

                            fetch('/admin/suscripciones/eliminar', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/x-www-form-urlencoded',
                                    },
                                    body: formData,
                                })
                                .then(response => response.text())
                                .then(data => {
                                    if (data === 'OK') {
                                        this.suscripciones = this.suscripciones.filter(s => s.idsuscripcion != id);
                                        this.sweetAlert('<?= $this->translate('Registro eliminado correctamente') ?>', 'success');
                                    } else {
                                        this.sweetAlert('<?= $this->translate('No se pudo eliminar el registro') ?>', 'error');
                                    }
                                })
                                .catch(() => {
                                    this.sweetAlert('<?= $this->translate('Ocurrió un problema con la eliminación') ?>', 'error');
                                });
                        }
                    });
                },
                eliminarSeleccionados() {
                    if (this.selectedSuscripciones.length === 0) return;

                    Swal.fire({
                        icon: 'warning',
                        title: '<?= $this->translate('¿Estás seguro?') ?>',
                        text: `<?= $this->translate('Se eliminarán') ?> ${this.selectedSuscripciones.length} <?= $this->translate('registros de forma permanente') ?>`,
                        showCancelButton: true,
                        confirmButtonText: '<?= $this->translate('Sí, eliminar') ?>',
                        cancelButtonText: '<?= $this->translate('Cancelar') ?>',
                    }).then(async (result) => {
                        if (result.isConfirmed) {
                            let eliminados = 0;
                            for (let id of this.selectedSuscripciones) {
                                const formData = new URLSearchParams();
                                formData.append('idsuscripcion', id);
                                let res = await fetch('/admin/suscripciones/eliminar', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/x-www-form-urlencoded',
                                    },
                                    body: formData,
                                }).then(r => r.text());

                                if (res === 'OK') {
                                    eliminados++;
                                    this.suscripciones = this.suscripciones.filter(s => s.idsuscripcion != id);
                                }
                            }
                            this.selectedSuscripciones = [];
                            this.sweetAlert(`${eliminados} <?= $this->translate('registros eliminados correctamente') ?>`, 'success');
                        }
                    });
                },
                sweetAlert(mensaje, icon) {
                    Swal.fire({
                        icon: icon,
                        text: mensaje,
                    });
                },
                exportar(formato) {
                    // Obtener IDs de los registros filtrados
                    const ids = this.filteredSuscripciones.map(item => item.idsuscripcion);

                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '/admin/suscripciones/excel';

                    // Enviar IDs de registros filtrados
                    const inputIds = document.createElement('input');
                    inputIds.type = 'hidden';
                    inputIds.name = 'ids';
                    inputIds.value = ids.join(',');
                    form.appendChild(inputIds);

                    const inputFormato = document.createElement('input');
                    inputFormato.type = 'hidden';
                    inputFormato.name = 'formato';
                    inputFormato.value = formato;
                    form.appendChild(inputFormato);

                    document.body.appendChild(form);
                    form.submit();
                    document.body.removeChild(form);
                },
                exportarPDF() {
                    // Obtener IDs de los registros filtrados
                    const ids = this.filteredSuscripciones.map(item => item.idsuscripcion);

                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '/admin/suscripciones/pdf';
                    form.target = '_blank'; // Abrir en nueva pestaña

                    // Enviar IDs de registros filtrados
                    const inputIds = document.createElement('input');
                    inputIds.type = 'hidden';
                    inputIds.name = 'ids';
                    inputIds.value = ids.join(',');
                    form.appendChild(inputIds);

                    document.body.appendChild(form);
                    form.submit();
                    document.body.removeChild(form);
                },
                limpiarFiltros() {
                    this.searchTerm = '';
                    this.fechaDesde = '';
                    this.fechaHasta = '';
                    this.filtroAsunto = '';
                    this.filtroNivel = '';
                    this.filtroGrado = '';
                },
                verConsulta(item) {
                    Swal.fire({
                        title: 'Consulta de ' + (item.nombres || '') + ' ' + (item.apellidos || ''),
                        html: `
                            <div class="text-start">
                                <p><strong>Email:</strong> ${item.correo || item.email || '-'}</p>
                                <p><strong>Nivel:</strong> ${item.nivel || '-'}</p>
                                <p><strong>Grado:</strong> ${item.grado || '-'}</p>
                                <p><strong>Asunto:</strong> ${item.asunto || '-'}</p>
                                <hr>
                                <p><strong>Consulta:</strong></p>
                                <p style="white-space: pre-wrap;">${item.consulta || 'Sin consulta'}</p>
                            </div>
                        `,
                        width: '600px',
                        confirmButtonText: 'Cerrar'
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