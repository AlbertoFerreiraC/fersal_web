<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - FERSAL</title>

    <!-- Fuentes y CSS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background: linear-gradient(180deg, #03142F 0%, #020817 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 1.5rem;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 1.5rem;
            backdrop-filter: blur(16px);
            max-width: 440px;
            width: 100%;
            padding: 2.75rem 2rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.6);
        }

        .brand-icon {
            width: 90px;
            height: 90px;
            background: radial-gradient(circle, rgba(37, 128, 255, 0.25) 0%, rgba(3, 20, 47, 0) 70%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            color: #D6B56C;
        }

        .form-control {
            background-color: rgba(255, 255, 255, 0.06) !important;
            border: 1px solid rgba(255, 255, 255, 0.18) !important;
            color: #ffffff !important;
            border-radius: 0.85rem;
            padding: 0.75rem 1rem;
        }

        .form-control:focus {
            border-color: #1769FF !important;
            box-shadow: 0 0 0 0.25rem rgba(23, 105, 255, 0.25) !important;
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.4);
        }

        .btn-fersal {
            background-color: #1769FF;
            border: none;
            color: #ffffff;
            font-weight: 700;
            letter-spacing: 1px;
            border-radius: 0.85rem;
            padding: 0.85rem;
            transition: all 0.2s ease;
        }

        .btn-fersal:hover {
            background-color: #0f52cc;
            color: #ffffff;
            transform: translateY(-2px);
        }
    </style>
</head>

<body>

    <div class="login-card text-center">
        <div class="brand-icon">
            <i class="fa-solid fa-building-columns fs-1"></i>
        </div>
        <h2 class="text-white fw-bold tracking-wider mb-1" style="letter-spacing: 4px;">FERSAL</h2>
        <p class="small text-white-50 mb-4" style="letter-spacing: 2px;">GESTIÓN INTELIGENTE</p>

        <h4 class="text-white fw-bold mb-2">Iniciar sesión</h4>
        <p class="small text-white-50 mb-4">Accedé a tu sistema de gestión comercial</p>

        <form id="formLogin" onsubmit="ejecutarLogin(event)">
            <div class="mb-3 text-start">
                <label class="form-label small text-white-50 fw-semibold">Email</label>
                <div class="input-group">
                    <span class="input-group-text bg-transparent border-0 text-white-50 ps-3">
                        <i class="fa-regular fa-envelope"></i>
                    </span>
                    <input type="email" class="form-control" id="loginEmail" placeholder="usuario@fersal.com" required>
                </div>
            </div>

            <div class="mb-3 text-start">
                <label class="form-label small text-white-50 fw-semibold">Contraseña</label>
                <div class="input-group">
                    <span class="input-group-text bg-transparent border-0 text-white-50 ps-3">
                        <i class="fa-solid fa-lock"></i>
                    </span>
                    <input type="password" class="form-control" id="loginPassword" placeholder="••••••••" required>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check text-start">
                    <input class="form-check-input" type="checkbox" id="checkRemember" checked>
                    <label class="form-check-label small text-white-50" for="checkRemember">
                        Recordarme
                    </label>
                </div>
            </div>

            <button type="submit" class="btn btn-fersal w-100 mb-3" id="btnSubmit">
                <span id="btnText">INGRESAR</span>
                <span id="btnSpinner" class="spinner-border spinner-border-sm d-none" role="status"></span>
            </button>
        </form>

        <small class="text-white-50 d-block mt-3" style="font-size: 0.75rem; letter-spacing: 1px;">
            FERSAL APP & WEB &bull; Tu negocio, bajo control.
        </small>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="assets/js/api-service.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Si ya existe sesión activa, ingresar directamente
            if (FersalApi.hasSession()) {
                window.location.href = 'index.php?view=dashboard';
            }
            // Cargar email recordado si existe
            const savedEmail = localStorage.getItem('fersal_email');
            if (savedEmail) {
                document.getElementById('loginEmail').value = savedEmail;
            }
        });

        async function ejecutarLogin(e) {
            e.preventDefault();
            const btn = document.getElementById('btnSubmit');
            const txt = document.getElementById('btnText');
            const spinner = document.getElementById('btnSpinner');

            const email = document.getElementById('loginEmail').value.trim();
            const password = document.getElementById('loginPassword').value;
            const remember = document.getElementById('checkRemember').checked;

            btn.disabled = true;
            txt.classList.add('d-none');
            spinner.classList.remove('d-none');

            try {
                const response = await FersalApi.login(email, password, remember);

                Swal.fire({
                    icon: 'success',
                    title: `¡Hola, ${response.name || 'Bienvenido'}!`,
                    text: `Sesión iniciada en ${response.empresaNombre || 'FERSAL'}`,
                    timer: 1400,
                    showConfirmButton: false
                }).then(() => {
                    window.location.href = 'index.php?view=dashboard';
                });

            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'No se pudo iniciar sesión',
                    text: error.message || 'Verifica tu correo y contraseña.'
                });
            } finally {
                btn.disabled = false;
                txt.classList.remove('d-none');
                spinner.classList.add('d-none');
            }
        }
    </script>
</body>

</html>