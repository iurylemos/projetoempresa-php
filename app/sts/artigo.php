<?php
//Se não ISSET = EXISTIR, a variavel segurança, ela cancele o processo, utilizando o EXIT;
if(!isset($seguranca)){
    exit;
}
/*Como o $endereco[0] que está no index é a pagina inicial, então a posição [1] é o SLUG
         * E NA TABELA ARTIGO VAI TER UM APELIDO CHAMADO DE ART
         * POSIÇÃO 0 é O NOME DO ARQUIVO, E A POSIÇÃO 1 É O ARTIGO
         * PARA TRAZER O RESULTADO DE OUTRA COLUNA SE UTILIZA O INNER JOIN
         * NA TABELA ADMS_USUARIO VAI TER UM APELIDO DE USER (ON) ONDE USER.(COLUNA)ID=
         * (COLUNA)ID DEVE SER IGUAL A CHAVE ESTRANGEIRA QUE TEM NA TABELA ARTIGOS
         * JÁ QUE CRIEI UM APELIDO PARA A TABELA ARTIGOS, VOU COLOCAR ELA DEPOIS DO SELECT * FROM
         * DIZENDO PARA SELECIONAR NA TABELA USUARIO A COLUNA A QUAL EU QUERO */
        /*COMO NA TABELA STS_ROBOTS eu quero que ele puxa a coluna NOME e não ID,
         *  vou atribuir aqui abaixo, mais um INNER JOIN, puxando da tabela a qual eu quero
         * E DEPOIS DO SELECT EU PEGO O APELIDO DA TABELA, E PUXO A COLUNA Q EU QUERO */
        $result_art = "SELECT art.*, 
                user.apelido,
                rob.tipo
                FROM sts_artigos art
                INNER JOIN adms_usuarios user ON user.id=art.adms_usuario_id
                INNER JOIN sts_robots rob ON rob.id=art.sts_robot_id
                WHERE slug='".$endereco[1]."' AND sts_situacoe_id=1 LIMIT 1";
        $resultado_art = mysqli_query($conn, $result_art);
        //$row_art = mysqli_fetch_assoc($resultado_art);
        $row_art = mysqli_fetch_assoc($resultado_art);  
        /* Fui no HEADER.PHP e peguei a variavel que contem o titulo
         * E vou substituir pela variavel que está o resultado do artigo, ficando dentro do próprio header 
           Ou seja, no titulo da pagina, vai ficar o titulo da variavel que contem da tabela ARTIGO */
        //CRIANDO O SEO DO ARTIGO \/
        $row_pagina['titulo'] = "Lanlink - " .$row_art['titulo'];
        /*Como criei a tabela sts_robots, e deixei ela como ESTRANGEIRA, vou atribuir abaixo,
         * Igual como eu criei a query puxando da tabela, e puxando a COLUNA,
         * Aqui abaixo eu coloco só o nome da coluna que ele imprime */
        $row_pagina['robots'] = $row_art['tipo'];
        $row_pagina['keywords'] = $row_art['keywords'];
        $row_pagina['description'] = $row_art['description'];
        $row_pagina['author'] = $row_art['author'];
include_once 'app/sts/header.php';
//Vou colocar a variavel antes do HEADER, pois o header está trazendo o SEO
?> 

<body>
    <?php
        include_once 'app/sts/menu.php';
        
    ?>
    
    <main role="main">
            <form>
                <!-- Como vou querer modificar a cor de fundo, vou utilizar o seletor contato que criei do lado do jumbotron -->
            <div class="jumbotron blog">
                <div class="container">
            
                    <!-- Utilizando a classe linha para que o ASSIDE que é a barra lateral fique na mesma linha do conteudo -->
                    <div class="row">
                        <!-- Aqui abaixo vou criar uma verificação que se ele encontrou a informação
                        no BD ele imprima, se não ele não apresenta nada -->
                    <!-- Em dispositivos medios ocupe 8 grid -->
                    <div class="col-md-8 blog-main">
                        <?php
                            if(($resultado_art) AND ($resultado_art->num_rows != 0)) {
                              // Copiei o que estava aqui e coloquei a cima do HEADER no inicio
                              //$row_art = mysqli_fetch_assoc($resultado_art);  
                        ?>

                                <div class="blog-post">
                                    <h2 class="blog-post-title"><?php echo $row_art['titulo']; ?></h2>
                                    <?php
                                    /*Esse PHP se refere a DATA abaixo para o ARTIGO
                                     * setlocale serve para definir as informações locais
                                     * LC_TIME = QUERO FORMATAR A DATA QUANDO ESTIVER UTILIZANDO UMA DETERMINADA FUNÇÃO */
                                    setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'portuguese');
                                    // A função date_default é para determinar o fuso horario
                                    date_default_timezone_set('America/Sao_Paulo');
                                    /*strftime = formatar a hora de acordo com as configurações locais, e é a função do setlocale
                                     * %d = DIA, %b = MES, %Y = ANO, e strtotime puxa a informação da variavel */
                                    //echo strftime('%d de %b de %Y', strtotime($row_art['created']));
                                    // ATRIBUIR TODA A QUERY ACIMA DO STRFTIME PARA A DATA ONDE EU QUERO
                                    
                                    
                                    ?>
                                    <p class="blog-post-meta">
                                        <?php
                                            echo strftime('%d de %b de %Y', strtotime($row_art['created'])) . ", "; 
                                            //Aqui abaixo vou imprimir o apelido de acordo com a QUERY
                                            echo $row_art['apelido'];
                                        ?>
                                    </p>
                                    <!-- O seletor img-fluid faz com que a imagem fique responsiva 
                                    E agora vou utilizar o css para dar o espaço dar imagem para o texto 
                                    margin-bottom = ESPAÇO PARA O RODAPÉ que é BOTTOM = RODAPÉ
                                    -->
                                    <img src="<?php echo pg.'/assets/imagens/artigo/'.$row_art['id'].'/'.$row_art['imagem']; ?>" class="img-fluid" alt="Imagem responsiva" style="margin-bottom: 20px;">
                                        
                                        <?php echo $row_art['conteudo']; ?>
                                    
                                   
                                  </div><!-- /.blog-post --> 
                                <nav class="blog-pagination">
                                  <!-- Aqui na NAV é que tá a parte do botão ANTERIOR E PROX
                                  Portanto precisa pesquisar qual o ARTIGO mais velho 
                                  E o mais novo -->
                                  <?php
                                  /*PHP em relação a NAV, ANT E PROX
                                   * Selecione a coluna SLUG da tabela STS_ARTIGOS ONDE
                                   * O ID deve ser menor do que a variavel que está vindo do BANCO
                                   * E A COLUNA STS_SITUACOE_ID deve ser igual a 1(ATIVA)
                                   * COMO VAI SER A PAGINA ANTERIOR, EU ODERNO A COLUNA ID PELO DESCRESCENTE
                                   * COMO VOU LER O RESULTADO DE UM SÓ UTILIZO O LIMIT */
                                   $result_art_ant = "SELECT slug FROM sts_artigos WHERE id < '".$row_art['id']."' AND sts_situacoe_id=1 ORDER BY id DESC LIMIT 1";
                                   $resultado_art_ant = mysqli_query($conn, $result_art_ant);
                                   //Agora vou verificar se ele conseguio visualizar o resultado
                                   
                                   if(($resultado_art_ant) AND ($resultado_art_ant->num_rows !=0)) {
                                       $row_art_ant = mysqli_fetch_assoc($resultado_art_ant);
                                       echo "<a class='btn btn-outline-primary' href='".pg."/artigo/".$row_art_ant['slug']."'>Anterior</a>";
                                   }
                                   
                                   //AQUI ABAIXO VAI SER O BOTÃO DO ARTIGO PROXIMO
                                   
                                   $result_art_prox = "SELECT slug FROM sts_artigos WHERE id > '".$row_art['id']."' AND sts_situacoe_id=1 ORDER BY id ASC LIMIT 1";
                                   $resultado_art_prox = mysqli_query($conn, $result_art_prox);
                                   //Agora vou verificar se ele conseguio visualizar o resultado
                                   
                                   if(($resultado_art_prox) AND ($resultado_art_prox->num_rows !=0)) {
                                       $row_art_prox = mysqli_fetch_assoc($resultado_art_prox);
                                       echo "<a class='btn btn-outline-primary' href='".pg."/artigo/".$row_art_prox['slug']."'>Proximo</a>";
                                   }
                                  
                                  ?>
                                  
                                    
                                </nav>

                        <?php
                        /* Aqui dentro do PHP, vou criar uma QUERY para os artigos em DESTAQUE
                         * Vou alterar na tabela STS_ARTIGOS a COLUNA qnt_acesso, vai receber o que ela já possui MAIS 1
                         * ONDE o IDtenha o mesmo valor da variavel que representa o ARTIGO que estamos visualizando
                         * PORTANTO ESSA QUERY PERMITE QUE CADA VEZ QUE EU VISUALIZE O ARTIGO ACRESCENTE 1 NA QNT DE ACESSOS */
                            $result_qnt_ac = "UPDATE sts_artigos SET
                                qnt_acesso=qnt_acesso+1
                                WHERE id='".$row_art['id']."' ";
                            mysqli_query($conn, $result_qnt_ac);
                        
                            //Final do IF
                            }else {
                                //Vou criar a variavel URL_DESTINO com o caminho
                                $url_destino = pg."/blog/";
                                
                                // No lugar de imprimir o alerta, eu tbm poderia fazer o redirecionamento
                                header("Location: $url_destino");
                                
                                /*echo "<div class='alert alert-danger' role='alert'>
                                            Artigo não encontrado!
                                      </div>"; */
                            }
                        
                        ?>
                     </div>
                        
                      
                          

                        <!-- Encerrando a divisão -->
                        <aside class="col-md-4 blog-sidebar">
                        <?php
                        /* Vou abrir o PHP para fazer a conexão com a tabela STS_BLOGS_SOBRES
                         * Para fazer a conexão com o BD para implementar o SOBRE */
                        $result_blog_sb = "SELECT * FROM sts_blogs_sobres WHERE sts_situacoe_id=1 LIMIT 1";
                        $resultado_blog_sb = mysqli_query($conn, $result_blog_sb);
                        //Vou criar a condição para implementar
                        if(($resultado_blog_sb) AND ($resultado_blog_sb->num_rows != 0)) {
                            
                        $row_blog_sb = mysqli_fetch_assoc($resultado_blog_sb);
                        ?>
                        <div class="p-3 mb-3 bg-light rounded">
                            <h4 class="font-italic"><?php echo $row_blog_sb['titulo']; ?></h4>
                            <p class="mb-0"><?php echo $row_blog_sb['descricao']; ?></p>
                        </div>
                        <?php
                        }
                        ?>
                        
                        <!-- Agora vou criar uma conexão para os artigos recentes -->
                        <?php
                        //Vou criar a query puxando as informações da tabela STS_ARTIGOS
                        
                        $result_art_rc = "SELECT titulo,slug FROM sts_artigos WHERE sts_situacoe_id=1 ORDER BY id DESC LIMIT 6";
                        $resultado_art_rc = mysqli_query($conn, $result_art_rc);
                        
                        
                        ?>
                        
                        <div class="p-3">
                              <h4 class="font-italic">Artigos recentes</h4>
                          <ol class="list-unstyled mb-0">
                            <?php

                            while($row_art_rc = mysqli_fetch_assoc($resultado_art_rc)) {
                                echo "<li><a href='".pg."/artigo/".$row_art_rc['slug']."'>".$row_art_rc['titulo']."</a></li>";
                            }
                        
                            ?>
                           </ol>
                        </div>
                        
                        
                        <!-- INICIAR O PHP DO DESTAQUE FAZENDO A CONEXÃO -->
                        
                        <?php
                        $result_art_dest = "SELECT titulo,slug FROM sts_artigos WHERE sts_situacoe_id=1 ORDER BY qnt_acesso DESC LIMIT 6";
                        $resultado_art_dest = mysqli_query($conn, $result_art_dest);
                        
                        ?>
                          
                            <div class="p-3">
                              <h4 class="font-italic">Artigos em destaque</h4>
                              <ol class="list-unstyled">
                            <!-- PHP DO DESTAQUE -->
                        <?php

                            while($row_art_dest = mysqli_fetch_assoc($resultado_art_dest)) {
                                echo "<li><a href='".pg."/artigo/".$row_art_dest['slug']."'>".$row_art_dest['titulo']."</a></li>";
                            }
                        
                        ?>
                                
                              </ol>
                            </div>
                        </aside><!-- /.blog-sidebar -->
                    </div>
                </div>
            </div>
      </main>
    
    <?php
        include_once 'app/sts/rodape.php';
        include_once 'app/sts/rodape_lib.php';
    ?>
</body>