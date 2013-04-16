<?php
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 
 * Descrição: 
 * Entradas:   
 * Origens:   
           
**************************************************************************
*/

//Instancia Classe

$obj            =   new models_T0026();

$despesaCodigo  =   $_REQUEST['despesaCodigo'];

$dadosDespesa   =   $obj->retornaDespesa($despesaCodigo);
$dadosDespesaKm =   $obj->retornaDespesaDetalhe($despesaCodigo);

?>
    <!-- Divs com a barra de ferramentas -->
<div class="div-primaria caixa-de-ferramentas padding-padrao-vertical">
    <ul class="lista-horizontal">
        <li><a href="?router=T0026/home" class="botao-padrao"><span class="ui-icon ui-icon-arrowthick-1-w"></span>Voltar    </a></li>
    </ul>
</div>

<div class="conteudo_16">

    <?php foreach($dadosDespesa as $campos  =>  $valores){ ?>

    <div class="grid_16">
        <span class="form-titulo">
            <p>Despesa Nro.: <?php echo $valores['DespesaCodigo'];?></p>
        </span>
    </div>    
    
    <div class="grid_2">
        <label class="label">CPF Colaborador</label>
        <p><?php echo $obj->FormataCGCxCPF($valores['CpfUsuario']);?></p>
    </div>
    
    <div class="grid_2">
        <label class="label">Data Elaboração</label>
        <p><?php echo $valores['DespesaData'];?></p>
    </div>
    
    <div class="grid_3">
        <label class="label">Período</label>
        <p><?php echo $valores['DespesaDtInicio']." à ".$valores['DespesaDtFim'];?>  </p>
    </div>
    
    <div class="grid_2">
        <label class="label">Total</label>
        <p><?php echo $obj->formataMoeda($valores['DespesaValor']);?></p>
    </div>
    
    <?php }?>
    
    <div class="clear10"></div>
    
    <div class="grid_16">
        <span class="form-titulo">
            <p>Despesa(s) com Quilometragem</p>
        </span>
    </div>
    
    <div class="grid_2">
        
    </div>
        
    <div class=""></div>
    
    <div class=""></div>
    
    <div class=""></div>
    
    <div class=""></div>
        
    <div class="grid_16">
        <span class="form-titulo">
            <p>Despesa(s) Diversa(s)</p>
        </span>
    </div>
    
</div>

