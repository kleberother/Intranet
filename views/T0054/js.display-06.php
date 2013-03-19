<?php
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 22/09/2011 por Jorge Nova                              
 * Descrição: Novo Template para display
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
        <link href="template/css/estilo-display.css" rel="stylesheet" type="text/css" />
        
        <script src="template/js/interno/jquery-1.6.1.min.js"></script>        
        
        <script src="template/js/display/jcarousellite_1.0.1.pack.js"></script>        
        <script src="template/js/display/jcarousellite_1.0.1c4.js"></script> 
        <script src="template/js/display/slides.min.jquery.js"></script> 
        <script src="template/js/display/display-funcoes.js"></script> 
    </head>
    <body>
        <div id="cabecalho">
            <h1 class="titulo_display"><?php echo $Titulo ; ?></h1>
        </div>
        <div id="conteudo">
            <div class="subconteudo esquerdo sombra">
            <?php // definicao da Area do template
               // Área de lista de itens da esquerda, como tabela   
               $AreaCod  = 1 ;
            ?>                      
                <div id="tabela-dinamica">    
                    <div class="tabela-titulo">
                        <div class="overflow">
                            <div class="ov-esquerda">
                                <center><p>PRODUTO</p></center>
                            </div>
                            <div class="ov-direta">
                                <center><p>VALOR (R$)</p></center>
                            </div>
                        </div>
                    </div>
                    <div class="tabela-conteudo">
                        <ul style="width: 100%;">
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
                            <li class="linha-titulo">
                                <div class="overflow">
                                    <div>
                                        <p><?php echo $GrupoDescricao; ?></p>
                                    </div>
                                </div>
                            </li>                            
                         <?php }
                         if ($linha == "linha")
                             $linha = "linha-verde";
                         else
                             $linha = "linha";                            
                         ?>
                            <li class="<?php echo $linha; ?>">
                                <div class="overflow">
                                    <div class="ov-esquerda divlinha">
                                        <p><?php if($valores['ValorPor']!=0)
                                                    echo "<span>".$valores['DescCml']."</span><span class='oferta'></span>";
                                                else 
                                                    echo $valores['DescCml'];?></p>
                                                  
                                    </div>                                    
                                    <div class="ov-direita divlinha">
                                        <p>
                                        <?php 
                                            if($valores['ValorPor']!=0)
                                                echo "<span class='red amarelo'>".number_format($valores['ValorPor'],2,","," ")."</span>"; 
                                            else 
                                                echo number_format($valores['ValorDe'],2,","," ");

                                        ?>      
                                        </p>
                                    </div>
                                </div>
                                <div class="clear"></div>
                            </li>
                        <?php } ?>                            
                        </ul>
                    </div>
                </div>
            </div>
            <?php // definicao da Area do template
                  // Painel Superior da direita, com fotos
                  $AreaCod  = 2 ;
            ?>                  
            <div class="subconteudo direito sombra">
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
                                                <div class="ovslide-esquerda">
                                                   <img src="<?php echo $CaminhoFoto; ?>" alt="" width="312px" />
<!--                                                   <img src="../../template/img/carne.jpg" alt="" width="312px" />-->
                                                </div>
                                                <div class="ovslide-direita">
                                                    <div class="titulo-slide"><?php echo $valores['DescCml']; ?></div>
                                                    <?php
                                                        if ($valorPor == 0)
                                                        {
                                                    ?>
                                                    <p class="valorDe"><?php echo "<span class='valorDeReal'>".$valorDeReal.",</span><span class='valorDeCentavo'>".$valorDeCentavo."</span>"; ?></p>                                                                                                  
                                                    <?php
                                                        }
                                                        else
                                                        {
                                                    ?>                                                    
                                                    <p class="valorDesconto"><?php echo "De: ".$valorDe; ?></p>                                                    
                                                    <p class="valorPor"><?php echo "Por: <span class='valorPorReal'>".$valorPorReal.",</span><span class='valorPorCentavo'>".$valorPorCentavo."</span>"; ?></p>                                                                                                      
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
            <div class="subconteudo direito sombra">    
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
                                                <div class="ovslide-esquerda">
                                                    <img src="<?php echo $CaminhoFoto; ?>" alt="" width="312px" />
                                                </div>
                                                <div class="ovslide-direita">
                                                    <div class="titulo-slide"><?php echo $valores['DescCml']; ?></div>
                                                    <?php
                                                        if ($valorPor == 0)
                                                        {
                                                    ?>
                                                    <p class="valorDe"><?php echo "<span class='valorDeReal'>".$valorDeReal.",</span><span class='valorDeCentavo'>".$valorDeCentavo."</span>"; ?></p>                                                                                                  
                                                    <?php
                                                        }
                                                        else
                                                        {
                                                    ?>                                                    
                                                    <p class="valorDesconto"><?php echo "De: ".$valorDe; ?></p>                                                    
                                                    <p class="valorPor"><?php echo "Por: <span class='valorPorReal'>".$valorPorReal.",</span><span class='valorPorCentavo'>".$valorPorCentavo."</span>"; ?></p>                                                    
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
            <div class="rodape-conteudo">
                <p><?php echo $Rodape ; ?></p>
            </div>
        </div>
    </body>
</html>

<?php
/* -------- Controle de versões - js.display-06.php --------------
 * 1.0.0 - 22/09/2011 - Jorge --> Liberada versao inicial
 *                                
 */
?>