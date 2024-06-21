<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link rel="stylesheet" href="login.css">
   
</head>

<body>

        <div class="container">

            <div class="image-section">
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                
                <img src="image.png" alt="Logo" style="width: 320px; height: auto;">
            </div>
            <div class="form-section">
            <ul class="circles">
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
            </ul>

                <div class="toggle-buttons"></div>
                <form id="sign-in-form">
                    <h1 style="color: #000;">Iniciar Sesion</h1>
                    <div class="input-group">
                        <input type="text" name="Usuario" placeholder="Usuario" required id="Usuario">
                        <br>
                    </div>
                    <div class="input-group">
                        <br>
                        <input type="password" name="Contraseña" placeholder="Contraseña" required id="Contraseña">
                    </div>
                    <br>
                  
                    <div class="forgot-password" style="font-size: 12px;">
                        <a href="/PHPSistemaEsmeralda/Views/Pages/RestablecerContra.php">¿Olvidaste tu Contraseña?</a>
                    </div>
                    <button type="submit" class="sign-in-button" >Iniciar Sesion</button>
                    <div class="social-icons">
                        <a href="https://accounts.google.com/signin"><img src="Google__G__logo.svg.webp" alt="Google"></a>
                        <a href="https://www.facebook.com/login/"><img src="images-removebg-preview.png" alt="Facebook"></a>
                        <a href="https://github.com/login"><img src="GitHub_Invertocat_Logo.svg" alt="GitHub"></a>
                    </div>
                </form>
            </div>
        </div>
</body>

</html>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
<script>
        $(document).ready(function () {
            $('#sign-in-form').validate({
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

            $('#sign-in-form').on('submit', function(e) {
                e.preventDefault();
                if ($(this).valid()) {
                    var Usuario = $('#Usuario').val();
                    var Contraseña = $('#Contraseña').val();
                    $.ajax({
                        url: 'LoginService.php',
                        type: 'POST',
                        data: {
                            action: 'Login',
                            Usuario: Usuario,
                            Contra: Contraseña
                        },
                        success: function(response) {
                            var data = JSON.parse(response);
                            if (data.data.length > 0) {
                                window.location.href = 'http://localhost/PHPSistemaEsmeralda/index.php?Pages=dashboard';
                            } else {
                                $('.invalid-feedback').remove();
                                $('#Usuario').addClass('is-invalid').after('<span class="invalid-feedback">Usuario incorrecto</span>');
                                $('#Contraseña').addClass('is-invalid').after('<span class="invalid-feedback">Contraseña incorrecta</span>');
                            }
                        },
                        error: function() {
                  
                        }
                    });
                }
            });
        });
    </script>