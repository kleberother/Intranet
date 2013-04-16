<<<<<<< HEAD
<?php

/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 03/04/2013 Roberta Schimidt    
 * Descrição: Incluir Executores RM
 * Entradas:   
 * Origens:   
           
**************************************************************************
*/

$conn   = "";
$obj    = new models_T0117();



$codRM      =    $_REQUEST["codRM"];
$status     =    $_REQUEST["status"];


if($status == 3){
    
   $tabela =   "T113_requisicao_mudanca";
   $campos =   array("T113_status" => 3);
   $delim  =   "T113_codigo    =   ".$codRM;
    
  echo $obj->altera($tabela, $campos, $delim);

   
}

elseif($status  ==  2){
    
   $tabela =   "T113_requisicao_mudanca";
   $campos =   array("T113_status" => 2);
   $delim  =   "T113_codigo    =   ".$codRM;
    
   $obj->altera($tabela, $campos, $delim);
    
}

?>
=======
<?php

/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 03/04/2013 Roberta Schimidt    
 * Descrição: Incluir Executores RM
 * Entradas:   
 * Origens:   
           
**************************************************************************
*/

$conn   = "";
$obj    = new models_T0117();



$revisado   =    $_REQUEST["revisado"];
$codRM      =    $_REQUEST["codRM"];

if($revisado == 1){
    
   $tabela =   "T113_requisicao_mudanca";
   $campos =   array("T113_status" => 2);
   $delim  =   "T113_codigo    =   ".$codRM;
    
   $obj->altera($tabela, $campos, $delim);
}

?>
>>>>>>> 148f36d03329d248606ec6adce731e4b3d6c3ee5
