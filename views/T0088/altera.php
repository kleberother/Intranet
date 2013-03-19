<?php
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 31/01/2012 por Jorge Nova
 * Descrição: Programa para incluir 
 * Entradas:   
 * Origens:   Menu Sistema
           
**************************************************************************
*/


$obj                =   new models_T0088();

if (!empty($_POST))
{       
    
    $tabela                 =   "T088_crf";
    
    $delim                  =   "T088_crf_rms = ".$_GET['codigo'];
    
    $insere                 =   $obj->altera($tabela, $_POST, $delim);
          
    header('location:?router=T0088/home');    
}


$retornaCRF =   $obj->retornaCRF($_GET["codigo"]);

?>




<!-- Divs com a barra de ferramentas -->
<div class="div-primaria caixa-de-ferramentas padding-padrao-vertical">
    <ul class="lista-horizontal">
        <li><a href="?router=T0088/novo" class="botao-padrao"><span class="ui-icon ui-icon-plus"            ></span>Novo    </a></li>
        <li><a href="?router=T0088/home" class="botao-padrao"><span class="ui-icon ui-icon-arrowthick-1-w"  ></span>Voltar  </a></li>
    </ul>
</div>

<div class="div-primaria padding-padrao-vertical">
    
    <?php
    foreach ($retornaCRF as $campos=>$valores)
    {
    ?>
    <form action="" method="post">
        
        <div class="conteudo-visivel padding-5px-vertical">

            <div class="coluna c02_tipo_d_01">       
                <label class="label">CRF</label>
                <input  type="text" name="T088_crf_rms" class="buscaCRF CRF"    size="4"  value="<?php echo $valores['CodigoRMS']; ?>" disabled="disabled" />            
            </div>

            <div class="coluna c02_tipo_d_02">       
                <label class="label">Descrição RMS</label>
                <input  type="text" name="T088_descricao_rms"   class="descricaoReduzida"   size="69"  value="<?php echo $valores['DescricaoRMS']; ?>" disabled="disabled"    />            
            </div>

        </div>
        
        <div class="conteudo-visivel padding-5px-vertical">

            <div class="coluna c1_tipo_a_01">       
                <label class="label">Descrição Intranet</label>
                <input type="text" name="T088_descricao_nota_debito" size="100" value="<?php echo $valores['Descricao']; ?>" />            
            </div>

        </div>
        
        <div class="conteudo-visivel padding-5px-vertical">
            
            <div class="coluna c1_tipo_a_01">       
                <input type="submit" value="Salvar" class="botao-padrao" />            
            </div>
            
        </div>        
        
    </form>
    <?php
    }
    ?>
    
</div>





