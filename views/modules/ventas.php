<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
        <h6 class="fw-bold mb-0">Ventas & Anulaciones (AnularVentaRequest)</h6>
        <button class="btn btn-sm btn-outline-primary" onclick="loadSalesList()"><i class="fa-solid fa-rotate me-1"></i> Recargar</button>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <tbody id="salesTableBody"></tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="anularVentaModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title fw-bold">Anular Venta</h5>
            </div>
            <div class="modal-body p-4">
                <input type="hidden" id="anularVentaId">
                <label class="form-label fw-bold small">Motivo</label>
                <textarea class="form-control" id="anularMotivo" rows="3" placeholder="Motivo de la anulación" required></textarea>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger btn-sm" onclick="confirmAnularVenta()">Confirmar Anulación</button>
            </div>
        </div>
    </div>
</div>