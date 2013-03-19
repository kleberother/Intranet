<?php
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 31/01/2012 por Jorge Nova
 * Descrição: Programa para listar 
 * Entradas:   
 * Origens:   Menu Sistema
           
**************************************************************************
*/

//Instancia Classe
$obj                =   new models_T0088();


if (!empty($_POST))
{
//    $filtros    =   " WHERE 1 = 1 ";
    
//    $FiltroNome =   $_POST['nome'];
//    
//    $FiltroLoja  =  $_POST['loja'];
//    
//    if (!empty ($FiltroLoja))
//        $filtros    .=  " AND TF1.T006_codigo = $FiltroLoja";
        
}

// Faz o select de CRFs
$retornaCRF   =   $obj->retornaCRFs();

?>

<div id="modal">
    <div id="dialog-confirm" title="Mensagem!" style="display:none">
        <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Tem certeza que deseja excluir este item?</p>
    </div>       
</div>

<!-- Divs com a barra de ferramentas -->
<div class="div-primaria caixa-de-ferramentas padding-padrao-vertical">
    <ul class="lista-horizontal">
        <li><a href="?router=T0088/novo"    class="             botao-padrao"><span class="ui-icon ui-icon-plus"    ></span>Novo    </a></li>
        <li><a href="#"                     class="abrirFiltros botao-padrao"><span class="ui-icon ui-icon-filter"  ></span>Filtros </a></li>
    </ul>
</div>

<!-- Divs com filtros -->
<div class="div-primaria div-filtro">
    <form action="" method="post">
        
        <div class="conteudo-visivel padding-5px-vertical">

            <div class="coluna c03_tipo_b_01">       
                <label class="label">Pesquisa Dinâmica</label>
                <input type="text" name="search" value="" id="id_search" />            
            </div>

            <div class="coluna c03_tipo_b_02">       
                <label class="label">Nome</label>
                <input type="text" name="nome" value="<?php echo $FiltroNome; ?>" />            
            </div>

            <div class="coluna c03_tipo_b_03">       
                <label class="label">Código RMS</label>
                <input type="text" name="codigo_rms" value="<?php echo $FiltroRMS; ?>" />
            </div>

        </div>
        
        <div class="conteudo-visivel padding-5px-vertical">
            
            <div class="coluna c1_tipo_a_01">       
                <input type="submit" value="Filtrar" class="botao-padrao" />            
            </div>
            
        </div>        
        
    </form>        
</div>

<div class="div-primaria padding-padrao-vertical">
    
    <!-- Cabecalho da Lista - Traz o título das colunas a serem listadas -->
    <ul class="lista-itens-head">
        
        <li>
            <div class="padding-padrao-vertical celula-01 conteudo-visivel">

                <div class="coluna c03_tipo_a_01 margim-5px-horizontal">
                    <p class="negrito texto-alinhado-esquerda">Descrição Intranet</p>
                </div>

                <div class="coluna c03_tipo_a_02 margim-5px-horizontal">
                    <p class="negrito texto-alinhado-esquerda">Descrição RMS</p>
                </div>


                <div class="coluna c03_tipo_a_03 margim-5px-horizontal">
                    <p class="negrito texto-alinhado-esquerda">Ações</p>
                </div>

            </div>
        </li> 

    </ul>

    <!-- Corpo da Lista - Traz as linhas de conteúdo retornada pela query -->
    <?php
        if (!empty($_POST))
        {
    ?>   
    <ul class="lista-itens-body">    
        <?php
        // Faz a mesma ação para todos os arquivos encontrados
        foreach($retornaCRF as $campos=>$valores)
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

                <div class="coluna c03_tipo_a_01 margim-5px-horizontal">
                    <p class="negrito texto-alinhado-esquerda"><?php echo $valores['Descricao']; ?></p>
                </div>

                <div class="coluna c03_tipo_a_02 margim-5px-horizontal">
                    <p class="negrito texto-alinhado-esquerda"><?php echo $valores['CodigoRMS']."-".$valores['DescricaoRMS']; ?></p>
                </div>

                <!-- Div com a lista de ações -->
                <div class="coluna c05_tipo_c_05 margim-5px-horizontal">
                    
                    <ul class="lista-de-acoes">
                        <li><a href="?router=T0088/altera&codigo=<?php echo $valores['CodigoRMS']; ?>" title="Alterar"><span class='ui-icon ui-icon-pencil'></span></a></li>
                    </ul>
                    
                </div>
        </li> 
        <?php
        }
        ?>
    </ul>
    <?php
         }
     else
         {
    ?>
        <ul class="lista-itens-body">    

            <!-- Class dados é utilizado pelo quicksearch -->        
            <li class="dados">

                <div class="padding-2px-vertical <?php echo $celula; ?> conteudo-visivel">

                    <!-- Div com o nome do médico -->
                    <div class="coluna c01_tipo_a_01 margim-5px-horizontal">
                        <p class="texto-alinhado-meio">Filtre os resultados para retornar uma lista desejada</p>
                    </div>

                </div>
            </li> 
            
        </ul>    
    <?php
         }
           
    ?>    
    
  </div>





