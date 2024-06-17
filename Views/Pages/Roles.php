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
.tree li::before {
    content: '';
    position: absolute;
    top: 0;
    left: -10px;
    width: 0;
    height: 100%;
    border-left: 1px solid #000000; /* Línea más fina */
    border-bottom: 1px solid #ccc; /* Línea en la parte inferior */
}
.tree li:last-child::before {
    display: none; /* Ocultar la última línea */
}
.tree label::before {
    content: '+';
    margin-right: 5px;
    color: green; /* Color del ícono de expansión */
    font-weight: bold;
}
.tree li.expanded > label::before {
    content: '>';
}
.tree > ul > li > label {
    font-weight: bold;
}
.tree li > ul > li {
    margin-left: 20px; /* Espacio para las pantallas */
}
.tree li > ul > li input[type="checkbox"] {
    margin-right: 5px;
}
ul, #myUL {
    list-style-type: none;
    margin: 0;
    padding: 0;
}

.caret {
    cursor: pointer;
    user-select: none;
}

.caret::before {
    content: "\25B6";
    color: black;
    display: inline-block;
    margin-right: 6px;
}

.caret-down::before {
    transform: rotate(90deg);
}

.nested {
    display: none;
}

.active {
    display: block;
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
                var selectedPantallas = [];
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
                        } else if (pantalla.Pant_Descripcion.includes("Marcas") || pantalla.Pant_Descripcion.includes("Proveedores") || pantalla.Pant_Descripcion.includes("Clientes") || pantalla.Pant_Descripcion.includes("Empleados")) {
                            categorias["Generales"].push(pantalla);
                        } else if (pantalla.Pant_Descripcion.includes("Facturas") || pantalla.Pant_Descripcion.includes("Facturas de compra") || pantalla.Pant_Descripcion.includes("Joyas") || pantalla.Pant_Descripcion.includes("Maquillajes")|| pantalla.Pant_Descripcion.includes("Transferencias")
                        || pantalla.Pant_Descripcion.includes("Control de stock")|| pantalla.Pant_Descripcion.includes("Reporte de caja")|| pantalla.Pant_Descripcion.includes("Ventas por pago"))  {
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
        var checkbox = $(this);
        var pantallaId = checkbox.data('id');
        console.log('Selected Pantalla ID:', pantallaId);

        if (checkbox.is(':checked')) {
            checkbox.closest('li').addClass('selected');
            selectedPantallas.push(pantallaId);
        } else {
            checkbox.closest('li').removeClass('selected');
            var index = selectedPantallas.indexOf(pantallaId);
            if (index !== -1) {
                selectedPantallas.splice(index, 1);
            }
        }

        console.log('Selected Pantallas:', selectedPantallas);
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
        console.log('Selected Pantallas:', selectedPantallas);
    });
    console.log('Datos a enviar:', {
        Role_Rol: nombreRol,
            Role_UsuarioCreacion: usuarioId,
            Role_FechaCreacion: fecha
}); // Primera solicitud AJAX para insertar el rol
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
    console.log('Respuesta JSON:', jsonResponse); // Verifica la estructura de la respuesta JSON
    
    var roleId = jsonResponse.nuevoRolId; // Asumiendo que el ID del rol se devuelve en el campo 'nuevoRolId'
    console.log('ID del nuevo rol:', roleId); // Verifica que obtienes correctamente el ID del nuevo rol
 // Asumiendo que el ID del rol se devuelve en el campo 'nuevoRolId'
                // Segunda solicitud AJAX para insertar las pantallas por rol
                console.log('Datos a enviar:', {
                    Role_Id: roleId,
                    Pantallas: selectedPantallas
});
                $.ajax({
                    url: 'Controllers/RolesController.php',
                    type: 'POST',
                    traditional: true, // Necesario para enviar arrays
                    data:  {
        action: 'insertarPantallaPorRol',
        data: {
            Role_Id: roleId, // roleId es el ID del rol
            Pantallas: selectedPantallas // selectedPantallas es un array con los IDs de las pantallas seleccionadas
        }
    },
    
    success: function(response) {
        console.log('Respuesta de insertarPantallaPorRol:', response);// Verifica la respuesta de la inserción de pantallas por rol
                        // Aquí puedes agregar la lógica para actualizar la tabla o mostrar un mensaje de éxito
                    }
                });
            } catch (e) {
                console.error('Error al parsear JSON:', e); // Imprime cualquier error al parsear JSON
                console.error('Respuesta del servidor:', response); // Imprime la respuesta del servidor para investigar posibles problemas
            }
        },
        error:  function(xhr, status, error) {
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
