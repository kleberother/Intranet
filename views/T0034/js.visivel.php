<?php
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 28/09/2011 por Rodrigo Alfieri
 * Descrição: altera pelo checkbox visivel
           
***************************************************************************/

//Instancia classe
$obj            =   new models_T0034();
//Tabela a ser alterada
$Tabela         =   "T075_T078_T080";
//Parametros do jQuery checkbox.js (Código do Painel, Área e Item) [Ex.: 5,10,2478]
$Dados          =   $_GET['Dados'];
//Separa os dados e atribui a um array
$Dados          =   split(",",$Dados);

$Painelcodigo   =   $Dados[0];
$AreaCod        =   $Dados[1];
$ItemCodigo     =   $Dados[2];

//Variavel para verificar houve seleção ou não-seleção
$Evento =   $_GET['Evento'];

//Delimitador para Update
$Where = "  T075_codigo=".$ItemCodigo.
        " AND T078_codigo=".$Painelcodigo.
        " AND T080_codigo=".$AreaCod
        ;
   
$campo = array("T075_T078_T080_visivel" => $Evento);

//Update
$obj->alteraVisibilidade($Tabela,$campo,$Where);

?>
<?php
/* -------- Controle de versões - js.classificacao.php --------------
 * 1.0.0 - 28/09/2011   --> Liberada a versão
*/
?>