<?php
//Pega parametros
$cod        =   $_REQUEST['cod'];
$nom        =   $_REQUEST['nom'];
$login      =   $_POST['T004_login'];
//Classe para Usuarios

$tabela     =   "T004_T077";

$obj        =   new models_T0033();
$Usuario    =   $obj->retornaUsuariosPorDepartamento($cod);


if(!is_null($login))
{
    unset ($_POST['nom']);
    $Insere     =   $obj->inserir($tabela, $_POST);
    header('location:?router=T0033/associar&cod='.$cod.'&nom='.$nom);
}

?>
<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0033/home">Listar</a></li>
                <li><a href="?router=T0033/novo">Novo</a></li>
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
                <p>Associar um usuário a esse grupo:</p>
            </span>
            <span class="form-input">
            <form action="" method="post" id="formCad">
                <label class="label">Login*</label>
                <input type="text"      name="T004_login"   id="nome"   class="validate[required,maxSize[8]] form-input-text"     />
                <input type="hidden"    name="T077_codigo"  id="codigo" value="<?php echo $cod;?>"  />
                <input type="hidden"    name="nom"          id="nome" value="<?php echo $nom;?>"  />
                <div class="form-inpu-botoes">
                    <input type="submit" value="Associar" />
                </div>
            </form>
            </span>
        </div>
        <div id="conteudo">
            <span class="form-titulo">
            <p>Departamento: <?php echo $cod." - ".$nom; ?></p>
            </span>
            <span class="lista_itens">
                <table class="ui-widget ui-widget-content">
                        <thead>
                                <tr class="ui-widget-header ">
                                    <th width="5%">Login   </th>
                                    <th>Nome               </th>
                                    <th width="5%">Ações   </th>
                                </tr>
                        </thead>
                        <tbody>
                                <?php foreach($Usuario as $campos=>$valores){?>
                                <tr>
                                    <td class="codigo"><?php echo ($valores['Login']);?></td>
                                    <td><?php echo ($valores['Nome']);?></td>
                                    <td class="acoes">
                                        <span class="lista_acoes">
                                        <ul>
                                            <li class="ui-state-default ui-corner-all" title="Excluir"  ><a href="javascript:excluir('T0033','T0033/associar&cod=<?php echo $cod?>&nom=<?php echo $nom; ?>','T004_T077','T004_login','<?php echo ($valores['Login']);?>')"   class="ui-icon ui-icon-closethick"></a></li>
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