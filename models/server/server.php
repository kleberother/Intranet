<?php

/**************************************************************************/
/*                          DAVÓ SUPERMERCADOS                            */
/* Criado em: 15/12/2011 por Rodrigo Alfieri                              */
/* Descrição: Classe para executar as Querys do Programa T00              */
/**************************************************************************/

class models_server extends models
{

    public function __construct()
    {
        $conn = "";
        parent::__construct($conn);        
    }
    
    public function instanciaServidor()
    {
        //Criação de uma instnância do servidor (coloque o endereço na sua máquina local)
        $server = new SoapServer(null, array('uri' => "http://localhost/?router=server/home"));

        function hello($name)
        {
            return "Olá".$name;
        }

        //registro do serviço
        $server->addFunction("hello");
        //chamada do método para atender as requisições do serviço
        //se a chama for um POST executa, senão apenas mostra as funções "cadastradas"

        if($_SERVER['REQUEST_METHOD'] == "POST")
        {
            $server->handle();    
        }else
        {
            $functions = $server->getFunctions();
            foreach($functions as $func)
            {
                return $func. "<br>";
            }
        }
        
    }

    
}
?>
