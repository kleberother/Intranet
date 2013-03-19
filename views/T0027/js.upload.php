<?php

if (isset($_FILES["P0029_arquivo"])){

//DECLARAÇÕES E PARAMETROS

    //Instancia Classe models_T0016
    $objUpload  =   new models_T0016($conn);

//Utilizados
    $ap         =   $_POST['T008_codigo'];
    $arquivo    =   $_FILES["P0016_arquivo"];
    $tmp        =   $arquivo["tmp_name"];
    $nome       =   $arquivo["name"];
    $diretorio  =   CAMINHO_ARQUIVOS."CAT";
        //Extrai a extensão arquivo
        $extensao['extensao'] = explode('.' , $arquivo["name"]);
    $extensao = $extensao['extensao'][1];

    $data       =   date("d/m/Y");
    $categoria  =   $objUpload->preencheZero("E", 4, $_POST['T056_codigo']);

    //Selecinar extensao
    $tabela     =   "T057_extensao";
    $procura    =   $objUpload->selecionaExtensao($extensao);
    $i          =   0;
    foreach ($procura   as $campos=>$valores)
    {
        $codExt     =   $valores['COD'];
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
            unset($_POST['T061_codigo']);
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
                header("location:?router=T0029/home");
            }
            else
            {
                echo "Erro!";
            }
        }
    }
}

?>
