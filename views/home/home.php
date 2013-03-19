<?php
//Chama classes
 
//Classe para Banners
$obj = new models_home(); 
$banners    = $obj->selecionaBanners();

$textos     =   $obj->selecionaNoticia();

$user = $_SESSION['user'];

?>
<div id="dialog-carregando" title="Aviso!" style="display:none">
    <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Teste</p>
</div>
<div id="ferramenta">
    <div id="ferr-conteudo">  
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=home/home" class="active">Home</a></li>
                <li><a href="?router=home/utilidades">Utilidades</a></li>
            </ul>
        </span>
    </div>
</div>
<div id="conteudo">
    <div class="conteudo-visivel">
    <p style="margin-left: 11px; margin-bottom: 3px; font-size: 13px;">Entre no sistema com seus dados (Usuário e Senha), e clique na imagem para visualizar as notícias.</p>
    <div id="cont-borda">
        <div id="cont-bord-imagem">
            <?php foreach($banners as $campos=>$valores){?>
            <span class="cont-bord-imagem-img">
                <a href="template/img/noticias/CONFIANCAPREMIO.pdf" target="_blank"><img src="<?php echo $valores['CAMINHO'];?>" /></a>
            </span>
            <?php }?>
        </div>
        <br/>
    </div>
    <div id="cont-noticia">
        <div id="accordionResizer" style="margin-left: 10px; height:420px; width: 250px;">
            <div id="cont-widg-conteudo">
                <h3><a href="#">Cotação</a></h3>
                <div>
                    <iframe scrolling="no" frameborder="0" id="remote_iframe_0" name="remote_iframe_0" style="border: 0px none; padding: 0px; margin: 0px; width: 100%; height: 423px; overflow: hidden;" onload="_tick_ol('qV68')" src="http://www-igprev-opensocial.googleusercontent.com/gadgets/ifr?exp_rpc_js=1&amp;exp_track_js=1&amp;url=http%3A%2F%2Fwww.tidybits.com%2Figquotesbr%2Fspecification.xml&amp;container=igprev&amp;view=default&amp;lang=pt-br&amp;country=US&amp;sanitize=0&amp;v=39309669e699bb6d&amp;parent=http://www.google.com&amp;libs=core:core.io:core.iglegacy:auth-refresh&amp;synd=igprev&amp;view=default#rpctoken=1869713214&amp;ifpctok=1869713214&amp;up_indexes=%5EBVSP%7C%5EDJI%7C%5EIXIC&amp;up_stocks=PETR4.SA%7CVALE5.SA%7CBVMF3.SA"></iframe>
                </div>                
                  
                <h3><a href="#">Tempo</a></h3>
                <div>
                    <iframe src='http://selos.climatempo.com.br/selos/MostraSelo.php?CODCIDADE=558&SKIN=padrao' scrolling='no' frameborder='0' width="150" height='170' marginheight='0' marginwidth='0' align="center"></iframe>
                </div>
            </div>
        </div> 
<!--        <span class="titulo">
            <?php //foreach($textos as $campos=>$valores){?>
            <p><?php //echo $valores['TITULO'];?></p>
        </span>
        <span class="chamada">
            <p><?php //echo ($valores['CHAMADA']);?></p>
        </span>
        <span class="texto">
            <p><?php //($valores['TEXTO']);?></p>
        </span>-->
        <?php //}?>
        <?php
        //if ($_SESSION['user'] != "")
        //{
        ?>
<!--        <span class="veja_mais">
            <a href="?router=home/noticias"><img src="template/css/-template-imagens/botao-veja_mais.gif" alt="Veja Mais" /></a>
        </span>-->
        <?php
        //}
        //else
        //{
        ?>
<!--        <div class="ui-state-highlight ui-corner-all destaque" style="margin-top: 20px; padding: 0 .7em;"> 
                <p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
                <strong>Faça Login para ver todas as notícias.</p>
        </div>        -->
        <?php
        //}
        ?>
    </div>
    </div>     
</div>