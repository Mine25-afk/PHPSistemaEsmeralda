<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer Contraseña</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/izitoast/dist/css/iziToast.min.css">
    <style>
        body {
            background-image: url('/PHPSistemaEsmeralda/Views/Fondo.png');
            background-size: cover;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }



        .card {
            max-width: 500px;
            width: 100%;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            border: none;
        }

        .card-header {
            background-color: #5d9e3e;
            color: white;
            text-align: center;
            font-weight: bold;
            padding: 1.5rem;
            font-size: 1.25rem;
        }

        .card-body {
            padding: 2rem;
        }

        .form-group label {
            font-weight: bold;
            font-size: 1rem;
        }

        .otp-input {
            width: 3rem;
            margin: 0 0.25rem;
            text-align: center;
            font-size: 1.5rem;
            border-radius: 5px;
            border: 1px solid #ced4da;
        }

        .otp-group {
            display: flex;
            justify-content: center;
            margin-bottom: 1.5rem;
        }

        .btn {
            width: 100%;
            padding: 0.75rem;
            font-size: 1rem;
            border-radius: 5px;
            margin-top: 1rem;
        }

        .btn-primary {
            background-color: #5d9e3e;
            border: none;
        }

        .btn-primary:hover {
            background-color: #5d9e3e;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
        }

        .btn-success:hover {
            background-color: #218838;
        }

        .btn-secondary {
            background-color: #6c757d;
            border: none;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }

        .hidden {
            display: none;
        }

        .btn-group {
            display: flex;
            gap: 10px;
        }

        .link {
            display: block;
            text-align: right;
            margin-bottom: 1rem;
        }

        .link a {
            color: #007bff;
            text-decoration: none;
        }

        .link a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="card">
        <div class="card-header">Restablecer Contraseña</div>
        <div class="card-body" id="stepOne">
            <div class="form-group">
                <label for="userEmail"> Ingrese su Correo</label>
                <input type="text" class="form-control" id="userEmail" placeholder="Ingrese su correo">
            </div>
            <button class="btn btn-primary" id="sendCodeBtn">Enviar Código</button>
        </div>
        <div class="card-body hidden" id="stepTwo">
            <div class="link"><a href="#" id="backLink">Regresar</a></div>
            <div class="form-group">
                <label for="otpCode">Código OTP</label>
                <div class="otp-group">
                    <input type="text" class="form-control otp-input" maxlength="1">
                    <input type="text" class="form-control otp-input" maxlength="1">
                    <input type="text" class="form-control otp-input" maxlength="1">
                    <input type="text" class="form-control otp-input" maxlength="1">
                </div>
            </div>
            <div class="form-group">
                <label for="newPassword">Nueva Contraseña</label>
                <input type="password" class="form-control" id="newPassword" placeholder="Ingrese la nueva contraseña">
            </div>
            <div class="btn-group">
                <button class="btn btn-success" id="resetPasswordBtn">Restablecer Contraseña</button>

            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/izitoast/dist/js/iziToast.min.js"></script>
    <script>
        $(document).ready(function() {
            let userEmail;

            $('#sendCodeBtn').click(function() {
                userEmail = $('#userEmail').val();
                if (!userEmail) {
                    iziToast.error({
                        title: 'Error',
                        message: 'Por favor, ingrese su usuario o correo.',
                        position: 'topRight',
                        transitionIn: 'flipInX',
                        transitionOut: 'flipOutX'
                    });
                    return;
                }

                if (!validateEmail(userEmail)) {
                    iziToast.error({
                        title: 'Error',
                        message: 'Por favor, ingrese un correo válido.',
                        position: 'topRight',
                        transitionIn: 'flipInX',
                        transitionOut: 'flipOutX'
                    });
                    return;
                }

                $.ajax({
                    url: '/PHPSistemaEsmeralda/Services/RestablecercontraServices.php',
                    method: 'POST',
                    data: {
                        action: 'sendCode',
                        user: userEmail
                    },
                    success: function(response) {
                        try {
                            const res = JSON.parse(response);
                            if (res.status === 'success') {
                                $('#stepOne').addClass('hidden');
                                $('#stepTwo').removeClass('hidden');
                            } else {
                                iziToast.error({
                                    title: 'Error',
                                    message: res.message,
                                    position: 'topRight',
                                    transitionIn: 'flipInX',
                                    transitionOut: 'flipOutX'
                                });
                            }
                        } catch (e) {
                            console.error('Error al parsear JSON:', response);
                            iziToast.error({
                                title: 'Error',
                                message: 'Hubo un error.',
                                position: 'topRight',
                                transitionIn: 'flipInX',
                                transitionOut: 'flipOutX'
                            });
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('Error en la solicitud:', textStatus, errorThrown);
                        iziToast.error({
                            title: 'Error',
                            message: 'Hubo un error en la solicitud.',
                            position: 'topRight',
                            transitionIn: 'flipInX',
                            transitionOut: 'flipOutX'
                        });
                    }
                });
            });

            function validateEmail(email) {
                const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return re.test(String(email).toLowerCase());
            }

            $('#backLink').click(function(e) {
                e.preventDefault();
                $('#stepTwo').addClass('hidden');
                $('#stepOne').removeClass('hidden');
            });

            $('#resendCodeBtn').click(function() {
                iziToast.success({
                    title: 'Éxito',
                    message: 'El código ha sido reenviado.',
                    position: 'topRight',
                    transitionIn: 'flipInX',
                    transitionOut: 'flipOutX'
                });
            });

            $('#Regresar').click(function() {
            limpiarFormulario();
       
            $('.CrearOcultar').show();
            $('.CrearMostrar').hide();
            $('.CrearDetalles').hide();
        });

            $('.otp-input').on('input', function() {
                if (this.value.length === this.maxLength) {
                    $(this).next('.otp-input').focus();
                }
            });

            $('.otp-input').on('keydown', function(e) {
                if (e.key === "Backspace" && this.value.length === 0) {
                    $(this).prev('.otp-input').focus();
                }
            });

            $('#resetPasswordBtn').click(function() {
                const otpCode = $('.otp-input').map(function() {
                    return $(this).val();
                }).get().join('');
                const newPassword = $('#newPassword').val();

                if (otpCode.length !== 4 || !newPassword) {
                    iziToast.error({
                        title: 'Error',
                        message: 'Por favor, ingrese el código completo y la nueva contraseña.',
                        position: 'topRight',
                        transitionIn: 'flipInX',
                        transitionOut: 'flipOutX'
                    });
                    return;
                }

                $.ajax({
                    url: '/PHPSistemaEsmeralda/Services/CodigoRestablecer.php',
                    method: 'POST',
                    data: {
                        codigo: otpCode
                    },
                    success: function(response) {
                        try {
                            const res = JSON.parse(response);
                            if (res.valid) {
                                $.ajax({
                                    url: '/PHPSistemaEsmeralda/Services/RestablecercontraServices.php',
                                    method: 'POST',
                                    data: {
                                        action: 'resetPassword',
                                        user: userEmail,
                                        password: newPassword
                                    },
                                    success: function(response) {
                                        try {
                                            const res = JSON.parse(response);
                                            if (res.status === 'success') {
                                                iziToast.success({
                                                    title: 'Éxito',
                                                    message: 'Contraseña restablecida correctamente.',
                                                    position: 'topRight',
                                                    transitionIn: 'flipInX',
                                                    transitionOut: 'flipOutX'
                                                });
                                                setTimeout(() => {
                                                    window.location.href = '/PHPSistemaEsmeralda/Views/Login.php'; // Reemplaza con la ruta de tu página de inicio de sesión
                                                }, 2000); // Espera 2 segundos antes de redirigir
                                            } else { 
                                                iziToast.error({
                                                    title: 'Error',
                                                    message: res.message,
                                                    position: 'topRight',
                                                    transitionIn: 'flipInX',
                                                    transitionOut: 'flipOutX'
                                                });
                                            }
                                        } catch (e) {
                                            console.error('Error al parsear JSON:', response);
                                            iziToast.error({
                                                title: 'Error',
                                                message: 'Hubo un error.',
                                                position: 'topRight',
                                                transitionIn: 'flipInX',
                                                transitionOut: 'flipOutX'
                                            });
                                        }
                                    },
                                    error: function(jqXHR, textStatus, errorThrown) {
                                        console.error('Error en la solicitud:', textStatus, errorThrown);
                                        iziToast.error({
                                            title: 'Error',
                                            message: 'Hubo un error en la solicitud.',
                                            position: 'topRight',
                                            transitionIn: 'flipInX',
                                            transitionOut: 'flipOutX'
                                        });
                                    }
                                });
                            } else {
                                iziToast.error({
                                    title: 'Error',
                                    message: 'Código incorrecto.',
                                    position: 'topRight',
                                    transitionIn: 'flipInX',
                                    transitionOut: 'flipOutX'
                                });
                            }
                        } catch (e) {
                            console.error('Error al parsear JSON:', response);
                            iziToast.error({
                                title: 'Error',
                                message: 'Hubo un error.',
                                position: 'topRight',
                                transitionIn: 'flipInX',
                                transitionOut: 'flipOutX'
                            });
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('Error en la solicitud:', textStatus, errorThrown);
                        iziToast.error({
                            title: 'Error',
                            message: 'Hubo un error en la solicitud.',
                            position: 'topRight',
                            transitionIn: 'flipInX',
                            transitionOut: 'flipOutX'
                        });
                    }
                });
            });
        });
    </script>
</body>

</html>