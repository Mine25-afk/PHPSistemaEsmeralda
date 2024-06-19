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
    list-style-type: none;
    margin: 0;
    padding: 0;
}

.tree li {
    margin: 5px 0;
    padding-left: 20px;
    position: relative;
}

.tree li::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    border-left: 1px solid #ccc;
    border-bottom: 1px solid #ccc;
    width: 10px;
    height: 20px;
}

.tree li:last-child::before {
    border-left: 1px solid #ccc;
    border-bottom: none;
}

.tree label {
    cursor: pointer;
    display: inline-block;
    padding: 5px 10px;
    border-radius: 5px;
    background-color: #fff;
    transition: background-color 0.3s, color 0.3s;
    font-size: 14px;
}

.tree label::before {
    content: '\25B6';
    display: inline-block;
    margin-right: 10px;
    transition: transform 0.3s;
}

.tree li.expanded > label::before {
    transform: rotate(90deg);
}

.tree ul.nested {
    display: none;
    padding-left: 20px;
}

.tree ul.nested.active {
    display: block;
}

.tree li.selected > label {
    background-color: #2196F3;
    color: #fff;
    border-radius: 5px;
}

.tree li > label:hover {
    background-color: #f0f0f0;
    border-radius: 5px;
}

/* Colores mejorados */
.tree li {
    --border-color: #ccc;
    --background-color: #f9f9f9;
    --hover-background-color: #f0f0f0;
    --selected-background-color: #2196F3;
    --selected-color: #fff;
}

.tree label {
    background-color: var(--background-color);
}

.tree li::before {
    border-left: 1px solid var(--border-color);
    border-bottom: 1px solid var(--border-color);
}

.tree li:last-child::before {
    border-left: 1px solid var(--border-color);
}

.tree li.selected > label {
    background-color: var(--selected-background-color);
    color: var(--selected-color);
}

.tree li > label:hover {
    background-color: var(--hover-background-color);
}
#nuevoRolCollapse .card-header {
    background-color: #007bff; /* Cambia el color del encabezado */
    color: #fff;
}

#nuevoRolCollapse .btn {
    margin-top: 10px; /* Añade margen superior a los botones */
}

</style>


</head>
<body>
    <div class="card">
        <div class="card-body">
            <h2 class="text-center" style="font-size:34px !important">Roles</h2>
            <div class="CrearOcultar">
            <p class="btn btn-primary" id="AbrirCollapse">
                Nuevo
            </p>
            <hr>
            <div class="table-responsive" id="tablaContainer">
                <table class="table table-striped table-hover" id="tablaRol">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Rol</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
            </div>
            <div class="collapse" id="nuevoRolCollapse">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5>Crear Nuevo Rol</h5>
        </div>
        <div class="card-body">
            <form id="formNuevoRol">
                <input type="hidden" id="Role_Id" name="Role_Id">
                
                <div class="form-group">
                    <label for="Role_Rol">Nombre del Rol</label>
                    <input type="text" class="form-control" id="Role_Rol" name="Role_Rol" required>
                </div>
                
                <div class="form-group">
                    <label for="pantallasTreeView">Permisos</label>
                    <div id="pantallasTreeView" class="border p-2">
                        <ul></ul>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-primary btn-block">Guardar</button>
                    </div>
                    <div class="col-md-6">
                        <a id="CerrarModal" class="btn btn-secondary btn-block text-white">Volver</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
 

</div>

<div id="Detalles">
    <div class="row" style="padding: 10px;">
        <div class="col" style="font-weight:700">
            ID
        </div>
        <div class="col" style="font-weight:700">
            Rol
        </div>
    </div>
    <div class="row" style="padding: 10px;">
        <div class="col">
            <label for="" id="DetallesId"></label>
        </div>
        <div class="col">
            <label for="" id="DetallesRol"></label>
        </div>
    </div>


    <div class="card mt-2">
        <div class="card-body">
            <h5>Auditoria</h5>
            <hr>

            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Acciones</th>
                        <th>Usuario</th>
                        <th>Fecha</th>
                    </tr>

                </thead>
                <tbody>
                    <tr>
                        <td>Insertar</td>
                        <td>

                        <label for="" id="DetallesUsuarioCreacion"></label>
                        </td>
                        <td><label for="" id="DetallesFechaCreacion"></label></td>
                    </tr>
                    <tr>
                        <td>Modificar</td>
                        <td> <label for="" id="DetallesUsuarioModificacion"></label> </td>
                        <td>  <label for="" id="DetallesFechaModificacion"></label></td>
                    </tr>
                </tbody>
            </table>

        </div>
    </div>
    <div class="col d-flex justify-content-end m-3">
    <a class="btn btn-secondary" style="color:white" id="VolverDetalles">Cancelar</a>
</div>

        </div>
     
  

            <div class="modal fade" id="eliminarModal" tabindex="-1" aria-labelledby="eliminarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="eliminarModalLabel">Confirmar Eliminación</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="text-center">¿Estás seguro de que deseas eliminar este Rol?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="confirmarEliminarBtn">Eliminar</button>
            </div>
        </div>
    </div>
</div>

    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.3.12/jstree.min.js"></script>
    <script>
var selectedPantallas = {};

$(document).ready(function () {

  
    var table =  $('#tablaRol').DataTable({
        "ajax": {
            "url": "Services/RolesService.php",
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
                       <div class='text-center'>
    <div class='btn-group'>
        <button type='button' class='btn btn-default dropdown-toggle dropdown-icon' data-toggle='dropdown'>
            <i class="fas fa-cogs"></i> Acciones
        </button>
        <div class='dropdown-menu'>
         <a class='dropdown-item  abrir-editar' data-id='${data.Role_Id}'>
                            <i class='fas fa-edit'></i> Editar
                        </a> 
                        <a class='dropdown-item  ver-detalles' data-id='${data.Role_Id}'>
                            <i class='fas fa-eye'></i> Detalles
                        </a>
                        <button class='dropdown-item  eliminar' data-id='${data.Role_Id}' data-toggle='modal' data-target='#eliminarModal'>
                            <i class='fas fa-eraser'></i> Eliminar
                        </button>
        </div>
    </div>
</div>
                    `;
                },
                "defaultContent": ""
            }
        ]
    });

    $('#AbrirCollapse').click(function() {
        $('#tablaContainer').toggle();
        $('#nuevoRolCollapse').collapse('toggle');
        $('#Detalles').hide();
    });
    $('#CerrarModal').click(function() {
        $('#tablaContainer').toggle();
        $('#nuevoRolCollapse').collapse('hide');
        limpiarFormulario();
    });
    $('#CerrarDetalles').click(function() {
        $('#tablaContainer').toggle();
        $('.CrearOcultar').show();
        $('.detallesContenido').hide();
    });
    // Datos estáticos de las pantallas
    var pantallas = [
            { Pant_Id: 1, Pant_Descripcion: "Usuarios" },
            { Pant_Id: 2, Pant_Descripcion: "Roles" },
            { Pant_Id: 9, Pant_Descripcion: "Marcas" },
            { Pant_Id: 13, Pant_Descripcion: "Proveedores" },
            { Pant_Id: 5, Pant_Descripcion: "Clientes" },
            { Pant_Id: 28, Pant_Descripcion: "Empleados" },
            { Pant_Id: 15, Pant_Descripcion: "Facturas" },
            { Pant_Id: 18, Pant_Descripcion: "Facturas de compra" },
            { Pant_Id: 16, Pant_Descripcion: "Joyas" },
            { Pant_Id: 17, Pant_Descripcion: "Maquillajes" },
            { Pant_Id: 31, Pant_Descripcion: "Transferencias" },
            { Pant_Id: 20, Pant_Descripcion: "Control de stock" },
            { Pant_Id: 30, Pant_Descripcion: "Reporte de caja" },
            { Pant_Id: 32, Pant_Descripcion: "Ventas por pago" }
        ];

        var categorias = {
            "Acceso": [],
            "Generales": [],
            "Ventas": []
        };

        pantallas.forEach(function(pantalla) {
            if (pantalla.Pant_Descripcion.includes("Usuarios") || pantalla.Pant_Descripcion.includes("Roles")) {
                categorias["Acceso"].push(pantalla);
            } else if (pantalla.Pant_Descripcion.includes("Marcas") || pantalla.Pant_Descripcion.includes("Proveedores") || pantalla.Pant_Descripcion.includes("Clientes") || pantalla.Pant_Descripcion.includes("Empleados")) {
                categorias["Generales"].push(pantalla);
            } else if (pantalla.Pant_Descripcion.includes("Facturas") || pantalla.Pant_Descripcion.includes("Facturas de compra") || pantalla.Pant_Descripcion.includes("Joyas") || pantalla.Pant_Descripcion.includes("Maquillajes") || pantalla.Pant_Descripcion.includes("Transferencias") || pantalla.Pant_Descripcion.includes("Control de stock") || pantalla.Pant_Descripcion.includes("Reporte de caja") || pantalla.Pant_Descripcion.includes("Ventas por pago")) {
                categorias["Ventas"].push(pantalla);
            }
        });

        var pantallasTreeView = $('#pantallasTreeView > ul');
        pantallasTreeView.empty();

        // Agregar checkbox para seleccionar todas las pantallas
        pantallasTreeView.append(`
            <li>
                <input type="checkbox" id="selectAllPantallas">
                <label for="selectAllPantallas">Seleccionar todas las pantallas</label>
            </li>
        `);

        Object.keys(categorias).forEach(function(categoria) {
            var categoriaItem = $(`
                <li class="categoria">
                    <input type="checkbox" class="categoria-checkbox" data-categoria="${categoria}">
                    <label class="categoria-label">${categoria}</label>
                    <ul class="nested categoria-ul"></ul>
                </li>
            `);
            pantallasTreeView.append(categoriaItem);
            categorias[categoria].forEach(function(pantalla) {
                categoriaItem.find('ul').append(
                    `<li><input type="checkbox" class="pantalla-checkbox" data-id="${pantalla.Pant_Id}" data-categoria="${categoria}"><label>${pantalla.Pant_Descripcion}</label></li>`
                );
            });
        });

        // Manejar el colapso de categorías
        pantallasTreeView.on('click', '.categoria-label', function() {
            var parentLi = $(this).closest('li');
            parentLi.toggleClass('expanded');
            parentLi.find('.categoria-ul').toggle();
        });

        // Manejar la selección de todas las pantallas
        $('#selectAllPantallas').change(function() {
            var isChecked = $(this).is(':checked');
            $('.categoria-checkbox, .pantalla-checkbox').prop('checked', isChecked);
        });

        // Manejar la selección de pantallas individuales dentro de una categoría
        pantallasTreeView.on('change', '.categoria-checkbox', function() {
            var categoria = $(this).data('categoria');
            var isChecked = $(this).is(':checked');
            $(this).siblings('ul').find('.pantalla-checkbox').prop('checked', isChecked);
        });

        // Manejar la selección individual de pantallas
        pantallasTreeView.on('change', '.pantalla-checkbox', function() {
            var categoriaCheckbox = $(this).closest('.categoria').find('.categoria-checkbox');
            var allChecked = $(this).closest('ul').find('.pantalla-checkbox:checked').length === $(this).closest('ul').find('.pantalla-checkbox').length;
            categoriaCheckbox.prop('checked', allChecked);
        });
   function limpiarFormulario() {
    console.log('Valor actual del campo Role_Id antes de limpiar:', $('#Role_Id').val());
    $('#Role_Id').val('');
    console.log('Valor actual del campo Role_Id después de limpiar:', $('#Role_Id').val());

    $('#Role_Rol').val('');
    $('#pantallasTreeView input[type="checkbox"]').prop('checked', false);
    $('#pantallasTreeView .categoria').removeClass('expanded');
    $('#pantallasTreeView .categoria-ul').hide();
}

$('#formNuevoRol').submit(function(e) {
    e.preventDefault();
    console.log('Formulario enviado');

    var roleId = $('#Role_Id').val();
    var nombreRol = $('#Role_Rol').val();
    var usuarioId = 1; // Assuming the user ID is 1 for now
    var fecha = new Date().toISOString().slice(0, 19).replace('T', ' ');

    var actionType = roleId ? 'actualizarRol' : 'insertarRol';
    var datosAEnviar = {
        action: actionType,
        Role_Rol: nombreRol,
        Role_UsuarioModificacion: usuarioId,
        Role_FechaModificacion: fecha
    };

    if (roleId) {
        datosAEnviar.Role_Id = roleId;
    } else {
        datosAEnviar.Role_UsuarioCreacion = usuarioId;
        datosAEnviar.Role_FechaCreacion = fecha;
    }

    $.ajax({
        url: 'Services/RolesService.php',
        type: 'POST',
        data: datosAEnviar,
        success: function(response) {
            console.log('Respuesta del servidor:', response);
            try {
                var result = JSON.parse(response);
                console.log('Resultado parseado:', result);

                if (result.nuevoRolId || result.resultado) {
                    var roleId = result.nuevoRolId || datosAEnviar.Role_Id;
                    console.log('Role ID:', roleId);
                    var selectedPantallas = $('.pantalla-checkbox:checked').map(function() {
                        return $(this).data('id');
                    }).get();
                    var unselectedPantallas = $('.pantalla-checkbox:not(:checked)').map(function() {
                        return $(this).data('id');
                    }).get();
                    console.log('Pantallas seleccionadas:', selectedPantallas);
                    console.log('Pantallas deseleccionadas:', unselectedPantallas);

                    var datosPantallasRol = {
                        action: 'insertarPantallasPorRol',
                        Role_Id: roleId,
                        Pantallas: selectedPantallas.join(',')
                    };

                    var datosEliminarPantallas = {
                        action: 'eliminarPantallasPorRol',
                        Role_Id: roleId,
                        Pantallas: unselectedPantallas.join(',')
                    };

                    console.log('Datos de pantallas a enviar:', datosPantallasRol);
                    console.log('Datos de pantallas a eliminar:', datosEliminarPantallas);

                    // First, remove the unselected screens
                    $.ajax({
                        url: 'Services/RolesService.php',
                        type: 'POST',
                        data: datosEliminarPantallas,
                        success: function(response) {
                            console.log('Respuesta del servidor (eliminarPantallasPorRol):', response);

                            // Then, insert the selected screens
                            $.ajax({
                                url: 'Services/RolesService.php',
                                type: 'POST',
                                data: datosPantallasRol,
                                success: function(response) {
                                    console.log('Respuesta del servidor (insertarPantallasPorRol):', response);
                                    iziToast.success({
                                        title: 'Éxito',
                                        message: 'Rol guardado correctamente.',
                                        position: 'topRight',
                        transitionIn: 'flipInX',
                        transitionOut: 'flipOutX'
                                    });
                                    $('#tablaRol').DataTable().ajax.reload();
                                    $('#tablaContainer').toggle();
                                    $('#nuevoRolCollapse').collapse('hide');
                                    limpiarFormulario();
                                },
                                error: function(xhr, status, error) {
                                    console.error("Error al insertar pantallas por rol:", xhr.responseText, status, error);
                                }
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error("Error al eliminar pantallas por rol:", xhr.responseText, status, error);
                        }
                    });
                } else {
                    console.error('Resultado no exitoso: la respuesta no contiene nuevoRolId válido', result);
                }
            } catch (e) {
                console.error('Error al parsear JSON:', e, response);
            }
        },
        error: function(xhr, status, error) {
            console.error("Error al insertar/actualizar rol:", xhr.responseText, status, error);
        }
    });
});

function obtenerDatosCompletosRol(roleId) {
    $.ajax({
        url: 'Services/RolesService.php',
        type: 'POST',
        data: {
            action: 'buscarDatosCompletosRol',
            Role_Id: roleId
        },
        success: function(response) {
            console.log('Respuesta del servidor:', response); 
            try {
                var data = JSON.parse(response);
                if (data.rol && data.pantallas) {
                    var rol = data.rol;
                    var pantallas = data.pantallas;

                    $('#Role_Id').val(rol.Role_Id);
                    $('#Role_Rol').val(rol.Role_Rol);

                    $('#pantallasTreeView input[type="checkbox"]').prop('checked', false); 

                    pantallas.forEach(function(pantalla) {
                        $('#pantallasTreeView input[data-id="' + pantalla.Pant_Id + '"]').prop('checked', true);
                    });

                    // Verificar si todas las pantallas están seleccionadas
                    var allPantallasChecked = $('.pantalla-checkbox:checked').length === $('.pantalla-checkbox').length;
                    $('#selectAllPantallas').prop('checked', allPantallasChecked);
                    if (allPantallasChecked) {
                        $('#pantallasTreeView .categoria').addClass('expanded');
                        $('#pantallasTreeView .categoria-ul').show();
                    }

                    // Verificar si todas las pantallas de una categoría están seleccionadas
                    Object.keys(categorias).forEach(function(categoria) {
                        var allPantallasInCategoriaChecked = $('.pantalla-checkbox[data-categoria="' + categoria + '"]:checked').length === $('.pantalla-checkbox[data-categoria="' + categoria + '"]').length;
                        $('.categoria-checkbox[data-categoria="' + categoria + '"]').prop('checked', allPantallasInCategoriaChecked);
                    });

                    $('#tablaContainer').toggle();
                    $('#nuevoRolCollapse').collapse('show');
                } else {
                    console.error('Datos incompletos del servidor:', data);
                }
            } catch (e) {
                console.error('Error al parsear JSON:', e, response);
            }
        },
        error: function(xhr, status, error) {
            console.error("Error al obtener los datos completos del rol:", error);
        }
    });
}

// Manejar la selección de una categoría completa
$('#pantallasTreeView').on('change', '.categoria-checkbox', function() {
    var categoria = $(this).data('categoria');
    var isChecked = $(this).is(':checked');
    $('.pantalla-checkbox[data-categoria="' + categoria + '"]').prop('checked', isChecked);
    $('#selectAllPantallas').prop('checked', $('.pantalla-checkbox:checked').length === $('.pantalla-checkbox').length);
});

$(document).on('click', '.abrir-editar', function () {
    var roleId = $(this).data('id');
    obtenerDatosCompletosRol(roleId);
});

$('#tablaRol tbody').on('click', '.ver-detalles', function () {
        var data = table.row($(this).parents('tr')).data();
        var valor = data.Role_Id;
        $('#Detalles').show();
        $('.CrearOcultar').hide();
        $('#nuevoRolCollapse').collapse('hide');
        $('#tablaContainer').toggle();

        $.ajax({
            url: 'Services/RolesService.php',
            method: 'POST',
            data: {
                action: 'buscarRol',
                Role_Id: valor
            },
            success: function(response) {
    console.log('Respuesta del servidor:', response);
    var data = JSON.parse(response);
    console.log('Datos parseados:', data);
   
$('#DetallesId').text(data.Role_Id);
$('#DetallesRol').text(data.Role_Rol);
$('#DetallesUsuarioCreacion').text(data.UsuarioCreacion);
$('#DetallesUsuarioModificacion').text(data.UsuarioModificacion);
$('#DetallesFechaModificacion').text(data.FechaModificacion);
$('#DetallesFechaCreacion').text(data.FechaCreacion);

            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
    });

var roleId; // Variable global para almacenar el ID del proveedor a eliminar

$(document).on('click', '.eliminar', function() {
    roleId = $(this).data('id'); // Actualización de la variable global sin redeclararla
    console.log('ID del proveedor:', roleId);
    $('#eliminarModal').modal('show');
});

$('#confirmarEliminarBtn').click(function() {
    if (roleId) {
        $.ajax({
            url: 'Services/RolesService.php',
            type: 'POST',
            data: {
                action: 'eliminarRol',
                Role_Id: roleId
            },
            success: function(response) {
                console.log('Response from server:', response);
                var result = JSON.parse(response);
                if (result.resultado == 1) {
                    iziToast.success({
                        title: 'Éxito',
                        message: 'Rol eliminado correctamente.',
                        position: 'topRight',
                        transitionIn: 'flipInX',
                        transitionOut: 'flipOutX'
                    });
                    $('#tablaRol').DataTable().ajax.reload();
                    $('#eliminarModal').modal('hide');
                } else {
                    iziToast.error({
                        title: 'Error',
                        message: 'Error al eliminar el rol.',
                        position: 'topRight',
                        transitionIn: 'flipInX',
                        transitionOut: 'flipOutX'
                    });
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log('Error:', errorThrown);
                iziToast.error({
                    title: 'Error',
                    message: 'Error al eliminar el rol.',
                    position: 'topRight',
                    transitionIn: 'flipInX',
                    transitionOut: 'flipOutX'
                });
            }
        });
    }
});
$('#Detalles').hide();
$('#VolverDetalles').click(function() {
        $('#Detalles').hide();
        $('#tablaContainer').toggle();
        $('.CrearOcultar').show();
    });
});
</script>

</body>
</html>
