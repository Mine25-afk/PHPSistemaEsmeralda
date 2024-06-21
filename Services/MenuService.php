<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

function generarMenu($conn) {
    $rol_id = $_SESSION['Role_Id'];
    $es_admin = $_SESSION['Usua_Administrador'];
    $pantallas = $_SESSION['pantallas'];

    if ($es_admin == 1) {
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

    $menu = [
        'Inicio' => ['icon' => 'fa-house'],
        'Dashboards' => ['icon' => 'fa-chart-pie'],
        'Reportes' => ['icon' => 'fa-chart-line'],
        'Accesos' => ['icon' => 'fa-key'],
        'Generales' => ['icon' => 'fa-th-list'],
        'Ventas' => ['icon' => 'fa-shopping-cart'],
        'Facturas' => ['icon' => 'fa-file-invoice-dollar']
    ];

    foreach ($result as $row) {
        $menu_key = '';
        switch ($row['Pant_Descripcion']) {
            case 'Usuarios':
            case 'Roles':
                $menu_key = 'Accesos';
                break;
            case 'Compras':
            case 'Ventas':
            case 'Reporte de caja':
            case 'Control de stock':
                $menu_key = 'Reportes';
                break;
            case 'Empleados':
            case 'Clientes':
            case 'Marcas':
            case 'Proveedores':
                $menu_key = 'Generales';
                break;
            case 'Facturas de Compra':
            case 'Transferencias':
            case 'Maquillajes':
            case 'facturaApartado':
            case 'Joyas':
            case 'Reparaciones':
                $menu_key = 'Ventas';
                break;
            case 'dashboard':
                $menu_key = 'Dashboards';
                break;
            case 'Facturas':
                $menu_key = 'Facturas';
                break;
            default:
                $menu_key = 'Inicio';
                break;
        }
        $menu[$menu_key][] = $row;
    }

    echo '<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">';
    foreach ($menu as $category => $data) {
        if (!empty($data)) {
            echo '<li class="nav-item">';
            echo '<a href="#" class="nav-link"><i class="nav-icon fas ' . $data['icon'] . '" style="color: #5d9e3e;"></i> <p>' . $category . '<i class="fas fa-angle-left right"></i></p></a>';
            echo '<ul class="nav nav-treeview">';
            foreach ($data as $item) {
                if (is_array($item)) {
                    echo '<li class="nav-item"><a href="?Pages=' . $item['Pant_Identificador'] . '" class="nav-link"><i class="far fa-circle nav-icon" style="color: #5d9e3e;"></i><p>' . $item['Pant_Descripcion'] . '</p></a></li>';
                }
            }
            echo '</ul>';
            echo '</li>';
        }
    }
    echo '</ul>';
}
?>

<style>
    .nav-treeview {
        display: none;
    }

    .nav-treeview.open {
        display: block;
    }

    .nav-link.active {
        background-color: #007bff; /* Azul */
        color: white !important;
    }

    .nav-link .nav-icon, .nav-link p {
        color: white; /* Cambia el color de los íconos y texto a blanco */
    }

    .nav-item > a:hover {
        background-color: #0056b3; /* Un azul más oscuro para el hover */
    }

    .sidebar-dark-primary .nav-sidebar > .nav-item > .nav-link.active,
    .sidebar-dark-primary .nav-sidebar > .nav-item > .nav-link:hover,
    .sidebar-dark-primary .nav-sidebar > .nav-item > .nav-link:focus {
        background-color: #FF9300; /* Azul */
        color: #FBFBA5; /* Blanco */
    }

    [class*="sidebar-dark-"] .nav-treeview > .nav-item > .nav-link.active, [class*="sidebar-dark-"] .nav-treeview > .nav-item > .nav-link.active:hover, [class*="sidebar-dark-"] .nav-treeview > .nav-item > .nav-link.active:focus {
        background-color: #5d9e3e; /* Azul más oscuro para hover/focus */
        color: #C6C62C; /* Blanco */
    }
</style>


<script>
document.addEventListener('DOMContentLoaded', function() {
    const currentPage = new URL(window.location.href).searchParams.get('Pages');
    
    document.querySelectorAll('.nav-item > a').forEach(function(link) {
        link.addEventListener('click', function(e) {
            const nextEl = link.nextElementSibling;
            if (nextEl && nextEl.classList.contains('nav-treeview')) {
                e.preventDefault();
                if (nextEl.style.display === 'block') {
                    nextEl.style.display = 'none';
                } else {
                    document.querySelectorAll('.nav-treeview').forEach(function(el) {
                        el.style.display = 'none';
                    });
                    nextEl.style.display = 'block';
                }
            }
        });
    });

    if (currentPage) {
        const activeLink = document.querySelector(`a[href="?Pages=${currentPage}"]`);
        if (activeLink) {
            activeLink.classList.add('active');
            const parentMenu = activeLink.closest('.nav-treeview');
            if (parentMenu) {
                parentMenu.classList.add('open');
                parentMenu.previousElementSibling.classList.add('active');
            }
        }
    }
});
</script>
