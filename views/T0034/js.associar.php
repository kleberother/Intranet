<?php
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 19/09/2011 por Rodrigo Alfieri
 * Descrição: Retorna para jQuery a lista de produtos associados aos paineis e produtos para associar
           
***************************************************************************/

//Instancia classe
$obj        =   new models_T0034();
//Atribuições nas variaveis

$tipo       = $_GET['tipo'];
$painel     = $_GET['painel'];


if($tipo==1)
{
    $i = 0;
    $html = "";
    $resultado = $obj->retornaProdutosAAssociar($painel);
    foreach($resultado as $campos => $valores)
    {
        $html .= "<option value='".$valores['Codigo']."'>".$obj->preencheZero('E', 5, $valores['Codigo'])." - ".$valores['Descricao']."</option>";
    }
    
    echo json_encode($html);
    
}
else
{
    $resultado = $obj->retornaProdutosAssociados($painel);      
    foreach($resultado as $campos => $valores)
    {
        $html .= "<option value='".$valores['Codigo']."'>".$obj->preencheZero('E', 5, $valores['Codigo'])." - ".$valores['Descricao']."</option>";
    }
    
    echo json_encode($html);  
}


?>
<?php
/* -------- Controle de versões - js.classificacao.php --------------
 * 1.0.0 - 19/09/2011   --> Liberada a versão
*/
?>