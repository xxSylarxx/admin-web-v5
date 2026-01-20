<aside class="sidebar active">
    <ul class="nav_list">
        <li>
            <a href="/admin/empresa" class="<?php echo $this->view_name == 'empresa' ? 'active' : '' ?>">
                <i class="fas fa-server"></i>
                <span class="links_name">
                    <?= $this->translate('Empresa') ?>
                </span>
            </a>
        </li>
        <li>
            <a href="/admin/banner" class="<?php echo $this->view_name == 'banner' ? 'active' : '' ?>">
                <i class="fa fa-object-ungroup"></i>
                <span class="links_name">
                    Banner
                </span>
            </a>
        </li>
        <li>
            <a href="/admin/publicacion" class="<?php echo $this->view_name == 'publicacion' ? 'active' : '' ?>">
                <i class="far fa-newspaper"></i>
                <span class="links_name">
                    <?= $this->translate('Publicaciones') ?>
                </span>
            </a>
        </li>
        <li>
            <a href="/admin/portadas" class="<?php echo $this->view_name == 'portadas' ? 'active' : '' ?>">
                <i class="fas fa-image"></i>
                <span class="links_name">
                    <?= $this->translate('Portadas') ?>
                </span>
            </a>
        </li>
        <li>
            <a href="/admin/admision" class="<?php echo $this->view_name == 'admision' ? 'active' : '' ?>">
                <i class="fas fa-user-graduate"></i>
                <span class="links_name">
                    <?= $this->translate('Admisión') ?>
                </span>
            </a>
        </li>
        <li>
            <a href="/admin/suscripciones" class="<?php echo $this->view_name == 'suscripciones' ? 'active' : '' ?>">
                <i class="fas fa-envelope"></i>
                <span class="links_name">
                    <?= $this->translate('Suscripciones') ?>
                </span>
            </a>
        </li>
        <li>
            <a href="/admin/galerias" class="<?php echo $this->view_name == 'galerias' ? 'active' : '' ?>">
                <i class="far fa-images"></i>
                <span class="links_name">
                    <?= $this->translate('Galerías') ?>
                </span>
            </a>
        </li>
        <li>
            <a href="/admin/archivos" class="<?php echo $this->view_name == 'archivos' ? 'active' : '' ?>">
                <i class="far fa-folder-open"></i>
                <span class="links_name">
                    <?= $this->translate('Archivos') ?>
                </span>
            </a>
        </li>
        <li>
            <a href="/admin/modal" class="<?php echo $this->view_name == 'modal' ? 'active' : '' ?>">
                <i class="far fa-window-maximize"></i>
                <span class="links_name">
                    Pop-up
                </span>
            </a>
        </li>
        <li>
            <a href="/admin/feed" class="<?php echo $this->view_name == 'feed' ? 'active' : '' ?>">
                <i class="fab fa-facebook"></i>
                <span class="links_name">
                    Facebook Posts
                </span>
            </a>
        </li>
    </ul>
</aside>

<script>
    const btnToggle = document.querySelector(".toggle");
    const sidebar = document.querySelector(".sidebar");
    btnToggle.onclick = function() {
        sidebar.classList.toggle("active");
    };
</script>