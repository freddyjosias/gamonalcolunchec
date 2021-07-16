$(document).ready(function() {

    let baseURL = 'http://localhost/licorlandsorftware/';

    var peticion = true;

    $('#proveedor').keypress(function (e) {
        console.log($('#proveedor').val());
        if (e.charCode == 13 && peticion && $('#proveedor').val() != '') 
        {
            e.preventDefault()
            peticion = false;
            dni = $('#proveedor').val();
            //console.log($('#documento option[value=DNI]').attr("selected",true));
            
            if (dni == 0) 
            {
                $('#proveedor').val('PROVEEDORES VARIOS');
                $('#numerodoc').val('0');
                peticion = true;
            } 
            else 
            {

                var rucRequest = $.ajax({

                    url: 'https://dniruc.apisperu.com/api/v1/ruc/' + dni + '?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6ImZqb3NpYXNoYkBnbWFpbC5jb20ifQ.8sYqyZS5UCx4hGTUPdgV08nIUHryye3C7M44TjyYzLM',
                    method: "GET",
                    dataType: "json"
        
                });
                
                rucRequest.done(function(msg) {
    
                    if (msg.success == false) {
                        $('.alertas').html('<div class="alert alert-danger" role="alert">No se encontraron datos con el DNI/RUC ingresado</div>');
                        $('#proveedor').val('PROVEEDORES VARIOS');
                        $('#numerodoc').val('0');
                    } else {
                        $('.alertas').html('');
    
                        $('#proveedor').val(msg.razonSocial);
                        $('#numerodoc').val('0');
                    }               
    
                    peticion = true;
    
                });
                
                rucRequest.fail(function( jqXHR, textStatus ) {
                    
                    $('.alertas').html('<div class="alert alert-danger" role="alert">No se encontraron datos con el DNI/RUC ingresado</div>');
                    peticion = true;
                    
                });
            }
        } 
        else 
        {
            $('.alertas').html('');
        }
    })

    function buscarProducto(e, tagCodigo, codigo) 
    {
        let enterKey = 13;
        let idCompra = $('#id_compra').val();

        if (codigo != '') 
        {
            if (e.which == enterKey) 
            {
                $.ajax({
                    url: baseURL + '/productos/buscarporcodigo/' + codigo + '/' + idCompra,
                    dataType: 'json',
                    success:function (resp) {
                        
                        if (resp == 0) 
                        {
                            $(tagCodigo).val('');
                        }
                        else
                        {
                            $(tagCodigo).removeClass('has-error');

                            $('#res_error').html(resp.error);

                            if (resp.existe) 
                            {
                                $('#id_producto').val(resp.datos.producto_id);
                                $('#nombre').val(resp.datos.producto_nombre);
                                $('#cantidad').val(1);
                                $('#precio_compra').val(resp.datos.producto_preciocompra);
                                $('#precio_venta').val(resp.datos.producto_precioventa);
                                $('#subtotal').val(resp.datos.producto_preciocompra);
                                $('#cantidad').focus();
                            }
                            else
                            {
                                $('#codigo').val('');
                                $('#id_producto').val('');
                                $('#nombre').val('');
                                $('#cantidad').val('');
                                $('#precio_compra').val('');
                                $('#subtotal').val('');
                            }
                        }
                    }
                });
            }
        }
    }

    function agregarProducto(idProducto, cantidad, idCompra) 
    {
        if (idProducto != null && idProducto != 0  && cantidad > 0) 
        {
            $.ajax({
                url: baseURL + '/temporalcompra/insertar/' + idProducto + '/' + cantidad + '/' + idCompra,
                dataType: 'json',
                success:function (resp) {

                    actualizarTabla(resp) 
                    
                }
            });
        }
    }

    function actualizarTabla(resp, borrar = false) 
    {
        if (resp != 0) 
        { 
            if (resp.error == '') 
            {
                $('#tableproducto tbody').empty();
                $('#tableproducto tbody').append(resp.datos);
                $('.label_total').html(resp.total);
                $('#total').val(resp.totalinput);
                
                if (!borrar) {
                    $('#codigo').val('');
                    $('#id_producto').val('');
                    $('#nombre').val('');
                    $('#cantidad').val('');
                    $('#precio_compra').val('');
                    $('#precio_venta').val('');
                    $('#subtotal').val('');
                    $('#codigo').focus();
                }
                
            }
        }
    }

    function eliminarProducto(idProducto, idCompra, explote = false) 
    {
        let urlAjax;

        if (explote == true) {
            urlAjax = baseURL + '/temporalcompra/eliminar/' + idProducto + '/' + idCompra + '/true';
        } else {
            urlAjax = baseURL + '/temporalcompra/eliminar/' + idProducto + '/' + idCompra;
        }

        $.ajax({
            url: urlAjax,
            dataType: 'json',
            success:function (resp) {
                
                if (resp != 0) 
                { 
                    if (resp.error == '') 
                    {
                        $('#tableproducto tbody').empty();
                        $('#tableproducto tbody').append(resp.datos);
                        $('.label_total').html(resp.total);
                        $('#total').val(resp.totalinput);
                        $('#codigo').focus();
                        
                    }
                }
            }
        });
    }

    $('#codigo').keyup(function (e) {

        buscarProducto(e, $(this), $(this).val());

    });

    $('#btn-addproducto').click(function () {
        
        let idProducto = $('#id_producto').val();
        let cantidad = $('#cantidad').val();
        let idCompra = $(this).attr('data-idcompra');

        agregarProducto(idProducto, cantidad, idCompra);

    });

    $(document).on("click", ".btn-deleteProducto", function(e) {
        
        let idProducto = $(this).attr('data-idproducto');
        let idCompra = $(this).attr('data-idcompra');

        eliminarProducto(idProducto, idCompra);

    });

    $(document).on("click", ".btn-exploteProducto", function(e) {
        
        let idProducto = $(this).attr('data-idproducto');
        let idCompra = $(this).attr('data-idcompra');

        eliminarProducto(idProducto, idCompra, true);

    });

    $('#completa_compra').click(function() {
        
        let nFila = $('#tableproducto tr').length;
        let proveDoc = $('#proveedor').val().length;
        let numeroDoc = $('#numerodoc').val().length;
        let fechaDoc = $('#fechadoc').val().length;
        let tipoDoc = $('#tipodoc').val().length;
        let igvDoc = $('#igv').val().length;

        if (nFila < 2 || proveDoc == 0 || numeroDoc == 0 || fechaDoc == 0 || tipoDoc == 0 || igvDoc == 0) 
        {

        }
        else
        {
            $('#form_compra').submit();
        }

    })

    $('#cantidad').keyup(function () {
        
        let newCantidad = $('#cantidad').val();
        newCantidad = parseInt(newCantidad);
        $('#subtotal').val(newCantidad * $('#precio_compra').val());

    })
    
    let actualizarCompra = $('.actualizar_compra').html();
    
    if (actualizarCompra == 'SI') 
    {
        let idCompras = $('#id_compra').val();

        e = jQuery.Event('keypress');
        e.which = 13;

        buscarProducto(e, $('#codigo'), $('#codigo').val());
        
        $.ajax({
            url: baseURL + '/temporalcompra/actualizartabla/' + idCompras,
            
            dataType: 'json',
            success: function (respa) {
                actualizarTabla(respa, true) 
            }
        });
    }

});