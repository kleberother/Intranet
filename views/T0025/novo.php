<?php

//Instancia Classe
$objFor         =   new models_T0025();
$T059 = $objFor->listaWF();
$T061 = $objFor->listaProcesso();
//Captura Login para inserção
$user           =   $_SESSION['user'];


//INICIO INSERE
//Verifica se CNPJ não é nulo
if (!is_null($_POST['T026_rms_cgc_cpf'])
|| (!is_null($_POST['cpf_T026_rms_cgc_cpf'])))
{
    //INSERI EM T026_fornecedor

    $tabela         =   "T026_fornecedor";

    //Trata CNPJ e CPF
    $_POST['T026_rms_cgc_cpf']      =   $objFor->retiraMascara($_POST['T026_rms_cgc_cpf']);
    $_POST['T026_rms_cgc_cpf']      =   $objFor->preencheZero("E", 14, $_POST['T026_rms_cgc_cpf']);
    $_POST['cpf_T026_rms_cgc_cpf']  =   $objFor->retiraMascara($_POST['cpf_T026_rms_cgc_cpf']);
    $_POST['cpf_T026_rms_cgc_cpf']  =   $objFor->preencheZero("E", 14, $_POST['cpf_T026_rms_cgc_cpf']);

    //Trata código RMS
    $codRMS_CNPJ        =   substr($_POST['T026_rms_codigo'], 0, -1);
    $digRMS_CNPJ        =   substr($_POST['T026_rms_codigo'], -1);

    $codRMS_CPF         =   substr($_POST['cpf_T026_rms_codigo'], 0, -1);
    $digRMS_CPF         =   substr($_POST['cpf_T026_rms_codigo'], -1);

    //Se não existe fornecedor em T026_fornecedor INSERI
    if($i==0)
    {
        //Array para inserir T026_fornecedor
        $arrFornCNPJ    =   array( 'T026_rms_cgc_cpf'        =>$_POST['T026_rms_cgc_cpf']
                                 , 'T026_rms_codigo'         =>$codRMS_CNPJ
                                 , 'T026_rms_insc_est_ident' =>$_POST['T026_rms_insc_est_ident']
                                 , 'T026_rms_razao_social'   =>$_POST['T026_rms_razao_social']
                                 , 'T026_rms_insc_mun'       =>$_POST['T026_rms_insc_mun']
                                 , 'T026_rms_digito'         =>$digRMS_CNPJ);

        $arrFornCPF     =   array( 'T026_rms_cgc_cpf'        =>$_POST['cpf_T026_rms_cgc_cpf']
                                 , 'T026_rms_codigo'         =>$codRMS_CPF
                                 , 'T026_rms_insc_est_ident' =>$_POST['cpf_T026_rms_insc_est_ident']
                                 , 'T026_rms_razao_social'   =>$_POST['cpf_T026_rms_razao_social']
                                 , 'T026_rms_digito'         =>$digRMS_CPF);

        if($arrFornCNPJ['T026_rms_cgc_cpf'] == "")
        {
            $insere = $objFor->inserir($tabela, $arrFornCPF);
            $cod_for = $objFor->lastInsertId();
            if ($insere)
            {
                header('location:?router=T0025/associar&cod='.$cod_for.'&nom='.$_POST['cpf_T026_rms_razao_social'].'&msg=6');
            }
            else
            {
                header('location:?router=T0025/novo&msg=1');
            }
        }
        else
        {
            $insere2 = $objFor->inserir($tabela, $arrFornCNPJ);
            $cod_for = $objFor->lastInsertId();
            if ($insere2)
            {
                header('location:?router=T0025/associar&cod='.$cod_for.'&nom='.$_POST['T026_rms_razao_social'].'&msg=6');
            }
            else
            {
               header('location:?router=T0025/novo&msg=1');               
            }
        }
    }
}
//FIM INSERE

//$GrpWkf   = $_POST["T059_codigo"];
//$tabela = "T026_T059";
//
//foreach($GrpWkf as $valores)
//{
//    $arrGrpWkf  =   array("T059_codigo"=>$valores
//                        , "T026_codigo"=>$cod_for
//                        , "T061_codigo"=>1);
//
//         $objFor->inserir($tabela, $arrGrpWkf);
//}

?>
<!-- Busca CNPJ ou CODIGO RMS  -->
<script src="template/js/interno/T0025/busca.js"></script>

<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0025/home">Listar</a></li>
                <li><a href="?router=T0025/novo" class="active">Novo</a></li>
            </ul>
        </span>
    </div>
</div>
<div id="formulario">
    <span class="form-titulo">
        <p>Os campos com asterisco (*) são obrigatórios o preechimento</p>
    </span>
    <span class="form-input">
    <form action="" method="post" id="formCad">
        <div id="form-trocar">
            <a href="#" onClick="alternarDocumento('CNPJ')">Pessoa Jurídica</a>
            <a href="#" onClick="alternarDocumento('CPF')" >Pessoa Física  </a>
        </div>
        <!-- PESSOA JURÍDICA - CNPJ -->
        <table style="display: block;" id="pessoa_juridica">
            <tr>
                <td><label class="label">CNPJ*             </label></td>
                <td><label class="label">Cod RMS*          </label></td>
                <td><label class="label">Inscrição Estadual</label></td>
            </tr>
            <tr>
                <td>            <input type="text" name="T026_rms_cgc_cpf"         id="cnpj_for"   class="validate[required] form-input-text-table" /></td>
                <td>            <input type="text" name="T026_rms_codigo"          id="rms_codigo" class="validate[required] form-input-text-table" /></td>
                <td>            <input type="text" name="T026_rms_insc_est_ident"  id="ie"         class="form-input-text-table" readonly/></td>
            </tr>
            <tr>
                <td colspan="2"><label class="label">Razão Social*      </label></td>
                <td>            <label class="label">Inscrição Municipal</label></td>
            </tr>
            <tr>
                <td colspan="2"><input type="text" name="T026_rms_razao_social"     id="raz_social" class="validate[required] form-input-text-table" readonly/></td>
                <td>            <input type="text" name="T026_rms_insc_mun"         id="im"         class="form-input-text-table" readonly/></td>
            </tr>
        </table>
        <!-- PESSOA JURÍDICA - CNPJ - FIM -->
        <!-- PESSOA FÍSICA - CPF -->
        <table style="display: none;" id="pessoa_fisica">
            <tr>
                <td><label class="label">CPF*    </label></td>
                <td><label class="label">Cod RMS*</label></td>
                <td></td>
            </tr>
            <tr>
                <td>            <input type="text" name="cpf_T026_rms_cgc_cpf"      id="cpf_for"    class="form-input-text-table" /></td>
                <td>            <input type="text" name="cpf_T026_rms_codigo"       id="rms_codigo" class="form-input-text-table" /></td>
            </tr>
            <tr>
                <td colspan="2"><label class="label">Razão Social*</label></td>
                <td><label class="label">RG</label></td>
            </tr>
            <tr>
                <td colspan="2"><input type="text" name="cpf_T026_rms_razao_social" id="raz_social" class="form-input-text-table" /></td>
                <td>            <input type="text" name="cpf_T026_rms_insc_mun"     id="rg"         class="form-input-text-table" /></td>
            </tr>
        </table>
        <!-- PESSOA FÍSICA - CPF - FIM -->
        <div class="form-inpu-botoes">
            <input type="submit" value="Criar" />
        </div>
    </form>
    </span>
</div>

