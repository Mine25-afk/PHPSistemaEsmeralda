<?php
require_once __DIR__ . '/../config.php';
session_start();

class EmpleadoService
{
    public function listarEmpleados()
    {
        global $pdo;
        try {
            $sql = 'CALL `dbsistemaesmeralda`.`SP_Empleado_Listar`()';
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $data = array();
            foreach ($result as $row) {
                $data[] = array(
                    'Empl_Id' => $row['Empl_Id'],
                    'Empl_DNI' => $row['Empl_DNI'],
                    'Empleado' => $row['Empleado'],
                    'Empl_Correo' => $row['Empl_Correo'],
                    'Empl_Sexo' => $row['Empl_Sexo'],
                    'Empl_FechaNac' => $row['Empl_FechaNac'],
                    'Muni_Municipio' => $row['Muni_Municipio'],
                    'Esta_EstadoCivil' => $row['Esta_EstadoCivil'],
                    'Carg_Cargo' => $row['Carg_Cargo'],
                    'Sucu_Nombre' => $row['Sucu_Nombre']
                );
            }
            echo json_encode(array('data' => $data));
        } catch (Exception $e) {
            throw new Exception('Error al listar empleados: ' . $e->getMessage());
        }
    }
    public function listarSucursales()
    {
        global $pdo;
        try {
            $sql = 'CALL `dbsistemaesmeralda`.`SP_Sucursales_Listar`()';
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            return json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        } catch (Exception $e) {
            throw new Exception('Error al listar sucursales: ' . $e->getMessage());
        }
    }
    public function listarEstadosCiviles()
    {
        global $pdo;
        try {
            $sql = 'CALL `dbsistemaesmeralda`.`SP_EstadosCiviles_Listar`()';
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            return json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        } catch (Exception $e) {
            throw new Exception('Error al listar estadosciviles: ' . $e->getMessage());
        }
    }
    public function listarCargos()
    {
        global $pdo;
        try {
            $sql = 'CALL `dbsistemaesmeralda`.`SP_Cargos_Listar`()';
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            return json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        } catch (Exception $e) {
            throw new Exception('Error al listar cargos: ' . $e->getMessage());
        }
    }
    public function listarDepartamentos()
    {
        global $pdo;
        try {
            $sql = 'CALL `dbsistemaesmeralda`.`SP_Departamentos_Listar`()';
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            return json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        } catch (Exception $e) {
            throw new Exception('Error al listar departaments: ' . $e->getMessage());
        }
    }
    public function listarMunicipiosPorDepartamento($depaCodigo)
    {
        global $pdo;
        try {
            $sql = 'CALL `dbsistemaesmeralda`.`SP_Municipios_MostrarPorDepartamento`(:Depa_Codigo)';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':Depa_Codigo', $depaCodigo, PDO::PARAM_STR);
            $stmt->execute();
            return json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        } catch (Exception $e) {
            throw new Exception('Error al listar municipios: ' . $e->getMessage());
        }
    }

    public function insertarEmpleado($Empl_Nombre, $Empl_Apellido, $Empl_Sexo, $Empl_FechaNac, $Empl_DNI, $Muni_Codigo, $Sucu_Id, $Esta_Id, $Carg_Id, $Empl_Correo, $Empl_UsuarioCreacion, $Empl_FechaCreacion)
    {
        global $pdo;
        try {
            $sql = 'CALL `dbsistemaesmeralda`.`SP_Empleados_insertar`(:Empl_Nombre, :Empl_Apellido, :Empl_Sexo, :Empl_FechaNac, :Empl_DNI, :Muni_Codigo, :Sucu_Id, :Esta_Id, :Carg_Id, :Empl_Correo, :Empl_UsuarioCreacion, :Empl_FechaCreacion)';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':Empl_Nombre', $Empl_Nombre, PDO::PARAM_STR);
            $stmt->bindParam(':Empl_Apellido', $Empl_Apellido, PDO::PARAM_STR);
            $stmt->bindParam(':Empl_Sexo', $Empl_Sexo, PDO::PARAM_STR);
            $stmt->bindParam(':Empl_FechaNac', $Empl_FechaNac, PDO::PARAM_STR);
            $stmt->bindParam(':Empl_DNI', $Empl_DNI, PDO::PARAM_STR);
            $stmt->bindParam(':Muni_Codigo', $Muni_Codigo, PDO::PARAM_STR);
            $stmt->bindParam(':Sucu_Id', $Sucu_Id, PDO::PARAM_INT);
            $stmt->bindParam(':Esta_Id', $Esta_Id, PDO::PARAM_INT);
            $stmt->bindParam(':Carg_Id', $Carg_Id, PDO::PARAM_INT);
            $stmt->bindParam(':Empl_Correo', $Empl_Correo, PDO::PARAM_STR);
            $stmt->bindParam(':Empl_UsuarioCreacion', $_SESSION['Usua_Id'], PDO::PARAM_INT);
            $stmt->bindParam(':Empl_FechaCreacion', $Empl_FechaCreacion, PDO::PARAM_STR);
            $stmt->execute();

            $result = $stmt->fetchColumn();
            return $result;
        } catch (PDOException $e) {
            return 0;
        }
    }

    public function actualizarEmpleado($Empl_Id, $Empl_Nombre, $Empl_Apellido, $Empl_Sexo, $Empl_FechaNac, $Empl_DNI, $Muni_Codigo, $Sucu_Id, $Esta_Id, $Carg_Id, $Empl_Correo, $Empl_UsuarioModificacion, $Empl_FechaModificacion)
    {
        global $pdo;
        try {
            $sql = 'CALL SP_Empleados_Actualizar(:Empl_Id, :Empl_Nombre, :Empl_Apellido, :Empl_Sexo, :Empl_FechaNac, :Empl_DNI, :Muni_Codigo, :Sucu_Id, :Esta_Id, :Carg_Id, :Empl_Correo, :Empl_UsuarioModificacion, :Empl_FechaModificacion)';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':Empl_Id', $Empl_Id, PDO::PARAM_INT);
            $stmt->bindParam(':Empl_Nombre', $Empl_Nombre, PDO::PARAM_STR);
            $stmt->bindParam(':Empl_Apellido', $Empl_Apellido, PDO::PARAM_STR);
            $stmt->bindParam(':Empl_Sexo', $Empl_Sexo, PDO::PARAM_STR);
            $stmt->bindParam(':Empl_FechaNac', $Empl_FechaNac, PDO::PARAM_STR);
            $stmt->bindParam(':Empl_DNI', $Empl_DNI, PDO::PARAM_STR);
            $stmt->bindParam(':Muni_Codigo', $Muni_Codigo, PDO::PARAM_STR);
            $stmt->bindParam(':Sucu_Id', $Sucu_Id, PDO::PARAM_INT);
            $stmt->bindParam(':Esta_Id', $Esta_Id, PDO::PARAM_INT);
            $stmt->bindParam(':Carg_Id', $Carg_Id, PDO::PARAM_INT);
            $stmt->bindParam(':Empl_Correo', $Empl_Correo, PDO::PARAM_STR);
            $stmt->bindParam(':Empl_UsuarioModificacion', $Empl_UsuarioModificacion, PDO::PARAM_INT);
            $stmt->bindParam(':Empl_FechaModificacion', $Empl_FechaModificacion, PDO::PARAM_STR);
            $stmt->execute();

            $result = $stmt->fetchColumn();
            return $result;
        } catch (PDOException $e) {
            return 0;
        }
    }


    public function eliminarEmpleado($Empl_Id)
    {
        global $pdo;
        try {
            $sql = 'CALL SP_Empleados_Eliminar(:Empl_Id)';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':Empl_Id', $Empl_Id, PDO::PARAM_INT);

            $stmt->execute();

            $result = $stmt->fetchColumn();
            return $result;
        } catch (PDOException $e) {
            return 0;
        }
    }

    public function buscarEmpleadoPorCodigo($Empl_Id)
    {
        global $pdo;
        try {
            $sql = 'CALL `dbsistemaesmeralda`.`SP_Empleados_buscar`(:Empl_Id)';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':Empl_Id', $Empl_Id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return json_encode(array('data' => $result));
        } catch (Exception $e) {
            throw new Exception('Error al buscar el empleado: ' . $e->getMessage());
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $service = new EmpleadoService();

    if ($_POST['action'] === 'listarEmpleados') {
        $service->listarEmpleados();
    } elseif ($_POST['action'] === 'insertar') {
        $Empl_Nombre = $_POST['Nombres'];
        $Empl_Apellido = $_POST['Apellidos'];
        $Empl_Sexo = $_POST['Sexo'];
        $Empl_FechaNac = $_POST['FechaNac'];
        $Empl_DNI = $_POST['DNI'];
        $Muni_Codigo = $_POST['Municipio'];
        $Sucu_Id = $_POST['Sucursal'];
        $Esta_Id = $_POST['EstadoCivil'];
        $Carg_Id = $_POST['Cargo'];
        $Empl_Correo = $_POST['Correo'];
        $Empl_UsuarioCreacion = $_SESSION['Usua_Id'];
        $Empl_FechaCreacion = (new DateTime())->format('Y-m-d H:i:s');

        $resultado = $service->insertarEmpleado($Empl_Nombre, $Empl_Apellido, $Empl_Sexo, $Empl_FechaNac, $Empl_DNI, $Muni_Codigo, $Sucu_Id, $Esta_Id, $Carg_Id, $Empl_Correo, $Empl_UsuarioCreacion, $Empl_FechaCreacion);
        echo $resultado;
    } elseif ($_POST['action'] === 'actualizar') {
        $Empl_Id = $_POST['Empl_Id'];
        $Empl_Nombre = $_POST['Nombres'];
        $Empl_Apellido = $_POST['Apellidos'];
        $Empl_Sexo = $_POST['Sexo'];
        $Empl_FechaNac = $_POST['FechaNac'];
        $Empl_DNI = $_POST['DNI'];
        $Muni_Codigo = $_POST['Municipio'];
        $Sucu_Id = $_POST['Sucursal'];
        $Esta_Id = $_POST['EstadoCivil'];
        $Carg_Id = $_POST['Cargo'];
        $Empl_Correo = $_POST['Correo'];
        $Empl_UsuarioModificacion = $_SESSION['Usua_Id'];
        $Empl_FechaModificacion = (new DateTime())->format('Y-m-d H:i:s');

        $resultado = $service->actualizarEmpleado(
            $Empl_Id,
            $Empl_Nombre,
            $Empl_Apellido,
            $Empl_Sexo,
            $Empl_FechaNac,
            $Empl_DNI,
            $Muni_Codigo,
            $Sucu_Id,
            $Esta_Id,
            $Carg_Id,
            $Empl_Correo,
            $Empl_UsuarioModificacion,
            $Empl_FechaModificacion
        );
        echo $resultado;
    } elseif ($_POST['action'] === 'eliminar') {
        $Empl_Id = $_POST['Empl_Id'];
        $resultado = $service->eliminarEmpleado($Empl_Id);
        echo $resultado;
    } elseif ($_POST['action'] === 'buscar') {
        $Empl_Id = $_POST['Empl_Id'];
        $resultado = $service->buscarEmpleadoPorCodigo($Empl_Id);
        echo $resultado;
    } elseif ($_POST['action'] === 'listarDepartamentos') {
        echo $service->listarDepartamentos();
    } elseif ($_POST['action'] === 'listarCargos') {
        echo $service->listarCargos();
    } elseif ($_POST['action'] === 'listarEstadosCiviles') {
        echo $service->listarEstadosCiviles();
    } elseif ($_POST['action'] === 'listarSucursales') {
        echo $service->listarSucursales();
    } elseif ($_POST['action'] === 'listarMunicipiosPorDepartamento') {
        $depaCodigo = $_POST['depaCodigo'];
        echo $service->listarMunicipiosPorDepartamento($depaCodigo);
    }
}
