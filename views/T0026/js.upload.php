<?php
//Instancia Classe
$obj  =   new models_T0026();

$codigoDespesa          =   $_REQUEST['codigoDespesa']              ;
$categoria              =   $_REQUEST['codigoCategoria']            ;
$arquivo                =   $_FILES["despesaArquivo"]               ;
$tmp                    =   $arquivo["tmp_name"]                    ;
$nome                   =   $arquivo["name"]                        ;
$diretorio              =   CAMINHO_ARQUIVOS."CAT"                  ;
$arrExtensao            =   explode('.' , $arquivo["name"])         ;
$extensao               =   $arrExtensao[1]                         ;
$data                   =   date("d/m/Y")                           ;

$strCategoria           =   $obj->preencheZero("E", 4, $categoria)  ;

$procura    =   $obj->retornaExtensaoArquivo($extensao);
$i          =   0;
foreach ($procura   as $campos=>$valores)
{
    $codExt     =   $valores['codigoExtensao'];
    $i++;
}

$_POST['T057_codigo']   =   $codExt;

if($i==1)
{
    //copia arquivo para diretóio files
    $copiar     =   move_uploaded_file($tmp, $diretorio .$categoria. "/" . $nome);
    if(!$copiar)
    {
        echo "nao copiou o arquivo!!";
        echo "arquivo nome: $arquivo";
        exit (0);
    }
    else
    {
        //Limpa variaveis array
        unset($_POST['T059_codigo']);
        unset($_POST['T008_codigo']);
        //Atribui nome INTERNO (ex.: 0001.pdf)
        $_POST['T055_dt_upload']    =   $data;
        //inseri T055_arquivo
        $tabela      =  "T055_arquivos";
        $_POST['T055_nome']         =   "[Automatico] - P0016/Aprovação de Pagamento";
        $_POST['T055_desc']         =   "[Automatico] - P0016/Aprovação de Pagamento";
        $insUpload   =  $objUpload->inserir($tabela, $_POST);
        $codArq      =  $objUpload->lastInsertId();
        //Renomeia arquivo
        $nomeInt    =   $objUpload->preencheZero("E", 4, $codArq).".".strtolower($extensao);

        if (rename($diretorio.$categoria."/".$nome,$diretorio.$categoria."/".$nomeInt))
        {
            //Inseri T008_T055
            $tabela      =  "T008_T055";
            $dados       = array('T008_codigo' => $ap
                               , 'T055_codigo' => $codArq);

            $insUpload   =  $objUpload->inserir($tabela, $dados);
            //echo $insUpload;
            //Lê página inicial
            header("location:?router=T0016/home");
        }
        else
        {
            echo "<script>alert('Erro!')</script>";
        }
    }
}

?>
