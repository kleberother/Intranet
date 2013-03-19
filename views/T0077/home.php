<?php
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 19/01/2012 por Jorge Nova
 * Descrição: Programa para listar todos os médicos cadastrados
 * Entradas:   
 * Origens:   Menu Sistema
           
**************************************************************************
*/


//Instancia Classe

$obj            =   new models_T0077();


if (!empty($_POST))
{
    $filtros    =   " WHERE 1 = 1 ";
    
    $FiltroNome =   $_POST['nome'];
    
    $FiltroCRM  =   $_POST['crm'];
    
    if (!empty ($FiltroCRM))
        $filtros    .=  " AND T085_crm = ".$FiltroCRM;
    if (!empty ($FiltroNome))
        $filtros    .=  " AND T085_nome LIKE '%$FiltroNome%'";
        
}


$medicos        =   $obj->retornaMedicos($filtros);



?>

<div id="modal">
    <div id="dialog-confirm" title="Mensagem!" style="display:none">
        <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Tem certeza que deseja excluir este item?</p>
    </div>       
</div>

<!-- Divs com a barra de ferramentas -->
<div class="div-primaria caixa-de-ferramentas padding-padrao-vertical">
    <ul class="lista-horizontal">
        <li><a href="?router=T0077/novo"    class="             botao-padrao"><span class="ui-icon ui-icon-plus"    ></span>Novo    </a></li>
        <li><a href="#"                     class="abrirFiltros botao-padrao"><span class="ui-icon ui-icon-filter"  ></span>Filtros </a></li>
    </ul>
</div>

<!-- Divs com filtros -->
<div class="div-primaria div-filtro">
    <form action="" method="post">
        
        <div class="conteudo-visivel padding-5px-vertical">

            <div class="coluna c03_tipo_a_01">       
                <label class="label">Pesquisa Dinâmica</label>
                <input type="text" name="search" value="" id="id_search" />            
            </div>

            <div class="coluna c03_tipo_a_02">       
                <label class="label">Nome</label>
                <input type="text" name="nome" value="<?php echo $FiltroNome; ?>" />            
            </div>

            <div class="coluna c03_tipo_a_03">       
                <label class="label">CRM</label>
                <input type="text" name="crm" value="<?php echo $FiltroCRM; ?>"  />            
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
                    <p class="negrito texto-alinhado-esquerda">Nome</p>
                </div>

                <div class="coluna c03_tipo_a_02 margim-5px-horizontal">
                    <p class="negrito texto-alinhado-esquerda">CRM</p>
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
            foreach($medicos as $campos=>$valores)
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

                    <!-- Div com o nome do médico -->
                    <div class="coluna c03_tipo_a_01 margim-5px-horizontal">
                        <p class="texto-alinhado-esquerda"><?php echo $valores['Nome']; ?></p>
                    </div>

                    <!-- Div com o número de crm -->
                    <div class="coluna c03_tipo_a_02 margim-5px-horizontal">
                        <p class="texto-alinhado-esquerda"><?php echo $obj->preencheZero("E", 6, $valores['CRM']); ?></p>
                    </div>

                    <!-- Div com a lista de ações -->
                    <div class="coluna c0c_tipo_a_03 margim-5px-horizontal">

                        <ul class="lista-de-acoes">
                            <li><a href="#" title="Alterar"><span class='ui-icon ui-icon-pencil'></span></a></li>
                            <li><a href="#" title="Excluir"><span class='ui-icon ui-icon-close'></span></a></li>
                        </ul>

                    </div>

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
                        <p class="texto-alinhado-meio">Busque os médicos por nome ou CRM!</p>
                    </div>

                </div>
            </li> 
            
        </ul>    
    <?php
         }
           
    ?>
  </div>





