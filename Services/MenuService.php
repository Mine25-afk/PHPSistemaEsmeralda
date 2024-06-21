
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

function generarMenu($conn) {
    $rol_id = $_SESSION['Role_Id'];
    $es_admin = $_SESSION['Usua_Administrador'];
    $pantallas = $_SESSION['pantallas'];

    

    // Acceder al valor 'usuarios' en el array $pantallas
   // Inicia la sesión si no está iniciada

    if ($es_admin == 1) { // Verificar si es administrador
        $sql = "SELECT * FROM acce_tbpantallas WHERE Pant_Estado = 1";
        $stmt = $conn->prepare($sql);
    } else {
        if (is_array($pantallas) && count($pantallas) > 0) {
            $sql = "SELECT * FROM acce_tbpantallas WHERE Pant_Identificador IN (" . implode(',', array_fill(0, count($pantallas), '?')) . ") AND Pant_Estado = 1";
            $stmt = $conn->prepare($sql);
            foreach ($pantallas as $k => $identificador) {
                $stmt->bindValue(($k + 1), $identificador, PDO::PARAM_STR);
            }
        } else {
            echo "Error: La variable \$pantallas no es un array o está vacía.";
            error_log('La variable $pantallas no es un array o está vacía: ' . print_r($pantallas, true));
            return;
        }
    }

    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
   
    // Agrupar pantallas por categoría
    $menu = [
        'Inicio' => [],
        'Dashboards' => [],
        'Reportes' => [],
        'Accesos' => [],
        'Generales' => [],
        'Ventas' => []
    ];

    foreach ($result as $row) {
        switch ($row['Pant_Descripcion']) {
            case 'Usuarios':
            case 'Roles':
                $menu['Accesos'][] = $row;
                break;
            case 'Compras':
            case 'Ventas':
            case 'Reporte de caja':
            case 'Control de stock':
                $menu['Reportes'][] = $row;
                break;
            case 'Empleados':
            case 'Clientes':
            case 'Marcas':
            case 'Proveedores':
                $menu['Generales'][] = $row;
                break;
        
            case 'Facturas de Compra':
            case 'Transferencias':
                case 'Maquillajes':
                    case 'Joyas':
                $menu['Ventas'][] = $row;
                break;
                
            case 'dashboard':
                
                $menu['Dashboards'][] = $row;
                break;
                case 'Facturas':
                
                    $menu['Facturas'][] = $row;
            default:
                $menu['Index'][] = $row;
                
        }
    }

    echo '<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">';
    
    // Menu Items
    echo '<li class="nav-item">';
    echo '<a href="Index.php" class="nav-link"><i class="fa-solid fa-house"></i><p>Inicio</p></a>';
    echo '</li>';

  
   
    // Accesos
    if (!empty($menu['Accesos'])) {
        echo '<li class="nav-item" id="EsquemaAcceso">';
        echo '<a href="#" class="nav-link" id="LinkAcceso"><i class="nav-icon far fa-envelope"></i><p>Accesos<i class="fas fa-angle-left right"></i></p></a>';
        echo '<ul class="nav nav-treeview">';
        foreach ($menu['Accesos'] as $item) {
            echo '<li class="nav-item"><a href="?Pages=' . $item['Pant_Identificador'] . '" class="nav-link"><i class="far fa-circle nav-icon"></i><p>' . $item['Pant_Descripcion'] . '</p></a></li>';
        }
        echo '</ul>';
        echo '</li>';
    }

    // Generales
    if (!empty($menu['Generales'])) {
        echo '<li class="nav-item" id="EsquemaGeneral">';
        echo '<a href="#" class="nav-link" id="LinkGeneral"><i class="nav-icon far fa-envelope"></i><p>Generales<i class="fas fa-angle-left right"></i></p></a>';
        echo '<ul class="nav nav-treeview">';
        foreach ($menu['Generales'] as $item) {
            echo '<li class="nav-item"><a href="?Pages=' . $item['Pant_Identificador'] . '" class="nav-link"><i class="far fa-circle nav-icon"></i><p>' . $item['Pant_Descripcion'] . '</p></a></li>';
        }
        echo '</ul>';
        echo '</li>';
    }

    // Ventas
    if (!empty($menu['Ventas'])) {
        echo '<li class="nav-item" id="EsquemaVentas">';
        echo '<a href="#" class="nav-link" id="LinkVentas"><i class="nav-icon far fa-envelope"></i><p>Ventas<i class="fas fa-angle-left right"></i></p></a>';
        echo '<ul class="nav nav-treeview">';
        foreach ($menu['Ventas'] as $item) {
            echo '<li class="nav-item"><a href="?Pages=' . $item['Pant_Identificador'] . '" class="nav-link"><i class="far fa-circle nav-icon"></i><p>' . $item['Pant_Descripcion'] . '</p></a></li>';
        }
        echo '</ul>';
        echo '</li>';
    }

     // Reportes
     if (!empty($menu['Reportes'])) {
        echo '<li class="nav-item" id="EsquemaReportes">';
        echo '<a href="#" class="nav-link" id="LinkReportes"><i class="nav-icon far fa-envelope"></i><p>Reportes<i class="fas fa-angle-left right"></i></p></a>';
        echo '<ul class="nav nav-treeview">';
        foreach ($menu['Reportes'] as $item) {
            echo '<li class="nav-item"><a href="?Pages=' . $item['Pant_Identificador'] . '" class="nav-link"><i class="far fa-circle nav-icon"></i><p>' . $item['Pant_Descripcion'] . '</p></a></li>';
        }
        echo '</ul>';
        echo '</li>';
    }


   
    
    if (!empty($menu['Dashboards'])) {
        echo '<li class="nav-item">';
        echo '<a href="?Pages=dashboard" class="nav-link"><i class="fa-solid fa-chart-simple"></i><p>Dashboards</p></a>';
        echo '</li>';
    }
    if (!empty($menu['Facturas'])) {
        echo '<li class="nav-item">';
        echo '<a href="FacturaVenta" id="FacturaLink" class="nav-link">  <i class="far fa-circle nav-icon" style="color: #5d9e3e;"></i><p>Factura</p></a>';
        echo '</li>';
    }
    echo '<li class="nav-item">';
    echo ' <a class="nav-link" id="AbrirCajas"><i class="far fa-circle nav-icon" style="color: #5d9e3e;"></i><p>Abrir Caja</p></a>';
    echo '</li>';

  echo '<li class="nav-item">';
    echo '<a class="nav-link" id="CerrarCajas"><i class="far fa-circle nav-icon" style="color: #5d9e3e;"></i><p>Cerrar caja</p></a>';
    echo '</li>';

    echo '<li class="nav-item">';
    echo ' <a class="nav-link" id="AbrirRetiro"><i class="far fa-circle nav-icon" style="color: #5d9e3e;"></i><p>Retiro caja</p></a>';
    echo '</li>';
    
    echo '</ul>';
}


?>

