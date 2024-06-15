<?php
require_once 'Controllers/EmpleadoController.php';
require_once 'Controllers/SucursalController.php';
require_once 'Controllers/EstadoCivilController.php';
require_once 'Controllers/CargoController.php';
require_once 'Controllers/DepartamentoController.php';
require_once 'Controllers/MunicipioController.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$controller = new EmpleadoController();
$sucu = new SucursalController();
$esta = new EstadoCivilController();
$carg = new CargoController();
$depa = new DepartamentoController();
$muni = new MunicipioController();

try {
    $empleados = $controller->listarEmpleados();
    $sucursales = $sucu->listarSucursals();
    $estadosciviles = $esta->listarEstadoCivils();
    $cargos = $carg->listarCargos();
    $departamentos = $depa->listarDepartamentos();
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['Depa_Codigo'])) {
        $Depa_Codigo = $_POST['Depa_Codigo'];
        try {
            $municipios = $muni->listarMunicipiosPorDepartamento($Depa_Codigo);
            header('Content-Type: application/json'); // Asegura que el contenido es JSON
            echo json_encode($municipios);
            exit;
        } catch (Exception $e) {
            header('Content-Type: application/json');
            echo json_encode(['error' => $e->getMessage()]);
            exit;
        }
    } else {
        try {
            $data = [
                'Nombres' => $_POST['Nombres'],
                'Apellidos' => $_POST['Apellidos'],
                'Sexo' => $_POST['Sexo'],
                'FechaNac' => $_POST['FechaNac'],
                'DNI' => $_POST['DNI'],
                'Municipio' => $_POST['Municipio'],
                'Sucursal' => $_POST['Sucursal'],
                'EstadoCivil' => $_POST['EstadoCivil'],
                'Cargo' => $_POST['Cargo'],
                'Correo' => $_POST['Correo']
            ];

            $controller->insertarEmpleado($data);
            echo 'Empleado insertado exitosamente.';
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
    exit;
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
    <form id="empleadoForm" method="POST">
    <div class="form-row">
        <div class="col-md-6">
            <label class="control-label">DNI</label>
            <input name="DNI" id="DNI" class="form-control letras" />
        </div>
        <div class="col-md-6">
            <label class="control-label">Correo</label>
            <input name="Correo" id="Correo" class="form-control letras" />
        </div>
        <div class="col-md-6">
            <label class="control-label">Nombres</label>
            <input name="Nombres" id="Nombres" class="form-control letras" />
        </div>
        <div class="col-md-6">
            <label class="control-label">Apellidos</label>
            <input name="Apellidos" id="Apellidos" class="form-control letras" />
        </div>
        <div class="col-md-6">
            <label class="control-label">Fecha de Nacimiento</label>
            <input name="FechaNac" id="FechaNac" class="form-control letras" />
        </div>
        <div class="col-md-6">
    <div class="form-group">
        <label>Departamento</label>
        <select id="Departamento" name="Departamento" class="form-control select2" style="width: 100%;">
            <option selected="selected" value="">--Seleccione un Departamento--</option>
            <?php foreach ($departamentos as $departamento): ?>
                <option value="<?php echo $departamento['Depa_Codigo']; ?>"><?php echo $departamento['Depa_Departamento']; ?></option> 
            <?php endforeach; ?>
        </select>
    </div>
</div>
<div class="col-md-6">
    <div class="form-group">
        <label>Municipio</label>
        <select id="Municipio" name="Municipio" class="form-control select2" style="width: 100%;">
            <option selected="selected" value="">--Seleccione un Municipio--</option>
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
                        <option value="<?php echo $sucursal['Sucu_Id'];?>"><?php echo $sucursal['Sucu_Nombre']; ?></option> 
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
                        <option value="<?php echo $estadocivil['Esta_Id'];?>"><?php echo $estadocivil['Esta_EstadoCivil']; ?></option> 
                    <?php endforeach;?>
                </select>
            </div>
        </div>
        <div class="col-sm-6">
            <label>Sexo</label>
            <div class="custom-control custom-radio">
                <input class="custom-control-input" type="radio" id="F" name="Sexo" value="F" checked>
                <label for="F" class="custom-control-label">Femenino</label>
            </div>
            <div class="custom-control custom-radio">
                <input class="custom-control-input" type="radio" id="M" name="Sexo" value="M">
                <label for="M" class="custom-control-label">Masculino</label>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="form-row d-flex justify-content-end">
            <div class="col-md-3">
                <input type="submit" value="Guardar" class="btn btn-primary" />
            </div>
            <div class="col-md-3">
                <a id="CerrarModal" class="btn btn-secondary" style="color:white">Volver</a>
            </div>
        </div>
    </div>
</form>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('.CrearOcultar').show();
        $('.CrearMostrar').hide();

        $('#AbrirModal').click(function() {
            $('.CrearOcultar').hide();
            $('.CrearMostrar').show();
        });

        $('#CerrarModal').click(function() {
            $('.CrearOcultar').show();
            $('.CrearMostrar').hide();
        });

        $('#Departamento').change(function() {
            var depaCodigo = $(this).val();
            if (depaCodigo) {
                $.ajax({
                    type: 'POST',
                    url: 'obtener_municipios.php', // Apunta al nuevo archivo PHP
                    data: { Depa_Codigo: depaCodigo },
                    success: function(response) {
                        console.log('respuesta', response); // Revisa la respuesta en la consola
                        try {
                            var municipios = JSON.parse(response);
                            $('#Municipio').empty();
                            $('#Municipio').append('<option selected="selected" value="">--Seleccione un Municipio--</option>');
                            $.each(municipios, function(index, municipio) {
                                $('#Municipio').append('<option value="' + municipio.Muni_Codigo + '">' + municipio.Muni_Municipio + '</option>');
                            });
                        } catch (e) {
                            console.log('Error parsing JSON:', e);
                        }
                    },
                    error: function(error) {
                        console.log('Error:', error);
                    }
                });
            }
        });
    });
</script>
