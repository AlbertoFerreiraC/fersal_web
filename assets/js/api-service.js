/**
 * FERSAL - Cliente HTTP REST
 * Replica fielmente el funcionamiento de ApiClient y TokenStorage de Flutter
 */
const FersalApi = {
    // URL base de Spring Boot (coincide con ApiConstants.baseUrl de Flutter o localhost)
    baseUrl: localStorage.getItem('fersal_api_url') || 'http://100.116.228.4:8080',
    prefix: localStorage.getItem('fersal_api_prefix') || '/api',

    // ==========================================
    // TOKEN STORAGE (Replica SharedPreferences)
    // ==========================================
    getToken() {
        return localStorage.getItem('fersal_token');
    },

    getUserData() {
        return {
            id: localStorage.getItem('fersal_usuario_id'),
            email: localStorage.getItem('fersal_email'),
            name: localStorage.getItem('fersal_name'),
            empresaId: localStorage.getItem('fersal_empresa_id'),
            empresaNombre: localStorage.getItem('fersal_empresa_nombre'),
            sucursalId: localStorage.getItem('fersal_sucursal_id'),
            sucursalNombre: localStorage.getItem('fersal_sucursal_nombre')
        };
    },

    hasSession() {
        const token = this.getToken();
        return token !== null && token.length > 0;
    },

    saveSession(data, remember = true) {
        localStorage.setItem('fersal_token', data.token);
        localStorage.setItem('fersal_email', data.email);
        localStorage.setItem('fersal_name', data.name);
        localStorage.setItem('fersal_empresa_id', data.empresaId || '');
        localStorage.setItem('fersal_empresa_nombre', data.empresaNombre || '');
        if (data.usuarioId) localStorage.setItem('fersal_usuario_id', data.usuarioId);
        if (data.sucursalId) localStorage.setItem('fersal_sucursal_id', data.sucursalId);
        if (data.sucursalNombre) localStorage.setItem('fersal_sucursal_nombre', data.sucursalNombre);
        localStorage.setItem('fersal_remember', remember ? 'true' : 'false');
    },

    logout(redirect = true) {
        localStorage.removeItem('fersal_token');
        if (localStorage.getItem('fersal_remember') !== 'true') {
            localStorage.removeItem('fersal_email');
        }
        if (redirect) {
            window.location.href = 'login.php';
        }
    },

    // ==========================================
    // INTERCEPTOR DE PETICIONES (Replica Dio)
    // ==========================================
    getFullUrl(endpoint) {
        return `${this.baseUrl}${this.prefix}${endpoint}`;
    },

    async request(endpoint, options = {}) {
        const url = this.getFullUrl(endpoint);
        const token = this.getToken();

        const headers = {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            ...(options.headers || {})
        };

        // Inyectar Authorization: Bearer si existe token
        if (token && token.length > 0) {
            headers['Authorization'] = `Bearer ${token}`;
        }

        try {
            const response = await fetch(url, { ...options, headers });

            // Interceptor onError: Si es 401 o 403, cerrar sesión y redirigir
            if (response.status === 401 || response.status === 403) {
                console.warn('[FERSAL Auth] Sesión expirada o no autorizada (401/403).');
                this.logout(true);
                throw new Error('Tu sesión ha expirado o no estás autorizado.');
            }

            if (!response.ok) {
                const errorBody = await response.json().catch(() => ({}));
                throw new Error(errorBody.message || `Error del servidor HTTP ${response.status}`);
            }

            return await response.json();
        } catch (error) {
            console.error(`[FERSAL API Request Error] en ${url}:`, error);
            throw error;
        }
    },

    // ==========================================
    // ENDPOINTS DE AUTENTICACIÓN & NEGOCIO
    // ==========================================

    // POST /api/auth/login
    async login(email, password, remember = true) {
        const url = this.getFullUrl('/auth/login');
        const response = await fetch(url, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
            body: JSON.stringify({ email: email, password: password })
        });

        if (!response.ok) {
            const errorData = await response.json().catch(() => ({}));
            throw new Error(errorData.message || 'Credenciales inválidas');
        }

        const data = await response.json(); // LoginResponse
        this.saveSession(data, remember);
        return data;
    },

    // GET /api/stock (StockRepository)
    getStock() {
        return this.request('/stock');
    },

    // GET y POST /api/ventas (VentaController)
    getVentas() {
        return this.request('/ventas');
    },

    createVenta(ventaData) {
        return this.request('/ventas', {
            method: 'POST',
            body: JSON.stringify(ventaData)
        });
    },

    // POST /api/ventas/anular (AnularVentaRequest)
    anularVenta(ventaId, motivo) {
        return this.request('/ventas/anular', {
            method: 'POST',
            body: JSON.stringify({ ventaId: ventaId, motivo: motivo })
        });
    },

    // Clientes
    getClientes() {
        return this.request('/clientes');
    },

    // Comprobación de estado
    async checkPing() {
        try {
            const res = await this.getStock();
            return !!res;
        } catch (e) {
            return false;
        }
    }
};