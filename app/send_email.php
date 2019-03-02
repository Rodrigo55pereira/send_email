<?php

use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\PHPMailer;

require '../vendor/autoload.php';

header('Content-type: text/html; charset=utf-8');

// Conta de Email no servidor de hospedagem
define('SERVIDOR', 'smtp.gmail.com');

// Para onde será enviado o contato
define('DESTINO', 'rodrigo55pereira@gmail.com');

// Usuário que irá receber o email
define('USER', 'rodrigo55pereira@gmail.com');

// Senha usuário que vai receber o email
define('PASS', 'rodrigo@2017');

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

    $mail = new PHPMailer();
    $mail->CharSet = "utf8";
    $mail->IsSMTP();		// Ativar SMTP
    $mail->SMTPDebug = 3;		// Debugar: 1 = erros e mensagens, 2 = mensagens apenas
    $mail->SMTPAuth = true;		// Autenticação ativada
    $mail->SMTPSecure = 'ssl';	// SSL REQUERIDO pelo GMail
    $mail->Host = 'smtp.gmail.com';	// SMTP utilizado
    $mail->Port = 587;  		// A porta 587 deverá estar aberta em seu servidor
    $mail->Username = USER;
    $mail->Password = PASS;
    $mail->FromName = $_POST['nome'];
    $mail->From = "rodrigo55pereira@gmail.com";
    $mail->isHTML(true);
    $mail->Subject = 'Novo contato - ' . $_POST['nome'] . " - " . date("H:i") . " - " . date("d/m/Y");
    $mail->Body = $mensagem;
    $mail->AddAddress($para);

    $retorno = $mail->send();
    return $retorno;
}