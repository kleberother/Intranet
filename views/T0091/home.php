<?php
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 03/04/2012 por Rodrigo Alfieri
 * Descrição: 
 * Entradas:   
 * Origens:   
           
**************************************************************************
*/
//Instancia Classe
$obj            =   new models_T0091();
$Deptos         =   $obj->retornaDeptos();

$objORA         =   new models_T0091("ora");

// Loja do usuário
$retornaLojaUsu     =   $obj->retornaLojas($_SESSION['user']);

foreach($retornaLojaUsu as $campos=>$valores)
{
    $codigoLoja     =   $valores['Codigo'];
}   

if(!empty($_POST['Cria'])&& $_POST['departamento'] <> '0')
{
    $depto              =   $_POST['departamento']                                              ;
    $secao              =   $_POST['secao']                                                     ;
    $grupo              =   $_POST['grupo']                                                     ;    
    $subgrupo           =   $_POST['subgrupo']                                                  ;
    if (empty($subgrupo))
        $subgrupo = 0;    
    $loja               =   $_POST['T006_codigo']                                               ;
    $dataArquivo        =   date('d/m/Y H:i:s')                                                 ;
    $lojaSemDigito      =   substr ($_POST['T006_codigo'], 0, strlen($_POST['T006_codigo']) - 1);

    $user               =   $_SESSION['user']           ;
    $codigoExtensao     =   25                          ;// 25 - txt
    $extensaoArquivo    =   "txt"                       ;
    $categoriaArquivo   =   20                          ;// 20 - Coletor    
    
    $nomeArquivo        =   "[Coletor] - Auditoria Preço - Loja ".$obj->preencheZero("E",2,$lojaSemDigito)    ;        
    
    //Descrição do Arquivo
    $descArquivo         =   "Data: ".$dataArquivo      ;
    $descArquivo        .=   " - Usuário: ".$user       ;
    if (!empty($depto))
    {
        $descDepto   =  $obj->retornaClassificacao($depto, 0, 0, 0) ;
        $descArquivo.=   ", D: ".$depto."-".$descDepto[0] ;
    }
    if (!empty($secao))
    {
        
        $descSecao       =   $obj->retornaClassificacao($depto, $secao, 0, 0)   ;  
        $descArquivo    .=   ", S: ".$secao."-".$descSecao[0]         ;    
    }
    if (!empty($grupo))
    {
        $descGrupo       =   $obj->retornaClassificacao($depto, $secao, $grupo, 0)  ;
        $descArquivo    .=   ", G: ".$grupo."-".$descGrupo[0]             ;
    }
    if (!empty($subgrupo))
    {
        $descSubGrupo   =   $obj->retornaClassificacao($depto, $secao, $grupo, $subgrupo)   ;
        $descArquivo   .=   ", SG: ".$subgrupo."-".$descSubGrupo[0]               ;    
    }       
    
    //Faz "Upload" do arquivo para Categoria 20 (Coletor)
    $tabela =   "T055_arquivos";    
    
    $campos =   array( "T055_nome"      =>  $nomeArquivo
                     , "T055_desc"      =>  $descArquivo
                     , "T055_dt_upload" =>  $dataArquivo
                     , "T004_login"     =>  $user
                     , "T057_codigo"    =>  $codigoExtensao
                     , "T056_codigo"    =>  $categoriaArquivo
                     , "T004_owner"     =>  $user);
    $obj->inserir($tabela, $campos);
        
    $codigoArquivo    =   $obj->lastInsertId()                      ;
    
    $Arquivo          =   $obj->preencheZero("E", 4, $lojaSemDigito)."_".$obj->preencheZero("E", 8, $codigoArquivo);    
    
    $dia        =   date(d)                 ; 
    $mes        =   date(m)                 ; 
    $ano        =   date(Y)                 ; 
    $dataRMS7   =   ($ano-1900).$mes.$dia   ;
    $Produtos   =   $objORA->retornaProdutos($dataRMS7, $loja, $depto, $secao, $grupo, $subgrupo);
        
    //Gera Arquivo para Coletor
    $Path   =   CAMINHO_ARQUIVOS."CAT".$obj->preencheZero("E",4,$categoriaArquivo)."/"."C".$obj->preencheZero("E", 8, $Arquivo);   
    $f=fopen($Path,"a+",0);
    
    $Separador  =   "|";            
    
    $Cabec      =  "I" //Indica inicio Arquivo
                   .$obj->preencheZero("E", 4,$lojaSemDigito).$Separador //Loja + |
                   .$obj->preencheZero("E",2,$depto).$Separador.str_pad($descDepto[0], 30, " ", STR_PAD_RIGHT).$Separador                             //CodDepto + DeptoDescricao
                   .$obj->preencheZero("E",2,$secao).$Separador.str_pad($descSecao[0], 30, " ", STR_PAD_RIGHT).$Separador                             //CodSeçao + SeçãoDescricao
                   .$obj->preencheZero("E",2,$grupo).$Separador.str_pad($descGrupo[0], 30, " ", STR_PAD_RIGHT).$Separador                             //CodGrupo + GrupoDescricao
                   .$obj->preencheZero("E",2,$subgrupo).$Separador.str_pad($descSubGrupo[0], 30, " ", STR_PAD_RIGHT).$Separador                       //CodSubGrupo + SubGrupoDescricao
                   .date("dmyHis").$Separador            
                   .$obj->preencheZero("E", 8, $codigoArquivo)."\n";        //Código Arquivo
    
    if(fwrite($f,$Cabec,strlen($Cabec)))
    {     
        
        //Grava dados tabela
        $tabela =   "T093_auditoria";
        
        $campos =   array(  "T093_codigo"       =>  $codigoArquivo
                          , "T093_tipo"         =>  "C"
                          , "T006_codigo"       =>  $loja
                          , "T004_login"        =>  $user
                          , "T020_departamento" =>  $depto            
                          , "T020_secao"        =>  $secao        
                          , "T020_grupo"        =>  $grupo            
                          , "T020_subgrupo"     =>  $subgrupo            
                          , "T093_dt_inicio"    =>  date("d/m/Y H:i:s")            
                         );
        
        $obj->inserir($tabela, $campos);
    }
    $i=1;
    
    while ($row_ora = oci_fetch_assoc($Produtos))
    {
        $ean            =   $row_ora['EAN']         ;
        $codigoRMS      =   $row_ora['CODIGOITEM']  ;
        $descricao      =   $row_ora['DESCRICAO']   ;
        $saidaMedia     =   $row_ora['SAIDAMEDIA']  ;
        $emLinha        =   $row_ora['EMLINHA']     ;
        $infoPreco      =   $row_ora['INFOPRECO']   ;
        $codfornecedor  =   $row_ora['CODIGOFORNECEDOR'];
        $codcomprador   =   $row_ora['CODIGOCOMPRADOR'];
        $embalagem      =   $row_ora['EMBALAGEM'];
        $tpoEmbalagem   =   $row_ora['TIPOEMBALAGEM'];
        
        $linha   =   str_pad($ean       ,   14, "0", STR_PAD_LEFT) .$Separador;
        $linha  .=   str_pad($descricao ,   22, " ", STR_PAD_RIGHT).$Separador;        

        // separa os campos do retorno em um array
        $ArrayPrc = split(',',str_replace('|',',',$infoPreco));
        
        /* Exemplo de Retorno:
        149|230911|199|40811|149|230911|230911|360|141,4
        * Onde:
        * [0] = Preço Vigente (2 decimais)
        * [1] = Data Entrada Preço
        * [2] = Preço Normal (2 decimais)
        * [3] = Data Entrada Preço Normal
        * [4] = Preço Oferta Vigente
        * [5] = Data Entrada Oferta
        * [6] = Data Fim Oferta 
        */        
        
        // Grava os valores do retorno
        $precoVigente   =   $ArrayPrc[0];
        $precoOferta    =   $ArrayPrc[4];
        
        $estoque        =   $row_ora['ESTOQUE'];
        
        $codigopai      =   $row_ora['CODIGOPAI'];
        
        if ($codigopai=="0")
            $codigopai  =   $row_ora['CODIGOITEM'];
        
        if($precoOferta > 0)
        {
            $preco  =   $precoOferta    ;
            $oferta =   'S'             ;
        }
        else
        {
            $preco  =   $precoVigente   ;
            $oferta =   'N'             ;
        }
        
        $saidaMedia=    str_replace(".", ",", $saidaMedia);
        
        $linha  .=  str_pad($preco/100  ,   8,  " ", STR_PAD_LEFT).  $Separador;
        $linha  .=  str_pad($oferta     ,   1,  " ", STR_PAD_LEFT).  $Separador;
        $linha  .=  str_pad($emLinha    ,   1,  " ", STR_PAD_LEFT).  $Separador;
        $linha  .=  str_pad($saidaMedia ,   6,  "0", STR_PAD_LEFT).  $Separador;
                        
        $linha  = str_pad($linha,163," ", STR_PAD_RIGHT)."\n"; //pula linha arquivo                
        
        /*Exemplo $linha: |00000078903999|COELHO PASC.GAR.50G   |    2,49|N|  0,00|*/
        
        if(fwrite($f,$linha,strlen($linha)))
        {
            $tabela =   "T094_auditoria_detalhes";
            
            $campos =   array(  "T093_codigo"           =>  $codigoArquivo
                              , "T093_tipo"             =>  "C"
                              , "T094_EAN"              =>  $ean
                              , "T094_codigo_rms"       =>  $codigoRMS
                              , "T094_descricao"        =>  $descricao
                              , "T094_oferta"           =>  $oferta
                              , "T094_linha"            =>  $emLinha
                              , "T094_preco_auditado"   =>  0
                              , "T094_preco_rms"        =>  $preco/100
                              , "T094_saida_media"      =>  $saidaMedia
                              , "T094_tp_endereco"      =>  'null'
                              , "T094_nro_endereco"     =>  'null'
                              , "T094_qtde_etiqueta"    =>  'null'
                              , "T105_status"           =>  "1"
                              , "T094_item_pai_rms"     =>  $codigopai
                              , "T094_estoque_rms"      =>  $estoque
                              , "T094_fornecedor_rms"   =>  $codfornecedor
                              , "T094_comprador_rms"    =>  $codcomprador
                              , "T094_embalagem"        =>  $embalagem
                              , "T094_tpo_embalagem"    =>  $tpoEmbalagem
                             );
            
            $obj->inserir($tabela, $campos);
            
        }
    }
    
    $Rodape=    "F".$obj->preencheZero("E", 4, $lojaSemDigito).$Separador.date("dmyHis").$Separador.$obj->preencheZero("E", 8, $codigoArquivo);  
    
    $Rodape  = str_pad($Rodape,163," ", STR_PAD_RIGHT)."\n"; //pula linha arquivo                
    
    fwrite($f,$Rodape,strlen($Rodape));           
    
    if (fclose($f))
    {
        //Atualiza Data Fim
        $tabela =   "T093_auditoria";
        
        $campos = array("T093_dt_fim" => date("d/m/Y H:i:s"));
        
        $delim  = " T093_codigo = $codigoArquivo";  
        $delim  .= " AND T093_tipo = 'C'";  
        
        $obj->altera($tabela, $campos, $delim);        
    }
    
}

$SelectBoxLoja   =   $obj->retornaLojasSelectBox();

$retornaArquivos    =   $obj->retornaArquivos();

?>
<!-- jQuery do Programa T0091-->
<script type="text/javascript" src="template/js/interno/T0091/T0091.js"></script>

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
            <div class="coluna c01_tipo_d_01">       
                    <label class="label">Loja</label>
                    <select name="T006_codigo" style="padding: 3px 0;" >
                        <?php
                            foreach($SelectBoxLoja as $campos=>$valores)
                            {
                        ?>
                            <option value="<?php echo $valores['Codigo']; ?>" <?php if ($codigoLoja == $valores['Codigo']) echo "selected";?>><?php echo $obj->preencheZero("E", 3, $valores['Codigo'])." - ".$valores['Nome']; ?></option>
                        <?php
                            }
                        ?>
                    </select>
            </div>            
        </div>
        
        <div class="conteudo-visivel padding-5px-vertical">

            <div class="coluna c04_tipo_d_01">       
                <label class="label">Departamento</label>
                    <select name="departamento" id="departamento">
                        <option value="0">Selecione...</option>
                        <?php foreach($Deptos as $campos=>$valores){?>
                            <option value="<?php echo $valores['Depto'];?>" <?php if($valores['Depto'] == $FiltroDepto) echo "selected"?>><?php echo $obj->preencheZero("E", 3, $valores['Depto'])." - ".$valores['Descricao'];?></option>
                        <?php }?>
                    </select>  
            </div>

            <div class="coluna c04_tipo_d_02">       
                <label class="label">Seção</label>
                <select name="secao" id="secao">
                    <option value="0"></option>
                </select>
            </div>

            <div class="coluna c04_tipo_d_03">       
                <label class="label">Grupo</label>
                <select name="grupo" id="grupo">
                    <option value="0"></option>
                </select>
            </div>

            <div class="coluna c04_tipo_d_04">       
                <label class="label">SubGrupo</label>
                <select name="subgrupo" id="subgrupo">
                    <option value="0"></option>
                </select>                
            </div>

        </div>          
        
        <div class="conteudo-visivel padding-5px-vertical">

            <div class="padding-5px-vertical margin-padrao-vertical coluna c02_tipo_b_01">
                <input type="hidden" name="Cria" value="1">
                <input type="submit" class="botao-padrao gerar" value="Gerar" id="Gerar">
            </div>

        </div>          
        
    </form>              
    
</div>

<div class="div-primaria padding-padrao-vertical">
    
    <!-- Cabecalho da Lista - Traz o título das colunas a serem listadas -->
    <ul class="lista-itens-head">
        
        <li>
            <div class="padding-padrao-vertical celula-01 conteudo-visivel">

                <div class="coluna c09_tipo_a_01 margim-5px-horizontal">
                    <p class="negrito texto-alinhado-esquerda">Loja Emissora</p>
                </div>                
                
                <div class="coluna c09_tipo_a_02 margim-5px-horizontal">
                    <p class="negrito texto-alinhado-esquerda">Auditoria</p>
                </div>

                <div class="coluna c09_tipo_a_03 margim-5px-horizontal">
                    <p class="negrito texto-alinhado-esquerda" >Departamento</p>
                </div>

                <div class="coluna c09_tipo_a_04 margim-5px-horizontal">
                    <p class="negrito texto-alinhado-esquerda">Seção</p>
                </div>

                <div class="coluna c09_tipo_a_05 margim-5px-horizontal">
                    <p class="negrito texto-alinhado-esquerda">Grupo</p>
                </div>

                <div class="coluna c09_tipo_a_06 margim-5px-horizontal">
                    <p class="negrito texto-alinhado-esquerda">Subgrupo</p>
                </div>
                
                <div class="coluna c09_tipo_a_07 margim-5px-horizontal">
                    <p class="negrito texto-alinhado-esquerda">Dt. Início Geração</p>
                </div>
                
                <div class="coluna c09_tipo_a_08 margim-5px-horizontal">
                    <p class="negrito texto-alinhado-esquerda">Dt. Fim Geração</p>
                </div>
                
                <div class="coluna c09_tipo_a_09 margim-5px-horizontal">
                    <p class="negrito texto-alinhado-esquerda">Ação</p>
                </div>

            </div>
        </li> 

    </ul>
    
    <!-- Corpo da Lista - Traz as linhas de conteúdo retornada pela query -->

    <ul class="lista-itens-body">                  
               
        <?php
        // Faz a mesma ação para todos os arquivos encontrados
        $i  =   0;
        foreach($retornaArquivos as $campos=>$valores)
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
                
                <div class="coluna c09_tipo_a_01 margim-5px-horizontal">
                    <p class="texto-alinhado-esquerda"><?php echo $obj->preencheZero("E",3,$valores['CodigoLoja'])."-".$valores['NomeLoja'];?></p>
                </div>
                
                <div class="coluna c09_tipo_a_02 margim-5px-horizontal">
                    <p class="texto-alinhado-esquerda"><?php echo $valores['CodigoArquivo'];?></p>
                </div>

                <div class="coluna c09_tipo_a_03 margim-5px-horizontal">
                    <p class="texto-alinhado-esquerda"><?php if(!empty($valores['CodigoDpto'])) echo $obj->preencheZero("E",3,$valores['CodigoDpto'])."-".$valores['DescricaoDpto'];?></p>
                </div>

                <div class="coluna c09_tipo_a_04 margim-5px-horizontal">
                    <p class="texto-alinhado-esquerda"><?php if(!empty($valores['CodigoSecao'])) echo $obj->preencheZero("E",3,$valores['CodigoSecao'])."-".$valores['DescricaoSecao'];?></p>
                </div>

                <div class="coluna c09_tipo_a_05 margim-5px-horizontal">
                    <p class="texto-alinhado-esquerda"><?php if(!empty($valores['CodigoGrupo'])) echo $obj->preencheZero("E",3,$valores['CodigoGrupo'])."-".$valores['DescricaoGrupo'];?></p>
                </div>

                <div class="coluna c09_tipo_a_06 margim-5px-horizontal">
                    <p class="texto-alinhado-esquerda"><?php if(!empty($valores['CodigoSubgrupo'])) echo $obj->preencheZero("E",3,$valores['CodigoSubgrupo'])."-".$valores['DescricaoSubgrupo'];?></p>
                </div>

                <div class="coluna c09_tipo_a_07 margim-5px-horizontal">
                    <p class="texto-alinhado-esquerda"><?php echo $valores['DtInicioArquivo'];?></p>
                </div>

                <div class="coluna c09_tipo_a_08 margim-5px-horizontal">
                    <p class="texto-alinhado-esquerda"><?php echo $valores['DtFimArquivo'];?></p>
                </div>

                <!-- Div com a lista de ações -->
                <div class="coluna c09_tipo_a_09 margim-5px-horizontal">
                    
                    <ul class="lista-de-acoes">
                        <li><a href="?router=T0091/detalhes&codigoArquivo=<?php echo $valores['CodigoArquivo']?>"    title="Detalhes"><span class='ui-icon ui-icon-search'></span></a></li>
                    </ul>
                    
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
 
                    <div class="coluna c01_tipo_a_01 margim-5px-horizontal">
                        <p class="texto-alinhado-meio">Não há arquivos.</p>
                    </div>

                </div>
            </li> 
            
        </ul>    

    <?php }?>
    
</div>

