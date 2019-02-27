<?php
header('Content-type: text/html; charset=utf-8');

// Conta de Email no servidor de hospedagem
define('SERVIDOR', 'smtp.gmail.com');

// Para onde será enviado o contato
define('DESTINO', 'rodrigo55pereira@gmail.com');

// Validar se os valores foram enviados do formulário
if (isset($_POST)):

    $nome    = (isset($_POST['nome']))? $_POST['nome']: '';
    $email   = (isset($_POST['email']))? $_POST['email']: '';
    $telefone = (isset($_POST['fone']))? $_POST['fone']: '';
    $msg     = (isset($_POST['mensagem']))? $_POST['mensagem']: '';

    // Valida se foram preenchidos todos os campos
    if (empty($nome) || empty($email) || empty($telefone) || empty($msg)):
        $array  = array('tipo' => 'alert alert-danger', 'mensagem' => 'Preencher todo os campos obrigatórios(*)!');
        echo json_encode($array);
    else:

        // Monta a mensagem do email
        $mensagem = "Contato enviado:" ."\n";
        $mensagem .= "**********************************************************\n";
        $mensagem .= "Nome do Contato: ".$nome."\n";
        $mensagem .= "E-mail do Contato: ".$email."\n";
        $mensagem .= "Telefone do Contato: ".$telefone."\n";
        $mensagem .= "**********************************************************\n";
        $mensagem .= "Mensagem: \n".$msg."\n";

        // Envia o e-mail e captura o retorno
        $retorno = sendEmail(DESTINO, $mensagem);

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
function sendEmail($para, $mensagem){

    $headers = "From: ".SERVIDOR."\n";
    $headers .= "Reply-To: $para\n";
    $headers .= "Subject: Email de contato: \n";
    $headers .= "Return-Path: ".SERVIDOR."\n";
    $headers .= "MIME-Version: 1.0\n";
    $headers .= "X-Priority: 3\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\n";

    $retorno = mail($para, "Email de contato", nl2br($mensagem), $headers);
    return $retorno;
}