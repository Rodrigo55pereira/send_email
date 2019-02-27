$('document').ready(function(){

    $('#formulario').submit(function(){
        let dados = $('#fomulario').serialize();

        $.ajax({
            type : 'POST',
            url  : 'send_email.php',
            data : dados,
            success: function(response){
                $('#mensagem').css('display', 'block').removeClass().addClass(response.tipo).html('').html('<p>' + response.mensagem + '</p>');
            }
        });
        return false;
    });
});