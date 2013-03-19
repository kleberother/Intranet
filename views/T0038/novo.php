<?php
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 16/09/2011 por Jorge Nova                              
 * Descrição: Arquivo cria novas áreas para templates já cadastrados
 * Entrada:   
 * Origens:   
           
**************************************************************************
*/


// GRAVA SESSÃO DE UM USUÁRIO EM UMA VARIAVEL
$user      = $_SESSION['user'];

// INSTANCIA OBJETO DA CLASSE
$obj       = new models_T0038();

// GRAVA O NOME DA TABELA NA QUAL DEVERÁ SER INSERIDA OS DADOS
$tabela    = "T080_areas_template";

// RETORNA DADOS PARA PREENCHER SELECT BOX DE TEMPLATES
$templates   = $obj->retornaTemplates();


if (!is_null($_POST['T076_codigo']))
{   
    $ProximaArea = $obj->retornaProximaArea($_POST['T076_codigo']);
    foreach ($ProximaArea as $campos=>$valores)
    {
        $CamposInsert = array ("T076_codigo"    => $_POST['T076_codigo']
                              ,"T080_nome"      => $_POST['T080_nome']   
                              ,"T080_desc"      => $_POST['T080_desc']
                              ,"T080_codigo"    => $valores['ProximaArea']
                              );
     }
    // recupera dados do POST para fazer Array do Insert
   
    
    $insert      =   $obj->inserir($tabela,$CamposInsert);    
    header('location:?router=T0038/home');
}


?>

<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0038/home">Listar</a></li>
                <li><a href="?router=T0038/novo" class="active">Novo</a></li>
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
        <label class="label">Template*</label>
        <select name="T076_codigo" class="validate[required]" id="template">
            <option value="">...</option>
            <?php
            foreach($templates as $campos=>$valores)
            {
            ?>
            <option value="<?php echo $valores['Codigo']; ?>"><?php echo $valores['Nome']; ?></option>
            <?php
            }
            ?>
        </select>
        <label class="label">Nome*</label>
        <input type="text" name="T080_nome" id="nome" class="validate[required] form-input-text" maxlenght="45"/>        
        <label class="label">Descrição</label>
        <textarea          name="T080_desc" id="desc" rows="" cols="" class="validate[required]"></textarea>
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