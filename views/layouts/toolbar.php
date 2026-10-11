<div class="toolbar bg-white border-bottom px-3 px-md-4 py-2 d-flex flex-wrap align-items-center justify-content-between gap-2">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0 py-1 small">
            <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none text-muted"><i class="fa-solid fa-house"></i> Inicio</a></li>
            <li class="breadcrumb-item active text-capitalize fw-semibold text-primary"><?php echo $title; ?></li>
        </ol>
    </nav>
    <div class="d-flex align-items-center gap-2">
        <button class="btn btn-sm btn-outline-primary" onclick="syncJavaBackend()"><i class="fa-solid fa-rotate me-1"></i> Sincronizar</button>
        <a href="index.php?view=pos" class="btn btn-sm btn-primary px-3"><i class="fa-solid fa-plus me-1"></i> Nueva Venta</a>
    </div>
</div>