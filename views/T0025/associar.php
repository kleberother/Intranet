<script src="template/js/interno/T0025/busca.js"></script>
<?php
//Parametros e Tabela
$cod            =   $_GET['cod'];
$nom            =   $_GET['nom'];
$tabela         =   "T026_T059";
$user           =   $_SESSION['user'];
//Lista Dados
$objForn        =   new models_T0025();
$Associados     =   $objForn->listarAssociados($cod);
//$Grupos         =   $objForn->listarGrpAssociados($cod);
$Loja           =   $objForn->selecionaLoja();

//Verifica se NULL para executar a Inserção
if(!is_null($_POST['T026_codigo']))    
{
    print_r($_POST);
    //Tratamento para combo lojas (TODAS)
    if ($_POST['T006_codigo']=="0")
    {
        $Grp    =   $_POST['T059_codigo'];

        foreach($Loja   as  $campos=>$valores)
        {
            $_POST['T006_codigo'] = $valores['COD'];

            foreach ($Grp as $valores)
            {
                $_POST['T059_codigo']  =   $valores;
                $inserir = $objForn->inserir($tabela, $_POST);
            }
        }
            if ($inserir)
                header('location:?router=T0025/associar&msg=8&cod='.$cod.'&nom='.$nom);
            else
                header('location:?router=T0025/associar&msg=7&cod='.$cod.'&nom='.$nom);
    }
    else
    {
            $Grp    =   $_POST['T059_codigo'];
            foreach ($Grp as $valores)
            {
                $_POST['T059_codigo']  =   $valores;
                $inserir = $objForn->inserir($tabela, $_POST);
            }
            
            if ($inserir)
                header('location:?router=T0025/associar&msg=8&cod='.$cod.'&nom='.$nom);
            else
                header('location:?router=T0025/associar&msg=7&cod='.$cod.'&nom='.$nom);
    }
}
?>
<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0025/home">Listar</a></li>
                <li><a href="?router=T0025/novo">Novo</a></li>
            </ul>
        </span>
    </div>
</div>
<div id="conteudo">
    <span class="form-titulo">
        <p><b>Fornecedor:</b> <?php echo $cod." - ".$nom; ?></p>
    </span>
    <span class="lista_itens">
	<table class="ui-widget ui-widget-content">
		<thead>
			<tr class="ui-widget-header ">
                            <th width="12%">Processo</th>
                            <th>Grupo Workflow</th>
                            <th width="22%">Loja</th>
                            <th width="5%">Ações</th>
			</tr>
		</thead>
		<tbody>
                        <?php $i=0;?>
                        <?php foreach($Associados as $campos=>$valores){?>
                        <?php $i++;?>
			<tr>
                            <td><?php echo $valores['CodigoProcesso'];?> - <?php echo $valores['NomeProcesso']?></td>
                            <td><?php echo $valores['CodigoGWF'];?> - <?php echo $valores['NomeGWF'];?></td>
                            <td><?php echo $valores['CodigoLoja'];?> - <?php echo $valores['NomeLoja'];?></td>
                            <td class="acoes">
                                <span class="lista_acoes">
                                <ul>
                                    <li class="ui-state-default ui-corner-all" title="Excluir"  >
                                        <a href="javascript:excluir('T0025','T0025/associar&cod=<?php echo $cod;?>&nom=<?php echo $nom; ?>','T026_T059','T059_codigo',<?php echo ($valores['CodigoGWF']);?>,'T006_codigo','<?php echo $valores['CodigoLoja']; ?>',1)" class="ui-icon ui-icon-closethick"></a>
                                    </li>
                                </ul>
                                </span>
                            </td>
			</tr>
                        <?php } if($i==0){?>
                        <tr>
                                <td colspan="5">Não existe nenhum grupo associado a este fornecedor</td>
			</tr>
                        <?php }?>
		<!-- Caixa Dialogo Excluir -->
                <div id="dialog-confirm" title="Mensagem!" style="display:none">
                    <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Tem certeza que deseja excluir este item?</p>
                </div>
                </tbody>
	</table>
    </span>
</div>
<div id="formulario">
    <span class="form-input">
    <form action="" method="post" id="formCad">
    <span class="form-titulo">
        <p>Associar Loja:</p>
    </span>
    <input type="hidden"    name="T026_codigo"  value="<?php echo $cod;?>" class="fornecedor" />
    <input type="hidden"    name="T061_codigo"  value="1"                                     />
    <table>
        <tr>
            <td>
                <select name="T006_codigo" class="loja">
                    <option value="">Selecione...</option>
                    <?php foreach($Loja    as  $campos=>$valores){?>
                    <option value="<?php echo  $valores['COD'];?>"><?php echo $objForn->preencheZero("E", 3, $valores['COD']); ?> - <?php echo $valores['NOM'];?></option>
                    <?php }?>
                    <option value="0">TODAS</option>
                </select>
            </td>
        </tr>
    </table>
    <span class="form-titulo">
        <p>Associar um Grupo de Workflow a este fornecedor:</p>
    </span>
    <table>
        <tr>
            <td><label class="label"> Grupos (pode-se selcionar vários itens segurando a tecla CTRL + Clique)</label></td>
        </tr>
        <tr>
            <td>
                <select name="T059_codigo[]" id="GrpWfl" class="validate[required] form-input-text-table-multiple" multiple>
                <?php foreach($Grupos as $campos=>$valores){ ?>
                    <option value='<?php echo $valores['COD']; ?>'><?php echo $objForn->preencheZero("E", 3, $valores['COD']); ?> - <?php echo ($valores['NOM']); ?></option>
                <?php }?>
                </select>
            </td>
        </tr>
    </table>
        <div class="form-inpu-botoes">
            <input type="submit" value="Associar" />
        </div>
    </form>
    </span>
</div>