<?php
//Se não ISSET = EXISTIR, a variavel segurança, ela cancele o processo, utilizando o EXIT;
    if(!isset($seguranca)){
        exit;
    }
    //Inclusão do HEADER que contem o BOOTSTRAP, CSS e o CSS PERSONALIZADO
    include_once 'app/sts/header.php';
    /* Vou criar a conexão com o BD e com a tabela utilizando o SELECT
     * SELECIONE NA TABELA SOBRE EMPRESA, ONDE A COLUNA SITUAÇÕES=ATV, DSTV ESTEJA COMO ATIVO
     * E QUERO QUE ELE ORDENE PELA COLUNA CHAMADA ORDEM
     * E COMO EU QUERO DA ORDEM CRESCENTE 1,2,3 VAI SER ASC */
    $result_sobs_emps = "SELECT * FROM sts_sobs_emps WHERE sts_situacoe_id=1 ORDER BY ordem ASC";
    $resultado_sobs_emps = mysqli_query($conn, $result_sobs_emps);
?>
<body>
    <?php
        include_once 'app/sts/menu.php';
    ?>
    
    <main role="main">
        <!-- VOU ADICIONAR O STYLE INLINE COM O PADDING BOTTOM -->
        <div class="jumbotron sobre-empresa" style="padding-bottom: 1rem; margin-bottom: 0px;">
            <div class="container">
            <h2 class="display-4 text-center"> Sobre a empresa Lanlink Informática </h2>
            </div>
        </div>
        <!-- AQUI DENTRO DO MAIN, VOU FAZER A VERIFICAÇÃO PARA VER SE VEIO ALGO DO BD
        E QUANTAS LINHAS TEM A TABELA, OU SEJA DIFERENTE DE ZERO É PQ VEIO ALGO -->
        <?php
            if(($resultado_sobs_emps) AND ($resultado_sobs_emps->num_rows != 0)) {
                // Atribuindo os valores para outra variavel
                /* Vou criar uma variavel controle SOBS_EMPS, 
                  * para criar as animações que precisa no meu jumbotron 
                  * E dizer em um IF que se for igual a um ele impre os jumbotron
                 * PRECISO COLOCAR FORA DO WHILE SE NÃO ELE VAI SER SEMPRE 1 */
                 $cont_sobs_emps = 1;
                while($row_sobs_emps = mysqli_fetch_assoc($resultado_sobs_emps)) {

                 if($cont_sobs_emps == 1) {
                 ?>
                   <div class="jumbotron sobre-empresa">
                    <div class="container">
                      <!-- Essa div abaixo é a div linha, a que coloca tudo na mesma linha -->
                      <div class="row featurette">
                        <!-- Vou criar um seletor para modificar o titulo e o texto -->
                        <div class="col-md-7 order-md-2 emp-text-mod-um">
                          <h2 class="featurette-heading"><?php echo $row_sobs_emps['titulo']; ?></h2>
                          <p class="lead"><?php echo $row_sobs_emps['descricao']; ?></p>
                        </div>
                        <!-- Tbm vou criar um seletor para a imagem -->
                        <div class="col-md-5 emp-img-mod-um">
                          <img class="featurette-image img-fluid mx-auto" src="<?php echo pg; ?>/assets/imagens/sobs_emps/<?php echo $row_sobs_emps['id'] .'/'.$row_sobs_emps['imagem']; ?>" alt="<?php echo $row_sobs_emps['titulo']; ?>">
                        </div>
                      </div>
                    </div>
                  </div>  
        
        
        
                 <?php
                 $cont_sobs_emps=2;
                 //ELSE DO IF ABAIXO PARAR CRIAR A IMAGEM 3
                 }else {
                  
                     //Aqui dentro do ELSE vou IMPRIMIR o 2° JUMBOTRON
                     ?>
                     <div class="jumbotron sobre-empresa">
                        <div class="container">
                          <div class="row featurette">
                            <div class="col-md-7 emp-text-mod-dois">
                              <h2 class="featurette-heading"><?php echo $row_sobs_emps['titulo']; ?></h2>
                              <p class="lead"><?php echo $row_sobs_emps['descricao']; ?></p>
                            </div>
                            <div class="col-md-5 emp-text-mod-dois">
                                <img class="featurette-image img-fluid mx-auto" src="<?php echo pg; ?>/assets/imagens/sobs_emps/<?php echo $row_sobs_emps['id'] .'/'.$row_sobs_emps['imagem']; ?>" alt="<?php echo $row_sobs_emps['titulo']; ?>">
                            </div>
                          </div>
                        </div>
                     </div>
                     
        
                     <?php
                     $cont_sobs_emps=1;
                 }  
                }
                
            }
        
        ?>
        
        
      </main>
    
    
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

      sr.reveal('.emp-text-mod-um', {
        duration: 1000,
        origin: 'right',
        distance: '30px'
      });

      sr.reveal('.emp-img-mod-um', {
        duration: 1000,
        origin: 'left',
        distance: '30px'
      }); 

      sr.reveal('.emp-text-mod-dois', {
        duration: 1000,
        origin: 'right',
        distance: '30px'
      }); 
      
      sr.reveal('.emp-img-mod-dois', {
        duration: 1000,
        origin: 'left',
        distance: '30px'
      });


    </script>
    
</body>

