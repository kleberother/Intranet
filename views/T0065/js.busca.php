<?php
//Instancia Classe

$obj    =   new models_T0065();


//busca valor digitado no campo autocomplete "$_GET['term']
$nome = mysql_real_escape_string($_GET['term']);

$Usuarios = $obj->retornaUsuarios($nome);

$json  = '[';
$first = true;

foreach($Usuarios as $campos=>$valores){
  
  if ($valores['Funcao'] == "")
      $valores['Funcao'] = 'Cargo não informado';
  
  if (!$first) { $json .=  ','; } else { $first = false; }
  $json .= '{"value":"'.$valores['Nome']." - ".$valores['Funcao']." - ".$valores['Login'].'"}';    
}

$json .= ']';

echo $json;

?>
