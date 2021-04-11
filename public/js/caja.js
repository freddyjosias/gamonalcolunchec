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
                        agregarProducto(e, id_producto, cantidad, id_venta); {   
                        let enterkey = 13;
                        if (codigo != '') {
                            if (e.whitch == enterkey) {
                                if (id_producto != null && id_producto != 0 && cantidad >0) {
                                    $.ajax({
                                        url: '<?php echo base_url(); ?>/temporalcompra/inserta/' + id_Producto + '/' + cantidad,
                                        
                                        success:function (resultado) {
                                            
                                            if (resultado == 0) 
                                            { 
                                            }else{
                                                var resultado = JSON.parse(resultado);
                                                if (resultado.error == '') 
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

                )
            }
        });

    });

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
                    $('#tableproducto tbody').append(resultado.datos);
                    $('#total').val(resultado.total);
                    
                }
            }
        }
    });
}
$(function(){
    $('#completa_venta').click(function(){
let nFilas = $('#tablaProductos tr').length;
        if (nFilas < 2) {

        } else {
            
        }
    });
});