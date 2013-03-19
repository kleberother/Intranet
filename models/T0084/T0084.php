<?php
 

/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 26/01/2012 por Jorge Nova
 * Descrição: Classe de models para o programa T084
 * Entrada:   
 * Origens:   
           
**************************************************************************
*/


class models_T0084 extends models
{

    public function __construct($conn,$verificaConexao,$db)
    {
        parent::__construct($conn,$verificaConexao,$db);
    }
    
    public function inserir($tabela,$campos)
    {
        $insere = $this->exec($this->insere($tabela, $campos));
        
       if($insere)
            $this->alerts('false', 'Alerta!', 'Incluido com Sucesso!');
       else
            $this->alerts('true', 'Erro!', 'Não foi possível Incluir!');
       
       return $insere;
    }   
    
    public function altera($tabela,$campos,$delim,$alerta)
    {
       $conn = "";
       
       $altera = $this->exec($this->atualiza($tabela, $campos, $delim));
       
       if($alerta)
       {
            if($altera)
                $this->alerts('false', 'Alerta!', 'Alterado com Sucesso!');
            else
                $this->alerts('true', 'Erro!', 'Não foi possível Alterar!');   
       }
       
       return $altera;
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
    
    public function retornaAguardandoMinhaAprovacao($user,$filtros)
    {
        $sql = "SELECT TJ3.T013_codigo						Codigo
                     , TJ3.T006_codigo						CodLoja
                     , TJ4.T006_nome						NomeLoja
                     , CONCAT(TJ7.T026_rms_codigo,'-',TJ7.T026_rms_digito)	CodRMSLoja        
                     , TJ7.T026_rms_razao_social				RazaoSocialLoja
                     , TJ7.T026_rms_cgc_cpf					CNPJLoja
                     , TJ7.T026_rms_insc_est_ident				IELoja
                     , TJ3.T026_codigo						CodFornecedor         
                     , CONCAT(TJ5.T026_rms_codigo,'-',TJ5.T026_rms_digito)      CodRMSFornecedor 
                     , TJ5.T026_rms_razao_social				RazaoSocial
                     , TJ5.T026_rms_cgc_cpf					CNPJ
                     , TJ5.T026_rms_insc_est_ident				IE
                     , TJ3.T013_total_geral					ValorTotal
                     , TJ3.T004_login						Elaborador	  
                     , TJ6.T004_nome						NomeElaborador
                     , TJ2.T060_codigo						EtapaCodigo
                     , TJ2.T060_proxima_etapa					ProximaEtapa
                  FROM	T013_T060                                               TF1
                  JOIN	(
                            SELECT TF2.T013_codigo			nota
                                 , MIN(TF2.T013_T060_ordem)	ordem
                              FROM T013_T060                       TF2
                             WHERE TF2.T013_T060_dt_aprovacao IS NULL
                               AND TF2.T013_T060_status = 0
                          GROUP BY TF2.T013_codigo				  	  
                        )	SE1 ON (     SE1.nota	= TF1.T013_codigo
                                         AND SE1.ordem  = TF1.T013_T060_ordem
                                       )
                  JOIN T004_T059 	TJ1	ON ( TJ1.T004_login                                  = '$user'         )
                  JOIN T060_workflow    TJ2	ON ( TJ2.T059_codigo                                 = TJ1.T059_codigo )
                  JOIN T013_nota_debito TJ3     ON ( TJ3.T013_codigo                                 = TF1.T013_codigo )
                  JOIN T006_loja	TJ4     ON ( TJ4.T006_codigo                                 = TJ3.T006_codigo )
                  JOIN T026_fornecedor  TJ5     ON ( TJ5.T026_codigo                                 = TJ3.T026_codigo )  
                  JOIN T004_usuario     TJ6     ON ( TJ6.T004_login                                  = TJ3.T004_login  )
                  JOIN T026_fornecedor  TJ7     ON ( CONCAT(TJ7.T026_rms_codigo,TJ7.T026_rms_digito) = TJ3.T006_codigo )    
                 WHERE TF1.T060_codigo  = TJ2.T060_codigo";
        
        $sql .= $filtros;
        
        //echo $sql;
        
        return $this->query($sql);
    }
     
    public function retornaMinhasDigitadas($user,$filtros)
    {
        $sql = "SELECT DISTINCT TJ1.T013_codigo                             Codigo
                     , TJ1.T006_codigo                                      CodLoja
                     , TJ2.T006_nome                                        NomeLoja
                     , TJ3.T026_codigo					    CodFornecedor        
                     , CONCAT(TJ3.T026_rms_codigo,'-',TJ3.T026_rms_digito)  CodRMSFornecedor 
                     , TJ3.T026_rms_razao_social                            RazaoSocial
                     , TJ1.T013_total_geral                                 ValorTotal
                     , TJ1.T004_login                                       Elaborador	  
                     , TJ4.T004_nome                                        NomeElaborador
                  FROM	T013_T060	TF1
                  JOIN T013_nota_debito TJ1   ON ( TJ1.T013_codigo  =  TF1.T013_codigo )
                  JOIN T006_loja	TJ2   ON ( TJ2.T006_codigo  = TJ1.T006_codigo )
                  JOIN T026_fornecedor  TJ3   ON ( TJ3.T026_codigo  = TJ1.T026_codigo )  
                  JOIN T004_usuario     TJ4   ON ( TJ4.T004_login   = TJ1.T004_login  )    
                 WHERE TJ1.T013_status	= 0
                   AND TJ1.T004_login	= '$user'";
        
        $sql .= $filtros;
        
        //echo $sql;
        
        return $this->query($sql);
    }
    
    public function retornaAnteriores($user,$filtros)
    {
        $sql = "SELECT DISTINCT TJ5.T013_codigo                             Codigo
                     , TJ5.T006_codigo                                      CodLoja
                     , TJ6.T006_nome                                        NomeLoja   
                     , TJ7.T026_codigo					    CodFornecedor            
                     , CONCAT(TJ7.T026_rms_codigo,'-',TJ7.T026_rms_digito)  CodRMSFornecedor 
                     , TJ7.T026_rms_razao_social                            RazaoSocial
                     , TJ5.T013_total_geral                                 ValorTotal
                     , TJ5.T004_login                                       Elaborador	  
                     , TJ8.T004_nome                                        NomeElaborador
                                    FROM (  SELECT TF1.T013_codigo nota , max(TF1.T013_T060_ordem) ordem
                                            FROM T013_T060 TF1
                                            JOIN ( -- retorna as notas que ja foram aprovadas
                                                    SELECT TF2.T013_codigo nota, max(T013_T060_ordem) ordem
                                                    FROM T013_T060 TF2
                                                    WHERE TF2.T013_T060_ordem  IS NOT NULL
                                                    AND T013_T060_dt_aprovacao IS NULL -- nao aprovadas
                                                    GROUP BY  TF2.T013_codigo
                                                  ) SE1 ON ( SE1.nota  = TF1.T013_codigo )
                                                -- retorna grupos do usuario
                                            JOIN T004_T059 TJ2      ON ( TJ2.T004_login = '$user' )
                                                -- retorna etapas dos grupos
                                            JOIN T060_workflow TJ3    ON ( TJ3.T059_codigo  =  TJ2.T059_codigo )
                                            WHERE TF1.T060_codigo  = TJ3.T060_codigo
                                              AND TF1.T013_T060_dt_aprovacao IS NULL -- em que o usuario logado nao aprovou
                                            GROUP BY TF1.T013_codigo
                                          ) SE2
                                    JOIN T013_T060 TJ4 ON (     TJ4.T013_codigo     = SE2.nota
                                                                AND TJ4.T013_T060_ordem < SE2.ordem -- etapas anteriores ao usuario logado
                                                            )
                                    -- detalhes da AP
                                    JOIN T013_nota_debito TJ5    ON ( TJ5.T013_codigo  =  TJ4.T013_codigo )
                                    AND TJ5.T013_status   in ( '0','1' ) -- novas ou ja aprovadas
                                     AND TJ4.T013_T060_dt_aprovacao IS NULL  /*somente nao aprovadas*/
                                  JOIN T006_loja			TJ6   ON ( TJ6.T006_codigo                                 = TJ5.T006_codigo )
                                  JOIN T026_fornecedor  TJ7   ON ( TJ7.T026_codigo                                 = TJ5.T026_codigo )  
                                  JOIN T004_usuario     TJ8   ON ( TJ8.T004_login                                  = TJ5.T004_login  )    	";
        
        $sql .= $filtros;
        
        //echo $sql;
        
        return $this->query($sql);
    }
    
    public function retornaPosteriores($user,$filtros)
    {
        $sql = "SELECT  DISTINCT TJ4.T013_codigo 		                               Codigo
               , TJ4.T006_codigo                                      CodLoja
               , T06.T006_nome                                        NomeLoja     
               , T26.T026_codigo				      CodFornecedor            
               , CONCAT(T26.T026_rms_codigo,'-',T26.T026_rms_digito)  CodRMSFornecedor 
               , T26.T026_rms_razao_social                            RazaoSocial
               , TJ4.T013_total_geral                                 ValorTotal
               , TJ4.T004_login                                       Elaborador	  
               , T04.T004_nome                                        NomeElaborador
   FROM (  SELECT TF1.T013_codigo nota , max(TF1.T013_T060_ordem) ordem
           FROM T013_T060 TF1
           JOIN ( -- retorna as Notas que ja foram aprovadas
                   SELECT T013_codigo nota, max(T013_T060_ordem) ordem
                   FROM T013_T060 T
                   WHERE     T013_T060_ordem        IS NOT NULL
                   GROUP BY  T013_codigo
                   ) SE1 ON ( SE1.nota  = TF1.T013_codigo )
               -- retorna grupos do usuario
           JOIN T004_T059 TJ1      ON ( TJ1.T004_login = '$user' )
               -- retorna etapas dos grupos
            JOIN T060_workflow TJ2    ON ( TJ2.T059_codigo  =  TJ1.T059_codigo )
           WHERE TF1.T060_codigo  = TJ2.T060_codigo
             AND TF1.T013_T060_dt_aprovacao IS NOT NULL -- em que o usuario JA aprovou
        GROUP BY TF1.T013_codigo
       ) SE2
   JOIN T013_T060 TJ3 ON (     TJ3.T013_codigo     = SE2.nota
                               AND TJ3.T013_T060_ordem > SE2.ordem
                           )
   -- detalhes da despesa
   JOIN T013_nota_debito TJ4    ON  ( TJ4.T013_codigo  =  TJ3.T013_codigo )
   JOIN T006_loja			 T06    ON  ( T06.T006_codigo  =  TJ4.T006_codigo )
	JOIN T026_fornecedor  T26    ON  ( T26.T026_codigo  =  TJ4.T026_codigo )  
	JOIN T004_usuario     T04    ON  ( T04.T004_login   =  TJ4.T004_login  )	
  WHERE TJ4.T013_status   = '1'";
        
        $sql .= $filtros;
        
        //echo $sql;
        
        return $this->query($sql);
    }
    
    public function retornaFinalizadas($user,$filtros)
    {
        $sql = "SELECT DISTINCT T13.T013_codigo 		                               Codigo
            , T13.T006_codigo                                      CodLoja
            , T06.T006_nome                                        NomeLoja     
            , T26.T026_codigo                                      CodFornecedor           
            , CONCAT(T26.T026_rms_codigo,'-',T26.T026_rms_digito)  CodRMSFornecedor 
            , T26.T026_rms_razao_social                            RazaoSocial
            , T13.T013_total_geral                                 ValorTotal
            , T13.T004_login                                       Elaborador	  
            , T04.T004_nome                                        NomeElaborador
            FROM T013_nota_debito T13
            -- retorna etapas das  Notas
            JOIN T013_T060 T1360      ON ( T1360.T013_codigo = T13.T013_codigo )
            -- retorna grupos do usuario
            JOIN T004_T059 T0459      ON ( T0459.T004_login = '$user' )
            -- retorna etapas dos grupos do usuario
            JOIN T060_workflow T60    ON (      T60.T059_codigo    =  T0459.T059_codigo
                                            AND T1360.T060_codigo  =  T60.T060_codigo
												     )
			   JOIN T006_loja			 T06    ON  ( T06.T006_codigo  =  T13.T006_codigo )
				JOIN T026_fornecedor  T26    ON  ( T26.T026_codigo  =  T13.T026_codigo )  
				JOIN T004_usuario     T04    ON  ( T04.T004_login   =  T13.T004_login  )
        WHERE T13.T013_status = '9'";
        
        $sql .= $filtros;
        
        //echo $sql;
        
        return $this->query($sql);
    }
    
    public function retornaCanceladas($user,$filtros)
    {
        $sql = "SELECT DISTINCT T13.T013_codigo 		                               Codigo
            , T13.T006_codigo                                      CodLoja
            , T06.T006_nome                                        NomeLoja    
            , T26.T026_codigo				      CodFornecedor           
            , CONCAT(T26.T026_rms_codigo,'-',T26.T026_rms_digito)  CodRMSFornecedor 
            , T26.T026_rms_razao_social                            RazaoSocial
            , T13.T013_total_geral                                 ValorTotal
            , T13.T004_login                                       Elaborador	  
            , T04.T004_nome                                        NomeElaborador
            FROM T013_nota_debito T13
            -- retorna etapas das  Notas
            JOIN T013_T060 T1360      ON ( T1360.T013_codigo = T13.T013_codigo )
            -- retorna grupos do usuario
            JOIN T004_T059 T0459      ON ( T0459.T004_login = '$user' )
            -- retorna etapas dos grupos do usuario
            JOIN T060_workflow T60    ON (      T60.T059_codigo    =  T0459.T059_codigo
                                            AND T1360.T060_codigo  =  T60.T060_codigo
												     )
			   JOIN T006_loja			 T06    ON  ( T06.T006_codigo  =  T13.T006_codigo )
				JOIN T026_fornecedor  T26    ON  ( T26.T026_codigo  =  T13.T026_codigo )  
				JOIN T004_usuario     T04    ON  ( T04.T004_login   =  T13.T004_login  )
        WHERE T13.T013_status = '4'";
        
        $sql .= $filtros;
        
        //echo $sql;
        
        return $this->query($sql);
    }
    
    

    public function retornaNota($codigo,$loja)
    {
        $sql = "SELECT TF1.T013_codigo                                      Codigo
                     , TF1.T006_codigo                                      CodLoja
                     , TJ1.T006_nome                                        NomeLoja
                     , CONCAT(TJ4.T026_rms_codigo,'-',TJ4.T026_rms_digito)  CodRMSLoja        
                     , TJ4.T026_rms_razao_social                            RazaoSocialLoja
                     , TJ4.T026_rms_cgc_cpf                                 CNPJLoja
                     , TJ4.T026_rms_insc_est_ident                          IELoja
                     , TF1.T026_codigo                                      CodFornecedor         
                     , CONCAT(TJ2.T026_rms_codigo,'-',TJ2.T026_rms_digito)  CodRMSFornecedor 
                     , TJ2.T026_rms_razao_social                            RazaoSocial
                     , TJ2.T026_rms_cgc_cpf                                 CNPJ
                     , TJ2.T026_rms_insc_est_ident                          IE
                     , TF1.T013_total_geral                                 ValorTotal
                     , TF1.T004_login                                       Elaborador	  
                     , TJ3.T004_nome                                        NomeElaborador
                     , TF1.T013_dt_emissao                                  DataEmissao
                     , TF1.T013_dt_vencimento                               DataVencimento
                  FROM T013_nota_debito TF1
                  JOIN T006_loja			TJ1 ON ( TJ1.T006_codigo = TF1.T006_codigo )
                  JOIN T026_fornecedor  TJ2 ON ( TJ2.T026_codigo = TF1.T026_codigo )  
                  JOIN T004_usuario     TJ3 ON ( TJ3.T004_login  = TF1.T004_login  )
                  JOIN T026_fornecedor  TJ4 ON ( CONCAT(TJ4.T026_rms_codigo,TJ4.T026_rms_digito) = TF1.T006_codigo )
                 WHERE TF1.T013_codigo = $codigo
                   AND TF1.T006_codigo = $loja";
        
        return $this->query($sql);
    }

    public function retornaNotaDesc($codigo,$loja)
    {
        $sql = "SELECT TJ1.T088_crf_rms                 CRF
                     , TF1.T087_descricao               Descricao
                     , TF1.T087_valor			Valor        
                  FROM T087_nota_debito_detalhe         TF1
                  JOIN T088_crf                         TJ1	ON ( TJ1.T088_crf_rms = TF1.T088_crf_rms )
                 WHERE TF1.T013_codigo	=	$codigo
                   AND TF1.T006_codigo  =       $loja";
        
        return $this->query($sql);
    }
    
    public function retornaLojas($user)
    {
        $sql = "SELECT TF1.T006_codigo  Codigo
                     , TF1.T006_nome    Nome
                  FROM T006_loja TF1
                  JOIN T004_usuario TJ1	ON ( TF1.T006_codigo = TJ1.T006_codigo )
                 WHERE TJ1.T004_login = '$user'";
        
        return $this->query($sql);
    }
    
    public function retornaCodigoRMS($codigo)
    {
        $sql = "SELECT CONCAT(T26.T026_rms_codigo, T26.T026_rms_digito) CodigoRMS
                  FROM T026_fornecedor	T26
                 WHERE T026_codigo = $codigo";
        
        return $this->query($sql);
        
    }

    public function retornaLojasSelectBox()
    {
        $sql = "SELECT TF1.T006_codigo  Codigo
                     , TF1.T006_nome    Nome
                  FROM T006_loja TF1                  
                 WHERE TF1.T006_codigo <> 0";
        
        return $this->query($sql);
    }
    
    public function retornaGruposWF($user)
    {
        $sql = "SELECT TF1.T059_codigo          Codigo
                     , TF1.T059_nome		Nome
                  FROM T059_grupo_workflow      TF1
                  JOIN T060_workflow 		TJ1 ON ( TJ1.T059_codigo = TF1.T059_codigo )
                  JOIN T004_T059				TJ2 ON ( TJ2.T059_codigo = TF1.T059_codigo )
                 WHERE TF1.T061_codigo	=	3	
                   AND TJ1.T060_ordem	=	1
                   AND TJ2.T004_login	=	'$user'";
        
        return $this->query($sql);
    }

    public function retornaCRF($crf)
    {
        $sql = "SELECT TF1.T088_codigo                  Codigo
                     , TF1.T088_descricao_nota_debito	Descricao
                  FROM T088_crf TF1
                 WHERE TF1.T088_crf_rms	=	$crf";
        
        return $this->query($sql);
    }
    
    public function retornaCRFSelectBox()
    {
        $sql = "SELECT TF1.T088_crf_rms                 CodigoRMS
                     , TF1.T088_descricao_nota_debito	Descricao
                  FROM T088_crf TF1";
        
        return $this->query($sql);        
    }
    
    public function retornaDadosFornecedor($codigo)
    {
        $connORA  =   $this->consulta;
        
        $sql = "SELECT 10*P.TIP_CODIGO+P.TIP_DIGITO CodigoRMS
                     , P.TIP_CGC_CPF                CNPJ
                     , P.TIP_INSC_EST_IDENT         InscEstadual
                     , P.TIP_RAZAO_SOCIAL           RazaoSocial
                     , P.TIP_ENDERECO               Endereco
                     , P.TIP_BAIRRO                 Bairro
                     , P.TIP_CIDADE                 Cidade
                     , P.TIP_ESTADO                 Estado
                     , P.TIP_CEP                    CEP
                     , P.TIP_FONE_DDD               FoneDDD
                     , P.TIP_FONE_NUM               FoneNum 
                     , P.TIP_FAX_DDD                FaxDDD
                     , P.TIP_FAX_NUM                FaxNum
                  FROM RMS.AA2CTIPO P
                 WHERE (10*P.TIP_CODIGO+P.TIP_DIGITO) =  $codigo";
        
        $stid    =  oci_parse($connORA, $sql);
        
        oci_execute($stid);                
        
        return($stid);        
    }

    public function retornaCondicaoPagamento($codigo)
    {
        $connORA  =   $this->consulta;
        
        $sql = "SELECT davo.fncad_diaspagtofornecedor($codigo) 
                  FROM dual";

        $stid    =  oci_parse($connORA, $sql);
        
        oci_execute($stid);                
        
        return($stid);        
    }
    
    public function retornaUltimaND()
    {
        $sql = "  SELECT T89.T089_valor Valor
                    FROM T089_parametro_detalhe T89
                   WHERE T89.T003_codigo  = 4";
        
        return $this->query($sql);
                
    }
    
    // Funções abaixo, são para inserir o fluxo da ND
   public function retornaEtapaGrupo($cod)
   {
       $sql = "SELECT T1.T060_codigo              EtapaCodigo
                    , T1.T060_proxima_etapa       ProxEtapaCodigo
                 FROM T060_workflow               T1
                WHERE T1.T059_codigo              = $cod";
             
       return $this->query($sql);
   }    
   
    public function InserirFluxo($codNd, $codLoja, $codEtapa, $ordem, $user)
    {   
        $tabela = "T013_T060";
        
        if(!is_null($codEtapa))
        {
            $Etapas = $this->retornaProximaEtapa($codEtapa);

            foreach($Etapas as $campos=>$valores)
            {
                $array = array ( "T060_codigo"      =>  $valores['EtapaCodigo']
                               , "T013_codigo"      =>  $codNd
                               , "T006_codigo"       => $codLoja                    
                               , "T013_T060_ordem"  =>  $ordem
                               , "T013_T060_status" =>  0
                               , "T004_login"       =>  $user   );
                
                $this->inserir($tabela, $array);
                
                $this->InserirFluxo($codNd, $codLoja, $valores['ProxCodigoEtapa'], $ordem+1 , $user);
            }
        }
        
        return true;
    }   
    
   public function retornaProximaEtapa($codEtapa)
   {
       return $this->query("SELECT T1.T060_codigo              EtapaCodigo
                                 , T1.T060_proxima_etapa       ProxCodigoEtapa
                              FROM T060_workflow               T1
                             WHERE T1.T060_codigo              = $codEtapa");
   }   
   
    public function retornaUltimaEtapaNota($NotaCodigo)
    {
        $sql    =   " SELECT T060_codigo UltimaEtapa -- retorna última etapa da AP
                        FROM
                            (
                                SELECT T013_T060.T013_codigo cod ,  max(T013_T060_ordem) ordem -- retorna ultima ordem da AP
                                FROM T013_T060
                                WHERE T013_codigo = $NotaCodigo
                                GROUP BY T013_T060.T013_codigo
                            ) SE1
                        JOIN T013_T060  ON (     T013_codigo     = SE1.cod
                                             AND T013_T060_ordem = SE1.ordem
                                            )";

        return $this->query($sql);
    }   
    
    public function retornaCodigoFornecedor($cnpj)
    {
        $sql    =   " SELECT T26.T026_codigo
                        FROM T026_fornecedor T26
                       WHERE T26.T026_rms_cgc_cpf = '$cnpj'";
        
        return $this->query($sql)->fetchAll(PDO::FETCH_COLUMN);
        
    }
        
   
}
?>
