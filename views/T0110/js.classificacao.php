<?php
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 14/09/2011 por Rodrigo Alfieri
 * Descrição: Retorna para jQuery os combos da classificação mercadológica (Seção, Grupo e SubGrupo)   
           
***************************************************************************/

//Instancia classe
$obj        =   new models_T0110();
//Atribuições nas variaveis
$depto      =   $_GET['Depto'];
$secao      =   $_GET['Secao'];   
$grupo      =   $_GET['Grupo'];
 
//Verifica qual combo foi selcionado
if((empty($secao))&&(empty($grupo))&&(empty($subgrupo)))
{
    $dados =   $obj->retornaSecoes($depto);
}else if ((empty($grupo))&&(empty($subgrupo)))
{
    $dados =   $obj->retornaGrupos($depto, $secao);   
}else if (empty($subgrupo))
{
    $dados =   $obj->retornaSubGrupos($depto, $secao, $grupo);
}

//Cria retorno para jQuery incluir dinamicamente o combo no html
foreach($dados as $campos=>$valores)
{
    $html .='<option value='.$valores['Codigo'].'>'.$obj->preencheZero("E", 3, $valores['Codigo']).' - '.$valores['Descricao'].'</option>';
}    
echo json_encode($html);

?>
<?php
/* -------- Controle de versões - js.classificacao.php --------------
 * 1.0.0 - 14/09/2011   --> Liberada a versão
*/
?>