<?php
//Se não ISSET = EXISTIR, a variavel segurança, ela cancele o processo, utilizando o EXIT;
if(!isset($seguranca)){
    exit;
}

/* COPIEI O LIB_VAZIO E RENOMIEI PARA O EMAIL E VOU MODIFICAR A FUNÇÃO
 * Não é obrigatorio passar a mesma variavel dentro da função email(variavel)
 * Mas coloco para ficar mais fácil o entendimento */

function validarEmail($email) {
    // Pode ter letrar de A a Z, 0 a 9, PRECISA SER O @ARROBA, E PRECISA TER O DOMINIO
   $condicao = '/[a-z0-9_\.\-]+@[a-z0-9_\.\-]*[a-z0-9_\.\-]+\.[a-z]{2,4}$/';
   /* Vou criar um IF e dentro vou utilizar uma função chamada de PREG MACTH
    * PREG MACTH = VALIDAR ATRÁVES DA EXPRESSÃO REGULAR
    * PRIMEIRO PASSO A CONDIÇÃO, E EM SEGUIDA O QUE EU QUERO VALIDAR */
    if(preg_match($condicao, $email)) {
        //Caso seja valido vai receber um retorno TRUE
        return true;
    }else {
        //SE o email não está valido ele retorna FALSO
        return false;
    }
}