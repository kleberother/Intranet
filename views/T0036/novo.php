<?php
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 16/09/2011 por Jorge Nova                              
 * Descrição: Arquivo cria novos templates
 * Entrada:   
 * Origens:   
           
**************************************************************************
*/


// GRAVA SESSÃO DE UM USUÁRIO EM UMA VARIAVEL
$user    = $_SESSION['user'];

// INSTANCIA OBJETO DA CLASSE T0036
$obj     = new models_T0036();

// GRAVA O NOME DA TABELA NA QUAL DEVERÁ SER INSERIDA OS DADOS
$tabela  = "T076_template";



if (!is_null($_POST['T076_nome']))
{
    $insert     =   $obj->inserir($tabela,$_POST);    
    header('location:?router=T0036/home');
}


?>

<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0036/home">Listar</a></li>
                <li><a href="?router=T0036/novo" class="active">Novo</a></li>
            </ul>
        </span>
    </div>
</div>
<div id="formulario">
    <span class="form-titulo">
        <p>Os campos com asterisco (*) são obrigatórios o preechimento</p>
    </span>
    <span class="form-input">
    <form action="" method="post" id="formCad">
        <label class="label">Nome*</label>
        <input type="text" name="T076_nome" id="nome" class="validate[required] form-input-text" />
        <label class="label">Descrição</label>
        <textarea name="T076_desc" id="desc"></textarea>
        <div class="form-inpu-botoes">
            <input type="submit" value="Criar" />
        </div>
    </form>
    </span>
</div>

<?php
/* -------- Controle de versões - T0036.php --------------
 * 1.0.0 - 16/09/2011 - Jorge --> Liberada versao inicial
 *                                
 */
?>