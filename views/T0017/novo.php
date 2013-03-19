<?php
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 05/12/2011 por Jorge Nova                              
 * Descrição: Criar novo artigo para intranet
 * Entrada:   
 * Origens:   
           
**************************************************************************
 */

// Captura session e poe na variavel User
$user  = $_SESSION['user'];

// Objeto de conexão 
$obj   = new models_T0017();

if (!empty($_POST))
{
    
    // Tabela para inserir noticias
    $tabela = "T046_artigos";
    
    // Seta os valores para insert que não são informados no Formulário
    $_POST['T004_login']           = $user;                                     // Publicador da Notícia
    $_POST['T045_codigo']          = 1;                                         // Tipo da Notícia
    $_POST['T046_data_publicacao'] = date('d/m/Y');                             // Data de Publicação
    $_POST['T046_chamada']         = trim(substr($_POST['T046_texto'],0,100));  // Chamada da Notícia
    $_POST['T046_texto']           = trim($_POST['T046_texto']);                // Retira os espaços
    
    $inserir = $obj->inserir($tabela, $_POST);

    header("location: ?router=T0017/home");
    
}


?>
<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0017/home">Listar</a></li>
                <li><a href="?router=T0017/novo" class="active">Novo</a></li>
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
        <table>
            <tr>
                <td colspan="2"><label class="label">Titulo*</label></td>
            </tr>
            <tr>
                <td colspan="2"><input type="text" name="T046_titulo" id="titulo" class="validate[required]" size="150" /></td>
            </tr>
            <tr>
                <td><label class="label">Data Inicial*    </label></td>
                <td><label class="label">Data Final*    </label></td>
            </tr>
            <tr>
                <td><input type="text" name="T046_data_inicial"   class="validate[required] dt_inicial" size="7" /></td>
                <td><input type="text" name="T046_data_final"     class="validate[required] dt_final"   size="7" /></td>
            </tr>            
            <tr>
                <td colspan="2"><label class="label">Texto*</label></td>
            </tr>
            <tr>
                <td colspan="2"><textarea name="T046_texto" id="texto" class="validate[required] textarea-table" cols="" rows="" ></textarea></td>
            </tr>  
        </table>
        <div class="form-inpu-botoes">
            <input type="submit" value="Criar" />
        </div>
    </form>
    </span>
</div>

