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
            <div class="collapse" id="nuevoRolCollapse">
                <div class="card card-body">
                    <h5>Crear Nuevo Rol</h5>
                    <form id="formNuevoRol">
                    <input type="hidden" id="Role_Id" name="Role_Id">

                        <div class="form-group">
                            <label for="Role_Rol">Nombre del Rol</label>
                            <input type="text" class="form-control" id="Role_Rol" name="Role_Rol" required>
                        </div>
                        <div id="pantallasTreeView">
                    <ul></ul>
                </div>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    

    <div class="CrearDetalles collapse" id="detallesCollapse">
              
                    <h5>Detalles de la Reparaciones</h5>
                    <p id="detallesContenido"></p>
                    <div class="form-row d-flex justify-content-end">
                        <div class="col-md-3">
                            <a id="CerrarDetalles" class="btn btn-secondary" style="color:white">Volver</a>
                        </div>
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

  
    $('#tablaRol').DataTable({
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
    $('#CerrarDetalles').click(function() {
        $('#tablaContainer').toggle();
        $('#nuevoRolCollapse').collapse('hide');
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
  
    $('#Role_Rol').val('');

   
    $('#pantallasTreeView input[type="checkbox"]').prop('checked', false);

   
    $('#pantallasTreeView .categoria').removeClass('expanded');
    $('#pantallasTreeView .categoria-ul').hide();
}


    $('#formNuevoRol').submit(function(e) {
    e.preventDefault();

    console.log('Formulario enviado');

    var nombreRol = $('#Role_Rol').val();
    var usuarioId = 1; 
    var fecha = new Date().toISOString().slice(0, 19).replace('T', ' ');

    var datosAEnviar = {
        action: 'insertarRol',
        Role_Rol: nombreRol,
        Role_UsuarioCreacion: usuarioId,
        Role_FechaCreacion: fecha
    };

    console.log('Datos a enviar:', datosAEnviar);

    $.ajax({
        url: 'Services/RolesService.php',
        type: 'POST',
        data: datosAEnviar,
        success: function(response) {
            console.log('Respuesta del servidor (insertarRol):', response);
            try {
                var result = JSON.parse(response);
                console.log('Resultado parseado:', result);
                
                
                if (result.nuevoRolId) {
                    var roleId = result.nuevoRolId;
                    console.log('Role ID:', roleId);
                    var selectedPantallas = $('.pantalla-checkbox:checked').map(function() {
                        return $(this).data('id');
                    }).get();
                    console.log('Pantallas seleccionadas:', selectedPantallas);

                    var datosPantallasRol = {
                        action: 'insertarPantallasPorRol',
                        Role_Id: roleId,
                        Pantallas: selectedPantallas.join(',')
                    };

                    console.log('Datos de pantallas a enviar:', datosPantallasRol);

                    $.ajax({
                        url: 'Controllers/RolesService.php',
                        type: 'POST',
                        data: datosPantallasRol,
                        success: function(response) {
                            console.log('Respuesta del servidor (insertarPantallasPorRol):', response);
                            iziToast.success({
                                title: 'Éxito',
                                message: 'Proveedor guardado correctamente.',
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

$(document).on('click', '.abrir-editar', function () {
    var roleId = $(this).data('id');
    obtenerDatosCompletosRol(roleId);
});

 
  $(document).on('click', '.ver-detalles', function() {
    var roleId = $(this).data('id');
        $.ajax({
            url: 'Services/RolesService.php',
            type: 'PoSt',
            data: {
                action: 'buscarDatosCompletosRol',
                Role_Id: roleId
            },
            success: function (response) {
                try {
                    console.log('Respuesta del servidor:', response);
                    var detalles = JSON.parse(response);
                    mostrarDetalles(detalles);
                    console.log(detalles)
                    $('#tablaContainer').toggle();
                } catch (e) {
                    alert('Error parsing JSON response.');
                }
            },
            error: function () {
                alert('Error fetching or parsing the response.');
            }
        });
    });
    function mostrarDetalles(detalles) {
    var datosGeneralesHTML = '';
    var datosAuditoriaHTML = '';

    if (typeof detalles === 'object') {
        
        datosGeneralesHTML += `
            <div class="row">
                <div class="col-md-4">
                    <p><strong>Repa_Id:</strong> ${detalles.Role_Id}</p>
                </div>
                <div class="col-md-4">
                    <p><strong>Repa_Codigo:</strong> ${detalles.Role_Rol}</p>
                </div>
                <div class="col-md-4">
                    <p><strong>Repa_Tipo_Reparacion:</strong> ${detalles.Pant_Descripcion}</p>
                </div>
            </div>
        `;

     
        datosAuditoriaHTML += `
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
                                    <label for="" ${detalles.UsuarioCreacion}></label>
                                </td>
                                <td>
                                    <label for="" ${detalles.FechaCreacion}></label>
                                </td>
                            </tr>
                            <tr>
                                <td>Modificar</td>
                                <td>
                                    <label for="" ${detalles.UsuarioModificacion}></label>
                                </td>
                                <td>
                                    <label for="" ${detalles.FechaModificacion}></label>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        `;
    } else {
        try {
            var datos = JSON.parse(detalles);

            datosGeneralesHTML += `
                <div class="row">
                <div class="col-md-4">
                    <p><strong>Repa_Id:</strong> ${detalles.Role_Id}</p>
                </div>
                <div class="col-md-4">
                    <p><strong>Repa_Codigo:</strong> ${detalles.Role_Rol}</p>
                </div>
                <div class="col-md-4">
                    <p><strong>Repa_Tipo_Reparacion:</strong> ${detalles.Pant_Descripcion}</p>
                </div>
            </div>
            `;

    
            datosAuditoriaHTML += `
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
                                    <label for="" ${detalles.UsuarioCreacion}></label>
                                </td>
                                <td>
                                    <label for="" ${detalles.FechaCreacion}></label>
                                </td>
                            </tr>
                            <tr>
                                <td>Modificar</td>
                                <td>
                                    <label for="" ${detalles.UsuarioModificacion}></label>
                                </td>
                                <td>
                                    <label for="" ${detalles.FechaModificacion}></label>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            `;
        } catch (error) {
            $('#detallesContenido').html('<p>Error al cargar los detalles de la reparación.</p>');
            $('#detallesCollapse').collapse('show');
            return;
        }
    }

    var detallesHTML = `
        <div class="datos-generales">
            <h4>Datos Generales</h4>
            ${datosGeneralesHTML}
        </div>
        <div class="datos-auditoria">
            <h4>Datos de Auditoría</h4>
            ${datosAuditoriaHTML}
        </div>
    `;

    $('#detallesContenido').html(detallesHTML);
    $('#detallesCollapse').collapse('show');
}
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


});
</script>

</body>
</html>
