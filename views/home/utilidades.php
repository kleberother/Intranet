<?php
//Chama classes

//Classe para Atalhos pessoais
$objAtalhosP = new models_home();
$atalhosP    = $objAtalhosP->atalhosPessoais();

?> 

<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=home/home">Home</a></li>
                <li><a href="?router=home/utilidades" class="active">Utilidades</a></li>
            </ul>
        </span>
    </div>
</div>
<div id="conteudo">
    <div id="cont-favoritos">
        <span class="cont-favo-titulo">
            <p>Favoritos</p>
        </span>
        <span class="cont-favo-lista">
            <ul>
                <?php foreach($atalhosP as $campos=>$valores){?>
                <li><a href="<?php echo $valores['URL'];?>" style="background: url(<?php echo $valores['CAMINHO'];?>) left no-repeat;"><?php echo ($valores['TITULO']);?></a></li>
                <?php }?>
            </ul>
        </span>
    </div>
    <div id="cont-widgets">
        <span class="cont-widg-titulo">
            <p>Widgets</p>
        </span>
        <div id="accordionResizer" style="margin-left: 10px; height:220px;">
            <div id="cont-widg-conteudo">
                <h3><a href="#">Tempo</a></h3>
                <div>
                    <iframe src='http://selos.climatempo.com.br/selos/MostraSelo.php?CODCIDADE=558&SKIN=padrao' scrolling='no' frameborder='0' width="150" height='170' marginheight='0' marginwidth='0' align="center"></iframe>
                </div>
                <h3><a href="#">Cotação</a></h3>
                <div>
                    <script src="http://www.gmodules.com/ig/ifr?url=http://www.tidybits.com/igquotesbr/specification.xml&amp;up_stocks=PETR4.SA%7CVALE5.SA%7CBVMF3.SA&amp;up_indexes=%5EBVSP%7C%5EDJI%7C%5EIXIC&amp;synd=open&amp;w=152&amp;h=429&amp;title=Cota%C3%A7%C3%B5es%2C+%C3%8Dndices+e+C%C3%A2mbio&amp;border=%23ffffff%7C3px%2C1px+solid+%23999999&amp;output=js"></script>
                </div>
            </div>
        </div>
    </div>
</div>