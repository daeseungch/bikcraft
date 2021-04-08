<?php

require("./sendgrid-php/sendgrid-php.php");

$email_site = "daeseungch@gmail.com";
$nome_site = "Bifrost";

$email_user = $_POST["email"];
$nome_user = $_POST["nome"];

$body_content = "";
foreach( $_POST as $field => $value) {
  if( $field !== "leaveblank" && $field !== "dontchange" && $field !== "enviar") {
    $sanitize_value = filter_var($value, FILTER_SANITIZE_STRING);
    $body_content .= "$field: $value \n";
  }
}

$email = new \SendGrid\Mail\Mail(); 
$email->setFrom($email_site, $nome_site);
$email->addTo($email_site, $nome_site);

$email->setReplyTo($email_user, $nome_user);

$email->setSubject("Formulário Bifrost");
$email->addContent("text/plain", $body_content);

$sendgrid = new \SendGrid("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");
try {
    $response = $sendgrid->send($email);
    print $response->statusCode() . "\n";
    print_r($response->headers());
    print $response->body() . "\n";
} catch (Exception $e) {
    echo "Caught exception: ". $e->getMessage() ."\n";
}