<?php 
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 26/01/2012 por Jorge Nova
 * Descrição: Programa para listar 
 * Entradas:   
 * Origens:   Menu Sistema
           
**************************************************************************
*/


//Instancia Classe

$obj            =   new models_T0084();


if (!empty($_POST))
{
    $filtros            =   " ";
    
    $FiltroForn         =   $obj->retornaCodigoFornecedorAutoComplete($_POST['fornecedor']);
    
    $FiltroLoja         =  $_POST['loja'];
    
    $status             =   $_POST['status'];
    
    if (!empty ($FiltroLoja))
        $filtros    .=  " AND TF1.T006_codigo = $FiltroLoja";
    if (!empty ($FiltroForn))
        $filtros    .=  " AND TF1.T026_codigo = $FiltroForn";        
    
    //Status da Nota
    switch ($status) {
        case 1:
            $retornaNotas   =   $obj->retornaAguardandoMinhaAprovacao($_SESSION['user'],$filtros);
            break;
        case 2:
            $retornaNotas   =   $obj->retornaMinhasDigitadas($_SESSION['user'],$filtros);
            break;
        case 3:
            $retornaNotas   =   $obj->retornaAnteriores($_SESSION['user'],$filtros);
            break;
        case 4:
            $retornaNotas   =   $obj->retornaPosteriores($_SESSION['user'],$filtros);
            break;
        case 5:
            $retornaNotas   =   $obj->retornaFinalizadas($_SESSION['user'],$filtros);
            break;
        case 6:
            $retornaNotas   =   $obj->retornaCanceladas($_SESSION['user'],$filtros);
            break; 
    }
}

// Faz o select de lojas para Select Box
$retornaLojas   =   $obj->retornaLojasSelectBox();

?>

<div id="modal">
    
    <div id="dialog-confirm" title="Mensagem!" style="display:none">
        <div class='padding-2px-vertical conteudo-visivel'>        
            <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Tem certeza que deseja excluir este item?</p>
        </div>            
    </div>
    
    <div id="dialog-aprovar" title="Mensagem!" style="display:none">
        <div class='padding-2px-vertical conteudo-visivel'>
            <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Tem certeza que deseja aprovar essa(s) Nota(s)?</p>
        </div>
    </div>
    
    <div id="dialog-carregando" title="" style="display:none">
        <div class='padding-2px-vertical conteudo-visivel'>        
            <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Aguarde Aprovando AP(s)</p>
        </div>            
    </div>    
    
</div>


<!-- Divs com a barra de ferramentas -->
<div class="div-primaria caixa-de-ferramentas padding-padrao-vertical">
    <ul class="lista-horizontal">
        <li><a href="?router=T0084/novo"    class="             botao-padrao"><span class="ui-icon ui-icon-plus"    ></span>Novo    </a></li>
        <li><a href="#"                     class="abrirFiltros botao-padrao"><span class="ui-icon ui-icon-filter"  ></span>Filtros </a></li>
    </ul>
</div>

<!-- Divs com filtros -->
<div class="div-primaria div-filtro">
    <form action="" method="post">
        
        <div class="conteudo-visivel padding-5px-vertical">

            <div class="coluna c03_tipo_b_01 margim-5px-horizontal">       
                <label class="label">Status da Nota</label>
                <select name="status">
                    <option value="0" <?php echo $status==0?"selected":""?>>Selecione...                    </option>
                    <option value="1" <?php echo $status==1?"selected":""?>>Aguardando Minha Aprovação      </option>
                    <option value="2" <?php echo $status==2?"selected":""?>>Minhas Digitadas (não aprovadas)</option>
                    <option value="3" <?php echo $status==3?"selected":""?>>Anteriores a Mim                </option>
                    <option value="4" <?php echo $status==4?"selected":""?>>Posteriores a Mim               </option>
                    <option value="5" <?php echo $status==5?"selected":""?>>Finalizadas                     </option>
                    <option value="6" <?php echo $status==6?"selected":""?>>Canceladas                      </option>
                </select>
            </div>

        </div>
        
        <div class="conteudo-visivel padding-5px-vertical">

            <div class="coluna c03_tipo_b_01 margim-5px-horizontal">       
                <label class="label">Pesquisa Dinâmica</label>
                <input type="text" name="search" value="" id="id_search" />            
            </div>

            <div class="coluna c03_tipo_b_03 margim-5px-horizontal">       
                <label class="label">Loja</label>
                <select name="loja">
                    <option value="">Selecione...</option>
                    <?php
                        foreach($retornaLojas as $campos=>$valores)
                        {
                    ?>
                        <option value="<?php echo $valores['Codigo']; ?>" <?php if ($FiltroLoja == $valores['Codigo']) echo "selected"; ?>><?php echo $obj->preencheZero("E", 3, $valores['Codigo'])." - ".$valores['Nome']; ?></option>
                    <?php
                        }
                    ?>
                </select>
            </div>

        </div>
        
        <div class="conteudo-visivel padding-5px-vertical">
            
            <div class="padding-5px-vertical margin-padrao-vertical coluna c2_tipo_b_01">       
                <input type="submit" value="Filtrar" class="botao-padrao" />            
            </div>
            
            <div class="padding-5px-vertical margin-padrao-vertical coluna c02_tipo_b_02">
                <input type="button" class="botao-padrao aprovarSelecionados" value="Aprovar Selecionados">
            </div>                
            
        </div>        
        
    </form>        
</div>

<div class="div-primaria padding-padrao-vertical">
    
    <!-- Cabecalho da Lista - Traz o título das colunas a serem listadas -->
    <ul class="lista-itens-head">
        
        <li>
            <div class="padding-padrao-vertical celula-01 conteudo-visivel">

                <div class="coluna c06_tipo_d_01 margim-5px-horizontal">
                    <input type="checkbox" value="1" class="chkSelecionaTodos" /> 
                </div>
                
                <div class="coluna c06_tipo_d_02 margim-5px-horizontalpx-horizontal">
                    <p class="negrito texto-alinhado-esquerda">Código</p>
                </div>

                <div class="coluna c06_tipo_d_03 margim-5px-horizontal">
                    <p class="negrito texto-alinhado-esquerda">Loja Emissora</p>
                </div>

                <div class="coluna c06_tipo_d_04 margim-5px-horizontal">
                    <p class="negrito texto-alinhado-esquerda">Fornecedor Receptor</p>
                </div>

                <div class="coluna c06_tipo_d_05 margim-5px-horizontal">
                    <p class="negrito texto-alinhado-esquerda">Total Geral (R$)</p>
                </div>

                <div class="coluna c06_tipo_d_06 margim-5px-horizontal">
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
        foreach($retornaNotas as $campos=>$valores)
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

                <div class="coluna c06_tipo_d_01 margim-5px-horizontal">
                    <input type="checkbox" value="<?php echo "NotaCodigo:".$valores['Codigo'].";"."EtapaCodigo:".$valores['EtapaCodigo'];?>" class="chkItem"/> 
                </div>
                
                <div class="coluna c06_tipo_d_02 margim-5px-horizontal">
                    <p class="texto-alinhado-esquerda"><?php echo $obj->preencheZero("E", 4, $valores['Codigo']); ?></p>
                </div>

                <div class="coluna c06_tipo_d_03 margim-5px-horizontal">
                    <p class="texto-alinhado-esquerda"><?php echo $valores['CodLoja']." - ".$valores['NomeLoja']; ?></p>
                </div>

                <div class="coluna c06_tipo_d_04 margim-5px-horizontal">
                    <p class="texto-alinhado-esquerda"><?php echo $valores['CodFornecedor']." - ".$valores['RazaoSocial']; ?></p>
                </div>

                <div class="coluna c06_tipo_d_05 margim-5px-horizontal">
                    <p class="texto-alinhado-direita"><?php echo substr(money_format('%n', $valores['ValorTotal']), 2); ?></p>
                </div>

                <!-- DIV com parametros para js-->
                <?php 
                if ($status == 1)
                {
                ?>
                <div style="display: none">
                    <p class="parametros">NotaCodigo:<?php echo $valores['Codigo'];?>;EtapaCodigo:<?php echo $valores['EtapaCodigo'];?></p>
                </div>
                <?php
                }
                ?>
                <!-- Div com a lista de ações -->
                <div class="coluna c06_tipo_d_06 margim-5px-horizontal">
                    
                    <ul class="lista-de-acoes">
                        <li><a href="?router=T0084/js.pdf&nota=<?php echo $valores['Codigo'];?>&loja=<?php echo $valores['CodLoja'];?>"    title="Imprimir"    target="_blank"><span class='ui-icon ui-icon-print'></span></a></li>
                        <?php
                        if ($status == 1)
                        {                        
                        ?>
                        <li><a href="#" title="Aprovar" class="Aprovar" ><span class='ui-icon ui-icon-check'></span></a></li>
                        <?php
                        }
                        ?>
                    </ul>
                    
                </div>
        </li> 
        <?php
        }
        ?>
    </ul
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





