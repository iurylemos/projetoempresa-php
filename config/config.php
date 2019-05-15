<?php
//Se não ISSET = EXISTIR, a variavel segurança, ela cancele o processo, utilizando o EXIT;
if(!isset($seguranca)){
    exit;
}

//Criei uma variavel, e atribuir a um filtro, que receber pelo Servidor, a variavel HTTP_HOST
// E preciso colocar lá no INDEX tbm, pois é a RAIZ, colocando nas bibliotecas auxiliares, 
// E ESSA VARIAVEL É O DOMINIO!! 
$url_host = filter_input(INPUT_SERVER, 'HTTP_HOST');
//echo "<br>" .$url_host ."<br>";
// Agora vou criar uma variavel constante, ou seja não pode ser alterada
// DEFINE = CONSTANTE ('ELA VAI SER CHAMADA = PG', "HTTP://DOMINIO = URL_HOST/DIRETORIO= LANLINK
// SEMPRE QUE EU MODIFICAR O SERVIDOR, EU SÓ MODIFICO O DOMINIO
// E ESSA PG AGORA POSSUI O ENDEREÇO DO LADO, 

define('pg', "http://$url_host/Lanlink");
