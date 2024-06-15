<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
    margin: 0;
    padding: 0;
    font-family: Arial, Helvetica, sans-serif;
    background: url('background.jpg') no-repeat center center fixed;
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
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    display: flex;
    flex-direction: row;
    max-width: 800px;
    width: 100%;
}

.login-logo {
    background-color: #ff9800;
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
                <h1>Sistema Esmeralda</h1>
                <p>¡Las mejores Joyas!</p>
            </div>
            <form class="login-form">
                <h2>Iniciar sesión</h2>
                <div class="input-group">
                    <input type="text" placeholder="Usuario" required>
                </div>
                <div class="input-group">
                    <input type="password" placeholder="Contraseña" required>
                </div>
                <div class="forgot-password">
                    <a href="#">No recuerdo mi contraseña</a>
                </div>
                <button type="submit">Ingresar</button>
            </form>
        </div>
    </div>
</body>
</html>