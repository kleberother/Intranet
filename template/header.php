<?php
//Set Data do Cabeçalho
$data = date; 
$obj = new models_home();
//Trata Sessão Usuário e Menus
$model = new models();
if (is_null($_SESSION['user']))
{
    $user = null;
    $menu=$model->menu("");
    $TituloPrograma =   "";
}
else
{
    //Fonte baixa para usuario
    $_SESSION['user'] = strtolower($_SESSION['user']);
    $user = $_SESSION['user'];
    $Grupo= $model->selecionaPerfil($user);
    foreach($Grupo as $campos=>$valores)
    {
        $grps .= $valores['COD'] . ",";
    }
    $grps = substr($grps,0,strlen($grps)-1);
    $menu=$model->menu("privado",$grps);
    
    $ProgramaAtual      =   $_REQUEST['router'];
    $ProgramaAtual      =   explode("/",$ProgramaAtual);
    $ProgramaAtual[0]   =   str_replace("T", "", $ProgramaAtual[0]);
    $ProgramaAtual      =   $ProgramaAtual[0];
    if (is_numeric($ProgramaAtual))
    {
        if (!empty($ProgramaAtual))
        {
            $DadosPrograma      =   $obj->title($ProgramaAtual);
            foreach($DadosPrograma as $campos=>$valores)
            {
                $TituloPrograma =   $valores['EstruturaTitulo'];
            }
        }   
    }else
        $TituloPrograma = "Home";
    
}

//Classe para Atalhos

$atalhosGlobais = $obj->atalhosGlobais();
$stringData     = $obj->string_data($data);

if (empty($_SERVER['msg'])) 
{
    $_SERVER['msg'] = "Você ainda não está logado, clique aqui para logar!";    
}
$msg         = $_SERVER['msg'];
$displayname = $_SESSION['displayName'];

//Fast Path
$fp     =   $_POST['FastPath'];

if(!is_null($fp))
{
    $fp = str_pad($fp, 4, "0", STR_PAD_LEFT);
    header("location:/?router=T$fp/home");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE" />
<title>Intranet D´avó</title>
<link rel="shortcut icon" href="template/img/favicon.ico" />
<link rel="icon" href="template/img/favicon.ico" />
<link rel="stylesheet" href="template/css/-estilo-include-tudo.css"/>
<!--[if IE 7]>
        <link rel="stylesheet" type="text/css" href="template/css/-estilo-include-tudo-ie7.css" />
<![endif]-->

<!-- BIBLIOTÉCA JQUERY 1.6.1 ------------------------------------------------------------------------->
<script src="template/js/interno/jquery-1.6.1.min.js"></script>
<!--<script src="template/js/interno/jquery-ui-1.8.11.custom.min.js"></script>-->

<!-- MÁSCARAS EM CAMPOS INPUT ------------------------------------------------------------------------>
<script src="template/js/interno/jquery.maskedinput-1.3.js"></script>

<!-- INCLUDE FUNÇÃO DE MOEDA ------------------------------------------------------------------------->
<script src="template/js/interno/moeda.js"></script>

<!-- MÁSCARAS MONETÁRIO (REAL) PARA CAMPOS INPUT ----------------------------------------------------->
<script src="template/js/interno/jquery.price_format.1.4.js"></script>

<!-- JQUERY BIBLIOTECA MATEMÁTICA -------------------------------------------------------------------->
<script src="template/js/interno/jquery.math.1.0.js"></script>

<!-- JQUERY GRÁFICO -------------------------------------------------------------------->
<script src="template/js/interno/highcharts.js"></script>
<script src="template/js/interno/highcharts_export.js"></script>

<!-- SCRIPTS DE MENU --------------------------------------------------------------------------------->
<script src="template/js/interno/menu.js"></script>

<!-- SCRIPTS PARA BUSCA RÁPIDA ----------------------------------------------------------------------->
<script type="text/javascript" src="template/js/interno/jquery.quicksearch.js"></script>

<!-- TEMPLATE PARA CX LOGIN -------------------------------------------------------------------------->
<script src="template/js/jquery/ui/jquery-ui-1.8.11.custom.js"></script>
<script src="template/js/interno/login.js"></script>
<script src="template/js/interno/classes-ui-jquery-form.js"></script>
<script src="template/js/interno/funcoesGerais.js"></script>

<!-- VALIDAÇÃO DE FORMULÁRIO INICIO ------------------------------------------------------------------>
<script src="template/js/validacao/jquery.validationEngine.js"></script>
<script src="template/js/validacao/languages/jquery.validationEngine-pt.js"></script>
<script src="template/js/validacao/jquery.ui.datepicker.validation.js"></script>
<script>
    jQuery(document).ready(function(){
        // Liga Submit do formulário com os vampos para a engine de validação
        jQuery("#formCad").validationEngine();
    });
</script>
<!-- VALIDAÇÃO DE FORMULÁRIO FIM --------------------------------------------------------------------->

<!-- EDITOR TEXTAREA --------------------------------------------------------------------------------->
<script type="text/javascript" src="template/js/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="template/js/tiny_mce/tiny_mce_config.js"></script>
<link rel="stylesheet" href="template/css/-interno/cx_dialogo_login.css"/>
<!-- FIM EDITOR TEXTAREA ----------------------------------------------------------------------------->

<!-- GRID SYSTEM --------------------------------------------------------------------------------->
<link rel="stylesheet" href="template/css/-960/960.css" />
<!-- FIM GRID SYSTEM ----------------------------------------------------------------------------->

<!-- MENSAGENS --------------------------------------------------------------------------------------->
<script type="text/javascript" src="template/js/msgs/jquery.pnotify.js"></script>
<link href="template/css/-msgs/jquery.pnotify.default.css" rel="stylesheet" type="text/css" />
<link href="template/css/-msgs/jquery.pnotify.default.icons.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="template/js/interno/mensagens.js"></script>
<!-- FIM MENSAGENS ----------------------------------------------------------------------------------->

<!-- FLIP PAGE --------------------------------------------------------------------------------------->
<script type="text/javascript" src="template/js/flipPage/js/swfobject.js"></script>
<script type="text/javascript" src="template/js/flipPage/js/swfaddress.js"></script>
<script type="text/javascript" src="template/js/flipPage/megazine/megazine.js"></script>
<!-- FIM FLIP PAGE ----------------------------------------------------------------------------------->

<!-- ORDENAÇÃO DE TABELA (TABLESORTER) ----------------------------------------------------------------------------------->
<link rel="stylesheet" href="template/js/tablesorter/themes/blue/style.css" type="text/css" media="print, projection, screen" />
<script type="text/javascript" src="template/js/tablesorter/tablesorter.js"></script>

<!-- FIM ORDENAÇÃO DE TABELA (TABLESORTER) ----------------------------------------------------------------------------------->

<!-- INICIO SCRIPT LISTPICKER ---------------------------------------------------------->
<script type="text/javascript" src="template/js/interno/jquery.listpicker.js"></script>
<!-- FIM SCRIPT LISTPICKER ------------------------------------------------------------->

</head>
    
<!--   IMPORTA JS NO PROGRAMA CASO EXISTA     -->
<?php 
$arquivoJs  =   "template/js/interno/".PROGRAMA."/".PROGRAMA.".js";
if (file_exists($arquivoJs))
    echo "<script src='$arquivoJs'></script>";
?>    
    
    
<body id="tools">

<!-- PARA APAGAR DIV DO MENU APYCOM -------------------------------------------- NÃO APAGAR ---------->
<div style="visibility:hidden; display: none">
    <a href="http://apycom.com/">Apycom jQuery Menus</a>
</div>
<div id="dialog-form" title="Caixa de Login" style="display:none">
	<p class="validateTips">Digite sua Senha e Login de Rede</p>
     
	<form id="frm" action="?router=home/js.usuario" method="post">
	<fieldset>
		<label for="name">Usuário</label>
		<input type="text" name="name" id="name" class="text ui-widget-content ui-corner-all" />
		<label for="password">Senha</label>
		<input type="password" name="password" id="password" value="" class="text ui-widget-content ui-corner-all" />
	</fieldset>
	</form>
</div>
<div id="dialog-form2" title="Confirmação de Dados!" style="display:none">
	<p class="validateTips">Preencha/Confira seus dados. Obs.: Campos com (*) são obrigatórios!</p>     
	<form id="frm2" action="?router=home/js.usuario" method="post">
	<fieldset>
            <label class="label">Nome Completo*</label>
                <input type="text" name="T004_nome"         id="nome"           class="form-input-text" />
            <label class="label">Matricula*</label>
                <input type="text" name="T004_matricula"    id="matricula"      class="form-input-text" />
            <label class="label">Função*</label>
                <input type="text" name="T004_funcao"       id="funcao"         class="form-input-text" />
            <label class="label">Departamento*</label>
                <input type="text" name="T004_departamento" id="departamento"   class="form-input-text" />
            <label class="label">Ramal</label>
                <input type="text" name="T004_ramal"        id="ramal"          class="form-input-text" />
            <label class="label">Celular</label>
                <input type="text" name="T004_celular"      id="celular"        class="form-input-text" />
            <label class="label">Loja*</label>
                <select             name="T006_codigo"      id="loja"           class="form-input-text"  ></select>            
	</fieldset>
	</form>
</div>
<div id="dialog-form3" title="APROVAÇÕES PENDENTES" style="display:none">
            <label class="label">Aprovação de Pagamento (AP):</label>
            <table>
                <tr>
                    <td id="ApPendente" align="right" valign="center"  width="30" ></td>
                    <td                               valign="center"  width="200" height="25"> - AP(s) Aguardando Minha Aprovação   </td>
                </tr>
                <tr>
                    <td id="ApAbaixo" align="right" valign="center" width="30"></td>
                    <td                             valign="center" width="200" height="25"> - AP(s) Anteriores a Mim   </td>
                </tr>
                <tr>
                    <td id="ApDentroPrazo" align="right" valign="center" width="30"></td>
                    <td valign="center" width="200" height="25" > - Ap(s) Dentro do Prazo</td>
                </tr>
                <tr>
                    <td id="ApForaPrazo" align="right" valign="center" width="30"></td>
                    <td valign="center" width="200" height="25"> - Ap(s) Fora do Prazo</td>
                    <td id="vApForaPrazo">
                        <ul class="lista-de-acoes">
                            <li id="linkAp"><a href="?router=T0016/home&Msg=1" title="Abrir Tela AP(s)">
                                    <span class='ui-icon ui-icon-search'></span>
                                </a>
                            </li>
                        </ul>                        
                    </td>
                </tr>
            </table>
            <label class="label">Reembolso de Despesa (RD)  :</label>
            <table>
                <tr>
                    <td id="DespesaPendente" align="right" valign="center" width="30"></td>
                    <td                                    valign="center" width="200" height="25"> - RD(s) Aguardando Minha Aprovação   </td>
                </tr>
                <tr>
                    <td id="DespesaAbaixo"  align="right" valign="center" width="30" ></td>
                    <td                                   valign="center" width="200" height="25"> - RD(s) Anteriores a Mim   </td>
                    <td id="vDespesaAbaixo">
                        <ul class="lista-de-acoes">
                            <li><a href="?router=T0026/home" title="Abrir Tela RD(s)">
                                    <span class='ui-icon ui-icon-search'></span>
                                </a>
                            </li>
                        </ul>
                    </td>
                </tr>
            </table>
            
</div>
<!-- 
    // Data de Criação: 24/11/2011 
    // Desenvolvedor: Jorge Nova
    // Div para inserir modals dinâmicos
-->
<div id="dialog-modal">
   
</div>
<div id="dialog-mensagem">
   
</div>




<!-- 
    // Final do modal de dialog-mostraUsuario
-->

<div id="pagina">
	<div id="cabecalho">
    	<div id="cabec-conteudo">
            <div id="cabec-cont-informacao">
            	<div id="cabec-cont-info-data">
                	<span class="cabec-cont-info-data-p"><p><?php echo $stringData;?></p></span>
                </div>
                <div id="cabec-cont-info-atalhos">
                	<span class="cabec-info-atal-ul">
                        <ul>
                            <?php foreach ($atalhosGlobais as $campos=>$valores){?>
                            <li><a href="<?php echo $valores['URL']?>" title="<?php echo $valores['Titulo']?>" target="_blank"><img src="<?php echo $valores['Caminho']?>" alt="" /></a></li>
                            <?php }?>
                        </ul>
                    </span>
                </div>
                <div id="cabec-cont-info-fast_path">
                	<span class="cabec-cont-info-fast_path-form">
                    	<form action="" method="post">
                            <table>
                                <thead>
                                <tr>
                                    <td><input type="text" class="fp-text" value="Fast Path" id="fastpath"  name="FastPath"/></td>
                                    <td><button class="botao"></button></td>
                                </tr>
                                </thead>
                            </table>
                    	</form>
                    </span>
                </div>
                <div id="cabec-cont-info-login">
                	<span class="cabec-info-logi-ul">
                        <ul><li class="usuario">
                        <?php if (is_null($user))
                              {
                                 echo "<a href='#' id='cx_login'>".$msg."</a>";
                              }
                              else
                              {
                                 echo "Bem Vindo(a) ".ucwords($displayname)."  "./*"<a href='?router=T0010/dadospessoais' class='cabec-info-logi-ul-sair'>Meus Dados</a>".*/"<a href='#' class='cabec-info-logi-ul-sair' id='logout'>Sair</a>";
                              }?>
                             </li>
                        </ul>
                        </span>
                </div>
            </div>

            <div id="cabec-cont-localizacao">
                <div id="cabec-cont-loca-conteudo">
                    <div id="cabec-cont-loca-cont-logo">
                        <a href="?router=home/home"><img src="template/css/-template-imagens/logo.png" alt="D´avó" /></a>
                    </div>
                    <div id="cabec-cont-loca-cont-titulo_breadcrumbs">
                        <span class="titulo"><h3>Intranet D´avó, Quem acessa conhece!</h3></span>
                        <span class="bread"><center><h1><?php echo $TituloPrograma?></h1></center></span>
                    </div>
                </div>
            </div>

            <div id="cabec-cont-menu">
                <div id="menu">
                <?php
                        function menu($menu)
                        {
                            foreach($menu as $chaves=>$valores)
                            {
                                if (is_array($valores))
                                {   array_push($valores,"A");?>
                                    <li><a href='javascript:void(0)' class='parent'><span><?php echo $chaves;?></span></a><ul>
                                    <?php
                                    menu($valores);
                                }
                                else
                                {   if($valores!="A")
                                    { ?>
                                        <li><a href='?router=T<?php echo $valores = str_pad($valores, 4, "0", STR_PAD_LEFT);?>/home'><span><?php echo $chaves?></span></a></li>
                              <?php }
                                    else
                                    {?>
                                        </ul></li>
                              <?php }
                                }
                            }?>
                         <?php
                         } ?>
                <ul id="menu"><?php menu($menu);?></ul>
                </div>
            </div>
        </div>
    </div>
<?php
//Mensagem/Alertas
//Variavel para controle se existe mensagem em $_SESSION

$true       =   $_SESSION['alert']['true']                      ;

//Verifica se verdade
if ($true)
{
    //Preenche as variaveis para mensagem
    $err        =   $_SESSION['alert']['err']                   ;   //se erro (True/False)
    $titulo     =   $_SESSION['alert']['titulo']                ;   //titulo mensagem
    $mensagem   =   $_SESSION['alert']['mensagem']              ;   //mensagem
    
    //exibe mensagem
    if($true)
    echo "<script>show_stack_bottomleft($err, '$titulo', '$mensagem');</script>";
    
    //anula msg para proximo refresh
    $_SESSION['alert']['true'] = false;        
    
}
?>    
    