<?php
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 16/09/2011 por Jorge Nova                              
 * Descrição: Arquivo altera templates já cadastrados
 * Entrada:   $codigo -> codigo do template
 * Origens:   T0036/home
           
**************************************************************************
*/


// GRAVA SESSÃO DE UM USUÁRIO EM UMA VARIAVEL
$user     = $_SESSION['user'];

// INSTANCIA OBJETO DA CLASSE T0036
$obj      = new models_T0036();

// RECUPERA O CODIGO DO TEMPLATE
$codigo   = $_REQUEST['codigo']; 

// RETORNA O TEMPLATE NO QUAL DESEJA-SE FAZER A ALTERAÇÃO
$template = $obj->retornaUnicoTemplate($codigo);

// GRAVA O NOME DA TABELA NA QUAL DEVERÁ SER INSERIDA OS DADOS
$tabela   = "T076_template";

if(!is_null($_POST['T076_codigo']))
{
    $delim         =        "T076_codigo = ".$_POST['T076_codigo'];

    $altera        =        $obj->alterar($tabela,$_POST,$delim);
    //print_r($_POST);
    header('location:?router=T0036/home');
}

?>

<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0036/home">Listar</a></li>
            </ul>
        </span>
    </div>
</div>
<div id="formulario">
    <?php foreach($template as $campos=>$valores){?>
    <span class="form-titulo">
        <p>Os campos com asterisco (*) são obrigatórios o preechimento</p>
    </span>
    <span class="form-input">
    <form action="" method="post" id="formCad">
        <label class="label">Código*</label>
        <input type="text" name="T076_codigo"     id="codigo"       value="<?php echo ($valores['Codigo']);?>"  class="form-input-text" READONLY/>
        <label class="label">Nome*</label>
        <input type="text" name="T076_nome"       id="nome"         value="<?php echo ($valores['Nome']);?>"  class="validate[required] form-input-text" />
        <label class="label">Descrição</label>
        <textarea          name="T076_desc"       id="desc"         ><?php echo ($valores['Descricao']);?></textarea>
        <div class="form-inpu-botoes">
            <input type="submit" value="Alterar" />
        </div>
    </form>
    </span>
<?php } ?>
</div>

<?php
/* -------- Controle de versões - T0036.php --------------
 * 1.0.0 - 16/09/2011 - Jorge --> Liberada versao inicial
 *                                
 */
?>