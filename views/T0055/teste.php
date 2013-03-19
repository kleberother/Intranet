<?php


$conn               =   "";
$obj = new models_T0055($conn);

$MetaMes = $obj->retornaMeta($mes_dataini);

   
   
while($row = mysql_fetch_array($MetaMes)){
    
    
    
    $meta = $row['T082_meta'];
    $lojaMeta = $row['T082_loja'];
    
    
  echo $meta."<br>";  
    
}

?>
