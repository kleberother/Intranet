<!DOCTYPE html>
<html>
    <head>        
        <title>Extranet D´avó</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link href="template/extranet/css/estilo-include.css" rel="stylesheet" type="text/css" />        
        <script src="template/extranet/js/jquery-1.7.1.min.js"></script>       
        <script src="template/extranet/js/jquery-ui-1.8.16.custom.min.js"></script>       
        <script src="template/extranet/js/funcoesGerais.js"></script>       
    </head>
    <body>

        <div id="modal">

        </div>
        
        <div id="cabecalho" class="padding-padrao-vertical">
            <div class="margim-padrao-horizontal conteudo-visivel">
                <div class="logo-02 alinhado-esquerda">
                    
                </div>
                <div class="alinhado-direita">
                    <ul id="menu-usuario" class="lista-horizontal">
                        <li class="divisao-de-lista">Bem Vindo(a) <?php echo $_SESSION['displayName'];?></li>
                        <li class="divisao-de-lista"><a href="?router=extranet/alterasenha">Alterar Senha</a></li>
                        <li><a href="#" id="logout">Sair</a></li>
                    </ul>
                </div>
            </div>
        </div>
        
        <div id="menu-principal" class="padding-5px-vertical">
<!--            <div class="margim-padrao-horizontal">-->
                <ul class="lista-horizontal">
                    <li><a href="?router=extranet/home">Home</a></li>
                    <li><a href="?router=T0067/home">Arquivos</a></li>
                </ul>
<!--            </div>-->
        </div>
        
        <div id="corpo"     class="padding-padrao-vertical">
            <div class="margim-padrao-horizontal">