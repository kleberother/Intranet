<?php
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: xx/xx/2011 por Jorge Nova                              
 * Descrição: Listar a associar usuários para perfil de acesso
 * Entrada:   
 * Origens:   
           
**************************************************************************
*/
//Pega parametros
$cod        =   $_REQUEST['cod'];
$nom        =   $_REQUEST['nom'];

//Classe para Usuarios

$tabela     =   "T004_T009";

$obj        =   new models_T0005();
$Perfil     =   $obj->selecionaUsuario($cod);
$Estru      =   $obj->selecionaEstrutura2();

if(!empty($_POST))
{
    unset ($_POST['nom']);
    $_POST['T004_login'] = $obj->formataLoginAutoComplete($_POST['T004_login']);
    $Insere              = $obj->insereT004_T009($tabela, $_POST);
     
    header('location:?router=T0005/associar&cod='.$cod.'&nom='.$nom);
}

?>
<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0005/home">Listar</a></li>
                <li><a href="?router=T0005/novo">Novo</a></li>
            </ul>
        </span>
    </div>
</div>
<!--<div id="tabs">
    <ul>
        <li><a href="#tabs-1">Usuários</a></li>
        <li><a href="#tabs-2">Permissões</a></li>
    </ul>
    <div id="tabs-1">-->
        <div id="formulario">
            <span class="form-titulo">
                <p>Associar um usuário a esse perfil:</p>
            </span>
            <span class="form-input">
            <form action="" method="post" id="formCad">
                <label class="label">Login*</label>
                <input type="text"      name="T004_login"   id="nome"                               class="validate[required] form-input-text buscaUsuario" />
                <input type="hidden"    name="T009_codigo"  id="codigo" value="<?php echo $cod;?>"  />
                <input type="hidden"    name="nom"          id="nome"   value="<?php echo $nom;?>"  />
                <div class="form-inpu-botoes">
                    <input type="submit" value="Associar" />
                </div>
            </form>
            </span>
        </div>
        <div id="conteudo">
            <span class="form-titulo">
            <p>Perfil: <?php echo $cod." - ".$nom; ?></p>
            </span>
            <span class="lista_itens">
                <table class="ui-widget ui-widget-content">
                        <thead>
                                <tr class="ui-widget-header ">
                                    <th width="5%">Código   </th>
                                    <th>Login    </th>
                                    <th width="5%">Ações    </th>
                                </tr>
                        </thead>
                        <tbody>
                                <?php foreach($Perfil as $campos=>$valores){?>
                                <tr>
                                    <td class="codigo"><?php echo ($valores['COD']);?></td>
                                    <td><?php echo ($valores['LOG']);?></td>
                                    <td class="acoes">
                                        <span class="lista_acoes">
                                        <ul>
                                            <li class="ui-state-default ui-corner-all" title="Excluir"  ><a href="javascript:excluir('T0005','T0005/associar&nome=<?php echo $nom; ?>','T004_T009','T004_login','<?php echo ($valores['LOG']);?>','T009_codigo',<?php echo $cod; ?>,2)"   class="ui-icon ui-icon-closethick"></a></li>
                                        </ul>
                                        </span>
                                    </td>
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
<!--    </div>-->

<!--    <div id="tabs-2">
        <div id="conteudo">
            <span class="lista_itens">
                <span class="form-input">
                    <form action="" method="post">
                <table class="ui-widget ui-widget-content">
                        <thead>
                                <tr class="ui-widget-header ">
                                    <th>#        </th>
                                    <th>Nome     </th>
                                    <th>Descrição</th>
                                    <th>Tipo     </th>
                                    <th>Permitir </th>
                                </tr>
                        </thead>
                        <tbody>
                                <?php //foreach($Estru as $campos=>$valores){ ?>
                                <tr>
                                        <td class="codigo"><?php //echo ($valores['COD']);?></td>
                                        <td><?php //echo ($valores['NOM']);?></td>
                                        <td><?php //echo ($valores['DES']);?></td>
                                        <td><?php //echo ($valores['TIP']);?></td>
                                        <td>
                                            <input type="checkbox" id="check<?php //echo ($valores['COD']);?>" />
                                        </td>
                                </tr>
                                <?php// } ?>
                        </tbody>
                </table>
                    </form>
                </span>
            </span>
        </div>
    </div>-->
<!--</div>-->