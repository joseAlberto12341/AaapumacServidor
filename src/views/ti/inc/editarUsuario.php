<?php
$usuario = $answer['data']['usuario'] ?? null;
$estados = $answer['data']['estados'] ?? [];
$error = $_GET['error'] ?? null;
?>
<link rel="stylesheet" href="/Aaapumac/src/views/assets/css/editarUsuario.css">

<div class="header">
    <a href="/Aaapumac/ti/listaUsuarios" class="back">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M19 12H5M12 19l-7-7 7-7" />
        </svg>
        Regresar
    </a>
</div>
<div class="wrapper">
    <?php if ($error): ?>
        <div class="alert">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <?php if ($usuario): ?>
        <div class="form-container">
            <div class="form-header">
                <h1>Editar usuario</h1>
                <p>Actualiza la información del usuario</p>
            </div>

            <form method="POST" action="/Aaapumac/ti/editarUsuario?id=<?php echo $usuario->id; ?>">

                <div class="field">
                    <label>Username</label>
                    <div class="field-input">
                        <input type="text"
                            name="username"
                            value="<?php echo htmlspecialchars($usuario->username); ?>"
                            required>
                    </div>
                </div>

                <div class="field">
                    <label>Email</label>
                    <div class="field-input">
                        <input type="email"
                            name="email"
                            value="<?php echo htmlspecialchars($usuario->email); ?>"
                            required>
                    </div>
                </div>

                <div class="field">
                    <label>Estado</label>
                    <div class="field-input">
                        <select name="id_status" required>
                            <option value="">Seleccionar</option>
                            <option value="1" <?php echo ($usuario->id_status == 1) ? 'selected' : ''; ?>>Activo</option>
                            <option value="2" <?php echo ($usuario->id_status == 2) ? 'selected' : ''; ?>>Inactivo</option>
                        </select>
                    </div>
                </div>

                <div class="actions">
                    <button type="submit" class="btn-save">Guardar cambios</button>
                    <a href="/Aaapumac/ti/listaUsuarios" class="btn-cancel">Cancelar</a>
                </div>

            </form>
        </div>
    <?php else: ?>
        <div class="empty">
            <p>Usuario no encontrado</p>
        </div>
    <?php endif; ?>
</div>
