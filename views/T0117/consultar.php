<?php
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 20/03/2013 Roberta Schimidt    
 * Descrição: Nova RM
 * Entradas:   
 * Origens:   
           
**************************************************************************
*/

//Instancia Classe
$obj                =   new models_T0117();
$codRM              =   $_REQUEST["codRM"];

//$codRM  =    '4';



$retornaDados   =   $obj->retornaRM($titulo, $descricao, $solicitante, $codRM);



foreach ($retornaDados as $cpsRM => $vlrRM){
?>

<!-- Divs com a barra de ferramentas -->
<div class="div-primaria caixa-de-ferramentas padding-padrao-vertical">
    <div class="push_9 conteudo_16">
          <ul class="lista-horizontal">
            <li><a href="?router=T0117/home" class="botao-padrao"><span class="ui-icon ui-icon-arrowthick-1-w"  ></span>Voltar  </a></li>
        </ul>
        <div class="push_7 grid_5">
            <label class="label">Requisição de Mudança - <?php echo $vlrRM["CodigoRM"];?> </label>
        </div>
    </div>
</div>

<div class="conteudo_16">
    
        <div class="clear10"></div>

        <div class="push_7 grid_6">
            <label class="label" style="color: blue;">Período Previsto para Requisição de Mudança</label>
        </div>

        <div class="clear"></div>

        <div class="grid_7">
            <label class="label">Título *</label>
            <label><?php echo $vlrRM["TituloRM"];?></label>            
        </div>

         <div style="position: absolute; top: 205px; left: 590px;">
            <label class="label">Data Inícial*</label>
            <label><?php echo $vlrRM["DataInicioRM"] ;?>  </label>            
        </div>

        <div style="position: absolute; top: 205px; left: 665px;">
            <label class="label">Hora*</label>
            <label> <?php echo $vlrRM["HoraInicioRM"];?></label>
        </div>

         <div style="position: absolute; top: 205px; left: 750px;">
            <label class="label">Data Final*</label>
            <label> <?php echo $vlrRM["DataFimRM"] ;?></label>            
        </div>

        <div style="position: absolute; top: 205px; left: 825px;">
            <label class="label">Hora*</label>
            <label> <?php echo $vlrRM["HoraFimRM"];?></label>
        </div>

        <div style="position: absolute; top: 205px; left: 900px;">
            <label class="label">Responsável da Requisição de Mudança*</label>
            <label><?php echo $vlrRM["Responsavel"];?></label>
        </div>

        <div class="clear10"></div>

        <div class="grid_6">
            <label class="label">Descrição * </label>
            <label><?php echo $vlrRM["DescricaoRM"];?></label>            
        </div>        

        <div class="clear"></div>

        <div style="position: absolute; top: 350px; left: 170px;">
            <label class="label">Qual a necessidade de mudança? *</label>
            <label><?php echo $vlrRM["MotivoRM"];?></label>            
        </div>

        <div style="position: absolute; top: 350px; left: 680px;">
            <label class="label">Qual o impacto para o negocio? *</label>
            <label><?php echo $vlrRM["ImpactoRM"];?></label>            
        </div>

        <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
        <div class="grid_16">
            <div id="tabs">
                <ul>
                    <li><a href="#tabs-1">Contingência</a></li>
                </ul>
                <div id="tabs-1">
                    <span class="form-input">
                        <div class="conteudo_16">                            
                            <div style="position: absolute; top: 60px; left: 7px;">
                                <label class="label">Tempo:</label>
                            </div> 
                            <div style="position: absolute; top: 40px; left: 50px;">
                                <label class="label">Contingência</label>
                                <label style="text-align: center;"><?php echo $vlrRM["TempoPrevisto"]?></label>
                            </div>   
                            
                            <div style="position: absolute; top: 40px; left: 150px;">
                                <label class="label">Disponível</label>
                                <label style="text-align: center;"><?php echo $vlrRM["JanelaDisp"] ;?></label>
                            </div>
                            
                            <div style="position: absolute; top: 40px; left: 250px;">
                                <label class="label">Total</label>
                                <label><?php echo $vlrRM["TempoTotal"] ;?></label>
                            </div> 
                            <br><br><br><br><br>
                            
                            <div class="clear"></div>

                                                      
                            <div class="clear"></div>
<?php $retExeCont   =   $obj->retornaExecutoresCont($codRM);?>
                            <div class="grid_7">
                                <label class="label">Executores</label>
                                <select  multiple >
                                    <?php foreach ($retExeCont as $cpsExeCont => $vlrExCont) {?>
                                    <option value="<?php echo $vlrExCont["Login"];?>"> <?php echo $vlrExCont["Nome"];?> </option>
                                    <?php }?>
                                </select>
                            </div>

                            <div style="position: absolute; top: 30px; left: 500px">
                                <label class="label">Observação Contingência</label>
                                <label><?php echo $vlrRM["ObsContingencia"];?></label>            
                            </div>                            

                        </div>
                    </span>
                </div>
            </div>                                                            
        </div>             

        <div class="clear"></div>

       

      <?php $retExeIntRM  =   $obj->retornaExecutoresRM($codRM);?>
        <div class="grid_6">
            <label class="label">Executores Internos</label>
            <select  multiple  >
                <?php foreach ($retExeIntRM as $cpsExIn => $vlrExInt) { ?>
                <option value="<?php echo $vlrExInt["Login"]?>"><?php echo $vlrExInt["Nome"];?></option>
                <?php }?>    
            </select>
            
        </div>
        
        <?php $retExecExternoRM =   $obj->retornaExecExternoRM($codRM);?>
        <div class="push_2 grid_7">
            <label class="label">Executores Externos</label>
            <select multiple readonly>
            <?php foreach ($retExecExternoRM as $cpsExtRm => $vlrExtRM) {?>
                <option value="<?php echo $vlrExtRM['Nome']."|".$vlrExtRM['Telefone']."|".$vlrExtRM['Email']."|".$vlrExtRM['Notificado']?>">
                    <?php echo $vlrExtRM['Nome']."|".$vlrExtRM['Telefone']."|".$vlrExtRM['Email']."|".$vlrExtRM['Notificado']?>
                </option>
            <?php }?>    
            </select>
          
        </div> 
            
    
    
<?php }?>
    
</div>