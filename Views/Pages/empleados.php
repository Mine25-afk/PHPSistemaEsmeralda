<?php
require_once 'Controllers/EmpleadoController.php';

$controller = new EmpleadoController();
try {
    $empleados = $controller->listarEmpleados();
    // $estadosciviles = 
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}

?>



<div class="card">
    <div class="card-body">
    <div class="CrearOcultar">
        <h2 class="text-center" style="font-size:34px !important">Empleados</h2>

        <p class="btn btn-primary" id="AbrirModal">
            Nuevo
        </p>
        <hr>
        <div class="table-responsive">
            <table class="table table-striped table-hover" id="tablaOne">
                <thead>
                    <tr>
                        <th>DNI</th>
                        <th>Empleado</th>
                        <th>Correo</th>
                        <th>Estado Civil</th>
                        <th>Sucursal</th>
                        <th>Cargo</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($empleados as $empleado): ?>
                        <tr>
                            <td><?php echo $empleado['Empl_DNI']; ?></td>
                            <td><?php echo $empleado['Empleado']; ?></td>
                            <td><?php echo $empleado['Empl_Correo']; ?></td>
                            <td><?php echo $empleado['Esta_EstadoCivil']; ?></td>
                            <td><?php echo $empleado['Sucu_Nombre']; ?></td>
                            <td><?php echo $empleado['Carg_Cargo']; ?></td>
                            <td class="d-flex justify-content-center" style="gap:10px">
                                <a class="btn btn-primary btn-sm abrir-editar"><i class="fas fa-edit"></i>Editar</a>
                                <a class="btn btn-secondary btn-sm"><i class="fas fa-eye"></i>Detalles</a>
                                <button class="btn btn-danger btn-sm"><i class="fas fa-eraser"></i> Eliminar</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
                    </div>
    <div class="CrearMostrar">
            <form>
                <div class="form-row">
                    <div class="col-md-6">
                        <label class="control-label">DNI</label>
                        <input name="DNI" id="DNI" class="form-control letras" />
                        <span class="text-danger"></span>
                    </div>
                    <div class="col-md-6">
                        <label class="control-label">Correo</label>
                        <input name="Correo" id="Correo" class="form-control letras" />
                        <span class="text-danger"></span>
                    </div>
                    <div class="col-md-6">
                        <label class="control-label">Nombres</label>
                        <input name="Nombres" id="Nombres" class="form-control letras" />
                        <span class="text-danger"></span>
                    </div>
                    <div class="col-md-6">
                        <label class="control-label">Apellidos</label>
                        <input name="Apellidos" id="Apellidos" class="form-control letras" />
                        <span class="text-danger"></span>
                    </div>
                    <div class="col-md-6">
                        <label class="control-label">Fecha de Nacimiento</label>
                        <input name="Contraseña" id="Contraseña" class="form-control letras" />
                        <span class="text-danger"></span>
                    </div>
                    <div class="col-md-6">
                <div class="form-group">
                  <label>Departamento</label>
                  <select id="Departamento" name="Departamento" class="form-control select2" style="width: 100%;">
                    <option selected="selected" value="">--Seleccione una Departamento--</option>
                    <?php foreach ($departamentos as $departamento):?>
                       
                       <option value="<?php echo $sucursal['Depa_Codigo'];?>"><?php echo $rol['Depa_Departamento']; ?></option> 
                       <?php endforeach;?>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Municipio</label>
                  <select id="Municipio" name="Municipio" class="form-control select2" style="width: 100%;">
                    <option selected="selected" value="">--Seleccione un Municipio--</option>
                    <?php foreach ($municipios as $municipio):?>
                       
                       <option value="<?php echo $municipio['Muni_Codigo'];?>"><?php echo $rol['Muni_Municipio']; ?></option> 
                    <?php endforeach;?>
                  </select>
                </div>
              </div>
                    <div class="col-md-6">
                <div class="form-group">
                  <label>Cargo</label>
                  <select id="Cargo" name="Cargo" class="form-control select2" style="width: 100%;">
                    <option selected="selected" value="">--Seleccione un Cargo--</option>
                    <?php foreach ($cargos as $cargo):?>
                       
                       <option value="<?php echo $cargo['Carg_Id'];?>"><?php echo $cargo['Carg_Cargo']; ?></option> 
                       <?php endforeach;?>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Sucursal</label>
                  <select id="Sucursal" name="Sucursal" class="form-control select2" style="width: 100%;">
                    <option selected="selected" value="">--Seleccione una Sucursal--</option>
                    <?php foreach ($sucursales as $sucursal):?>
                       
                       <option value="<?php echo $sucursal['Sucu_Id'];?>"><?php echo $rol['Sucu_Nombre']; ?></option> 
                       <?php endforeach;?>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Estado Civil</label>
                  <select id="EstadoCivil" name="EstadoCivil" class="form-control select2" style="width: 100%;">
                    <option selected="selected" value="">--Seleccione una Estado Civil--</option>
                    <?php foreach ($estadosciviles as $estadocivil):?>
                       
                       <option value="<?php echo $estadocivil['Esta_Id'];?>"><?php echo $rol['Esta_EstadoCivil']; ?></option> 
                       <?php endforeach;?>
                  </select>
                </div>
              </div>
              <div class="col-sm-6">
              <label>Sexo</label>
              <div class="custom-control custom-radio">
                 <input class="custom-control-input" type="radio" id="F" name="F" checked>
                 <label for="F" class="custom-control-label">Femenino</label>
               </div>
              <div class="custom-control custom-radio">
                 <input class="custom-control-input" type="radio" id="M" name="M">
                 <label for="M" class="custom-control-label">Masculino</label>
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
