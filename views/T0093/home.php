<?php
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 0304/2012 por Rodrigo Alfieri
 * Descrição: 
 * Entradas:   
 * Origens:   
           
**************************************************************************
*/  

//Instancia Classe
$conn           =   "";
$obj            =   new models_T0093($conn);

$conn           =   "ora";
$objORA         =   new models_T0093($conn);

if (!empty($_POST['Import']))
{
    //endereço diretorio Importação
    $diretorioIMP   = CAMINHO_ARQUIVOS."CAT0020/";
    //endereço diretorio Processado 
    $diretorioPROC  = CAMINHO_ARQUIVOS."CAT0020/PROCESSADOS/";    
    // abre o diretório
    $ponteiro  = opendir($diretorioIMP);
    // monta os vetores com os itens encontrados na pasta
    $contador   =   0;
    while ($arquivos = readdir($ponteiro)) 
    {   
        
        $nomeArquivo    =   explode(".",$arquivos);        
        $tpArquivo      =   substr($nomeArquivo[0],0,-13);
        $nroArquivo     =   substr($nomeArquivo[0],-8);  
                        
        if ($tpArquivo=="I")
        { 
            if (is_numeric($nroArquivo))
            {
                $handle = fopen($diretorioIMP.$arquivos, "r");
                if ($handle) 
                {
                    while (!feof($handle)) 
                    {
                        $linha  =   fgets($handle, 4096);
                        $dados  =   explode("|",$linha);               

                        //Verifica Flag de Inicio e Fim arquivo (1ª e Última Linha): I = Inicio, F = Fim
                        $flag   =   substr($dados[0], 0, 1);
                        if ($flag=="I")
                        {
                            list($loja,$codDpto,$dpto,$codSecao,$secao,$codGrupo,$grupo,$codSbg,$sbg,$dataHora,$arquivo)  =   $dados;
                            $diretorioLoja  =   substr ($loja, -4)."/";
                            $loja   =   (int)substr ($loja, -4).$obj->calculaDigitoMod11((int)substr ($loja, -4), 1, 9);

                            //Tratamento Data
                            $dia    =   substr(substr($dataHora,0,-6),0,-4);
                            $mes    =   substr(substr($dataHora,0,-6),2,-2);
                            $ano    =   substr($dataHora,4,2);
                            $hh     =   substr(substr($dataHora,-6),0,-4);
                            $mm     =   substr(substr($dataHora,-6),2,-2);
                            $ss     =   substr(substr($dataHora,-6),4,2);

                            $data   =   date("d/m/Y H:i:s", mktime($hh, $mm, $ss, $mes, $dia, $ano));

                            $tabela =   "T093_auditoria";

                            $campos =   array( "T093_codigo"       =>  $arquivo
                                            ,  "T093_tipo"         =>  "I"
                                            ,  "T006_codigo"       =>  $loja
                                            ,  "T004_login"        =>  $user
                                            ,  "T020_departamento" =>  $codDpto
                                            ,  "T020_secao"        =>  $codSecao
                                            ,  "T020_grupo"        =>  $codGrupo
                                            ,  "T020_subgrupo"     =>  $codSbg
                                            ,  "T093_dt_inicio"    =>  $data
                                            );

                            $obj->inserir($tabela, $campos);

                        }else if ($flag=="F")
                        {                                        
                            list($loja,$dataHora,$arquivo)  =   $dados;
                            $loja   =   (int)substr ($loja, -4).$obj->calculaDigitoMod11((int)substr ($loja, -4), 1, 9);

                            //Tratamento Data
                            $dia    =   substr(substr($dataHora,0,-6),0,-4);
                            $mes    =   substr(substr($dataHora,0,-6),2,-2);
                            $ano    =   substr($dataHora,4,2);
                            $hh     =   substr(substr($dataHora,-6),0,-4);
                            $mm     =   substr(substr($dataHora,-6),2,-2);
                            $ss     =   substr(substr($dataHora,-6),4,2);

                            $data   =   date("d/m/Y H:i:s", mktime($hh, $mm, $ss, $mes, $dia, $ano));

                            $tabela =   "T093_auditoria";

                            $campos =   array("T093_dt_fim" =>  $data);

                            $delim  =   " T093_codigo   =   $arquivo AND T093_tipo  =   'I' AND T006_codigo = $loja";

                            $obj->altera($tabela, $campos, $delim);
                            
                        }else
                        {
                            list($ean,$precoAuditado,$precoRMS,$oferta,$emLinha,$tpEndereco,$nroEndereco,$qtdEtiqueta,$status)    =   $dados;
                            /*  7891024158609|4.99|4.99|N|S||||1    
                             * Onde:
                             * [0] = Ean do Item
                             * [1] = Preço Auditado
                             * [2] = Preço RMS
                             * [3] = Oferta
                             * [4] = Em Linha
                             * [5] = Tipo Endereço
                             * [6] = Número Endereço
                             * [7] = Quantidade de Etiquetas a serem impressas
                             * [8] = Status do Item
                             */
                            
                          
                            if(!empty($ean))
                            {
                                $dia            =   date(d)                                                             ; 
                                $mes            =   date(m)                                                             ; 
                                $ano            =   date(Y)                                                             ; 
                                $dataRMS7       =   ($ano-1900).$mes.$dia                                               ;
                                $lojaSemDigito  =   substr ($loja, 0, strlen($loja) - 1)                                ;
                                
                                
                              
                                

                               
                           
                                $dadosItem  =   $objORA->retornaDadosItem($dataRMS7, $lojaSemDigito, $loja, $ean);

                                while($valores  = oci_fetch_assoc($dadosItem))
                                {
                                    $codigoRMS  =   $valores['CODIGOINTERNO'];
                                    $infoPreco  =   $valores['INFOPRECO']   ;

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
                                    $descricao      =   $valores['DESCRICAO']       ;
                                    
                                    $emLinha        =   $valores['EMLINHA']         ;
                                    
                                    $estoque        =   $valores['ESTOQUE']         ;
                                    
                                    $codigopai      =   $valores['CODIGOPAI']       ;
                                    
                                    $codfornecedor  =   $valores['CODIGOFORNECEDOR'];
                                    
                                    $codcomprador  =   $valores['CODIGOCOMPRADOR'];
                                    
                                    if ($codigopai==0)
                                        $codigopai  =   $codigoRMS;
                                                                       

                                    $precoVigente   =   $ArrayPrc[0]/100;
                                    $precoOferta    =   $ArrayPrc[4]/100;

                                    if($precoOferta > 0)
                                    {
                                        $precoRMS   =   $precoOferta    ;
                                        $oferta     =   'S'             ;
                                    }
                                    else
                                    {
                                        $precoRMS   =   $precoVigente   ;
                                        $oferta     =   'N'             ;
                                    }                                      
                                    
                                                                                                        
                                }
                                
                                //Formata Valores                                
                                $precoAuditado  =   $obj->formataValor("T094_auditoria_detalhes", "T094_preco_auditado", $precoAuditado);
                                $precoRMS       =   $obj->formataValor("T094_auditoria_detalhes","T094_preco_rms",$precoRMS);                                                                                            
                                
                                //Verifica Preço
                                if ($status==2)
                                {                                    
                                    //Verifica se Preço RMS está diferente do Preço Auditado
                                    if($precoAuditado==0)
                                        $status = 6;
                                    else
                                        if ($precoAuditado != $precoRMS)
                                            $status = 5;                                    
                                        else
                                            $status = 6;
                                }
                                
                                if ($status!=3)
                                {
                                    if ($emLinha=='N')
                                        $status =   4;
                                }
                                
                                if (empty($tpEndereco))
                                    $tpEndereco =   'null';
                                if (empty($nroEndereco))
                                    $nroEndereco=   'null';
                                if (empty($qtdEtiqueta))
                                    $qtdEtiqueta=   'null';                                  
                                
                                $tabela =   "T094_auditoria_detalhes";

                                $campos =   array( "T093_codigo"            =>  $arquivo
                                                ,  "T093_tipo"              =>  "I"
                                                ,  "T094_EAN"               =>  $ean
                                                ,  "T094_codigo_rms"        =>  $codigoRMS
                                                ,  "T094_descricao"         =>  $descricao    
                                                ,  "T094_oferta"            =>  $oferta      
                                                ,  "T094_linha"             =>  $emLinha
                                                ,  "T094_preco_auditado"    =>  $precoAuditado  
                                                ,  "T094_preco_rms"         =>  $precoRMS
                                                ,  "T094_tp_endereco"       =>  $tpEndereco      
                                                ,  "T094_nro_endereco"      =>  $nroEndereco      
                                                ,  "T094_qtde_etiqueta"     =>  $qtdEtiqueta      
                                                ,  "T105_status"            =>  $status
                                                ,  "T094_item_pai_rms"      =>  $codigopai
                                                ,  "T094_estoque_rms"       =>  $estoque
                                                ,  "T094_fornecedor_rms"    =>  $codfornecedor
                                                ,  "T094_comprador_rms"     =>  $codcomprador
                                                );
                                
                                $obj->inserir($tabela, $campos);
                                
                                $descricao = "";
                            }
                        }

                    }

                    fclose($handle);
                    
                    
                        $rupturaComercial   =   $obj->retornaRupturasComercial($arquivo);
                           
                            foreach ($rupturaComercial as $camposRupt => $valoresRupt) {
                                
                               $eanRupt    =   $valoresRupt["Ean"];
                               
                                    $lojas  = $obj->retornaStrLojaSegmento();
                                
                                  $dadosEstoque =  $objORA->retornaDadosEstoque($eanRupt, $lojas);
                                
                                while($valoresEst   = oci_fetch_assoc($dadosEstoque)){
                                    
                                    $QtdEstoque =   round($valoresEst["ESTOQUE"]);
                                    
                                    $tabela =   "T112_auditoria_loja_est";
                                    
                                    $campos =   array(  "T093_codigo"       =>  $arquivo
                                                    ,   "T094_EAN"          =>  $eanRupt
                                                    ,   "T094_loja"         =>  $valoresEst['LOCAL']
                                                    ,   "T094_qtd_estoque"  =>  $QtdEstoque);
                                    
                                    $obj->inserir($tabela, $campos);
                                    
                                    
                                }
                                
                            }
                            
                           
                 
                    
                    //Ruptura
                    $auditoria      =   (int)$arquivo                       ;
                    $dadosRupturas  =   $obj->retornaRupturas($auditoria)   ;
                    $rup = 0;
                    foreach($dadosRupturas  as $campos=>$valores)
                    {   
                        $codigoItem =   $valores['CodigoRMS']               ;                                            
                        //Ruptura Comercial
                        if($valores['Estoque']==0)
                        {
                            //Verifica se Receita
                            $cont       =   0   ;
                            $receita    =   $objORA->verificaReceita($codigoItem);
                            while ($row_ora = oci_fetch_assoc($receita)) { $cont++;}

                            if($cont>0)
                            {
                                $status =   9;                                
                            }else
                            {
                                $status =   7;
                            }

                        //Ruptura Loja    
                        }else
                        {
                            //Verifica se Receita
                            $cont       =   0   ;
                            $receita    =   $objORA->verificaReceita($codigoItem);
                            while ($row_ora = oci_fetch_assoc($receita)) { $cont++;}

                            if($cont>0)
                            {
                                $status =   9;
                            }else
                            {
                                $status =   8;
                            }                
                        }
                        
                        $tabela     =   "T094_auditoria_detalhes"                   ;
                        $campos     =   array("T105_status" => $status)             ;
                        $delim      =   "T093_codigo    =   $auditoria"             ;
                        $delim     .=   " AND T094_codigo_rms    =   $codigoItem"   ;                            
                        $delim     .=   " AND T093_tipo          =   'C'"           ;                            
                        $obj->altera($tabela, $campos, $delim);  
                        
                        $rup++;
                        
                        
                    }
                    
                     if($rup > 0) {
                                $obj->enviaEmailRuptInclusao($loja, $arquivo);}
                    
                }   
                
//                Move Arquivo para Diretório de Processados de acordo com o diretorio da loja
                if(rename($diretorioIMP.$arquivos, $diretorioPROC.$diretorioLoja.$arquivos))
                {
                    $arqs['Movidos'][$contador]    =   $arquivos;                    
                }else
                {
                    $arqs['Erro'][$contador]    =   $arquivos;
                }

            }    

        }        
        
        $contador++;  
        
    }
                    
    //Mensagens de Importação dos Arquivos
    $contMov    =   0;
    $contErr    =   0;
    foreach($arqs['Movidos'] as $valores)
    {
        $contMov++;
    }
    foreach($arqs['Erro'] as $valores)
    {
        $contErr++;
    }
    if ($contMov>0)
        echo "<script>show_stack_bottomleft(false, 'Alerta!', '".$contMov." arquivo(s) importado(s)!');</script>";
    if ($contErr>0)
        echo "<script>show_stack_bottomleft(true, 'Atenção!', '".$contErr." arquivo(s) não importado(s)!');</script>";
}

$retornaArquivos    =   $obj->retornaArquivos();

?>
<!-- jQuery do Programa T0093-->
<script type="text/javascript" src="template/js/interno/T0093/T0093.js"></script>

<!-- Divs com a barra de ferramentas -->
<div class="div-primaria caixa-de-ferramentas padding-padrao-vertical">
    <ul class="lista-horizontal">
        <li><a href="#"                     class="abrirFiltros botao-padrao">  <span class="ui-icon ui-icon-filter"  ></span>Filtros </a></li>
    </ul>
</div>

<!-- Divs com filt0ros oculta -->
<div class="div-primaria div-filtro">
    
    <form action="" method="post" class="div-filtro-visivel">
        
        <div class="conteudo-visivel padding-5px-vertical">

            <div class="padding-5px-vertical margin-padrao-vertical coluna c02_tipo_b_01">
                <input type="hidden" name="Import"   value="1"/>
                <input type="submit" class="botao-padrao" value="Importar Arquivos">
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
                    <p class="negrito texto-alinhado-esquerda">Departamento</p>
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
                    <p class="negrito texto-alinhado-esquerda">Dt. Início Importação</p>
                </div>
                
                <div class="coluna c09_tipo_a_08 margim-5px-horizontal">
                    <p class="negrito texto-alinhado-esquerda">Dt. Fim Importação</p>
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
                        <li><a href="?router=T0093/detalhes&codigoArquivo=<?php echo $valores['CodigoArquivo']?>"    title="Detalhes"><span class='ui-icon ui-icon-search'></span></a></li>
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




