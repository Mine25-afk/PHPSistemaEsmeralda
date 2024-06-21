<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.3.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.13/jspdf.plugin.autotable.min.js"></script>
    <style>
        .custom-date-input {
            font-size: 20px;
            height: 50px;
            padding: 10px;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row mt-2">
            <div class="col-12">
                <div class="card">
                    <h2 class="text-center" style="font-size: 90px !important">Ventas por Mayoristas</h2>
                    <div class="card-body">
                        <div class="form-row" style="justify-content: center; margin: 0px 10px">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Fecha Inicio</label>
                                    <input type="date" id="fechaInicio" class="form-control custom-date-input" value="<?php echo date('Y-m-01'); ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Fecha Fin</label>
                                    <input type="date" id="fechaFinal" class="form-control custom-date-input" value="<?php echo date('Y-m-d'); ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-12">
                            <iframe id="pdfViewer" style="width:100%; height:700px;" frameborder="0"></iframe>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

    <script>
        document.getElementById('fechaInicio').addEventListener('change', generarReporte);
        document.getElementById('fechaFinal').addEventListener('change', generarReporte);

        window.onload = generarReporte;

        async function generarReporte() {
            const fechaInicio = document.getElementById('fechaInicio').value;
            const fechaFinal = document.getElementById('fechaFinal').value;

            const response = await fetch('Services/ReporteService.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `accion=reporteventasmayoristas&FechaInicio=${fechaInicio}&FechaFinal=${fechaFinal}`
            });

            const data = await response.json();
            if (data.status === 'success') {
                generarPDF(data.data, fechaInicio, fechaFinal);
            } else {
                alert(data.message);
            }
        }

        function generarPDF(detalles, fechaInicio, fechaFinal) {
            const {
                jsPDF
            } = window.jspdf;
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

            doc.setFontSize(12);
            doc.setFont(undefined, 'bold');
            doc.text("Fecha Inicio: " + fechaInicio, 32, 120);
            doc.text("Fecha Final: " + fechaFinal, 32, 135);

            doc.setFontSize(16);
            doc.setFont(undefined, 'bold');
            doc.text("Reporte de Ventas por Mayoristas", 120, 90);

            let total = 0;

            doc.autoTable({
                head: [
                    ['Categoria', 'Producto', 'Cantidad', 'Precio', 'Total']
                ],
                body: detalles.map(detalle => {
                    const totalProducto = detalle.Cantidad * detalle.Precio_Unitario;
                    total += totalProducto;
                    return [
                        detalle.Categoria,
                        detalle.Producto,
                        detalle.Cantidad.toString(),
                        detalle.Precio_Unitario,
                        totalProducto
                    ];
                }),
                startY: 160,
                styles: {
                    fontSize: 10,
                },
                headStyles: {
                    fillColor: [0, 0, 0],
                    textColor: [255, 255, 255],
                    halign: 'center',
                    valign: 'middle',
                    fontStyle: 'bold',
                },
                columnStyles: {
                    0: {
                        halign: 'center'
                    },
                    1: {
                        halign: 'center'
                    },
                    2: {
                        halign: 'center'
                    },
                    3: {
                        halign: 'center'
                    },
                    4: {
                        halign: 'center'
                    }
                },
                theme: 'grid'
            });

            doc.setFontSize(12);
            doc.setFont(undefined, 'bold');
            doc.text("Total: " + total.toFixed(2), 360, doc.previousAutoTable.finalY + 20);

            const user = "<?php echo $_SESSION['Empl_Nombre']; ?>";
            const currentDate = new Date().toISOString().split('T')[0];
            const pageHeight = doc.internal.pageSize.height;
            

            const totalPages = doc.internal.getNumberOfPages();
            for (let i = 1; i <= totalPages; i++) {
                doc.setPage(i);
                doc.setFontSize(10);
                doc.text(`Página ${i} de ${totalPages}`, doc.internal.pageSize.width - 80, pageHeight - 15);

                doc.text(`Emitido por: ${user}`, 32, pageHeight - 25);
                doc.text(`Fecha: ${currentDate}`, 32, pageHeight - 15);
            }

            const string = doc.output('datauristring');
            const iframe = document.getElementById('pdfViewer');
            iframe.src = string;
        }
    </script>
</body>