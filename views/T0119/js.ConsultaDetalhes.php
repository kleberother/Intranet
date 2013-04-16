<?php

//Instancia Classe
$conn      =   "emporium";
$objEMP    =   new models_T0119($conn);

$Lote      = $_REQUEST['Lote'];
$Loja      = $_REQUEST['Loja'];

$RetornoDetalhes = $objEMP->ConsultaDetalhesLoteLoja($Loja,$Lote);
#$RetornoDetalhes = $objEMP->ConsultaDetalhesLoteLoja(3,2532);

$HTML    = "
            <div class='conteudo_10'>
            <table id='tDetalhes' class='tablesorter'>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>PLU</th>
                        <th>Descricao</th>
                        <th>Qtde</th>
                        <th>Valor Unit.</th>
                        <th>Valor Total</th>
                    </tr>
                </thead>
                <tbody>";
                 foreach($RetornoDetalhes as $campos=>$valores){
$HTML .=           "<tr>
                        <td>".$valores['sequence']."</td>
                        <td>".$valores['plu_id']  ."</td>
                        <td>".$valores['desc_plu']."</td>
                        <td align='right'>".$objEMP->formataNumero($valores['quantity'],3)."</td>
                        <td align='right'>".$objEMP->formataMoedaSufixo($valores['unit_price'],3)."</td>
                        <td align='right'>".$objEMP->formataMoedaSufixo($valores['amount'])."</td>
                    </tr> ";
                 }  
$HTML .=     "  </tbody>
            </table>
            </div> ";

echo $HTML ; 
?>


  
