$(document).ready(function() {

    function buscarProducto(e, tagCodigo, codigo) 
    {
        let enterKey = 13;

        if (codigo != '') 
        {
            if (e.which == enterKey) 
            {
                $.ajax({
                    url: '../productos/buscarporcodigo/' + codigo,
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
                url: '../temporalcompra/insertar/' + idProducto + '/' + cantidad + '/' + idCompra,
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
                            
                            $('#id_producto').val('');
                            $('#nombre').val('');
                            $('#cantidad').val('');
                            $('#precio_compra').val('');
                            $('#subtotal').val('');
                            $('#codigo').focus();
                        }
                    }
                }
            });
        }
    }

    function eliminarProducto(idProducto, idCompra) 
    {
        $.ajax({
            url: '../temporalcompra/eliminar/' + idProducto + '/' + idCompra,
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

    $('#completa_compra').click(function() {
        
        let nFila = $('#tableproducto tr').length;

        if (nFila < 2) 
        {

        }
        else
        {
            $('#form_compra').submit();
        }

    })

});