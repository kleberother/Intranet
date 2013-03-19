<?php

$user = $_SESSION["user"];

    $conn             =   "mssql";
    $verificaConexao    =   "";
    $db                 =   "DBO_CRE";
    $objMSSQL = new models_T0111($conn,$verificaConexao,$db);

    
    $conn = "";
    $obj = new models_T0111();

    $cpf = $obj->retiraMascara($_GET['campocpf']);
    
    $retornaNCartão = $objMSSQL->retornaNcartao($cpf);
    
    $rows = mssql_fetch_array($retornaNCartão);
    
  echo $rows["NUM_CARTAO"];  
    

?>
