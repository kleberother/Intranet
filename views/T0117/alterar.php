<?php
/* * ************************************************************************
  Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 23/03/2013 Rodrigo Alfieri    
 * Descrição: Alterar RM
 * Entradas:   
 * Origens:   

 * *************************************************************************
 */

//Instancia Classe
$obj = new models_T0117();
$codRM = $_REQUEST["codRM"];
$user   =   $_SESSION["user"];

//$codRM  =    '4';

if (!empty($_POST)) {

    $tabela = "T113_requisicao_mudanca";

    $titulo             =   $_POST['T113_titulo'];
    $solicitante        =   $_POST['T004_solicitante'];
    $descricao          =   $_POST['T113_descricao'];
    $dt_inicio          =   $_POST['T113_dt_hr_inicio'] . " " . $_POST['hr_ini'] . ":00";
    $dt_fim             =   $_POST['T113_dt_hr_fim'] . " " . $_POST['hr_fim'] . ":00";
    $motivo             =   $_POST['T113_motivo'];
    $impacto            =   $_POST['T113_impacto'];
    $tempo_previsto     =   $_POST['T113_tempo_previsto'];
    $responsavel        =   $_POST["T004_responsavel"];
    $obs_contingencia   =   $_POST['T113_obs_contingencia'];
    $tempo_total        =   $_POST['T113_tempo_total'];
    $janela_disp        =   $_POST['T113_janela_disponivel'];
    $hora_total         =   $_POST["T113_hora_total"];
    $hora_disponivel    =   $_POST["T113_hora_disponivel"];
    $hora_prevista      =   $_POST["T113_hora_prevista"];


    $campos = array(
          "T113_titulo"                 => $titulo
        , "T113_descricao"              => $descricao
        , "T113_dt_hr_inicio"           => $dt_inicio
        , "T113_dt_hr_fim"              => $dt_fim
        , "T113_motivo"                 => $motivo
        , "T113_impacto"                => $impacto
        , "T113_tempo_previsto"         => $tempo_previsto
        , "T113_obs_contingencia"       => $obs_contingencia
        , "T113_tempo_total"            => $tempo_total
        , "T113_janela_disponivel"      => $janela_disp
        ,  "T113_hora_total"            => $hora_total
        ,  "T113_hora_prevista"         => $hora_prevista
        ,  "T113_hora_disponivel"       => $hora_disponivel    
    );

    $delim = "T113_codigo  = " . $codRM;

    $altera = $obj->altera($tabela, $campos, $delim);


    if ($altera)
        header('location:?router=T0117/home');
}

$retornaDados = $obj->retornaRM($titulo, $descricao, $solicitante, $codRM);



foreach ($retornaDados as $cpsRM => $vlrRM) {
    
   $statusRM    =   $vlrRM["StatusRM"];
    
    ?>

    <!-- Divs com a barra de ferramentas -->
    <div class="div-primaria caixa-de-ferramentas padding-padrao-vertical">
        <div class="push_9 conteudo_16">
            <ul class="lista-horizontal">
                <li><a href="?router=T0117/home" class="botao-padrao"><span class="ui-icon ui-icon-arrowthick-1-w"  ></span>Voltar  </a></li>
            </ul>
            <div class="push_7 grid_5">
                <label class="label">Requisição de Mudança - <?php echo $vlrRM["CodigoRM"]; ?> </label>
                
            </div>
        </div>
    </div>

    <div class="conteudo_16">

        <form action="" method="post" class="validaFormulario">

            <div class="clear10"></div>

            <div class="push_7 grid_6">
                <label class="label" style="color: blue;">Período Previsto para Requisição de Mudança</label>
            </div>

            <div class="clear"></div>

            <div class="grid_7">
                <label class="label">Título *</label>
                <input type="text" name="T113_titulo"   placeholder="Digite o título da requisição de mudança."    class="validate[required] form-input-text-table" value="<?php echo $vlrRM["TituloRM"]; ?>"       />            
            </div>

            <div style="position: absolute; top: 205px; left: 590px;">
                <label class="label">Data Inícial*</label>
                <input style="width: 65px"type="text" name="T113_dt_hr_inicio" class="validate[required]   "  id="dateCmp1" value="<?php echo $vlrRM["DataInicioRM"]; ?>"  />            
                <input style="width: 65px"type="hidden" name="dataHoje"  id="dataHoje" value="<?php echo date("d/m/Y"); ?>" />            
            </div>

            <div style="position: absolute; top: 205px; left: 665px;">
                <label class="label">Hora*</label>
                <select id="hr_ini" name="hr_ini" class="validate[required]">
    <?php if (!empty($vlrRM["HoraInicioRM"])) { ?>
                        <option><?php echo $vlrRM["HoraInicioRM"]; ?></option>
    <?php } ?>
    <?php $obj->comboHora(); ?>
                </select>       
            </div>

            <div style="position: absolute; top: 205px; left: 750px;">
                <label class="label">Data Final*</label>
                <input style="width: 65px" type="text" name="T113_dt_hr_fim"    class="validate[required] " value="<?php echo $vlrRM["DataFimRM"]; ?>"  id="dateCmp2" onBlur="validaData()" />            
            </div>

            <div style="position: absolute; top: 205px; left: 825px;">
                <label class="label">Hora*</label>
                <select id="hr_fim" name="hr_fim" class="validate[required]">
    <?php if (!empty($vlrRM["HoraFimRM"])) { ?>
                        <option><?php echo $vlrRM["HoraFimRM"]; ?></option>
    <?php } ?>
    <?php $obj->comboHora(); ?>
                </select>            
            </div>

            <div style="position: absolute; top: 205px; left: 900px;">
                <label class="label">Responsável da Requisição de Mudança*</label>
                <input style="width: 268px" type="text" class="buscaUsuario validate[required]"
                       readonly                    
                       name="T004_responsavel"
                       value   ="<?php echo $vlrRM["Responsavel"]; ?>"
                       />
            </div>

            <div class="clear"></div>

            <div class="grid_6">
                <label class="label">Descrição * </label>
                <textarea name="T113_descricao"   placeholder="Falta o Texto!"          class="validate[required] textarea-table" cols="122" rows="4" ><?php echo $vlrRM["DescricaoRM"]; ?></textarea>            
            </div>        

            <div class="clear"></div>

            <div style="position: absolute; top: 350px; left: 170px;">
                <label class="label">Qual a necessidade de mudança? *</label>
                <textarea style="width: 500px" name="T113_motivo"      placeholder="Falta o Texto!"       class="validate[required] textarea-table" cols="50" rows="4" ><?php echo $vlrRM["MotivoRM"]; ?></textarea>            
            </div>

            <div style="position: absolute; top: 350px; left: 680px;">
                <label class="label">Qual o impacto para o negocio? *</label>
                <textarea style="width: 500px" name="T113_impacto"     placeholder="Falta o Texto!"        class="validate[required] textarea-table" cols="47" rows="4" ><?php echo $vlrRM["ImpactoRM"]; ?></textarea>            
            </div>

            <br><br><br><br><br><br><br><br>
            <div class="grid_16">
                <div id="tabs">
                    <ul>
                        <li><a href="#tabs-1">Contingência</a></li>
                        <li><a href="#tabs-2">Executores Internos</a></li>
                        <li><a href="#tabs-3">Executores Externos</a></li>
                     <?php 
                        $CM =   $obj->retornaPerfil($user, 58);
                        $cmt = 0;
                        foreach ($CM as $cpPerCM => $vlPerCM) {
                            $cmt++;
                        }
                     if (($cmt != 0)&&($statusRM == 3)) {?>   <li><a href="#tabs-4">Comitê</a></li><?php }?>
                    </ul>
                    <div id="tabs-1">
                        <span class="form-input">
                            <div class="conteudo_16">                            
                                <div style="position: absolute; top: 60px; left: 7px;">
                                    <label class="label">Tempo:</label>
                                </div> 
                                <div style="position: absolute; top: 40px; left: 50px;">
                                    <label class="label">Contingência</label>
                                    <input style="width: 60px;" type="text" name="T113_tempo_previsto" placeholder="" id='tempoPrev' value ="<?php echo $vlrRM["TempoPrevisto"] ?>"
                                           onmouseover ='show_tooltip_alert("", "Tempo previsto para voltar para cenário anterior em minutos.", true);
                        tooltip.pnotify_display();'
                                           onmousemove ='tooltip.css({"top": event.clientY + 12, "left": event.clientX + 12});' 
                                           onmouseout  ='tooltip.pnotify_remove();'
                                           />
                                </div>
                                
                                <div style="position: absolute; top: 63px; left: 120px;">
                                    <input style="width: 60px;" type="text" name="T113_hora_prevista" placeholder="" value ="<?php echo $vlrRM["HoraPrevista"]?>" id='horaPrev'
                                           onmouseover ='show_tooltip_alert("", "Tempo previsto para voltar para cenário anterior em horas.", true);
                        tooltip.pnotify_display();'
                                           onmousemove ='tooltip.css({"top": event.clientY + 12, "left": event.clientX + 12});' 
                                           onmouseout  ='tooltip.pnotify_remove();'
                                           readonly
                                           />
                                </div>

                                <div style="position: absolute; top: 40px; left: 210px;">
                                    <label class="label">Disponível</label>
                                    <input style="width: 60px"type="text" name="T113_janela_disponivel" placeholder="" value="<?php echo $vlrRM["JanelaDisp"]; ?>" id='tempoDisp' 
                                           onmouseover ='show_tooltip_alert("", "Janela disponível para praticar a mudança em minutos.", true);
                                          tooltip.pnotify_display();'
                                           onmousemove ='tooltip.css({"top": event.clientY + 12, "left": event.clientX + 12});' 
                                           onmouseout  ='tooltip.pnotify_remove();'/>
                                </div>
                                
                                <div style="position: absolute; top: 63px; left: 280px;">
                                    <input style="width: 60px"type="text" name="T113_hora_disponivel" placeholder="" value="<?php echo $vlrRM["HoraDisponivel"]; ?>" id='horaDisp' readonly
                                           onmouseover ='show_tooltip_alert("", "Janela disponível para praticar a mudança em horas.", true);
                                          tooltip.pnotify_display();'
                                           onmousemove ='tooltip.css({"top": event.clientY + 12, "left": event.clientX + 12});' 
                                           onmouseout  ='tooltip.pnotify_remove();'/>
                                </div>

                                <div style="position: absolute; top: 40px; left: 370px;">
                                    <label class="label">Total</label>
                                    <input style="width: 60px" type="text" name="T113_tempo_total" placeholder="" id="tempoTotal" readonly value="<?php echo $vlrRM["TempoTotal"]; ?>"
                                           onmouseover ='show_tooltip_alert("", "Tempo total para realizar a mudança em minutos.", true);
                                          tooltip.pnotify_display();'
                                           onmousemove ='tooltip.css({"top": event.clientY + 12, "left": event.clientX + 12});' 
                                           onmouseout  ='tooltip.pnotify_remove();'/>
                                </div> 
                                
                                <div style="position: absolute; top: 63px; left: 440px;">
                                    <input style="width: 60px" type="text" name="T113_hora_total" placeholder="" id="horasTotal" readonly value="<?php echo $vlrRM["HoraTotal"]; ?>" 
                                           onmouseover ='show_tooltip_alert("", "Tempo total para realizar a mudança em horas.", true);
                                          tooltip.pnotify_display();'
                                           onmousemove ='tooltip.css({"top": event.clientY + 12, "left": event.clientX + 12});' 
                                           onmouseout  ='tooltip.pnotify_remove();'/>
                                </div> 
                                <br><br><br><br><br>

                                <div class="clear"></div>

                                <div class="grid_7">
                                    <label class="label">Executores Contingência</label>
                                    <input type="text" name="" class="buscaUsuario" id="txtExeCont" 
                                           onmouseover ='show_tooltip_alert("", "Digite o nome ou Login do Colaborador, selecione na lista e clique em adicionar.", true);
                        tooltip.pnotify_display();' 
                                           onmousemove ='tooltip.css({"top": event.clientY + 12, "left": event.clientX + 12});' 
                                           onmouseout  ='tooltip.pnotify_remove();'                                       
                                           />
                                </div>                            

                                <div class="grid_1">   
                                    <label style="position: absolute; left: 439px;" class="label">Adicionar</label>
                                    <input style="position: absolute; top: 119px;" type="button" value="+" id="btnAddCont"/>
                                </div>                            
                                <div class="clear"></div>
    <?php $retExeCont = $obj->retornaExecutoresCont($codRM); ?>
                                <div class="grid_7">
                                    <label class="label">Executores</label>
                                    <select name="ExeCont[]" multiple id="cmbExeCont">
                                <?php foreach ($retExeCont as $cpsExeCont => $vlrExCont) { ?>
                                            <option value="<?php echo $vlrExCont["Login"]; ?>"> <?php echo $vlrExCont["Nome"]; ?> </option>
    <?php } ?>
                                    </select>
                                    *Clique em cima do Executor para exclui-lo da lista.
                                </div>                               

                                <div style="position: absolute; top: 30px; left: 515px">
                                    <label class="label">Observação Contingência</label>
                                    <textarea style="height: 185px" name="T113_obs_contingencia"    placeholder="Observação da contingência"         class="textarea-table" cols="150" rows="10" ><?php echo $vlrRM["ObsContingencia"]; ?></textarea>            
                                </div>                            

                            </div>
                        </span>
                    </div>
                    <div id="tabs-2">
                        <div >
                            <label class="label">Executor da Requisição de Mudança (Interno)*</label>
                            <input style="width: 250px" type="text" class="buscaUsuario" id="txtExeInt"
                                   onmouseover ='show_tooltip_alert("", "Digite o nome do Colaborador, selecione na lista e clique em adicionar.", true);
                        tooltip.pnotify_display();' 
                                   onmousemove ='tooltip.css({"top": event.clientY + 12, "left": event.clientX + 12});' 
                                   onmouseout  ='tooltip.pnotify_remove();'     
                                   />
                        </div>
                        <div style="position: absolute; top: 44px; left: 275px">      
                            <label class="label">Adicionar</label>
                            <input type="button" value="+" id="btnAddExeInt"/>
                        </div>
    <?php $retExeIntRM = $obj->retornaExecutoresRM($codRM); ?>
                        <div style="top: 84px; left: 275px">
                            <label class="label">Executores Internos</label>
                            <select style="width: 250px" name="T004_login[]" multiple id="cmbExeInt" >
                        <?php foreach ($retExeIntRM as $cpsExIn => $vlrExInt) { ?>
                                    <option value="<?php echo $vlrExInt["Login"] ?>"><?php echo $vlrExInt["Nome"]; ?></option>
    <?php } ?>    
                            </select>
                            *Clique em cima do Executor para exclui-lo da lista.
                        </div>

                    </div>
                    <div id="tabs-3">
                         <div >
                <label class="label">Nome</label>
                <input style="width: 250px" type="text" id="txtNomeExt"/>
            </div>

            <div style="position: absolute; top: 44px; left: 275px">
                <label class="label">E-mail</label>
                <input style="width: 250px" type="text" id="txtEmailExt"/>
            </div>

            <div style="position: absolute; top: 44px; left: 534px">
                <label class="label">Telefone</label>
                <input style="width: 100px" type="text" id="txtFoneExt" class="fone"/>
            </div>

            <div style="position: absolute; top: 44px; left: 650px">
                <label class="label">Notificado</label>
                <div id="radio" >
                    <input type="radio" id="radio1" name="T113_resp_notificado" value="S"                    class="validate[required]" /><label for="radio1">Sim</label>
                    <input type="radio" id="radio2" name="T113_resp_notificado" value="N" checked="checked"  class="validate[required]" /><label for="radio2">Não</label>
                </div>            
            </div>                

            <div style="position: absolute; top: 44px; left: 735px">      
                <label class="label">Adicionar</label>
                <input type="button" value="+" id="btnAddExeExt"/>
            </div>    
                        <?php $retExecExternoRM = $obj->retornaExecExternoRM($codRM); ?>
            <div style=" top: 55px; left: 0px">
                <label class="label">Executores Externos</label>
                <select style="width: 625px;" name="ExeExt[]" multiple id="cmbExeExt" readonly>
            <?php foreach ($retExecExternoRM as $cpsExtRm => $vlrExtRM) { ?>
                        <option value="<?php echo $vlrExtRM['Nome'] . "|" . $vlrExtRM['Telefone'] . "|" . $vlrExtRM['Email'] . "|" . $vlrExtRM['Notificado'] ?>">
        <?php echo $vlrExtRM['Nome'] . "|" . $vlrExtRM['Telefone'] . "|" . $vlrExtRM['Email'] . "|" . $vlrExtRM['Notificado'] ?>
                        </option>
                    <?php } ?>    
                </select>
                *Clique em cima do Executor para exclui-lo da lista.
            </div> 

                    </div>
                    <?php 
                 if(($cmt   !=  0) && ($statusRM == 3)){?>
                    <div id="tabs-4">
                        <div >
                            <label class="label">Comitê</label>
                            <input style="width: 250px" type="text" class="buscaUsuario" id="txtComite"
                                   onmouseover ='show_tooltip_alert("", "Digite o nome do Colaborador, selecione na lista e clique em adicionar.", true);
                        tooltip.pnotify_display();' 
                                   onmousemove ='tooltip.css({"top": event.clientY + 12, "left": event.clientX + 12});' 
                                   onmouseout  ='tooltip.pnotify_remove();'     
                                   />
                        </div>
                        <div style="position: absolute; top: 44px; left: 330px">
                                <label class="label">Aprovado</label>
                                <div id="radioC">
                                    <input type="radio" id="radio3" name="T113_aprovado" value="S"                    class="validate[required]" /><label for="radio3">Sim</label>
                                    <input type="radio" id="radio4" name="T113_aprovado" value="N" checked="checked"  class="validate[required]" /><label for="radio4">Não</label>
                                </div>            
                            </div>
                        <div style="position: absolute; top: 44px; left: 450px;">
                                <label class="label">Parecer</label>
                                <textarea style="width: 250px" name="T113_justificativa" id='txtJustComite'    placeholder="Falta o Texto!"        class="validate[required] textarea-table" cols="47" rows="4" ></textarea>            
                        </div>
                        <div style="position: absolute; top: 44px; left: 750px">      
                                <label class="label">Adicionar</label>
                                <input type="button" value="+" id="btnAddComite"/>
                        </div>   <br><br><br>
                        <div style="position: static; top: 500px; left: auto; ">
                            <label class="label">Membros do Comitê</label>
                            <?php $retComiteRM = $obj->retornaComiteRM($codRM);?>
                            <select style="width: 950px" name="T004_login[]" multiple id="cmbComite" >
                        <?php foreach ($retComiteRM as $cpsComt => $vlrComt) { ?>
                                    <option value="<?php echo $vlrComt["Login"] ?>"><?php echo $vlrComt["Nome"]." | ".$vlrComt["Aprovado"]." | ".$vlrComt["Justificativa"]; ?></option>
    <?php } ?>    
                            </select><br>
                            *Clique em cima do Executor para exclui-lo da lista.
                        </div>
                    </div> <?php }?>
                </div>       

            </div>   


           
            <div class="clear"></div>



    

            <div class="clear10"></div>

            <!--        <div class="grid_2">
                        <label class="label">Prioridade *</label>
                        <input type="text" name=""          />            
                    </div>-->

            <div class="clear"></div>

            <div class="grid_2">
                <?php 
                $GM = $obj->retornaPerfil($user, 59);
                $rev = 0;
                foreach ($GM as $cmpPerf => $vlrPerf) {
                    $rev++;
                }
                if(($statusRM == 1) && ($rev != 0)){ ?>
                <input type='checkbox' id='revisado' name='revisado' value='1'/><label for='revisado'>Revisado</label> 
                <?php }?>
                <input type="hidden" value="<?php echo $codRM; ?>" id="codRM">
                <input type="submit" value="Atualizar" class="botao-padrao" >
            </div>

        </form>

<?php } ?>

</div>