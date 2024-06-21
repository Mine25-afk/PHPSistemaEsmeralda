
    
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
        <iframe id="pdfViewer" style="width:100%; height:600px;"></iframe>

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
        const doc = new jsPDF({
            orientation: 'portrait',
            unit: 'px',
            format: 'letter'
        });

        const img = new Image();
        img.src = 'Views/Logo.png';

        doc.addImage(img, 'PNG', 10, 10, 200, 50);

        doc.setFontSize(10);
        doc.setFont(undefined, 'bold');
        doc.text('Esmeraldas HN', 280, 30);

        doc.setFontSize(10);
        doc.setFont(undefined, 'normal');
        doc.text('Dirección :', 280, 40);
        doc.text("Tegucigalpa: Los dolores, calle buenos aires", 280, 50);

        const fechaActual = new Date().toLocaleDateString();

        doc.setFontSize(12);
        doc.setFont(undefined, 'bold');
        doc.text("Fecha Inicio: " + fechaActual, 32, 120);
        doc.text("Fecha Final: " + fechaActual, 32, 135);

        doc.setFontSize(16);
        doc.setFont(undefined, 'bold');
        doc.text("Reporte de Control de Stock", 105, 90, null, null, 'center');

        let yPosition = 160;
        doc.setFontSize(12);
        doc.setTextColor(255, 255, 255);
        doc.setFillColor(108, 117, 125); // Gris para el encabezado
        doc.rect(10, yPosition - 10, 580, 10, 'F');
        doc.text('Categoría', 20, yPosition);
        doc.text('Producto', 200, yPosition);
        doc.text('Stock', 400, yPosition);

        yPosition += 20;
        doc.setTextColor(0, 0, 0); // Negro para el contenido

        data.forEach(row => {
            doc.line(10, yPosition - 10, 580, yPosition - 10);
            doc.line(10, yPosition + 10, 580, yPosition + 10);
            doc.line(10, yPosition - 10, 10, yPosition + 10);
            doc.line(200, yPosition - 10, 200, yPosition + 10);
            doc.line(400, yPosition - 10, 400, yPosition + 10);
            doc.line(580, yPosition - 10, 580, yPosition + 10);

            doc.text(`${row.Categoria}`, 20, yPosition);
            doc.text(`${row.Producto}`, 200, yPosition);
            doc.text(`${row.Stock}`, 400, yPosition);
            yPosition += 20;
            if (yPosition > 700) {
                doc.addPage();
                yPosition = 20;
            }
        });

        const user = "<?php echo $_SESSION['Empl_Nombre']; ?>"; // Obtén el nombre del empleado de alguna manera
        const currentDate = new Date().toISOString().split('T')[0];
        const pageHeight = doc.internal.pageSize.height;
        doc.text(`Emitido por: ${user}`, 32, pageHeight - 30);
        doc.text(`Fecha: ${currentDate}`, 32, pageHeight - 15);

        const totalPages = doc.internal.getNumberOfPages();
        for (let i = 1; i <= totalPages; i++) {
            doc.setPage(i);
            doc.setFontSize(10);
            doc.text(`Página ${i} de ${totalPages}`, doc.internal.pageSize.width - 80, pageHeight - 15);
        }

        const string = doc.output('datauristring');
        const iframe = document.getElementById('pdfViewer');
        if (iframe) {
            iframe.src = string;
        } else {
            console.error("El elemento 'pdfViewer' no se encontró en el DOM.");
        }
    }
</script>


    </script>
</body>
</html>
