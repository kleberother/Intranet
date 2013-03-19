<?php
//Chama classes
$cod       = $_GET["cod"];
$tabela    = "T054_avisos";
//Classe para buscar loja
$objAvisos = new models_T0019();
$avi       = $objAvisos->buscaT054($cod);

$user  = $_SESSION['user'];

if(!is_null($_POST['T054_codigo']))
{
    $delim         =        "T054_codigo = ".$_POST['T054_codigo'];
    //print_r($_POST);
    $Altera        =        $objAvisos->altera($tabela,$_POST,$delim);

    header('location:?router=T0019/home');
}

?>
<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0019/home">Listar</a></li>
                <li><a href="?router=T0019/novo" class="active">Novo</a></li>
            </ul>
        </span>
    </div>
</div>
<div id="formulario">
    <span class="form-titulo">
        <p>Os campos com asterisco (*) são obrigatórios o preechimento</p>
    </span>
    <span class="form-input">
    <?php foreach($avi as $campos=>$valores){
        
        $dt_inicial    = $valores['P0019_T054_DTI'];
        $val_ini           = explode(" ",$dt_inicial);
        $date_ini          = explode("-",$val_ini[0]);
        $dt_inicial_format = $date_ini[2]."/".$date_ini[1]."/".$date_ini[0];

        $dt_final    = $valores['P0019_T054_DTF'];
        $val_fim           = explode(" ",$dt_final);
        $date_fim          = explode("-",$val_fim[0]);
        $dt_final_format = $date_fim[2]."/".$date_fim[1]."/".$date_fim[0];        
        
    ?>
    <form action="" method="post" id="formCad">
        <table>
            <tr>
                <td colspan="4"><label class="label">Código*</label></td>
            </tr>
            <tr>
                <td><input type="text" name="T054_codigo"  id="codigo"    class="form-input-text-table" value="<?php echo $valores['P0019_T054_COD']; ?>" READONLY/></td>
            </tr>  
            <tr>
                <td colspan="4"><label class="label">Texto*</label></td>
            </tr>
            <tr>
                <td colspan="4"><textarea name="T054_texto" id="texto" class="validate[required] textarea-table" cols="" rows="" ><?php echo $valores['P0019_T054_TEX']; ?></textarea></td>
            </tr>  
            <tr>
                <td><label class="label">Data Inicial*    </label></td>
                <td><label class="label">Hora Inicial*</label></td>
                <td><label class="label">Data Final*    </label></td>
                <td><label class="label">Hora Final*    </label></td>
            </tr>
            <tr>
                <td><input type="text" name="T054_dt_inicio"  id="dt_inicial"    class="validate[required] form-input-text-table" value="<?php echo $dt_inicial_format; ?>"         /></td>
                <td><input type="text" name="T054_hr_inicio"  id="hr_inicial"    class="validate[required] form-input-text-table" value="<?php echo $valores['P0019_T054_HOI']; ?>" /></td>
                <td><input type="text" name="T054_dt_fim"     id="dt_final"      class="validate[required] form-input-text-table" value="<?php echo $dt_final_format; ?>"           /></td>
                <td><input type="text" name="T054_hr_fim"     id="hr_final"      class="validate[required] form-input-text-table" value="<?php echo $valores['P0019_T054_HOF']; ?>" /></td>
            </tr>
        </table>
        <div class="form-inpu-botoes">
            <input type="submit" value="Alterar" />
        </div>
    </form>
    <?php } ?>
    </span>
</div>

