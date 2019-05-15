    <!-- PARA NÃO TER QUE UTILIZAR O MENU EM TODAS AS PAGINAS, EU CRIEI UMA PAGINA ESPECIFICA PARA ISSO, 
    E VOU INCLUINDO ELA NAS PAGINAS -->
    <!-- Vou criar o SELECT para puxar as informações do Banco
    Já que eu criei o NOME_PAGINA, para se referir ao nome da pagina, diferente do titulo que era o nome antes -->
    <?php
    /* SELECIONE AS COLUNA ENDERECO, NOME_PAGINA DA TABELA STS_PAGINA, ONDE A COLUNA
     * LIB_BLOQ TEM QUE SER 1, QUE QUER DIZER LIBERADA, E ORDENE PELA COLUNA ORDEM */
    
    $result_menu = "SELECT endereco, nome_pagina FROM sts_paginas WHERE lib_bloq=1 ORDER BY ordem ASC";
    $resultado_menu = mysqli_query($conn, $result_menu);
    //Agora que tenho o resultado, vou utilizar o while para imprimir os itens do menu
    ?>
    
    
    
    
    <header>
        <!-- Se utiliza a nav pois ele é um menu -->
        <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <!-- Como eu quero que ele utilize o tamanho do container, eu irei colocar ele dentro do container -->
        <div class="container">
          <a class="navbar-brand" href="<?php echo pg; ?>/home">Lanlink</a>
          <!-- Esse botão abaixo se refere aquele botão que quando a página fica do tamanho pequeno
            Ele se ajuda e bota os icones dentro dele -->
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <!-- Itens do menu que é colocado dentro dessa div -->
          <div class="collapse navbar-collapse" id="navbarCollapse">
            <!-- UL É UMA LISTA, E LI É O ITENS DA LISTA
            E aqui vou fazer as modificações para ficar do lado esquerdo 
            Vou colocar o seletor NAV no inicio da CLASSE é um seletor do bootstrap,
            e no lugar de mr-auto, vou colocar ml-auto, que é de LADO -->
            <ul class=" nav navbar-nav ml-auto">
              <?php
              /*PHP CRIADO PARA COLOCAR OS ITENS DO MENU DE ACORDO COM A QUERY
               * Vou criar o while para pecorrer os array dos dados
               * Entre o LI, vou criar o link */
              
              while($row_menu = mysqli_fetch_assoc($resultado_menu)) {
                  echo "<li class='nav-item menu'>";
                  echo "<a class='nav-link' href='".pg."/".$row_menu['endereco']."'>".$row_menu['nome_pagina']." </a>";
                  echo "</li>";
              }
              
              ?>
              <!-- <li class="nav-item menu">
                <a class="nav-link" href="< ?php echo pg; ?>/home">Home</a>
              </li> -->
             
        </div>
            
          </div>
        </nav>
    </header>

