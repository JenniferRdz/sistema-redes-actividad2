<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Seguro - Sistema Redes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; display: flex; align-items: center; }
        .card { border: none; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.2); }
        .requirement { font-size: 0.85rem; color: #6c757d; transition: all 0.3s; }
        .requirement.valid { color: #198754; font-weight: bold; }
        .requirement.invalid { color: #dc3545; }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card p-4">
                <div class="text-center mb-4">
                    <h3 class="fw-bold">Crear Cuenta</h3>
                    <p class="text-muted">Sistema de Redes Inalámbricas</p>
                </div>

                <form id="registroForm" action="registro_action.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Nombre Completo</label>
                        <input type="text" name="nombre" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nombre de Usuario</label>
                        <input type="text" name="usuario" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Contraseña</label>
                        <div class="input-group">
                            <input type="password" id="password" name="password" class="form-control" required>
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword()">
                                <i id="eyeIcon" class="bi bi-eye"></i>
                            </button>
                        </div>
                        <div class="mt-2">
                            <div id="req-length" class="requirement"><i class="bi bi-circle"></i> Mínimo 8 caracteres</div>
                            <div id="req-upper" class="requirement"><i class="bi bi-circle"></i> Una mayúscula</div>
                            <div id="req-lower" class="requirement"><i class="bi bi-circle"></i> Una minúscula</div>
                            <div id="req-number" class="requirement"><i class="bi bi-circle"></i> Un número</div>
                            <div id="req-special" class="requirement"><i class="bi bi-circle"></i> Un carácter especial (@$!%*?&)</div>
                        </div>
                    </div>
                    
                    <button type="submit" id="submitBtn" class="btn btn-primary w-100 py-2 fw-bold" disabled>Registrar Usuario</button>
                </form>
                
                <div class="text-center mt-3">
                    <a href="login.php" class="text-decoration-none">¿Ya tienes cuenta? Inicia sesión</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const passwordInput = document.getElementById('password');
    const submitBtn = document.getElementById('submitBtn');
    
    const requirements = {
        length: { regex: /.{8,}/, el: document.getElementById('req-length') },
        upper: { regex: /[A-Z]/, el: document.getElementById('req-upper') },
        lower: { regex: /[a-z]/, el: document.getElementById('req-lower') },
        number: { regex: /[0-9]/, el: document.getElementById('req-number') },
        special: { regex: /[@$!%*?&]/, el: document.getElementById('req-special') }
    };

    passwordInput.addEventListener('input', () => {
        let allValid = true;
        
        for (const key in requirements) {
            const isValid = requirements[key].regex.test(passwordInput.value);
            const el = requirements[key].el;
            const icon = el.querySelector('i');
            
            if (isValid) {
                el.classList.add('valid');
                el.classList.remove('invalid');
                icon.className = 'bi bi-check-circle-fill';
            } else {
                el.classList.remove('valid');
                if(passwordInput.value.length > 0) el.classList.add('invalid');
                icon.className = 'bi bi-circle';
                allValid = false;
            }
        }
        
        submitBtn.disabled = !allValid;
    });

    function togglePassword() {
        const icon = document.getElementById('eyeIcon');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.className = 'bi bi-eye-slash';
        } else {
            passwordInput.type = 'password';
            icon.className = 'bi bi-eye';
        }
    }
</script>

</body>
</html>
