<?php
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 19/09/2011 por Jorge Nova                              
 * Descrição: Arquivo lista produtos de acordo com o template 02
 * Entrada:   
 * Origens:   
           
**************************************************************************
*/

// GRAVA SESSÃO DE UM USUÁRIO EM UMA VARIAVEL
$user       = $_SESSION['user'];

// INSTANCIA OBJETO DA CLASSE T0036
$obj        = new models_T0036();

$PainelCod = $_GET['PainelCod']

//$produtoB  = $obj->retornaProdutoImg2();


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link href="template/css/-display-01.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <div id="cabecalho">
            <p>AÇOUGUE</p>
        </div>
        <div id="conteudo">
            <div id="cont-left">
            <?php // definicao da Area do template
                  $AreaCod  = 1 ;
            ?>      
                <table class="produtos">
                    <thead>
                        <tr>
                            <th class="border">Descrição</th>
                            <th>Preço (R$)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php // Retorna os produtos associados para a área
                        $ListaProdutos   = $obj->retornaProdutosArea($PainelCod,$AreaCod);
                        
                        foreach($ListaProdutos as $campos=>$valores){ 
                         if ($color == "")
                             $color = "colortd";
                         else
                             $color = "";
                        ?>                            
                        <tr>
                            <td class="<?php echo $color; ?>"><?php echo $valores['DescRed']; ?></td>
                            <td class="align-right without-border-right <?php echo $color; ?>">
                            <?php if($valores['ValorPor']!=0)
                                       echo money_format('%.2n', $valores['ValorPor']); 
                                  else echo money_format('%.2n', $valores['ValorDe']);
                            ?>      
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div id="cont-middle">
            </div>
            <div id="cont-right">
            <?php // definicao da Area do template
                  $AreaCod  = 2 ;
            ?>      
                
                <?php 
                $ListaProdutos   = $obj->retornaProdutosArea($PainelCod,$AreaCod);
                
                foreach($ListaProdutos as $campos=>$valores){ ?>
                <div class="cont-right-img">
                    <div class="cont-right-img-title">
                        <p><?php echo $valores['DescRed']; ?></p>
                    </div>
                    <div id="cont-right-img-coluna">
                        <div class="left">
                            <img src="template/img/picanha.png" alt="Picanha" height="158" />
                        </div>
                        <div class="right">
                            <p class="de">De: <?php echo money_format('%.2n', $valores['ValorDe']); ?></p>
                            <p class="para">Por: <?php echo money_format('%.2n', $valores['ValorPor']); ?></p>
                        </div>
                    </div>
                </div>
                <?php } ?>
<!--                <?php //foreach($produtoB as $campos=>$valores){ ?>                   
                <div class="cont-right-img2">
                    <div class="cont-right-img-title">
                        <p><?php //echo $valores['DescReduzida']; ?></p>
                    </div>                 
                    <div id="cont-right-img-coluna">
                        <div class="left">
                            <img src="template/img/alcatra.png" alt="Alcatra" width="250"/>
                        </div>
                        <div class="right">
                            <p class="de">De: <?php //echo money_format('%.2n', $valores['ValorDe']); ?></p>
                            <p class="para">Por: <?php //echo money_format('%.2n', $valores['ValorPor']); ?></p>
                        </div>
                    </div>
                </div>
                <?php //} ?>                -->
            </div>

        </div>
        <div id="rodape">
            <marquee><p>Somente no D'Avó, voce encontra carnes com procedência garantida e melhores preços.</p></marquee>
        </div>
    </body>
</html>