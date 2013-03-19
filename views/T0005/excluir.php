<?php
// Objeto de conexão com a models da T005
$obj           =    new models_T0005();

// Captura dados do URL
$pagina        =    $_GET["pagina"];    // Página na qual deverá voltar no redirect
$tabela        =    $_GET["tabela"];    // Tabela usada para o evento
$campo         =    $_GET['campo'];     // Campo parametro do WHERE 01
$valor         =    $_GET["valor"];     // Valor 01
$campo2        =    $_GET['campo2'];    // Campo parametro do WHERE 02
$valor2        =    $_GET["valor2"];    // Valor 02
$tipo          =    $_GET["tipo"];      // Tipo do Exclusão
                                        // para ser usada com mais de 2 parametros
$nome          =    $_GET['nome'];      // Nome 

// Mostra o conteúdo das variaveis
//echo $pagina;
//echo "<br/>";
//echo $tabela;
//echo "<br/>";
//echo $campo;
//echo "<br/>";
//echo $valor;
//echo "<br/>";
//echo $campo2;
//echo "<br/>";
//echo $valor2;
//echo "<br/>";
//echo $tipo;
//echo "<br/>";
//echo $nome;

// Verifica o Tipo da Exclusão, onde Tipo 1 = Excluir Perfil e Tipo 2 = Excluir usuário de perfil
if ($tipo == 1)
{
    
    // Retorna quantidade de usuários associados ao perfil
    $Usuarios = $obj->retornaQtdeUsuarios($valor);
    
    foreach($Usuarios as $campos=>$valores)
    {
        $ContadorUsuarios = $valores['ContadorUsuarios'];
    }
    
    // Retorna quantidade de menus associados ao perfil
    $Menus = $obj->retornaQtdeMenus($valor);
    
    foreach($Menus as $campos=>$valores)
    {
        $ContadorMenus = $valores['ContadorMenus'];
    }
    
    // Verifica se o contador de usuários é maior que 0
    if ($ContadorUsuarios == 0)
    {
        if ($ContadorMenus == 0)
        {           
            // Formata o delimitador
            $delim  = $campo." = ".$valor;
    
            // Objeto para excluir item
            $Excluir  =   $obj->excluir($tabela, $delim);    

            // Verifica se os dados foram excluidos com sucessoif ($Excluir)
                if ($Excluir)
                {
                    header('location:?router='.$pagina);
                }
                else
                { // Erro ao inserir na tabela T009_perfil
                    echo "<script>alert('ERRO AO EXCLUIR');</script>";                 
                    echo "<script>window.location='?router=$pagina';</script>";    
                }      
        }
        else
        { // Existem menus associados a esse perfil
            echo "<script>alert('Não pode ser excluido, pois este perfil esta associado a alguns menus/programas.');</script>";                 
            echo "<script>window.location='?router=$pagina';</script>";                  
        }
    }
    else
    { // Existem usuários associados a esse perfil
        echo "<script>alert('Não pode ser excluido, pois existem usuários associados a esse perfil.');</script>";                 
        echo "<script>window.location='?router=$pagina';</script>";            
    }
}
else if ($tipo == 2)
{
    // Formata o delimitador
    $delim  = $campo." = '".$valor."' AND ".$campo2." = ".$valor2;
           
    // Objeto para excluir item
    $Excluir  =   $obj->excluir($tabela, $delim);    

    // Verifica se os dados foram excluidos com sucessoif ($Excluir)
        if ($Excluir)
        {
            header('location:?router='.$pagina.'&cod='.$valor2.'&nom='.$nome);
        }
        else
        { // Erro ao inserir na tabela T009_perfil
            echo "<script>alert('ERRO AO EXCLUIR');</script>";                 
            echo "<script>window.location='?router=$pagina&cod=$valor2&nom=$nome';</script>";    
        }           
}
?>