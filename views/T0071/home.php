<?php
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 29/12/2011 por Jorge Nova
 * Descrição: Programa para gerar relatórios de APs de um tal fornecedor por período e PDF para impressão caso necessário
 * Entradas:   
 * Origens:   Menu Sistema
           
**************************************************************************
*/

$user         = $_SESSION['user'];
$tipo         = $_REQUEST['tipo'];

//Chama classes
//Classe para APS
$obj   =  new models_T0071($conn);


?>
<!-- Filtro Dinâmico -->
<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0071/home" class="active">Novo</a></li>
            </ul>
        </span>
    </div>
</div>

<form action="?router=T0071/home" method="post">
    <div  id="formulario" class="formulario">
        <span class="form-input">
            <table>
                <tr>
                    <td width="70%" colspan="5"><label class="label">Fornecedor: </label></td>                
                </tr>
                <tr>
                    <td><input type="" name="fornecedor"  id="fornecedor" class="buscaFornecedor" size="80" value="<?php echo $_POST['fornecedor']; ?>" /></td>
                    <td><label class="label">Periodo de: </label></td>
                    <td><input type="" name="dt_inicial"  id="dt_inicial"                         size="8" value="<?php echo $_POST['dt_inicial']; ?>" /></td>
                    <td><label class="label">até: </label></td>                    
                    <td><input type="" name="dt_final"    id="dt_final"                           size="8" value="<?php echo $_POST['dt_final']; ?>" /></td>
                </tr>
                <tr>
                    <td colspan="5">                        
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
$codigo     =   $obj->retornaCodigoFornecedorAutoComplete($_POST['fornecedor']);
$dt_inicial =   $obj->retornaMySQLData($_POST['dt_inicial']);
$dt_final   =   $obj->retornaMySQLData($_POST['dt_final']);

// Faz select das lojas
$lojas      =   $obj->retornaLojas(); 


// Faz select com os dados do POST
$totalNotas =   $obj->retornaNotasFornecedorTotal($codigo, $dt_inicial, $dt_final);


?>
<div id="conteudo">
    <span class="lista_itens">
        <table>
            <tr>
                <?php
                foreach($totalNotas as $campos=>$valores)
                {
                    $total = $valores['Total'];
                ?>
                    <td style="font-size: 15px; font-weight: bold;"><?php echo "Total: ".money_format('%n', $valores['Total']); ?></td>                
                <?php
                }
                ?>
            </tr>
        </table>
        <table>
            <thead>
                <tr style="background: #F4F4F4;">
                    <th width="9%" class="centerp">Data Emissão         </th>
                    <th width="9%" class="centerp">AP Nro               </th>
                    <th width="9%" class="centerp">Nota Fiscal             </th>
                    <th width="9%" class="centerp">Valor (R$)             </th>
                    <th class="centerp">Descrição                          </th>
                </tr>
            </thead>
            <tbody>
        <?php
          
            // Retorna todas as lojas com seus respectivos códigos
            foreach($lojas as $campos=>$valores)
            {   // Inicio da listagem das lojas 
                // Busca as notas fiscais passando alguns parametros
                $listaNotas =   $obj->retornaNotasFornecedor($codigo, $dt_inicial, $dt_final,$valores['Codigo']);
                
                // Contador para listar nome da loja ou não
                $i = 0;
                
                // Retorna as notas fiscais
                foreach($listaNotas as $campos2=>$valores2)
                {   // Inicio da listagem das notas 
                    // Verifica se o contador é igual a zero, se for, o programa imprime na tela o nome e código do fornecedor
                    // como se fosse título
                    if($i==0)
                        echo "<tr style='font-weight: bolder;'><td colspan='4'>".$valores['Codigo']." - ".$valores['Nome']."</td></tr>";
                    
                    // Após imprimir, soma o contador para que o titulo seja impresso apenas uma vez e logo seguido de suas notas
                    $i ++;
                    
                  
                    if ($cor == "#F9F9F9")
                        $cor = "white";
                    else
                        $cor = "#F9F9F9";                        
                        
                    ?>
                    
                    <!-- Código HTML retornando todas as notas daquela loja e fornecedor -->
                    <tr style="background:<?php echo $cor; ?>;">
                        <td><?php echo $valores2['DataEmissao']; ?></td>
                        <td><a href="?router=T0016/detalhe&cod=<?php echo $valores2['Ap']; ?>" target="_blank"><?php echo $valores2['Ap']; ?></a></td>
                        <td align="right"><?php echo $valores2['NotaFiscal'];  ?></td>
                        <td align="right"><?php echo $valor_bruto   = substr(money_format('%n', $valores2['ValorBruto']), 2);  ?></td>
                        <td><?php echo $valores2['Descricao'];   ?></td>
                    </tr>                
                    
                    <?php
                    
                    // Soma o valor das notas e iguala em uma variavel que será o total da loja
                    $totalLoja = $valores2['ValorBruto'] + $totalLoja;
                }   // Final da listagem das notas
                
                // Verifica se o total da loja é diferente de zero:
                // True: Imprimi o total da loja
                // False: Não imprimi nada, pois não possuiam notas da loja especificada
                if ($totalLoja != 0)
                    echo "<tr style='font-weight: bolder; background: #F4F4F4;'><td colspan='2'>Total da Loja: </td><td align='right'>".substr(money_format('%n', $totalLoja),2)."</td></tr>";      
                 
                // Iguala o total da loja para iniciar a contagem com outra loja no FOR
                $totalLoja = 0;
                
            }   // Final da listagem das lojas
        ?>
            </tbody>
        </table>
    </span>
</div>

<!-- Formulário para imprimir esse relatório -->
<!--<div  id="formulario" class="formulario">
    <form action="?router=T0071/js.relatorio" method="post" target="_blank">
    <input type="hidden" name="fornecedor"  id="fornecedor" value="<?php //echo $_POST['fornecedor']; ?>" />
    <input type="hidden" name="dt_inicial"  id="dt_inicial" value="<?php //echo $dt_inicial;          ?>" />
    <input type="hidden" name="dt_final"    id="dt_final"   value="<?php //echo $dt_final;            ?>" />
    <input type="hidden" name="total"       id="total"      value="<?php //echo $total;               ?>" />
    <span class="form-input">
        <div class="form-inpu-botoes">
            <button type="submit" >Imprimir</button>
        </div>   
    </span>
    </form>
</div>-->
<?php
}
?>



<?php
/* -------- Controle de versões --------------
 * 0.0.1 - 29/12/2011 - Jorge     --> Liberada primeira versão
 * 0.0.2 - 02/01/2012 - Jorge     --> Alteração da listagem do conteúdo, visualizar e tela e ter opção para gerar PDF
 * 0.0.3 - 03/01/2012 - Jorge     --> Trazer a listagem separada por lojas e total de cada um
 * 
*/
?>

