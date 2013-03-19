<?php 
//Instancia Classe
$obj    = new models_T0015();
?>
<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">                          Selecione       </li>
                <li><a href="?router=T0015/home" class="active">Listar      </a></li>
                <li><a href="?router=T0015/novo">               Novo        </a></li>
            </ul>
        </span>
    </div>
</div>
<div id="conteudo">
    <span class="form-titulo">
        <p>Workflow:</p>
    </span>
    <span class="lista_itens">
	<table class="ui-widget ui-widget-content" style="border-style: solid;">
            <thead >
                <tr class="ui-widget-header ">
                    <th>Nome</th>
                    <th>Descrição</th>
                </tr>
            </thead>
            <tbody>
                <?php
                function verificaWorkflow($CodigoPai)
                {
                    global $nivel; $nivel ++;
                    $obj    =   new models_T0015();
                    $WkfPai  =   $obj->retornaWorkflow($CodigoPai);                                        
                    foreach($WkfPai   as  $campos =>  $valores)
                    {       
                        if (!empty($valores['ProxEtapaWorkflow']))
                            $Cascata .= str_repeat("&nbsp",($nivel*4)-4)   ;
                        else
                            $Cascata  = "" ;  // Raiz pai = NULL

                        echo "<tr class='dados'>";
                        echo "    <td>".$Cascata.$obj->preencheZero("E", 3, $valores['CodigoGrupo'])."-".$valores['NomeGrupo']."</td>";
                        echo "    <td>".$valores['DescricaoGrupo']."</td>";
                        echo "</tr>";

                        $Cascata  = ""                  ;

                        verificaWorkflow($valores['CodigoWorkflow']);
                    }
                    $nivel --;
                }
                $CodigoPai      =   NULL    ;
                $Retorno    =   verificaWorkflow($CodigoPai);
                ?>
            </tbody>
    </table>

    </span>
</div>