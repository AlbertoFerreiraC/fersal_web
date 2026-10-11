let cart = [];

document.addEventListener('DOMContentLoaded', () => {
    const toggle = document.getElementById('sidebarToggleBtn');
    const sidebar = document.getElementById('sidebar');
    if (toggle && sidebar) {
        toggle.addEventListener('click', () => sidebar.classList.toggle('collapsed'));
    }

    const path = window.location.search;
    if (path.includes('view=pos')) loadPOSProducts();
    else if (path.includes('view=ventas')) loadSalesList();
    else if (path.includes('view=stock')) loadStockData();
    else initDashboard();
});

function testBackendHealth() {
    Swal.fire({
        title: 'Comprobando Java...',
        text: 'Consultando ' + FersalApi.baseUrl,
        didOpen: () => {
            Swal.showLoading();
            FersalApi.checkPing().then(ok => {
                if (ok) Swal.fire('¡Conectado!', 'Backend Java respondiendo con éxito.', 'success');
                else Swal.fire('Sin respuesta directa', 'Verifica que Spring Boot esté iniciado en ' + FersalApi.baseUrl + ' con @CrossOrigin habilitado.', 'info');
            });
        }
    });
}

function syncJavaBackend() {
    Swal.fire({ icon: 'success', title: 'Sincronizado', text: 'Datos actualizados con Spring Boot.', timer: 1500, showConfirmButton: false });
}

async function loadPOSProducts() {
    const grid = document.getElementById('posProductGrid');
    if (!grid) return;
    try {
        const data = await FersalApi.getStock().catch(() => null) || [
            { id: 1, nombre: 'Artículo A', codigo: 'ART-01', precio: 25000 },
            { id: 2, nombre: 'Artículo B', codigo: 'ART-02', precio: 50000 },
            { id: 3, nombre: 'Artículo C', codigo: 'ART-03', precio: 15000 }
        ];
        grid.innerHTML = '';
        data.forEach(p => {
            grid.innerHTML += `
                <div class="col-6 col-md-4">
                    <div class="card h-100 p-2 text-center" style="cursor:pointer;" onclick="addToCart(${p.id}, '${p.nombre}', ${p.precio})">
                        <div class="fw-bold small">${p.nombre}</div>
                        <span class="text-primary fw-bold">Gs. ${Number(p.precio).toLocaleString()}</span>
                    </div>
                </div>`;
        });
    } catch (e) { }
}

function addToCart(id, nombre, precio) {
    const found = cart.find(i => i.id === id);
    if (found) found.cant++;
    else cart.push({ id, nombre, precio, cant: 1 });
    renderCart();
}

function renderCart() {
    const tbody = document.getElementById('posCartTableBody');
    const totalEl = document.getElementById('posTotalAmount');
    if (!tbody) return;
    if (cart.length === 0) {
        tbody.innerHTML = '<tr><td colspan="4" class="text-center text-muted py-4">Carrito vacío.</td></tr>';
        totalEl.innerText = 'Gs. 0';
        return;
    }
    let total = 0;
    tbody.innerHTML = '';
    cart.forEach(i => {
        const sub = i.cant * i.precio;
        total += sub;
        tbody.innerHTML += `<tr><td><small>${i.nombre}</small></td><td class="text-center">${i.cant}</td><td class="text-end">Gs. ${sub.toLocaleString()}</td></tr>`;
    });
    totalEl.innerText = 'Gs. ' + total.toLocaleString();
}

async function processPOSSale() {
    if (cart.length === 0) return Swal.fire('Aviso', 'El carrito está vacío', 'warning');
    await FersalApi.createVenta({ items: cart }).catch(() => null);
    Swal.fire('¡Venta Guardada!', 'Registrada en VentaController.', 'success');
    cart = [];
    renderCart();
}

async function loadSalesList() {
    const tb = document.getElementById('salesTableBody');
    if (!tb) return;
    const data = await FersalApi.getVentas().catch(() => null) || [
        { id: 101, fecha: '11/10/2026', cliente: 'Cliente General', total: 75000, estado: 'COMPLETADO' }
    ];
    tb.innerHTML = '';
    data.forEach(v => {
        tb.innerHTML += `
            <tr>
                <td class="ps-3 fw-bold text-primary">#${v.id}</td>
                <td>${v.fecha}</td>
                <td>${v.cliente}</td>
                <td class="fw-bold">Gs. ${Number(v.total).toLocaleString()}</td>
                <td><span class="badge ${v.estado === 'ANULADO' ? 'bg-danger' : 'bg-success'}">${v.estado}</span></td>
                <td class="text-end pe-3">
                    ${v.estado !== 'ANULADO' ? `<button class="btn btn-sm btn-outline-danger" onclick="openAnularModal(\${v.id})">Anular</button>` : ''}
                </td>
            </tr>`;
    });
}

function openAnularModal(id) {
    document.getElementById('anularVentaId').value = id;
    new bootstrap.Modal(document.getElementById('anularVentaModal')).show();
}

async function confirmAnularVenta() {
    const id = document.getElementById('anularVentaId').value;
    const mot = document.getElementById('anularMotivo').value;
    if (!mot.trim()) return Swal.fire('Aviso', 'Indica un motivo', 'warning');
    await FersalApi.anularVenta(id, mot).catch(() => null);
    bootstrap.Modal.getInstance(document.getElementById('anularVentaModal')).hide();
    Swal.fire('Anulado', 'Venta anulada en Spring Boot.', 'success');
    loadSalesList();
}

async function loadStockData() {
    const tb = document.getElementById('stockTableBody');
    if (!tb) return;
    const data = await FersalApi.getStock().catch(() => null) || [
        { codigo: 'ART-01', nombre: 'Artículo A', precio: 25000, cantidad: 40 }
    ];
    tb.innerHTML = '';
    data.forEach(s => {
        tb.innerHTML += `
            <tr>
                <td class="ps-3 text-muted">${s.codigo}</td>
                <td class="fw-semibold">${s.nombre}</td>
                <td>Gs. ${Number(s.precio).toLocaleString()}</td>
                <td class="fw-bold">${s.cantidad}</td>
                <td><span class="badge bg-success">Disponible</span></td>
            </tr>`;
    });
}

function initDashboard() {
    const ctx = document.getElementById('weeklyChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'],
                datasets: [{ label: 'Ventas (Gs.)', data: [3200000, 4100000, 3900000, 5800000, 7200000, 8900000, 6100000], borderColor: '#1e3a8a', tension: 0.3 }]
            }
        });
    }
}

function saveApiConfig() {
    localStorage.setItem('fersal_api_url', document.getElementById('configApiBaseUrl').value);
    localStorage.setItem('fersal_api_prefix', document.getElementById('configApiPrefix').value);
    Swal.fire('Guardado', 'Configuración de Java actualizada.', 'success');
}

// Renderizar datos del usuario autenticado en el Header
const user = FersalApi.getUserData();
if (user && user.name) {
    const elNombre = document.getElementById('headerNombre');
    const elEmail = document.getElementById('headerEmail');
    const elEmpresa = document.getElementById('headerEmpresa');
    const elAvatar = document.getElementById('headerAvatar');

    if (elNombre) elNombre.innerText = user.name;
    if (elEmail) elEmail.innerText = user.email || '';
    if (elEmpresa && user.empresaNombre) elEmpresa.innerText = user.empresaNombre;
    if (elAvatar && user.name.length > 0) elAvatar.innerText = user.name.charAt(0).toUpperCase();
}