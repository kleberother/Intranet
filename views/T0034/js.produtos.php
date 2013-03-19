<?php
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 05/10/2011 por Rodrigo Alfieri
 * Descrição: Retorna para jQuery os Produtos do Filtro
           
***************************************************************************/

//Instancia classe
$obj                    =   new models_T0034();

//Variaveis para filtro
$FiltroArea             =   $_GET['AreaTemplate']           ;           //codigo Area
$PainelCodigo           =   $_GET['PainelCodigo']           ;           //codigo do painel
$TemplateCodigo         =   $_GET['TemplateCodigo']         ;           //Area Template

//Campos diferente de NULL/Branco são atribuidos em suas respecitvas variaveis
if (!empty($_GET['ProdutoCodigo']))
     $FiltroCodigo      =   $_GET['ProdutoCodigo']          ;           //codigo departamento
if (!empty($_GET['ProdutoDescricao']))
     $FiltroDescricao   =   $_GET['ProdutoDescricao']       ;           //codigo departamento
if (!empty($_GET['ProdutoDepartamento']))
     $FiltroDepto       =   $_GET['ProdutoDepartamento']    ;           //codigo departamento
if (!empty($_GET['ProdutoSecao']))
     $FiltroSecao       =   $_GET['ProdutoSecao']           ;           //codigo secao
if (!empty($_GET['ProdutoGrupo']))
     $FiltroGrupo       =   $_GET['ProdutoGrupo']           ;           //codigo grupo
if (!empty($_GET['ProdutoSubGrupo']))
     $FiltroSubGrupo    =   $_GET['ProdutoSubGrupo']        ;           //codigo subgrupo


// Monta Filtro para trazer nos produtos para Associar
$Filtro     = '';
if(!empty($FiltroCodigo))
    $Filtro  .= " AND 10*T75.T075_codigo+T75.T075_digito    =   "   .$FiltroCodigo;
if(!empty($FiltroDescricao))
    $Filtro .= " AND T75.T075_descricao_comercial LIKE      '%"     .$FiltroDescricao."%'";
if($FiltroDepto!="null" )
    $Filtro .= " AND T75.T020_departamento                  =   "   .$FiltroDepto;
if($FiltroSecao!="null" )
    $Filtro .= " AND T75.T020_secao                         =   "   .$FiltroSecao;
if($FiltroGrupo!="null")
    $Filtro .= " AND T75.T020_grupo                         =   "   .$FiltroGrupo;
if($FiltroSubGrupo!="null")
    $Filtro .= " AND T75.T020_subgrupo                      =   "   .$FiltroSubGrupo;    
 
$Produtos               =   $obj->retornaProdutosParaAssociar($PainelCodigo,$TemplateCodigo,$FiltroArea,$Filtro);
//echo $Filtro;    
$i=0;
foreach($Produtos as $campos=>$valores)
{
    $dados[$i] = $valores;
    $i++;
}

echo json_encode($dados);

?>
<?php
/* -------- Controle de versões - js.classificacao.php --------------
 * 1.0.0 - 05/10/2011   --> Liberada a versão
*/
?>