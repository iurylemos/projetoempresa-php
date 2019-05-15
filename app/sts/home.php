<?php
//Se não ISSET = EXISTIR, a variavel segurança, ela cancele o processo, utilizando o EXIT;
if(!isset($seguranca)){
    exit;
}

// Agora vou incluir o HEADER que contem o cabeçalho, utilizando o include_once (DIRETORIO)/(ARQUIVO)
include_once 'app/sts/header.php';


?> 
<!-- PARA PARAR DE UTILIZAR O CABEÇALHO EM TODAS AS PAGINAS, VOU CRIAR UMA PAGINA ESPECIFICA PARA ISSO 
<head>
    <meta charset="UTF-8">
    <title>Lanlink</title>
</head> -->
<body>
    <?php
        include_once 'app/sts/menu.php';
    ?>
    <!-- INCLUIR TODO O CONTEUDO DA HOME DO LAYOUT -->
    <main role="main">
       <!-- Vou fazer aqui abaixo do MAIN a parte de colocar o carrosel -->
       <?php
        /* Aqui dentro vou criar a QUERY para pesquisar no BD
         * UTILIZANDO O SELECT PARA SELECIONAR AS COLUNAS SITUADAS NA sts_caroulses, ela vai ser chamada de CAR
         * E NA TABELA cor que é a STS_CORS vou querer a coluna chamada cor
         * ONDE A COLUNA SITUACOES FOR IGUAL A 1 QUE É O ATIVO
         * VOU UTILIZAR O INNER JOIN PARA PUXAR AS CORES, POIS SE TRATA DE UMA TABELA ESTRAGEIRA QUE É A STS_CORS,
         *  VOU INDETIFICAR COMO COR, colocando depois do nome da tabela, ONDE O ID FOR IGUAL
         *  AI SEU SÓ PEGO O NOME DA COLUNA COR E ATRIBUO LÁ NA PARTE DA CORES DO BOTÃO COM O PHP
         * AGORA VOU CRIAR A QUERY ORDER BY, PARA ORDENAR AS IMAGENS E TER O CONTROLE
         * EU QUERO QUE ELE ORDENE DA FORMA ASC */
         $result_carousels = "SELECT car.*,
                    cor.cor
                    FROM sts_caroulses car
                    INNER JOIN sts_cors cor ON cor.id=car.sts_cor_id
                    WHERE car.sts_situacoe_id=1
                    ORDER BY ordem ASC";
         //Todo resultado que vier do banco eu estou atribuindo para a variavel $resultado_carolsels
         $resultado_carousels = mysqli_query($conn, $result_carousels);
         /* Vou realizar um teste utilizando o IF, perguntando se for true, e se a quantidade de linha for diferente de ZERO
          E só imprimo se as duas condições passarem pelo IF
          FECHEI O PHP DPS DO IF, E ABRIR NOVAMENTE PARA FECHAR DEPOIS DO CODIGO CARROSEL QUE ESTÁ EM HTML*/
         if(($resultado_carousels) AND ($resultado_carousels->num_rows != 0)) {
         ?>    
               <!-- Aqui é a div do carrosel -->
            <div id="myCarousel" class="carousel slide" data-ride="carousel">
              <!-- OL é onde ele indentifica os itens, ou seja são os indicadores
              Aqueles que ficam em baixo da imagem, pra você navegar de uma para a outra -->
              <ol class="carousel-indicators">
                 <!-- VOU ABRIR O PHP ABAIXO PARA VER QUANTOS SLIDES ESTÃO VINDO DO BANCO 
                 QUE ESTÀ DENTRO DA VARIAVEL $RESULTADO_CAROUSELS-->
                 <?php
                 /* Percebir que ele tem numeros e pra isso vou criar um contador para ficar mais fácil   */
                 $cont_marc = 0;
                 
                 
                 /*Vou criar a variavel linha_marcadores, pois irei trabalhar com marcadores 
                Vou botar dentro de um while pois se trata de um array para percorrer a variavel
                  *   */
                 while($row_marcador = mysqli_fetch_assoc($resultado_carousels)) {
                     //Copiei do LAYOUT, e coloquei entre as aspas do ECHO, e dentro coloquei todos com aspas SIMPLES
                     echo "<li data-target='#myCarousel' data-slide-to='1'></li>";
                     
                     //Todas as vezes que ele imprimir um marcador, ele vai acrescentar mais um
                     $cont_marc++;
                 }
                 ?>
                 <!-- NO LUGAR DE FICAR ESSES TRES, EU CRIEI UM MARCADOR PARA PECORRER TODOS
                 COMO CRIEI ACIMA UTILIZANDO SÓMENTE 1, E MODIFIQUEI PARA ASPLAS SIMPLES
                <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                <li data-target="#myCarousel" data-slide-to="1"></li>
                <li data-target="#myCarousel" data-slide-to="2"></li> -->
              </ol>
              <div class="carousel-inner">
                 <?php
                 // Variavel controle SLIDE, e antes de fechar o segundo PHP, eu acrescento sempre MAIS 1 nela
                 $cont_slide = 0;
                 //Vou incluir o PHP dentro do CAROUSEL, para puxar as informações do banco
                  $resultado_carousels = mysqli_query($conn, $result_carousels);
                  
                  // Vou criar uma variavel LINHA SLIDE, e vou colocar um mysqli_fetch_assoc, para ler o resultado
                 while($row_slide = mysqli_fetch_assoc($resultado_carousels)) {
                 ?>
                 <!-- Segundo SLIDE aqui dentro do PHP, depois da CONDIÇÃO,
                 E vou criar uma condição dentro da DIV CAROUSEL-ITEM com o PHP
                 Dizendo que se a variavel controle_SLIDE = $cont_slide for igual a 0, é pq é o primeiro slide
                 e no inicio do PHP, eu digo que ela inicia com 0 -->
                 <div class="carousel-item <?php if($cont_slide == 0) { echo 'active'; } ?>">
                   <!-- Para imprimir a IMAGEM, eu vou puxar dentro da variavel que contem o valor
                   que é a $row_slide, e colocar depois da pasta que está a imagem, e coloco a coluna ao lado
                   Só que antes da coluna tem que colocar o diretorio, e tem que abrir o PHP de novo,
                   e selecionar a coluna primaria, que é o ID
                   e o nome da coluna que está no banco de dados é imagem, e por isso vou coloca-la -->
                   <img class="second-slide img-fluid" src="<?php echo pg; ?>/assets/imagens/carousel/<?php echo $row_slide['id']; ?>/<?php echo $row_slide['imagem']; ?>" alt="<?php echo $row_slide['titulo']; ?>">          
                  <div class="container">
                    <div class="carousel-caption <?php echo $row_slide['posicao_text']; ?>">
                      <!-- Titulo - Só será apresentando quando for maior que dispositivos médios  -->
                      <h1 class="d-none d-md-block"><?php echo $row_slide['titulo']; ?></h1>
                      <!-- Descrição - Só será apresentando quando for maior que dispositivos médios -->
                      <p class="d-none d-md-block"><?php echo $row_slide['descricao']; ?></p>
                      <!-- Botão - Só será apresentando quando for maior que dispositivos médios -->
                      <p class="d-none d-md-block"><a class="btn btn-lg btn-<?php echo $row_slide['cor']; ?>" href="<?php echo $row_slide['link']; ?>" role="button"><?php echo $row_slide['titulo_botao']; ?></a></p>
                    </div>
                  </div>
                </div>
                 
                  
                 <?php
                 $cont_slide++;
                 }
                 ?>
              <!-- DIV QUE FECHA O CARROSEL INNER \/ -->
              </div>
              <!-- A parte do controle, são aquelas setas para passar a página que fica ao lado -->
              <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
              </a>
              <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
              </a>
            </div>
         <!-- ABRIR NOVAMENTE O PHP ABAIXO PARA FECHAR O IF POIS ESTÁ EM PHP -->
       <?php
         }
       ?>
         
       <!-- ABRINDO UM PHP PARA IMPLEMENTAR OS SERVIÇOS DA TABELA QUE CRIEI DO BANCO DE DADOS -->
       <?php
       /* Primeiramente vou criar a QUERY. selecione as colunas da tabela SERVIÇOS sts_servicos
        * E LIMITE APENAS PARA 1 RESULTADO */
       
       $result_servico = "SELECT * FROM sts_servicos LIMIT 1";
       
       $resultado_servico = mysqli_query($conn, $result_servico);
       //AGORA VOU LER O RESULTADO
       $row_servico = mysqli_fetch_assoc($resultado_servico);
       ?>
      
      <!-- Agora vou incluir o Jumbotron, que vai servir como um MENU -->
      <!-- Main jumbotron for a primary marketing message or call to action -->
      <div class="jumbotron servicos">
        <div class="container">
          <!-- Ele vai ser h2, pois H1 só pode se utilizar uma vez no site -->
          <!-- Para centralizar o texto vou colocar o text-center -->
           <!-- A utilização desse style é para dar o espaço entre o titulo e o conteudo /\ -->
          <h2 class="display-4 text-center" style="margin-bottom: 40px;"><?php echo $row_servico['titulo']; ?></h2>
          <!-- Vou utilizar aqui em baixo o modelo CARTÕES, com o CARTÕES DE BARALHO -->
          <div class="card-deck card-servicos">
            <div class="card text-center">
                <!-- Os icones tem que está dentro da classe seletora 
                 Vou atribuir a classe tamanho-icone e modificar ela no CSS -->
                <div class="icon-row tamanho-icone">
                  <!-- Atribuindo o icone com o seletor "step, e size se refere ao tamanho -->
                  <span class="step size-96 text-primary"> <i class="icon <?php echo $row_servico['icone_um']; ?>"></i></span>
                </div>
              <div class="card-body">
                <!-- Aqui vai ser o titulo do serviço -->
                <h5 class="card-title"><?php echo $row_servico['nome_um']; ?></h5>
                <!-- Conteudo do serviço - Como eu quero o conteudo com a fonte diferenciada
                E o nome da fonte é lead, basta eu colocar do lado do seletor -->
                <p class="card-text lead"><?php echo $row_servico['descricao_um']; ?></p>
              </div>
            </div>
            <div class="card text-center">
                <div class="icon-row tamanho-icone">
                  <!-- Atribuindo o icone com o seletor "step, e size se refere ao tamanho -->
                  <span class="step size-96 text-primary"> <i class="icon <?php echo $row_servico['icone_dois']; ?>"></i></span>
                </div>
              <!-- Como vou querer centralizar o texto tanto do titulo como do conteudo, eu boto 
              o text-center dentro do card-body que serve para os dois -->
              <div class="card-body text-center">
                <h5 class="card-title"><?php echo $row_servico['nome_dois']; ?></h5>
                <p class="card-text lead"><?php echo $row_servico['descricao_dois']; ?></p>
                
              </div>
            </div>
            <div class="card text-center">
                <div class="icon-row tamanho-icone">
                  <!-- Atribuindo o icone com o seletor "step, e size se refere ao tamanho -->
                  <span class="step size-96 text-primary"> <i class="icon <?php echo $row_servico['icone_tres']; ?>"></i></span>
                </div>
              <div class="card-body text-center">
                <h5 class="card-title"><?php echo $row_servico['nome_tres']; ?></h5>
                <p class="card-text lead"><?php echo $row_servico['descricao_tres']; ?></p>
                
              </div>
            </div>
          </div>
         
          
        </div>
      </div>
      <!-- VOU CRIAR UM PHP, PARA FAZER A CONEXÃO COM O BANCO DE DADOS PARA PUXAR OS DADOS DA TABELA DOS VIDEOS -->
      
      <?php
      $result_video = "SELECT * FROM sts_videos LIMIT 1";
      $resultado_video = mysqli_query($conn, $result_video);
      $row_video = mysqli_fetch_assoc($resultado_video);
      
      ?>
      

      <!-- OUTRO JUMBOTRON -->
      <div class="jumbotron depoimentos">
          <div class="container">
            <!-- Ele vai ser h2, pois H1 só pode se utilizar uma vez no site -->
            <!-- Para centralizar o texto vou colocar o text-center -->
             <!-- A utilização desse style é para dar o espaço entre o titulo e o conteudo /\ -->
            <h2 class="display-4 text-center" style="margin-bottom: 40px; color: #fff"><?php echo $row_video['titulo']; ?></h2>
            <p class="lead text-center" style="margin-bottom: 40px; color: #FFF;" ><?php echo $row_video['descricao']; ?></p>
            <!-- Vou utilizar aqui em baixo o modelo CARTÕES, com o CARTÕES DE BARALHO -->
            <div class="card-deck">
              <div class="card text-center dep-left">
                  <div class="embed-responsive embed-responsive-16by9">
                     <?php echo $row_video['video_um']; ?>
                  </div>
              </div>
              <div class="card text-center dep-center">
                  <div class="embed-responsive embed-responsive-16by9">
                      <?php echo $row_video['video_dois']; ?>
                  </div>
              </div> 
              <div class="card text-center dep-right">
                  <div class="embed-responsive embed-responsive-16by9">
                      <?php echo $row_video['video_tres']; ?>
                  </div> 
              </div>
            </div>
          </div>
        </div>
           
            
          </div>
        </div>
        <!-- VOU CRIAR UM PHP PARA FAZER A CONEXÃO COM A TABELA DOS PRODUTOS -->
        <?php
            //Vou criar a conexão com a tabela do produtos que se chama sts_prods_homes SIGNIFICA SITE_PRODUTOS_HOME
            $result_prod_home = "SELECT * FROM sts_prods_homes LIMIT 1";
            $resultado_prod_home = mysqli_query($conn, $result_prod_home);
            $row_prod_home = mysqli_fetch_assoc($resultado_prod_home);
        
        ?>

        <!-- Criando um novo jumbotron -->
        <div class="jumbotron produto">
          <div class="container">
            <!-- Coloquei o h2 produto agora, vou modificar com os seletores, colocando o tamanho 
            utilizando o display-4, deixando o texto centralizado com o text-center
            E agora vou colocar o texto em linha com o style="margin-bottom: 40px" -->
            <h2 class="display-4 text-center" style="margin-bottom: 40px"><?php echo $row_prod_home['titulo']; ?></h2>
            <div class="row featurette">
              <div class="col-md-7 prod-text">
                <h2 class="featurette-heading"><?php echo $row_prod_home['subtitulo']; ?></h2>
                <!-- Retirei o sub titulo do h2 que é o titulo acima. que era o <span class="text-muted">It’ll blow your mind.</span> -->
                <p class="lead"><?php echo $row_prod_home['descricao']; ?></p>
              </div>
              <div class="col-md-5 prod-img">
                  <!-- CONCATENEI PARA NÃO TER QUE ABRIR DOIS PHP, E ASSIM UTILIZAR SÓ 1 -->
                <img class="featurette-image img-fluid mx-auto" src="<?php echo pg.'/assets/imagens/prods_home/'.$row_prod_home['id'].'/'.$row_prod_home['imagem']; ?>" alt="<?php echo $row_prod_home['subtitulo']; ?>">
              </div>
            </div>
          </div>
        </div>

        <!-- AGORA VOU FAZER A CONEXÃO COM A TABELA QUE CADASTRA OS E-MAILS COM O PHP -->
        <?php
        $result_forms_emails = "SELECT * FROM sts_forms_emails LIMIT 1";
        $resultado_forms_emails = mysqli_query($conn, $result_forms_emails);
        $row_forms_emails = mysqli_fetch_assoc($resultado_forms_emails);
        
        ?>
        
        
        
        <!-- Criar um jumbotron para cadastrar e-mail -->
        <!-- Vou utilizar uma imagem de fundo, e para isso utilizo o background-image -->
        <!-- Vou criar uma paralaxe utilizando ela como um seletor -->
        <div class="jumbotron cadastro-email paralaxe-email" style="background-image:url(<?php echo pg .'/assets/imagens/forms_emails/'.$row_forms_emails['id'].'/'.$row_forms_emails['imagem']; ?> );">
          <div class="container">
            <div class="email-text">
              <h2 class="display-4 text-center" style="margin-bottom: 40px"><?php echo $row_forms_emails['titulo']; ?></h2>
                <p class="lead text-center" style="margin-bottom: 40px;"><?php echo $row_forms_emails['descricao']; ?></p>
            </div>
            <div class="email-form">
              <!-- Fui dentro do boot strap em formulário inline e utilizei aqui embaixo 
              E depois apaguei o seletor "form-inline" do form -->
              <!-- Dentro do FORM vou utilizar uma ACTION que envia as ações para outra pagina,
              e vou utilizar um metodo poderia ser o GET, mas vou utilizar o POST
              Eu colocando o PG; vai ficar a inial do HTTP barra e a pagina -->
              <form action="<?php echo pg; ?>/proc_cad_lead" method="POST">
                <!-- Criando uma div para centralizar o conteudo utilizando o seletor justify-content-center 
                Só coloquei form-row, para dizer que é um formulário em linha -->
                <div class="form-row justify-content-center">  
                  <!-- Criei essa outra div para dizer que a coluna quando estiver em dispositivos SM ocupe 3 grid -->
                  <div class="col-sm-4 my-1">
                    <label class="sr-only">E-mail</label>
                    <div class="input-group mb-2 mr-sm-2">
                      <div class="input-group-prepend">
                        <div class="input-group-text">@</div>
                      </div>
                        <!-- Aqui no INPUT vou botar um atributo NAME, para botar um nome para o campo -->
                      <input type="email" name="email" class="form-control" placeholder="Digite seu e-mail">
                    </div> 
                  </div>
                    <!-- Como eu criei um acima para a coluna tbm vou criar para o botão 
                    Quando eu utilizo o col-auto, estou dizendo que ela mesmo que vai determinar -->
                    <div class="col-auto my-1"> 
                        <!-- No LUGAR de ser botão, agora vai ser um INPUT, e vou colocar um VALUE a ele também 
                        E dentro do value vai ficar o titulo do botão que está no PHP, e tbm vou atribuir um NAME a ele
                        Vai ser SendCadLead só para saber que ele está cadastrando pelo LEAD -->
                      <input type="submit" class="btn btn-primary mb-2" value="<?php echo $row_forms_emails['titulo_botao']; ?>" name="SendCadLead">
                    </div> 
              </div>
              </form>
            </div>
          </div>
        </div>
        <!-- Vou abrir outro PHP, em relação a conexão com a tabela de PERGUNTAS e RESPOSTAS 
        WHERE É A CONDIÇÃO OU SEJA SÓ VOU QUERER SE ESTIVER ATIVO, DE ACORDO COM A TABELA
        ESTRAGEIRA QUE TEM AS SITUAÇÕES: ATV, DSTV... -->
        <?php
        $result_perg_resp = "SELECT * FROM sts_pergs_resps WHERE sts_situacoe_id=1";
        $resultado_perg_resp = mysqli_query($conn, $result_perg_resp)
        //VOU FAZER A LEITURA DESSA VARIAVEL JÁ DENTRO DO ACCORDION
        ?>
        
        <!-- Criando outro jumbotron -->
        <div class="jumbotron perg-resp">
          <div class="container">
            <!-- Criei um seletor perg-resp-text para criar uma animação-->
              <h2 class="display-4 text-center perg-resp-text" style="margin-bottom: 40px"> Perguntas e Respostas </h2>
              <!-- Criei outro seletor perg-resp-conteudo, para criar uma animação para o conteudo -->
              <div class="perg-resp-conteudo">
                  <div class="accordion" id="accordionExample">
                      <!-- Vou abrir aqui o PHP E no meio dos PHP e dentro do WHILE,
                      vou colocar sómente 1 CARD, e ele vai percorrer por todos que tem no BD  -->
                      <?php
                      //Para que uma das perguntas já fique aberta eu utilizo o seletor = show
                      /*Vou criar uma variavel CONTROLE_ACCORDION 
                       * que inicia com 1 para quando for 1, ele vai imprimir o SHOW
                       * Vou colocar essa variavel dentro da RESPOSTA que é onde eu quero visualizar
                       * E INCREMENTAR MAIS UM LÁ NO FINAL SEMPRE
                       */
                      $cont_acord = 1;
                      while($row_perg_resp= mysqli_fetch_assoc($resultado_perg_resp)) 
                      {
                           
                      ?>
                        <div class="card">
                            <!-- ONDE TINHA TWO EU TIREI E COLOQUEI O PHP COM O ID -->
                        <div class="card-header" id="heading<?php echo $row_perg_resp['id'] ?>">
                          <h2 class="mb-0">
                            <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse<?php echo $row_perg_resp['id'] ?>" aria-expanded="false" aria-controls="collapse<?php echo $row_perg_resp['id'] ?>">
                              <?php echo $row_perg_resp['pergunta'] ?>
                            </button>
                          </h2>
                        </div>
                            <!-- O SHOW TEM QUE SER COLOCADO DENTRO DO CLASS -->
                        <div id="collapse<?php echo $row_perg_resp['id']; ?>" class="collapse<?php if($cont_acord == 1) { echo "show"; } ?>" aria-labelledby="heading<?php echo $row_perg_resp['id'] ?>" data-parent="#accordionExample">
                          <div class="card-body">
                            <?php echo $row_perg_resp['resposta'] ?>
                          </div>
                        </div>
                      </div>
                      
                      
                      <?php
                      $cont_acord++;
                      }
                      ?>
                      
                    </div>
              </div>
          </div>
        </div>
      </main>
            <!-- INCLUINDO O RODAPÉ -->
        <?php 
            include_once 'app/sts/rodape.php';
            include_once 'app/sts/rodape_lib.php';
        ?>
       <script>
      // Vou colocar o {reset: true} dentro do ScrollReveal, para ele ficar animando sem ter que resetar a página
      window.sr = ScrollReveal({reset: true});
      //Dentro desse reveal você coloca o .CLASSE, o nome da classe
      //Com esse seletor estou colocando a animação, e eu coloquei o card-servicos, depois do seletor
      //card-deck card-servicos
      //Duration é o tempo que leva para ele ser inserido
      //Esse origin é de onde que ele vai ser inserido, no caso bottom é do rodapé
      sr.reveal('.card-servicos', {
        duration: 1000,
        origin: 'bottom',
        distance: '30px'
      });
      // Como eu quero que os videos, venham do lado esquerdo, direito, e centro vou acrescentar aqui
      // Ou seja isso é uma animação que estou colocando quando eu visualizo a página
      sr.reveal('.dep-left', {
        duration: 1000,
        origin: 'left',
        distance: '30px'
      });
      sr.reveal('.dep-center', {
        duration: 1000,
        origin: 'bottom',
        distance: '30px'
      });
      sr.reveal('.dep-right', {
        duration: 1000,
        origin: 'right',
        distance: '30px'
      });

      sr.reveal('.prod-text', {
        duration: 1000,
        origin: 'left',
        distance: '30px'
      });

      sr.reveal('.prod-img', {
        duration: 1000,
        origin: 'right',
        distance: '30px'
      });

      sr.reveal('.email-text', {
        duration: 1000,
        origin: 'left',
        distance: '30px'
      });

      sr.reveal('.email-form', {
        duration: 1000,
        origin: 'right',
        distance: '30px'
      });

      sr.reveal('.perg-resp-text', {
        duration: 1000,
        origin: 'left',
        distance: '30px'
      });

      sr.reveal('.perg-resp-conteudo', {
        duration: 1000,
        origin: 'right',
        distance: '30px'
      });
      
    </script>
</body>
    

