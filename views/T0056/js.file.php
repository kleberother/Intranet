<?php
//captura nome do arquivo
$arquivo     = $_GET['ArquivoCodigo'];
//captura categoria do arquivo
$categoria   = $_GET['categoria'];
//captura nome da extensão
$extensao    = $_GET['extensao'];

//formata o path do caminho atual do arquivo
$path     = "files/CAT".$categoria."/".$arquivo;
//formata o path do caminho temporário para fazer o download
$path_tmp = "files/tmp"."/".$arquivo;
//formata o path para renomear o arquivo movido ao temporário   
$path_tmp_rename = "files/tmp"."/".$arquivo.".".$extensao;

//Inicia a manipulação do arquivo
if (copy($path, $path_tmp))
   { //Copia o arquivo original para o diretório temporário
    echo "ARQUIVO COPIADO!";
    echo "<br/>";      
    if (rename($path_tmp, $path_tmp_rename))
       { //Renomeia o arquivo temporário
        echo "ARQUIVO RENOMEADO";
        echo "<br/>";
        //abre o arquivo
        header("location:$path_tmp_rename");
       }
    else
       {
        echo "ARQUIVO NÃO RENOMEADO";
        echo "<br/>";           
       }
   }
else
   {
    echo "NÃO COPIOU"; 
   }
?>
