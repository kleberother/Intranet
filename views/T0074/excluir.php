<?php

//Chama classes
$pagina        =    $_GET["pagina"];
$cod           =    $_GET["cod"];
$tabela        =    $_GET["tabela"];
$tipo          =    $_GET['tipo'];

// Número do programa
$numprog    =   "74";

// Nome do programa
$nomeprog   =   "EXCLUIR";  

$obj           =   new models_T0074();

if ($tipo == 1)
{

    if(is_numeric($_GET["valor"]))
    {
        $delim        =    $_GET["campo"]." = ".$_GET["valor"];
    }
    else
    {
        $delim        =    $_GET["campo"]." = "."'".$_GET["valor"]."'";
    }
        
    // Exclui da tabela T004_T004
    $Excluir01  =   $obj->excluir("T004_T004", $delim);

    
    
    // Verifica se a exclusão deu certa, para inserir a mensagem na tabela de auditoria
    if ($Excluir01)
    {
        $ocorrencia =   "USUARIO ".strtoupper($_GET['valor'])."|DELETE|REMOVEU TODAS AS ASSOCIACOES DA TABELA T004_T004";

        $obj->insereAuditoria($numprog, $nomeprog, $ocorrencia);
    }
    else
    {
        $ocorrencia =   "USUARIO ".strtoupper($_GET['valor'])."|DELETE|NAO CONSEGUIU REMOVER TODAS AS ASSOCIACOES DA TABELA T004_T004";

        $obj->insereAuditoria($numprog, $nomeprog, $ocorrencia);        
    }
    
    // Exclui da tabela T004_usuario
    $Excluir02  =   $obj->excluir("T004_usuario", $delim);
    
    // Verifica se a exclusão deu certa, para inserir a mensagem na tabela de auditoria
    if ($Excluir02)
    {
        $ocorrencia =   "USUARIO ".strtoupper($_GET['valor'])."|DELETE|REMOVEU USUARIO DA TABELA T004_USUARIO";

        $obj->insereAuditoria($numprog, $nomeprog, $ocorrencia);
    }
    else
    {
        $ocorrencia =   "USUARIO ".strtoupper($_GET['valor'])."|DELETE|NAO REMOVEU USUARIO DA TABELA T004_USUARIO";

        $obj->insereAuditoria($numprog, $nomeprog, $ocorrencia);        
    }
    
    // Redireciona para home
    header('location:?router=T0074/home');       
    
    
}

else if ($tipo == 2)
{
  
    // Encontra os arquivos do usuário para retirar as permissões
    $arquivos   =   $obj->retornaArquivosUsuario($_GET['valor2']);
    
    foreach($arquivos as $campos=>$valores)
    {
        
        $delim1     =   "T004_login = '".$_GET['valor']."' AND T055_codigo = ".$valores['Codigo'];
    
        $Excluir02  =   $obj->excluir("T004_T055", $delim1);
        
        // Verifica se a exclusão deu certa, para inserir a mensagem na tabela de auditoria
        if ($Excluir02)
        {
            $ocorrencia =   "USUARIO ".strtoupper($_GET['valor'])." ARQUIVO N ".$valores['Codigo']."|DELETE|REMOVEU PERMISSOES DA TABELA T004_T055";

            $obj->insereAuditoria($numprog, $nomeprog, $ocorrencia);
        }
        else
        {
            $ocorrencia =   "USUARIO ".strtoupper($_GET['valor'])." ARQUIVO N ".$valores['Codigo']."|DELETE|NAO REMOVEU PERMISSOES DA TABELA T004_T055";

            $obj->insereAuditoria($numprog, $nomeprog, $ocorrencia);        
        }        
               
    }
    
    $delim        =       $_GET['campo']." = '".$_GET['valor']."' AND ".$_GET['campo2']." = '".$_GET['valor2']."'";
    
    $Excluir01  =   $obj->excluir("T004_T004", $delim);
      
    
    // Verifica se a exclusão deu certa, para inserir a mensagem na tabela de auditoria
    if ($Excluir01)
    {
        $ocorrencia =   "USUARIO ".strtoupper($_GET['valor'])."|DELETE|REMOVEU USUARIO DA TABELA T004_T004";

        $obj->insereAuditoria($numprog, $nomeprog, $ocorrencia);
    }
    else
    {
        $ocorrencia =   "USUARIO ".strtoupper($_GET['valor'])."|DELETE|NAO REMOVEU USUARIO DA TABELA T004_T004";

        $obj->insereAuditoria($numprog, $nomeprog, $ocorrencia);        
    }
    
    header("location:?router=T0074/associar&login=".$_GET['valor2']);    
    
}


?>