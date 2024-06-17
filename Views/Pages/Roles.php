<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Roles</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.3.12/themes/default/style.min.css" />
    <style>
 /* Estilos mejorados para el tree view */
.tree ul {
    padding-left: 20px;
    list-style-type: none;
}

.tree li {
    margin: 5px 0;
    position: relative;
}

.tree input[type="checkbox"] {
    margin-right: 5px;
}

.tree label {
    cursor: pointer;
}

/* Estilo de las líneas */
.tree li::before {
    content: '';
    position: absolute;
    top: 0;
    left: -10px;
    width: 0;
    height: 100%;
    border-left: 1px solid #ccc; /* Color de las líneas */
}

.tree li:last-child::before {
    display: none; /* Ocultar la última línea */
}

/* Estilo para los íconos de expansión */
.tree label::before {
    content: '+';
    margin-right: 5px;
    color: green; /* Color del ícono de expansión */
    font-weight: bold;
}

/* Estilo para los íconos de colapso */
.tree li.expanded > label::before {
    content: '-';
}

/* Estilo para las categorías */
.tree > ul > li > label {
    font-weight: bold;
}

/* Estilo para las pantallas */
.tree li > ul > li {
    margin-left: 20px; /* Espacio para las pantallas */
}

/* Estilo para los checkbox */
.tree li > ul > li input[type="checkbox"] {
    margin-right: 5px;
}

</style>

</head>
<body>
    <div class="card">
        <div class="card-body">
            <h2 class="text-center" style="font-size:34px !important">Roles</h2>
            <p class="btn btn-primary" id="AbrirCollapse">
                Nuevo
            </p>
            <hr>
            <div class="table-responsive" id="tablaContainer">
                <table class="table table-striped table-hover" id="tablaOne">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Rol</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="collapse" id="nuevoRolCollapse">
                <div class="card card-body">
                    <h5>Crear Nuevo Rol</h5>
                    <form id="formNuevoRol">
                        <div class="form-group">
                            <label for="Role_Rol">Nombre del Rol</label>
                            <input type="text" class="form-control" id="Role_Rol" name="Role_Rol" required>
                        </div>
                        <div class="form-group">
                            <label for="pantallasTreeView">Pantallas</label>
                            <div class="tree" id="pantallasTreeView">
                                <ul>
                                    <!-- Aquí se insertarán las pantallas dinámicamente -->
                                </ul>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.3.12/jstree.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#tablaOne').DataTable({
                "ajax": {
                    "url": "Controllers/RolesController.php",
                    "type": "POST",
                    "data": function(d) {
                        d.action = 'listarRoles';
                    },
                    "dataSrc": function(json){
                        return json.data;
                    }
                },
                "columns": [
                    { "data": "Role_Id" },
                    { "data": "Role_Rol" },
                    { 
                        "data": null,
                        "render": function (data, type, row) {
                            return `
                                <a class='btn btn-primary btn-sm abrir-editar' data-id='${data.Role_Id}'>
                                    <i class='fas fa-edit'></i> Editar
                                </a> 
                               <a class='btn btn-secondary btn-sm ver-detalles' data-id='${data.Role_Id}'>
                                <i class='fas fa-eye'></i> Detalles
                                </a>
                                <button class='btn btn-danger btn-sm eliminar' data-id='${data.Role_Id}' data-toggle='modal' data-target='#eliminarModal'>
                                    <i class='fas fa-eraser'></i> Eliminar
                                </button>
                            `;
                        },
                        "defaultContent": ""
                    }
                ]
            });

            $('#AbrirCollapse').click(function() {
                $('#tablaContainer').toggle();
                $('#nuevoRolCollapse').collapse('toggle');
            });

            $.ajax({
                url: 'Controllers/RolesController.php',
                type: 'POST',
                data: { action: 'listarPantallas' },
                success: function(response) {
                    // Verifica si la respuesta del servidor es un objeto JSON
                    try {
                        response = JSON.parse(response);
                    } catch (e) {
                        console.error('La respuesta del servidor no es un JSON válido:', response);
                        return;
                    }

                    var data = response.data;

                    console.log('Datos recibidos:', data); // Verifica la estructura de los datos recibidos

                    // Clasificación de las pantallas bajo Acceso, Generales, y Ventas
                    var categorias = {
                        "Acceso": [],
                        "Generales": [],
                        "Ventas": []
                    };

                    data.forEach(function(pantalla) {
                        // Clasificación manual basada en tus necesidades
                        if (pantalla.Pant_Descripcion.includes("Usuarios") || pantalla.Pant_Descripcion.includes("Roles")) {
                            categorias["Acceso"].push(pantalla);
                        } else if (pantalla.Pant_Descripcion.includes("Cargos") || pantalla.Pant_Descripcion.includes("Categorias") || pantalla.Pant_Descripcion.includes("Clientes")) {
                            categorias["Generales"].push(pantalla);
                        } else if (pantalla.Pant_Descripcion.includes("Facturas") || pantalla.Pant_Descripcion.includes("Facturas de compra")) {
                            categorias["Ventas"].push(pantalla);
                        }
                    });

                    var pantallasTreeView = $('#pantallasTreeView > ul');
                    pantallasTreeView.empty();

                    Object.keys(categorias).forEach(function(categoria) {
                        var categoriaItem = $(`
                            <li>
                                <label class="categoria-label">${categoria}</label>
                                <ul class="categoria-ul"></ul>
                            </li>
                        `);
                        pantallasTreeView.append(categoriaItem);
                        categorias[categoria].forEach(function(pantalla) {
                            categoriaItem.find('ul').append(
                                '<li><input type="checkbox" class="pantalla-checkbox" data-id="' + pantalla.Pant_Id + '"><label>' + pantalla.Pant_Descripcion + '</label></li>'
                            );
                        });
                    });

                    $('.pantalla-checkbox').change(function() {
                        console.log('Selected Pantalla ID:', $(this).data('id'));
                    });

                    // Agregar funcionalidad de expandir/contraer
                    $('.categoria-label').click(function() {
                        $(this).next('.categoria-ul').toggle();
                    });
                }
            });
            $('#formNuevoRol').submit(function(e) {
    e.preventDefault();
    var nombreRol = $('#Role_Rol').val();
    var usuarioId = 1; // Suponiendo que el ID del usuario que crea el rol es 1
    var fecha = new Date().toISOString().slice(0, 19).replace('T', ' ');
    var selectedPantallas = [];
    $('.pantalla-checkbox:checked').each(function() {
        selectedPantallas.push($(this).data('id'));
    });

    // Primera solicitud AJAX para insertar el rol
    $.ajax({
        url: 'Controllers/RolesController.php',
        type: 'POST',
        data: {
            action: 'insertarRol',
            Role_Rol: nombreRol,
            Role_UsuarioCreacion: usuarioId,
            Role_FechaCreacion: fecha
        },
        success: function(response) {
            // Imprimir la respuesta para depuración
            console.log(response);
            try {
                var jsonResponse = JSON.parse(response);
                var roleId = jsonResponse.nuevoRolId; // Asumiendo que el ID del rol se devuelve en el campo 'nuevoRolId'

                // Segunda solicitud AJAX para insertar las pantallas por rol
                $.ajax({
                    url: 'Controllers/RolesController.php',
                    type: 'POST',
                    traditional: true, // Necesario para enviar arrays
                    data: {
                        action: 'insertarPantallaPorRol',
                        Role_Id: roleId,
                        Pantallas: selectedPantallas
                    },
                    success: function(response) {
                        console.log(response);
                        // Aquí puedes agregar la lógica para actualizar la tabla o mostrar un mensaje de éxito
                    }
                });
            } catch (e) {
                console.error("Error al parsear JSON: ", e);
                console.error("Respuesta del servidor: ", response);
            }
        },
        error: function(xhr, status, error) {
            console.error("Error en la solicitud AJAX: ", error);
            console.error("Estado: ", status);
            console.error("Respuesta completa: ", xhr.responseText);
        }
    });
});




        });
    </script>
</body>
</html>
