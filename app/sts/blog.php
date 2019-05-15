<?php
//Se não ISSET = EXISTIR, a variavel segurança, ela cancele o processo, utilizando o EXIT;
if(!isset($seguranca)){
    exit;
}
include_once 'app/sts/header.php';
?>
<body>
    <?php
        include_once 'app/sts/menu.php';
        
        /* Agora vou receber o numero da página em que o usuário está, ele 
         * Vai vim através da URL, e se utiliza o GET
         * Exemplo: blog?pagina=2 */
        $pagina_atual = filter_input(INPUT_GET, 'pagina', FILTER_SANITIZE_NUMBER_INT);
        /*SE for diferente de EMPTY é pq está vindo algum valor 
            ? = ENTÃO, atribua o valor := CASO SEJA VAZIO, atribua o numero 1 
         * OU SEJA SE NÃO TIVER VALOR VAI DIRETO PARA A PAGINA 1 */
        $pagina = (!empty($pagina_atual)) ? $pagina_atual : 1;
        
        /* Agora vou setar a quantidade de itens por páginas */
        $qnt_result_pg = 2;
        /* Agora vou calcular o inicio da visualização 
         Se ele estiver na pagina 1, vai ver 1 e 2, se tiver na 2, vai ver 2 e 3 
          Pois é como eu determinei acima a quantidade de itens q visualizará
         * Vai ser a QNT_RESULTADOS_PAG * VEZES a PAGINA
         * EXEMPLO SE O USUÁRIO ESTIVER NA PAGINA 2, VAI FICAR 2 x 2, 4, mas como eu subtrair
         * pela $qnt_result_pag, ele vai iniciar pela 2 */
        $inicio = ($qnt_result_pg * $pagina) - $qnt_result_pg;
        
        /* AGORA VOU INICIAR A QUERY DA CONEXÃO COM O BD
         * SELECIONE AS COLUNAS DA TABELA, WHERE = SOMENTE quando a SITUACAO for ativa
         * QUERO QUE ORDENE PELA COLUNA ID de forma DECRESCENTE
         * E LIMITE O VALOR A PARTIR DA VARIAVEL INICIO ATÉ A QNT_RESULT_PAG
         * EX: SE EU ESTOU NA PAG 3, E ELE DEVE TRAZER 2 POR PAGINA
         * ENTÃO ELE VAI TRAZER A PARTIR DO 4, E TRAZENDO APARTIR DO 4, ELE SÓ VAI PODER APRESENTAR 2 RESULTADOS
         * ENTÂO ELE VAI TRAZER O 5 E O 6 */
        $result_art = "SELECT id, titulo, descricao, imagem, slug FROM sts_artigos
                WHERE sts_situacoe_id=1 
                ORDER BY id DESC
                LIMIT $inicio,$qnt_result_pg";
        // Agora vou executar
        $resultado_art = mysqli_query($conn, $result_art);
    ?>
    
    <main role="main">
            <form>
                <!-- Como vou querer modificar a cor de fundo, vou utilizar o seletor contato que criei do lado do jumbotron -->
            <div class="jumbotron blog">
                <div class="container">
                    <h2 class="display-4 text-center" style="margin-bottom: 50px">Blog</h2>
                    <!-- Utilizando a classe linha para que o ASSIDE que é a barra lateral fique na mesma linha do conteudo -->
                    <div class="row">
                        <!-- Em dispositivos medios ocupe 8 grid -->
                        <div class="col-md-8 blog-main">
                            <!-- AGORA COMO VOU IMPRIMIR OS ARTIGOS -->
                            <?php
                            while($row_art = mysqli_fetch_assoc($resultado_art)) {
                            ?>
                                <!-- Copiei uma parte da pagina do BLOG, pois já está no BD só vou atribuir -->
                                <div class="row featurette">
                                    <div class="col-md-7 order-md-2 blog-text">
                                            <!-- Para redirecionar para a parte do SLUG que é depois da barra
                                            E quando clicar na imagem vai para o artigo e depois da barra é o SLUG -->
                                    <a href="<?php echo pg.'/artigo/'.$row_art['slug']; ?>"><h2 class="featurette-heading"><?php echo $row_art['titulo']; ?></h2></a>
                                    <p class="lead"><?php echo $row_art['descricao']; ?> <a href="<?php echo pg.'/artigo/'.$row_art['slug']; ?>">Continuar lendo</a></p>
                                    </div>
                                        <!-- Vou criar um link, para quando clicar na imagem abra o artigo.html -->
                                    <div class="col-md-5 blog-img">
                                      <a href="<?php echo pg.'/artigo/'.$row_art['slug']; ?>"><img class="featurette-image img-fluid mx-auto" src="<?php echo pg.'/assets/imagens/artigo/'.$row_art['id'].'/'.$row_art['imagem']; ?>" alt="<?php echo $row_art['titulo']; ?>"></a>
                                    </div>
                                </div>
                                <hr class="featurette-divider">
                            
                            
                            <?php    
                            }
                            //* Agora vou criar a paginação 
                            //E na paginação vou criar primeiro a query para saber quantos registros tem no BD
                            //Portanto vou utilizar o SELECT e o COUNT para CONTAR
                            //E ESSA CONTAGEM VOU (AS)ATRIBUIR PARA UM APELIDO CHAMADO: num_result (FROM)DA TABELA
                            //(CONDIÇÃO) WHERE(ONDE) sts_situacoe_id=1(SITUACAO FOR ATIVA = 1)
                            //COLOQUEI RESULT_PG = RESULTADO DE PAGINAÇÃO */
                            $result_pg = "SELECT COUNT(id) AS num_result FROM sts_artigos WHERE sts_situacoe_id=1";
                            $resultado_pg = mysqli_query($conn, $result_pg);
                            $row_pg = mysqli_fetch_assoc($resultado_pg);
                            //Agora vou imprimir o valor do APELIDO que é o num_result
                            //echo $row_pg['num_result'];
                            /* Agora vou implementar a divisão, QUANTIDADE DE PAGINAS
                             * Vou utilizar a função CEIT = NÃO DEIXA TER FLOAT, SÓ INTEIROS
                             * PEGAR O APELIDO QUE CONTEM O RESULTADO DA QUANTIDADE
                             * E DIVIDIR PELA VARIAVEL QUE CONTEM O RESULTADO DAS PAGINAS
                             * E O RESULTADO VAI SER ATRIBUIDO A VARIAVEL QUANTIDADE DE PAGINAS */
                            $quantidade_pg = ceil($row_pg['num_result'] / $qnt_result_pg);
                            
                            
                            //LIMITAR os links ANTES e DEPOIS, 2 antes e 2 depois
                            
                            $max_links = 2;
                            
                            //Implementar o LAYOUT
                            echo "<nav aria-label='paginacao-blog'>";
                            echo "<ul class='pagination justify-content-center'>";
                            echo "<li class='page-item'>";
                            /*Aqui abaixo no caminho para encaminhar abrir o PG, disse qual era a pagina
                             * Que no caso é a BLOG, e vou pegar a variavel que está recebendo a PAGINAÇÃO
                             * Que no caso é a PAGINA, conforme o RECEBER O NUMERO DE PAGINAS */
                            echo "<a class='page-link' href='".pg."/blog?pagina=1' tabindex='-1'>Primeira</a>";
                            
                            echo "</li>";
                            /*Como eu disse acima que teria no maximo 2 links antes e depois eu preciso criar um FOR
                             * Vou criar uma variavel chamada pag_ant = PAGINA ANTERIOR
                             * Essa PAGINA ANTERIOR vai receber a PAGINA em ESTOU menos o MAXIMO DE LINKS
                             * E ESSE FOR SÓ VAI SER EXECUTADO QUANDO A PAGINA QUE ESTOU
                             * $pag_ant <= $pagina-1; FOR MENOR IGUAL A 1
                             * E INCREMENTAR O FOR QUANDO PASSAR */
                            
                            for($pag_ant = $pagina - $max_links; $pag_ant <= $pagina-1; $pag_ant++) {
                                /*Como ficou imprimindo o 0 e o -1, vou colocar um IF
                                 * Para quando for menor que 1 ele não imprimir */
                                if($pag_ant >= 1) {
                                    echo "<li class='page-item'><a class='page-link' href='".pg."/blog?pagina=$pag_ant'>$pag_ant</a></li>";
                                }
                                
                                
                                /*Agora vamos imprimir o LAYOUT quando passar por aqui
                                 * Vai imprimir o BLOG $PAG_ANTERIOR */
                                
                                //echo "<li class='page-item'><a class='page-link' href='".pg."/blog?pagina=$pag_ant'>$pag_ant</a></li>";
                            }
                            /* Criando a paginação da PAGINA ATUAL
                             * Copiei do LAYOUT essa parte e colei aqui */
                                echo "<li class='page-item active'>";
                                echo "<a class='page-link' href='#'>$pagina <span class='sr-only'>(current)</span></a>";
                                echo "</li>";
                                
                             /* Agora vou criar a paginação da PAGINA PROXIMA
                              * Ele vai ser executado se a (PAGINA QUE ESTOU)$pagina + 1
                              * Por que +1? Por que eu quero depois da pagina atual que estou
                              * Esse for vai ser executado enquanto nossa PAGINA_DEPOIS for menor igual
                              * a PAGINA ATUAL + MAXIMO DE LINKS */
                                
                              for($pag_dep = $pagina + 1; $pag_dep <= $pagina + $max_links; $pag_dep++) {
                                 /* Vou criar um IF, para determinar que só temos 6 páginas e depois disso não tem que imprimir 
                                   Ou aparecer as paginação que tem depois
                                  * ENQUANTO O PAGINA DEPOIS FOR MENOR QUE O NUMERO QUE TEMOS DE PAGINAS, NÃO É PARA IMPRIMIR */
                                  if($pag_dep <= $quantidade_pg) {
                                    echo "<li class='page-item'><a class='page-link' href='".pg."/blog?pagina=$pag_dep'>$pag_dep</a></li>"; 
                                  }
                              }
                              /*Agora vou criar o proxima página
                               * A VARIAVEL VAI SER QUANTIDADE_PAG, PQ QUANTIDADE PAG É O TANTO DE PÁGINA,
                               * ENTÃO ELE VAI PEGAR A ULTIMA PÁGINA, SE FOR 10 PAGINAS, A 10° É A ULTIMA */
     
                              echo "<li class='page-item'>";
                              echo "<a class='page-link' href='".pg."/blog?pagina=$quantidade_pg'>Next</a>";
                              echo "</li>";
                              
                            ?>
                                
                      
                          

                        <!-- Encerrando a divisão -->

                      <!-- Como eu quero a paginação centralizada vou utilizar o justify-content-center -->
                          
                    </div>
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
      </main>
    
    <?php
        include_once 'app/sts/rodape.php';
        include_once 'app/sts/rodape_lib.php';
    ?>
    <script>
        window.sr = ScrollReveal({reset: true});
        sr.reveal('.blog-text', {
            duration: 1000,
            origin: 'right',
            distance: '20px'
        });
        sr.reveal('.blog-img', {
            duration: 1000,
            origin: 'left',
            distance: '20px'
        });
    </script>
</body>