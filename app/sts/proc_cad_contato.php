<?php
if(!isset($seguranca)){
    exit;
}
//Vou criar essa tabela no BD
//Eu estarei recebendo os dados da outra página, pelo SendCadCont que foi o nome a qual dei a ela

$SendCadCont = filter_input(INPUT_POST, 'SendCadCont', FILTER_SANITIZE_STRING);

if($SendCadCont) {
    /* Aqui vou receber os dados do formulário e atribuir para a variavel $dados
     * Como vou receber todos os dados de uma vez só vou utilizar o filter_input_array
     * Quando eu coloco FILTER_DEFAULT eu recebo todos os dados como STRING */
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    //var_dump($dados);
    
    /* Validar se não tem nenhum campo vázio,
     * Vou iniciar a variavel erro como false, mas se alguma vez ela for TRUE, ela acessa o IF */
    $erro = false;
    /* Criei essa função chamada vázio dentro do LIB, e vou incluir ela aqui abaixo */
    include_once 'lib/lib_vazio.php';
    //Aqui vou colocar o validar e-mail
    include_once 'lib/lib_email.php';
    $dados_validos = vazio($dados);
    // Vou criar um IF, para ver se os dados VALIDOS, são false ou TRUE
    
    //Só vai entrar no IF ABAIXO se tiver algum campo vázio
    if(!$dados_validos){
        //E essa variavel error vai se tornar TRUE, e uma vez que ela é TRUE, ela entra no IF ABAIXO
        $erro = true;
        //E aqui abaixo vou criar a mensagem de erro
        $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>
         Necessário preencher todos os campos para enviar a mensagem!
                            </div>";
    }
   
    /* Vou criar um elseif, referente ao IF acima
     * Dentro dele vou pegar a função validarEmail e fazer a condição se for falso ele acessa
     * O e-mail que vou passar é onde está a variavel que contem os dados que é a $dados_validos
     * E nesse dados validos vou pegar a posição ['email']
     * Essa validação é IMPORTANTE, pois quando não funcionar em alguns navegadores o HTML 5,
     * Essa validação vai estar funcionando como 2° opção */
    elseif(!validarEmail($dados_validos['email'])) {
        $erro = true;
        $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>
                                   E-mail invalido!
                            </div>";
    }
    
    
    //Se tiver algum erro ele vai acessar o IF abaixo, ou seja se entrar no IF ACIMA entra nesse IF abaixo
    //Quer dizer que há campos vázio ai ele redireciona para a pagina /contato e o erro,
    // Se não ele entrar no ELSE e INSERE os DADOS
    
    /* Houve erro em algum campo será redirecionado para o formulário,
     *  não há erro no formulário tenta cadastrar no banco
     * Isso é DENTRO do IF($erro) */
    if($erro) {
        //A varivel global SESSION VAI RECEBER OS DADOS E ATRIBUIR A VARIAVEL DADOS
        $_SESSION['dados'] = $dados;
        //Agora que está criado é só dar um echo em cada campo na pagina contato
        $url_destino = pg."/contato";
        header("Location: $url_destino");
    } else {
        //Lembrando que tinha criado isso na aula passada, copiei e colei aqui
        //Agora vou criar a query para inserir os dados
        // No lugar de deixar $dados, vou colocar $dados_validos, pois já está com a TRIM e STRIP TAGS a qual coloquei no LIB
        $result_cont = "INSERT INTO sts_contatos (nome, email, assunto, mensagem, created) VALUES ('".$dados_validos['nome']."', '".$dados_validos['email']."', '".$dados_validos['assunto']."', '".$dados_validos['mensagem']."', NOW())";
        mysqli_query($conn, $result_cont);
        // Agora vou criar uma condição, para apresentar uma mensagem que inseriu com sucesso
        if(mysqli_insert_id($conn)) {
            $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>
                                   Mensagem enviada com sucesso!
                            </div>";
            $url_destino = pg."/contato";
            header("Location: $url_destino");
        }else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>
                                   Erro ao enviar a mensagem, Tente mais tarde!
                            </div>";
            $url_destino = pg."/contato";
            header("Location: $url_destino");
        }
   
    }
    
    
} else {
    /* E aqui eu não vou apresentar a mensagem, vou logo fazer o redirecionamento
     * E vou abrir um SESSION['msg'] para exibir uma mensagem de ALERTA de ERROR */
    $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>
                               Página não encontrada!
                        </div>";
    $url_destino = pg."/contato";
    header("Location: $url_destino");
}

