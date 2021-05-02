$(document).ready(function() {

    let baseURL = 'http://localhost/gamonalcolunche/public';

    $('#cliente').keyup(function (e) {

        $('#cliente').autocomplete({
            source: baseURL + '/clientes/autocompletedata',
            minLenght: 3,
            select: function (event, ui) {
                
                autocomple(event, ui) 
            }
        });

    });

    $('#apellido').keyup(function (e) {

        $('#apellido').autocomplete({
            source: baseURL + '/clientes/autocompletedata/apellido',
            minLenght: 3,
            select: function (event, ui) {

                autocomple(event, ui) 
                
            }
        });

    });

    $('#dni').keyup(function (e) {

        $('#dni').autocomplete({
            source: baseURL + '/clientes/autocompletedata/dni',
            minLenght: 3,
            select: function (event, ui) {

                autocomple(event, ui) 
                
            }
        });

    });

    function autocomple(event, ui) 
    {
        event.preventDefault();
            $('#id_cliente').val(ui.item.id);
            $('#idcli').val(ui.item.id);
            $('#cliente').val(ui.item.nombre);
            $('#apellido').val(ui.item.apellido);
            $('#dni').val(ui.item.dni);
            $('#documento').val(ui.item.documento);
            $('#telefono').val(ui.item.telefono);
            $('#direccion').val(ui.item.direccion);
            $('#correo').val(ui.item.correo);
    }

    $('#edit_user').click(function () {
        
        location.href = baseURL + "/clientes/editar/" + $('#id_cliente').val() + '/null/' + $('#id_venta').val();

    })

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
                        let cantidad = parseInt($('#cantidad').val());

                        if (!cantidad > 0) 
                        {
                            cantidad = 1;
                        }

                        agregarProducto(e, ui.item.id, cantidad, idCompra);
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
                if (id_producto != null && id_producto != 0 && cantidad > 0) 
                {
                    $.ajax({
                        url: baseURL + '/temporalcompra/insertar/' + id_producto + '/' + cantidad + '/' + id_venta + '/true',
                        
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
                                    $('#precio_compra').val('');
                                    $('#subtotal').val('');
                                }
                                    
                                $('#res_error').html(resp.error);
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

    $(document).on("click", ".btn-exploteProducto", function(e) {
        
        let idProducto = $(this).attr('data-idproducto');
        let idCompra = $(this).attr('data-idcompra');

        eliminarProducto(idProducto, idCompra, true);

    });

    function eliminarProducto(idProducto, id_venta, explote = false) 
    {
        let urlAjax;

        if (explote == true) {
            urlAjax = baseURL + '/temporalcompra/eliminar/' + idProducto + '/' + id_venta + '/true';
        } else {
            urlAjax = baseURL + '/temporalcompra/eliminar/' + idProducto + '/' + id_venta;
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