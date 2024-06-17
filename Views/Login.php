

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="../Views/Resources/dist/css/adminlte.min.css">
    <style>
        body {
    margin: 0;
    padding: 0;
    font-family: Arial, Helvetica, sans-serif;
    background: url('Fondo.png') no-repeat center center fixed;
    background-size: cover;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    
}

.login-container {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    height: 100%;
}

.login-box {
    background-color: #5D9E3E;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0px 8px rgba(0, 0, 0, 0.5);
    display: flex;
    flex-direction: row;
    max-width: 800px;
    width: 100%;
}

.login-logo {
    background: url('Logo.png') no-repeat center center;
    background-size: contain;
    color: #fff;
    padding: 20px;
    border-radius: 8px 0 0 8px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
    width: 50%;
}

.login-logo img {
    max-width: 100px;
    margin-bottom: 10px;
}

.login-logo h1 {
    margin: 0;
    font-size: 2rem;
}

.login-logo p {
    margin-top: 10px;
    font-size: 1rem;
}

.login-form {
    padding: 20px;
    display: flex;
    flex-direction: column;
    width: 50%;
}

.login-form h2 {
    margin: 0 0 20px 0;
    font-size: 1.5rem;
    text-align: center;
}

.input-group {
    margin-bottom: 15px;
    position: relative;
}

.input-group input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 1rem;
}

.forgot-password {
    text-align: right;
    margin-bottom: 15px;
}

.forgot-password a {
    color: #007bff;
    text-decoration: none;
}

.forgot-password a:hover {
    text-decoration: underline;
}

button {
    background-color: #333;
    color: #fff;
    padding: 10px;
    border: none;
    border-radius: 4px;
    font-size: 1rem;
    cursor: pointer;
}

button:hover {
    background-color: #555;
}
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <div class="login-logo">
                
            </div>
            <div class="login-form">
            <form id="quickForm">
                <h2>Iniciar sesión</h2>
                <div class="input-group">
                    <input type="text" name="Usuario" placeholder="Usuario" required id="Usuario">
                </div>
                <div class="input-group">
                    <input type="password" name="Contraseña" placeholder="Contraseña" required id="Contraseña">
                </div>
                <div class="forgot-password">
                    <a href="#">No recuerdo mi contraseña</a>
                </div>
                <div class="button" style="display:flex;justify-content: center;">
                <button type="button" id="GuardarBtn">Ingresar</button>
                </div>
            </form>
            </div>
           
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
    <script>
    $(document).ready(function () {  
        $('#quickForm').validate({
            rules: {
                Usuario: {
                    required: true
                },
                Contraseña: {
                    required: true
                }
            },
            messages: {
                Usuario: {
                    required: "Por favor ingrese su usuario"
                },
                Contraseña: {
                    required: "Por favor ingrese su contraseña"
                }
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.input-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });

        $('#GuardarBtn').click(function() {
            if ($('#quickForm').valid()) {
                var Usuario = $('#Usuario').val();
                var Contraseña = $('#Contraseña').val();
                console.log(Contraseña);
                $.ajax({
                    url: 'LoginService.php',
                    type: 'POST',
                    data: {
                        action: 'Login',
                        Usuario: Usuario,
                        Contra: Contraseña
                    },
                    success: function(response) {
                        var data = JSON.parse(response); // Parse the JSON response
                        console.log(data);
                        console.log(data.data.length);
                        if (data.data.length > 0) {
                            window.location.href = '../index.php';
                        } else {
                            $('.invalid-feedback').remove();
                            $('#Usuario').addClass('is-invalid').after('<span class="invalid-feedback">Usuario incorrecto</span>');
                            $('#Contraseña').addClass('is-invalid').after('<span class="invalid-feedback">Contraseña incorrecta</span>');
                        }
                    },
                    error: function() {
                        alert('Error en la comunicación con el servidor.');
                    }
                });
            }
        });
    });
    </script>
</body>



</html>