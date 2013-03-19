<?php

$cod        = $_GET["cod"];
$codfor     = $_GET["codfor"];
$origem     = $_GET["orig"];
// verifica se origem é da tela de ultimas APs
if ($origem == "ultimas")
    // Concatena origem com codigo do fornecedor
    $origem .= "&FornCodigo=".$_GET["FornCodigo"];

$tabela     = "T008_approval";
//Instancia Classe
 $objAP     = new models_T0016();
 $ap        = $objAP->selecionaAPDF($cod);
 $GrpWkf    = $objAP->selecionaGrupofkw($codfor);

 //Seleciona Lojas
$ListLoja   =   $objAP->listaLojas();

//Captura Login para inserção
$user       =   $_SESSION['user'];


?>
<!-- Busca CNPJ ou CODIGO RMS  -->
<script src="template/js/interno/T0016/busca.js"></script>

<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0016/home" class="active">Listar</a></li>
                <li><a href="?router=T0016/novo">Novo</a></li>
                <?php
                if (($user == 'jnova') || ($user == 'msasanto') || ($user == 'cmlima') || ($user == 'aribeiro') || ($user == 'gssilva'))
                 echo "<li><a href='?router=T0016/monitora'>Visualizar Antigas</a></li>";

                 echo "<li><a href='?router=T0016/painel'>Painel de Aprovações</a></li>";
                ?>
                <li><a href="?router=T0016/fluxo">Fluxo AP</a></li>
            </ul>
        </span>
    </div>
</div>
<?php foreach($ap as $campos=>$valores){

$dt_emissao        = $valores['P0016_T008_DTE'];
$val_emi           = explode(" ",$dt_emissao);
$date_emi          = explode("-",$val_emi[0]);
$dt_emissao_format = $date_emi[2]."/".$date_emi[1]."/".$date_emi[0];

$dt_recebimento    = $valores['P0016_T008_DTR'];
$val_rec           = explode(" ",$dt_recebimento);
$date_rec          = explode("-",$val_rec[0]);
$dt_receb_format = $date_rec[2]."/".$date_rec[1]."/".$date_rec[0];

$dt_vencimento     = $valores['P0016_T008_DTV'];
$val_ven           = explode(" ",$dt_vencimento);
$date_ven          = explode("-",$val_ven[0]);
$dt_vencto_format  = $date_ven[2]."/".$date_ven[1]."/".$date_ven[0];

$cgc =  $objAP->FormataCGCxCPF($valores['P0016_T026_CGC']);

$valor_bruto       = money_format('%n', $valores['P0016_T008_VAB']);

$valor_liquido     = money_format('%n', $valores['P0016_T008_VAL']);

?>
<div id="formulario" class="formulario">
    <span class="form-titulo">
        <p>Dados do Fornecedor</p>
    </span>
    <span class="form-input">
        <table>
            <tr>
                <td><label class="label">CNPJ / CPF              </label></td>
                <td><label class="label">Cod RMS               </label></td>
                <td><label class="label">Inscrição Estadual    </label></td>
                <td><label class="label">Razão Social          </label></td>
                <td><label class="label">Inscrição Municipal / RG</label></td>
            </tr>
            <tr>
                <td><p><?php echo $cgc;?>                                                </p></td>
                <td><p><?php echo $valores['P0016_T026_COD']."-".$valores['P0016_T026_DIG'];?></p></td>
                <td><p><?php echo $valores['P0016_T026_INE'];?>                               </p></td>
                <td><p><?php echo $valores['P0016_T026_RAZ'];?></p></td>
                <td><p><?php echo $valores['P0016_T026_INM'];?></p></td>
            </tr>
        </table>
        <span class="form-titulo">
            <p>Dados da Nota Fiscal</p>
        </span>
        <table>
            <tr>
                <td><label class="label">Nota Fiscal   </label></td>
                <td><label class="label">Série         </label></td>
                <td><label class="label">Característica</label></td>
                <td><label class="label">Data de Emissão    </label></td>
                <td><label class="label">Data de Recebimento</label></td>
                <td><label class="label">Data de Vencimento    </label></td>
            </tr>
            <tr>
                <td><p><?php echo $valores['P0016_T008_NNF'];?></p></td>
                <td><p><?php echo $valores['P0016_T026_SER'];?></p></td>
                <td>
                <?php

                    if ($valores['P0016_T008_TDE'] == 1)
                    {
                     echo "EVENTUAL";
                    }
                else if ($valores['P0016_T008_TDE'] == 2)
                    {
                     echo "POR DEMANDA";
                    }
                else
                    {
                     echo "REGULAR";
                    }
                    
                ?>
                </td>
                <td><p><?php echo $dt_emissao_format;?></p></td>
                <td><p><?php echo $dt_receb_format;?></p></td>
                <td><p><?php echo $dt_vencto_format;?></p></td>
            </tr>
            <tr>
                <td><label class="label">Valor</label></td>
<!--                <td><label class="label">Valor Liquido</label></td>-->
                <td><label class="label">Forma de Pagamento</label></td>
                <td><label class="label">Tipo da Nota</label></td>
                <td><label class="label">Loja Faturada</label></td>
                <td><label class="label">N° do Contrato</label></td>
            </tr>
            <tr>
                <td><p><?php echo $valor_bruto;?></p></td>
<!--                <td><p><?php echo $valor_liquido;?></p></td>-->
                <td><p><?php echo $valores['P0016_T008_FPA'];?></p></td>
                <td>
                    <p>
                    <?php
                        if ($valores['P0016_T008_TNO'] == 1)
                            echo "SERVIÇO";
                        else if ($valores['P0016_T008_TNO'] == 2)
                            echo "DESPESA";
                        else
                            echo "0";                            
                    ;?>
                    </p>
                </td>
                <td><p><?php echo $valores['P0016_T006_COD']." - ".$valores['P0016_T006_NOM'];?></p></td>
                <td><p><?php echo $valores['P0016_T008_NCO'];?></p></td>
            </tr>
        </table>
    </span>
    <span class="form-titulo">
            <p>Informações / Descrições</p> 
    </span>
</div>

<div id="tabs">
    <ul>
        <li><a href="#tabs-1">Detalhes</a></li>
        <li><a href="#tabs-2">Justificativas</a></li>
        <li><a href="#tabs-3">Instruções</a></li>
        <li><a href="#tabs-4">Controladoria</a></li>
    </ul>
    <div id="tabs-1">
    <span class="form-input">
        <table>
            <tr>
                <td><label class="label">Detalhes (detalhamentos do serviço contratado, competencia ou período de execução, mencionar anexos que seguem, e demais conteúdos)</label></td>
            </tr>
            <tr>
                <td><p><?php echo $valores['P0016_T008_DES'];?></p></td>
            </tr>
        </table>
    </span>
    </div>
    <div id="tabs-2">
    <span class="form-input">
        <table>
            <tr>
                <td><label class="label">Justificativas/Considerações relevantes à contratação:</label></td>
            </tr>
            <tr>
                <td><p><?php echo $valores['P0016_T008_JUS'];?></p></td>
            </tr>
        </table>
    </span>
    </div>
    <div id="tabs-3">
    <span class="form-input">
        <table>
            <tr>
                <td><label class="label">Instruções p/ Controladoria/Financeiro</label></td>
            </tr>
            <tr>
                <td><p><?php echo $valores['P0016_T008_INS'];?></p></td>
            </tr>
        </table>
    </span>
    </div>
    <div id="tabs-4">
    <span class="form-input">
    <table>
        <tr>
            <td><label class="label">Espaço reservado à controladoria (agenda, numero, serie, data de agenda, conta contábil, controles internos, etc.)</label></td>
        </tr>
        <tr>
            <td><p><?php echo $valores['P0016_T008_CON'];?></p></td>
        </tr>
    </table>
    </span>
    </div>
    <?php }?>
        <div class="form-inpu-botoes">
            <p><a href="?router=T0016/<?php echo $origem; ?>" id="voltar">Voltar</a></p>
        </div>
</div>

