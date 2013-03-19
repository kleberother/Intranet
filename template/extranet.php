<?php
$conn       =   "";
$obj        =   new models($conn);

if (!empty($_POST))
$autentica  =   $obj->autentica();

if(!empty($_SESSION['user']))
    //echo "Mensagem: Não Logado...";    
//else
{
    header('location:?router=extranet/home');
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Extranet D´avó</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link href="template/extranet/css/estilo-include-login.css" rel="stylesheet" type="text/css" />  
    </head>
    <body OnLoad="document.formLogin.usuario.focus();">
    <div id="cabecalho" class="padding-padrao-vertical">

        <div class="margim-padrao-horizontal">
                <div class="logo-02">
                    
                </div>            
        </div>

    </div>

    <div id="corpo">
	
        <div id="caixa-login" class="margim-padrao-horizontal padding-padrao-vertical sombra">
            <div class="margim-padrao-horizontal">
                <div>
                    <p class="titulo">Acesso Restrito</p>
                </div>

                <div>
                    <p class="subtitulo">Entre com seu usu&aacute;rio e senha</p>
                </div>

                <div>
                    <form action="#" method="post" id="" name="formLogin">
                        <fieldset>
                            <label>Usu&aacute;rio:</label>
                            <input type="text"      name="usuario"      class="caixa-texto-padrao"      id="usuario"    size="40"   />
                            <label>Senha:</label>
                            <input type="password"  name="senha"        class="caixa-texto-padrao"                      size="40"   />
                            <input type="hidden"    name="action"                                       value="login"               />
                            <input type="submit"    name="botao-padrao" class="botao-padrao-vermelho"   value="Entrar"              />     
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>

    </div>
        
    <div id="rodape" class="padding-padrao-vertical">

        <div class="margim-padrao-horizontal">
            <p><span class="copyright">© 2011 D´Avó Supermercados</span> - Extranet - Desenvolvido pela Divisão de Tecnologia</p>
        </div>

    </div>
        
    </body>
</html>
