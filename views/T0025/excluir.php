<?php
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 15/06/2011 por Jorge Nova                              
 * Descrição: Excluir itens do programa 25 (Fornecedores)
 * Entrada:   $cod, $loja, $nom, $tabela 
 * Origens:   T0025/home, T0025/associar
           
**************************************************************************
*/


// Capturando Dados
echo $pagina        =    $_GET["pagina"];
echo $cod           =    $_GET["cod"];
echo $nom           =    $_GET["nom"];
echo $tabela        =    $_GET["tabela"];
echo $tipo          =    $_GET['tipo'];


if ($tipo == 1)
{
$delim         =             $_GET["campo"]." = ".$_GET["valor"].
                    " AND ". $_GET["campo2"]." = ".$_GET["valor2"].
                    " AND    T026_codigo = $cod";
}
else
{
$delim         =    $_GET["campo"]." = ".$_GET["valor"];
}

//Classe para

$objExcluir     =   new models_T0025();
$Excluir        =   $objExcluir->excluiT027($tabela, $delim);


if (is_null($cod))
{
    header('location:?router='.$pagina);
}
else
{
    header('location:?router='.$pagina."&cod=".$cod.'&nom='.$nom);
}


?>

<?php
/* -------- Controle de versões - T0025/excluir.php --------------
 * 1.0.0 - 15/06/2011 - Jorge --> Liberada versao inicial
 * 1.0.1 - 17/10/2011 - Jorge --> Versão desassocia fornecedor a GWF corretamente,
 * porem sem mensagens de erros. 
 *                                
 */
?>