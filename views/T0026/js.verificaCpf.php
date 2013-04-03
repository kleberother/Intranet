<?php 
//Instancia Classe com Conexão Oracle
$obj                =   new models_T0026("ora");

$cpf                =   $obj->retiraMascara($_REQUEST['cpf']);

$dadosColaborador   =   $obj->verificaCpf($cpf);

//Retorna JSON para jQuery buscaCodRMS/buscaCnpjRMS em ARRAY
$i  =   0;
while ($row_ora = oci_fetch_assoc($dadosColaborador))
{
    $colaboradores  =   $row_ora;
    $i++;
}

if ($i==0)
    echo 0;
else
    echo json_encode($colaboradores);

?>