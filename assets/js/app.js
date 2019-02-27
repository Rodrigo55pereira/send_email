$('document').ready(function(){

    $('#formulario').submit(function(){
        var dadosFormulario = $('#formulario').serialize();
        console.log(dadosFormulario);
        $.ajax({
            type : 'POST',
            url  : 'send_email.php',
            data : dadosFormulario,
            dataType: 'json',
            success: function(response){
                $('#mensagem').css('display', 'block').removeClass().addClass(response.tipo).html('').html('<p>' + response.mensagem + '</p>');
            }
        });
        return false;
    });
});