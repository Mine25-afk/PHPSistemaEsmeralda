<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap');
        @import url('https://css.glass');

        body {
            font-family: 'Great Vibes', cursive;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: rgb(135,135,135);
            background: radial-gradient(circle, rgba(135,135,135,1) 0%, rgba(71,71,71,1) 100%);

  
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes slideIn {
            from {
                transform: translateY(50px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .container {
            display: flex;
            background: rgb(255,255,255);
            background: linear-gradient(90deg, rgba(255,255,255,1) 0%, rgba(255,255,255,1) 35%, rgba(255,255,255,1) 100%);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            animation: fadeIn 2s ease-in-out;
        }

        .image-section {
            padding: 30px;
            text-align: center;
            animation: slideIn 1.5s ease-in-out;
        }

        .image-section img {
            width: 200px;
            height: auto;
        }

        .image-section p {
            margin-top: 20px;
            font-size: 1.1em;
        }

        .form-section {
            background: rgb(0,0,0);
            background: linear-gradient(90deg, rgba(0,0,0,1) 0%, rgba(0,0,0,1) 35%, rgba(0,0,0,1) 100%);
            padding: 30px;
            border-radius: 0 20px 20px 0;
            animation: slideIn 2s ease-in-out;
        }

        .toggle-buttons {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .toggle-buttons button {
            background: none;
            border: none;
            color: #fff;
            font-size: 1em;
            cursor: pointer;
            padding: 10px 20px;
            animation: fadeIn 1.5s ease-in-out;
            font-family: 'Roboto', sans-serif;
        }

        .toggle-buttons .active {
            background: #000;
            border-radius: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        form h1 {
            margin-bottom: 20px;
            text-align: center;
            font-family: 'Roboto', sans-serif;
        }

        .input-group {
            margin-bottom: 20px;
            position: relative;
        }

        .input-group input {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 10px;
            outline: none;
            background: rgba(255, 255, 255, 0.2);
            color: #fff;
            font-size: 1em;
            transition: background 0.3s ease-in-out;
        }

        .input-group input:focus {
            background: rgba(255, 255, 255, 0.3);
        }

        .forgot-password {
            text-align: right;
        }

        .forgot-password a {
            color: #fff;
            text-decoration: none;
            font-family: 'Roboto', sans-serif;
        }

        .sign-in-button {
            padding: 10px;
            border: none;
            border-radius: 10px;
            background: #000;
            color: #fff;
            font-size: 1em;
            cursor: pointer;
            margin-top: 10px;
            transition: background 0.3s ease-in-out;
            font-family: 'Roboto', sans-serif;
        }

        .sign-in-button:hover {
            background: #333;
        }

        .social-icons {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .social-icons a {
            background: rgba(255, 255, 255, 0.2);
            padding: 10px;
            border-radius: 50%;
            color: #fff;
            margin: 0 10px;
            text-decoration: none;
            font-size: 0.3em;
            transition: background 0.3s ease-in-out;
        }

        .social-icons a img {
            width: 20px;
            height: 20px;
        }

        .social-icons a:hover {
            background: rgba(255, 255, 255, 0.4);
        }

        .aaa{
            background: rgba(186,5,5, 0.2);
            border-radius: 16px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.58);
        }
    </style>
</head>

<body>
    <div class="aaa">
        <div class="container">
            <div class="image-section">
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
                <img src="Logo.png" alt="Logo" style="width: 320px; height: 100;">
             
             
            </div>
            <div class="form-section">
                <div class="toggle-buttons">

                </div>
                <form id="sign-in-form">
                    <h1 style="color: #fff;">Iniciar Sesion</h1>
                    <div class="input-group">
                        <input type="text" name="Usuario" placeholder="Usuario" required id="Usuario">
                    </div>
                    <div class="input-group">
                        <input type="password" name="Contraseña" placeholder="Contraseña" required id="Contraseña">
                    </div>
                    <div class="forgot-password" style="font-size: 12px;">
                        <a href="#"  >Olvidaste tu Contraseña?</a>
                    </div>
                    <button type="submit" class="sign-in-button" style="background-color: #ebb22a;">Iniciar Sesion</button>
                    <div class="social-icons">
                        <a href="https://accounts.google.com/signin"><img src="Google__G__logo.svg.webp" alt="Google"></a>
                        <a href="https://www.facebook.com/login/"><img src="images-removebg-preview.png" alt="Facebook"></a>
                        <a href="https://github.com/login"><img src="GitHub_Invertocat_Logo.svg" alt="GitHub"></a>
                    </div>
                </form> 
            </div>
        </div>
    </div>
</body>

</html>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
<script>
    $(document).ready(function() {
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
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.input-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
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