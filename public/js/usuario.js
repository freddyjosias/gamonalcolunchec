$(document).ready(function() {

    let baseURL = 'http://localhost/gamonalcolunchec/';

    var peticion = true;

    $('#dni').keypress(function (e) {
        
        if (e.charCode == 13 && peticion && $('#dni').val() != '') 
        {
            e.preventDefault()
            peticion = false;
            dni = $('#dni').val();
            //console.log($('#documento option[value=DNI]').attr("selected",true));

            $('.alertas').html('<div class="alert alert-warning" role="alert">Buscando DNI/RUC...</div>');
            
            var request = $.ajax({

                url: 'https://dniruc.apisperu.com/api/v1/dni/' + dni + '?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6ImZqb3NpYXNoYkBnbWFpbC5jb20ifQ.8sYqyZS5UCx4hGTUPdgV08nIUHryye3C7M44TjyYzLM',
                method: "GET",
                dataType: "json"
    
            });
            
            request.done(function(msg) {

                if (msg.success == false) {
                    $('.alertas').html('<div class="alert alert-danger" role="alert">No se encontraron datos con el DNI/RUC ingresado</div>');
                    $('#direccion').val('');
                    $('#nombre').val('');
                } else {
                    $('.alertas').html('');
                    $('#direccion').val('');

                    $('#nombre').val(msg.nombres + ' ' + msg.apellidoPaterno + ' ' + msg.apellidoMaterno);
                    
                    $('#default_select').removeAttr('selected');
                    $('#ruc_select').removeAttr('selected');
                    $('#dni_select').attr('selected', true);
                }
                
                peticion = true;

            });
            
            request.fail(function( jqXHR, textStatus ) {

                var rucRequest = $.ajax({

                    url: 'https://dniruc.apisperu.com/api/v1/ruc/' + dni + '?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6ImZqb3NpYXNoYkBnbWFpbC5jb20ifQ.8sYqyZS5UCx4hGTUPdgV08nIUHryye3C7M44TjyYzLM',
                    method: "GET",
                    dataType: "json"
        
                });
                
                rucRequest.done(function(msg) {

                    console.log(msg)
                    if (msg.success == false) {
                        $('.alertas').html('<div class="alert alert-danger" role="alert">No se encontraron datos con el DNI/RUC ingresado</div>');
                        $('#nombre').val('');
                        $('#direccion').val('');
                    } else {
                        $('.alertas').html('');

                        $('#nombre').val(msg.razonSocial);
                        $('#direccion').val(msg.direccion);
                        
                        $('#default_select').removeAttr('selected');
                        $('#dni_select').removeAttr('selected');
                        $('#ruc_select').attr('selected', true);
                    }
                    
                    peticion = true;
    
                });
                
                rucRequest.fail(function( jqXHR, textStatus ) {

                    $('#nombre').val('');
                    $('#direccion').val('');
                    
                    $('.alertas').html('<div class="alert alert-danger" role="alert">No se encontraron datos con el DNI/RUC ingresado</div>');
                    peticion = true;
                    
                });
                
            });
        } 
        else 
        {
            $('.alertas').html('');
        }
    })

});