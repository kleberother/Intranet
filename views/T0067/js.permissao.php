<?php
// Instancia objeto de conexão com a models
$obj        =   new models_T0067();

// captura valor do array passado pelo jquery, infomando todos os IDs dos arquivos
$valores        =   explode(",",$_POST['T055_codigo']);


// Contador de quantas inserções vão ocorrer de arquivos para o loop 
$contador       =   count($valores);

// Contador de quantos usuários possuem no array
$contadorLogin  =   count($_POST['T004_login']);

// Insere tabela de permissões 
$tabela         =   "T004_T055";

// Executa o for para cada arquivo checado
for ($i = 0; $i < $contador; $i++)
{ 
    // Executa novo FOR para cada usuário selecionado
    for ($ii = 0; $ii < $contadorLogin; $ii++ )
    {
        // formata a string de login de Nome - Login, e deixa só o Login
        $login = $obj->formataLoginAutoComplete($_POST['T004_login'][$ii]);

        // Formata array para inserção de dados
        $array  =   array(  "T055_codigo"           =>  $valores[$i]
                          , "T004_login"            =>  $login
                          , "T004_T055_visualizar"  =>  '1'
                          , "T004_T055_alterar"     =>  '0'
                          , "T004_T055_excluir"     =>  '0'      );

        // Executa o comando de inserção de dados na tabela
        $insere = $obj->inserir($tabela, $array);
        
        // Verifica se inseriu ou não.
        if ($insere)
            $retorno = "1";
        else
            $retorno = "0";
        
    }
}

// Veririca o retorno e envia as mensagens de erro caso houver erro
$retorno;
if ($retorno == 1)
    {
        echo "<script>window.location = '?router=T0067/home';</script>";   
    }
else
    {
        echo "<script>alert('Não conseguiu cadastrar permissão');</script>";
        echo "<script>window.location = '?router=T0067/home';</script>";   
    }



?>