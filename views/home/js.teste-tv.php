<?php
/* Inicializa characters com UTF-8 */
ini_set('default_charset','UTF-8');

/* Configuração de DATA             */
date_default_timezone_set('America/Sao_Paulo');

/* Configuração de LOCAL     */
setlocale(LC_ALL, 'pt_BR', 'ptb', 'pt_BR.utf-8', 'br');

header ('Content-type: text/html; charset=UTF-8');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title></title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<style type="text/css">
                *{color: #333;}
		html{border:0px; padding:0px; margin:0px; overflow-y: hidden;}
		body{border:0px; padding:0px; margin:0px; font-family:"trebuchet ms", tahoma, verdana, arial, sans-serif;}
		#cabecalho{text-align: center; background: #660000; color: #fff;}
		#cabecalho h1{font-size: 50px; margin: 0px; color: #fff;}
		#conteudo{overflow:hidden;}
		#cont-esquerda{float:left; width:45%;}
		#cont-direita{float:right; width:45%;}
		.lista{font-size: 44px; width: 100%; margin: 5px; border-spacing: 10px;}
		/*.lista td{border: 1px dotted black;}*/
		.lista td.right{text-align: right;}
		#rodape{clear: both;}
		#rodape p{font-size: 45px; margin: 2px 0;}
	</style>
  </head>
  <body>
	<div id="cabecalho">
		<h1>AÇOUGUE</h1>
	</div>
	<div id="conteudo">
		<div id="cont-esquerda">
			<table class="lista">
				<tr bgcolor="#BAB494">
                                        <td>0001 - File Mignon</td>
					<td class="right">22,00</td>
				</tr>
				<tr>
					<td>0002 - Alcatra</td>
					<td class="right">22,00</td>
				</tr>
				<tr bgcolor="#BAB494">
					<td>0003 - Contra File</td>
					<td class="right">22,00</td>
				</tr>
                                <tr>
					<td>0004 - Fraldinha</td>
					<td class="right">22,00</td>
				</tr>
                                <tr bgcolor="#BAB494">
					<td>0005 - Coxao Mole</td>
					<td class="right">22,00</td>
				</tr>
                                <tr>
					<td><span style="color: red;">0006 - Coxao Duro</span></td>
					<td class="right"><span style="color: red;">22,00</span></td>
				</tr>
                                <tr bgcolor="#BAB494">
					<td>0007 - Coxao Duro</td>
					<td class="right">22,00</td>
				</tr>						
                                <tr>
					<td>0008 - Coxao Duro</td>
					<td class="right">22,00</td>
				</tr>						
                                <tr bgcolor="#BAB494">
					<td>0009 - Coxao Duro</td>
					<td class="right">22,00</td>
				</tr>
                                <tr>
					<td>0010 - Coxao Duro</td>
					<td class="right">22,00</td>
				</tr>
			</table>
		</div>
		<div id="cont-direita">
			<table class="lista">
				<tr bgcolor="#BAB494">
					<td>0001 - Filé Mignon</td>
					<td class="right">22,00</td>
				</tr>
                                <tr>
					<td>0001 - Filé Mignon</td>
					<td class="right">22,00</td>
				</tr>
				<tr bgcolor="#BAB494">
					<td>0001 - Filé Mignon</td>
					<td class="right">22,00</td>
				</tr>
                                <tr>
					<td>0001 - Filé Mignon</td>
					<td class="right">22,00</td>
				</tr>
				<tr bgcolor="#BAB494">
					<td>0001 - Alcatra</td>
					<td class="right">22,00</td>
				</tr>
				<tr>
					<td>0001 - Contra Filé</td>
					<td class="right">22,00</td>
				</tr>
				<tr bgcolor="#BAB494">
					<td>0001 - Fraldinha</td>
					<td class="right">22,00</td>
				</tr>
				<tr>
					<td>0001 - Coxao Mole</td>
					<td class="right">22,00</td>
				</tr>
				<tr bgcolor="#BAB494">
					<td>0001 - Coxao Duro</td>
					<td class="right">22,00</td>
				</tr>
				<tr>
					<td>0001 - Coxao Duro</td>
					<td class="right">22,00</td>
				</tr>
			</table>
		</div>
	</div>
	<div id="rodape">
		<marquee direction="left">
		<p>Somente no D'Avó, voce encontra carnes com procedência garantida e melhores preços.</p>
		</marquee>
	</div>
  </body>
</html>