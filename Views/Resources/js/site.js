// Please see documentation at https://docs.microsoft.com/aspnet/core/client-side/bundling-and-minification
// for details on configuring this project to bundle and minify static web assets.


// Write your JavaScript code.
var dragcontent, ci, ri;
jQuery(document).ready(function () {
   
    function reinitializeDraggable() {
        $(".dragitem").draggable({
            helper: 'clone',
            revert: 'invalid'
        });
        $(".dragitem2").draggable({
            helper: 'clone',
            revert: 'invalid'
        });
    }

   
    reinitializeDraggable();

  
    $(".pantallaPorRoles").droppable({
        accept: ".dragitem",
        drop: function (event, ui) {
            var contenido = ui.helper.text();
            var pantallaId = ui.helper.data('id');
            var newRow = $('<tr><td class="dragitem2 btn btn-dark" style="width:100%;position: relative; z-index: 40;"></td></tr>').find('td').text(contenido).attr('data-id', pantallaId).end();

            $("#tbPantRole tbody").append(newRow);
            reinitializeDraggable();

           
            $.ajax({
                url: '/Rol/AgregarPantallaPorRol',
/*                type: 'POST',*/
                data: { idPantalla: pantallaId },
                success: function (response) {
                    iziToast.success({
                        title: 'Exito',
                        message: 'Rol agregado correctamente',
                        position: 'topRight',
                        transitionIn: 'flipInX',
                        transitionOut: 'flipOutX'

                    });
                },
                error: function (error) {
                    sessionStorage.setItem('sess', 'hola');

                }
            });

            $(ui.draggable).closest('tr').remove();
        }
    });


    $(".pantalla").droppable({
        accept: ".dragitem2",
        drop: function (event, ui) {
            var contenido = ui.helper.text();
            var pantallaId = ui.helper.data('id');
            var newRow = $('<tr><td class="dragitem btn btn-dark" style="width:100%"></td></tr>').find('td').text(contenido).attr('data-id', pantallaId).end();

            $("#tbPant tbody").append(newRow);
            reinitializeDraggable();

            $.ajax({
                url: '/Rol/EliminarPantallaPorRol', 
                type: 'POST',
                data: { idPantalla: pantallaId },
                success: function (response) {
                    iziToast.success({
                        title: 'Exito',
                        message: 'Rol eliminado correctamente',
                        position: 'topRight',
                        transitionIn: 'flipInX',
                        transitionOut: 'flipOutX'

                    });
                },
                error: function (error) {
                    console.error("Error al eliminar el item", error);
                }
            });

            $(ui.draggable).closest('tr').remove();
        }
    });

    
    $(".proyectospormate").droppable({
        accept: ".dragitem",
        drop: function (event, ui) {
            var contenido = ui.helper.text();
            var materialId = ui.helper.data('id');
            var newRow = $('<tr><td class="dragitem2 btn btn-dark" style="width:100%"></td></tr>').find('td').text(contenido).attr('data-id', materialId).end();

            $("#tbProyMate tbody").append(newRow);
            reinitializeDraggable();

        
            $.ajax({
                url: '/Proyecto/AgregarMaterialPorProy',
                type: 'POST',
                data: { idMaterial: materialId },
                success: function (response) {

                    iziToast.success({
                        title: 'Exito',
                        message: 'Material agregado correctamente',
                        position: 'topRight',
                        transitionIn: 'flipInX',
                        transitionOut: 'flipOutX'

                    });

                },
                error: function (error) {
                    console.error("Error al agregar el item", error);
                }
            });

            $(ui.draggable).closest('tr').remove();
        }
    });


    $(".material").droppable({
        accept: ".dragitem2",
        drop: function (event, ui) {
            var contenido = ui.helper.text();
            var materialId = ui.helper.data('id');
            var newRow = $('<tr><td class="dragitem btn btn-dark" style="width:100%"></td></tr>').find('td').text(contenido).attr('data-id', materialId).end();

            $("#tbMate tbody").append(newRow);
            reinitializeDraggable();

            $.ajax({
                url: '/Proyecto/EliminarMaterialPorProy',
                type: 'POST',
                data: { idMaterial: materialId },
                success: function (response) {
                    iziToast.success({
                        title: 'Exito',
                        message: 'Material eliminado correctamente',
                        position: 'topRight',
                        transitionIn: 'flipInX',
                        transitionOut: 'flipOutX'

                    });
                },
                error: function (error) {
                    console.error("Error al eliminar el item", error);
                }
            });

            $(ui.draggable).closest('tr').remove();
        }
    });
  
    var etapaidprueba;
    var fechasIngresadas = false;
   
    function ObtenerIdEtapa(event, ui) {
        var contenido = ui.helper.text();
        
        if (fechasIngresadas == false) {
            etapaidprueba = ui.helper.data('id');


            var newRow = $('<tr><td class="dragitem2 btn btn-dark prueba" style="width:100%">' + contenido + '</tr>');
           
            var fecha = $('<div class="card fecha"><div class="card-body"><div class="form-row"><div class="col-md-6"><label>Fecha Inicio:</label></div><div class="col-md-6"><label>Fecha Final:</label></div></div><div class="form-row"><div class="col-md-6"><input type="date" class="form-control col-md-10 fechaInicio" /></div><div class="col-md-6"> <input type="date" class="form-control col-md-10 fechaFin" /></div></div></div><div class="card-body boton"><div class="form-row"><div class="col-md-6"><button class="btn btn-primary guardarBtn">Guardar</button></div></div></div></div>');
            var fechaInicio = $(this).closest('tr').find('.fechaInicio').val();
            newRow.append(fecha);
          
            console.log(fechaInicio);
            $("#tbProyEtap tbody").append(newRow);
            reinitializeDraggable();


            fechasIngresadas = true;
            $(ui.draggable).closest('tr').remove();
        }
        else {
            iziToast.warning({
                title: 'Advertencia',
                message: 'Porfavor termine de registrar la etapa',
                position: 'topRight',
                transitionIn: 'flipInX',
                transitionOut: 'flipOutX'

            });
        }
    }
  

    $(".proyectosporetap").droppable({
        accept: ".dragitem",
        drop: ObtenerIdEtapa
    });


    $(document).on('click', '.guardarBtn', function () {
        var etapaId = etapaidprueba;
        console.log(etapaId)
        var fechaInicio = $(this).closest('tr').find('.fechaInicio').val();
        var fechaFin = $(this).closest('tr').find('.fechaFin').val();

        if (fechaFin < fechaInicio) {

          
            iziToast.warning({
                title: 'Advertencia',
                message: 'Porfavor Ingrese una fecha valida',
                position: 'topRight',
                transitionIn: 'flipInX',
                transitionOut: 'flipOutX'

            });
        }
        else {
            $.ajax({
                url: '/Proyecto/AgregarEtapaPorProy',
                type: 'POST',
                data: {
                    idEtapa: etapaId,
                    fechaInicio: fechaInicio,
                    fechaFin: fechaFin
                },
                success: function (response) {
                 
                        iziToast.success({
                            title: 'Exito',
                            message: 'Etapa agregada correctamente',
                            position: 'topRight',
                            transitionIn: 'flipInX',
                            transitionOut: 'flipOutX'

                        });
                },
                error: function (error) {
                    console.error("Error al guardar", error);
                }
            });


            $(".fecha").hide();

            fechasIngresadas = false;
        }

         
              
    });
  
  

    $(".etapa").droppable({
        accept: ".dragitem2",
        drop: function (event, ui) {
            var contenido = ui.helper.text();
            var etapasId = ui.helper.data('id');
            var newRow = $('<tr><td class="dragitem btn btn-dark" style="width:100%"></td></tr>').find('td').text(contenido).attr('data-id', etapasId).end();

            $("#tbEtap tbody").append(newRow);
            reinitializeDraggable();

            $.ajax({
                url: '/Proyecto/EliminarEtapaPorProy',
                type: 'POST',
                data: { idEtapa: etapasId },    
                success: function (response) {
                    iziToast.success({
                        title: 'Exito',
                        message: 'Etapa eliminada correctamente',
                        position: 'topRight',
                        transitionIn: 'flipInX',
                        transitionOut: 'flipOutX'

                    });
                },
                error: function (error) {
                    console.error("Error al eliminar el item", error);
                }
            });

            $(ui.draggable).closest('tr').remove();
        }
    });

   
    $(".proyectosporempl").droppable({
        accept: ".dragitem",
        drop: function (event, ui) {
            var contenido = ui.helper.text();
            var empleadoId = ui.helper.data('id');
            var newRow = $('<tr><td class="dragitem2 btn btn-dark" style="width:100%"></td></tr>').find('td').text(contenido).attr('data-id', empleadoId).end();

            $("#tbProyEmpl tbody").append(newRow);
            reinitializeDraggable();

           
            $.ajax({
                url: '/Proyecto/AgregarEmpleadoPorProy',
                type: 'POST',
                data: { idEmpleado: empleadoId },
                success: function (response) {
                    iziToast.success({
                        title: 'Exito',
                        message: 'Empleado agregado correctamente',
                        position: 'topRight',
                        transitionIn: 'flipInX',
                        transitionOut: 'flipOutX'

                    });
                },
                error: function (error) {
                    console.error("Error al agregar el item", error);
                }
            });

            $(ui.draggable).closest('tr').remove();
        }
    });


    $(".empleado").droppable({
        accept: ".dragitem2",
        drop: function (event, ui) {
            var contenido = ui.helper.text();
            var empleadoId = ui.helper.data('id');
            var newRow = $('<tr><td class="dragitem btn btn-dark" style="width:100%"></td></tr>').find('td').text(contenido).attr('data-id', empleadoId).end();

            $("#tbEmpl tbody").append(newRow);
            reinitializeDraggable();

            $.ajax({
                url: '/Proyecto/EliminarEmplPorProy',
                type: 'POST',
                data: { idEmpleado: empleadoId },
                success: function (response) {
                    iziToast.success({
                        title: 'Exito',
                        message: 'Empleado eliminado correctamente',
                        position: 'topRight',
                        transitionIn: 'flipInX',
                        transitionOut: 'flipOutX'

                    });
                },
                error: function (error) {
                    console.error("Error al eliminar el item", error);
                }
            });

            $(ui.draggable).closest('tr').remove();
        }
    });
});
