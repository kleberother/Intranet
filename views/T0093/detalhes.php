<?php
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 10/05/2012 por Rodrigo Alfieri
 * Descrição: 
 * Entradas:   
 * Origens:   
           
**************************************************************************
*/

//Instancia Classe
$obj            =   new models_T0093();

$codigoArquivo  =   $_GET['codigoArquivo'];

$classArquivo   =   $obj->retornaArquivos($codigoArquivo);

$retornaItens   =   $obj->retornaItens($codigoArquivo);

?>
<!-- Divs com a barra de ferramentas -->
<div class="div-primaria caixa-de-ferramentas padding-padrao-vertical">
    <ul class="lista-horizontal">
        <li><a href="?router=T0093/home"  class="abrirFiltros botao-padrao"><span class="ui-icon ui-icon-arrowthick-1-w"  ></span>Voltar </a></li>
    </ul>
</div>

<div class="div-primaria div-filtro">

    <div class="conteudo-visivel padding-5px-vertical">
        
            <div class="coluna c01_tipo_d_01">       
                    <label class="label">Arquivo:   <?php echo $codigoArquivo;?></label>
            </div>                             
        
    </div>
    
    <div class="conteudo-visivel padding-5px-vertical">
        
            <?php if (!empty($classArquivo[0]['CodigoDpto'])){?>
                <div class="coluna c04_tipo_d_01">       
                    <label class="label">Departamento:   <?php if (!empty($classArquivo[0]['CodigoDpto'])) echo $obj->preencheZero("E", 3, $classArquivo[0]['CodigoDpto'])."-".$classArquivo[0]['DescricaoDpto'];?></label>
                </div>   
            <?php }?>
            
        
            <?php if (!empty($classArquivo[0]['CodigoSecao'])){?>
                <div class="coluna c04_tipo_d_02">       
                        <label class="label">Seção:   <?php if (!empty($classArquivo[0]['CodigoSecao'])) echo $obj->preencheZero("E", 3, $classArquivo[0]['CodigoSecao'])."-".$classArquivo[0]['DescricaoSecao'];?></label>
                </div>                             
            <?php }?>
        
            <?php if (!empty($classArquivo[0]['CodigoGrupo'])){?>
                <div class="coluna c04_tipo_d_03">       
                        <label class="label">Grupo:   <?php if (!empty($classArquivo[0]['CodigoGrupo'])) echo $obj->preencheZero("E", 3, $classArquivo[0]['CodigoGrupo'])."-".$classArquivo[0]['DescricaoGrupo'];?></label>
                </div> 
            <?php }?>
        
            <?php if (!empty($classArquivo[0]['CodigoSubgrupo'])){?>
                <div class="coluna c04_tipo_d_04">       
                        <label class="label">Subgrupo:   <?php  echo $obj->preencheZero("E", 3, $classArquivo[0]['CodigoSubgrupo'])."-".$classArquivo[0]['DescricaoSubgrupo'];?></label>
                </div>                             
            <?php }?>
        
    </div>
    
</div>

<div class="div-primaria padding-padrao-vertical">
    
    <!-- Cabecalho da Lista - Traz o título das colunas a serem listadas -->
    <ul class="lista-itens-head">
        
        <li>
            <div class="padding-padrao-vertical celula-01 conteudo-visivel">

                <div class="coluna c07_tipo_e_01 margim-5px-horizontal">
                    <p class="negrito texto-alinhado-esquerda">EAN</p>
                </div>

                <div class="coluna c07_tipo_e_02 margim-5px-horizontal">
                    <p class="negrito texto-alinhado-esquerda">Descrição</p>
                </div>

                <div class="coluna c07_tipo_e_03 margim-5px-horizontal">
                    <p class="negrito texto-alinhado-esquerda">Em Oferta[S/N]</p>
                </div>

                <div class="coluna c07_tipo_e_04 margim-5px-horizontal">
                    <p class="negrito texto-alinhado-esquerda">Em Linha[S/N]</p>
                </div>

                <div class="coluna c07_tipo_e_05 margim-5px-horizontal">
                    <p class="negrito texto-alinhado-esquerda">Preço RMS</p>
                </div>

                <div class="coluna c07_tipo_e_06 margim-5px-horizontal">
                    <p class="negrito texto-alinhado-esquerda">Preço Auditado</p>
                </div>

                <div class="coluna c07_tipo_e_07 margim-5px-horizontal">
                    <p class="negrito texto-alinhado-esquerda">Status</p>
                </div>

            </div>
            
        </li> 

    </ul>
    
    <!-- Corpo da Lista - Traz as linhas de conteúdo retornada pela query -->

    <ul class="lista-itens-body">                  
               
        <?php
        // Faz a mesma ação para todos os arquivos encontrados
        $i  =   0;
        foreach($retornaItens as $campos=>$valores)
        {           
            // Retorna celulas zebradas
            if ($celula == "celula-02")
                $celula = "celula-03";
            else
                $celula = "celula-02";
        ?>
        
        <!-- Class dados é utilizado pelo quicksearch -->        
        <li class="dados">
            
            <div class="padding-2px-vertical <?php echo $celula; ?> conteudo-visivel">
                
                <div class="coluna c07_tipo_e_01 margim-5px-horizontal">
                    <p class="texto-alinhado-esquerda"><?php echo $valores['EAN'];?></p>
                </div>

                <div class="coluna c07_tipo_e_02 margim-5px-horizontal">
                    <p class="texto-alinhado-esquerda"><?php echo $valores['Descricao'];?></p>
                </div>

                <div class="coluna c07_tipo_e_03 margim-5px-horizontal">
                    <p class="texto-alinhado-esquerda"><?php echo $valores['Oferta'];?></p>
                </div>

                <div class="coluna c07_tipo_e_04 margim-5px-horizontal">
                    <p class="texto-alinhado-esquerda"><?php echo $valores['EmLinha'];?></p>
                </div>

                <div class="coluna c07_tipo_e_05 margim-5px-horizontal">
                    <p class="texto-alinhado-esquerda"><?php echo money_format('%.2n', $valores['PrecoRMS']);?></p>
                </div>

                <div class="coluna c07_tipo_e_06 margim-5px-horizontal">
                    <p class="texto-alinhado-esquerda"><?php echo money_format('%.2n', $valores['PrecoAuditado']);?></p>
                </div>

                <div class="coluna c07_tipo_e_07 margim-5px-horizontal">
                    <p class="texto-alinhado-esquerda"><?php echo $valores['Status'];?></p>
                </div>
                
        </li> 
        <?php
        $i++;} 
        ?>
    </ul>

    <?php if ($i==0){?>
        <ul class="lista-itens-body">    

            <li class="dados">

                <div class="padding-2px-vertical <?php echo $celula; ?> conteudo-visivel">
 
                    <div class="coluna c01_tipo_g_01 margim-5px-horizontal">
                        <p class="texto-alinhado-meio">Não há itens.</p>
                    </div>

                </div>
            </li> 
            
        </ul>    

    <?php }?>
    
</div>

