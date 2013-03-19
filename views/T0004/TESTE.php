<?php

$conn = "mssql";
$db   = "DBO_CRE";

$obj = new models_T0004($conn,$db);

$result = $obj->retornaDadosMSSQL();    

print_r($result);
while( $row = mssql_fetch_array($result))
{
    //print_r($row);
    echo $row['abc']."<br>";
}


?>
