
    
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Control de Stock</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/izitoast/dist/css/iziToast.min.css">
    <style>
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            margin-bottom: 20px;
        }
        .btn-group {
            margin-top: 20px;
        }
        .btn {
            margin-right: 10px;
        }
        .selected {
            background-color: #ff69b4;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center mb-4">Reporte de Control de Stock</h1>
        <div class="sucursal-info">
            <label for="Sucursal">Sucursal</label>
            <select id="Sucursal" name="Sucursal" class="form-control">
                <option selected="selected" value="">--Seleccione una Sucursal--</option>
                <!-- Aquí se cargarán las sucursales dinámicamente -->
            </select>
        </div>

        <div class="btn-group">
            <button type="button" class="btn btn-primary" onclick="generateReport()">Generar Reporte</button>
        </div>

        <div class="btn-group mt-3" id="tipoProductoButtons">
            <button type="button" class="btn" onclick="selectTipoProducto('0')">Maquillajes</button>
            <button type="button" class="btn" onclick="selectTipoProducto('1')">Joyas</button>
            <button type="button" class="btn" onclick="selectTipoProducto('2')">Ambos</button>
        </div>

        <hr>

        <div id="reportContent" class="mt-4">
            <embed id="pdfEmbed" src="" type="application/pdf" width="100%" height="600px" />
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/izitoast/dist/js/iziToast.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script>
        function cargarSucursales() {
            $.ajax({
                url: 'Services/ReporteService.php',
                type: 'POST',
                data: { accion: 'listarsucursales' },
                success: function(response) {
                    const data = JSON.parse(response);
                    if (data.status === 'success') {
                        const sucursales = data.data;
                        var sucursalDropdown = $('#Sucursal');
                        sucursalDropdown.empty();
                        sucursalDropdown.append('<option selected="selected" value="">--Seleccione una Sucursal--</option>');
                        sucursales.forEach(function(sucursal) {
                            sucursalDropdown.append('<option value="' + sucursal.Sucu_Id + '">' + sucursal.Sucu_Nombre + '</option>');
                        });
                    } else {
                        iziToast.error({
                            title: 'Error',
                            message: 'No se pudieron cargar las sucursales. Inténtelo de nuevo más tarde.',
                        });
                    }
                },
                error: function(error) {
                    iziToast.error({
                        title: 'Error',
                        message: 'Error en la solicitud. Inténtelo de nuevo más tarde.',
                    });
                }
            });
        }

        cargarSucursales();

        let selectedTipoProducto = '';

        function selectTipoProducto(tipo) {
            selectedTipoProducto = tipo;
            const buttons = $('#tipoProductoButtons').find('.btn');
            buttons.removeClass('selected');
            const selectedButton = buttons.eq(tipo);
            selectedButton.addClass('selected');
        }

        async function generateReport() {
            const selectedSucursalId = $('#Sucursal').val();
            if (!selectedSucursalId) {
                iziToast.error({
                    title: 'Error',
                    message: 'Por favor, seleccione una sucursal para generar el reporte.',
                });
                return;
            }

            if (selectedTipoProducto === '') {
                iziToast.error({
                    title: 'Error',
                    message: 'Por favor, seleccione un tipo de producto antes de generar el reporte.',
                });
                return;
            }

            // Guardar el ID de la sucursal en la sesión
            $.ajax({
                url: 'Services/ReporteService.php',
                type: 'POST',
                data: { 
                    accion: 'reportecontrolstock',
                    TipoProducto: selectedTipoProducto,
                    Sucu_Id: selectedSucursalId // Guardar el ID de la sucursal en la sesión
                },
                success: function(response) {
                    const data = JSON.parse(response);
                    if (data.status === 'success') {
                        const reportData = data.data;
                        if (reportData.length > 0) {
                            generatePDF(reportData);
                        } else {
                            iziToast.info({
                                title: 'Información',
                                message: 'No se encontraron datos para el reporte.',
                            });
                        }
                    } else {
                        iziToast.error({
                            title: 'Error',
                            message: 'Error al generar el reporte. Inténtelo de nuevo más tarde.',
                        });
                    }
                },
                error: function(error) {
                    iziToast.error({
                        title: 'Error',
                        message: 'Error en la solicitud. Inténtelo de nuevo más tarde.',
                    });
                }
            });
        }

        function generatePDF(data) {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    const logoBase64 = 'Views/Logo.png';

    // Agregar el logo
    doc.addImage(logoBase64, 'PNG', 10, 10, 50, 20); 

    // Descripción de la sucursal, empleado y fecha
    const sucursal = 'Sucursal: Centro';
    const empleado = 'Empleado: Juan Pérez';
    const fecha = `Fecha: ${new Date().toLocaleDateString()}`;

    doc.setFontSize(12);
    doc.setTextColor(0, 0, 0);
    doc.text(sucursal, 70, 15); // Ajusta las posiciones según sea necesario
    doc.text(empleado, 70, 20);
    doc.text(fecha, 70, 25);

    // Título del reporte
    doc.setFontSize(18);
    doc.setTextColor(255, 255, 255);
    doc.setFillColor(0, 123, 255); // Azul
    doc.rect(10, 40, 190, 10, 'F'); // Ajusta la posición del rectángulo
    doc.text('Reporte de Control de Stock', 105, 47, null, null, 'center'); // Ajusta la posición del texto

    // Encabezado de la tabla
    doc.setFontSize(12);
    doc.setTextColor(255, 255, 255);
    doc.setFillColor(108, 117, 125); // Gris
    doc.rect(10, 60, 190, 10, 'F'); // Ajusta la posición del encabezado

    doc.rect(10, 60, 60, 10, 'F'); // Categoría
    doc.text('Categoría', 12, 67);
    doc.rect(70, 60, 70, 10, 'F'); // Producto
    doc.text('Producto', 72, 67);
    doc.rect(140, 60, 60, 10, 'F'); // Stock
    doc.text('Stock', 142, 67);

    let yPosition = 77;
    doc.setTextColor(0, 0, 0); // Negro

    doc.setLineWidth(0.1);
    data.forEach(row => {
        doc.line(10, yPosition - 7, 200, yPosition - 7);
        doc.line(10, yPosition + 3, 200, yPosition + 3);
        doc.line(10, yPosition - 7, 10, yPosition + 3);
        doc.line(70, yPosition - 7, 70, yPosition + 3);
        doc.line(140, yPosition - 7, 140, yPosition + 3);
        doc.line(200, yPosition - 7, 200, yPosition + 3);

        doc.text(`${row.Categoria}`, 12, yPosition);
        doc.text(`${row.Producto}`, 72, yPosition);
        doc.text(`${row.Stock}`, 142, yPosition);
        yPosition += 10;
        if (yPosition > 280) {
            doc.addPage();
            yPosition = 20;
        }
    });

    const pdfData = doc.output('datauristring');
    $('#pdfEmbed').attr('src', pdfData);
}


    </script>
</body>
</html>
