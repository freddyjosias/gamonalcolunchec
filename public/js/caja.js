$(document).ready(function() {

    $('#cliente').keyup(function (e) {

        $('#cliente').autocomplete({
            source: '../clientes/autocompletedata',
            minLenght: 3,
            select: function (event, ui) {
                
                event.preventDefault();
                $('#id_cliente').val(ui.item.id);
                $('#cliente').val(ui.item.value);
            }
        });

    });

    $('#codigo').keyup(function (e) {

        $('#codigo').autocomplete({
            source: '../productos/autocompletedata',
            minLenght: 3,
            select: function (event, ui) {
                
                event.preventDefault();
                $('#codigo').val(ui.item.value);
                
                setTimeout(

                    function () 
                    {
                        e = jQuery.Event('keypress');
                        e.which = 13;
                        let idCompra = $('.input-codpro').attr('data-idcompra');
                        agregarProducto(e, ui.item.id, 1, idCompra);
                    }

                )
            }
        });

    });

    function agregarProducto(e, id_producto, cantidad, id_venta)
    {
        let enterkey = 13;
        if (codigo != '') 
        {
            if (e.which == enterkey) 
            { 
                if (id_producto != null && id_producto != 0 && cantidad >0) 
                {
                    $.ajax({
                        url: '../temporalcompra/insertar/' + id_producto + '/' + cantidad + '/' + id_venta,
                        
                        success:function (resp) {
                            
                            if (resp == 0) 
                            { 
                            }
                            else
                            {
                                var resp = JSON.parse(resp);

                                if (resp.error == '') 
                                {
                                    $('#tableproducto tbody').empty();
                                    $('#tableproducto tbody').append(resp.datos);
                                    $('.label_total').html(resp.total);
                                    $('#total').val(resp.totalinput);
                                    $('#codigo').focus();
                                    
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
    }

    $(document).on("click", ".btn-deleteProducto", function(e) {
        
        let idProducto = $(this).attr('data-idproducto');
        let idCompra = $(this).attr('data-idcompra');

        eliminarProducto(idProducto, idCompra);

    });

    function eliminarProducto(idProducto, id_venta) 
    {
        $.ajax({
            url: '../temporalcompra/eliminar/' + idProducto + '/' + id_venta,
            dataType: 'json',
            success:function (resp) {
                
                if (resp != 0) 
                { 
                    if (resp.error == '') 
                    {
                        $('#tableproducto tbody').empty();
                        $('#tableproducto tbody').append(resp.datos);
                        $('#total').val(resp.total);
                        
                    }
                }
            }
        });
    }

    $('#completa_venta').click(function () {
        
        let nFilas = $('#tableproducto tr').length;
        
        if (nFilas < 2) 
        {
            alert('Debe de agregar un producto');
        }
        else
        {
            $('#form_venta').submit();
        }

    });

});