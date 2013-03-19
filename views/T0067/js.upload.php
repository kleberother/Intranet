<?php

if (empty($_POST["T055_codigo"]))
   {//valida o tipo, se for vazio, é um upload não existente, se for igual a 1, o usuário esta
    //alterando o arquivo [ir para else] linha 151
    if (!empty($_FILES["P0067_arquivo"]))
       {      
        //DECLARAÇÕES E PARAMETROS
        //Instancia Classe models_T0067
        $objUpload           =  new models_T0067($conn);
        
        //Tamanho total do arquivo
        $tamanho             =  ($_FILES["P0067_arquivo"]['size']/1024)/1024;
        
        //Parametro para ver se o arquivo ultrapassou o tamanho limite de upload
        $parametro           =  $objUpload->retornaParametroUP();
        
        foreach($parametro as $campos=>$valores)
        {
         $parametro_valor    = $valores['Valor'];     
        }
        
        
        if ( $tamanho < $parametro_valor )
           {
            
            //arquivo físico nome+extensão
            $arquivo             =  $_FILES["P0067_arquivo"]['name'];    
            
            //Pasta aonde encontra-se os arquivos
            $diretorio           =  CAMINHO_ARQUIVOS."CAT";         
            
            //tipo do arquivo, vai determinar a pasta no qual o arquivo se encontra           
            $categoria           =  $objUpload->preencheZero("E", 4, $_POST['T056_codigo']);             
            
            //caminho temporário
            $temporario          =  $_FILES["P0067_arquivo"]['tmp_name'];
            
            //Nome do arquivo
            $nome                =  $objUpload->SepararNome($arquivo);
            //Extensão do arquivo
            $extensao            =  $objUpload->SepararExtensao($arquivo); 

            //Verfica se a extensão existe na tabela de extensões
            $tabela              =  "T057_extensao";
            $RetornaExt          =  $objUpload->selecionaExtensao($extensao);
            
            // Retira o espaço da posição T004_login
            $_POST['T004_login'] = trim($_POST['T004_login']); 
            
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
                                       , "T057_desc"=>"Insert Autmático via upload de arquivo");
                //insere o array na tabela
                $insere = $objUpload->inserir($tabela, $arrayExtensao);

                $RetornaExt          = $objUpload->selecionaExtensao($extensao);  

                //varre novamente o array em busca do codigo da extensão
                foreach ($RetornaExt   as $campos=>$valores)
                {
                 $CodigoExt  =   $valores['Codigo'];             
                }                    
               }               
               
            if (!empty($CodigoExt))
               {                       
                //Seta no post a extensão de acordo com o código encontrado no foreach acima
                $_POST['T057_codigo']      =   $CodigoExt;
                //Seta no post a data atual do sistema
                $_POST['T055_dt_upload']   =   date("d/m/Y");
                //Formata a variavel $_POST['T055_owner'], retirando o nome e deixando só o login
                $_POST['T004_owner']       =   trim($_POST['T004_owner']);

                //prepara para inserçao de dados no banco
                //Seta a variável $tabela de arquivos T055_arquivos
                $tabela                    =  "T055_arquivos";                    

                //Instancia classe para inserir
                $insere                    =  $objUpload->inserir($tabela, $_POST);
                
                //Retorna o código do arquivo inserido
                $codigo_arquivo            =  $objUpload->lastInsertId();
                
                //Prepara para mover o arquivo, seta os paths

                //Path com o nome do arquivo setado pelo usuario
                $path_novo         = $diretorio.$categoria."/".$arquivo;

                //Path para renomear o arquivo
                $path_novo_rename  = $diretorio.$categoria."/".$objUpload->preencheZero("E", 8, $codigo_arquivo);

                //Iniciar a manipulação do arquivo
                if (move_uploaded_file($temporario, $path_novo))
                   { //move o arquivo que esta sendo upado no sistema do temporário para o path de destino               
                    if (rename($path_novo, $path_novo_rename))
                       {// Renomeia o arquivo recem movido do temporário para o Código do arquivo no banco 
                       
                        // Encontra os demais usuários que poderão ver o arquivo escolhidos pelo Grantor
                        $buscaUsuariosGrantor   =   $objUpload->retornaUsuariosGrantors($_POST['T004_login']);
                        
                        // Faz inserção para cada usuário que foi definido como "Grantor" também
                        foreach($buscaUsuariosGrantor as $campos=>$valores)
                        {
                            $arrayGrantor   =   array ( "T055_codigo"           => $codigo_arquivo
                                                      , "T004_login"            => $valores['Grantor']  
                                                      , "T004_T055_visualizar"  => 1
                                                      , "T004_T055_alterar"     => 1
                                                      , "T004_T055_excluir"     => 0    );
                            
                            $objUpload->inserir("T004_T055",$arrayGrantor);      
                        }

                        
                        $data = date('d/m/Y H:i:s');
                        
                        // Prepara array para inserir na tabela de auditoria 
                        $array  =   array   (   "T066_data"         => $data
                                            ,   "T066_usu_login"    => $_SESSION['user']
                                            ,   "T066_usu_nome"     => $_SESSION['DisplayNome']
                                            ,   "T066_obj_codigo"   => "67"
                                            ,   "T066_obj_nome"     => "JS.UPLOAD"
                                            ,   "T066_ocorrencia"   => "ARQUIVO N $codigo_arquivo|INSERT|USUARIO EXTERNO CRIOU UM NOVO ARQUIVO"
                                            ,   "T066_address"      => $_SERVER['REMOTE_ADDR'] );

                        // Insere dados na tabela de auditoria
                        $objUpload->inserir("T066_auditoria", $array);
                        
                        // Redireciona a página, pois o arquivo foi gravado com sucesso                        
                        echo "<script>window.location = '?router=T0067/home';</script>";                    
                       }
                    else
                       { //Mostra mensagem se o arquivo movido não for renomeado com o Código do arquivo no banco
                        echo "<script>alert('ARQUIVO NÃO FOI RENOMEADO');</script>";
                        echo "<script>window.location = '?router=T0067/home';</script>";
                       }
                   }
                 else
                   { //Mostra mensagem se o arquivo não for movido do diretório temporário para o de categoria
                    echo "<script>alert('NÃO MOVEU O ARQUIVO DO TEMPORÁRIO PARA O DIRETÓRIO DE CATEGORIA');</script>";
                    echo "<script>window.location = '?router=T0067/home';</script>";              
                   }
                }        
            else
                { //Mostra mensagem se não foi encontrado a extensão
                 echo "<script>alert('NAO HÁ A EXTENSÃO INFORMADA NO ARQUIVO');</script>";
                 echo "<script>window.location = '?router=T0067/home';</script>";           
                }
           }
        else
           { //Mostra mensagem caso o arquivo ultrapasse o tamanho limite do parametro de 10MB
            ?>
            <script>alert('ARQUIVO ULTRAPASSOU O TAMANHO LIMITE.\nTAMANHO TOTAL DE UPLOAD: 20 MB\nTAMANHO DO ARQUIVO SELECIONADO: <?php echo round($tamanho,2)." MB"; ?>');</script>  
            <script>window.location = '?router=T0067/home';</script>        
            <?php
           }
       }
    else
       {
        echo "<script>alert('NÃO CONSEGUIU CARREGAR O ARQUIVO');</script>";
        echo "<script>window.location = '?router=T0067/home';</script>";      
       }
   }
else
   {//UPLOAD DE ALTERAÇÃO DE ARQUIVO
    //Instancia Classe models_T0067
    $objUpload  =   new models_T0067($conn);

    //DECLARANDO VARIÁVEIS 

    //arquivo físico nome+extensão
    $arquivo             =  $_FILES["P0067_arquivo"]['name'];    
    //Extensão do arquivo
    $extensao            = $objUpload->SepararExtensao($arquivo);     

    //Código do arquivo
    $codigo_arquivo      =  $_POST["T055_codigo"];     
    
    //Extensão nova
    $extensao_nova       = $objUpload->SepararExtensao($arquivo);

    //Extensão antiga
    $objExtensaoAntiga   = $objUpload->retornaExtensaoArquivos($codigo_arquivo);
    
    //Faz o foreach para encontrar o resultado da extensão antiga
    foreach($objExtensaoAntiga as $campos=>$valores)
    {
        $extensao_antiga  = $valores['Nome'];
    }
    
    //Verifica se a extensão do arquivo novo é igual ao do arquivo antigo
    if ($extensao_nova == $extensao_antiga)
       {
    
        //Tamanho total do arquivo
        $tamanho             =  ($_FILES["P0067_arquivo"]['size']/1024)/1024;

        //Parametro para ver se o arquivo ultrapassou o tamanho limite de upload
        $parametro           =  $objUpload->retornaParametroUP();

        foreach($parametro as $campos=>$valores)
        {
         $parametro_valor    = $valores['Valor'];     
        }
        //verifica se o tamanho do arquivo a ser upado, é menor ou igual ao parametro setado de 10MB
        if ( $tamanho < $parametro_valor )
           {           
            //Pasta aonde encontra-se os arquivos
            $diretorio           =  CAMINHO_ARQUIVOS."CAT";         
            //tipo do arquivo, vai determinar a pasta no qual o arquivo se encontra
            $categoria           =  $objUpload->preencheZero("E", 4, $_POST['T056_codigo']); 
            //caminho temporário
            $temporario          =  $_FILES["P0067_arquivo"]['tmp_name'];

            //paths para renomear o arquivo existente
            //Path em que hoje se encontra o arquivo
            $path_velho          =  $diretorio.$categoria."/".$objUpload->preencheZero("E", 8, $codigo_arquivo);
            //Path do nome novo, que vai ser feito o upload
            $path_novo           =  $diretorio.$categoria."/".$arquivo;
            //Path para renomear o arquivo movido ao diretorio
            $path_novo_rename    =  $diretorio.$categoria."/".$objUpload->preencheZero("E", 8, $codigo_arquivo);
            //Path para renomear o arquivo antigo para um arquivo Backup
            $path_bkp            =  $diretorio.$categoria."/".$codigo_arquivo."-BKP.".$ext;

            //renomeando arquivo
            if (rename($path_velho, $path_bkp))
               { //renomeia o arquivo para um arquivo BKP
                //echo "Arquivo renomeado com sucesso.";
                //echo "<br/>";

                //copia outro arquivo para o local
                if (move_uploaded_file($temporario, $path_novo))
                   { //move o arquivo que esta sendo upado no sistema do temporário para o path de destino
                    //echo "Arquivo movido com sucesso";   
                    //echo "<br/>"; 

                    if (rename($path_novo, $path_novo_rename))
                       { //renomeia o arquivo recem movido do temporário para o Código do arquivo no banco
                        //echo "Arquivo novo renomeado com sucesso"; 
                        //echo "<br/>";

                        if (unlink($path_bkp))
                           { //exclui o arquivo backup, já que o procedimento inteiro deu certo de substituição de arquivo
                            //echo "Arquivo BACKUP excluído com sucesso!";
                            //echo "<br/>";

                            //Redireciona para a home, pois o arquivo foi alterado com sucesso!
                            header("location:?router=T0067/home");
                           }
                        else
                           { //retorna a mensagem de erro ao tentar excluir o arquivo backup
                            echo "<script>alert('ARQUIVO BACKUP NÃO FOI EXCLUIDO.');</script>";  
                            echo "<script>window.location = '?router=T0067/home';</script>";                      
                           }
                       }
                    else
                       { //mostra a mensagem caso não seja renomeado com sucesso o arquivo do temporário
                        echo "<script>alert('ARQUIVO NOVO NÃO FOI RENOMEADO');</script>";    
                        echo "<script>window.location = '?router=T0067/home';</script>";                 
                       }
                   }
                else
                   { //mostra a mensagem caso o arquivo não seja movido do temporário para o diretório do sistema
                    echo "<script>alert('ARQUIVO NÃO FOI MOVIDO');</script>";   
                    echo "<script>window.location = '?router=T0067/home';</script>";                     
                   }
               }   
            else
               { //mostra a mensagem caso o arquivo antigo não seja renomeado para BKP.
                echo "<script>alert('NÃO FOI POSSÍVEL RENOMEAR O ARQUIVO.');</script>";
                echo "<script>window.location = '?router=T0067/home';</script>";            
               } 
           }
        else
           { //Mostra mensagem caso o arquivo ultrapasse o tamanho limite do parametro de 10MB
            ?>
            <script>alert('ARQUIVO ULTRAPASSOU O TAMANHO LIMITE.\nTAMANHO TOTAL DE UPLOAD: 10 MB\nTAMANHO DO ARQUIVO SELECIONADO: <?php echo round($tamanho,2)." MB"; ?>');</script>  
            <script>window.location = '?router=T0067/home';</script>        
            <?php
           }
       }
    else
       { //retorna a mensagem caso a extensão do arquivo atual não for igual ao arquivo antigo
        ?>
        <script>alert('O ARQUIVO NÃO É IGUAL AO ANTIGO DE ACORDO COM A EXTENSÃO. \nEXTENSÃO NOVA: <?php echo strtoupper($extensao_nova); ?> \nEXTENSÃO ANTIGA: <?php echo strtoupper($extensao_antiga); ?>');</script>  
        <script>window.location = '?router=T0067/home';</script>        
        <?php
       }
   }
?>
