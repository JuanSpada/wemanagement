<?php

// configure
$from = 'juan@wemanagement.com.ar';
$sendTo = 'juan@wemanagement.com.ar, gloria@wemanagement.com.ar'; // Add Your Email
$subject = 'New Lead Home | We Management';
$fields = array('Nombre' => 'Name', 'Asunto' => 'Subject', 'Email' => 'Email', 'Mensaje' => 'Message'); // array variable name => Text to appear in the email
$okMessage = 'Tu consulta fue recibida. Muchas gracias, dentro de poco nos pondremos en contacto!';
$errorMessage = 'Hay un error, por favor proba más tarde.';

// let's do the sending

try
{
    $emailText = "Alguien completo el formulario de la página web www.wemanagement.com.ar xD!\n=============================\n";

    foreach ($_POST as $key => $value) {

        if (isset($fields[$key])) {
            $emailText .= "$fields[$key]: $value\n";
        }
    }

    $headers = array('Content-Type: text/plain; charset="UTF-8";',
        'From: ' . $from,
        'Reply-To: ' . $from,
        'Return-Path: ' . $from,
    );
    
    mail($sendTo, $subject, $emailText, implode("\n", $headers));

    $responseArray = array('type' => 'success', 'message' => $okMessage);
}
catch (\Exception $e)
{
    $responseArray = array('type' => 'danger', 'message' => $errorMessage);
}

if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $encoded = json_encode($responseArray);

    header('Content-Type: application/json');

    echo $encoded;
}
else {
    echo $responseArray['message'];
}
