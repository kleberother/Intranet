<?php 
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 14/06/2012 por Rodrigo Alfieri
 * Descrição: 
 * Entradas:   
 * Origens:   
           
**************************************************************************
*/

//Instancia Classe
$obj    =   new models_T0110();

$Deptos =   $obj->retornaDeptos();

if (!empty($_POST))
{
    $depto      =   $_POST['departamento']  ;
    $secao      =   $_POST['secao']         ;
    $grupo      =   $_POST['grupo']         ;
    $subgrupo   =   $_POST['subgrupo']      ;
    $descricao  =   $_POST['descricao']     ;
    
    if(empty($depto))
        $depto  =   0;
    if(empty($secao))
        $secao  =   0;
    if(empty($grupo))
        $grupo  =   0;
    if(empty($subgrupo))
        $subgrupo  =   0;
    
    $tabela     =   "T020_classificacao_mercadologica";
    
    $campos     =   array("T020_descricao_painel"  =>  strtoupper($descricao));
            
    $delim      =   " T020_departamento =   $depto"     ;
    $delim     .=   " AND T020_secao    =   $secao"     ;
    $delim     .=   " AND T020_grupo    =   $grupo"     ;
    $delim     .=   " AND T020_subgrupo =   $subgrupo"  ;
    
    $obj->alterar($tabela, $campos, $delim);
       
}


?>
<!-- jQuery do Programa T0110-->
<script type="text/javascript" src="template/js/interno/T0110/T0110.js"></script>
<!-- Divs com filtros -->
<div class="div-primaria div-filtro">
    <form action="" method="post">
        
        <div class="conteudo-visivel padding-5px-vertical">

            <div class="coluna c04_tipo_d_01">       
                <label class="label">Departamento</label>
                    <select name="departamento" id="departamento">
                        <option value="0" selected>Selecione...</option>
                        <?php foreach($Deptos as $campos=>$valores){?>
                            <option value="<?php echo $valores['Depto'];?>" <?php if($valores['Depto'] == $FiltroDepto) echo "selected"?>><?php echo $obj->preencheZero("E", 3, $valores['Depto'])." - ".$valores['Descricao'];?></option>
                        <?php }?>
                    </select>  
            </div>

            <div class="coluna c04_tipo_d_02">       
                <label class="label">Seção</label>
                <select name="secao" id="secao">
                    <option value="0" selected></option>
                </select>
            </div>

            <div class="coluna c04_tipo_d_03">       
                <label class="label">Grupo</label>
                <select name="grupo" id="grupo">
                    <option value="0" selected></option>
                </select>
            </div>

            <div class="coluna c04_tipo_d_04">       
                <label class="label">SubGrupo</label>
                <select name="subgrupo" id="subgrupo">
                    <option value="0" selected></option>
                </select>                
            </div>

        </div> 
        
        <div class="conteudo-visivel padding-5px-vertical">
        
        <div class="conteudo-visivel padding-5px-vertical">

            <div class="coluna c02_tipo_a_01">       
                <label class="label">Descrição Painel</label>
                <input type="text" name="descricao" size="50"/>
            </div>

            <div class="coluna c02_tipo_a_02">       
                <input type="submit" value="Alterar" />
            </div>

        </div>
        
    </form>        
</div>