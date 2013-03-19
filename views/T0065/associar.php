<?php
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 21/11/2011 por Jorge Nova                              
 * Descrição: Associar departamentos a loja
 * Entrada:   
 * Origens:   
           
**************************************************************************
 */

// Captura parametros do header
$codigo        =   $_REQUEST['codigo'];
$nome          =   $_REQUEST['nome'];


//Classe para Usuarios
$obj           =   new models_T0065();

// Se o POST estiver com contéudo, executa inserção de dados na tabela
if (!empty($_POST))
{

    // Tabela a ser inserida
    $tabela = "T006_T077";
    
    // Formata a string de T004_login para deixar apenas o login
    $_POST['T004_login'] = $obj->formataLoginAutoComplete($_POST['T004_login']);   
    
    //print_r($_POST);
    
    // Insere dados
    $insert = $obj->inserir($tabela, $_POST);

    // Verifica se o segundo insert deu certo T006_T077
    if ($insert)
    {        
        header('location:?router=T0065/associar&codigo='.$codigo.'&nome='.$nome);            
    }
    else
    { // Erro ao inserir na tabela T006_T0077
        echo "<script>alert('ERRO AO CADASTRAR');</script>";                 
        echo "<script>window.location='?router=T0065/associar&codigo='.$codigo.'&nome='.$nome';</script>";                 
    }    
    
}


// Retorna Departamentos Associados
$DepartamentosAssociados = $obj->retornaDptoAssociados($codigo);

// Retorna Departamentos não associados a essa loja
$Departamentos           =  $obj->retornaDptoNaoAssociados($codigo);

?>
<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0065/home">Listar</a></li>
            </ul>
        </span>
    </div>
</div>
<div id="conteudo">
    <span class="form-titulo">
        <p>Arquivo: <?php echo $codigo." - ".$nome;?></p>
    </span>
</div>
<div id="formulario">
    <span class="form-input">
    <form action="" method="post" id="formCad">
        <label class="label">Owner do Departamento*</label>
        <input type="text"    name="T004_login"  class="validate[required] buscaUsuario" size="100" />
        <label class="label">Departamento*</label>
        <select name="T077_codigo" id="departamento" class="validate[required] form-input-text departamento">
            <option value="">Selecione...</option>
            <?php           
            foreach($Departamentos as $campos=>$valores)
            {
            ?>
            <option value="<?php echo $valores['Codigo']; ?>"><?php echo $obj->preencheZero("E", 3, $valores['Codigo'])." - ".$valores['Nome']; ?></option>
            <?php
            }
            ?>
        </select>
        <input type="hidden"  name="T006_codigo" value="<?php echo $codigo; ?>" />
        
        <div class="form-inpu-botoes">
            <input type="submit" value="Associar" />
        </div> 
    </form>
    </span>
</div>
<div id="conteudo">
    <span class="lista_itens">
        <table class="ui-widget ui-widget-content">
            <thead>
                    <tr class="ui-widget-header ">
                            <th>Departamento              </th>
                            <th>Owner                     </th>
                            <th width="7%">Ações          </th>
                    </tr>
            </thead>
            <tbody> 
                <?php foreach($DepartamentosAssociados as $campos=>$valores){ ?>
			<tr>
                            <td><?php echo $obj->preencheZero("E", 3, $valores['CodigoDepartamento']);?> - <?php echo ($valores['NomeDepartamento']);?></td>
                            <td><?php echo ($valores['Usuario']);?><br/><?php echo ($valores['NomeUsuario']);?><br/><?php if($valores['FuncaoUsuario'] == "") echo "Cargo não informado"; else echo $valores['FuncaoUsuario'];?></td>
                            <td class="acoes">
<!--                                <span class="lista_acoes">
                                    <ul>
                                       <li class="ui-state-default ui-corner-all" title="Excluir"  ><a href="javascript:excluir('T0064','T0064/home','T077_departamento','T077_codigo',<?php //echo ($valores['CodigoDepartamento']);?>)"   class="ui-icon ui-icon-closethick"></a></li>
                                    </ul>
                                </span>-->
                            </td>
			</tr>
                   <?php } ?>
            <!-- Caixa Dialogo Excluir -->
            <div id="dialog-confirm" title="Mensagem!" style="display:none">
                <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Tem certeza que deseja excluir este item?</p>
            </div>
            </tbody>
        </table>
    </span>
</div>