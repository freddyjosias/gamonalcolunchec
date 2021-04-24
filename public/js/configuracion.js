$(document).ready(function() {

    let imgSelecionada = '';

    $('#tienda_logo').change(function () {
        
        if ($('#tienda_logo')[0].files.length) 
        {
            imgSelecionada = $('#tienda_logo')[0].files[0].name;
            $('.configuracion_filename').html('<p class="text-white text-center mt-2 p-1 font-weight-bold rounded bg-primary">' + imgSelecionada + '</p>');
        }
        else
        {
            imgSelecionada = '';
            $('.configuracion_filename').html('');
        }

        
        
    });

});