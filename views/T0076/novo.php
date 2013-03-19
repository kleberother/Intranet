<?php
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 19/01/2012 por Jorge Nova
 * Descrição: Programa para incluir novo afastamento
 * Entradas:   
 * Origens:   Menu Sistema
           
**************************************************************************
*/



//Instancia Classe
$obj                =   new models_T0076();

// Select Box de Entidades Prestadoras
$entidades          =   $obj->retornaEntidade();

if (!empty($_POST))
{       
    
    $tabela                 =   "T086_afastamentos";
    
    $insere                 =   $obj->inserir($tabela, $_POST); 
    
    header('location:?router=T0076/home');    
}

?>

<script type="text/javascript" src="template/js/interno/T0076/T0076.js"></script>

<!-- Divs com a barra de ferramentas -->
<div class="div-primaria caixa-de-ferramentas padding-padrao-vertical">
    <ul class="lista-horizontal">
        <li><a href="?router=T0076/novo" class="botao-padrao"><span class="ui-icon ui-icon-plus"            ></span>Novo    </a></li>
        <li><a href="?router=T0076/home" class="botao-padrao"><span class="ui-icon ui-icon-arrowthick-1-w"  ></span>Voltar  </a></li>
    </ul>
</div>

<div class="div-primaria padding-padrao-vertical">
    <form action="" method="post">
        <div id="abas">
            
            <ul>
                <li><a href="#aba-1">Colaborador</a></li>
                <li><a href="#aba-2">Consulta</a></li>
                <li><a href="#aba-3">Diagnóstico</a></li>
                <li><a href="#aba-4">Atestado</a></li>
            </ul>


            <div id="aba-1">
                <div class="padding-5px-vertical celula">
                    <label class="label">Procure o Colaborador</label>
                    <input type="text" name="" size="100" class="buscaColaborador" />
                </div>
            </div>
            
            <div id="aba-2">
                <div class="padding-5px-vertical celula">
                    <label class="label">Entidade Prestadora</label>
                    <select class="entidade" name="T049_codigo">
                        <option value="">Selecione...</option>
                        <?php
                        foreach($entidades as $campos=>$valores)
                        {
                        ?>
                        <option value="<?php echo $valores['Codigo']; ?>"><?php echo $valores['Codigo']." - ".$valores['Nome']; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                    
                    <label class="label">Local de Atendimento</label>
                    <select class="local" name="T050_codigo">
                        <option value="">Selecione a entidade</option>
                    </select>
                    
                    <label class="label">Motivo</label>
                    <input type="text" name="" size="50" />
                </div>
            </div>
            
            <div id="aba-3">
                
                <label class="label">Médico</label>
                <input type="text" name="T085_crm" size="100" class="buscaMedico" />
                
                <label class="label">Enfermidade</label>
                <input type="text" name="T051_codigo" size="100" class="buscaCID" />
                
            </div>
            
            <div id="aba-4">
       
                <label class="label">Data de Emissão</label>
                <input type="text" name="T086_dt_emissao" class="data"   />

                <label class="label">Tempo de Afastamento</label>
                <input type="text" name="T086_qtd"          />

                <label class="label">Data de Retorno</label>
                <input type="text" name="T086_dt_retorno" class="data"   />

                <label class="label">Hora Chegada</label>
                <input type="text" name="T086_hr_chegada"   />

                <label class="label">Hora Saída</label>
                <input type="text" name="T086_hr_saida"     />
               
            </div>
            
        </div>
        
    

        <div class="rodape-formulario-botao padding-5px-vertical margin-padrao-vertical">
            <input type="submit" value="Salvar" class="botao-padrao" >
        </div>
        
    </form>
</div>





