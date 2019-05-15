<head>
    <meta charset="UTF-8">
    <!-- FUI NO LAYOUT E PEGUEI OS DADOS DO CABEÇALHO QUE PRECISO E COLOQUEI AQUI -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Esse LINK que vou criar abaixo é para os buscadores GOOGLE, ele sempre vai ser recohecido
    Como esse endereco dentro da '' vou colocar o endereço que eu estou acessando
    Como eu recebo no arquivo INDEX.PHP, pela variavel URL, e atribuio para a $url_limpa
    Que já retirei os caracteres especiais e ETC
    ISSO OTIMIZA PARA OS BUSCADORES -->
    <link rel="caconical" href="<?php echo pg.'/'.$url_limpa; ?>">
    <!-- Abrir o PHP dentro do titulo, e puxei o nome pelo BD, imprimindo a variavel que contem os dados do BD 
    NA COLUNA EM QUE EU QUERO QUE É A NOME_PAGINA = < ?php echo $row_pagina['nome_pagina'] ?>
    Alterei a variavel nome_pagina no BD para titulo, e alterei aqui no HEADER tbm -->
    <title><?php echo $row_pagina['titulo']; ?></title>
    <!-- Essa são as palavras chaves para encontrar o site, puxando do BD 
    <meta name="keywords" content="PHP, HTML, CSS, BootStrap, JavaScript"> 
    SÓ QUE VOU FAZER PUXANDO DO BANCO DE DADOS UTILIZANDO O PHP -->
    <!-- NA TAG ROBOTS ELE DEVE INDEXAR E SEGUIDA PELOS BUSCADORES = INDEX, FOLLOW -->
    <!-- NO ROBOTS FICOU O NOME TIPO, PQ FIZ A MODIFICAÇÃO NO INDEX, E PARA FICAR PARA TODAS QUE UTILIZAM O HEADER -->
    <meta name="robots" content="<?php echo $row_pagina['tipo']; ?>">
    <meta name="keywords" content="<?php echo $row_pagina['keywords']; ?>">
    <!-- Proxima TAG vai ser a DESCRIÇÃO -->
    <meta name="description" content="<?php echo $row_pagina['description']; ?>">
    <meta name="author" content="<?php echo $row_pagina['author']; ?>">
    
    <!-- ISSO TBM PEGUEI DO LAYOUT, MAS VOU DEIXAR DEPOIS DO CEO
    COMO ESTÁ DENTRO DO DIRETORIO ASSETS, EU FAÇO A MODIFICAÇÃO, E ANTES DO ASSETS, 
    TEM QUE COLOCAR O DOMINIO E FICA EM UMA VARIAVEL DEFINED, QUE ESTÁ NO ARQUIVO CONFIG.PHP 
    E SEMPRE QUE EU MUDAR DE SERVIDOR, DE DOMINIO E ETC, EU MODIFICO NESSE ARQUIVO
    E A VARIAVEL QUE ESTÁ GUARDADA O DOMINIO É NA VARIAVEL pg 
    E PARA EXECUTAR O DOMINIO EU UTILIZO O PHP 
    <? php echo pg; ?> -->
    <!-- Aqui ele está incluindo o Bootstrap CSS -->
    <link rel="stylesheet" href="<?php echo pg; ?>/assets/css/bootstrap.css">
    <!-- Incluindo a fonte dos icones -->
    <link rel="stylesheet" href="<?php echo pg; ?>/assets/css/ionicons.min.css">
    <!-- Irei utilizar um arquivo que copiei do bootstrap e modifiquei o nome para personalizado -->
    <link rel="stylesheet" href="<?php echo pg; ?>/assets/css/personalizado.css">
    <!-- NO LUGAR DE USAR O ICONE DO WAMPSERVER, VOU UTILIZAR UM ICONE MEU -->
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo pg.'/assets/imagens/icone/icone.ico'; ?>"/>
</head>