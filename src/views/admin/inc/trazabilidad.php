<div class="container mt-5">
    <h1 class="text-center">Validación de Agente Aduanal</h1>
    <p class="text-center">Escanea el código QR o introduce la patente para obtener los datos del agente.</p>

    <!-- Formulario para ingresar la patente manualmente -->
    <div class="card shadow-sm p-4">
        <form action="/admin/validar" method="POST">
            <div class="mb-3">
                <label for="patente" class="form-label">Patente</label>
                <input type="text" id="patente" name="patente" class="form-control" placeholder="Introduce la patente"
                    required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Validar</button>
        </form>
    </div>
</div>