<?php
require_once 'Controllers/UsuarioController.php';
require_once 'Controllers/EmpleadoController.php';
require_once 'Controllers/RolesController.php';

$controller = new UsuarioController();
$controllerempl = new EmpleadoController();
$controllerrol = new RolesController();
try {
    $usuarios = $controller->listarUsuarios();
    $empleados = $controllerempl->listarEmpleados();
    $roles = $controllerrol->listarRoles();
} catch (Exception $e) {
    echo 'Error: '. $e->getMessage();
}

?>


<body>
    <div class="container-fluid">
        <div class="row mt-2">
            <div class="col-12">
    <div class="card">
        <div class="card-header">
        <h3><b>Usuarios</b></h3>
</div>
        <div class="card-body">
        <div class="CrearOcultar">

        <p class="btn btn-primary" id="AbrirModal">
            Nuevo
        </p>
            <div class="table-responsive">
            <table class="table table-striped table-hover" id="tablaOne">
                    <thead>
                        <tr>
                            <th>Usuario</th>
                            <th>Administrador</th>
                            <th>Empleado</th>
                            <th>Rol</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($usuarios as $usuario):?>
                            <tr>
                                <td><?php echo $usuario['Usua_Usuario'];?></td>
                                <td><?php echo $usuario['Usua_Administradores'];?></td>
                                <td><?php echo $usuario['Empleado'];?></td>
                                <td><?php echo $usuario['Role_Rol'];?></td>
                                <td class="d-flex justify-content-center" style="gap:10px">
                                    <a class="btn btn-primary btn-sm abrir-editar"><i class="fas fa-edit"></i>Editar</a>
                                    <a class="btn btn-secondary btn-sm"><i class="fas fa-eye"></i>Detalles</a>
                                    <button class="btn btn-danger btn-sm"><i class="fas fa-eraser"></i> Eliminar</button>
                                </td>
                            </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            </div>
                        </div>

            <div class="CrearMostrar">
            <form>
                <div class="form-row">
                    <div class="col-md-6">
                        <label class="control-label">Usuario</label>
                        <input name="Usuario" id="Usuario" class="form-control letras" />
                        <span class="text-danger"></span>
                    </div>
                    <div class="col-md-6">
                        <label class="control-label">Contraseña</label>
                        <input name="Contraseña" id="Contraseña" class="form-control letras" />
                        <span class="text-danger"></span>
                    </div>

                    <div class="col-md-6">
                    <div class="form-group">
                    <div class="custom-control custom-switch">
                      <input type="checkbox" class="custom-control-input" id="Administrador">
                      <label class="custom-control-label" for="Administrador">Administrador</label>
                    </div>
                  </div>
                        </div>
                    
                <div class="col-md-6">
                <div class="form-group">
                  <label>Empleado</label>
                  <select id="Empleado" name="Empleado" class="form-control select2" style="width: 100%;">
                    <option selected="selected" value="">--Seleccione un Empleado--</option>
                    <?php foreach ($empleados as $empleado):?>
                       
                       <option value="<?php echo $empleado['Empl_Id'];?>"><?php echo $empleado['Empleado']; ?></option> 
                       <?php endforeach;?>
                  </select>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>Rol</label>
                  <select id="Rol" name="Rol" class="form-control select2" style="width: 100%;">
                    <option selected="selected" value="">--Seleccione un Rol--</option>
                    <?php foreach ($roles as $rol):?>
                       
                       <option value="<?php echo $rol['Role_Id'];?>"><?php echo $rol['Role_Rol']; ?></option> 
                       <?php endforeach;?>
                  </select>
                </div>
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
                        </div>
                        </div>
                        </div>
                        <script>
   $(document).ready(function () {
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
    var usuario = $('#Usuario').val();
    var contra = $('#Contraseña').val();
    var admin = $('#Administrador').val();
    var emple = $('#Empleado').val();
    var rol = $('#Rol').val();

    console.log("Datos enviados:", {
        Usua_Usuario: usuario,
        Usua_Contraseña: contra,
        Usua_Administrador: admin,
        Empl_Id: emple,
        Role_Id: rol,
        Usua_UsuarioCreacion: 1, 
        Usua_FechaCreacion: new Date().toISOString().slice(0, 19).replace('T', ' ')
    });

    $.ajax({
        url: 'Controllers/UsuarioController.php',
        type: 'POST',
        data: {
            action: 'insertar',
            Usua_Usuario: usuario,
            Usua_Contraseña: contra,
            Usua_Administrador: admin,
            Empl_Id: emple,
            Role_Id: rol,
            Usua_UsuarioCreacion: 1, 
            Usua_FechaCreacion: new Date().toISOString().slice(0, 19).replace('T', ' ')
        },
        success: function(response) {
            console.log("Respuesta recibida:", response);

            if (response == 1) {
                alert('Proveedor guardado exitosamente.');
                $('.CrearMostrar').hide();
                $('.CrearOcultar').show();
            } else {
                alert('Error al guardar el proveedor.');
            }
        },
        error: function() {
            alert('Error en la comunicación con el servidor.');
        }
    });
});


</script>

</body>