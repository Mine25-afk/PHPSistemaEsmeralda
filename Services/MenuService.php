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
            case 'ventasmayorista':
            case 'reportecaja':
            case 'ventasmetodo':
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
            case 'facturaApartado':
            case 'Joyas':
            case 'Reparaciones':
        
                $menu['Ventas'][] = $row;
                break;
                
            case 'dashboard':
                
                $menu['Dashboards'][] = $row;
                break;
                case 'Facturas':
            
                    $menu['Facturas'][] = $row;
                    break;
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
        echo '<a href="#" class="nav-link" id="LinkAcceso"><i class="nav-icon fas fa-key" id="linkacesso" style="color: #5d9e3e;"></i>    <p style="color: #5d9e3e;">
Accesos   <i class="fas fa-angle-left right"></i>
</i></p></a>';
        echo '<ul class="nav nav-treeview">';
        foreach ($menu['Accesos'] as $item) {
            echo '<li class="nav-item"><a href="?Pages=' . $item['Pant_Identificador'] . '" class="nav-link">    <i class="far fa-circle nav-icon" style="color: #5d9e3e;"></i><p>' . $item['Pant_Descripcion'] . '</p></a></li>';
        }
        echo '</ul>';
        echo '</li>';
    }

    // Generales
    if (!empty($menu['Generales'])) {
        echo '<li class="nav-item" id="EsquemaGeneral">';
        echo '<a href="#" class="nav-link" id="LinkGeneral"> <i class="nav-icon fas fa-gem" style="color: #5d9e3e;"></i> <p style="color: #5d9e3e;">
Generales<i class="fas fa-angle-left right"></i></p></a>';
        echo '<ul class="nav nav-treeview">';
        foreach ($menu['Generales'] as $item) {
            echo '<li class="nav-item"><a href="?Pages=' . $item['Pant_Identificador'] . '" class="nav-link">    <i class="far fa-circle nav-icon" style="color: #5d9e3e;"></i><p>' . $item['Pant_Descripcion'] . '</p></a></li>';
        }
        echo '</ul>';
        echo '</li>';
    }

    // Ventas
    if (!empty($menu['Ventas'])) {
        echo '<li class="nav-item" id="EsquemaVentas">';
        echo '<a href="#" class="nav-link" id="LinkVentas"><i class="nav-icon fas fa-shopping-bag" style="color: #5d9e3e;"></i>     <p style="color: #5d9e3e;">
Ventas<i class="fas fa-angle-left right"></i></p></a>';
        echo '<ul class="nav nav-treeview">';
        foreach ($menu['Ventas'] as $item) {
            echo '<li class="nav-item"><a href="?Pages=' . $item['Pant_Identificador'] . '" class="nav-link">  <i class="far fa-circle nav-icon" style="color: #5d9e3e;"></i><p>' . $item['Pant_Descripcion'] . '</p></a></li>';
        }
        echo '</ul>';
        echo '</li>';
    }

     // Reportes
     if (!empty($menu['Reportes'])) {
        echo '<li class="nav-item" id="EsquemaReportes">';
        echo '<a href="#" class="nav-link" id="LinkReportes">     <i class="nav-icon fas fa-chart-line" style="color: #5d9e3e;"></i>  <p style="color: #5d9e3e;">
Reportes<i class="fas fa-angle-left right"></i></p></a>';
        echo '<ul class="nav nav-treeview">';
        foreach ($menu['Reportes'] as $item) {
            echo '<li class="nav-item"><a href="?Pages=' . $item['Pant_Identificador'] . '" class="nav-link"><i class="far fa-circle nav-icon" style="color: #5d9e3e;"></i><p>' . $item['Pant_Descripcion'] . '</p></a></li>';
        }
        echo '</ul>';
        echo '</li>';
    }


    echo '</li>';
    if (!empty($menu['Dashboards'])) {
        echo '<li class="nav-item">';
        echo '<a href="?Pages=dashboard" class="nav-link"> <i class="far fa-circle nav-icon" style="color: #5d9e3e;"></i> <p style="color: #5d9e3e;">Dashboards</p></a>';
        echo '</li>';
    }
    if (!empty($menu['Facturas'])) {
        echo '<li class="nav-item">';
        echo '<a href="?Pages=FacturaVenta"  class="nav-link">  <i class="far fa-circle nav-icon" style="color: #5d9e3e;"></i><p>Factura</p></a>';
        echo '</li>';

        echo '<li class="nav-item">';
        echo '<a href="?Pages=facturaApartado" class="nav-link">  <i class="far fa-circle nav-icon" style="color: #5d9e3e;"></i><p>factura Apartado</p></a>';
        echo '</li>';
    
 

        echo '<li class="nav-item">';
        echo '<a id="AbrirCajas" class="nav-link">  <i class="far fa-circle nav-icon" style="color: #5d9e3e;"></i><p>Abrir Caja</p></a>';
        echo '</li>';

  
    echo '<li class="nav-item">';
        echo '<a id="CerrarCajas" class="nav-link">  <i class="far fa-circle nav-icon" style="color: #5d9e3e;"></i><p>Cerrar Caja</p></a>';
        echo '</li>';

   
    echo '<li class="nav-item">';
        echo '<a id="AbrirRetiro" class="nav-link">  <i class="far fa-circle nav-icon" style="color: #5d9e3e;"></i><p>Retiro</p></a>';
        echo '</li>';
    }
  
    echo '</ul>';
}


?>

<script>
   $(document).ready(function () {
    // Mantener el menú abierto al hacer clic en un enlace del menú
    $('.nav-item').on('click', function (e) {
        var $this = $(this);

        // Si el menú actual ya está abierto, ciérralo
        if ($this.parent().hasClass('menu-open')) {
            $this.parent().removeClass('menu-open');
            $this.siblings('.nav-treeview').slideUp();
        } else {
            // Cerrar otros menús abiertos
            $('.nav-item.menu-open').removeClass('menu-open');
            $('.nav-item.menu-open .nav-treeview').slideUp();

            // Abrir el menú actual
            $this.parent().addClass('menu-open');
            $this.siblings('.nav-treeview').slideDown();
        }
    });

    // Guardar el estado de los menús en el localStorage
    $('.nav-link').on('click', function () {
        var openMenus = [];
        $('.nav-item.menu-open').each(function () {
            openMenus.push($(this).attr('id'));
        });
        localStorage.setItem('openMenus', JSON.stringify(openMenus));
    });

    // Restaurar el estado de los menús desde el localStorage
    var openMenus = JSON.parse(localStorage.getItem('openMenus'));
    if (openMenus) {
        openMenus.forEach(function (menuId) {
            var $menu = $('#' + menuId);
            $menu.addClass('menu-open');
            $menu.children('.nav-treeview').slideDown();
        });
    }
});

</script>

