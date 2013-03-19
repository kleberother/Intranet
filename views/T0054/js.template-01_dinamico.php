<?php
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 05/10/2011 por Jorge Nova                              
 * Descrição: Novo Template para template
 * Entrada:   
 * Origens:   
           
**************************************************************************
*/

// GRAVA SESSÃO DE UM USUÁRIO EM UMA VARIAVEL
$user       = $_SESSION['user'];

// INSTANCIA OBJETO DA CLASSE T0054
$obj        = new models_T0054();

//$PainelCod = 21;
$PainelCod  = $_GET['PainelCod'] ;

// Variavel para fazer quebra do Grupo
$GrupoAtual = 0 ;

// Controle de fotos no template
$CaminhoFotos   = CAMINHO_ARQUIVOS ; 
$CategoriaFotos = "CAT0014" ;
$FotoPadrao     = "../../template/img/photos.png";

//include 'js.precos.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta http-equiv="Refresh" content="<?php echo $TempoRefresh?>;?router=T0054/<?php echo $Origem?>"/>        
        <link href="template/css/estilo-painel.css" rel="stylesheet" type="text/css" />
        
        <script src="template/js/interno/jquery-1.6.1.min.js"></script>        
        
        <script src="template/js/display/jcarousellite_1.0.1.pack.js"></script>        
        <script src="template/js/display/jcarousellite_1.0.1c4.js"></script> 
        <script src="template/js/display/slides.min.jquery.js"></script> 
        <script src="template/js/display/painel-funcoes.js"></script> 
    </head>
    <body>
        <div id="logo-cabecalho">
        </div>        
        <div id="cabecalho">
            <div class="subconteudo">
                <p><?php echo $Titulo ; ?></p>
            </div>
        </div>
        <div id="conteudo">
            <div id="coluna-esquerda">
            <?php // definicao da Area do template
               // Área de lista de itens da esquerda, como tabela   
               $AreaCod  = 1 ;
            ?>                      
                <div id="tabela-dinamica">    
                    <div class="tabela-titulo">
                        <div class="overflow">
                            <div class="over-col-01-a">
                                <p>PRODUTO</p>
                            </div>
                            <div class="over-col-02-a">
                                <p>PREÇO (R$)</p>
                            </div>
                        </div>
                    </div>
                    <div class="tabela-conteudo">
                        <ul>
                        <?php // Retorna os produtos associados para a área
                        $ListaProdutos   = $obj->retornaProdutosAreaQuebraGrupo($PainelCod,$AreaCod);
                        
                        foreach($ListaProdutos as $campos=>$valores){ 
                           // verifica se houve quebra do Grupo
                           if($valores['Grupo']!=$GrupoAtual)
                           { 
                             // grava GrupoAtual 
                             $GrupoAtual = $valores['Grupo'];
                             // Retorna Descricao do Grupo
                             $Grupo = $obj->retornaDetalhesGrupo($valores['Depto'],$valores['Secao'],$valores['Grupo']);
                             
                             foreach($Grupo as $camposGrupo=>$valoresGrupo)
                             {
                                 $GrupoDescricao = $valoresGrupo['Descricao'];
                             }
                             
                             // imprime linha com titulo do Grupo
                            ?>
                            <li></li>
                            <li>
                                <div class="tc-titulo-sessao">
                                    <p><?php echo $GrupoDescricao; ?></p>
                                </div>
                            </li>    
                         <?php }
                                                
                         ?>
                            <li>
                                <?php
                                // verifica se é uma oferta
                                if( $valores['ValorPor'] != 0 )
                                {
                                 // faz as linhas zebradas
                                 if ($linha == "tc-linha-oferta-02")
                                     $linha = "tc-linha-oferta-01";
                                 else
                                     $linha = "tc-linha-oferta-02"; 
                                 
                                 // verifica quantos caracteres existe na string de descrição do produto
                                 $iProduto = strlen(trim($valores['DescCml']));
                                 $iProduto = intval($iProduto);
                                 if ($iProduto <= 16)
                                 {
                                   $classeDescricao = "descricao-01";
                                 }
                                 else if ($iProduto > 16 && $iProduto <= 19)
                                 {
                                   $classeDescricao = "descricao-02";  
                                 }
                                 else if ($iProduto > 19 && $iProduto <= 24)
                                 {
                                   $classeDescricao = "descricao-03";  
                                 }
                                 else if ($iProduto > 24 && $iProduto <= 27)
                                 {
                                   $classeDescricao = "descricao-04";  
                                 }
                                 else
                                   $classeDescricao = " ";    
                                 
                                 
                                ?>
                                <div class="<?php echo $linha; ?>">
                                    <div class="overflow">
                                        <div class="over-col-01-d">
                                            <p class="p-tabela <?php echo $classeDescricao; ?>"><?php echo $valores['DescCml']; ?></p>
                                        </div>                                        
                                        <div class="over-col-02-d"> 
                                            <p class="alinhamento-direita descricao-02"><?php echo number_format($valores['ValorDe'],2,","," "); ?></p>                                            
                                        </div>
                                    </div>
                                </div>
                                <?php
                                }
                                else
                                {
                                 // faz as linhas zebradas
                                 if ($linha == "tc-linha-zebra-02")
                                     $linha = "tc-linha-zebra-01";
                                 else
                                     $linha = "tc-linha-zebra-02";                                        
                                ?>
                                <div class="<?php echo $linha; ?>">
                                    <div class="overflow">
                                        <div class="over-col-01-d">
                                            <p class="p-tabela <?php echo $classeDescricao; ?>"><?php echo $valores['DescCml']; ?></p>
                                        </div>                                     
                                        <div class="over-col-02-d"> 
                                            <p class="alinhamento-direita descricao-02"><?php echo number_format($valores['ValorDe'],2,","," "); ?></p>                                            
                                        </div>
                                    </div>
                                </div>                                
                                <?php
                                }
                                ?>
                                <div class="clear"></div>
                            </li>
                        <?php } ?>                            
                        </ul>
                    </div>
                </div>
            </div>
            <div id="coluna-direita">
            <?php 
                //// definicao da Area do template
                // Painel Inferior da direita, com fotos
                $AreaCod  = 2 ;
            ?>    
                <div id="slides" class="slides">
                        <div class="slide-conteudo">
                            <?php 
                            $ListaProdutos   = $obj->retornaProdutosArea($PainelCod,$AreaCod);
                            foreach($ListaProdutos as $campos=>$valores){



                            $valorDe  = number_format($valores['ValorDe'],2,","," ");
                            $valorPor = number_format($valores['ValorPor'],2,","," ");

                            // formata valor por

                            $array_valorPor = explode(",",$valorPor);

                            $valorPorReal    = $array_valorPor[0];
                            $valorPorCentavo = $array_valorPor[1];

                            // formata valor de

                            $array_valorDe = explode(",",$valorDe);

                            $valorDeReal    = $array_valorDe[0];
                            $valorDeCentavo = $array_valorDe[1];                                    

                            // Marca foto padrão    
                            $CaminhoFoto = $FotoPadrao;                                     
                            // Recupera foto do Arquivo, se existir
                            $Foto = $obj->retornaCodigoFoto($valores['ItemCod'],$valores['ItemDig']);
                            foreach ($Foto as $camposFoto=>$valoresFoto)
                            {
                                $FotoCodigo = $valoresFoto['ArquivoCodigo'];
                                $CaminhoFoto = CAMINHO_ARQUIVOS.'/'.$CategoriaFotos.'/'.$obj->preencheZero("E", 8, $FotoCodigo);
                            }

                                ?>
                                <div class="slide">
                                    <div class="overflow">
                                        <div>
                                           <img src="<?php echo $CaminhoFoto; ?>" alt="" width="390px" height="295px" />
                                        </div>
                                    </div>
                                </div>
                            <?php }?>
                        </div>
                </div>  

            <?php // definicao da Area do template
                  // Painel Inferior da direita, com fotos
                  $AreaCod  = 3 ;
            ?>                        
            <div id="slides" class="slides">
                    <div class="slide-conteudo">
                        <?php 
                        $ListaProdutos   = $obj->retornaProdutosArea($PainelCod,$AreaCod);
                        foreach($ListaProdutos as $campos=>$valores){ 

                        $valorDe  = number_format($valores['ValorDe'],2,","," ");
                        $valorPor = number_format($valores['ValorPor'],2,","," ");

                        // formata valor por

                        $array_valorPor = explode(",",$valorPor);

                        $valorPorReal    = $array_valorPor[0];
                        $valorPorCentavo = $array_valorPor[1];

                        // formata valor de

                        $array_valorDe = explode(",",$valorDe);

                        $valorDeReal    = $array_valorDe[0];
                        $valorDeCentavo = $array_valorDe[1];
                        
                        // desconto de
                        $valorDesconto = $valores['ValorDe'] - $valores['ValorPor'];
                        $valorDesconto = number_format($valorDesconto,2,","," ");

                        // Marca foto padrão    
                        $CaminhoFoto = $FotoPadrao;                                     
                        // Recupera foto do Arquivo, se existir
                        $Foto = $obj->retornaCodigoFoto($valores['ItemCod'],$valores['ItemDig']);
                        foreach ($Foto as $camposFoto=>$valoresFoto)
                        {
                            $FotoCodigo = $valoresFoto['ArquivoCodigo'];
                            $CaminhoFoto = CAMINHO_ARQUIVOS.'/'.$CategoriaFotos.'/'.$obj->preencheZero("E", 8, $FotoCodigo);
                        }



                            ?>
                            <div class="slide">
                                <div class="overflow">
                                    <div class="over-col-01-c">
                                        <img src="<?php echo $CaminhoFoto; ?>" alt="" width="150px" height="295px" />
                                    </div>
                                    <div class="over-col-02-c">
                                        <div class="titulo-destaque"><?php echo $valores['DescCml']; ?></div>
                                        <?php
                                            if ($valorPor == 0)
                                            {
                                        ?>
                                        <p class="preco-a"><?php echo "<span class='Real'>".$valorDeReal."</span>,<span class='Centavo'>".$valorDeCentavo."</span>"; ?></p>                                                                                                  
                                        <?php
                                            }
                                            else
                                            {
                                        ?>                                                    
                                        <p class="preco-b">
                                        <?php echo "<span class='italico'>De ".$valorDe; ?><br/>
                                        <?php echo "Desconto de ".$valorDesconto."</span>"; ?><br/><br/>
                                        <?php echo "<span class='Vermelho'>= <span class='Real'>".$valorPorReal."</span>,<span class='Centavo'>".$valorPorCentavo."</span></span>"; ?>
                                        </p>                                                    
                                        <?php   
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        <?php }?>
                    </div>
                </div>
            </div>                
        </div>
        <div id="rodape">
            <div class="subconteudo">      
                <div class="overflow">
                    <div class="over-col-01-b">
                        <div class="logo-davo"></div>
                    </div>
                    <div class="over-col-02-b">
                        <p class="p-rodape"><?php echo $Rodape ; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

<?php
/* -------- Controle de versões - js.display-06.php --------------
 * 1.0.0 - 22/09/2011 - Jorge --> Liberada versao inicial
 * 1.0.1 - 05/10/2011 - Jorge --> Alteração do css do template
 *                                
 */
?>