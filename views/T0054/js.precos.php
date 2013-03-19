<?php
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 22/09/2011 por Jorge Nova                              
 * Descrição: Novo Template para display
 * Entrada:   
 * Origens:   
           
**************************************************************************
*/
   
include('js.produtos.php'); 
   

// GRAVA SESSÃO DE UM USUÁRIO EM UMA VARIAVEL
$user               = $_SESSION['user'];

// INSTANCIA OBJETO DA CLASSE T0054
$objPainel          =  new models_T0054();

// Instancia Classe T0054 para conexao ORACLE
$connORA            =  "ora"                                        ;
$verificaConexao    =  1                                            ;
$objPrecosRMS       =  new models_T0054($connORA,$verificaConexao)  ;

// Instancia Classe T0057 para conexao Emporium
$connEMP            =  "emporium"                                   ;               
$verificaConexao    =  1                                            ; //se 1 ignora conexao, caso haja erro na conexao com BD do Emporium
$objPrecosEMP       =  new models_T0054($connEMP,$verificaConexao)  ;

$PainelCod  = $_GET['PainelCod'] ;
// Grava Origem, para ser usado no reload do HTML do Template
$Origem = "js.precos&PainelCod=".$PainelCod ;    

$TempoRefresh = "600";

// recupera detalhes do painel
$Painel     = $objPainel->retornaDetalhesPainel($PainelCod) ;
foreach($Painel as $campos=>$valores)
{ 
    $TemplateCod = $valores['TemplateCodigo'] ;
    $LojaCod     = $valores['LojaCodigo'] ;
    $Titulo      = $valores['Titulo'] ;
    $Rodape      = $valores['Rodape'] ;
}
// grava loja sem o digito
$LojaSD     = substr($LojaCod, 0,  strlen($LojaCod)-1);
        

/* grava variaveis da data atual */
$Dia  = date(d); 
$Mes  = date(m); 
$Ano  = date(Y); 
$Hora = date(H);
$Min  = date(i);
$Seg  = date(s);
//$DataHora = $Dia."/".$Mes."/".$Ano." ".$Hora.":".$Min.":".$Seg ;
$DataHora         =   date('d/m/Y H:i:s');

$DataRMS7  = ($Ano-1900).$Mes.$Dia;
$DataMySQL = $Ano."-".$Mes."-".$Dia ; 
$DataHoraMySQL = $Ano."-".$Mes."-".$Dia." ".$Hora.":".$Min.":".$Seg ;

$RetornoRMS   = array () ;
$InsertPrecos = array () ;

//echo $PainelCod;

$PrecosPainel   = $objPainel->retornaProdutosPrecosPainel($PainelCod) ;

foreach($PrecosPainel as $campos=>$valores)
 { 
     // retorna preços atuais (na Intranet) dos produtos
     $ItemCod  = $valores['ItemCod'] ; 
     $ItemDig  = $valores['ItemDig'] ; 
     $ValorDe  = $valores['ValorDe'] ; 
     $ValorPor = $valores['ValorPor'] ; 
     
     //echo "</BR>".$ItemCod."-".$ItemDig."</BR>";
     
     // grava o preco vigente atual
     if ($ValorPor == 0 )
        $PrecoVigente = $ValorDe;
     else
        $PrecoVigente = $ValorPor; 
  
     //echo $PrecoVigente."</BR>";
     
     // Busca Preco Emporium
     $PrecosEMP  = $objPrecosEMP->retornaPrecosEMP($ItemCod.$ItemDig,"'".$DataMySQL."'",$LojaSD);
     //print_r($PrecosEMP);
     // percorre a linha do retorno
     foreach($PrecosEMP as $camposEMP=>$valoresEMP)
     {
         // separa os campos do retorno em um array
         $RetornoEMP = split(',',str_replace('|',',',$valoresEMP[0]));
         
         // lê o retorno (array) do Emporium
         /* Exemplo de Retorno:
         149|23092011
          * Onde:
          * [0] = Preço Vigente (2 decimais)
          * [1] = Data Entrada Preço
          */
         
         // Grava os valores do retorno
         $PreçoVigenteEMP = $RetornoEMP[0]/100;
         $DataPrecoEMP    = $RetornoEMP[1];
         
         //echo $PreçoVigenteEMP;
         
         // verifica se o preço vigente na Intranet está diferente do Emporium
         if ($PrecoVigente != $PreçoVigenteEMP)
         {
             // Busca Precos RMS
             $PrecosRMS  = $objPrecosRMS->retornaPrecosRMS($ItemCod,$DataRMS7,$LojaSD);
             
             // percorre cada linha de retorno do Oracle
             while ($row_ora = oci_fetch_assoc($PrecosRMS))
             {          
                 //print_r($PrecosRMS);
                 // lê o retorno (array) do ORacle
                 /* Exemplo de Retorno:
                 149|230911|199|40811|149|230911|230911|360|141,4
                  * Onde:
                  * [0] = Preço Vigente (2 decimais)
                  * [1] = Data Entrada Preço
                  * [2] = Preço Normal (2 decimais)
                  * [3] = Data Entrada Preço Normal
                  * [4] = Preço Oferta Vigente
                  * [5] = Data Entrada Oferta
                  * [6] = Data Fim Oferta 
                 */

                 foreach($row_ora as $camposRMS=>$valoresRMS)
                 {
                     // separa os campos do retorno em um array
                     $RetornoRMS = split(',',str_replace('|',',',$valoresRMS));

                     // Grava os valores do retorno
                     $PreçoVigenteRMS = $RetornoRMS[0]/100;
                     $PreçoNormalRMS  = $RetornoRMS[2]/100;
                     $DataPrecoRMS    = $RetornoRMS[1];

                         // Insere/Atualiza preço na Intranet
                         $PreçoVigenteRMS ;
                         $PreçoNormalRMS   ;
                         // Verifica se é oferta e grava preços para atualizacao
                         if ($PreçoVigenteEMP == $PreçoNormalRMS)
                         {
                             $TipoPreco = 'N';
                             $PrecoDe   = $PreçoVigenteEMP ; // Preço vigente é sempre do Emporium
                             $PrecoPor  = 0 ;
                         }
                         else
                         {
                             $TipoPreco = 'O';
                             $PrecoDe   = $PreçoNormalRMS  ;
                             $PrecoPor  = $PreçoVigenteEMP ;  // Preço vigente é sempre do Emporium
                         }
                         /*
                         echo $TipoPreco ;
                         echo "</BR>"    ;
                         echo $PrecoDe   ;
                         echo "</BR>"    ;
                         echo $PrecoPor  ;
                         echo "</BR>"    ;
                         */
                         // insere na tabela de preços da Intranet
                         $AtualizacaoPreco = array ( "T075_codigo"    => $ItemCod 
                                                   , "T075_digito"    => $ItemDig
                                                   , "T006_codigo"    => $LojaCod
                                                   , "T079_data"      => $DataHora
                                                   , "T079_tipo"      => $TipoPreco
                                                   , "T079_valor_de"  => $PrecoDe
                                                   , "T079_valor_por" => $PrecoPor
                                                   );
                         
                           $Where = "     T075_codigo=".$ItemCod.
                                    " AND T075_digito=".$ItemDig.
                                    " AND T006_codigo=".$LojaCod.
                                    " AND T079_data='".$DataMySQL."'".
                                    " AND T079_tipo='".$TipoPreco."'"
                                    ;

                         $InsereOuAtualiza = $objPainel->InsereOuAtualiza("T079_precos_produtos", $AtualizacaoPreco,$Where);
                         
                     }

                 }             
             
         }
     }
             
 }
 
 
// Verifica qual o template deve ser chamado
switch ($TemplateCod)
{
    case 1:
        include "js.template-01.php";
        break;
    default:
        include "js.template-01.php";
        break;
} 

?>

<?php
/* -------- Controle de versões - js.display-06.php --------------
 * 1.0.0 - 22/09/2011 - Jorge --> Liberada versao inicial
 *                                
 */
?>