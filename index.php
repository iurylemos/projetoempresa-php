<!-- Fui em Ferramentas > Modelos > PHP > E em Pagina Web PHP, eu dupliquei e renomiei 
A que foi criada para o nome PHP e HTML e abri com o Editor e esse aqui é o resultado -->
<?php
    //Vou iniciar a SESSÃO
    session_start();
    // Tbm vou criar a função para limpar o BUFFER de saida
    // Pq em alguns servidores possa ser que o HEADER não esteja funcionando
    ob_start();
    //Vou criar essa variavel, para algum usuário não poder acessar diretamente, e recebo lá na pagina
    $seguranca = true;

    /* Biblioteca auxiliares 
     *  MESMO QUE VC MUDE DE SERVIDOR, INCLUDE_ONCE PARA INCLUIR SÓ 1 VEZ
     *  VOU CRIAR UMA FUNÇÃO PARA LIMPAR A URL, E PRECISO ATRIBUIR ISSO A BIBLIOTECA */
    include_once 'config/config.php';
    // Para buscar as informações no banco de dados, vou utilizar o INCLUDE para fazer a conexão
    include_once 'config/conexao.php';
    include_once 'lib/lib_valida.php';
    


    $url = filter_input(INPUT_GET, 'url', FILTER_SANITIZE_STRING);
    //echo $url;
    
    //Chamei a função, e passei a variavel que contem a URL e atribuir a uma variavel
    
    $url_limpa = limparurl($url);
    //echo $url_limpa;
    
    /* ANTES DA BARRA É O NOME DA PAGINA E DEPOIS DA BARRA É O NOME DO ARTIGO
     * E PARA SEPARAR PELA BARRA UTILIZA-SE O EXPLODE
     * E PRIMEIRO PRECISO COLOCAR O DELIMITADOR QUE É A BARRA
     * E DEPOIS A VARIAVEL 
     * E COMO ELE VEM COMO ARRAY, EU TENHO QUE INFORMAR A POSIÇÃO QUANDO FOR IMPRIMIR */
    $endereco = explode("/", $url_limpa);
    /* VOU EXCLUIR A PARTE DO TESTE = echo "<br>" .$endereco[0] ."<br>";
    echo "<br>" .$endereco[1] ."<br>"; */
    
    
    /*Vou pesquisar a página que usuário esteja tentando abrir, se realmente ela existe
    Vou utilizar a instrução SELECT para fazer a pesquisa 
    SELECIONE TODAS AS COLUNAS DA TABELA STS ONDE A COLUNA ENDEREÇO,
     * DEVE TER O MESMO ENDEREÇO DA URL, QUE ESTÁ NA VARIAVEL ACIMA CHAMADA $ENDEREÇO  
     * COMO ELE É UM ARRAY, ELE FICA DENTRO DAS ASPAS SIMPLES '".$endereco[0]"'
     * E ASPAS DUPLAS DENTRO PARA CONCATENAR = '".$endereco[0]"' 
     * E TBM A SITUAÇÃO DA PAGINA DEVE SER 1
     * LIMIT QUER DIZER QUE É NO MAXIMO 1 O RESULTADO
     * USANDO O INNER JOIN PARA DIZER QUE NA TABELA STS_ROBOTS, O ID, TEM QUE SER IGUAL A CHAVE ESTRANGEIRA DA STS_PAGINAS
     * DA TABELAA ROB SÓ VOU QUERER A COLUNA TIPO = 2° LINHA
     * E MODIFICO LÁ NO HEADER, PARA FICAR PARA TODAS AS INSTANCIAS QUE UTILIZAM O HEADER
     * NO WHERE VOU COLOCAR pag.endereco, e depois do AND colocar o pag.sts_situacaos */
    
    $result_pagina = "SELECT pag.*,
            rob.tipo
            FROM sts_paginas pag
            INNER JOIN sts_robots rob ON rob.id=pag.sts_robot_id
            WHERE pag.endereco='".$endereco[0]."' AND pag.sts_situacaos_pg_id = 1 LIMIT 1; ";
    /* Agora vou executar a query e para executar utilizo o mysqli_query */
    $resultado_pagina = mysqli_query($conn, $result_pagina);
    // Agora vou verificar se ele encontrou a página lá no body
?>


<!DOCTYPE html>
<html lang="pt-br">
        <?php
        /* Irei verificar aqui se encontrou a query
         * PARA VISUALIZAR O TANTO DE LINHAS, UTILIZO A VARIAVEL E DIGO QUE SE ELE FOR DIFERENTE DE ZERO
         * ELE CONSEGUIO ENCONTRAR ALGUMA INFORMAÇÃO
         * E coloco assim: $resultado_pagina->num_rows != 0 */
            if(($resultado_pagina) AND ($resultado_pagina->num_rows != 0)) {
                /* VOU PEGAR TODA A INSTRUÇÃO QUE TINHA CRIADO ABAIXO E COLAR AQUI.
                 * NO FILE ESTOU PEGANDO DIRETAMENTE DO DIRETORIO
                 * MAS EU QUERO PEGAR É DO PROPRIO BD UTILIZANDO UMA COLUNA QUE TODAS AS TABELAS IRÃO TER 
                 * E TRAZENDO DE FORMA DINAMICA SUBSTITUINDO O DIRETORIO 'app/sts/' para A tp_pagina
                 * $file = 'app/sts/'.$endereco[0].'.php'; VAI FICAR ASSIM: $file = 'app/'.$row_pagina['tp_pagina'].'/'.$endereco[0].'.php'; */
                
                //Agora vou fazer a leitura com a variavel que possui os valores
                // Estou lendo o que veio do banco de dados e atribuindo a uma variavel chamada $row_pagina
                //E vou pegar o valor dessa variavel somente na POSIÇÃO do TP_PAGINA
                // PQ O TP_PAGINA POSSUI O DIRETORIO QUE ERA O ANTERIOR QUE É O STS
                // BARRA / E O ENDEREÇO QUE EU QUERO ABRIR QUE ESTAVA NA VARIAVEL $endereco
                $row_pagina = mysqli_fetch_assoc($resultado_pagina);
                
                //E vou pegar o valor que está na variavel, na posição do TP_PAGINA
                
                $file = 'app/'.$row_pagina['tp_pagina'].'/'.$endereco[0].'.php';
                if(file_exists($file)) 
                {
                    include $file; 
                }else {
                    $url_destino = pg."/home";
                    header("Location: $url_destino");
                }
            }else{
                /* AGORA SE ELE NÃO CONSEGUIO ENCONTRAR O ARQUIVO PQ NÃO ESTÀ CADASTRADO NO BD
                 * ENTÃO ELE VAI SER REDIRECIONADO PARA A PAGINA HOME */
                $url_destino = pg."/home";
                header("Location: $url_destino");

            }
        
        
        /*
        /* Vou imprimir a pagina contato aqui abaixo utilizando o 
        $file = '(DIRETORIO)'. (VARIAVEL URL AMIGAVEL). 'EXTENSÃO'
         * ESTAVA UTILIZANDO a $url, e agora vou colocar o $endereco[POSIÇÃO]
         * Para que quando o usuário veja, só visualize o conteudo */
           // $file = 'app/sts/'.$endereco[0].'.php';
        /* Agora vou incluir essa variavel para imprimir através do INCLUDE, 
        E agora vou utilizar o IF para verificar se existe antes de imprimir,
         * Caso não encontre, ele imprima uma pagina home, atráves do diretorio  */  
          /* if(file_exists($file)) 
          {
            include $file; 
          }else {
              /* Dessa forma estava incluindo junto a pagina que iria abrir
              include 'app/sts/home.php'; MAS AGORA EU QUERO QUE REDIRECIONE PARA A PAGINA HOME,
               * CRIO UMA PAGINA ATRIBUINDO PARA UMA VARIAVEL
               * E DEPOIS COLOCO ESSA VARIAVEL DENTRO DO HEADER 
               * VOU MODIFICAR O SELETOR ABAIXO, E COLOCAR SÓMENTE O PG Q CRIEI NO CONFIG.PHP
               * QUE JÁ VEM COM O SERVIDOR
              $url_destino = "http://localhost/Lanlink/home"; 
               SUBSTITUINDO PARA: $url_destino = pg."/home";, OU SEJA UTILIZO SÓ O PG,
               * E COLOCO O NOME DO ARQUIVO   */
              //$url_destino = pg."/home";
              //header("Location: $url_destino");
          //} 
        ?>
</html>
