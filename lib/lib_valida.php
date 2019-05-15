<?php
//Se não ISSET = EXISTIR, a variavel segurança, ela cancele o processo, utilizando o EXIT;
if(!isset($seguranca)){
    exit;
}


/* Aqui dentro vou criar uma função 
 * Todos os valores do formato_a que ele incluir depois da URL vai ser substituido pelo formato B 
  * Utilizando o STRTR
 * STR_IREPLACE, (CONTEUDO, TIRA O QUE EU QUERO, E BOTA O QUE EU QUERO)
 * PARA RETIRAR A TAG UTILIZA O $conteudo_st = strip_tags($conteudo_br); ST = SEM STRING
 * PARA RETIRAR OS ESPAÇOS EM BRANCO NO INICIO E NO FINAL UTILIZA O TRIM $conteudo_lp = trim($conteudo_st); */


function limparurl($conteudo) {
    $formato_a = '"!@#$%*()+{[}];:,\\\'<>°ºª';
    $formato_b = '____________________________';
    $conteudo_ct = strtr($conteudo, $formato_a, $formato_b);
    $conteudo_br = str_ireplace(" ", "", $conteudo_ct);
    $conteudo_st = strip_tags($conteudo_br);
    $conteudo_lp = trim($conteudo_br);
    
    return $conteudo_lp;
}