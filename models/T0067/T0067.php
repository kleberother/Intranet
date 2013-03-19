<?php
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 22/12/2011 por Jorge Nova
 * Descrição:   
           
***************************************************************************/

class models_T0067 extends models
{

   public function inserir($tabela,$campos)
    {
        $insere =  $this->exec($this->insere($tabela, $campos));
//        if($insere)
//             $this->alerts('false', 'Alerta!', 'Incluído com Sucesso!');
//        else
//             $this->alerts('true', 'Erro!', 'Não foi possível Incluir!');         
        
        return $insere;
    } 

    public function excluir($tabela, $delim)
    {
        $exclui = $this->exec($this->exclui($tabela, $delim));

//       	if($exclui)
//		$this->alerts('false', 'Alerta!', 'Excluído com Sucesso!');
//       	else
//		$this->alerts('true', 'Erro!', 'Não foi possível Excluir!'); 

	return $exclui;
    }
    
    public function Alterar($tabela,$campos,$delim)
    {
       $conn = "";
       $altera = $this->exec($this->atualiza($tabela, $campos, $delim));

//       if($altera)
//            $this->alerts('false', 'Alerta!', 'Alterado com Sucesso!');
//       else
//            $this->alerts('true', 'Erro!', 'Não foi possível Alterar!');   

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

    public function retornaArquivos($user)
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
                        JOIN T056_categoria_arquivo   T56    ON ( T56.T056_codigo   = T55.T056_codigo   )
                        JOIN T057_extensao 	        T57    ON ( T57.T057_codigo   = T55.T057_codigo   )
                        JOIN T004_usuario            T04    ON ( T04.T004_login = T55.T004_owner )
                 WHERE T55.T061_codigo IS NULL -- somente arquivos sem processos (nao automaticos)
                   AND ( -- permissoes para o proprietario
                          ( T55.T004_login	= '$user'      )
                         ) 
                   AND  T55.T056_codigo = 19 -- somente arquivos extranet";
        $sql .= " ORDER BY 1 DESC";
        //echo $sql;
        return $this->query($sql);
    }

    public function retornaArquivosComPermissao($user)
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
                        JOIN T056_categoria_arquivo   T56    ON ( T56.T056_codigo   = T55.T056_codigo   )
                        JOIN T057_extensao 	      T57    ON ( T57.T057_codigo   = T55.T057_codigo   )
                        JOIN T004_usuario             T04    ON ( T04.T004_login = T55.T004_owner       )
                 WHERE T55.T061_codigo IS NULL -- somente arquivos sem processos (nao automaticos)
                   AND  SEU.ArquivoCodigoU IS NOT NULL
                   AND  T55.T056_codigo = 19 -- somente arquivos extranet";

        $sql .= " ORDER BY 1 DESC";
        //echo $sql;
        return $this->query($sql);
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
        return $this->query("SELECT TJ1.T089_valor Valor
                               FROM T003_parametros TF1
                               JOIN T089_parametro_detalhe TJ1 ON ( TJ1.T003_codigo = TF1.T003_codigo )
                              WHERE TF1.T003_codigo = 3");
    }
    
    public function retornaLojas()
    {
        $sql = "SELECT TF1.T006_codigo 	Codigo
                     , TF1.T006_nome	Nome 
                  FROM T006_loja TF1";
        
        return $this->query($sql);
    }
    
    public function retornaTipodoArquivo($codigo)
    {
        $sql = "SELECT T056_codigo      Tipo
                  FROM T055_arquivos 
                 WHERE T055_codigo = $codigo";
        
        return $this->query($sql);        
    }

    public function retornaGrantor($login)
    {
        $sql = "SELECT TF1.T004_grantor	Grantor
                  FROM T004_usuario TF1
                 WHERE TF1.T004_login = '$login'";
        
        return $this->query($sql);        
    }

    public function retornaUsuariosGrantors($user)
    {
        $sql = "SELECT T004_grantor Grantor 
                  FROM T004_T004 
                 WHERE T004_login = '$user'";
        
        return $this->query($sql);        
    }
  
}
?>
<?php
/* -------- Controle de versões - models/T0067.php --------------
 * 
*/
?>