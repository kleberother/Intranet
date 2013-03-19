<?php
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 16/09/2011 por Jorge Nova                              
 * Descrição: Arquivo exclui templates já cadastrados
 * Entrada:   $codigo -> codigo do template
 * Origens:   T0036/home
           
**************************************************************************
*/

// RECUPERA PAGINA DE REDIRECIONAMENTO
$pagina        =    $_GET["pagina"];

// RECUPERA CODIGO DE ASSOCIAÇÃO
// $codigo        =    $_GET["cod"];

// TABELA A SER ATUALIZADA
$tabela        =    $_GET["tabela"];

// RECUPERA E IGUALA O CAMPO DE DELIMITADOR
$delim         =    $_GET["campo"]." = ".$_GET["valor"];

// INSTANCIA OBJETO DA CLASSE T0036
$obj           =    new models_T0036();

// CLASSE PARA EXCLUIR
$excluir       =   $obj->excluir($tabela, $delim);

if ($excluir)
{
    if (is_null($cod))
    {
        header('location:?router='.$pagina);
    }
    else
    {
        header('location:?router='.$pagina."&cod=".$cod);
    }
}
else
{
    echo "<script>alert('ERRO AO EXCLUIR');</script>";
    echo "<script>window.location = '?router=$pagina';</script>";
}


?>

<?php
/* -------- Controle de versões - T0036.php --------------
 * 1.0.0 - 16/09/2011 - Jorge --> Liberada versao inicial
 *                                
 */
?>