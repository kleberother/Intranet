<?php

//Chama classes
$pagina        =    $_GET["pagina"];
$cod           =    $_GET["cod"];
$nom           =    $_GET["nom"];
$tabela        =    $_GET["tabela"];
$tipo          =    $_GET["tipo"];


if ($tipo == 1)
{
    echo "entrou aqui";
    
}

else if ($tipo == 2)
{
    
    // captura valor do array passado pelo jquery, infomando todos os IDs dos arquivos
    $valores  = explode(",",$_GET['arquivos']);


    // Contador de quantas exclusões vão ocorrer de arquivos para o loop 
    $contador = count($valores);
    
    // Usuario a ser excluido
    $usuario    =   $_GET['usuario'];    

    for ($i = 0; $i < $contador; $i++)
    {        
        $objExcluir =   new models_T0067();

        // Não executará a exclusão do arquivo físico, e sim apenas da permissão atribuida a ele
        // Exclui da tabela T004_T055

        // Tabela para exclusão
        $tabela     =   "T004_T055";
        
        // Delimitador
        $delim      =   "T055_codigo        =   ".$valores[$i].
                        " AND T004_login    =   '".$usuario."'"; 

        $Excluir    =   $objExcluir->excluir($tabela, $delim);

        if ($Excluir)
        {
           
            $data   =   date('d/m/Y H:i:s');
            
            // Prepara array para inserir na tabela de auditoria 
            $array  =   array   (   "T066_quando"       => $data
                                ,   "T066_usu_login"    => $usuario
                                ,   "T066_usu_nome"     => $_SESSION['DisplayNome']
                                ,   "T066_obj_codigo"   => "67"
                                ,   "T066_obj_nome"     => "js.excluir"
                                ,   "T066_ocorrencia"   => "ARQUIVO N $valores[$i]|DELETE|USUARIO EXTERNO RETIROU ARQUIVO DE SUA LISTAGEM"
                                ,   "T066_address"      => $_SERVER['REMOTE_ADDR'] );
                        
            // Escolhe a tabela para inserir dados
            $tabela =   "T066_auditoria";
            
            // Insere dados na tabela de auditoria
            $insere =   $objExcluir->inserir($tabela, $array);
                     
            if ($insere)
                $retorno = 1;            
            else
                $retorno = "Nao conseguiu inserir na tabela T066_auditoria o evento";
            
        }
        else
        {
            $retorno =  "Nao conseguiu excluir da tabela T004_T055 o arquivo".$valores[$i];
        }        
    }

    // Retorna o dado de resultado
    if (is_numeric($retorno))    
        echo json_encode(1);
    else
        echo json_encode ($retorno);    
    
}


?>