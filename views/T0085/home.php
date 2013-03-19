<?php
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 29/01/2012 por Rodrigo Alfieri
 * Descrição: Programa para listar todos os usuários cadastrados para usar a extranet
 * Entradas:   
 * Origens:   Menu Sistema
           
**************************************************************************
*/


//Instancia Classe

$obj            =   new models_T0085();

$Contas         =   $obj->retornaContas();

?>

<div id="modal">
    <div id="dialog-confirm" title="Mensagem!" style="display:none">
        <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Tem certeza que deseja excluir este item?</p>
    </div>       
</div>

<!-- Divs com a barra de ferramentas -->
<div class="div-primaria caixa-de-ferramentas padding-padrao-vertical">
    <ul class="lista-horizontal">
        <li><a href="?router=T0085/novo"    class="             botao-padrao"><span class="ui-icon ui-icon-plus"    ></span>Novo    </a></li>
        <li><a href="#"                     class="abrirFiltros botao-padrao"><span class="ui-icon ui-icon-filter"  ></span>Filtros </a></li>
    </ul>
</div>

<!-- Divs com filtros oculta -->
<div class="div-primaria div-filtro">
    <form action="" method="post" class="div-filtro-oculto">
        
        <div class="conteudo-visivel padding-5px-vertical">

            <div class="coluna c01_tipo_a_01">       
                <label class="label">Pesquisa Dinâmica</label>
                <input type="text" name="search" value="" id="id_search" />            
            </div>

        </div>          
        
    </form>              
</div>

<div class="div-primaria padding-padrao-vertical">
    
    <!-- Cabecalho da Lista - Traz o título das colunas a serem listadas -->
    <ul class="lista-itens-head">
        
        <li>
            <div class="padding-padrao-vertical celula-01 conteudo-visivel">

                <!-- Div com o nome e link do arquivo para download -->
                <div class="coluna c04_tipo_a_01 margim-5px-horizontal">
                    <p class="negrito texto-alinhado-esquerda">Nome</p>
                </div>

                <!-- Div com a descrição do arquivo -->
                <div class="coluna c04_tipo_a_02 margim-5px-horizontal">
                    <p class="negrito texto-alinhado-esquerda">Agenda RMS</p>
                </div>

                <!-- Div com o nome e link do arquivo para download -->
                <div class="coluna c04_tipo_a_03 margim-5px-horizontal">
                    <p class="negrito texto-alinhado-esquerda">CRF</p>
                </div>

                <!-- Div com o nome e link do arquivo para download -->
                <div class="coluna c04_tipo_a_04 margim-5px-horizontal">
                    <p class="negrito texto-alinhado-esquerda">Ações</p>
                </div>

            </div>
        </li> 

    </ul>

    <!-- Corpo da Lista - Traz as linhas de conteúdo retornada pela query -->    
    <ul class="lista-itens-body">    
        <?php
        // Faz a mesma ação para todos os arquivos encontrados
        foreach($Contas as $campos=>$valores)
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

                <!-- Div com o nome e link do arquivo para download -->
                <div class="coluna c04_tipo_a_01 margim-5px-horizontal">
                    <p class="texto-alinhado-justificado"><?php echo $obj->preencheZero("E", 3, $valores['CodigoConta'])." - ".$valores['NomeConta']; ?></p>
                </div>

                <!-- Div com a descrição do arquivo -->
                <div class="coluna c04_tipo_a_02 margim-5px-horizontal">
                    <p class="texto-alinhado-justificado"><?php echo $valores['AgendaConta']; ?></p>
                </div>

                <!-- Div com o nome e link do arquivo para download -->
                <div class="coluna c04_tipo_a_03 margim-5px-horizontal">
                    <p class="texto-alinhado-justificado"><?php echo $valores['CRFConta']; ?></p>
                </div>

                <!-- Div com a lista de ações -->
                <div class="coluna c04_tipo_a_04 margim-5px-horizontal">
                    
                    <ul class="lista-de-acoes">
<!--                        <li><a href="#" title="Alterar"><span class='ui-icon ui-icon-pencil'></span></a></li>-->
                        <li><a href="javascript:excluir('T0085','T0085/home','T014_conta','T014_codigo','<?php echo ($valores['CodigoConta']);?>','',0,1)" title="Excluir"><span class='ui-icon ui-icon-close'></span></a></li>
                    </ul>
                    
                </div>

            </div>
        </li> 
        <?php
        }
        ?>
    </ul>
    
  </div>





