<?php
//Instancia Classe
$conn   =   "ora";
$objORA    =   new models_T0097($conn);

$obj       =   new models_T0097();

$user           =   $_SESSION['user'];

$perfilUsuario  =   $obj->retornaPerfil($user);

$lojaUsuario    =   $obj->retornaLojaUsuario($user);

$comboLoja      =   $obj->retornaLojas();

$tipo           =   $_POST['tipo'];



if (!empty($_POST))
{
    if ($perfilUsuario[0]==47)
        $loja   =   $_POST['loja'];
    else 
        $loja   =   $lojaUsuario;    
    
  
    //Data Inicial
    if (!empty($_POST)){
        $dataInicial    =   $_POST['dataI'];
        $arrayData      =   explode("/", $dataInicial);   
        $ano            =   $arrayData[2]-1900;
        $mes            =   $arrayData[1];
        $dia            =   $arrayData[0];
                        }
    else 
        $dataInicial    =   date("d/m/Y");
    
    if(!empty($dia))
        $dataI          =   $ano.$mes.$dia;
    else
        $dataI          =   "";
    
    
    
    //Data Final
        $dataFinal    =   $_POST['dataF'];
        $arrayData      = explode("/", $dataFinal);   
        $ano    =   $arrayData[2]-1900;
        $mes    =   $arrayData[1];
        $dia    =   $arrayData[0];
    
    if(!empty($dia))
        $dataF  =   $ano.$mes.$dia;
    else
        $dataF  =   "";
    
    
    
    
    
    if (!empty($_POST['filtro']))
        $filtro =   $_POST['filtro'];
    else
        $filtro =   5;
        
    $Dados  =   $objORA->retornaDados($loja, $dataI,$dataF, $tipo, $filtro);    
}

?>

<!-- Divs com a barra de ferramentas -->
<div class="div-primaria caixa-de-ferramentas padding-padrao-vertical">
    <ul class="lista-horizontal">
        <li><a href="#"                     class="abrirFiltros botao-padrao"><span class="ui-icon ui-icon-filter"  ></span>Filtros </a></li>
    </ul>
</div>

<!-- Divs com filtros oculta -->
<div class="div-primaria div-filtro">
    <form action="" method="post" class="div-filtro-visivel">
        
        <div class="conteudo-visivel padding-5px-vertical">

            <div class="coluna c05_tipo_f_01">       
                <label class="label">Loja</label>
                
                    <?php if($perfilUsuario[0]==47){?>
                    <select name="loja">
                        <option value="">Todas</option>
                        <?php foreach($comboLoja as $campos => $valores){?>
                            <option value="<?php echo $valores['LojaCodigo']?>" <?php echo $valores['LojaCodigo']==$loja?"selected":"";?>><?php echo $obj->preencheZero("E", 3, $valores['LojaCodigo'])."-".$valores['LojaNome'];?></option>
                        <?php }?>
                    </select>                    
                    <?php }else if($perfilUsuario[0]==48){?>
                    <select name="loja" disabled>
                        <?php foreach($comboLoja as $campos => $valores){?>
                            <option value="<?php echo $valores['LojaCodigo']?>" <?php echo $valores['LojaCodigo']==$lojaUsuario?"selected":""?>><?php echo $valores['LojaCodigo']==$lojaUsuario?$obj->preencheZero("E", 3, $valores['LojaCodigo'])."-".$valores['LojaNome']:" 999 - erro";?></option>
                        <?php }?>
                    </select>                                    
                    <?php }?>
                
            </div>
            
     <div class="coluna c05_tipo_f_02">       
                <label class="label">Operador/Vendedor</label>
                <select name="tipo">
                    <option value="">Selecione...</option>
                    <option value="VE" <?php echo $tipo=="VE"?"selected":"";?>>Vendedor</option>
                    <option value="OC" <?php echo $tipo=="OC"?"selected":"";?>>Operador de Caixa</option>
                </select>
            </div>
            
            <div class="coluna c05_tipo_f_03">       
                <label class="label">Classificação</label>
                <select name="filtro">
                    <option value="5" <?php echo $filtro=="5"?"selected":"";?>>Quantidade</option>
                    <option value="6" <?php echo $filtro=="6"?"selected":"";?>>Valor</option>
                </select>
            </div>            

            <div class="coluna c05_tipo_f_04">       
                <label class="label">Data Inicial</label>
                <input type="text" name="dataI" class="data" value="<?php echo $dataInicial;?>" />
            </div>

            <div class="coluna c05_tipo_f_05">       
                <label class="label">Data Final</label>
                <input type="text" name="dataF" class="data" value="<?php echo $dataFinal;?>" />
            </div>                       

        </div>          
        
        <div class="conteudo-visivel padding-5px-vertical">

            <div class="padding-5px-vertical margin-padrao-vertical coluna c02_tipo_b_01">
                <input type="submit" class="botao-padrao" value="Filtrar">
            </div>

        </div>          
        
    </form>              
    
</div>

<div class="div-primaria padding-padrao-vertical">
    
    <!-- Cabecalho da Lista - Traz o título das colunas a serem listadas -->
    <ul class="lista-itens-head">
        
        <li>
            <div class="padding-padrao-vertical celula-01 conteudo-visivel">

                <div class="coluna c07_tipo_c_01 margim-5px-horizontal">
                    <p class="negrito texto-alinhado-esquerda">Loja</p>
                </div>

                <div class="coluna c07_tipo_c_03 margim-5px-horizontal">
                    <p class="negrito texto-alinhado-esquerda">Código RMS</p>
                </div>

                <div class="coluna c07_tipo_c_04 margim-5px-horizontal">
                    <p class="negrito texto-alinhado-esquerda">Nome</p>
                </div>

                <div class="coluna c07_tipo_c_05 margim-5px-horizontal">
                    <p class="negrito texto-alinhado-esquerda">Tipo</p>
                </div>

                <div class="coluna c07_tipo_c_06 margim-5px-horizontal">
                    <p class="negrito texto-alinhado-esquerda">Qtde</p>
                </div>

                <div class="coluna c07_tipo_c_07 margim-5px-horizontal">
                    <p class="negrito texto-alinhado-esquerda">Valor (R$)</p>
                </div>

            </div>
        </li> 

    </ul>
    
    <!-- Corpo da Lista - Traz as linhas de conteúdo retornada pela query -->

    <ul class="lista-itens-body">                  
               
        <?php
        // Faz a mesma ação para todos os arquivos encontrados
        $i  =   0;
        while ($valores = oci_fetch_assoc($Dados))
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
                
                <div class="coluna c07_tipo_c_01 margim-5px-horizontal">
                    <p class="texto-alinhado-esquerda"><?php echo $valores['LOJA'];?></p>
                </div>

                <div class="coluna c07_tipo_c_03 margim-5px-horizontal">
                    <p class="texto-alinhado-esquerda"><?php echo $valores['COD_RMS'];?></p>
                </div>

                <div class="coluna c07_tipo_c_04 margim-5px-horizontal">
                    <p class="texto-alinhado-esquerda"><?php echo strtoupper($valores['NOME']);?></p>
                </div>

                <div class="coluna c07_tipo_c_05 margim-5px-horizontal">
                    <p class="texto-alinhado-esquerda"><?php echo $valores['OPER_VEND'];?></p>
                </div>

                <div class="coluna c07_tipo_c_06 margim-5px-horizontal">
                    <p class="texto-alinhado-esquerda"><?php echo $valores['QTDE'];?></p>
                </div>

                <div class="coluna c07_tipo_c_07 margim-5px-horizontal">
                    <p class="texto-alinhado-esquerda"><?php echo money_format("%.2n",$valores['VALOR']);?></p>
                </div>
                
                <?php   
                        //TOTAIS
                        $totalQtde     +=   $valores['QTDE'];
                        $totalValor    +=   $valores['VALOR'];
                 ?>
                
        </li> 
        <?php
        $i++;} 
        ?>
        <li class="dados">
            
            <div class="padding-2px-vertical celula-01 conteudo-visivel">

                <div class="coluna c03_tipo_e_01 margim-5px-horizontal">
                    <p class="texto-alinhado-esquerda negrito">TOTAL</p>
                </div>

                <div class="coluna c03_tipo_e_02 margim-5px-horizontal">
                    <p class="texto-alinhado-esquerda negrito"><?php echo $totalQtde;?></p>
                </div>

                <div class="coluna c03_tipo_e_03 margim-5px-horizontal">
                    <p class="texto-alinhado-esquerda negrito"><?php echo money_format("%.2n",$totalValor);?></p>
                </div>
                
            <div>
                
        </li>   
        
    </ul>
    
    <?php if ($i==0){?>
        <ul class="lista-itens-body">    

            <li class="dados">

                <div class="padding-2px-vertical <?php echo $celula; ?> conteudo-visivel">
 
                    <div class="coluna c01_tipo_g_01 margim-5px-horizontal">
                        <p class="texto-alinhado-meio">Sem dados.</p>
                    </div>

                </div>
            </li> 
            
        </ul>    

    <?php }?>
    
</div>

