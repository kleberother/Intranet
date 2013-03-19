<?php

$obj    =   new models_T0095();
$Deptos =   $obj->retornaDeptos();
$user   =   $_SESSION['user'];
        
if (!empty($_POST))
{    

    $FiltroLoja         =   $_POST['T006_codigo'];
    $FiltroDataInicial  =   $_POST['dataInicial'];
    $FiltroDataFinal    =   $_POST['dataFinal'];
    $FiltroDepto        =   $_POST['departamento'];
    $FiltroSecao        =   $_POST['secao'];
    $FiltroGrupo        =   $_POST['grupo'];
    $FiltroSGrupo       =   $_POST['subgrupo'];

    $dadosGrafico       =   $obj->retornaDadosGrafico(    $FiltroLoja
                                                        , $FiltroDataInicial
                                                        , $FiltroDataFinal
                                                        , $FiltroDepto
                                                        , $FiltroSecao
                                                        , $FiltroGrupo
                                                        , $FiltroSGrupo
                                                        );
    $Categoria  =   "";
    $Subtitulo  =   "";
    $ValorPreco =   "";
    $ValorEtq   =   "";
    
    foreach($dadosGrafico as $campos    =>  $valores)
    {
        $apostrofo  =   "'";
        if (empty($FiltroDepto))
            $Classificacao  =   "Todos Produtos";
        else if (empty($FiltroSecao))
            $Classificacao  =   $valores['DescricaoDpto'];
        else if (empty($FiltroGrupo))
            $Classificacao  =   $valores['DescricaoDpto']." > ".$valores['DescricaoSecao'];
        else if (empty($FiltroSGrupo))
            $Classificacao  =   $valores['DescricaoDpto']." > ".$valores['DescricaoSecao']." > ".$valores['DescricaoGrupo'];
        else
            $Classificacao  =   $valores['DescricaoDpto']." > ".$valores['DescricaoSecao']." > ".$valores['DescricaoGrupo']." > ".$valores['DescricaoSubgrupo'];        
            
        $Subtitulo   =   $valores['NomeLoja']." - ".$Classificacao;        
        $Categoria  .=   $apostrofo.$valores['CodigoAuditoria']." ".$valores['Data'].$apostrofo.",";       
        $ValorPreco .=   $valores['ErroPrc'].",";
        $ValorEtq   .=   $valores['ErroEtq'].",";
        
    }
    
}       

?>
<script>
$(function () {
    var chart;
    $(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'container',
                type: 'line',
                marginRight: 130,
                marginBottom: 30
            },
            title: {
                text: 'Gráfico: Evolução Auditoria',
                x: -20 //center
            },
            subtitle: {
                text: '<?php echo $Subtitulo;?>',
                x: -20
            },
            xAxis: {
                categories: [<?php echo $Categoria;?>]
            },
            yAxis: {
                title: {
                    text: 'Valores'
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            tooltip: {
                formatter: function() {
                        return '<b>'+ this.series.name +'</b><br/>'+
                        this.x +': '+ '<b>' +this.y+'%</b>';
                }
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'top',
                x: 0,
                y: 100,
                borderWidth: 0
            },
            series: [{
                name: 'Erro Preço',
                data: [<?php echo "$ValorPreco";?>]
            }, {
                name: 'Sem Etiqueta',
                data: [<?php echo "$ValorEtq";?>]
            }]
        });
    });
    
});
</script>

<!-- Divs com a barra de ferramentas -->
<div class="div-primaria caixa-de-ferramentas padding-padrao-vertical">
    <ul class="lista-horizontal">
        <li><a href="#"                     class="abrirFiltros botao-padrao"><span class="ui-icon ui-icon-filter"  ></span>Filtros </a></li>
        <li><a href="<?php echo ROUTER."home";?>" class="botao-padrao"><span class="ui-icon ui-icon-arrowthick-1-w"  ></span>Voltar</a></li>
    </ul>
</div>
<div class="conteudo_16 div-filtro">
    
    <form action="" method="post" class="div-filtro-visivel">
    
        <div class="grid_4">
            <?php echo $obj->retornaHtmlComboLojas($FiltroLoja,$user);?>
        </div>

        <div class="grid_2">
            <label class="label">Data Inicial</label>
            <input type="text" class="data" name="dataInicial" value="<?php echo $FiltroDataInicial;?>"/>
        </div>

        <div class="grid_2">
            <label class="label">Data Final</label>
            <input type="text" class="data" name="dataFinal" value="<?php echo $FiltroDataFinal;?>"/>
        </div>    

        <div class="clear"></div>

        <div class="grid_4">       
            <label class="label">Departamento</label>
                <select name="departamento" id="departamento">
                    <option value="0">Selecione...</option>
                    <?php foreach($Deptos as $campos=>$valores){?>
                        <option value="<?php echo $valores['Depto'];?>" <?php if($valores['Depto'] == $FiltroDepto) echo "selected"?>><?php echo $obj->preencheZero("E", 3, $valores['Depto'])." - ".$valores['Descricao'];?></option>
                    <?php }?>
                </select>  
        </div>   

        <div class="grid_4">
            <label class="label">Seção</label>
            <select name="secao" id="secao">
                <option value="0"></option>
            </select>
        </div>

        <div class="grid_4">
            <label class="label">Grupo</label>
            <select name="grupo" id="grupo">
                <option value="0"></option>
            </select>
        </div>

        <div class="grid_4">
            <label class="label">SubGrupo</label>
            <select name="subgrupo" id="subgrupo">
                <option value="0"></option>
            </select>                
        </div>    

        <div class="clear10"></div> 

        <div class="grid_2 prefix_14">
            <input type="submit" value="Gerar Gráfico" class="ui-button ui-widget ui-state-default ui-corner-all" role="button"/>
        </div>
        
    </form>
    
</div>

<div class="conteudo_16">    
    <div id="container" style="min-width: 400px; height: 400px; margin: 0 auto"></div>
</div>
