<?php
$obj    = new models_T0095();

$codigoAuditoria    =   $_POST["codigoAuditoria"];
$perfil =   $obj->retornaPerfil($_SESSION["user"]);

foreach ($perfil as $key => $value) {
    
    $perfilUser =   $value["PERFIL"];
    
}

$dadosRuptura = $obj->retornaRupturasLoja2($codigoAuditoria, $_SESSION['user']);

$html   =   "";

$html   =   "<span class='lista_itens'>";
$html   .=  " <table>";
$html   .=  "        <thead>";
$html   .=  "           <tr bgcolor='#333333'>";
$html   .=  "               <th align='center'>Cod. RMS</th>";
$html   .=  "               <th>EAN</th>";
$html   .=  "               <th>Descrição</th>";
$html   .=  "               <th>Preço RMS</th>";
$html   .=  "               <th>Estoque RMS</th>";
$html   .=  "               <th>Estoque Loja</th>";
$html   .=  "               <th>Oferta</th>";
$html   .=  "               <th colspan='2'>Confirma Estoque RMS ?</th>";

$html   .=  "          </tr>";
$html   .=  "       </thead>";
$html   .=  "     <tbody>";

$i       =  0;

foreach ($dadosRuptura as $campos => $valores)
{
    if ($i%2==0)
        $corlinha   =   "#E8E8E8";
    else
        $corlinha   =   "";

$html   .=  "        <tr style='background-color:".$corlinha."'>";

$html   .=  "           <td align='center' valign='center' class='codigoItem'>".$valores['CodigoPaiRMS']."                                   </td>";
$html   .=  "           <td align='center'>".$valores['Ean']."                                         </td>";
$html   .=  "           <td align='center'>".$valores['Descricao']."                                   </td>";
$html   .=  "           <td align='center'>".$valores['PrecoRMS']."                                    </td>";
$html   .=  "           <td align='center'>".$valores['Estoque']."                                     </td>";
$html   .=  "           <td align='center'>  0                                                          </td>";
$html   .=  "           <td align='center'>".$valores['Oferta']."                                      </td>";
$html   .=  "           <td align='center'> <input type='button' class='botao-padrao confirma' value='Não Confirma' style='width:95px;'> </td>";
if (($perfilUser ==  '55' && is_null($valores["StatusGe"]))||($perfilUser   ==  '56' && is_null($valores["StatusInv"]))) {
$html   .=  "           <td align='center'> <input type='button' class='botao-padrao naoconfirma' value='Confirma' style='width:65px;'> </td>";
} else{
$html   .= "<td align='center'></td>";
}
$html   .=  "       </tr>";

$i++;

}
$html   .=  "    </tbody>    ";
$html   .=  "    </table>    ";
$html   .=  "    </span>    ";
$html   .=  "<input type='hidden' name='CodigoAuditoria' id='CodigoAuditoria' value=".$codigoAuditoria.">";


echo $html;

?>

