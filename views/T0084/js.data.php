<?php
/**************************************************************************/
/*                          DAVÓ SUPERMERCADOS                            */
/* Criado em: 18/04/2012 por Rodrigo Alfieri                              */
/* Descrição:                                                             */
/**************************************************************************/

$obj    =   new models_T0084();

$DataEmissao    =   $_REQUEST['DtEmiss']        ; 
$NumDias        =   (int)$_REQUEST['NumDias']   ;
$DataHoje       =   date("d/m/Y")               ;
$DiffDias       =   $obj->dateDiff($DataEmissao, $DataHoje);


if($DataEmissao>$DataHoje)
    echo 0; //retorno jQuery quando Dtemiss > DataHoje
elseif($DiffDias>$NumDias)
    echo 1; //retorno jQuery quando Diferença de Dias é maior que para de Dias Retroativos
else
    echo 2; //retorno

?>
