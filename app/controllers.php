<?php

/**************************************************************************/
/*                          DAVÓ SUPERMERCADOS                       */
/* Criado em: 19/03/2011 por Rodrigo Alfieri                           */
/* Descrição: Classe de controle das páginas Cabeçalho (Header)
 *          , Arquivos/Programas/Telas.php e Rodapé (Footer)              */
/**************************************************************************/

class controllers
{
    var $menu;

    public function execute($tipo)
    {
        //Captura nome da classe anteiormente chamada pelo Extends
        $class      = get_called_class();

        //Captura Objetos da Classe
        $variaveis  = get_object_vars($this);

        //Defini caminho da Página

        $file = "views/".$class."/".$tipo.".php";

        foreach($variaveis as $nomes=>$valores)
                ${$nomes} = $valores;

        //Tratamento de páginas que são carregadas internamente com o jQuery
        list($js) = explode(".",$tipo);

        //Arquivos que são processados pelo jQuery (javascript)
        if (($js=="js") || ($js=="aprovar") )
        {
            include($file);
        //Caso servidor de requisição seja o ORAAS050(172.17.0.3) carrega página inicial Extranet
        }else if ($_SERVER['REMOTE_ADDR']   ==  EXTRANET_HOST)
        {
            //Carrega tela de Login se SESSION estiver vazio, sem usuário.
            if(empty($_SESSION['user']))
            {
                include('template/extranet.php');
            }
            else
            {
                //CABECALHO EXTRANET
                include('template/header_extranet.php');
                //Quando o $_SESSION destruir, ele direciona para a Home

                //CORPO
                $programa   =   new models($conn);
                $class      =   substr($class, -4);
                $id_prog    =   ltrim($class,"0");
                $tp_prog    =   $programa->retornaTpMenu($id_prog);
                $i  =   0;
                foreach($tp_prog as $campos=>$valores);
                if (($valores["T007_tp"]==1) || ($valores['extranet']==1))
                    include($file); 
                else
                {     
                    $file  =   'views/extranet/'.$tipo.'.php';                        
                    include($file);
                }   
                
                //RODAPÉ
                include('template/footer_extranet.php');                    
            }        
        }
        else
        {
            //CABECALHO
            include('template/header.php');
            //Quando o $_SESSION destruir, ele direciona para a Home

            //CORPO
            if (!is_null($_SESSION['user']))
                include($file);
            else
            {
                $programa   =   new models($conn);
                $class      =   substr($class, -4);
                $id_prog    =   ltrim($class,"0");
                $tp_prog    =   $programa->retornaTpMenu($id_prog);
                foreach($tp_prog as $campos=>$valores);
                if ($valores["T007_tp"]==1)
                    include($file); 
                else
                {
                    include('views/home/home.php');

                }                                                 
            }                
            //RODAPÉ
            include('template/footer.php');
        }
    }
}
?>
