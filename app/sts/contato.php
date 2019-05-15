<!-- Foi criado a pagina contato dentro do STS de site , e foi criado como um arquivo PHP -->

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
    ?>
    
    <main role="main">
        <!-- Aqui dentro do FORM vou dizer qual o METODO que é o POST
        e do lado no ACTION vou dizer para qual página ele irá enviar os dados-->
        <form method="POST" action="<?php echo pg.'/proc_cad_contato' ?>">
                <!-- Como vou querer modificar a cor de fundo, vou utilizar o seletor contato que criei do lado do jumbotron -->
              <div class="jumbotron contato">
                <div class="container">
                        <h2 class="display-4 text-center" style="margin-bottom: 50px">Contato</h2>
                        <!-- Aqui abaixo do titulo vou criar um PHP, vai fazer a condição de caso de erro
                        SE existir(ISSET) a mensagem global ele imprime, se não blz
                        Já que no caso eu criei uma mensagem de erro no PROC_CAD_CONTATO, usando o SESSION, que é o global
                        Se existe a mensagem global ele imprime e UNSET para destruir a mensagem GLOBAL 
                        PROFESSOR COLOCOU EM CIMA DO TITULO, MAS EU PREFERIR AQUI ABAIXO MESMO 
                        QUALQUER COISA É SO COPIAR O PHP QUE CONTEM AS MENSAGEM DE ERRO E ACERTO -->
                        <?php
                            if(isset($_SESSION['msg'])) {
                                echo $_SESSION['msg'];
                                unset($_SESSION['msg']);
                            }
                        ?>
                    <div class="form-row">
                        <!-- Como vou colocar animação eu coloco dentro do form-group -->
                        <div class="form-group col-md-6 form-nome">
                            <label>Nome</label>
                            <!-- Aqui dentro do INPUT vou atribuir um NOME, com o valor do mesmo da tabela no BD
                            E vou colocar o atributo REQUIRED conforme o HTML 5 que quer dizer que o campo será OBRIGATORIO
                            Criei um PHP dentro de cada CAMPO, e disse que se EXISTIR a variavel que criei no PROC_CAD_CONTATO 
                            Que é a variavel global $_SESSION['dados'] AQUI AO LADO É O CAMPO ['nome'] , e imprimo essa variavel 
                            Para que não seja perdido nenhum dado, após o erro-->
                            <input type="text" name="nome" class="form-control" placeholder="Digite seu nome" value="<?php if(isset($_SESSION['dados']['nome'])) { echo $_SESSION['dados']['nome']; } ?>" required>
                        </div>
                        <div class="form-group col-md-6 form-email">
                          <label>E-mail</label>
                          <input type="email" name="email" class="form-control" placeholder="Digite seu e-mail" value="<?php if(isset($_SESSION['dados']['email'])) { echo $_SESSION['dados']['email']; } ?>" required>
                        </div> 
                    </div>
                    <div class="form-group assunto">
                      <label>Assunto</label>
                      <input type="text" name="assunto" class="form-control" placeholder="Assunto da mensagem" value="<?php if(isset($_SESSION['dados']['assunto'])) { echo $_SESSION['dados']['assunto']; } ?>" required>
                    </div>
                    <div class="form-group mensagem">
                      <label>Mensagem</label>
                      <!-- Como o campo mensagem é um campo maior vou tirar o input e colocar o textarea
                        No seletor rows="" Vou dizer quantas linhas vou querer que seja exibida -->
                      <!-- Aqui dentro TEXTAREA eu coloco o PHP entre os fechamento
                         Nos demais que são INPUT, eu coloco dentro do INPUT
                         E vou destruir esse sessão lá no final da PAGINA -->
                      <textarea type="text" name="mensagem" class="form-control" rows="5" required>
                          <?php 
                            if(isset($_SESSION['dados']['mensagem']))
                            {
                                echo $_SESSION['dados']['mensagem'];    
                            } 
                          ?>
                      </textarea>
                    </div>
                    <!-- Vou modificar o button, vai ficar como INPUT, e o Enviar vai estar dentro de um VALUE -->
                    <!--<button type="submit" class="btn btn-primary">Enviar</button> 
                    Vou atribuir um NAME com o valor Send(ENVIAR)Cad(CADASTRAR)Cont(CONTATO)-->
                    <input type="submit" name="SendCadCont" class="btn btn-primary" value="Enviar">
            </div>
                </div>
            </form>
      </main>
    
    
    <?php
        /*Destruindo a mensagem global SESSION, para não poder REUTILIZAR,
         *  ou seja quando ele atualizar a PAG vai ser destruido os valores */
        unset($_SESSION['dados']);
        include_once 'app/sts/rodape.php';
        include_once 'app/sts/rodape_lib.php';
    ?>
    <!-- Coloquei as animações JAVASCRIPT que tinha no LAYOUT e coloquei aqui -->
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

      sr.reveal('.form-nome', {
        duration: 1000,
        origin: 'left',
        distance: '30px'
      });

      sr.reveal('.form-email', {
        duration: 1000,
        origin: 'right',
        distance: '30px'
      });

      sr.reveal('.assunto', {
        duration: 1000,
        origin: 'left',
        distance: '30px'
      });

      sr.reveal('.mensagem', {
        duration: 1000,
        origin: 'right',
        distance: '30px'
      });

    </script>
</body>

