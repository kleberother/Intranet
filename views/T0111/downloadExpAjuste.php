<?php

/*Autor: Roberta Schimidt 
 * Data : 21/09/2012
 * Titulo: Download Exportação de Ajustes. 
 */

set_time_limit(0);

$data = $_POST['data'];

$arquivoNome = 'AjustesEMS'.$data;

$arquivoLocal = CAMINHO_ARQUIVOS."CAT0021/";

if (!file_exists($arquivoLocal)){
    
    echo "Arquivo não existe!!";
    
    exit;
}

// definir o novo nome do arquivo
$novoNome = "AjustesEMS".$data;


// Configuração dos Headers que serão enviados para o browser
header('Content-Description: File Transfer');
header('Content-Disposition: attachment; filename="'.$novoNome.'"');
header('Content-Type: application/octet-stream');
header('Content-Transfer-Encoding: binary');
header('Content-Length: ' . filesize($aquivoNome));
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');
header('Expires: 0');

//Envia o arquivo para o usuário
readfile($aquivoNome);


?>
