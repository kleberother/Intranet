<?php
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 29/12/2011 por Jorge Nova
 * Descrição: Programa para gerar relatórios de APs de um tal fornecedor por período
 * Entradas:   
 * Origens:   Menu Sistema
           
**************************************************************************
*/

$user         = $_SESSION['user'];
$tipo         = $_REQUEST['tipo'];

//Chama classes
//Classe para APS
$obj   =  new models_T0016($conn);


?>
<!-- Filtro Dinâmico -->
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

                if (($user == 'rrocha') || ($user == 'fcolivei') || ($user == 'msasanto') || ($user == 'ralfieri') || ($user == 'rcsilva') || ($user == 'lolive') || ($user == 'ctlima') || ($user == 'mlsilva') || ($user == 'rcsouza'))
                 echo "<li><a href='?router=T0016/painel'>Painel de Aprovações</a></li>";
                ?>
                <li><a href="?router=T0016/fluxo">Fluxo AP</a></li>
            </ul>
        </span>
    </div>
</div>

<!--<form action="?router=T0016/js.relatorio" method="post" target="_blank">-->
<form action="?router=T0016/resumofornecedor" method="post">
    <div  id="formulario" class="formulario">
        <span class="form-input">
            <table>
                <tr>
                    <td colspan="2"><label class="label">Fornecedor: </label></td>
                </tr>
                <tr>
                    <td colspan="2"><input type="" name="fornecedor"  id="fornecedor" class="buscaFornecedor" size="100" value="<?php echo $_POST['fornecedor']; ?>" /></td>
                </tr>
                <tr>
                    <td width="100px"><label class="label">De: </label></td>
                    <td><label class="label">Ate: </label></td>
                </tr>
                <tr>
                    <td><input type="" name="dt_inicial"  id="dt_inicial"                         size="8" value="<?php echo $_POST['dt_inicial']; ?>" /></td>
                    <td><input type="" name="dt_final"    id="dt_final"                           size="8" value="<?php echo $_POST['dt_final']; ?>" /></td>
                </tr>
                <tr>
                    <td colspan="2">                        
                        <span class="form-input">
                            <div class="form-inpu-botoes">
                                <input type="hidden" name="tipo" value="1" />
                                <button type="submit" >Gerar Relatório</button>
                            </div>   
                        </span>
                    </td>
                </tr>
            </table>
        </span>
    </div>
</form>

<?php
if (!empty ($_POST))
{
    
// Captura dados do $_POST
$codigo     = $obj->retornaCodigoFornecedorAutoComplete($_POST['fornecedor']);
$dt_inicial = $obj->retornaMySQLData($_POST['dt_inicial']);
$dt_final   = $obj->retornaMySQLData($_POST['dt_final']);

// Faz select com os dados do POST
$listaNotas = $obj->retornaNotasFornecedor($codigo, $dt_inicial, $dt_final);
$totalNotas = $obj->retornaNotasFornecedorTotal($codigo, $dt_inicial, $dt_final);
    
?>
<div id="conteudo">
    <span class="lista_itens">
        <table>
            <tr>
                <td>Total das Notas: </td>
                <?php
                foreach($totalNotas as $campos=>$valores)
                {
                ?>
                <td><?php echo money_format('%n', $valores['Total']); ?></td>                
                <?php
                }
                ?>
            </tr>
        </table>
        <table>
            <thead>
                <tr class="ui-widget-header ">
                    <th width="9%">Data de Emissão          </th>
                    <th width="9%">Nota Fiscal              </th>
                    <th width="9%">Valor                   </th>
                    <th>Descrição               </th>

                </tr>
            </thead>
        <?php
            foreach($listaNotas as $campos=>$valores)
            {
        ?>
            <tr>
                <td><?php echo $valores['DataEmissao']; ?></td>
                <td><?php echo $valores['NotaFiscal'];  ?></td>
                <td><?php echo $valor_bruto   = money_format('%n', $valores['ValorBruto']);  ?></td>
                <td><?php echo $valores['Descricao'];   ?></td>
            </tr>
        <?php
            }
        ?>
        </table>
    </span>
</div>
<?php
}
?>



<?php
/* -------- Controle de versões --------------
 * 0.0.1 - 29/12/2011 - Jorge     --> Liberada primeira versão
 * 0.0.2 - 30/12/2011 - Jorge     --> Alteração da listagem do conteúdo, visualizar e tela e ter opção para gerar PDF
 * 
*/
?>