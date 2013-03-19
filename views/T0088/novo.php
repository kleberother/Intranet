<?php
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 31/01/2012 por Jorge Nova
 * Descrição: Programa para incluir 
 * Entradas:   
 * Origens:   Menu Sistema
           
**************************************************************************
*/


$connORA            =   "ora"                                        ;               

$objORA             =   new models_T0088($connORA)  ;

$obj                =   new models_T0088();

if (!empty($_POST))
{       
    
    $tabela                 =   "T088_crf";
    
    $insere                 =   $obj->inserir($tabela, $_POST);
          
    header('location:?router=T0088/home');    
}

?>

<!-- Include de Scripts Java Script  -->
<script src="template/js/interno/T0088/T0088.js"></script>

<!-- Divs com a barra de ferramentas -->
<div class="div-primaria caixa-de-ferramentas padding-padrao-vertical">
    <ul class="lista-horizontal">
        <li><a href="?router=T0088/novo" class="botao-padrao"><span class="ui-icon ui-icon-plus"            ></span>Novo    </a></li>
        <li><a href="?router=T0088/home" class="botao-padrao"><span class="ui-icon ui-icon-arrowthick-1-w"  ></span>Voltar  </a></li>
    </ul>
</div>

<div class="div-primaria padding-padrao-vertical">
    
    <form action="" method="post">
        
        <div class="conteudo-visivel padding-5px-vertical">

            <div class="coluna c02_tipo_d_01">       
                <label class="label">CRF</label>
                <input  type="text" name="T088_crf_rms" class="buscaCRF CRF"    size="4"    />            
            </div>

            <div class="coluna c02_tipo_d_02">       
                <label class="label">Descrição RMS</label>
                <input  type="text" name="T088_descricao_rms"   class="descricaoReduzida"   size="69"   readonly    />            
            </div>

        </div>
        
        <div class="conteudo-visivel padding-5px-vertical">

            <div class="coluna c1_tipo_a_01">       
                <label class="label">Descrição Intranet</label>
                <input type="text" name="T088_descricao_nota_debito" size="100" />            
            </div>

        </div>
        
        <div class="conteudo-visivel padding-5px-vertical">
            
            <div class="coluna c1_tipo_a_01">       
                <input type="submit" value="Salvar" class="botao-padrao" />            
            </div>
            
        </div>        
        
    </form>  
    
</div>





