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
 $CRTLOJA            = $_GET['CRTLOJA'];
 $CRTPDV             = $_GET['CRTPDV'];
 $CRTNSUSITEF        = $_GET['CRTNSUSITEF'];
 $CRTNSUGCB          = $_GET['CRTNSUGCB'];
 $CRTAUTCHAVE        = $_GET['CRTAUTCHAVE'];  
 $CRTDATACONTABIL    = $_GET['CRTDATACONTABIL'];

    $DetalheCB = $objORA->retornaDetalheCB($CRTLOJA,$CRTPDV,$CRTNSUSITEF,$CRTNSUGCB,$CRTAUTCHAVE,$CRTDATACONTABIL);

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
        while ($valores = oci_fetch_assoc($DetalheCB))
        { 
        ?>
    <div class="grid_2">
        <label class="label">Data Contábil</label>
        <input type="text" disabled value="<?php echo $valores['CRTDATACONTABIL'];?>"/>
    </div>
    <div class="grid_2">
        <label class="label">Data Movimento</label>
        <input type="text" disabled value="<?php echo $valores['CRTDATAMOVTO'];?>"/>
    </div>
    <div class="grid_2">
        <label class="label">Horário</label>
        <input type="text" disabled value="<?php echo $valores['CRTHORARIO'];?>"/>
    </div>

    <div class="clear"></div>
    <div class="grid_2">
        <label class="label">Loja</label>
        <input type="text" disabled value="<?php echo $valores['CRTLOJA'];?>"/>
    </div>
    <div class="grid_2">
        <label class="label">PDV</label>
        <input type="text" disabled value="<?php echo $valores['CRTPDV'];?>"/>
    </div>
    <div class="grid_2">
        <label class="label">Valor</label>
        <input type="text" disabled value="<?php echo number_format($valores['CRTVALOR'], 2, ',', '.');?>"/>
    </div>    
        
    <div class="clear"></div>
    <div class="grid_2">
        <label class="label">NSU Sitef</label>
        <input type="text" disabled value="<?php echo $valores['CRTNSUSITEF'];?>"/>
    </div>
    <div class="grid_2">
        <label class="label">NSU Admin.</label>
        <input type="text" disabled value="<?php echo $valores['CRTNSUGCB'];?>"/>
    </div>
    <div class="grid_2">
        <label class="label">Chave Aut. BB</label>
        <input type="text" disabled value="<?php echo $valores['CRTAUTCHAVE'];?>"/>
    </div>
    <div class="clear"></div>
    <div class="grid_2">
        <label class="label">Cód Transação</label>
        <input type="text" disabled value="<?php echo $valores['CRTCODIGOTRANS'];?>"/>
    </div>    
    <div class="grid_3">
        <label class="label">Desc Transação</label>
        <input type="text" disabled value="<?php echo $valores['CCTDESCRICAO'];?>"/>
    </div>      
    <div class="grid_2">
        <label class="label">Estado Transação</label>
        <input type="text" disabled value="<?php echo $valores['CRTESTADOTRANS'];?>"/>
    </div>        
    <div class="grid_2">
        <label class="label">Desc Estado Tr.</label>
        <input type="text" disabled value="<?php echo $valores['CETDESCRICAO'];?>"/>
    </div>        
    <div class="clear"></div>
    <div class="grid_2">
        <label class="label">Cód Forma Pgto</label>
        <input type="text" disabled value="<?php echo $valores['CRTFORMAPAGAMENTO'];?>"/>
    </div>    
    <div class="grid_3">
        <label class="label">Forma Pagamento</label>
        <input type="text" disabled value="<?php echo $valores['CFPFORMA'];?>"/>
    </div>      
    <div class="grid_2">
        <label class="label">Cód CMC7</label>
        <input type="text" disabled value="<?php echo $valores['CRTCODIGOMC7'];?>"/>
    </div>        
    <div class="clear"></div>
    <div class="grid_8">
        <label class="label">Nome Cedente</label>
        <input type="text" disabled value="<?php echo $valores['CRTNOMECEDENTE'];?>"/>
    </div>        
    
    <div class="clear"></div>
    <div class="grid_8">
        <label class="label">Código Barras</label>
        <input type="text" disabled value="<?php echo $valores['CRTCODIGOBARRAS'];?>"/>
    </div>            
        <div class="clear"></div>
    <div class="grid_2">
        <label class="label">Cod Resposta</label>
        <input type="text" disabled value="<?php echo $valores['CRTCODIGORESPOSTA'];?>"/>
    </div>
    <div class="grid_2">
        <label class="label">Cod Erro</label>
        <input type="text" disabled value="<?php echo $valores['CRTCODIGOERRO'];?>"/>
    </div>    
    <div class="grid_2">
        <label class="label">Seq. Erros</label>
        <input type="text" disabled value="<?php echo $valores['CRTSEQERROS'];?>"/>
    </div>    
    <div class="grid_2">
        <label class="label">Cancelamento</label>
        <input type="text" disabled value="<?php echo $valores['CRTDOCCANCELADO'];?>"/>
    </div>        

    <div class="clear"></div>
    <div class="grid_4">
        <label class="label">Status</label>
        <input type="text" disabled value="<?php echo $obj->preencheZero("E",3,$valores['CRTSTATUS'])."-".$valores['CSCDESCRICAO'];?>"/>
    </div>    
    
    <?php } ?>
     
</div>
