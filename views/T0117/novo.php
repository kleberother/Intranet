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
    $arrResp            =   explode("-",$_POST['T004_responsavel'])                 ;    
    $responsavel        =   str_replace(" ", "", $arrResp[1])                   ;
    $obs_contingencia   =   $_POST['T113_obs_contingencia']                         ;
    $status             =   1;                                                  //Status 1 = Aberta
//    $prioridade         =   $_POST['T113_'];
    
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
    
    $insere     =   $obj->inserir($tabela, $campos);
    
    $codigoRM  =   $obj->lastInsertId();
    
    //Executores Contingencia
    $usuariosContingencia   =   $_POST['ExeCont'];
    
    foreach($usuariosContingencia   as $campos  =>  $valores)
    {
        $tabela     =   "T004_T113";
        
        $user       =   $valores;
        $dadosUser  =   $obj->retornaDadosUsuario($user);
        
        foreach($dadosUser as $cp   =>  $vl)
        {
            $nomeUsuario    =   $vl['NomeUsuario'];
            $emailUsuario   =   $vl['EmailUsuario'];
        }
                
        $campos =   array(
                            "T113_codigo"           =>  $codigoRM
                         ,  "T004_login"            =>  $valores
                         ,  "T004_T113_nome"        =>  $nomeUsuario
                         ,  "T004_T113_email"       =>  $emailUsuario
                         ,  "T004_T113_telefone"    =>  ""
                         ,  "T004_T113_notificado"  =>  ""
                         ,  "T004_T113_tipo"        =>  2               //Tipo 1 = Responsaveis RM
                         );
        
        $insere     =   $obj->inserir($tabela, $campos);
        
    }    
    
    
    //Executores RM
    $usuariosInterno   =   $_POST['T004_login'];
    
    foreach($usuariosInterno   as $campos  =>  $valores)
    {
        $tabela     =   "T004_T113";
        
        $user       =   $valores;
        $dadosUser  =   $obj->retornaDadosUsuario($user);
        
        foreach($dadosUser as $cp   =>  $vl)
        {
            $nomeUsuario    =   $vl['NomeUsuario'];
            $emailUsuario   =   $vl['EmailUsuario'];
        }
                
        $campos =   array(
                            "T113_codigo"           =>  $codigoRM
                         ,  "T004_login"            =>  $valores
                         ,  "T004_T113_nome"        =>  $nomeUsuario
                         ,  "T004_T113_email"       =>  $emailUsuario
                         ,  "T004_T113_telefone"    =>  ""
                         ,  "T004_T113_tipo"        =>  1               //Tipo 1 = Responsaveis RM
                         );
        
        $insere     =   $obj->inserir($tabela, $campos);
        
    }
    
    //Executores Externo RM
    $usuariosExterno   =   $_POST['ExeExt'];
    
    foreach($usuariosExterno   as $campos  =>  $valores)
    {
        $tabela         =   "T004_T113";
        
        $strUserExt     =   explode("|", $valores);
        
        $nomeExterno    =   $strUserExt[0];
        $foneExterno    =   $strUserExt[1];
        $emailExterno   =   $strUserExt[2];
        $notificado     =   $strUserExt[3];
                
        $campos =   array(
                            "T113_codigo"           =>  $codigoRM
                         ,  "T004_T113_nome"        =>  $nomeExterno
                         ,  "T004_T113_email"       =>  $emailExterno
                         ,  "T004_T113_telefone"    =>  $foneExterno
                         ,  "T004_T113_notificado"  =>  $notificado
                         ,  "T004_T113_tipo"        =>  3               //Tipo 3 = Responsaveis RM Externo
                         );
        
        $insere     =   $obj->inserir($tabela, $campos);
        
    }
    
    if($insere)
        header('location:?router=T0117/home');    
}


?>



<!-- Divs com a barra de ferramentas -->
<div class="div-primaria caixa-de-ferramentas padding-padrao-vertical">
  
    <div class="push_9 conteudo_16">
          <ul class="lista-horizontal">
            <li><a href="?router=T0117/home" class="botao-padrao"><span class="ui-icon ui-icon-arrowthick-1-w"  ></span>Voltar  </a></li>
        </ul>
        <div class="push_7 grid_5">
            <label class="label">Requisição de Mudança - Nova </label>
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
            <input type="text" name="T113_titulo"   placeholder="Digite o título da requisição de mudança."    class="validate[required] form-input-text-table"       />            
        </div>

        <div style="position: absolute; top: 205px; left: 590px;">
            <label class="label">Data Inícial*</label>
            <input style="width: 65px"type="text" name="T113_dt_hr_inicio" class="validate[required]   "  id="dateCmp1" />            
            <input style="width: 65px"type="hidden" name="dataHoje"  id="dataHoje" value="<?php echo date("d/m/Y");?>" />            
        </div>

        <div style="position: absolute; top: 205px; left: 665px;">
            <label class="label">Hora*</label>
            <select id="hr_ini" name="hr_ini" class="validate[required]">
                <?php $obj->comboHora();?>
            </select>       
        </div>

        <div style="position: absolute; top: 205px; left: 750px;">
            <label class="label">Data Final*</label>
            <input style="width: 65px" type="text" name="T113_dt_hr_fim"    class="validate[required] "  id="dateCmp2" onBlur="validaData()" />            
        </div>

        <div style="position: absolute; top: 205px; left: 825px;">
            <label class="label">Hora*</label>
            <select id="hr_fim" name="hr_fim" class="validate[required]">
                <?php $obj->comboHora();?>
            </select>            
        </div>
       
       
        
        <div style="position: absolute; top: 205px; left: 900px;">
            <label class="label">Responsável da Requisição de Mudança*</label>
            <input style="width: 268px" type="text" class="buscaUsuario validate[required]"
                    onmouseover ='show_tooltip_alert("","Digite o nome do Colaborador e selecione na lista.", true);tooltip.pnotify_display();' 
                    onmousemove ='tooltip.css({"top": event.clientY+12, "left": event.clientX+12});' 
                    onmouseout  ='tooltip.pnotify_remove();'                    
            
                    name="T004_responsavel"
            />
        </div>

        <div class="clear"></div>

        <div class="grid_6">
            <label class="label">Descrição * </label>
            <textarea name="T113_descricao"   placeholder="Falta o Texto!"          class="validate[required] textarea-table" cols="122" rows="4" ></textarea>            
        </div>        

        <div class="clear"></div>

        <div style="position: absolute; top: 350px; left: 170px;">
            <label class="label">Qual a necessidade de mudança? *</label>
            <textarea style="width: 500px" name="T113_motivo"      placeholder="Falta o Texto!"       class="validate[required] textarea-table" cols="50" rows="4" ></textarea>            
        </div>

        <div style="position: absolute; top: 350px; left: 680px;">
            <label class="label">Qual o impacto para o negocio? *</label>
            <textarea style="width: 500px" name="T113_impacto"     placeholder="Falta o Texto!"        class="validate[required] textarea-table" cols="47" rows="4" ></textarea>            
        </div>

        <br><br><br><br><br><br><br><br>

        <div class="grid_16">
            <div id="tabs">
                <ul>
                    <li><a href="#tabs-1">Contingência</a></li>
                </ul>
                <div id="tabs-1">
                    <span class="form-input">
                        <div class="conteudo_12">  
                            <div class="grid_8">
                            <div style="position: absolute; top: 50px; left: 7px;">
                                <label class="label">Tempo:</label>
                            </div>      
                            <div style="position: absolute; top: 30px; left: 50px;">
                                <label class="label">Contingência</label>
                                <input style="width: 60px;" type="text" name="T113_tempo_previsto" placeholder=""
                                onmouseover ='show_tooltip_alert("","Tempo previsto para voltar para cenário anterior.", true);tooltip.pnotify_display();'
                                onmousemove ='tooltip.css({"top": event.clientY+12, "left": event.clientX+12});' 
                                onmouseout  ='tooltip.pnotify_remove();'
                                />
                            </div> 
                                
                            <div style="position: absolute; top: 30px; left: 250px;">
                                <label class="label">Disponível</label>
                                <input style="width: 60px"type="text" name="T113_janela_disponivel" placeholder="" />
                            </div>  
                            
                           <div style="position: absolute; top: 30px; left: 150px;">
                                <label class="label">Total</label>
                                <input style="width: 60px" type="text" name="T113_tempo_total" placeholder="" id="tempoTotal" readonly />
                            </div>   
                        
                             
                                <br><br><br>
                         <div class="clear"></div>

                            <div class="grid_7">
                                <label class="label">Executores Contingência</label>
                                <input type="text" name="" class="buscaUsuario" id="txtExeCont" 
                                        onmouseover ='show_tooltip_alert("","Digite o nome do Colaborador, selecione na lista e clique em adicionar.", true);tooltip.pnotify_display();' 
                                        onmousemove ='tooltip.css({"top": event.clientY+12, "left": event.clientX+12});' 
                                        onmouseout  ='tooltip.pnotify_remove();'                                       
                                />
                            </div>           
                            
                            <div style="position: absolute; top: 68px; left: 460px;">   
                                <label class="label">Add</label>
                                <input style="width: 15px"  type="button" value="+" id="btnAddCont"/>
                            </div>    
                           <div class="clear"></div>
                            <div class="grid_4">
                                <label class="label">Executores</label>
                                <select name="ExeCont[]" multiple id="cmbExeCont">

                                </select>
                                *Clique em cima do Executor para exclui-lo da lista.
                            </div>       
                        </div>
                          <div class="grid_1">
                           <div style="position: absolute; top: 30px; left: 500px">
                                <label class="label">Observação Contingência</label>
                                <textarea style="height: 160px" name="T113_obs_contingencia"    placeholder="Observação da contingência"         class="textarea-table" cols="30" rows="10" ></textarea>            
                           </div>  
                        </div>
                        </div>
                        
                        <div class="clear"></div>
                    </span>
                </div>
            </div>                                                            
        </div>             

        <div class="clear"></div>


        <div class="clear10"></div> 

        <div class="grid_5">
            <label class="label">Executor da Requisição de Mudança (Interno)*</label>
            <input type="text" class="buscaUsuario" id="txtExeInt"
                   onmouseover ='show_tooltip_alert("","Digite o nome do Colaborador, selecione na lista e clique em adicionar.", true);tooltip.pnotify_display();' 
                   onmousemove ='tooltip.css({"top": event.clientY+12, "left": event.clientX+12});' 
                   onmouseout  ='tooltip.pnotify_remove();'     
            />
        </div>
        
          <div class="grid_1">      
            <label class="label">Adicionar</label>
            <input type="button" value="+" id="btnAddExeInt"/>
        </div>    
        
        <div class="push_2 grid_3">
            <label class="label">Nome Executor Externo</label>
            <input type="text" id="txtNomeExt"/>
        </div>

        <div class="push_2 grid_2">
            <label class="label">E-mail</label>
            <input type="text" id="txtEmailExt"/>
        </div>

        <div class="push_2 grid_2">
            <label class="label">Telefone</label>
            <input type="text" id="txtFoneExt" class="fone"/>
        </div>
        
           <div class="push_2 grid_3">
            <label class="label">Notificado</label>
            <div id="radio">
                    <input type="radio" id="radio1" name="T113_resp_notificado" value="S"                    class="validate[required]" /><label for="radio1">Sim</label>
                    <input type="radio" id="radio2" name="T113_resp_notificado" value="N" checked="checked"  class="validate[required]" /><label for="radio2">Não</label>
            </div>            
        </div>                

        <div class="push_1 grid_1">      
            <label class="label">Adicionar</label>
            <input type="button" value="+" id="btnAddExeExt"/>
        </div>     

            
        
        <div class="clear"></div>
        
        <div class=" grid_6">
            <label class="label">Executores Internos</label>
            <select name="T004_login[]" multiple id="cmbExeInt" class="validate[required]">

            </select>
            *Clique em cima do Executor para exclui-lo da lista.
        </div>

         <div class="push_2 grid_6">
            <label class="label">Executores Externos</label>
            <select name="ExeExt[]" multiple id="cmbExeExt" readonly>

            </select>
            *Clique em cima do Executor para exclui-lo da lista.
        </div>    

        <div class="clear"></div>

        

            

                   

        <div class="clear10"></div>

<!--        <div class="grid_2">
            <label class="label">Prioridade *</label>
            <input type="text" name=""          />            
        </div>-->

        <div class="clear"></div>

        <div class="grid_2">
            <input type="submit" value="Salvar" class="botao-padrao" >
        </div>
            
    </form>
    
</div>