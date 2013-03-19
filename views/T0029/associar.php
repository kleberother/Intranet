<?php
//Pega parametros
$cod                    = $_REQUEST['cod'];     //codigo do arquivo
//$cod                    =   51239 ;
$nome                   = $_REQUEST['nome'];    //nome do arquivo
$tab1                   = "T004_T055";          //Usa essa variavel para associar o login ao arquivo
$tab2                   = "T009_T055";          //Usa essa variavel para associar o perfil ao arquivo
$tab3                   = "T055_T006T077";      //Usa essa variavel para associar o departamento ao arquivo

//Classe para ***
//Cria objeto para encontrar as models do programa 29
$obj                    = new models_T0029();


//Busca dados do arquivo
 $buscaArquivo  =   $obj->retornaArquivoUnico($cod);

  foreach($buscaArquivo    as $cpsArq=>$vlrArq)
 {
     $nomeArq   =   $vlrArq['Nome'];
     $descArq   =   $vlrArq['Descricao'];
     $publArq   =   $vlrArq['Publisher'];
     $owneArq   =   $vlrArq['NomeOwner'];
     $dtupArq   =   $vlrArq['DataUpload'];
    
     
 }

 
  
     
//Verifica se NULL para executar a Inserção da T004_T055
if(!is_null($_POST['T004_login']))
{
 //Verifica se o campo de permissão Visualizar esta vazio, se verdadeiro, iguala a zero.
 if(empty($_POST['T004_T055_visualizar']))
  $_POST['T004_T055_visualizar'] = 0 ;
 //Verifica se o campo de permissão Alterar esta vazio, se verdadeiro, iguala a zero.
 if(empty($_POST['T004_T055_alterar']))
  $_POST['T004_T055_alterar'] = 0 ;
 //Verifica se o campo de permissão Excluir esta vazio, se verdadeiro, iguala a zero.
 if(empty($_POST['T004_T055_excluir']))
  $_POST['T004_T055_excluir'] = 0 ;
 // Formata a string de T004_login para deixar apenas o login
 $_POST['T004_login'] = $obj->formataLoginAutoComplete($_POST['T004_login']);
 //Instancia o objeto inserir, e passa como parametro $tab1(T004_T055) e $_POST(Conteúdo do formulário)
 $insere = $obj->inserir($tab1, $_POST);
 // Busca o e-mail do usuário, e envia um e-mail falando que o arquivo foi permissionado para ele

 $buscaEmail    =   $obj->retornaEmail($_POST['T004_login']);
 
 foreach($buscaEmail    as $campos=>$valores)
 {
     $email = $valores['Email'];
 }
 
 
 

 
 
$para       =  $email;

$assunto    =   "Arquivo Intranet";

$mensagem    =   'Foi disponibilizado um novo arquivo para o seu usuário.'.PHP_EOL.PHP_EOL;
$mensagem   .=   'Código: '.$_POST['T055_codigo'].PHP_EOL.PHP_EOL;
$mensagem   .=   'Nome: '.$nomeArq.PHP_EOL.PHP_EOL;
$mensagem   .=   'Descrição: '.$descArq.PHP_EOL.PHP_EOL;
$mensagem   .=   'Publicado por: '.$owneArq." (".$publArq.") Em: ".$dtupArq.PHP_EOL;



$cabecalho  = "From: Intranet Davo <intranet@davo.com>.br\r\n";
$cabecalho .= "MIME-Version: 1.0\r\n"; 
$cabecalho .= "Content-type: text/plain; charset=utf-8\r\n";
$cabecalho .= "Content-Transfer-Encoding: 8bit";    

$email      =   mail($para, $assunto, $mensagem, $cabecalho);
 
 
 
 //Redireciona para a página de permissão, passando o código e nome do arquivo,
 //e a aba na qual o usuário se encontraca (#tabs-3).
 header('location:?router=T0029/associar&cod='.$cod."&nome=".$nome.'&#tabs-3');
}

//Verfica se NULL para executar a inserção de perfis no banco
if(!is_null($_POST['T009_codigo']))
{
 $Perfis1 = $_POST['T009_codigo'];
 if(empty($_POST['T009_T055_visualizar']))
 $_POST['T009_T055_visualizar'] = 0 ;
 //Verifica se o campo de permissão Alterar esta vazio, se verdadeiro, iguala a zero.
 if(empty($_POST['T009_T055_alterar']))
 $_POST['T009_T055_alterar']    = 0 ;
 //Verifica se o campo de permissão Excluir esta vazio, se verdadeiro, iguala a zero.
 if(empty($_POST['T009_T055_excluir']))
 $_POST['T009_T055_excluir']    = 0 ;
 foreach ($Perfis1 as $valores)
 {
     $usuarios = $obj->retornaEmailUsuariosPerfil($valores);
     
     foreach($usuarios  as  $cps => $vls)
     {
         

         
        $para       =  $vls['email'];

        $assunto    =   "Arquivo Intranet";

        $mensagem    =   'Foi disponibilizado um novo arquivo para o seu usuário.'.PHP_EOL.PHP_EOL;
        $mensagem   .=   'Código: '.$_POST['T055_codigo'].PHP_EOL.PHP_EOL;
        $mensagem   .=   'Nome: '.$nomeArq.PHP_EOL.PHP_EOL;
        $mensagem   .=   'Descrição: '.$descArq.PHP_EOL.PHP_EOL;
        $mensagem   .=   'Publicado por: '.$owneArq." (".$publArq.") Em: ".$dtupArq.PHP_EOL;



        $cabecalho  = "From: Intranet Davo <intranet@davo.com>.br\r\n";
        $cabecalho .= "MIME-Version: 1.0\r\n"; 
        $cabecalho .= "Content-type: text/plain; charset=utf-8\r\n";
        $cabecalho .= "Content-Transfer-Encoding: 8bit";    

        $email      =   mail($para, $assunto, $mensagem, $cabecalho);    
        
        if($email)
            echo "enviei"."<BR>";
         
     }
          
    $_POST['T009_codigo']  =   $valores;
    $inserir               =   $obj->inserir($tab2, $_POST);
 }
 header('location:?router=T0029/associar&cod='.$cod."&nome=".$nome.'&#tabs-2');
}

//Verfica se NULL para executar a inserção de departamentos na tabela T055_T006T077
if(!is_null($_POST['T077_codigo']))
{
 $Departamento    =   $_POST['T077_codigo'];
 
 if(empty($_POST['T055_T006T077_visualizar']))
 $_POST['T055_T006T077_visualizar'] = 0 ;
 //Verifica se o campo de permissão Alterar esta vazio, se verdadeiro, iguala a zero.
 if(empty($_POST['T055_T006T077_alterar']))
 $_POST['T055_T006T077_alterar']    = 0 ;
 //Verifica se o campo de permissão Excluir esta vazio, se verdadeiro, iguala a zero.
 if(empty($_POST['T055_T006T077_excluir']))
 $_POST['T055_T006T077_excluir']    = 0 ;
 
 foreach ($Departamento as $valores)
 {
     
     
     
  $_POST['T077_codigo']  =   $valores;
  $inserir               =   $obj->inserir($tab3, $_POST);
 }
 //header('location:?router=T0029/associar&cod='.$cod."&nome=".$nome.'&#tabs-1');
}

$user = $_SESSION['user'];

//Retorna os usuários associados na Tabela T004_T055
$Usuarios               = $obj->retornaUsuariosComPermissao($cod);
//Retorna Perfis no select box, que ainda não estão associados
$Perfis                 = $obj->retornaPerfis($cod);
//Retorna os perfis associados na T009_T055
$PerfisPermissao        = $obj->retornaPerfisComPermissao($cod);
// Retorna as lojas para select box
$Lojas                  = $obj->retornaLojas();
//Retorna os departamentos no select box, que ainda não foram associados
$Departamentos          = $obj->retornaDepartamentos($cod);
//Retorna os departamentos associados na T055_T077
$DepartamentoPermissao  = $obj->retornaDepartamentosComPermissao($cod);

?>
<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0029/home">Listar</a></li>
                <li><a href="?router=T0029/home#tabs-2">Novo</a></li>
            </ul>
        </span>
    </div>
</div>
<div id="conteudo">
    <span class="form-titulo">
        <p>Arquivo: <?php echo $cod." - ".$nome;?></p>
    </span>
</div>
<div id="tabs">
    <ul>
        <li><a href="#tabs-1">Permissão por Departamento</a></li>
        <li><a href="#tabs-2">Permissão por Perfil</a></li>
        <li><a href="#tabs-3">Permissão por Usuário</a></li>
    </ul>
    <!-- DIV ABAIXO, MOSTRA O FORMULÁRIO DE PERMISSÃO PARA DEPARTAMENTO - INICIO --------------------------------------------------------------------------------------------------- -->
    <div id="tabs-1">
        <div id="formulario">
            <span class="form-input">
            <form action="" method="post" id="formCad">
                <table>
                    <tr>
                        <td><label class="label">Loja*</label></td>
                        <td><label class="label">Departamentos*</label></td>
                        <td><label class="label">Permissões</label></td>
                    </tr>
                    <tr>
                        <td>
                            <select name="T006_codigo" id="loja" class="validate[required] selecionaLoja">
                                <option value="">Selecione...</option>
                                <?php
                                foreach($Lojas as $campos=>$valores){
                                ?>
                                <option value="<?php echo $valores['Codigo']; ?>"><?php echo $obj->preencheZero("E", 3, $valores['Codigo'])." - ".$valores['Nome']; ?></option>
                                <?php } ?>
                            </select>                            
                        </td>
                        <td>
                            <select name="T077_codigo[]" id="departamentos" class="validate[required] retornaDepartamentos" style="width: 300px; height: 100px;" multiple>

                            </select>
                            <input type="hidden" name="T055_codigo" value="<?php echo $cod; ?>" />
                        </td>
                        <td valign="top">
                            <input type="checkbox" name="T055_T006T077_visualizar"   value="1" style="display:inline;" checked />Download<br/>
                            <input type="checkbox" name="T055_T006T077_alterar"      value="1" style="display:inline;" />Alterar<br/>
                            <input type="checkbox" name="T055_T006T077_excluir"      value="1" style="display:inline;" />Excluir
                        </td>
                    </tr>
                </table>
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
                                        <th>Loja        </th>
                                        <th>Departamento</th>
                                        <th width="8%">Download</th>
                                        <th width="8%">Alterar</th>
                                        <th width="8%">Excluir</th>
                                        <th width="7%">Ações</th>
                                </tr>
                        </thead>
                        <tbody> <?php $i==0;?>
                                <?php foreach($DepartamentoPermissao as $campos=>$valores){ ?>
                                <?php $i++;?>
                                <tr>
                                    <td><?php echo $valores['CodigoLoja']." - ".$valores['NomeLoja'];?></td>
                                    <td><?php echo $valores['CodigoDepartamento']." - ".$valores['NomeDepartamento'];?></td>
                                    <td>
                                        <?php
                                        if($valores['Visualizar'] == 1)
                                         echo "<p class='centerp'><span class='ui-icon ui-icon-check'></span></p>";
                                        else
                                         echo "<p class='centerp'><span class='ui-icon ui-icon-close'></span></p>";
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        if($valores['Alterar'] == 1)
                                         echo "<p class='centerp'><span class='ui-icon ui-icon-check'></span></p>";
                                        else
                                         echo "<p class='centerp'><span class='ui-icon ui-icon-close'></span></p>";
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        if($valores['Excluir'] == 1)
                                         echo "<p class='centerp'><span class='ui-icon ui-icon-check'></span></p>";
                                        else
                                         echo "<p class='centerp'><span class='ui-icon ui-icon-close'></span></p>";
                                        ?>
                                    </td>
                                    <td class="acoes">
                                        <span class="lista_acoes">
                                        <ul>
                                            <li class="ui-state-default ui-corner-all" title="Excluir"  ><a href="javascript:excluir('T0029','T0029/associar&cod=<?php echo $cod;?>&nome=<?php echo $nome;?>','T055_T006T077','T077_codigo','<?php echo ($valores['CodigoDepartamento']);?>','T006_codigo','<?php echo $valores['CodigoLoja']; ?>')" class="ui-icon ui-icon-closethick"></a></li>
                                        </ul>
                                        </span>
                                    </td>
                                </tr>
                                <?php } if($i==0) { ?>
                                <tr>
                                    <td colspan="5">Não há usuarios associados a esse grupo!</td>
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
    </div>
    <!-- DIV ACIMA, MOSTRA O FORMULÁRIO DE PERMISSÃO PARA DEPARTAMENTO - FINAL  --------------------------------------------------------------------------------------------------- -->
    <!-- ESSA DIV, MOSTRA O FORMULÁRIO DE PERMISSÃO PARA PERFIL - INICIO --------------------------------------------------------------------------------------------------- -->
    <div id="tabs-2">
        <div id="formulario">
            <span class="form-input">
            <form action="" method="post" id="formCad">
                <table>
                    <tr>
                        <td width="350px;"><label class="label">Perfis*</label></td>
                        <td><label class="label">Permissões</label></td>

                    </tr>
                    <tr>
                        <td>
                            <select name="T009_codigo[]" id="perfil" class="validate[required] form-input-text" style="width: 300px; height: 100px;"multiple>
                                <?php
                                foreach($Perfis as $campos=>$valores){
                                ?>
                                <option value="<?php echo $valores['Codigo']; ?>"><?php echo $valores['Codigo']." - ".$valores['Nome']; ?></option>
                                <?php } ?>
                            </select>
                            <input type="hidden" name="T055_codigo" value="<?php echo $cod; ?>" />
                        </td>
                        <td valign="top">
                            <input type="checkbox" name="T009_T055_visualizar"   value="1" style="display:inline;" checked />Download<br/>
                            <input type="checkbox" name="T009_T055_alterar"      value="1" style="display:inline;" />Alterar<br/>
                            <input type="checkbox" name="T009_T055_excluir"      value="1" style="display:inline;" />Excluir
                        </td>
                    </tr>
                </table>
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
                                        <th>Perfil</th>
                                        <th width="8%">Download</th>
                                        <th width="8%">Alterar</th>
                                        <th width="8%">Excluir</th>
                                        <th width="7%">Ações</th>
                                </tr>
                        </thead>
                        <tbody> <?php $i==0;?>
                                <?php foreach($PerfisPermissao as $campos=>$valores){ ?>
                                <?php $i++;?>
                                <tr>
                                    <td><?php echo $valores['Codigo']." - ".$valores['Nome'];?></td>
                                    <td>
                                        <?php
                                        if($valores['Visualizar'] == 1)
                                         echo "<p class='centerp'><span class='ui-icon ui-icon-check'></span></p>";
                                        else
                                         echo "<p class='centerp'><span class='ui-icon ui-icon-close'></span></p>";
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        if($valores['Alterar'] == 1)
                                         echo "<p class='centerp'><span class='ui-icon ui-icon-check'></span></p>";
                                        else
                                         echo "<p class='centerp'><span class='ui-icon ui-icon-close'></span></p>";
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        if($valores['Excluir'] == 1)
                                         echo "<p class='centerp'><span class='ui-icon ui-icon-check'></span></p>";
                                        else
                                         echo "<p class='centerp'><span class='ui-icon ui-icon-close'></span></p>";
                                        ?>
                                    </td>
                                    <td class="acoes">
                                        <span class="lista_acoes">
                                        <ul>
                                            <li class="ui-state-default ui-corner-all" title="Excluir"  ><a href="javascript:excluir('T0029','T0029/associar&cod=<?php echo $cod;?>&nome=<?php echo $nome;?>','T009_T055','T009_codigo','<?php echo ($valores['Codigo']);?>')" class="ui-icon ui-icon-closethick"></a></li>
                                        </ul>
                                        </span>
                                    </td>
                                </tr>
                                <?php } if($i==0) { ?>
                                <tr>
                                    <td colspan="5">Não há usuarios associados a esse grupo!</td>
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
    </div>
    <!-- DIV ACIMA, MOSTRA O FORMULÁRIO DE PERMISSÃO PARA PERFIL  - FINAL ---------------------------------------------------------------------------------------------------- -->
    <!-- ESSA DIV, MOSTRA O FORMULÁRIO DE PERMISSÃO PARA USUÁRIO - INICIO --------------------------------------------------------------------------------------------------- -->
    <div id="tabs-3">
        <div id="formulario">
            <span class="form-input">
            <form action="" method="post" id="formCad">
                <table>
                    <tr>
                        <td width="680px"><label class="label">Nome*     </label></td>
                        <td>              <label class="label">Permissões</label></td>
                    </tr>
                    <tr>
                        <td>
                            <input type="text" name="T004_login" id="buscaUsuario" class="validate[required] buscaUsuario" size="100" />
                            <input type="hidden" name="T055_codigo" value="<?php echo $cod; ?>"    />
                        </td>
                        <td>
                            <input type="checkbox" name="T004_T055_visualizar"   value="1" style="display:inline;" checked />Download
                            <input type="checkbox" name="T004_T055_alterar"      value="1" style="display:inline;" />Alterar
                            <input type="checkbox" name="T004_T055_excluir"      value="1" style="display:inline;" />Excluir
                        </td>
                    </tr>
                </table>
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
                                        <th>Login    </th>
                                        <th>Nome     </th>
                                        <th width="8%">Download</th>
                                        <th width="8%">Alterar</th>
                                        <th width="8%">Excluir</th>
                                        <th width="7%">Ações    </th>
                                </tr>
                        </thead>
                        <tbody> <?php $i==0;?>
                                <?php foreach($Usuarios as $campos=>$valores){ ?>
                                <?php $i++;?>
                                <tr>
                                    <td class="codigo"><?php echo ($valores['Login']);?></td>
                                    <td>               <?php echo ($valores['Nome']);?></td>
                                    <td>
                                        <?php
                                        if($valores['Visualizar'] == 1)
                                         echo "<p class='centerp'><span class='ui-icon ui-icon-check'></span></p>";
                                        else
                                         echo "<p class='centerp'><span class='ui-icon ui-icon-close'></span></p>";
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        if($valores['Alterar'] == 1)
                                         echo "<p class='centerp'><span class='ui-icon ui-icon-check'></span></p>";
                                        else
                                         echo "<p class='centerp'><span class='ui-icon ui-icon-close'></span></p>";
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        if($valores['Excluir'] == 1)
                                         echo "<p class='centerp'><span class='ui-icon ui-icon-check'></span></p>";
                                        else
                                         echo "<p class='centerp'><span class='ui-icon ui-icon-close'></span></p>";
                                        ?>
                                    </td>
                                    <td class="acoes">
                                        <span class="lista_acoes">
                                        <ul>
                                            <li class="ui-state-default ui-corner-all" title="Excluir"  ><a href="javascript:excluir('T0029','T0029/associar&cod=<?php echo $cod;?>&nome=<?php echo $nome;?>','T004_T055','T004_login','<?php echo ($valores['Login']);?>')" class="ui-icon ui-icon-closethick"></a></li>
                                        </ul>
                                        </span>
                                    </td>
                                </tr>
                                <?php } if($i==0) { ?>
                                <tr>
                                    <td colspan="6">Não há usuarios associados a esse grupo!</td>
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
    </div>
    <!-- DIV ACIMA, MOSTRA O FORMULÁRIO DE PERMISSÃO PARA USUÁRIO - FINAL  --------------------------------------------------------------------------------------------------- -->
</div>

