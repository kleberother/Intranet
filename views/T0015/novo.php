<?php 

//Instancia Classe
$obj    =   new models_T0015();

$processos  =   $obj->retornaProcessos();

$etapa =   $obj->retornaUltimaEtapa();

foreach($etapa as $campos => $valores)
{
    $ProxEtapa  =   $valores['ProxEtapa'];
}

if (!empty($_POST))
{
    $Processo       =   $_POST['T061_codigo']           ;
    $Etapa          =   $_POST['numEtapa']              ;
    $CodigoGrupo    =   $_POST['T059_codigo']           ;
    $ProximaEtapa   =   $_POST['T060_proxima_etapa']    ;
    $Ordem          =   $_POST['T060_ordem']            ;
    $NumeroDias     =   $_POST['T060_num_dias']         ;
    $Obrigatorio    =   $_POST['T060_obriga_aprovacao'] ;
    $Dados          =   array()                         ;
    $Tabela         =   "T060_workflow"                 ;
    
    $qtdeCampos  =   0                                  ;
    foreach($Etapa  as  $campos =>  $valores)
    {
        $qtdeCampos++;
    }
    
    //Zera Contadores
    $i  =   0   ;
    
    //Preenche variavel Dados com valores dos grupos
    foreach($CodigoGrupo    as  $campos =>  $valores)
    {
        $Dados['T059_codigo'][$i]  =   $valores;
        $i++;
    }
    
    $i  =   0   ;
    //Preenche variavel Dados com valores das Proximas Etapas
    foreach($ProximaEtapa    as  $campos =>  $valores)
    {
        $Dados['T060_proxima_etapa'][$i]  =   $valores;
        $i++;
    }
    
    $i  =   0   ;
    //Preenche variavel Dados com valores da Ordem
    foreach($Ordem    as  $campos =>  $valores)
    {
        $Dados['T060_ordem'][$i]  =   $valores;
        $i++;
    }
    
    $i  =   0   ;
    //Preenche variavel Dados com valores do campo Numero de Dias
    foreach($NumeroDias    as  $campos =>  $valores)
    {
        $Dados['T060_num_dias'][$i]  =   $valores;
        $i++;
    }
    
    $i  =   0   ;
    //Preenche variavel Dados com valores do Campos Obrigatorio
    foreach($Obrigatorio    as  $campos =>  $valores)
    {
        $Dados['T060_obriga_aprovacao'][$i]  =   $valores;
        $i++;
    }    
    
    for( $i=0; $i<$qtdeCampos; $i++)
    {
        
        $campos = array (     "T060_obriga_aprovacao" =>  $Dados['T060_obriga_aprovacao'][$i]
                            , "T060_num_dias"         =>  $Dados['T060_num_dias'][$i]
                            , "T060_ordem"            =>  $Dados['T060_ordem'][$i]
                            , "T060_proxima_etapa"    =>  $Dados['T060_proxima_etapa'][$i]
                            , "T061_codigo"           =>  $Processo
                            , "T059_codigo"           =>  $Dados['T059_codigo'][$i]
                        );
        
        $obj->inserir($Tabela, $campos);
        
    }
    

    
}
?>
<script src="template/js/interno/T0015/T0015.js"></script>  
<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>  
                <li><a href="?router=T0015/home"               >Listar  </a></li>
                <li><a href="?router=T0015/novo" class="active">Novo    </a></li>
            </ul>
        </span>
    </div>
</div>
<div id="formulario">  
    <span class="form-titulo">
        <p>Os campos com asterisco (*) são obrigatórios o preechimento</p>
    </span>
    <span class="form-input">
    <form action="" method="post">
        <table>
            <tr>
                <td width="10%"><label class="label">Processo</label></td>
            </tr>
            <tr>
                <td>
                    <select name="T061_codigo" id="processo">
                        <option values="">Selecione...</option>
                        <?php foreach($processos as $campos => $valores){?>
                        <option value="<?php echo $valores['ProcessoCodigo']?>"><?php echo $obj->preencheZero("E", 3, $valores['ProcessoCodigo'])."-".$valores['ProcessoNome'];?></option>                            
                        <?php }?>
                    </select>
                </td>
            </tr>
        </table>
        <span class="form-titulo">
            <p>Etapas</p>
        </span>
        <table class="form-inpu-tab">
            <thead>
                <tr>
                    <th align="left"><label>Etapa           </label></th>
                    <th align="left"><label>Grupo           </label></th>
                    <th align="left"><label>Próxima Etapa   </label></th>
                    <th align="left"><label>Ordem           </label></th>
                    <th align="left"><label>Nº Dias         </label></th>
                    <th align="left"><label>Obrigatório     </label></th>
                    <th align="left"><label>Ações           </label></th>
                </tr>
            </thead>
            <tbody class="tbody">
                    <tr>
                        <td><input type="text" name="numEtapa[]"  value="<?php echo $ProxEtapa;?>"        class="etapa"   size="3"   readonly="true"      /></td>
                        <td>
                            <select name="T059_codigo[]"                        class="grupos">
                            </select>
                        </td>
                        <td><input type="hidden"    name="T060_proxima_etapa[]"      class="proximaEtapa"    size="3"   maxlength="3"  value="null"/></td>
                        <td><input type="text"      name="T060_ordem[]"              class="ordem"           size="3"   maxlength="3"                  /></td>
                        <td><input type="text"      name="T060_num_dias[]"           class="numDias"         size="3"   maxlength="3"                  /></td>
                        <td>
                            <select class="obrigatorio" name="T060_obriga_aprovacao[]">
                                <option value="S">Sim</option>
                                <option value="N">Não</option>
                            </select>
                        </td>
                        <td><input type="button" href="#" class="adicionaLinha" value="+"/></td>                    
                    </tr>                                        
            </tbody>
        </table>
        <div class="form-inpu-botoes">
            <input type="submit" value="Criar" />
        </div>
    </form>
    </span>
</div>

