<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Seguro - Sistema Redes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f0f2f5;
            height: 100vh;
            display: flex;
            align-items: center;
        }

        .login-card {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }

        .login-header {
            background: #4e73df;
            color: white;
            padding: 2rem;
            text-align: center;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card login-card">
                    <div class="login-header">
                        <h4 class="m-0 fw-bold">Sistema Redes</h4>
                        <small>Inicia sesión para continuar</small>
                    </div>
                    <div class="card-body p-4">
                            <?php if (isset($_GET['error'])): ?>
                            <div class="alert alert-danger py-2 text-center" style="font-size: 0.9rem;">
                                Credenciales inválidas
                            </div>
                            <?php endif; ?>

                        <form action="auth.php" method="POST">
                            <div class="mb-3">
                                <label class="form-label">Usuario</label>
                                <input type="text" name="usuario" class="form-control" required
                                    placeholder="Ingresa tu usuario">
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Contraseña</label>
                                <input type="password" name="password" class="form-control" required
                                    placeholder="••••••••">
                            </div>
                            <button type="submit" class="btn btn-primary w-100 py-2">Ingresar</button>
                        </form>

                        <hr>
                        <div class="text-center">
                            <a href="registro.php" class="text-muted text-decoration-none small">¿No tienes cuenta?
                                Regístrate</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>