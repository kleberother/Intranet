<?php
///**************************************************************************
//                Intranet - DAVÓ SUPERMERCADOS
// * Criado em: 19/10/2012 por Alexandre Alves
// * Descrição: Programa de Conciliacao Correspondente Bancario (COBAN)
// * Entrada:   
// * Origens:   
//           
//**************************************************************************


//Instancia Classe
$obj       =   new models_T0112();
$conn      =   "ora";
$objORA    =   new models_T0112($conn);

$user           =   $_SESSION['user'];

// Recupera parametros de chamada da tela
 $CEBDATAARQUIVO    = $_GET['CEBDATAARQUIVO'];
 $CEBCODIGOCLIENTE  = $_GET['CEBCODIGOCLIENTE'];
 $CEBREMESSATO      = $_GET['CEBREMESSATO'];
 $CEBBANCO          = $_GET['CEBBANCO'];
 $CEBDATATRANS      = $_GET['CEBDATATRANS'];  
 $CEBAGENCIA        = $_GET['CEBAGENCIA'];
 $CEBOPERADOR       = $_GET['CEBOPERADOR'];
 $CEBSEQUENCIAL     = $_GET['CEBSEQUENCIAL'];  
 $CEBCODIGOTRANS    = $_GET['CEBCODIGOTRANS'];
        
    $DetalheBB = $objORA->retornaDetalheBB($CEBDATAARQUIVO,$CEBCODIGOCLIENTE,$CEBREMESSATO,$CEBBANCO,$CEBDATATRANS,$CEBAGENCIA,$CEBOPERADOR,$CEBSEQUENCIAL,$CEBCODIGOTRANS);    

?>
<script>function fechar(){ javascript:window.close() }</script>

<!-- Divs com a barra de ferramentas -->
<div class="div-primaria caixa-de-ferramentas padding-padrao-vertical">
    <ul class="lista-horizontal">
        <form action="javascript:window.close()" method="">
         <p style="text-align: left;"> 
           
           <input onclick="fechar()" alt="Fechar" src="" type="button" class="botao-padrao" value="Fechar">
         </p>
        </form>

    </ul>
</div>
<div class="conteudo_16 div-primaria div-filtro conteudo-visivel">
    <?php
        while ($valores = oci_fetch_assoc($DetalheBB))
        { 
        ?>
    <div class="grid_2">
        <label class="label">Data Arquivo</label>
        <input type="text" disabled value="<?php echo $valores['CEBDATAARQUIVO']?>"/>
    </div>

    <div class="grid_2">
        <label class="label">Data Movimento</label>
        <input type="text" disabled value="<?php echo $valores['CEBDATAMOVTO'];?>"/>
    </div>
    <div class="grid_2">
        <label class="label">Data Transação</label>
        <input type="text" disabled value="<?php echo $valores['CEBDATATRANS'];?>"/>
    </div>
    <div class="grid_2">
        <label class="label">Horário Transação</label>
        <input type="text" disabled value="<?php echo $valores['CEBHORATRANS'];?>"/>
    </div>

    <div class="clear"></div>
    <div class="grid_2">
        <label class="label">Loja</label>
        <input type="text" disabled value="<?php echo $valores['CEBLOJA'];?>"/>
    </div>
    <div class="grid_2">
        <label class="label">PDV</label>
        <input type="text" disabled value="<?php echo $valores['CEBPDV'];?>"/>
    </div>
    <div class="grid_2">
        <label class="label">Valor</label>
        <input type="text" disabled value="<?php echo number_format($valores['CEBVALOR'], 2, ',', '.');?>"/>
    </div>    
        
    <div class="clear"></div>
    <div class="grid_2">
        <label class="label">Código Cliente</label>
        <input type="text" disabled value="<?php echo $valores['CEBCODIGOCLIENTE'];?>"/>
    </div>
    <div class="grid_2">
        <label class="label">Operador</label>
        <input type="text" disabled value="<?php echo $valores['CEBOPERADOR'];?>"/>
    </div>
    <div class="grid_2">
        <label class="label">Remessa Para</label>
        <input type="text" disabled value="<?php echo $valores['CEBREMESSATO'];?>"/>
    </div>
    <div class="grid_2">
        <label class="label">Area Livre</label>
        <input type="text" disabled value="<?php echo $valores['CEBAREALIVRE'];?>"/>
    </div>
    <div class="clear"></div>
    <div class="grid_2">
        <label class="label">Banco</label>
        <input type="text" disabled value="<?php echo $valores['CEBBANCO'];?>"/>
    </div>
    <div class="grid_2">
        <label class="label">Agência</label>
        <input type="text" disabled value="<?php echo $valores['CEBAGENCIA'];?>"/>
    </div>    
    <div class="grid_2">
        <label class="label">Chave</label>
        <input type="text" disabled value="<?php echo $valores['CEBSEQUENCIAL'];?>"/>
    </div>    
    <div class="clear"></div>
    <div class="grid_2">
        <label class="label">Cód Transação</label>
        <input type="text" disabled value="<?php echo $valores['CEBCODIGOTRANS'];?>"/>
    </div>    
    <div class="grid_2">
        <label class="label">Cód Transação BB</label>
        <input type="text" disabled value="<?php echo $valores['CCBCODIGO'];?>"/>
    </div>        
    <div class="grid_3">
        <label class="label">Desc Transação</label>
        <input type="text" disabled value="<?php echo $valores['CCTDESCRICAO'];?>"/>
    </div>  
    <div class="clear"></div>
    <div class="grid_4">
        <label class="label">Status</label>
        <input type="text" disabled value="<?php echo $obj->preencheZero("E",3,$valores['CEBSTATUS'])."-".$valores['CSCDESCRICAO'];?>"/>
    </div>    
    
    <?php } ?>
     
</div>
