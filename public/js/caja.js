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
                        agregarProducto();    
                    }

                )
            }
        });

    });

});