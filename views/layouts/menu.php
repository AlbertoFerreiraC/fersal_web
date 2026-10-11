<nav id="sidebar" class="sidebar bg-white border-end shadow-sm">
    <div class="sidebar-header d-flex align-items-center px-4 py-3 border-bottom">
        <div class="logo-icon bg-gradient-primary text-white rounded-3 p-2 me-2 shadow-xs">
            <i class="fa-solid fa-layer-group fs-4"></i>
        </div>
        <div>
            <h5 class="mb-0 fw-bold tracking-tight text-primary">FERSAL</h5>
            <small class="text-muted fw-semibold">ERP Web</small>
        </div>
    </div>
    <div class="sidebar-content py-3">
        <ul class="nav flex-column px-2 gap-1">
            <li class="nav-header px-3 text-uppercase text-muted fw-bold small my-2">Principal</li>
            <li class="nav-item">
                <a href="index.php?view=dashboard" class="nav-link rounded-3 <?php echo ($current_view == 'dashboard') ? 'active' : ''; ?>">
                    <i class="fa-solid fa-chart-pie me-2"></i><span>Dashboard</span>
                </a>
            </li>
            <li class="nav-header px-3 text-uppercase text-muted fw-bold small my-2">Comercial</li>
            <li class="nav-item">
                <a href="index.php?view=pos" class="nav-link rounded-3 <?php echo ($current_view == 'pos') ? 'active' : ''; ?>">
                    <i class="fa-solid fa-cash-register me-2"></i><span>Punto de Venta (POS)</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="index.php?view=ventas" class="nav-link rounded-3 <?php echo ($current_view == 'ventas') ? 'active' : ''; ?>">
                    <i class="fa-solid fa-receipt me-2"></i><span>Ventas & Anular</span>
                </a>
            </li>
            <li class="nav-header px-3 text-uppercase text-muted fw-bold small my-2">Inventario</li>
            <li class="nav-item">
                <a href="index.php?view=stock" class="nav-link rounded-3 <?php echo ($current_view == 'stock') ? 'active' : ''; ?>">
                    <i class="fa-solid fa-boxes-stacked me-2"></i><span>StockRepository</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="index.php?view=config" class="nav-link rounded-3 <?php echo ($current_view == 'config') ? 'active' : ''; ?>">
                    <i class="fa-solid fa-gear me-2"></i><span>Ajustes Java API</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="sidebar-footer p-3 m-3 rounded-3 bg-light border text-center">
        <i class="fa-brands fa-java text-danger fs-3 mb-1"></i>
        <h6 class="mb-1 fw-bold small">Spring Boot</h6>
        <button class="btn btn-outline-primary btn-sm w-100 py-1" onclick="testBackendHealth()">Test Ping</button>
    </div>
</nav>