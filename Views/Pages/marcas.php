
<div class="card">
    <div class="card-body">
    <h2 class="text-center" style="font-size: 90px !important">Marcas</h2>
    <div class="CrearOcultar" style="position:relative; top:-30px">
        <p class="btn btn-primary" id="AbrirModal">
            Nuevo
        </p>
        <hr>
        <div class="table-responsive">
            <table class="table table-striped table-hover" id="TablaMarca">
                <thead>
                    <tr>
                    <th>#</th>
                        <th>Marca</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>

        </div>

        <div class="CrearMostrar">
        <div class="d-flex justify-content-end">
                        <a href="#" id="CerrarModal" style="color: black;" class="btn btn-link">Regresar</a>
                    </div>
        <form id="quickForm">


        <div class="form-row d-flex justify-content-center">

            <div class="col-md-6">
                <label class="control-label"></label>
                <input name="Marca" class="form-control letras" id="Marca"/>
                <span class="text-danger"></span>
            </div>
        </div>


<div class="card-body">
    <div class="form-row d-flex justify-content-center">

        <div class="col-auto" style="margin: 0px 10px;">
            <input type="button" value="Guardar" class="btn btn-primary" id="guardarBtn"/>
        </div>

        <div class="col-auto">
            <a id="CerrarModal" class="btn btn-secondary" style="color:white">Cancelar</a>
        </div>
    </div>
</div>


</form>
        </div>
        
    </div>

</div>

<!-- Modal Eliminar -->
<div class="modal fade" id="eliminarModal" tabindex="-1" aria-labelledby="eliminarModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eliminarModalLabel">Confirmar Eliminación</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ¿Estás seguro de que deseas eliminar esta Marca?
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-danger" id="confirmarEliminarBtn">SI</button>
                <button type="button" class="btn btn-secondary" style="color: white;" data-dismiss="modal">NO</button>
             
            </div>
        </div>
    </div>
</div>

<div id="Detalles">
<div class="d-flex justify-content-end">
                        <a href="#" id="VolverDetalles" style="color: black;" class="btn btn-link">Regresar</a>
                    </div>
    <div class="row" style="padding: 10px;">
        <div class="col" style="font-weight:700">
            ID
        </div>
        <div class="col" style="font-weight:700">
            Marca
        </div>
    </div>
    <div class="row" style="padding: 10px;">
        <div class="col">
            <label for="" id="DetallesId"></label>
        </div>
        <div class="col">
            <label for="" id="DetallesMarca"></label>
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



<script>
   $(document).ready(function () {

    $('#quickForm').validate({
        rules: {
            Marca: {
                required: true
            }
        },
        messages: {
            Marca: {
                required: "Por favor ingrese su Marca"
            }
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.col-md-6').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        }
    });

    sessionStorage.setItem('Marc_Id', "0");
    var table = $('#TablaMarca').DataTable({
        "ajax": {
            "url": "Services/MarcaService.php",
            "type": "POST",
            "data": function(d) {
                d.action = 'listarMarcas';
            },
            "dataSrc": function(json){
                console.log(json)
                return json.data;
            }
        },language: {
                "decimal": "",
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Entradas",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "search": "Buscar:",
                "zeroRecords": "Sin resultados encontrados",
                "paginate": {
                    "first": "Primero",
                    "last": "Ultimo",
                    "next": "Siguiente",
                    "previous": "Anterior"
                }

            },
        "columns": [
            { "data": null },
            { "data": "Marc_Marca" },
            { 
                "data": null, 
               
                         
                         
                        
                "defaultContent": `
<div class='text-center'>
    <div class='btn-group'>
        <button type='button' class='btn btn-default dropdown-toggle dropdown-icon' data-toggle='dropdown'>
            <i class="fas fa-cogs"></i> Acciones
        </button>
        <div class='dropdown-menu'>
            <a class='dropdown-item abrir-editar'>
                <i class="fas fa-edit"></i> Editar
            </a>
            <a class='dropdown-item abrir-detalles'>
                <i class="fas fa-info-circle"></i> Detalles
            </a>
            <a class='dropdown-item abrir-eliminar'>
                <i class="fas fa-trash-alt"></i> Eliminar
            </a>
        </div>
    </div>
</div>
`
            }
        ],
        "createdRow": function(row, data, dataIndex) {
      
        $('td:eq(0)', row).html(dataIndex + 1);
    }
    });
    $('.CrearOcultar').show();
    $('.CrearMostrar').hide();
    $('#Detalles').hide();


    $('#AbrirModal').click(function() {
    $('.CrearOcultar').hide();
    $('.CrearMostrar').show();
    $('#Marca').val(null);
    sessionStorage.setItem('Marc_Id', "0");
    });

    $('#CerrarModal').click(function() {
    $('.CrearOcultar').show();
    $('.CrearMostrar').hide();
    });

    $('#TablaMarca tbody').on('click', '.abrir-eliminar', function () {
        var data = table.row($(this).parents('tr')).data();
        console.log(data);
        var Marc_Id = data.Marc_Id;
        sessionStorage.setItem('Marc_Id', Marc_Id);
        $('#eliminarModal').modal('show');
        });

        $('#confirmarEliminarBtn').click(function() {
        var Marca_Id = sessionStorage.getItem('Marc_Id');
        $.ajax({
            url: 'Services/MarcaService.php',
            type: 'POST',
            data: {
                action: 'eliminar',
                Marc_Codigo: Marca_Id
            },
            success: function(response) {
                if (response == 1) {
                    iziToast.success({
                        title: 'Éxito',
                        message: 'Eliminado con éxito',
                        position: 'topRight',
                        transitionIn: 'flipInX',
                        transitionOut: 'flipOutX'
                    });
                    $('#TablaMarca').DataTable().ajax.reload();
                    $('#eliminarModal').modal('hide');
                    sessionStorage.setItem('Marc_Id', "0");
                } else {
                    iziToast.error({
                        title: 'Error',
                        message: 'Problemas',
                        position: 'topRight',
                        transitionIn: 'flipInX',
                        transitionOut: 'flipOutX'
                    });
                    $('#eliminarModal').modal('hide');
                }
            },
            error: function() {
                alert('Error en la comunicación con el servidor.');
            }
        });
    });   

    $('#Regresar').click(function() {
            limpiarFormulario();
       
            $('.CrearOcultar').show();
            $('.CrearMostrar').hide();
            $('.CrearDetalles').hide();
        });
    
    $('#guardarBtn').click(function() {
    if ($('#quickForm').valid()) {
        var marca = $('#Marca').val();
        var Valor = sessionStorage.getItem('Marc_Id');
        var InsertarOActualizar = true
        if (Valor == "0") {
            InsertarOActualizar = true
        }else{
            InsertarOActualizar = false
        }

        console.log(Valor)
        console.log(InsertarOActualizar)

        $.ajax({
            url: 'Services/MarcaService.php',
            type: 'POST',
            data: {
                action: InsertarOActualizar ? 'insertar' : 'actualizar',
                Marc_Id: Valor,
                Marc_Marca: marca,
                Marc_UsuarioCreacion: 1, 
                Marc_FechaCreacion: new Date().toISOString().slice(0, 19).replace('T', ' ')
            },
            success: function(response) {
                console.log(response)
                if (response == 1) {
                    $('#Marca').val(null);
                    iziToast.success({
            title: 'Éxito',
            message: 'Subido con exito',
            position: 'topRight',
            transitionIn: 'flipInX',
            transitionOut: 'flipOutX'


        });
        $('#TablaMarca').DataTable().ajax.reload();
            $('.CrearOcultar').show();
            $('.CrearMostrar').hide();
                } else {
                    iziToast.error({
            title: 'Error',
            message: 'No se pudo subir',
            position: 'topRight',
            transitionIn: 'flipInX',
            transitionOut: 'flipOutX'


        });
                }
            },
            error: function() {
                alert('Error en la comunicación con el servidor.');
            }
        });
}
});

    $('#TablaMarca tbody').on('click', '.abrir-editar', function () {
        var data = table.row($(this).parents('tr')).data();
        sessionStorage.setItem('Marc_Id', data.Marc_Id);
        $('#Marca').val(data.Marc_Marca);
        $('.CrearOcultar').hide();
        $('.CrearMostrar').show();
    });

    $('#TablaMarca tbody').on('click', '.abrir-detalles', function () {
        var data = table.row($(this).parents('tr')).data();
        var valor = data.Marc_Id;
        $('#Detalles').show();
        $('.CrearOcultar').hide();
        $('.CrearMostrar').hide();

        $.ajax({
            url: 'Services/MarcaService.php',
            method: 'POST',
            data: {
                action: 'buscar',
                Marc_Id: valor
            },
            success: function(response) {
                var data = JSON.parse(response);
                var marca = data.data[0];
                $('#DetallesId').text(marca.Marc_Id);
                $('#DetallesMarca').text(marca.Marc_Marca);
                $('#DetallesUsuarioCreacion').text(marca.UsuarioCreacion);
                $('#DetallesUsuarioModificacion').text(marca.UsuarioModificacion);
                $('#DetallesFechaModificacion').text(marca.FechaModificacion);
                $('#DetallesFechaCreacion').text(marca.FechaCreacion);
            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
    });

    $('#VolverDetalles').click(function() {
        $('#Detalles').hide();
    $('.CrearOcultar').show();
    $('.CrearMostrar').hide();
    });






    });


    

  





    
    
      

    
        


</script>



