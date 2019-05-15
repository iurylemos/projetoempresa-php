<?php
//Se não ISSET = EXISTIR, a variavel segurança, ela cancele o processo, utilizando o EXIT;
    if(!isset($seguranca)){
        exit;
    }

$servidor = "localhost";
$usuario = "root";
$senha = "";
$dbname = "lanlink";

//Criar a conexão

$conn = mysqli_connect($servidor, $usuario, $senha, $dbname);

/* Vou criar um IF, que se for diferente de (TRUE)$conn, ele imprima a falha na conexão
if(!$conn) {
    die("Falha na conexão" . mysqli_connect_error());
}else {
    echo "Conexão realizada com sucesso";
} */
if(!$conn) {
    die("Falha na conexão" . mysqli_connect_error());
}else {
    echo "Conexão realizada com sucesso";
}