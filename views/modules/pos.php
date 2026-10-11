<div class="row g-3">
    <div class="col-12 col-lg-7">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold mb-0">Catálogo de Stock</h6>
            </div>
            <div class="card-body p-2" style="max-height: 520px; overflow-y: auto;">
                <div class="row g-2" id="posProductGrid"></div>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-5">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold mb-0">Orden Actual</h6>
            </div>
            <div class="card-body p-3">
                <div class="table-responsive" style="max-height: 250px; overflow-y: auto;">
                    <table class="table table-sm align-middle">
                        <tbody id="posCartTableBody">
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">Carrito vacío.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="border-top pt-3 mt-2">
                    <div class="d-flex justify-content-between fs-5 fw-bold mb-3">
                        <span>Total:</span><span class="text-primary" id="posTotalAmount">Gs. 0</span>
                    </div>
                    <button class="btn btn-primary w-100 py-2 fw-semibold" onclick="processPOSSale()">Facturar (VentaController)</button>
                </div>
            </div>
        </div>
    </div>
</div>