# FERSAL - Estructura Frontend Web (PHP + Bootstrap 5 + JS)

Estructura modular diseñada para el sistema de gestión comercial **FERSAL**, lista para consumir los microservicios REST del backend hecho en Java (Spring Boot).

## 📁 Arquitectura del Proyecto

```text
fersal-web/
├── index.php                      <- Punto de entrada principal
├── views/
│   ├── layouts/
│   │   ├── plantilla.php          <- Layout Maestro: concentra dependencias CSS/JS, meta tags y estructura
│   │   ├── cabezote.php           <- Barra superior (Header / Navbar), buscador global, notificaciones, perfil
│   │   ├── menu.php               <- Sidebar lateral con navegación por módulos y estado del backend
│   │   ├── toolbar.php            <- Barra de herramientas contextal (Breadcrumbs, filtros, exportar, nuevo registro)
│   │   └── footer.php             <- Pie de página con copyright, badges de seguridad y estado
│   └── modules/
│       └── dashboard.php          <- Vista inicial con KPIs, gráficos y tablas de transacciones
├── assets/
│   ├── css/
│   │   └── fersal-custom.css      <- Estilos corporativos, variables CSS, efectos pulse y sidebar responsive
│   ├── js/
│   │   ├── api-client.js          <- Cliente HTTP REST (Fetch API) preparado para Spring Boot (GET/POST/PUT/DELETE + JWT)
│   │   └── fersal-main.js         <- Lógica interactiva (sidebar toggle, gráficos Chart.js, SweetAlert2)
│   └── img/                       <- Directorio para logotipos e isotipos
└── README.md
```

## 🔌 Conexión con el Backend en Java (Spring Boot)

1. **Configuración del Endpoint:**
   En `assets/js/api-client.js`:
   ```javascript
   baseUrl: 'http://localhost:8080/api/v1' // Ajusta según el puerto o dominio de tu servidor Java
   ```
2. **CORS en Java:**
   Asegúrate de permitir las peticiones desde el frontend en tus controladores o configuración de Spring Boot:
   ```java
   @CrossOrigin(origins = "*") // O el host donde corre PHP (ej. http://localhost:8000)
   ```
3. **Consumo desde PHP o JavaScript:**
   - **Frontend (SPA / Reactivo):** Utiliza `FersalApi.get('/productos')` o `FersalApi.post('/ventas', data)`.
   - **Backend PHP (Server-Side):** Puedes usar `file_get_contents()` o cURL en controladores PHP si requieres renderizado del lado del servidor.

## 🚀 Cómo ejecutar
Simplemente coloca la carpeta en un servidor Apache/Nginx (XAMPP, Laragon, Docker) o ejecuta con el servidor embebido de PHP:
```bash
php -S localhost:8000
```
Y abre en tu navegador: `http://localhost:8000`