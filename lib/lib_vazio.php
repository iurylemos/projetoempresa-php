<?php
//Se não ISSET = EXISTIR, a variavel segurança, ela cancele o processo, utilizando o EXIT;
if(!isset($seguranca)){
    exit;
}

/* COPIEI O LIB_VALIDA E RENOMIEI PARA O VAZIO E VOU MODIFICAR A FUNÇÃO
 * Não é obrigatorio passar a mesma variavel dentro da função vazio(variavel)
 * Mas coloco para ficar mais fácil o entendimento */

function vazio($dados) {
    /* Aqui dentro vou passar uma STRING TAGS, mas para isso vou criar um array
     * PRIMEIRO EU INFORMO O QUE EU QUERO PASSAR, E EM SEGUNDO A QUAL ARRAY */
    $dados_st = array_map('strip_tags', $dados);
    /* Agora vou passar o TRIM para retirar os espaços em branco */
    $dados_tr = array_map('trim', $dados_st);
    /* Agora vou criar um IF, para verificar se tem campo vázio
     * Aqui dentro do If vou utilizar a função IN_ARRAY
     * ELA CHECKA SE EXISTE ALGUM VALOR DENTRO DO ARRAY
     * PASSO O VÁZIO '' e DEPOIS DIGO EM QUAL ARRAY */
    if(in_array('', $dados_tr)) {
        //Aqui dentro vou dar um return false para dizer que algum campo está vazio
        return false;
    }else {
        /*Agora se estiver tudo OK, ele retorna para a variavel que está tudo LIMPO
         * Vou criar a função para receber dentro do proc_cad_contato, esses valores */
        return $dados_tr;
    }
    
    
}