<?php
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 30/09/2011 por Rodrigo Alfieri
 * Descrição: Tratamento via POST para Upload do Arquivo/Imagem associado ao produto
           
***************************************************************************/
//Verifica se tem arquivo em anexo
//DECLARAÇÕES E PARAMETROS
//Instancia Classe models_T0056
if(!empty($_FILES['Arquivo']))
{ 
    //Instancia Classe
    $obj                 =  new models_T0056();

    //Tamanho total do arquivo
    $tamanho             =  ($_FILES["Arquivo"]['size']/1024)/1024;

    //Parametro para ver se o arquivo ultrapassou o tamanho limite de upload
    $parametro           =  $obj->retornaParametroUP();

    foreach($parametro as $campos=>$valores)
    {
        $parametro_valor    = $valores['Valor'];     
    }

    if ( $tamanho < $parametro_valor )
       {
            //arquivo físico nome+extensão
            $arquivo             =  $_FILES["Arquivo"]['name'];    
            //Pasta aonde encontra-se os arquivos
            echo $diretorio           =  CAMINHO_ARQUIVOS."CAT";         
            //tipo do arquivo, vai determinar a pasta no qual o arquivo se encontra
            $categoria           =  $obj->preencheZero("E", 4, $_POST['T056_codigo']); 
            //caminho temporário
            $temporario          =  $_FILES["Arquivo"]['tmp_name'];
            //Nome do arquivo
            $nome                = $obj->SepararNome($arquivo);
            //Extensão do arquivo
            $extensao            = $obj->SepararExtensao($arquivo); 

            //Verfica se a extensão existe na tabela de extensões
            $tabela              = "T057_extensao";
            $RetornaExt          = $obj->selecionaExtensao($extensao);

            //varre o array em busca do codigo da extensão
            foreach ($RetornaExt   as $campos=>$valores)
            {
                $CodigoExt  =   $valores['Codigo'];
            }           

            if (empty($CodigoExt))
               {
                    //atribui a variavel $tabela a tabela T057_extensao
                    $tabela        = "T057_extensao";

                    //monta o array para inserir dados na tabela
                    $arrayExtensao = array ( "T057_nome"=>$extensao
                                           , "T057_desc"=>"[Automático via Sistema]");
                    //insere o array na tabela
                    $insere = $obj->inserir($tabela, $arrayExtensao);

                    $RetornaExt          = $obj->selecionaExtensao($extensao);  

                    //varre novamente o array em busca do codigo da extensão
                    foreach ($RetornaExt   as $campos=>$valores)
                    {
                     echo $CodigoExt  =   $valores['Codigo'];             
                    }                    
                }    

        if (!empty($CodigoExt))
           {                       
                //Seta no post a extensão de acordo com o código encontrado no foreach acima
                $_POST['T057_codigo']       =   $CodigoExt;
                //Seta no post a data atual do sistema
                
                $ArquivoNome                =   $_POST['T055_nome'];
                $ArquivoDescricao           =   "[Automático] - P0056/Imagens Painel Digital";
                $ArquivoDtUpload            =   date("d/m/Y");
                $ArquivoLogin               =   $_POST['T004_login'];
                $ArquivoExtensao            =   $_POST['T057_codigo'];
                $ArquivoCategoria           =   $_POST['T056_codigo'];
                $ArquivoProcesso            =   "1";

                //prepara para inserçao de dados no banco
                //Seta a variável $tabela de arquivos T055_arquivos
                $tabela                    =    "T055_arquivos";                    

                $dados                     =    array(
                                                        "T055_nome"       => $ArquivoNome
                                                     ,  "T055_desc"       => $ArquivoDescricao
                                                     ,  "T055_dt_upload"  => $ArquivoDtUpload
                                                     ,  "T004_login"      => $ArquivoLogin
                                                     ,  "T057_codigo"     => $ArquivoExtensao
                                                     ,  "T056_codigo"     => $ArquivoCategoria
                                                     ,  "T061_codigo"     => $ArquivoProcesso
                                                     );
                
                //Instancia classe para inserir
                $insere                    =    $obj->inserir($tabela, $dados);
                //Retorna o código do arquivo inserido
                $codigo_arquivo            =    $obj->lastInsertId();
                
                //Associa/inseri Produto e Arquivo - T055_T075
                $ProdutoCodigo  =   $_POST['T075_codigo'];
                $ProdutoDigito  =   $_POST['T075_digito'];
                 
                $tabela                    =    "T055_T075";
                $dados                     =    array(
                                                        "T055_codigo"              =>  $codigo_arquivo
                                                     ,  "T075_codigo"              =>  $ProdutoCodigo
                                                     ,  "T075_digito"              =>  $ProdutoDigito
                                                     );
                $insere                    =    $obj->inserir($tabela, $dados);

                //Prepara para mover o arquivo, seta os paths
                echo "<br/>";
                //Path com o nome do arquivo setado pelo usuario
                echo $path_novo         = $diretorio.$categoria."/".$arquivo;
                echo "<br/>";
                //Path para renomear o arquivo
                echo $path_novo_rename  = $diretorio.$categoria."/".$obj->preencheZero("E", 8, $codigo_arquivo);

                //Iniciar a manipulação do arquivo
                if (move_uploaded_file($temporario, $path_novo))
                   { //move o arquivo que esta sendo upado no sistema do temporário para o path de destino
                    echo "ARQUIVO MOVIDO COM SUCESSO";
                    echo "<br/>";
                    if (rename($path_novo, $path_novo_rename))
                       { //renomeia o arquivo recem movido do temporário para o Código do arquivo no banco 
                        echo "AQUIRVO RENOMEADO COM SUCESSO";
                        echo "<br/>";

                        //Redireciona a página, pois o arquivo foi gravado com sucesso
                        header("location:?router=T0056/associar&ProdutoCodigo=".$ProdutoCodigo);                    
                       }
                    else
                       { //Mostra mensagem se o arquivo movido não for renomeado com o Código do arquivo no banco
                        echo "<script>alert('ARQUIVO NÃO FOI RENOMEADO');</script>";
                        echo "<script>window.location = '?router=T0056/associar&ProdutoCodigo='$ProdutoCodigo;</script>";
                       }
                   }
                 else
                   { //Mostra mensagem se o arquivo não for movido do diretório temporário para o de categoria
                    echo "<script>alert('NÃO MOVEU O ARQUIVO DO TEMPORÁRIO PARA O DIRETÓRIO DE CATEGORIA');</script>";
                    echo "<script>window.location = '?router=T0056/associar&ProdutoCodigo='$ProdutoCodigo;</script>";              
                   }
            }        
        else
            { //Mostra mensagem se não foi encontrado a extensão
                 echo "<script>alert('NAO HÁ A EXTENSÃO INFORMADA NO ARQUIVO');</script>";
                 echo "<script>window.location = '?router=T0056/associar&ProdutoCodigo='$ProdutoCodigo;</script>";           
            }
       }
    else
       { //Mostra mensagem caso o arquivo ultrapasse o tamanho limite do parametro de 10MB
        ?>
        <script>alert('ARQUIVO ULTRAPASSOU O TAMANHO LIMITE.\nTAMANHO TOTAL DE UPLOAD: 10 MB\nTAMANHO DO ARQUIVO SELECIONADO: <?php echo round($tamanho,2)." MB"; ?>');</script>  
        <script>window.location = '?router=T0056/associar&ProdutoCodigo='<?php echo $ProdutoCodigo;?></script>        
        <?php
       }
}
else
{
    echo "<script>alert('NÃO CONSEGUIU CARREGAR O ARQUIVO');</script>";
    echo "<script>window.location = '?router=T0056/associar&ProdutoCodigo='$ProdutoCodigo;</script>";  
}
?>