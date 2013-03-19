<?php
echo "NOME DO ARQUIVO<BR/>";
echo $str = 'T.E.S.T.E.txt';
echo "<br/>";
echo "<br/>";
echo "ARRAY<br/>";
$arquivo = explode('.', $str);
print_r($arquivo);
echo "<br/>";
echo "<br/>";
echo "ULTIMA POSIÇÃO<br/>";
$narquivo = array_pop($arquivo);
echo $narquivo;
echo "<br/>";
echo "<br/>";
echo "ARRAY NOVO<br/>";
print_r($arquivo);
echo "<br/>";
echo "<br/>";
echo "POSIÇÕES DO ARRAY<br/>";
echo $posicao = count($arquivo);

$i = 0;
foreach($posicao as $campos=>$valores)
{
 
}
?>
