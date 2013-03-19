<?php
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 16/09/2011 por Jorge Nova                              
 * Descrição: Arquivo altera templates já cadastrados
 * Entrada:   $codigo -> codigo da area
 * Origens:   T0038/home
           
**************************************************************************
*/


// GRAVA SESSÃO DE UM USUÁRIO EM UMA VARIAVEL
$user     = $_SESSION['user'];

// INSTANCIA OBJETO DA CLASSE
$obj      = new models_T0038();

// RECUPERA O CODIGO DO TEMPLATE
$codigo   = $_REQUEST['codigo']; 

// RETORNA O TEMPLATE NO QUAL DESEJA-SE FAZER A ALTERAÇÃO
$AreaTemp = $obj->retornaUnicaArea($codigo);

// RETORNA DADOS PARA PREENCHER SELECT BOX DE TEMPLATES
$templates = $obj->retornaTemplates();

// GRAVA O NOME DA TABELA NA QUAL DEVERÁ SER INSERIDA OS DADOS
$tabela   = "T080_areas_template";

if(!is_null($_POST['T076_codigo']))
{
    $delim         =        "T080_codigo = ".$codigo;

    $altera        =        $obj->alterar($tabela,$_POST,$delim);

    header('location:?router=T0038/home');
}

?>

<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0038/home">Listar</a></li>
            </ul>
        </span>
    </div>
</div>
<div id="formulario">
    <?php foreach($AreaTemp as $campos=>$valores){?>
    
    <span class="form-titulo">
        <p>Os campos com asterisco (*) são obrigatórios o preechimento</p>
    </span>
    <span class="form-input">
    <form action="" method="post" id="formCad">
        <label class="label">Template*</label>
        <select name="T076_codigo" class="validate[required]" id="template">
            <option value="">...</option>
            <?php
            foreach($templates as $campos2=>$valores2)
            {
            ?>
            <option value="<?php echo $valores2['Codigo']; ?>" <?php if ($valores['CodigoTemplate'] == $valores2['Codigo']) echo "selected"; ?>><?php echo $valores2['Nome']; ?></option>
            <?php
            }
            ?>
        </select>
        <label class="label">Nome*</label>
        <input type="text" name="T080_nome" id="nome" value="<?php echo $valores['NomeArea']; ?>" class="validate[required] form-input-text" maxlenght="45"/>
        <label class="label">Descrição</label>
        <textarea          name="T080_desc" id="desc" rows="" cols="" class="validate[required]"><?php echo $valores['DescricaoArea'];?></textarea>        
        <div class="form-inpu-botoes">
            <input type="submit" value="Salvar" />
        </div>
    </form>
    </span>
<?php } ?>
</div>

<?php
/* -------- Controle de versões - altera.php --------------
 * 1.0.0 - 16/09/2011 - Jorge --> Liberada versao inicial
 *                                
 */
?>