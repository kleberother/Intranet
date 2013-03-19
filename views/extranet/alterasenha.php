<?php

$obj            =   new models_extranet()           ;
$tabela         =   "T004_usuario"                  ;
$usuario        =   $_SESSION['user']               ;
$senha          =   md5($_POST['senha'])            ;
$confirmaSenha  =   md5($_POST['confirmaSenha'])    ;

if (!empty($_POST))
{
    if ($senha  ==  $confirmaSenha)
    {
        $campos =   array ( "T004_senha" => $confirmaSenha );
        $delim  =   "T004_login = '$usuario'";

        $altera =   $obj->altera($tabela, $campos, $delim);

        if($altera)
        {
            header('location:?router=extranet/home');
        }
        else
            echo "<script>alert('Erro ao alterar a Senha!');</script>";
    }
    else
    {
        echo "<script>
                $(function(){
                    alert('Senha inválida, redigite!');
                    $('#senha').val()           =   ''  ;
                    $('#senha').focus           =   ''  ;
                    $('#confirmaSenha').val()   =   ''  ;
                    
                })
              </script>";
    }
}
?>
<div class="padding-padrao-vertical">

    <div class="margim-padrao-horizontal">
        
        <form action="" method="post" id="formSenha">
            
            <div class="div-input">
                <label>Senha: </label>
                <input type="password" name="senha" id="senha"/>
            </div>
            <div class="div-input">
                <label>Confirmar a Senha: </label>
                <input type="password" name="confirmaSenha" id="confirmaSenha"/>
            </div>
            <div class="div-input">
                <input type="submit" value="Salvar" class="botao-padrao" />
            </div>
                      
        </form>
        
    </div>

</div>
