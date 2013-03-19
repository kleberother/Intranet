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
                        <li class="divisao-de-lista">$Usuario</li>
                        <li class="divisao-de-lista"><a href="#">Meus Dados</a></li>
                        <li><a href="#">Sair</a></li>
                    </ul>
                </div>
            </div>
        </div>
        
        <div id="menu-principal" class="padding-5px-vertical">
<!--            <div class="margim-padrao-horizontal">-->
                <ul class="lista-horizontal">
                    <li><a href="#">Link 01</a></li>
                    <li><a href="#">Link 02</a></li>
                    <li><a href="#">Link 03</a></li>
                    <li><a href="#">Link 04</a></li>
                </ul>
<!--            </div>-->
        </div>

        <div id="corpo"     class="padding-padrao-vertical">
            <div class="margim-padrao-horizontal">
                <div id="abas">
                    <ul>
                        <li><a href="#aba-1">Adicionados por mim</a></li>
                        <li><a href="#aba-2">Adicionados para mim</a></li>
                    </ul>
                    <div id="aba-1">
                        <div class="caixa-de-ferramentas padding-padrao-vertical">
                            <ul class="lista-horizontal">
                                <li><a href="#" class="addArquivo     botao-padrao">Adicionar Arquivo</a></li>
                                <li><a href="#" class="botao-padrao">Compartilhar Arquivo</a></li>
                                <li><a href="#" class="marcarArquivos botao-padrao">Marcar\Desmarcar todos os Arquivos</a></li>
                                <li><a href="#" class="botao-padrao">Excluir</a></li>
                            </ul>
                        </div>
                        <div class="padding-padrao-vertical">
                            <ul class="menu-tree">
<!--                                <li class="diretorio"><a href="#">Categoria 01</a>
                                    <ul class="submenu-tree item">
                                        <li><a href="#">Item 01</a></li>
                                        <li><a href="#">Item 02</a></li>
                                    </ul>                                   
                                </li>
                                <li class="diretorio"><a href="#">Categoria 02</a>
                                    <ul class="submenu-tree item">
                                        <li><a href="#">Item 01</a></li>
                                        <li><a href="#">Item 02</a></li>
                                    </ul>   
                                </li>
                                <li class="diretorio"><a href="#">Categoria 03</a>
                                    <ul class="submenu-tree item">
                                        <li><a href="#">Item 01</a></li>
                                        <li><a href="#">Item 02</a></li>
                                    </ul>    
                                </li>        
                            </ul>                         -->
                            <ul class="lista-arquivos">
                                <li><p><input type="checkbox" value="1" name="marcar[]" class="marcarArquivo"/> Arquivo</p></li>          
                                <li><p><input type="checkbox" value="1" name="marcar[]" class="marcarArquivo"/> Arquivo</p></li>          
                                <li><p><input type="checkbox" value="1" name="marcar[]" class="marcarArquivo"/> Arquivo</p></li>          
                                <li><p><input type="checkbox" value="1" name="marcar[]" class="marcarArquivo"/> Arquivo</p></li>          
                                <li><p><input type="checkbox" value="1" name="marcar[]" class="marcarArquivo"/> Arquivo</p></li>          
                                <li><p><input type="checkbox" value="1" name="marcar[]" class="marcarArquivo"/> Arquivo</p></li>          
                                <li><p><input type="checkbox" value="1" name="marcar[]" class="marcarArquivo"/> Arquivo</p></li>          
                            </ul>                         
                        </div>
                    </div>
                    
                    <div id="aba-2">
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
