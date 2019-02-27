<?php
header('Content-type: text/html; charset=utf-8');

// Conta de Email no servidor de hospedagem
define('SERVIDOR', 'contato@devwilliam.com.br');

// Para onde será enviado o contato
define('DESTINO', 'rodrigo55pereira@gmail.com');

// Identifica o site que foi enviada a mensagem
define('SITE', 'DevWilliam');

var_dump($POST);
die();

// Validar se os valores foram enviados do formulário
if (isset($_POST)):

    $nome    = (isset($_POST['nome']))? $_POST['nome']: '';
    $email   = (isset($_POST['email']))? $_POST['email']: '';
    $assunto = (isset($_POST['assunto']))? $_POST['assunto']: '';
    $msg     = (isset($_POST['mensagem']))? $_POST['mensagem']: '';

    // Valida se foram preenchidos todos os campos
    if (empty($nome) || empty($email) || empty($assunto) || empty($msg)):
        $array  = array('tipo' => 'alert alert-danger', 'mensagem' => 'Preencher todo os campos obrigatórios(*)!');
        echo json_encode($array);
    else:

        // Monta a mensagem do email
        $mensagem = "Contato enviado pelo site ".SITE."\n";
        $mensagem .= "**********************************************************\n";
        $mensagem .= "Nome do Contato: ".$nome."\n";
        $mensagem .= "E-mail do Contato: ".$email."\n";
        $mensagem .= "**********************************************************\n";
        $mensagem .= "Mensagem: \n".$msg."\n";

        // Envia o e-mail e captura o retorno
        $retorno = sendEmail(DESTINO, $assunto, $mensagem);

        // Conforme o retorno da função exibe a mensagem para o usuário
        if ($retorno):
            $array  = array('tipo' => 'alert alert-success', 'mensagem' => 'Sua mensagem foi enviada com sucesso!');
            echo json_encode($array);
        else:
            $array  = array('tipo' => 'alert alert-danger', 'mensagem' => 'Infelizmente houve um erro ao enviar sua mensagem!');
            echo json_encode($array);
        endif;

    endif;
endif;

// Função para envio de e-mail usando a função nativa do PHP mail()
function sendEmail($para, $assunto, $mensagem){

    $headers = "From: ".SERVIDOR."\n";
    $headers .= "Reply-To: $para\n";
    $headers .= "Subject: $assunto\n";
    $headers .= "Return-Path: ".SERVIDOR."\n";
    $headers .= "MIME-Version: 1.0\n";
    $headers .= "X-Priority: 3\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\n";

    $retorno = mail($para, $assunto, nl2br($mensagem), $headers);
    return $retorno;
}