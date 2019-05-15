<?php
if(!isset($seguranca)){
    exit;
}
//Eu estarei recebendo os dados da outra página, pelo SendCadLead que foi o nome a qual dei a ela

$SendCadLead = filter_input(INPUT_POST, 'SendCadLead', FILTER_SANITIZE_STRING);

if($SendCadLead) {
    /*SE A VARIAVEL FOR TRUE, SE DER CERTO VAI RECEBER ABAIXO,
     *  E VOU COLOCAR A VARIAVEL QUE VAI VIM QUE VAI VIM QUE NO CASO É O E-MAIL
     * Vou colocar o nome dela de $email_RC pois recebeu */
    $email_rc = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    /* Vou criar o STRIP TAGS, utilizando o e-mail para não poder utilizar TAGS
     * É A PARTE DA VALIDAÇÃO QUE SE TIVER TAG ELE NÃO INSERE */
    $email_st = strip_tags($email_rc);
    /* Vou utilizar o TRIM para retirar os espaços em BRANCO na variavel */
    $email_tr = trim($email_rc);
    // SE A VARIAVEL TRIM FOR DIFERENTE DE VÁZIO ELE ACESSA
    if($email_tr != "") 
    {
        /*E aqui dentro vou inserir no BANCO DE DADOS
         * INSIRA OS DADOS NA TABELA sts_leads (NAS COLUNAS: email, created) 
         * COM OS VALORES ($ EMAIL_TR, E A HORA ATUAL QUE É O NOW()  */
        $result_lead = "INSERT INTO sts_leads (email, created) VALUES ('$email_tr', NOW())";
        $resultado_lead = mysqli_query($conn, $result_lead);
        // Vou criar um IF para saber se foi inserido com sucesso
        if(mysqli_insert_id($conn)) {
            /* Vou criar uma variavel URL destino que é para onde o usuário vai se redirecionado */
            $url_destino = pg."/home";
            /* AQUI DENTRO VOU UTILIZAR UM JAVA SCRIPT UTILIZANDO O META
             *  PARA DIZER PARA ONDE EU QUERO REDIRECIONAR, E EM SEGUIDA
             * VOU APRESENTAR A MENSAGEM DE ERROR ATRAVÉS DO SCRIPT */
            echo "<META HTTP-EQUIV = REFRESH CONTENT = '0;URL=$url_destino'>
                    <script type=\"text/javascript\"> 
                     alert(\"E-mail cadastrado com sucesso. \")
                    </script>";
        }else {
            $url_destino = pg."/home";
            echo "<META HTTP-EQUIV = REFRESH CONTENT = '0;URL=$url_destino'>
                    <script type=\"text/javascript\"> 
                     alert(\"Erro ao cadastrar o e-mail. \")
                    </script>";
        }
        
    } else {
        $url_destino = pg."/home";
            echo "<META HTTP-EQUIV = REFRESH CONTENT = '0;URL=$url_destino'>
                    <script type=\"text/javascript\"> 
                     alert(\"E-mail invalido. \")
                    </script>";
    }
    
} else {
    //E aqui eu não vou apresentar a mensagem, vou logo fazer o redirecionamento
    $url_destino = pg."/home";
    header("Location: $url_destino");
}

