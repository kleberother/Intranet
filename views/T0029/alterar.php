<?php
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 17/11/2011 por Jorge Nova                              
 * Descrição: Página de alteração dos dados de arquivos
 * Entrada:   Código do Arquivo   
 * Origens:   ?router=T0029/home
           
**************************************************************************
*/

$codigo = $_REQUEST['codigo'];

//Classe para Conexão com as models
$obj     = new models_T0029();

$Arquivo = $obj->retornaArquivoUnico($codigo); 

$TipArq  = $obj->retornaTipoArquivos();

// Prepara para alterar o arquivo
if (!empty ($_POST))
{
  $delim   = "T055_codigo = $codigo";
  
  $tabela  = "T055_arquivos";
  
  if (isset($_POST['T004_owner']))
    $_POST['T004_owner'] = $obj->formataLoginAutoComplete($_POST['T004_owner']);
  
  $Alterar = $obj->Alterar($tabela,$_POST,$delim);
  
  //echo $Alterar;
  
  echo "<script>window.location = '?router=T0029/home';</script>";  

  
          
}

?>

<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0029/home">Listar</a></li>
                <li><a href="?router=T0029/novo">Novo</a></li>
            </ul>
        </span>
    </div>
</div>
<div id="formulario">
    <?php foreach($Arquivo as $campos=>$valores){?>
    <span class="form-titulo">
        <p>Os campos com asterisco (*) são obrigatórios o preechimento</p>
    </span>
    <span class="form-input">
        <form action="" method="post" id="formCad">
        <div id="formulario">
            <span  class="form-input">
                <table>
                    <thead>
                        <tr>
                            <td><label class="label">Nome*</label></td>
                        </tr>
                        <tr>
                            <td><input type="text" name="T055_nome" id="nome" value="<?php echo $valores['Nome']; ?>" class="validate[required,maxSize[50]] form-input-select" maxlength="40" /></td>
                        </tr>
                        <tr>
                            <td><label class="label">Descrição</label></td>
                        </tr>
                        <tr>
                            <td><textarea name="T055_desc"  class="textarea-table" cols="" rows="" id="descricao" ><?php echo $valores['Descricao']; ?></textarea></td>
                        </tr>
                        <?php
                        if ($valores['Publisher'] == $valores['Owner'])
                        {
                        ?>
                        <tr>
                            <td><label class="label">Owner do Arquivo</label></td>
                        </tr>
                        <tr>
                            <td><input type="text" name="T004_owner"  class="buscaUsuario" value="<?php echo $valores['NomeOwner']." - ".$valores['Owner']; ?>" /></td>
                        </tr>
                        <?php
                        }
                        ?>
                        <tr>
                            <td><label class="label">Tipo de Arquivo*</label></td>
                        </tr>
                        <tr>
                            <td>
                                <select name="T056_codigo"  id="tp_codigo" class="validate[required] form-input-select">
                                    <option value="">Selecione...</option>
                                <?php foreach($TipArq as $campos=>$valores2){?>
                                    <option value="<?php echo $valores2['Codigo']?>" <?php if ($valores['Tipo'] == $valores2['Codigo']) echo "selected";?>><?php echo ($valores2['Nome'])?></option>
                                <?php }?>
                                </select>
                            </td>
                        </tr>
                    </thead>
                </table>
                <div class="form-inpu-botoes">
                    <input type="submit" value="Salvar" />
                </div>
            </span>
        </div>
        </form>
    </span>
<?php } ?>
</div>

<?php
/* -------- Controle de versões - alterar.php --------------
 * 1.0.0 - 17/11/2011 - Jorge --> Liberada versao inicial
 *                                
 */
?>
