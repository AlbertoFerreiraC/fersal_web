<?php
$current_view = isset($_GET['view']) ? htmlspecialchars($_GET['view']) : 'dashboard';
$view_titles = [
    'dashboard'  => 'Dashboard General',
    'pos'        => 'Punto de Venta (POS)',
    'ventas'     => 'Historial de Ventas & Facturación',
    'stock'      => 'Control de Stock',
    'config'     => 'Configuración API Java'
];
$title = isset($view_titles[$current_view]) ? $view_titles[$current_view] : 'FERSAL';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?> - FERSAL</title>

    <!-- Guardia de Autenticación Front: Redirige a login si no existe token -->
    <script>
        if (!localStorage.getItem('fersal_token')) {
            window.location.href = 'login.php';
        }
    </script>

    <!-- Google Fonts & CDN -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="assets/css/fersal-style.css">
</head>

<body class="bg-light">
    <div class="wrapper d-flex">
        <!-- MENÚ / SIDEBAR -->
        <?php include_once __DIR__ . '/menu.php'; ?>

        <div id="content" class="w-100 min-vh-100 d-flex flex-column">
            <!-- CABEZOTE -->
            <?php include_once __DIR__ . '/cabezote.php'; ?>

            <!-- TOOLBAR -->
            <?php include_once __DIR__ . '/toolbar.php'; ?>

            <!-- VISTAS DINÁMICAS -->
            <main class="flex-grow-1 p-3 p-md-4">
                <div class="container-fluid">
                    <?php
                    $module = __DIR__ . '/../modules/' . $current_view . '.php';
                    if (file_exists($module)) {
                        include_once $module;
                    } else {
                        include_once __DIR__ . '/../modules/dashboard.php';
                    }
                    ?>
                </div>
            </main>

            <!-- FOOTER -->
            <?php include_once __DIR__ . '/footer.php'; ?>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="assets/js/api-service.js"></script>
    <script src="assets/js/fersal-app.js"></script>
</body>

</html>