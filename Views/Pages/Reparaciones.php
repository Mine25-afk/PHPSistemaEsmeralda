<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Collapse Example</title>
</head>
<body>
    <div class="container mt-5">
        <p class="btn btn-primary" id="AbrirCollapse" data-toggle="collapse" data-target="#myCollapse">Nuevo</p>
    </div>

    <!-- Collapsible Section -->
    <div class="collapse" id="myCollapse">
        <div class="card card-body">
            <!-- Your content goes here -->
            <form id="myForm" action="process_form.php" method="POST">
                <div class="form-group">
                    <label for="inputField">Campo:</label>
                    <input type="text" class="form-control" id="inputField" name="inputField">
                </div>
                <button type="submit" class="btn btn-primary">Enviar</button>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
