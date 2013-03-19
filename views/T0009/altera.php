<?php
//Chama classes
$cod    = $_GET['cod'];
$tabela = "T046_artigos";
//Classe para Alterar usuario
$objArt = new models_T0017();
$art    = $objArt->buscaT046($cod);
$T045    = $objArt->listaT045();

if(!is_null($_POST['T046_codigo']))
{
    $delim         =        "T046_codigo = ".$_POST['T046_codigo'];
    //print_r($_POST);
    $Altera        =        $objArt->alteraT046($tabela,$_POST,$delim);

    header('location:?router=T0017/home');
}


$user  = $_SESSION['user'];

?>

<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0017/home">Listar</a></li>
                <li><a href="?router=T0017/novo">Novo</a></li>
            </ul>
        </span>
    </div>
</div>
<div id="formulario">
    <span class="form-titulo">
        <p>Os campos com asterisco (*) são obrigatórios o preechimento</p>
    </span>
    <span class="form-input">
    <?php foreach($art as $campos=>$valores){
        
        $dt_inicial        = $valores['P0017_T046_DTI'];
        $val_ini           = explode(" ",$dt_inicial);
        $date_ini          = explode("-",$val_ini[0]);
        $dt_inicial_format = $date_ini[2]."/".$date_ini[1]."/".$date_ini[0];

        $dt_final          = $valores['P0017_T046_DTF'];
        $val_fim           = explode(" ",$dt_final);
        $date_fim          = explode("-",$val_fim[0]);
        $dt_final_format = $date_fim[2]."/".$date_fim[1]."/".$date_fim[0];        
    ?>
    <form action="" method="post" id="formCad">
        <table>
            <tr>
                <td><label class="label">Código*     </label></td>
            </tr>
            <tr>
                <td><input type="text" name="T046_codigo" id="cod" class="form-input-text-table" value="<?php echo $cod; ?>" READONLY/></td>
            </tr>
            <tr>
                <td><label class="label">Titulo*     </label></td>
                <td><label class="label">Categoria*    </label></td>
                <td><label class="label">Data Inicial* </label></td>
                <td><label class="label">Data Final*  </label></td>
            </tr>
            <tr>
                <td><input type="text" name="T046_titulo" id="titulo" class="validate[required] form-input-text-table" value="<?php echo ($valores['P0017_T046_TIT']); ?>" /></td>
                <td>
                    <select name="T045_codigo" id="categoria" class="validate[required] form-input-text-table">
                        <option value="">Selecione...</option>
                    <?php foreach($T045 as $campos=>$valores2){ ?>
                        <option value='<?php echo $valores2['P0017_T045_COD']; ?>'><?php echo ($valores2['P0017_T045_NOM']); ?></option>
                    <?php }?>
                    </select>
                </td>
                <td><input type="text" name="T046_data_inicial" id="dt_inicial" class="validate[required] form-input-text-table" value="<?php echo $dt_inicial_format; ?>" /></td>
                <td><input type="text" name="T046_data_final"   id="dt_final" class="validate[required] form-input-text-table"  value="<?php echo $dt_final_format; ?>" /></td>
            </tr>
            <tr>
                <td colspan="4"><label class="label">Chamada</label></td>
            </tr>
            <tr>
                <td colspan="4"><textarea name="T046_chamada" id="chamada" class="textarea-table" cols="" rows="" ><?php echo $valores['P0017_T046_CHA']; ?></textarea></td>
            </tr>
            <tr>
                <td colspan="4"><label class="label">Texto</label></td>
            </tr>
            <tr>
                <td colspan="4">
                    <textarea name="T046_texto" id="texto" class="textarea-table" cols="" rows="" ><?php echo $valores['P0017_T046_TEX']; ?></textarea>
                </td>
            </tr>
        </table>
        <div class="form-inpu-botoes">
            <input type="submit" value="Alterar" />
        </div>
    </form>
    <?php };?>
    </span>
</div>
