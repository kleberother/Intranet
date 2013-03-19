<?php
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 21/11/2011 por Jorge Nova                              
 * Descrição: Owner poderá associar usuários aos departamentos que ele faz gestão
 * Entrada:   
 * Origens:   
           
**************************************************************************
 */

// Captura parametros
$codigo        =   $_REQUEST['codigo']; // Código do Departamento
$nome          =   $_REQUEST['nome'];   // Nome do Departamento
$loja          =   $_REQUEST['loja'];   // Loja
$tabela        =   "T004_T006_T077";    // Tabela que deverá ser utilizada para inserir dados

$obj           =   new models_T0064();  // Classe de conexão com as models desse programa

// Verifica se o $_POST esta em branco
if(!empty ($_POST))
{   
    // Formatar usuário 
    $_POST['T004_login'] = $obj->formataLoginAutoComplete($_POST['T004_login']);
    
    // Insere dados
    $Insere     =   $obj->inserir($tabela, $_POST);
    
    // Verifica se os dados foram inseridos com sucesso
    if ($Insere)
    {
        header('location:?router=T0064/associar&codigo='.$codigo.'&nome='.$nome.'&loja='.$loja);
    }
    else
    { // Erro ao inserir na tabela T004_T006_T0077
        echo "<script>alert('ERRO AO CADASTRAR');</script>";                 
        echo "<script>window.location='?router=T0064/associar&codigo=".$codigo."&nome=".$nome."&loja=".$loja."';</script>";    
    }
}

// Retorna todos os usuários de acordo com os parametros passados
$Usuarios      =   $obj->retornaUsuariosPorDepartamento($codigo,$loja); 

?>
<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0064/home">Listar</a></li>
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
        <input type="hidden"  name="T006_codigo"  value="<?php echo $loja;   ?>" />
        <input type="hidden"  name="T077_codigo"  value="<?php echo $codigo; ?>" />        
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
                        <th width="7%">Matricula       </th>
                        <th>Nome (login)    </th>
                        <th width="7%">Ações</th>
                </tr>
            </thead>
            <tbody> 
                <?php foreach($Usuarios as $campos=>$valores){ ?>
			<tr>
                            <td><?php echo strtoupper($valores['Matricula']) ;?></td>
                            <td><?php echo strtoupper($valores['Login']." - ".$valores['Nome']) ;?></td>
                            <td class="acoes">
                                <span class="lista_acoes">
                                    <ul>
                                       <li class="ui-state-default ui-corner-all" title="Excluir"  ><a href="javascript:excluir('T0064','T0064/associar&nome=<?php echo $nome; ?>','T004_T006_T077','T004_login','<?php echo $valores['Login'] ;?>','T006_codigo',<?php echo $loja; ?>,<?php echo $codigo; ?>)"   class="ui-icon ui-icon-closethick"></a></li>
                                    </ul>
                                </span>
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