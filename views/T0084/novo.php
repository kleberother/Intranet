<?php 
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 27/01/2012 por Jorge Nova
 * Descrição: Programa para incluir 
 * Entradas:   
 * Origens:   Menu Sistema
           
**************************************************************************
*/

//Instancia Classe
$obj                =   new models_T0084();

$connORA            =   "ora";               

$objORA             =   new models_T0084($connORA);
  
// Loja do usuário
$retornaLojaUsu     =   $obj->retornaLojas($_SESSION['user']);

foreach($retornaLojaUsu as $campos=>$valores)
{
    $codigoLoja     =   $valores['Codigo'];
}

// Faz o select de grupos para retornar o grupo do usuário
$retornaGrupos  =   $obj->retornaGruposWF($_SESSION['user']);

foreach($retornaGrupos as $campos=>$valores)
{

    $codigoWF   =   $valores['Codigo'];

}

if (!empty($_POST))
{
    //Busca Codigo Fornecedor Intranet
    $cnpj               =   $_POST['cnpj'];
    $cnpj = str_replace(".", "", $cnpj);
    $cnpj = str_replace("/", "", $cnpj);
    $cnpj = str_replace("-", "", $cnpj);
    $cnpj = str_pad($cnpj, 14, "0", STR_PAD_LEFT);
    
    $codigoFornecedor   =   $obj->retornaCodigoFornecedor($cnpj);
    
            
    // Retorna condição de pagamento
    $retornaCondicao           =   $objORA->retornaCondicaoPagamento($codigoRMS);    
    
    while ($row_ora = oci_fetch_array($retornaCondicao))
    {
        $condicao   =   $row_ora[0];
    }      
    
        
    // Tabela para inserir os dados
    $tabela01               =   "T013_nota_debito";
    
    $tabela02               =   "T087_nota_debito_detalhe";
    
    $tabela03               =   "T089_parametro_detalhe";       // Tabela para UPDATE do parametro
    
    $tabela04               =   "T013_T060";                    // Tabela para gravar fluxo da ND
    
    // Query para descobrir a última nota de débito emitida para a loja X
    $retornaNumero          =   $obj->retornaUltimaND();   
    
    // Varre o retorno para encontrar o número
    foreach ($retornaNumero as $campos=>$valores)
    {
        $ultimaNd           =   $valores['Valor'];
    }
    
    // Soma mais um para nova nota
    $codigoND = $ultimaNd + 1;
    
    
    
    // Campos para inserir na Tabela 01
    $Campos01               =   array(  "T013_codigo"        =>  $codigoND
                                     ,  "T013_total_geral"   =>  $_POST['T013_total_geral']
                                     ,  "T004_login"         =>  $_SESSION['user']
                                     ,  "T006_codigo"        =>  $_POST['T006_codigo']
                                     ,  "T013_dt_emissao"    =>  $_POST['T013_dt_emissao']
                                     ,  "T013_dt_vencimento" =>  $_POST['T013_dt_vencimento']
                                     ,  "T013_status"        =>  "0"
                                     ,  "T026_codigo"        =>  $codigoFornecedor[0]);
       
    // Insere Campos 01 na Tabela 01
    $insere                 =   $obj->inserir($tabela01, $Campos01);
    
   
    // Prepara campos para inserir na tabela 02         
    $contador = count($_POST['T088_crf_rms']);
    
    for($i = 0 ; $i < $contador ; $i++)
    {
        // Campos para inserir na Tabela 02
        $Campos02               =   array(     "T013_codigo"       =>  $codigoND
                                            ,  "T006_codigo"       =>  $_POST['T006_codigo']
                                            ,  "T088_crf_rms"      =>  $_POST['T088_crf_rms'][$i]
                                            ,  "T087_descricao"    =>  $_POST['T087_descricao'][$i]   
                                            ,  "T087_valor"        =>  $_POST['T087_valor'][$i]   
                                        );
        
        // Insere Campos 02 na Tabela 02
        $insere02                 =   $obj->inserir($tabela02, $Campos02);
    }
    
    
    // Inicia a inserção do fluxo na tabela 04
    
    // Recupera o número da Etapa para esse grupo de workflow
    $Etapa = $obj->retornaEtapaGrupo($_POST['T059_codigo']);
    
   
    // Inicia a inserção
    foreach($Etapa as $campos=>$valores)
    {
        
        echo $_POST['T006_codigo']."AAAAA";
        
        $Campos04   =   array ( "T060_codigo"       =>  $valores['EtapaCodigo']
                              , "T013_codigo"       =>  $codigoND
                              , "T006_codigo"       =>  $_POST['T006_codigo']
                              , "T013_T060_ordem"   =>  1
                              , "T013_T060_status"  =>  0
                              , "T004_login"        =>  $_SESSION['user']);
              
        $insere03   =   $obj->inserir($tabela04, $Campos04);
        
        $insere04   =   $obj->InserirFluxo($codigoND, $_POST['T006_codigo'], $valores['ProxEtapaCodigo'], 2, $_SESSION['user']);

    }    
    
    
    // Faz o update na tabela de descrição de parametros
    $delim      =   "T003_codigo = 4" ;
    
    // Campos para update na Tabela 03
    $Campos03               =   array(  "T089_valor"       =>  $codigoND    );   
    
    $update01   =   $obj->altera($tabela03, $Campos03, $delim);     
      
          
    
    //header('location:?router=T0084/home');    
}

// Select para retornar Select Box de CRFs
$SelectBoxCRF    =   $obj->retornaCRFSelectBox();

// Select para retornar Select Box de CRFs
$SelectBoxLoja   =   $obj->retornaLojasSelectBox();

?>

<!-- Include de Scripts Java Script  -->
<script src="template/js/interno/T0084/T0084.js"></script>


<!-- Div para conter os options  -->
<div id='modal-addCRF' title='Escolher CRF' style='display:none;'>
    <form action='' method=''>
        <div class='div-input'>                       
        <label class='label'>CRF*</label>
            <select name='crf_codigo_select' class='crf_codigo_select' style='width: 370px;'>
                <option value=''>Selecione...</option>
                <?php
                foreach ($SelectBoxCRF as $campos=>$valores)
                {
                ?>
                    <option value='<?php echo $valores['CodigoRMS']; ?>'><?php echo $valores['CodigoRMS']." - ".$valores['Descricao']; ?></option>
                <?php
                }
                ?>
            </select>       
        </div>     
    </form>
</div>




<!-- Divs com a barra de ferramentas -->
<div class="div-primaria caixa-de-ferramentas padding-padrao-vertical">
    <ul class="lista-horizontal">
        <li><a href="?router=T0084/novo" class="botao-padrao"><span class="ui-icon ui-icon-plus"            ></span>Novo    </a></li>
        <li><a href="?router=T0084/home" class="botao-padrao"><span class="ui-icon ui-icon-arrowthick-1-w"  ></span>Voltar  </a></li>
    </ul>
</div>

<div class="div-primaria padding-padrao-vertical">
    
    <form action="" method="post" id="formCad">
        
        <div id="formulario" class="formulario">
        
            <div class="conteudo-visivel padding-5px-vertical">

                <div class="coluna c05_tipo_e_01 margim-5px-horizontal">       
                    <label class="label">Loja Emissora</label>
                    <select name="T006_codigo" style="padding: 3px 0;" >
                        <?php
                            foreach($SelectBoxLoja as $campos=>$valores)
                            {
                        ?>
                            <option value="<?php echo $valores['Codigo']; ?>" <?php if ($codigoLoja == $valores['Codigo']) echo "selected";?>><?php echo $obj->preencheZero("E", 3, $valores['Codigo'])." - ".$valores['Nome']; ?></option>
                        <?php
                            }
                        ?>
                    </select>
                </div>

                <div class="coluna c05_tipo_e_03 margim-5px-horizontal">       
                    <label class="label">Data Emissão*</label>
                    <input  type="text" name="T013_dt_emissao"      id="DtEmiss"  class="data"   />
                </div>

                <div class="coluna c05_tipo_e_04 margim-5px-horizontal">
                    <label class="label">Data Vencimento*</label>
                    <input  type="text" name="T013_dt_vencimento"   id="DtVencto" class="data"  />
                </div>

            </div>                             
        
            <div class="conteudo-visivel padding-5px-vertical">

                <div class="coluna c04_tipo_e_01 margim-5px-horizontal">       
                    <label class="label">CNPJ*</label>
                    <input  type="text" name="cnpj"  id="cnpj_for" />
                </div>
  
                <div class="coluna c04_tipo_e_02 margim-5px-horizontal">       
                    <label class="label">Código RMS*</label>
                    <input  type="text" name="cod_rms"  id="rms_codigo"  />
                </div>

                <div class="coluna c04_tipo_e_03 margim-5px-horizontal">       
                    <label class="label">Razão Social</label>
                    <input  type="text" name=""  size="42"  id="raz_social" />
                </div>

                <div class="coluna c04_tipo_e_04 margim-5px-horizontal">       
                    <label class="label texto-alinhado-direita">Valor Total</label>
                    <p class="negrito texto-alinhado-direita valorTotal2 valor-01"></p>
                </div>

            </div>                             
                            

            <div class="div-primaria padding-padrao-vertical">

                <ul class="lista-itens-head">

                    <li>

                        <div class="padding-2px-vertical conteudo-visivel celula-01">

                            <!-- Cabec. CRF -->
                            <div class="coluna c04_tipo_c_01 margim-5px-horizontal">
                                <label class="label">CRF</label>
                            </div>

                            <!-- Cabec. Descrição -->
                            <div class="coluna c04_tipo_c_02 margim-5px-horizontal">
                                <label class="label descricaoND">Descrição</label>
                            </div>

                            <!-- Cabec. Valor em Reais -->
                            <div class="coluna c04_tipo_c_03 margim-5px-horizontal">
                                <label class="label">Valor R$</label>
                            </div>

                            <!-- Ações / Botões -->
                            <div class="coluna c04_tipo_c_04 margim-5px-horizontal"> 
                                <ul class="lista-de-acoes">
                                    <li><a href="#" title="Adicionar Linha"><span class='ui-icon ui-icon-plus adicionaLinha'></span></a></li>
                                </ul>
                            </div>

                        </div>

                    </li>                 

                </ul>


                <ul class="lista-itens-body">    

                    <li class="elementosLista">

                        <div class="padding-2px-vertical conteudo-visivel">

                            <!-- Campo Data-->
                            <div class="coluna c04_tipo_c_01 margim-5px-horizontal padding-2px-vertical">
                                <input type="text"     name="T088_crf_rms[]" size="1"    class="codigoRMS" readonly  />
    <!--                            <input type="hidden"   name="T088_codigo[]"  size="1"    class="codigoCRF"           />-->
                            </div>

                            <!-- Campo Descrição -->
                            <div class="coluna c04_tipo_c_02 margim-5px-horizontal padding-2px-vertical">
                                <textarea name="T087_descricao[]"   class="descricao"  maxlength="500" style="width:750px;height:15px"></textarea>                             
                            </div>

                            <!-- Campo Valor da Nota -->
                            <div class="coluna c04_tipo_c_03 margim-5px-horizontal padding-2px-vertical">
                                <input type="text" name="T087_valor[]" size="10"   class="valorCRF monetario" />
                            </div>

                            <!-- Ações/Botões -->
                            <div class="coluna c04_tipo_c_04 margim-5px-horizontal padding-2px-vertical">

                            </div>

                        </div>

                    </li> 

                </ul>

            </div>

            <!-- Inputs tipo Hidden -->
            <input  type="hidden"  name="T059_codigo"       value="<?php echo $codigoWF; ?>"                                      />
            <input  type="hidden"  name="T013_total_geral"                                    class="valorTotal monetario valor" />            

            <div class="conteudo-visivel padding-5px-vertical">

                <div class="coluna c1_tipo_a_01">       
                    <input type="submit" value="Salvar" class="botao-padrao" />            
                </div>

            </div>      

        </div>
        
    </form> 
    
</div>





