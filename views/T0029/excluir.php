<?php
//Chama classes
$pagina        =    $_GET["pagina"];
$cod           =    $_GET["cod"];
$tabela        =    $_GET["tabela"];
$path          =    $_GET["path"];
$nome          =    $_GET["nome"];

//EXCLUI DA TABELA T055_arquivos
if($tabela == 'T055_arquivos')
{
    if(is_numeric($_GET["valor"]))
    {
        $delim        =    $_GET["campo"]." = ".$_GET["valor"];
    }
    else
    {
        $delim        =    $_GET["campo"]." = "."'".$_GET["valor"]."'";
    }

    $objExcluir     =   new models_T0029();
    
   $buscaUsuarios =   $objExcluir->retornaUsuariosComPermissao($_GET["valor"]);

   foreach($buscaUsuarios as $campos=>$valores)
   {

       $buscaEmail    =   $objExcluir->retornaEmail($valores['Login']);

       foreach($buscaEmail    as $campos=>$valores2)
       {
           $email = $valores2['Email'];
       }

       // Busca dados do arquivo

       $buscaArquivo  =   $objExcluir->retornaArquivoUnico($_GET["valor"]);

       foreach($buscaArquivo    as $campos=>$valores3)
       {
             $nomeArq   =   $valores3['Nome'];
             $descArq   =   $valores3['Descricao'];
             $publArq   =   $valores3['Publisher'];
             $owneArq   =   $valores3['NomeOwner'];
             $dtupArq   =   $valores3['DataUpload'];
       }


          $para       =   $email;

          $assunto    =   "Arquivo Intranet";

          $mensagem    =   'Foi excluído o arquivo abaixo, para o qual você obtinha acesso:'.PHP_EOL.PHP_EOL;
          $mensagem   .=   'Código: '.$_GET["valor"].PHP_EOL.PHP_EOL;
          $mensagem   .=   'Nome: '.$nomeArq.PHP_EOL.PHP_EOL;
          $mensagem   .=   'Descrição: '.$descArq.PHP_EOL.PHP_EOL;
          $mensagem   .=   'Publicado por: '.$owneArq." (".$publArq.") Em: ".$dtupArq.PHP_EOL;



          $cabecalho  = "From: Intranet Davo <intranet@davo.com>.br\r\n";
          $cabecalho .= "MIME-Version: 1.0\r\n"; 
          $cabecalho .= "Content-type: text/plain; charset=utf-8\r\n";
          $cabecalho .= "Content-Transfer-Encoding: 8bit";    

          $email      =   mail($para, $assunto, $mensagem, $cabecalho);                               
   }   
           
    $ExcluirT0455 =   $objExcluir->excluir("T004_T055", $delim);
    $ExcluirT0955 =   $objExcluir->excluir("T009_T055", $delim);
    $ExcluirT5577 =   $objExcluir->excluir("T055_T077", $delim);
   //if($ExcluirT0455)
   //{
    //if($ExcluirT0955)
    //{
      $Excluir       =   $objExcluir->excluir($tabela, $delim);
      if ($Excluir)
      {
        $fn = $path;
        // Excluindo arquivo
        $ret = unlink($fn);
        if ($ret)
        {                            
         //echo "exclui arquivo fisico";
         header('location:?router='.$pagina);
        }
        else
        {
         //echo "nao exclui arquivo fisico";
         header('location:?router='.$pagina);
        }
      }
      else
       //echo "nao exclui T055";
       header('location:?router='.$pagina);
     //}
     //else
     //  echo "nao exclui T009";
       //header('location:?router='.$pagina.'&msg=2');
   //}
  // else
       //echo "nao exclui T004";
       //header('location:?router='.$pagina.'&msg=2');
}//termina a exclusão total do arquivo

//PAGINA DE PERMISSOES
//EXCLUI DA TABELA T004_T055
if($tabela == 'T004_T055')
{
    if(is_numeric($_GET["valor"]))
    {
        $delim        =    $_GET["campo"]." = ".$_GET["valor"]." AND T055_codigo = ".$cod;
    }
    else
    {
        $delim        =    $_GET["campo"]." = "."'".$_GET["valor"]."' AND T055_codigo = ".$cod;
    }

    //EXCLUI DA TABELA T055_arquivos
    $objExcluir     =   new models_T0029();
     $Excluir       =   $objExcluir->excluir($tabela, $delim);


     if ($Excluir)
     {
      header('location:?router='.$pagina.'&msg=10&cod='.$cod.'&nome='.$nome.'&#tabs-3');
     }
     else
      header('location:?router='.$pagina.'&msg=2&cod='.$cod.'&nome='.$nome.'&#tabs-3');
}

//EXCLUI DA TABELA T009_T055
if($tabela == 'T009_T055')
{
    if(is_numeric($_GET["valor"]))
    {
        $delim        =    $_GET["campo"]." = ".$_GET["valor"]." AND T055_codigo = ".$cod;
    }
    else
    {
        $delim        =    $_GET["campo"]." = "."'".$_GET["valor"]."' AND T055_codigo = ".$cod;
    }

    //EXCLUI DA TABELA T055_arquivos
    $objExcluir     =   new models_T0029();
     $Excluir       =   $objExcluir->excluir($tabela, $delim);


     if ($Excluir)
     {
      header('location:?router='.$pagina.'&msg=10&cod='.$cod.'&nome='.$nome.'&#tabs-2');
     }
     else
      header('location:?router='.$pagina.'&msg=2&cod='.$cod.'&nome='.$nome.'&#tabs-2');
}

//EXCLUI DA TABELA T055_T006T077
if($tabela == 'T055_T006T077')
{
    if(is_numeric($_GET["valor"]))
    {
        $delim        =    $_GET["campo"]." = ".$_GET["valor"]." AND T055_codigo = ".$cod." AND ".$_GET['campo2']." = ".$_GET['valor2'];
    }
    else
    {
        $delim        =    $_GET["campo"]." = "."'".$_GET["valor"]."' AND T055_codigo = ".$cod." AND ".$_GET['campo2']." = ".$_GET['valor2'];
    }

    //EXCLUI DA TABELA T055_arquivos
    $objExcluir     =   new models_T0029();
     $Excluir       =   $objExcluir->excluir($tabela, $delim);


     if ($Excluir)
     {
      header('location:?router='.$pagina.'&msg=10&cod='.$cod.'&nome='.$nome.'&#tabs-1');
     }
     else
      header('location:?router='.$pagina.'&msg=2&cod='.$cod.'&nome='.$nome.'&#tabs-1');
}

?>