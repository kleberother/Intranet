<?php
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 22/09/2011 por Jorge Nova                              
 * Descrição: Novo Template para display
 * Entrada:   
 * Origens:   
           
**************************************************************************
*/

// INSTANCIA OBJETO DA CLASSE T0054
$objPainel        =  new models_T0054();

// Instancia Classe T0054 para conexao ORACLE
$connORA          =  "ora";
$objRMS     =  new models_T0054($connORA);

//Executa Procedure para Classificação Mercadológica
$objRMS->executaProcedureExportaClassificacaoMerc();

//Executa Procedure para Produtos
$objRMS->executaProcedureExportaProdutos();


/* INTEGRAÇÃO DE CLASSIFICAÇÃO MERCADOLÓGICA  */

// retorna produtos atualizados no RMS
//$ClassificacaoRMS  = $objRMS->retornaItensAtualizadosRMS() ;
//
//$TabelaClassificacao =   "T020_classificacao_mercadologica";
//// percorre cada linha de retorno do Oracle
//while (($row = oci_fetch_array($ClassificacaoRMS))) 
//{
//    //Cria delimitar para insert ou update
//    $delim  =   " T020_departamento = " .$row['ITEMCODIGO']."  
//              AND T020_secao        = " .$row['ITEMDIGITO']."
//              AND T020_grupo        = " .$row['ITEMDIGITO']."
//              AND T020_subgrupo     = " .$row['ITEMDIGITO'];
//    
//    //Monta array com os campos para inserir na tabela de produtos
//    $campos =   array("T075_codigo"                 =>  $row['ITEMCODIGO']
//                     ,"T075_digito"                 =>  $row['ITEMDIGITO']
//                     ,"T075_descricao"              =>  $row['ITEMDESCRICAO']
//                     ,"T075_descricao_comercial"    =>  $row['ITEMDESCRICAOCOMERCIAL']
//                     ,"T020_departamento"           =>  $row['ITEMDEPARTAMENTO']
//                     ,"T020_secao"                  =>  $row['ITEMSECAO']
//                     ,"T020_grupo"                  =>  $row['ITEMGRUPO']
//                     ,"T020_subgrupo"               =>  $row['ITEMSUBGRUPO']
//                    );
//    
//    if($row['TIPO']=='I')
//    {
//        
//        if($objPainel->InsereOuAtualiza($TabelaClassificacao, $campos, $delim));
//        {            
//            $objRMS->atualizaStatusIntegracaoRMS($row['ITEMCODIGO'], $row['ITEMDIGITO']);
//        }
//    }
//    if($row['TIPO']=='U')
//    {
//        if($objPainel->altera($TabelaClassificacao,$campos,$delim));        
//        {
//            $objRMS->atualizaStatusIntegracaoRMS($row['ITEMCODIGO'], $row['ITEMDIGITO']);
//        }
//    }
//}

/*  INTEGRAÇÃO DE PRODUTOS  */

// retorna produtos atualizados no RMS
$ProdutosRMS  = $objRMS->retornaItensAtualizadosRMS() ;


$RetornoRMS   = array () ;
$InsertPrecos = array () ;

$TabelaProdutos =   "T075_produtos";
// percorre cada linha de retorno do Oracle
while (($row = oci_fetch_array($ProdutosRMS))) 
{
    //Cria delimitar para insert ou update
    $delim  =   " T075_codigo = ".$row['ITEMCODIGO']."  
              AND T075_digito = ".$row['ITEMDIGITO'];
    
    //Monta array com os campos para inserir na tabela de produtos
    $campos =   array("T075_codigo"                 =>  $row['ITEMCODIGO']
                     ,"T075_digito"                 =>  $row['ITEMDIGITO']
                     ,"T075_descricao"              =>  $row['ITEMDESCRICAO']
                     ,"T075_descricao_comercial"    =>  $row['ITEMDESCRICAOCOMERCIAL']
                     ,"T020_departamento"           =>  $row['ITEMDEPARTAMENTO']
                     ,"T020_secao"                  =>  $row['ITEMSECAO']
                     ,"T020_grupo"                  =>  $row['ITEMGRUPO']
                     ,"T020_subgrupo"               =>  $row['ITEMSUBGRUPO']
                    );
    
    if($row['TIPO']=='I')
    {
        
        if($objPainel->InsereOuAtualiza($TabelaProdutos, $campos, $delim));
        {            
            $objRMS->atualizaStatusIntegracaoRMS($row['ITEMCODIGO'], $row['ITEMDIGITO']);
        }
    } 
    if($row['TIPO']=='U')
    {
        if($objPainel->alterar($TabelaProdutos,$campos,$delim));        
        {
            $objRMS->atualizaStatusIntegracaoRMS($row['ITEMCODIGO'], $row['ITEMDIGITO']);
        }
    }
}

?>
<?php
/* -------- Controle de versões - js.display-06.php --------------
 * 1.0.0 - 22/09/2011 - Jorge --> Liberada versao inicial
 *                                
 */
?>