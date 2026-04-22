<?php
$usuario = $answer['data']['usuario'] ?? null;
$estados = $answer['data']['estados'] ?? [];
$error = $_GET['error'] ?? null;
?>

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

<style>
    .wrapper {
        max-width: 700px;
        margin: 0 auto;
        padding: 48px 24px;
    }



    .back {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: #666;
        text-decoration: none;
        font-size: 14px;
        font-weight: 450;
        transition: color 0.2s;
    }

    .back:hover {
        color: #111;
    }

    /* Alert */
    .alert {
        background: #fef2f2;
        color: #991b1b;
        padding: 12px 16px;
        border-radius: 10px;
        font-size: 14px;
        margin-bottom: 24px;
        border: 1px solid #fee2e2;
    }

    /* Form Container */
    .form-container {
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04), 0 1px 2px rgba(0, 0, 0, 0.03);
        overflow: hidden;
    }

    .form-header {
        padding: 28px 28px 0 28px;
    }

    .form-header h1 {
        font-size: 24px;
        font-weight: 550;
        color: #111;
        margin-bottom: 8px;
        letter-spacing: -0.3px;
    }

    .form-header p {
        font-size: 14px;
        color: #666;
        margin-bottom: 0;
    }

    /* Form Fields */
    form {
        padding: 0 28px 28px 28px;
    }

    .field {
        margin-top: 24px;
    }

    .field:first-of-type {
        margin-top: 28px;
    }

    label {
        display: block;
        font-size: 13px;
        font-weight: 500;
        color: #333;
        margin-bottom: 8px;
        letter-spacing: -0.2px;
    }

    .field-input input,
    .field-input select {
        width: 100%;
        padding: 12px 14px;
        font-size: 15px;
        font-family: inherit;
        color: #111;
        background: #fff;
        border: 1px solid #d4d4d4;
        border-radius: 12px;
        transition: all 0.2s;
        outline: none;
    }

    .field-input input:focus,
    .field-input select:focus {
        border-color: #888;
        box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.05);
    }

    .field-input input::placeholder {
        color: #aaa;
    }

    select {
        cursor: pointer;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%23666' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 14px center;
    }

    /* Actions Buttons */
    .actions {
        display: flex;
        gap: 12px;
        margin-top: 36px;
        padding-top: 8px;
    }

    .btn-save,
    .btn-cancel {
        flex: 1;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 12px 20px;
        font-size: 14px;
        font-weight: 500;
        font-family: inherit;
        border-radius: 40px;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        text-align: center;
    }

    .btn-save {
        background: #1a1a1a;
        color: white;
        border: none;
    }

    .btn-save:hover {
        background: #333;
    }

    .btn-cancel {
        background: #f4f4f4;
        color: #444;
        border: 1px solid #e0e0e0;
    }

    .btn-cancel:hover {
        background: #e8e8e8;
        border-color: #ccc;
    }

    /* Empty State */
    .empty {
        background: #fff;
        border-radius: 20px;
        padding: 48px 24px;
        text-align: center;
        color: #666;
        font-size: 14px;
    }

    /* Responsive */
    @media (max-width: 560px) {
        .wrapper {
            padding: 24px 16px;
        }

        .form-header {
            padding: 24px 24px 0 24px;
        }

        form {
            padding: 0 24px 24px 24px;
        }

        .form-header h1 {
            font-size: 22px;
        }

        .actions {
            flex-direction: column;
            gap: 10px;
        }

        .btn-save,
        .btn-cancel {
            padding: 11px 20px;
        }
    }
</style>