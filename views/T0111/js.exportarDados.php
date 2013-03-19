<?php
//$conn = "";
$obj  = new models_T0111();

 set_time_limit(0);

$data = $_POST['data'];
$data =  substr($data,6,4)."-".substr($data,3,2)."-".substr($data,0,2);
$categoriaArquivo   =   21;

$dataDown = $data;

$arquivoNome = 'AjustesEMS'.$dataDown.".txt";

$arquivoLocal = CAMINHO_ARQUIVOS."CAT0021/".$arquivoNome;

if (file_exists($arquivoLocal)){
  
    
header("Content-Type: application/save"); 
header("Content-Length:".filesize($arquivoLocal)); 
header('Content-Disposition: attachment; filename="' . $arquivoLocal . '"'); 
header("Content-Transfer-Encoding: binary");
header('Expires: 0'); 
header('Pragma: no-cache'); 
    

//Envia o arquivo para o usuário
$fp = fopen("$arquivoLocal", "r");
fpassthru($fp);
fclose($fp);

exit; 
    
} else {

$arquivo = fopen($arquivoLocal,"w+");
$sql = $obj->retornaTxtAjustes($data);

foreach($sql as $key=>$value)
{
    $dados  =   "INSERT INTO AJUSTES-EMS VALUES(";
    $dados  .= "'".$value["CodLoja"]."','".$value["DataOper"]."','".$value["TipoOper"]."','".$value["Conta"]."','".$value["ValorTotal"]."','".$value["CPF"]."','".$value["ValorVista"]."','".$value["QtdParc"]."','".$value["ValorParc"]."','".$value["Cupom"]."','".$value["Pdv"]."','".$value["Elaborador"]."','".$value["Motivo"]."','".$value["Status"]."','".$value["Contratado"]."'" ;
    $dados  .= ");\n";
    
  
    fwrite($arquivo, "$dados");
    
    echo $dados;
}
fclose($arquivo);



header("Content-Type: application/save"); 
header("Content-Length:".filesize($arquivoLocal)); 
header('Content-Disposition: attachment; filename="' . $arquivoLocal . '"'); 
header("Content-Transfer-Encoding: binary");
header('Expires: 0'); 
header('Pragma: no-cache'); 
    


//Envia o arquivo para o usuário
$fp = fopen("$arquivoLocal", "r");
fpassthru($fp);
fclose($fp);
//readfile($arquivoNome);

exit; 
}
    
    








?>
    