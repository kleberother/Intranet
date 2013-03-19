<?php

    //Configuração Gerais
    require_once 'app/config.php';

    //Inicialização com __autoload para carregamento das classes
    require_once 'app/start.php';

    //Controle Geral de Cabeçalho, Programas/Home e Rodapé
    require_once 'app/controllers.php';

    //Modelos/Métodos ja construidos e conexão com os BDs
    require_once 'app/models.php';

    //Captura a rota
    $router = $_GET['router'];

    //Verifica se existe valor para rota
    if(isset($router))
        {
          $router = explode('/',$router);
          class_alias($router[0], 'classe');
          $classe = new classe;
              if(!isset($router[1]))
                  {
                    $classe->index("index");
                  }
              else
                  {
                    $classe->index($router[1]);
                  }
        }
    //Caso a rota não tenha valor o programa irá definir a rota padrão para a Home da Intranet ou Extranet
    else if ($_SERVER['REMOTE_ADDR']    ==  EXTRANET_HOST)
    {
          class_alias('extranet', 'classe');
          $classe = new classe;
          $classe->index(home);        
    }else
        {
          class_alias('home', 'classe');
          $classe = new classe;
          $classe->index(home);
        }

?>

