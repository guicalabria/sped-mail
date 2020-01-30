<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
require_once '../bootstrap.php';

$config = new stdClass();
$config->host = 'smtp.test.com.br';
$config->port = 587;
$config->smtpauth = true;
$config->user = 'usuario@test.com.br';
$config->password = 'senha';
$config->secure = 'tls';
$config->authtype = null; //CRAM-MD5, PLAIN, LOGIN, XOAUTH2
$config->from = 'usuario@test.com.br';
$config->fantasy = 'Test Ltda';
$config->replyTo = 'vendas@test.com.br';
$config->replyName = 'Vendas';
//$config->timeout = 30; //Quanto tempo aguardar a conexão para abrir, em segundos. O padrão de 5 minutos (300s) é da seção RFC2821 4.5.3.2 Isso precisa ser bem alto para funcionar corretamente com hosts usando greetdelay como medida anti-spam.
//$config->timelimit = 30; //Quanto tempo esperar pelos comandos para concluir, em segundos. O padrão de 5 minutos (300s) é da seção RFC2821 4.5.3.2

use NFePHP\Mail\Mail;

try {
    //a configuração é uma stdClass com os campos acima indicados
    //esse parametro é OBRIGATÓRIO
    $mail = new Mail($config);
    
    //use isso para inserir seu próprio template HTML com os campos corretos 
    //para serem substituidos em execução com os dados dos xml
    $htmlTemplate = '';
    $mail->loadTemplate($htmlTemplate);

    //aqui são passados os documentos, tanto pode ser um path como o conteudo
    //desses documentos
    $xml = 'nfe.xml';
    $pdf = '';//não é obrigatório passar o PDF, tendo em vista que é uma BOBAGEM
    $mail->loadDocuments($xml, $pdf);
    
    //se não for passado esse array serão enviados apenas os emails
    //que estão contidos no XML, isto se existirem
    $addresses = ['seu@email.com.br'];
    
    //envia emails, se false apenas para os endereçospassados
    //se true para todos os endereços contidos no XML e mais os indicados adicionais
    $mail->send($addresses, true);
    
} catch (\InvalidArgumentException $e) {
    echo "Falha: " . $e->getMessage();
} catch (\RuntimeException $e) {
    echo "Falha: " . $e->getMessage();
} catch (\Exception $e) {
    echo "Falha: " . $e->getMessage();
}  



