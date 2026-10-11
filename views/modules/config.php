<div class="row justify-content-center">
    <div class="col-12 col-md-8">
        <div class="card border-0 shadow-sm p-4">
            <h6 class="fw-bold mb-3">Parámetros de Conexión Java</h6>
            <div class="mb-3">
                <label class="form-label small fw-bold">URL Servidor Spring Boot</label>
                <input type="text" class="form-control" id="configApiBaseUrl" value="http://localhost:8080">
            </div>
            <div class="mb-3">
                <label class="form-label small fw-bold">Prefijo de Endpoints</label>
                <input type="text" class="form-control" id="configApiPrefix" value="/api">
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-primary" onclick="saveApiConfig()">Guardar</button>
                <button class="btn btn-outline-secondary" onclick="testBackendHealth()">Probar Conexión</button>
            </div>
        </div>
    </div>
</div>