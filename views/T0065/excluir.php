<?php
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 21/11/2011 por Jorge Nova                              
 * Descrição: Excluir departamento a loja - pendente não esta funcionando
 * Entrada:   
 * Origens:   
           
**************************************************************************
 */

// Captura dados do URL

$pagina        =    $_GET["pagina"];    // Página na qual deverá voltar no redirect
$loja          =    $_GET["valor2"];    // Loja para executar no AND
$login         =    $_GET["valor"];     // Login do usuário que deverá ser excluido
$tabela        =    $_GET["tabela"];    // Tabela usada para o evento
$departamento  =    $_GET["tipo"];      // Esta sendo usado o Tipo como Departamento, pois a função não esta
                                        // para ser usada com mais de 2 parametros
$campo         =    $_GET['campo'];     // Campo parametro do WHERE T004_login
$campo2        =    $_GET['campo2'];    // Campo parametro do WHERE T006_loja
$nome          =    $_GET['nome'];      // Nome do Departamento
// Delimitador para exclusão
$delim         =    $campo." = '".$login."' AND ".$campo2." = ".$loja." AND T077_codigo = ".$departamento;
 
// Classe para conexão com as Models da T0065
$obj           =    new models_T0065();

// Objeto para excluir item
$Excluir  =   $obj->excluir($tabela, $delim);


// Verifica se os dados foram excluidos com sucessoif ($Excluir)
if ($Excluir)
{
    header('location:?router='.$pagina."&codigo=".$departamento."&nome=".$nome."&loja=".$loja);
}
else
{ // Erro ao inserir na tabela T004_T006_T0077
    echo "<script>alert('ERRO AO EXCLUIR');</script>";                 
    echo "<script>window.location='?router=$pagina&codigo=$departamento&nome=$nome&loja=$loja';</script>";    
}



?>