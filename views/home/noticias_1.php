<?php
//Chama classes

//Classe para Textos das Noticias
$objTextos  =   new models_home();

$cod = $_GET['cod'];
if (empty($cod))
 $textos     =   $objTextos->selecionaNoticia();
else
 $textos   =   $objTextos->selecionaNoticiaPorID($cod);

 $ultimas    =   $objTextos->selecionaUltimaNoticia();

$user = $_SESSION['user'];

?>

<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=home/home">Home</a></li>
                <li><a href="?router=home/utilidades">Utilidades</a></li>
            </ul>
        </span>  
    </div>
</div>
<div id="conteudo">
    <div id="cont-noticia-2">
        <span class="titulo">
            <?php foreach($textos as $campos=>$valores){?>
            <p><?php echo ($valores['TITULO']);?></p>
        </span>
<!--        <span class="chamada">
            <p><?php //echo ($valores['CHAMADA']);?></p>
        </span>-->
        <span class="texto">
            <?php echo ($valores['TEXTO']);?>
        </span>
        <?php }?>
    </div>
    <div id="cont-ultimas_noticias">
        <span class="cont-ulno-titulo">
            <p>Ultimas Notícias</p>
        </span>
        <span class="cont-ulno-lista">
            <ul>
            <?php foreach($ultimas as $campos=>$valores){?>
                <li><a href="?router=home/noticias&cod=<?php echo ($valores['COD']); ?>"><?php echo ($valores['TITULO']);?></a></li>
            <?php }?>
            </ul>
        </span>
    </div>
</div>