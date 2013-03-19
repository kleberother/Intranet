<?php
 
/**************************************************************************/
/*                          DAVÓ SUPERMERCADOS                            */
/* Criado em: 25/07/2011 por Jorge Nova  / Alexandre Alves                */
/* Descrição: Classe para executar as Querys do Programa T0029            */
/**************************************************************************/

class models_T0029 extends models
{


    public function inserir($tabela,$campos)
    {
        $insere =  $this->exec($this->insere($tabela, $campos));
        if($insere)
             $this->alerts('false', 'Alerta!', 'Incluído com Sucesso!');
        else
             $this->alerts('true', 'Erro!', 'Não foi possível Incluir!');         
        
        return $insere;
    } 

    public function excluir($tabela, $delim)
    {
        $exclui = $this->exec($this->exclui($tabela, $delim));

       	if($exclui)
		$this->alerts('false', 'Alerta!', 'Excluído com Sucesso!');
       	else
		$this->alerts('true', 'Erro!', 'Não foi possível Excluir!'); 

	return $exclui;
    }
    
    public function Alterar($tabela,$campos,$delim)
    {
       $conn = "";
       $altera = $this->exec($this->atualiza($tabela, $campos, $delim));

       if($altera)
            $this->alerts('false', 'Alerta!', 'Alterado com Sucesso!');
       else
            $this->alerts('true', 'Erro!', 'Não foi possível Alterar!');   

	return $altera;
    } 
    
    // Retorna único arquivo de acordo com o código
    public function retornaArquivoUnico($codigo)
    {
        $sql = "SELECT T1.T055_nome     Nome
                     , T1.T055_desc     Descricao
                     , T1.T056_codigo   Tipo
                     , T1.T004_login    Publisher
                     , T1.T004_owner    Owner
                     , TJ1.T004_nome	NomeOwner
                  FROM T055_arquivos T1
                  JOIN T004_usuario TJ1 ON ( TJ1.T004_login = T1.T004_owner )
                 WHERE T1.T055_codigo = $codigo";
        
        return $this->query($sql);
    }

    //Para Upload
    public function selecionaExtensao($extensao)
    {
       return $this->query("SELECT T1.T057_codigo   Codigo
                                  , T1.T057_nome    Nome
                                  , T1.T057_desc    Descricao
                               FROM T057_extensao   T1
                              WHERE T1.T057_nome = '$extensao'");
    }

    public function retornaTipoArquivos()
    {
       return $this->query("SELECT DISTINCT TF1.T056_codigo	Codigo
                                 , TF1.T056_nome		Nome
                              FROM T056_categoria_arquivo TF1
                              JOIN T055_arquivos TJ1 ON ( TF1.T056_codigo = TJ1.T056_codigo)
                             WHERE TJ1.T061_codigo IS NULL");
    }

    public function retornaArquivos($user,$Filtro)
    {
        // SQL Principal
        $sql  = "SELECT  T55.T055_codigo                            Codigo
                       , T55.T055_nome                              Nome
                       , T55.T055_desc                              Descricao
                       , date_format(T55.T055_dt_upload,'%d/%m/%Y') DataUp
                       , T55.T004_owner 			    Usuario
                       , T04.T004_nome                              NomeUsuario
                       , T55.T056_codigo	                    CodCategoria
                       , T56.T056_nome                              NomeCategoria
                       , T55.T057_codigo			    CodExtensao
                       , T57.T057_nome                              NomeExtensao
                   FROM T055_arquivos T55
                   LEFT JOIN ( -- arquivos com permissao para o usuario
                                    SELECT T0455.T055_codigo ArquivoCodigoU
                                 FROM T004_T055 T0455
                                WHERE T0455.T004_login  = '$user'
                                  AND T0455.T004_T055_visualizar = 1
                             ) SEU  ON ( SEU.ArquivoCodigoU  = T55.T055_codigo)
                   LEFT JOIN ( -- arquivos com permissao para os perfis do usuario
                                    SELECT T0955.T055_codigo   ArquivoCodigoP
                                         , T0955.T009_codigo   PerfilCodigo
                                 FROM T009_T055 T0955
                                 JOIN T004_T009 T0409  ON ( T0409.T009_codigo = T0955.T009_codigo )
                                WHERE T0409.T004_login     = '$user'
                                                           AND T009_T055_visualizar = 1
                             ) SEP ON ( SEP.ArquivoCodigoP = T55.T055_codigo )
                   LEFT JOIN (-- arquivos com permissao para os departamentos dos usuario
                               SELECT T550677.T055_codigo ArquivoCodigoD
                                    , T550677.T077_codigo DepartamentoCodigo
                                    , T550677.T006_codigo LojaCodigo 
                                 FROM T055_T006T077  T550677
                                 JOIN T004_T006_T077 T040677  ON (    T040677.T077_codigo = T550677.T077_codigo
                                                                  AND T040677.T006_codigo = T550677.T006_codigo )                                   
                                WHERE T040677.T004_login = '$user'
                                  AND T550677.T055_T006T077_visualizar = 1
                                         )	SED ON ( SED.ArquivoCodigoD = T55.T055_codigo )
                        JOIN T056_categoria_arquivo   T56    ON ( T56.T056_codigo   = T55.T056_codigo   )
                        JOIN T057_extensao 	        T57    ON ( T57.T057_codigo   = T55.T057_codigo   )
                        JOIN T004_usuario            T04    ON ( T04.T004_login = T55.T004_owner )
                 WHERE T55.T061_codigo IS NULL -- somente arquivos sem processos (nao automaticos)
                   AND ( -- permissoes para o proprietario
                          ( T55.T004_owner	= '$user'      )
                          OR	-- permissoes para usuario
                          ( SEU.ArquivoCodigoU IS NOT NULL )
                          OR -- permissoes por perfil
                          ( SEP.ArquivoCodigoP IS NOT NULL )
                          OR -- permissoes por departamento
                          ( SED.ArquivoCodigoD IS NOT NULL )
                         ) ";
        // Monta SQL com os Filtros passados
        $sql .= $Filtro ;
        $sql .= " ORDER BY 1 DESC";
        //echo $sql;
        return $this->query($sql);

       // BACKUP, NAO APAGAR POR ENQUANTOO
//       return $this->query("SELECT DISTINCT
//                                   T55.T055_codigo                            Codigo
//                                 , T55.T055_nome			      Nome
//                                 , T55.T055_desc			      Descricao
//                                 , date_format(T55.T055_dt_upload,'%d/%m/%Y') DataUp
//                                 , T55.T004_login 			      Usuario
//                                 , T55.T056_codigo	                      CodCategoria
//                                 , T56.T056_nome			      NomeCategoria
//                                 , T55.T057_codigo			      CodExtensao
//                                 , T57.T057_nome			      NomeExtensao
//                              FROM ( -- retona arquivos que o usuario pode visualizar
//                                     -- arquivos do proprio usuario
//                                     SELECT T55.T055_codigo ArquivoCodigo
//                                       FROM T055_arquivos T55
//                                      WHERE T55.T004_login	= '$user'
//                                      UNION
//                                     -- arquivos com permissao para o usuario
//                                     SELECT T0455.T055_codigo ArquivoCodigo
//                                       FROM T004_T055 T0455
//                                      WHERE T0455.T004_login = '$user'
//                                        AND T0455.T004_T055_visualizar = 1
//                                      UNION
//                                     -- arquivos com permissao para os perfis do usuario
//                                     SELECT T0955.T055_codigo ArquivoCodigo
//                                       FROM T009_T055 T0955
//                                       JOIN T004_T009 T0409  ON ( T0409.T009_codigo = T0955.T009_codigo )
//                                      WHERE T0409.T004_login	= '$user'
//                                        AND T0955.T009_T055_visualizar = 1
//                                      UNION
//                                     -- arquivos com permissao para os departamentos dos usuario
//                                     SELECT T5577.T055_codigo ArquivoCodigo
//                                       FROM T055_T077 T5577
//                                       JOIN T004_T077 T0477  ON ( T0477.T077_codigo = T5577.T077_codigo )
//                                      WHERE T0477.T004_login = '$user'
//                                        AND T5577.T055_T077_visualizar = 1
//                                   )	SE1
//                              JOIN T055_arquivos 	    T55    ON ( T55.T055_codigo   = SE1.ArquivoCodigo )
//                              JOIN T056_categoria_arquivo   T56    ON ( T56.T056_codigo   = T55.T056_codigo   )
//                              JOIN T057_extensao 	    T57    ON ( T57.T057_codigo   = T55.T057_codigo   )
//                             WHERE T55.T061_codigo IS NULL -- somente arquivos sem processos
//                          ORDER BY 1 DESC");
    }
    
      public function retornaUsuariosComPermissao($cod)
    {
       return $this->query("SELECT T0455.T004_login	      Login
                                 , T04.T004_nome	      Nome
                                 , T0455.T004_T055_visualizar Visualizar
                                 , T0455.T004_T055_alterar    Alterar
                                 , T0455.T004_T055_excluir    Excluir
                             FROM T004_T055    as T0455
                             JOIN T004_usuario as T04 ON ( T04.T004_login = T0455.T004_login )
                            WHERE T0455.T055_codigo = $cod");
    }

    public function retornaPerfis($cod)
    {
        return $this->query("  SELECT T09.T009_codigo          Codigo
                                    , T09.T009_nome            Nome
                                 FROM T009_perfil T09
                            LEFT JOIN (  
                                       SELECT DISTINCT
                                              T0955.T009_codigo Codigo
                                         FROM T009_T055 T0955
                                        WHERE T0955.T055_codigo = $cod
                                       ) SE1 ON ( SE1.codigo = T09.T009_codigo )
                                WHERE  SE1.Codigo IS NULL
                                   ORDER BY 1 ; ");
    }

    public function retornaPerfisFiltro()
    {
        return $this->query("  SELECT T09.T009_codigo   Codigo
                                    , T09.T009_nome     Nome
                                 FROM T009_perfil       T09
                             ORDER BY T009_nome");
    }

    public function retornaPerfisComPermissao($cod)
    {
        return $this->query("SELECT T0955.T009_codigo          Codigo
                                  , T09.T009_nome              Nome
                                  , T0955.T009_T055_visualizar Visualizar
                                  , T0955.T009_T055_alterar    Alterar
                                  , T0955.T009_T055_excluir    Excluir          
                               FROM T009_T055   as T0955
                               JOIN T009_perfil as T09   ON ( T09.T009_codigo = T0955.T009_codigo )
                              WHERE T0955.T055_codigo = $cod
                                ORDER BY 1 ;");
    }

    public function retornaDepartamentos($cod)
    {
        return $this->query("
                            SELECT T77.T077_codigo     Codigo
                                 , T77.T077_nome       Nome
                              FROM T077_departamento T77
                              LEFT JOIN (  
                                        SELECT DISTINCT
                                                    T5577.T077_codigo Codigo
                                          FROM T055_T077 T5577
                                          WHERE T5577.T055_codigo = $cod
                                         ) SE1 ON ( SE1.codigo = T77.T077_codigo )
                               WHERE  SE1.Codigo IS NULL
                            ");
    }

    public function retornaDepartamentosFiltro()
    {
        return $this->query("
                            SELECT T77.T077_codigo     Codigo
                                 , T77.T077_nome       Nome
                              FROM T077_departamento   T77
                          ORDER BY T77.T077_nome");
    }

    public function retornaDepartamentosComPermissao($cod)
    {
        return $this->query("SELECT TF1.T077_codigo			CodigoDepartamento
                                  , TJ2.T077_nome			NomeDepartamento
                                  , TF1.T006_codigo			CodigoLoja
                                  , TJ1.T006_nome         		NomeLoja	
                                  , TF1.T055_T006T077_visualizar	Visualizar
                                  , TF1.T055_T006T077_alterar		Alterar
                                  , TF1.T055_T006T077_excluir 		Excluir
                               FROM T055_T006T077     TF1
                               JOIN T006_loja         TJ1 ON ( TJ1.T006_codigo = TF1.T006_codigo)
                               JOIN T077_departamento TJ2 ON ( TJ2.T077_codigo = TF1.T077_codigo)	   
                              WHERE TF1.T055_codigo = $cod");
    }

    public function retornaPermissaoPermissoes($user,$cod,$permissao)
    {
       // verifica qual permissao esta sendo verificada
       switch ($permissao)
       {

           case 'P': // permissao de alterar permissoes
               if ($_SESSION['user'] == $user)
                   $retorno = 1;
                   break;
           case 'V':
                      $sql = $this->query("SELECT SE1.nivel     nivel
                                                , SE1.permissao permissao
                                              FROM (
                                                         -- arquivos com permissao para os departamentos dos usuario
                                                           SELECT 1 nivel
                                                             , T550677.T055_T006T077_visualizar permissao
                                                          FROM T055_T006T077  T550677
                                                          JOIN T004_T006_T077 T040677  ON ( T040677.T077_codigo = T550677.T077_codigo )
                                                         WHERE T040677.T004_login = '$user'
                                                           AND T550677.T055_codigo = $cod 
                                                         UNION
                                                         -- arquivos com permissao para os perfis do usuario
                                                         SELECT 2 nivel
                                                                   , T0955.T009_T055_visualizar permissao
                                                           FROM T009_T055 T0955
                                                           JOIN T004_T009 T0409  ON ( T0409.T009_codigo = T0955.T009_codigo )
                                                          WHERE T0409.T004_login  = '$user'
                                                            AND T0955.T055_codigo =  $cod
                                                          UNION
                                                         -- arquivos com permissao para o usuario
                                                         SELECT 3 nivel
                                                                   , T0455.T004_T055_visualizar permissao
                                                           FROM T004_T055 T0455
                                                          WHERE T0455.T004_login  = '$user'
                                                            AND T0455.T055_codigo =  $cod
                                                  ) SE1
                                           ORDER BY 1 DESC
                                           LIMIT 1
                                         ");
               //print_r($sql);
                 foreach($sql as $campos1=>$valores1)
                 {
                    $retorno = $valores1['permissao'];
                 }
                 break;
           case 'A': // permissao de alterar
                      $sql = $this->query("SELECT SE1.nivel     nivel
                                                , SE1.permissao permissao
                                              FROM (
                                                         -- arquivos com permissao para os departamentos dos usuario
                                                        SELECT 1 nivel
                                                             , T550677.T055_T006T077_alterar permissao
                                                          FROM T055_T006T077  T550677
                                                          JOIN T004_T006_T077 T040677  ON ( T040677.T077_codigo = T550677.T077_codigo )
                                                         WHERE T040677.T004_login = '$user'
                                                           AND T550677.T055_codigo = $cod 
                                                         UNION
                                                         -- arquivos com permissao para os perfis do usuario
                                                         SELECT 2 nivel
                                                                   , T0955.T009_T055_alterar permissao
                                                           FROM T009_T055 T0955
                                                           JOIN T004_T009 T0409  ON ( T0409.T009_codigo = T0955.T009_codigo )
                                                          WHERE T0409.T004_login  = '$user'
                                                            AND T0955.T055_codigo =  $cod
                                                          UNION
                                                         -- arquivos com permissao para o usuario
                                                         SELECT 3 nivel
                                                                   , T0455.T004_T055_alterar permissao
                                                           FROM T004_T055 T0455
                                                          WHERE T0455.T004_login  = '$user'
                                                            AND T0455.T055_codigo =  $cod
                                                  ) SE1
                                         ORDER BY 1 DESC
                                         LIMIT 1
                                         ");
                 foreach($sql as $campos1=>$valores1)
                 {
                    $retorno = $valores1['permissao'];
                 }
                 break;
           case 'E': // permissao de excluir
                      $sql = $this->query("SELECT SE1.nivel     nivel
                                                , SE1.permissao permissao
                                              FROM (
                                                         -- arquivos com permissao para os departamentos dos usuario
                                                        SELECT 1 nivel
                                                             , T550677.T055_T006T077_excluir permissao
                                                          FROM T055_T006T077  T550677
                                                          JOIN T004_T006_T077 T040677  ON ( T040677.T077_codigo = T550677.T077_codigo )
                                                         WHERE T040677.T004_login  = '$user'
                                                           AND T550677.T055_codigo = $cod 
                                                         UNION
                                                         -- arquivos com permissao para os perfis do usuario
                                                         SELECT 2 nivel
                                                                   , T0955.T009_T055_excluir permissao
                                                           FROM T009_T055 T0955
                                                           JOIN T004_T009 T0409  ON ( T0409.T009_codigo = T0955.T009_codigo )
                                                          WHERE T0409.T004_login  = '$user'
                                                            AND T0955.T055_codigo =  $cod
                                                          UNION
                                                         -- arquivos com permissao para o usuario
                                                         SELECT 3 nivel
                                                                   , T0455.T004_T055_excluir permissao
                                                           FROM T004_T055 T0455
                                                          WHERE T0455.T004_login  = '$user'
                                                            AND T0455.T055_codigo =  $cod
                                                  ) SE1
                                         ORDER BY 1 DESC
                                         LIMIT 1
                                         ");
                 foreach($sql as $campos1=>$valores1)
                 {
                    $retorno = $valores1['permissao'];
                 }
                 break;

           default:
             $retorno = 0;
             break;

       }
        // verifica se possui permissao e retorna da funcao
        if ($retorno)
            return 1 ;
        else
            return 0 ;
    }
   
    public function retornaExtensaoArquivos($cod)
    {
        return $this->query("SELECT T55.T057_codigo Codigo 
                                  , T57.T057_nome   Nome
                               FROM T055_arquivos T55
                               JOIN T057_extensao T57 ON ( T57.T057_codigo = T55.T057_codigo)
                              WHERE T055_codigo = $cod");
    }
    
    public function retornaUsuarioUP($user)
    {
        return $this->query("SELECT T004_permissao_arquivo Permissao
                               FROM T004_usuario  
                              WHERE T004_login = '$user'");
    }

    public function retornaParametroUP()
    {
        return $this->query("SELECT T003_valor  Valor
                               FROM T003_parametro
                              WHERE T003_codigo = 1");
    }
    
    public function retornaLojas()
    {
        $sql = "SELECT TF1.T006_codigo 	Codigo
                     , TF1.T006_nome	Nome 
                  FROM T006_loja TF1";
        
        return $this->query($sql);
    }    
    
}
?>