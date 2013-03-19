<?php
//Entradas
$usuario            =   $_REQUEST['usuario'];
$senha              =   $_REQUEST['senha']  ;
$action             =   $_REQUEST['action'] ;
$evento             =   $_REQUEST['evento'] ;

//System Date (data hoje) 
$dia                =   date(d);
$mes                =   date(m);
$ano                =   date(Y);

//Parametro (FAZER VERIFICAÇÃO DA TABELA DE PARAMETRO)
$parametro  =   120;        //parametro de 120 dias

//Data Juliana System Date
$dtJdHoje           =   gregoriantojd($mes, $dia, $ano);

//Instancia Classe
$obj                =   new models_home();

//Classe para Autenticação
$autentica          =   new models();
 
if ($evento==1) 
{    
    //Faz atutenticação ou logout
    $autentica->autentica();   
    
    //Verifica última atualização dos dados de usuário
    $dadosUsuario       =   $obj->retornaUsuario($usuario);
   
    $dataUltAlteracao   =   0;
    foreach ($dadosUsuario  as $campos=>$valores)
    {
        $UsuarioDataUltAlteracao    =   $valores['UsuarioDataUltAlteracao'];
        $dados = $valores;
    }
    
    if (!empty($UsuarioDataUltAlteracao)) 
    {
        $UsuarioDataUltAlteracao    =   explode(" ",$UsuarioDataUltAlteracao)   ;
        $dataUsuario                =   explode("-",$UsuarioDataUltAlteracao[0]);
        $ano                        =   $dataUsuario[0]                         ;
        $mes                        =   $dataUsuario[1]                         ;
        $dia                        =   $dataUsuario[2]                         ;
        $dtJdUsuario                =   gregoriantojd($mes, $dia, $ano)         ;
        $data                       =   $dtJdHoje - $dtJdUsuario;
    }
    else
        $data                   =   $parametro;
    
    //Verifica se usuario existe
    if ($data>=$parametro) 
    {        
        echo json_encode($dados);
    }
    else
        echo "0"; //retorno js para usuario com dados atualizados
}
else if($evento==2)
{
    $Lojas = $obj->retornaLojas();
    $i  =   0;
    foreach($Lojas as $campos=>$valores)
    {
        $dados[$i]  = $valores  ;
        $i++;
    }

echo json_encode($dados);
      
}else if($evento==3)
{
    $nome           =   $_REQUEST['nome']           ;
    $matricula      =   $_REQUEST['matricula']      ;
    $funcao         =   $_REQUEST['funcao']         ;
    $departamento   =   $_REQUEST['departamento']   ;
    $ramal          =   $_REQUEST['ramal']          ;
    $celular        =   $_REQUEST['celular']        ;
    $loja           =   $_REQUEST['loja']           ;
    $login          =   $_SESSION['user']           ;
    $tabela         =   "T004_usuario"              ;
    $data           =   date('d/m/Y H:i:s')         ;
    
    $dadosUsuario   =   array("T004_nome"               => $nome
                             ,"T004_matricula"          => $matricula
                             ,"T004_funcao"             => $funcao
                             ,"T004_departamento"       => $departamento
                             ,"T004_ramal"              => $ramal
                             ,"T004_celular"            => $celular
                             ,"T006_codigo"             => $loja
                             ,"T004_data_ult_alteracao" => $data);
    
    $delim  =   " T004_login  =   '$login'";
    
    $obj->altera($tabela, $dadosUsuario, $delim);
    
}
?>