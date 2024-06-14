
<div class="card">
    <div class="card-body">
        <h2 class="text-center" style="font-size:34px !important">Marca</h2>
        <div class="CrearOcultar">
        <p class="btn btn-primary" id="AbrirModal">
            Nuevo
        </p>
        <hr>
        <div class="table-responsive">
            <table class="table table-striped table-hover" id="TablaMarca">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Marca</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>

        </div>

        <div class="CrearMostrar">
        <form>


<div class="form-row">
    <div class="col-md-6">
        <label class="control-label"></label>
        <input name="Marca" class="form-control letras" id="MarcaInput"/>
        <span class="text-danger"></span>
    </div>
</div>

<div class="card-body">
    <div class="form-row d-flex justify-content-end">

        <div class="col-md-3">
        <input type="button" value="Guardar" class="btn btn-primary" id="guardarBtn" />
        </div>


        <div class="col-md-3">
            <a id="CerrarModal" class="btn btn-secondary" style="color:white">Volver</a>
        </div>
    </div>
</div>

</form>
        </div>
        
    </div>

</div>

<div class="modal fade" id="exampleModalEliminar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Eliminar Registro</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <div class="form-row">
        <p>Esta seguro que desea ELIMINAR el registro?</p>
    </div>
    <div class="row mt-3">
        <div class="col-md-2">

        </div>
        <div class="col-md-1">

        </div>
    </div>
    <div class="card-body">
        <div class="form-row mt-3 d-flex justify-content-end">

            <div class="col-md-3">
                <input type="button" name="valido" id="EliminarBtn" class="btn btn-danger btn-sm" />
            </div>


            <div class="col-md-3">

                <a class="btn btn-secondary btn-sm" style="color:white">Volver</a>


            </div>
        </div>
    </div>
            </div>

        </div>
    </div>
</div>



<script>
   $(document).ready(function () {
    
   $('#TablaMarca').DataTable({
        "ajax": {
            "url": "Controllers/MarcaController.php",
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
            { "data": "Marc_Id" },
            { "data": "Marc_Marca" },
            { 
                "data": null, 
               "defaultContent": "<a class='btn btn-primary btn-sm abrir-editar'><i class='fas fa-edit'></i>Editar</a><a class='btn btn-secondary btn-sm'><i class='fas fa-eye'></i>Detalles</a> <button class='btn btn-danger btn-sm' onclick=\"eliminar('3')\"><i class='fas fa-eraser'></i> Eliminar</button>"

            }
        ]
    });
    $('.CrearOcultar').show();
    $('.CrearMostrar').hide();
    });

   $('#AbrirModal').click(function() {
    $('.CrearOcultar').hide();
    $('.CrearMostrar').show();
    });

    $('#CerrarModal').click(function() {
    $('.CrearOcultar').show();
    $('.CrearMostrar').hide();
    });


    $('#guardarBtn').click(function() {

            var marca = $('#MarcaInput').val();
            console.log(marca)

    
            $.ajax({
                url: 'Controllers/MarcaController.php',
                type: 'POST',
                data: {
                    action: 'insertar',
                    Marc_Marca: marca,
                    Marc_UsuarioCreacion: 1, 
                    Marc_FechaCreacion: new Date().toISOString().slice(0, 19).replace('T', ' ')
                },
                success: function(response) {
                    console.log(response)
                    if (response == 1) {
                        $('#MarcaInput').val(null);
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
                       
                    }
                },
                error: function() {
                    alert('Error en la comunicación con el servidor.');
                }
            });
        });

        $('#EliminarBtn').click(function() {
        console.log("Entra")
        var valor = sessionStorage.getItem('EliminarId');
        console.log(valor)

$.ajax({
    url: 'Controllers/MarcaController.php',
    type: 'POST',
    data: {
        action: 'eliminar',
        Marc_Codigo: valor
    },
    success: function(response) {
    if (response == 1) {
    iziToast.success({
    title: 'Éxito',
    message: 'Subido con exito',
    position: 'topRight',
    transitionIn: 'flipInX',
    transitionOut: 'flipOutX'
    });
 $('#TablaMarca').DataTable().ajax.reload();
 $("#exampleModalEliminar").modal('hide');
        } else {
           
        }
    },
    error: function() {
        alert('Error en la comunicación con el servidor.');
    }
});
});
                
        

        function eliminar(id) {
        $("#exampleModalEliminar").modal('show');
        sessionStorage.setItem('EliminarId', id);
        }
</script>



