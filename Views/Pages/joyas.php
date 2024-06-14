<div class="card">
    <div class="card-body">
        <h2 class="text-center" style="font-size:34px !important">Joyas</h2>
        <div class="CrearOcultar">
        <p class="btn btn-primary" id="AbrirModal">
            Nuevo
        </p>
        <hr>
        <div class="table-responsive">
            <table class="table table-striped table-hover" id="TablaJoya">
                <thead>
                    <tr>
                       <th>Id</th>
                        <th>Descripción</th>
                        <th>Precio Compra</th>
                        <th>Precio Venta</th>
                        <th>Stock</th>
                        <th>Precio Mayorista</th>
                        <th>Imagen</th>
                        <th>Material</th>
                        <th>Proveedor</th>
                        <th>Categoría</th>
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
        <input name="Joya" class="form-control letras" id="JoyaInput"/>
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
   $('#TablaJoya').DataTable({
        "ajax": {
            "url": "Controllers/JoyasController.php",
            "type": "POST",
            "data": function(d) {
                d.action = 'listarJoyas';
            },
            "dataSrc": function(json){
                console.log(json)
                return json.data;
            }
        },
        "columns": [
            { "data": "Joya_Id" },
            { "data": "Joya_Nombre" },
            { "data": "Joya_PrecioCompra" },
            { "data": "Joya_PrecioVenta" },
            { "data": "Joya_Stock" },
            { "data": "Joya_PrecioMayor" },
            { "data": "Joya_Imagen" },
            { "data": "Mate_Material" },
            { "data": "Prov_Proveedor" },
            { "data": "Cate_Categoria" },
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
            var joya = $('#JoyaInput').val();
            console.log(joya)

            // Enviar los datos mediante AJAX
            $.ajax({
                url: 'Controllers/JoyasController.php',
                type: 'POST',
                data: {
                    action: 'insertar',
                    Joya_Nombre: joya,
                    Joya_PrecioCompra: joya,
                    Joya_PrecioVenta: joya,
                    Joya_Stock: joya,
                    Joya_PrecioMayor: joya,
                    Joya_Imagen: joya,
                    Mate_Id: joya,
                    Prov_Id: joya,
                    Cate_Id: joya,
                    Joya_UsuarioCreacion: 1, 
                    Joya_FechaCreacion: new Date().toISOString().slice(0, 19).replace('T', ' ')
                },
                success: function(response) {
                    console.log(response)
                    if (response == 1) {
                        $('#JoyaInput').val(null);
                        iziToast.success({
                 title: 'Éxito',
                 message: 'Subido con exito',
                position: 'topRight',
                 transitionIn: 'flipInX',
                 transitionOut: 'flipOutX'


             });
             $('#TablaJoya').DataTable().ajax.reload();
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


