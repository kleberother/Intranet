<script src='template/js/interno/T0034/mensagens.js'></script>
<script src='template/js/interno/T0034/classificacao.js'></script>
<?php
//Inputs
$cod        =       $_GET['cod'];

//Instancia Classe
$obj        =       new models_T0034();

//Retorna Lojas
$Lojas          =   $obj->listaLojas();
//Retorna temas
$Temas          =   $obj->retornaTemas();
//Retorna Deptos
$Deptos         =   $obj->retornaDeptos();
//Retorna Painel
$Painel     =       $obj->retornaPaineis($cod);

//Tabela 
$tabela     =       "T078_painel";


if(!empty($_POST))
{
    $delim         =        "T078_codigo = ".$cod;
    $Altera        =        $obj->alterar($tabela,$_POST,$delim,$cod);
    
    header("location:?router=T0034/home");
}

?>
<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0034/home"                >Painéis</a></li>
                <li><a href="?router=T0034/novo"                >Novo   </a></li>
            </ul>
        </span>
    </div>
</div>
<div id="formulario">
    <?php foreach($Painel as $campos => $valores){?>
    <span class="form-titulo">
        <p>Painel:  <?php echo $obj->preencheZero("E", 3, $valores['Codigo'])." - ".$valores['Descricao']?></p>
    </span>    
    <span class="form-titulo">
        <p>Os campos com asterisco (*) são obrigatórios o preechimento</p>
    </span>
    <span class="form-input">
    <form action="" method="post" id="formCad">
        <label class="label">Cabeçalho*</label>
            <input type="text" name="T078_titulo" id="Cabecalho" class="validate[required]" value="<?php echo $valores['Cabecalho']?>"/>
        <label class="label">Rodapé</label>
            <input type="text" name="T078_rodape" id="Rodape" value="<?php echo $valores['Rodape']?>"/>
        <label class="label">Descrição*</label>
            <textarea          name="T078_descricao" id="desc" rows="" cols="" class="validate[required]"><?php echo $valores['Descricao'];?></textarea>
        <label class="label">Produtos Própria Seção*</label>
            <div id="radio">
                <?php if($valores['SecaoPropria']==0){?>
                    <input type="radio" id="radio2" name="T078_secao_propria" value="1"         /><label for="radio2">Sim</label>
                    <input type="radio" id="radio1" name="T078_secao_propria" value="0" checked /><label for="radio1">Não</label>                
                <?php }else if($valores['SecaoPropria']==1){?>
                    <input type="radio" id="radio2" name="T078_secao_propria" value="1" checked /><label for="radio2">Sim</label>
                    <input type="radio" id="radio1" name="T078_secao_propria" value="0"         /><label for="radio1">Não</label>                
                <?php }else{?>
                    <input type="radio" id="radio2" name="T078_secao_propria" value="1"          /><label for="radio2">Sim</label>
                    <input type="radio" id="radio1" name="T078_secao_propria" value="0"         /><label for="radio1">Não</label>                                    
                <?php } ?>    
            </div>
        <label class="label">Loja*</label>
            <select name="T006_codigo" id="loja" class="validate[required] form-input-text-table">
            <?php foreach($Lojas as $camposl=>$valoresl){ 
                if ($valores['Loja']==$valoresl['Codigo']){?>
                <option value='<?php echo $valoresl['Codigo']; ?>' selected><?php echo $obj->preencheZero("E", 3, $valoresl['Codigo']); ?> - <?php echo ($valoresl['Nome']); ?></option>
            <?php }else{?>
                <option value='<?php echo $valoresl['Codigo']; ?>'><?php echo $obj->preencheZero("E", 3, $valoresl['Codigo']); ?> - <?php echo ($valoresl['Nome']); ?></option>
            <?php }}?>
            </select>        
        <label class="label">Tema*</label>
            <select name="T076_codigo" id="loja" class="validate[required] form-input-text-table">
            <?php foreach($Temas as $campost=>$valorest){            
                if ($valores['TemaCodigo']==$valorest['Codigo']){?>
                <option value='<?php echo $valorest['Codigo']; ?>' selected><?php echo $obj->preencheZero("E", 3, $valorest['Codigo']); ?> - <?php echo ($valorest['Nome']); ?></option>
                <?php }else{?>
                <option value='<?php echo $valorest['Codigo']; ?>'><?php echo $obj->preencheZero("E", 3, $valorest['Codigo']); ?> - <?php echo ($valorest['Nome']); ?></option>
            <?php }}?>
            </select>         
        <label class="label">Departamento</label>   
            <select name="T020_departamento" id="ProdutoDepartamento" class="form-input-text-table">
            <?php if(empty($valores['DeptoCodigo'])){?>                    
                <option value="null"></option>
            <?php }?>
            <?php foreach($Deptos as $camposd=>$valoresd){
                if ($valores['DeptoCodigo']==$valoresd['Depto']){?>
                <option value='<?php echo $valoresd['Depto']; ?>' selected><?php echo $obj->preencheZero("E", 3, $valoresd['Depto']); ?> - <?php echo ($valoresd['Descricao']); ?></option>
                <?php }else{?>
                <option value='<?php echo $valoresd['Depto']; ?>' ><?php echo $obj->preencheZero("E", 3, $valoresd['Depto']); ?> - <?php echo ($valoresd['Descricao']); ?></option>                                    
            <?php }}?>
            </select>      
        <label class="label">Seção</label>   
            <select name="T020_secao" id="ProdutoSecao" class="form-input-text-table">
            <?php if(empty($valores['SecaoCodigo'])){?>                    
                <option value="null"></option>
            <?php }$Secoes = $obj->retornaSecoes($valores['DeptoCodigo']);?>
            <?php foreach($Secoes as $cpSecao=>$vlSecao){
                if ($valores['SecaoCodigo']==$vlSecao['Codigo']){?>
                <option value='<?php echo $vlSecao['Codigo']; ?>' selected><?php echo $obj->preencheZero("E", 3, $vlSecao['Codigo']); ?> - <?php echo ($vlSecao['Descricao']); ?></option>
                <?php $Sec = $vlSecao['Codigo'];}else{?>
                <option value='<?php echo $vlSecao['Codigo']; ?>' ><?php echo $obj->preencheZero("E", 3, $vlSecao['Codigo']); ?> - <?php echo ($vlSecao['Descricao']); ?></option>                                    
            <?php }}?>
            </select>  
        <label class="label">Grupo</label>   
            <select name="T020_grupo" id="ProdutoGrupo" class="form-input-text-table">
            <?php if(empty($valores['GrupoCodigo'])){?>                    
                <option value="null"></option>
            <?php }$Grupos = $obj->retornaGrupos($valores['DeptoCodigo'],$Sec);?>
            <?php foreach($Grupos as $cpGrupo=>$vlGrupo){
                if ($valores['GrupoCodigo']==$vlGrupo['Codigo']){?>
                <option value='<?php echo $vlGrupo['Codigo']; ?>' selected><?php echo $obj->preencheZero("E", 3, $vlGrupo['Codigo']); ?> - <?php echo ($vlGrupo['Descricao']); ?></option>
                <?php $Grp = $vlGrupo['Codigo'];}else{?>
                <option value='<?php echo $vlGrupo['Codigo']; ?>' ><?php echo $obj->preencheZero("E", 3, $vlGrupo['Codigo']); ?> - <?php echo ($vlGrupo['Descricao']); ?></option>                                    
            <?php }}?>
            </select>  
        <label class="label">SubGrupo</label>   
            <select name="T020_subgrupo" id="ProdutoSubGrupo" class="form-input-text-table">
            <?php if(empty($valores['SubGrupoCodigo'])){?>                    
                <option value="null"></option>
            <?php }$SubGrupos = $obj->retornaSubGrupos($valores['DeptoCodigo'],$Sec,$Grp);print_r($SubGrupos);?>
            <?php foreach($SubGrupos as $cpSubGrupo=>$vlSubGrupo){
                if ($valores['SubGrupoCodigo']==$vlSubGrupo['Codigo']){?>
                <option value='<?php echo $vlSubGrupo['Codigo']; ?>' selected><?php echo $obj->preencheZero("E", 3, $vlSubGrupo['Codigo']); ?> - <?php echo ($vlSubGrupo['Descricao']); ?></option>
                <?php }else{?>
                <option value='<?php echo $vlSubGrupo['Codigo']; ?>' ><?php echo $obj->preencheZero("E", 3, $vlSubGrupo['Codigo']); ?> - <?php echo ($vlSubGrupo['Descricao']); ?></option>                                    
            <?php }}?>
            </select>  
        <?php }?>
        <div class="form-inpu-botoes">
            <input type="submit"            value="Alterar" />
        </div>
    </form>
    </span>
</div>
<?php
/* -------- Controle de versões - tema.php --------------
 * 1.0.0 - 15/09/2011   --> Liberada a versão
*/
?>