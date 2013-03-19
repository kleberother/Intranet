<?php
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 14/02/2013 Rodrigo Alfieri    
 * Descrição: Nova RM
 * Entradas:   
 * Origens:   
           
**************************************************************************
*/

//Instancia Classe
$obj                =   new models_T0117();
$codRM              =   $_REQUEST["codRM"];

//$codRM  =    '4';

if (!empty($_POST))
{       
    
    $tabela =   "T113_requisicao_mudanca";
    
    $titulo             =   $_POST['T113_titulo']                                   ;
    $solicitante        =   $_SESSION['user']                                       ;
    $data               =   date("d/m/Y h:i:s")                                     ;
    $descricao          =   $_POST['T113_descricao']                                ;
    $dt_inicio          =   $_POST['T113_dt_hr_inicio']." ".$_POST['hr_ini'].":00"  ;
    $dt_fim             =   $_POST['T113_dt_hr_fim']." ".$_POST['hr_fim'].":00"     ;
    $motivo             =   $_POST['T113_motivo']                                   ;
    $impacto            =   $_POST['T113_impacto']                                  ;    
    $tempo_previsto     =   $_POST['T113_tempo_previsto']                           ;    
    $responsavel        =   $_POST["T004_responsavel"]                              ;
    $obs_contingencia   =   $_POST['T113_obs_contingencia']                         ;
    $status             =   1;                                                  //Status 1 = Aberta

    
    $campos =   array(
                        "T004_solicitante"      => $solicitante
                     ,  "T113_data"             => $data
                     ,  "T113_titulo"           => $titulo
                     ,  "T113_descricao"        => $descricao
                     ,  "T113_dt_hr_inicio"     => $dt_inicio
                     ,  "T113_dt_hr_fim"        => $dt_fim
                     ,  "T113_motivo"           => $motivo
                     ,  "T113_impacto"          => $impacto
                     ,  "T113_tempo_previsto"   => $tempo_previsto
                     ,  "T113_obs_contingencia" => $obs_contingencia
                     ,  "T004_responsavel"      => $responsavel
                     ,  "T113_status"           => $status
                     );
    
    $delim  =   "T113_codigo  = ".$codRM; 
    
    $altera     =   $obj->altera($tabela, $campos, $delim);
    
    
    if($altera)
        header('location:?router=T0117/home');    
    
    


}

$retornaDados   =   $obj->retornaRM($titulo, $descricao, $solicitante, $codRM);



foreach ($retornaDados as $cpsRM => $vlrRM){
?>

<!-- Divs com a barra de ferramentas -->
<div class="div-primaria caixa-de-ferramentas padding-padrao-vertical">
    <ul class="lista-horizontal">
        <li><a href="?router=T0117/home" class="botao-padrao"><span class="ui-icon ui-icon-arrowthick-1-w"  ></span>Voltar  </a></li>
    </ul>
</div>

<div class="conteudo_16">
    
    <form action="" method="post" class="validaFormulario">
        
        <div class="clear10"></div>

        <div class="push_11 grid_2">
            <label class="label" style="color: blue;">Período Previsto</label>
        </div>

        <div class="clear"></div>

        <div class="grid_7">
            <label class="label">Título *</label>
            <input type="text" name="T113_titulo"   placeholder="Digite o título da requisição de mudança."    class="validate[required] form-input-text-table" value="<?php echo $vlrRM["TituloRM"];?>"       />            
        </div>

        <div class="grid_3">
            <label class="label">Data Inícial Prevista*</label>
            <input type="text" name="T113_dt_hr_inicio" class="validate[required] data"  id="dateCmp1"  value="<?php echo $vlrRM["DataInicioRM"] ;?>" />            
        </div>

        <div class="grid_2">
            <label class="label">Hora*</label>
            <select name="hr_ini" class="validate[required]">
                <?php if (!empty($vlrRM["HoraInicioRM"])){?>
                        <option><?php echo $vlrRM["HoraInicioRM"];?></option>
                <?php }?>
                <?php $obj->comboHora();?>
            </select>       
        </div>

        <div class="grid_3">
            <label class="label">Data Final Prevista*</label>
            <input type="text" name="T113_dt_hr_fim"    class="validate[required] data"  id="dateCmp2"  value="<?php echo $vlrRM["DataFimRM"] ;?>"  />            
        </div>

        <div class="grid_2">
            <label class="label">Hora*</label>
            <select name="hr_fim" class="validate[required]">
            <?php if (!empty($vlrRM["HoraFimRM"])){?>
                    <option><?php echo $vlrRM["HoraFimRM"];?></option>
                <?php }?>
                <?php $obj->comboHora();?>
            </select>            
        </div>

        <div class="clear"></div>

        <div class="grid_6">
            <label class="label">Descrição * </label>
            <textarea name="T113_descricao"   placeholder="Falta o Texto!"          class="validate[required] textarea-table" cols="122" rows="4"  ><?php echo $vlrRM["DescricaoRM"];?></textarea>            
        </div>        

        <div class="clear"></div>

        <div class="grid_4">
            <label class="label">Motivo *</label>
            <textarea name="T113_motivo"      placeholder="Falta o Texto!"       class="validate[required] textarea-table" cols="122" rows="4" ><?php echo $vlrRM["MotivoRM"];?></textarea>            
        </div>

        <div class="clear"></div>

        <div class="grid_4">
            <label class="label">Impacto *</label>
            <textarea name="T113_impacto"     placeholder="Falta o Texto!"        class="validate[required] textarea-table" cols="122" rows="4" ><?php echo $vlrRM["ImpactoRM"];?></textarea>            
        </div>

        <div class="clear"></div>

        <div class="grid_16">
            <div id="tabs">
                <ul>
                    <li><a href="#tabs-1">Contingência</a></li>
                </ul>
                <div id="tabs-1">
                    <span class="form-input">
                        <div class="conteudo_16">                            

                            <div class="grid_4">
                                <label class="label">Tempo Previsto Contingência</label>
                                <input type="text" name="T113_tempo_previsto" placeholder="" value ="<?php echo $vlrRM["TempoPrevisto"]?>"/>
                            </div>   

                            <div class="clear"></div>

                            <div class="grid_4">
                                <label class="label">Executores Contingência</label>
                                <input type="text" name="" class="buscaUsuario" id="txtExeCont" 
                                        onmouseover ='show_tooltip_alert("","Digite o nome do Colaborador, selecione na lista e clique em adicionar.", true);tooltip.pnotify_display();' 
                                        onmousemove ='tooltip.css({"top": event.clientY+12, "left": event.clientX+12});' 
                                        onmouseout  ='tooltip.pnotify_remove();'                                       
                                />
                            </div>                            

                            <div class="grid_1">   
                                <label class="label">Adicionar</label>
                                <input type="button" value="+" id="btnAddCont"/>
                            </div>                            
<?php $retExeCont   =   $obj->retornaExecutoresCont($codRM);?>
                            <div class="grid_4">
                                <label class="label">Executores</label>
                                <select name="ExeCont[]" multiple id="cmbExeCont">
                                    <?php foreach ($retExeCont as $cpsExeCont => $vlrExCont) {?>
                                    <option value="<?php echo $vlrExCont["Login"];?>"> <?php echo $vlrExCont["Nome"];?> </option>
                                    <?php }?>
                                </select>
                                *Clique em cima do Executor para exclui-lo da lista.
                            </div>                               

                            <div class="clear"></div>

                            <div class="grid_11">
                                <label class="label">Observação Contingência</label>
                                <textarea name="T113_obs_contingencia"    placeholder="Observação da contingência"         class="textarea-table" cols="150" rows="3" ><?php echo $vlrRM["ObsContingencia"];?></textarea>            
                            </div>                            

                        </div>
                    </span>
                </div>
            </div>                                                            
        </div>             

        <div class="clear"></div>

        <div class="grid_5">
            <label class="label">Responsável da Requisição de Mudança*</label>
            <input type="text" class="buscaUsuario validate[required]"
                    onmouseover ='show_tooltip_alert("","Digite o nome do Colaborador e selecione na lista.", true);tooltip.pnotify_display();' 
                    onmousemove ='tooltip.css({"top": event.clientY+12, "left": event.clientX+12});' 
                    onmouseout  ='tooltip.pnotify_remove();'                    
            
                    name="T004_responsavel"
                    
                    value   ="<?php echo $vlrRM["Responsavel"];?>"
            />
        </div>

        <div class="clear10"></div> 

        <div class="grid_5">
            <label class="label">Executor da Requisição de Mudança (Interno)*</label>
            <input type="text" class="buscaUsuario" id="txtExeInt"
                   onmouseover ='show_tooltip_alert("","Digite o nome do Colaborador, selecione na lista e clique em adicionar.", true);tooltip.pnotify_display();' 
                   onmousemove ='tooltip.css({"top": event.clientY+12, "left": event.clientX+12});' 
                   onmouseout  ='tooltip.pnotify_remove();'     
            />
        </div>

        <div class="push_5 grid_1">      
            <label class="label">Adicionar</label>
            <input type="button" value="+" id="btnAddExeInt"/>
        </div>          
<?php $retExeIntRM  =   $obj->retornaExecutoresRM($codRM);?>
        <div class="push_5 grid_4">
            <label class="label">Executores Internos</label>
            <select name="T004_login[]" multiple id="cmbExeInt" >
                <?php foreach ($retExeIntRM as $cpsExIn => $vlrExInt) { ?>
                <option value="<?php echo $vlrExInt["Login"]?>"><?php echo $vlrExInt["Nome"];?></option>
                <?php }?>    
            </select>
            *Clique em cima do Executor para exclui-lo da lista.
        </div>

        <div class="clear"></div>

        <div class="grid_4">
            <label class="label">Executor RM Externo</label>
        </div>

        <div class="clear"></div>

        <div class="grid_3">
            <label class="label">Nome</label>
            <input type="text" id="txtNomeExt"/>
        </div>

        <div class="grid_2">
            <label class="label">E-mail</label>
            <input type="text" id="txtEmailExt"/>
        </div>

        <div class="grid_2">
            <label class="label">Telefone</label>
            <input type="text" id="txtFoneExt" class="fone"/>
        </div>

        <div class="grid_3">
            <label class="label">Notificado</label>
            <div id="radio">
                    <input type="radio" id="radio1" name="T113_resp_notificado" value="S"                    class="validate[required]" /><label for="radio1">Sim</label>
                    <input type="radio" id="radio2" name="T113_resp_notificado" value="N" checked="checked"  class="validate[required]" /><label for="radio2">Não</label>
            </div>            
        </div>                

        <div class="grid_1">      
            <label class="label">Adicionar</label>
            <input type="button" value="+" id="btnAddExeExt"/>
        </div>            
<?php $retExecExternoRM =   $obj->retornaExecExternoRM($codRM);?>
        <div class="grid_6">
            <label class="label">Executores Externos</label>
            <select name="ExeExt[]" multiple id="cmbExeExt" readonly>
            <?php foreach ($retExecExternoRM as $cpsExtRm => $vlrExtRM) {?>
                <option value="<?php echo $vlrExtRM['Nome']."|".$vlrExtRM['Telefone']."|".$vlrExtRM['Email']."|".$vlrExtRM['Notificado']?>">
                    <?php echo $vlrExtRM['Nome']."|".$vlrExtRM['Telefone']."|".$vlrExtRM['Email']."|".$vlrExtRM['Notificado']?>
                </option>
            <?php }?>    
            </select>
            *Clique em cima do Executor para exclui-lo da lista.
        </div>                

        <div class="clear10"></div>

<!--        <div class="grid_2">
            <label class="label">Prioridade *</label>
            <input type="text" name=""          />            
        </div>-->

        <div class="clear"></div>

        <div class="grid_2">
            <input type="hidden" value="<?php echo $codRM;?>" id="codRM">
            <input type="submit" value="Atualizar" class="botao-padrao" >
        </div>
            
    </form>
    
<?php }?>
    
</div>