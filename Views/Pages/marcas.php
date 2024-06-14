
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
        },
        "columns": [
            { "data": "Marc_Id" },
            { "data": "Marc_Marca" },
            { 
                "data": null, 
                "defaultContent": "<a class='btn btn-primary btn-sm abrir-editar'><i class='fas fa-edit'></i>Editar</a> <a class='btn btn-secondary btn-sm'><i class='fas fa-eye'></i>Detalles</a> <button class='btn btn-danger btn-sm'><i class='fas fa-eraser'></i> Eliminar</button>"
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
            // Capturar los datos del formulario
            var marca = $('#MarcaInput').val();
            console.log(marca)

            // Enviar los datos mediante AJAX
            $.ajax({
                url: 'Controllers/MarcaController.php',
                type: 'POST',
                data: {
                    action: 'insertar',
                    Marc_Marca: marca,
                    Marc_UsuarioCreacion: 1, // Puedes reemplazar esto con el ID del usuario real
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
                
        

</script>


