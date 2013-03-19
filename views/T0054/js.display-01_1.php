<?php
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 19/09/2011 por Jorge Nova                              
 * Descrição: Arquivo lista produtos de acordo com o template 01
 * Entrada:   
 * Origens:   
           
**************************************************************************
*/

// GRAVA SESSÃO DE UM USUÁRIO EM UMA VARIAVEL
$user       = $_SESSION['user'];

// INSTANCIA OBJETO DA CLASSE T0054
$obj        = new models_T0054();

// RETORNA DADOS DE TEMPLATE
$produtos  = $obj->retornaProdutos();
$produtos2  = $obj->retornaProdutos();

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
                <table class="produtos">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th class="border">Descrição</th>
                            <th>Preço (R$)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($produtos as $campos=>$valores){ 
                         if ($color == "")
                             $color = "colortd";
                         else
                             $color = "";
                        ?>                            
                        <tr>
                            <td class="without-border-left align-right codigo <?php echo $color; ?>"><?php echo $valores['Codigo']; ?></td>
                            <td class="<?php echo $color; ?>"><?php echo $valores['DescReduzida']; ?></td>
                            <td class="align-right without-border-right <?php echo $color; ?>"><?php echo money_format('%.2n', $valores['ValorPor']); ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div id="cont-middle">
            </div>
            <div id="cont-right">
                <table class="produtos">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th class="border">Descrição</th>
                            <th>Preço (R$)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($produtos2 as $campos=>$valores){ 
                         if ($color == "")
                             $color = "colortd";
                         else
                             $color = "";
                        ?>                            
                        <tr>
                            <td class="without-border-left align-right codigo <?php echo $color; ?>"><?php echo $valores['Codigo']; ?></td>
                            <td class="<?php echo $color; ?>"><?php echo $valores['DescReduzida']; ?></td>
                            <td class="align-right without-border-right <?php echo $color; ?>"><?php echo money_format('%.2n', $valores['ValorPor']); ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div id="rodape">
            <marquee><p>Somente no D'Avó, voce encontra carnes com procedência garantida e melhores preços.</p></marquee>
        </div>
    </body>
</html>