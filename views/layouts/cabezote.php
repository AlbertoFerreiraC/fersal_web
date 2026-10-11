<header class="navbar navbar-expand bg-white sticky-top border-bottom shadow-xs px-3 py-2 main-header">
    <div class="d-flex align-items-center">
        <button id="sidebarToggleBtn" class="btn btn-outline-primary btn-sm me-3 border-0 shadow-none">
            <i class="fa-solid fa-bars-staggered fs-5"></i>
        </button>
        <span class="badge bg-primary-subtle text-primary fw-bold px-2 py-1 rounded-pill">JWT Bearer</span>
        <span class="fw-semibold text-secondary ms-2 d-none d-sm-inline" id="headerEmpresa">FERSAL</span>
    </div>

    <div class="navbar-nav ms-auto align-items-center gap-2">
        <div class="d-flex align-items-center gap-2 me-2 px-2 py-1 rounded-pill bg-success-subtle border border-success-subtle text-success small">
            <span class="status-dot bg-success"></span>
            <span class="fw-medium d-none d-md-inline">Sesión Activa</span>
        </div>

        <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                <div class="user-avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" id="headerAvatar">
                    U
                </div>
                <div class="d-none d-md-block text-start lh-sm">
                    <span class="fw-semibold text-dark d-block" id="headerNombre">Usuario</span>
                    <small class="text-muted" id="headerEmail">user@fersal.com</small>
                </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2 py-2">
                <li><a class="dropdown-item" href="index.php?view=stock"><i class="fa-solid fa-boxes-stacked me-2 text-primary"></i> Stock</a></li>
                <li><a class="dropdown-item" href="index.php?view=config"><i class="fa-solid fa-sliders me-2 text-primary"></i> Ajustes API</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li>
                    <a class="dropdown-item text-danger" href="javascript:void(0)" onclick="FersalApi.logout()">
                        <i class="fa-solid fa-arrow-right-from-bracket me-2"></i> Cerrar Sesión
                    </a>
                </li>
            </ul>
        </div>
    </div>
</header>