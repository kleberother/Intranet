<?php


///**************************************************************************
//                Intranet - DAVÓ SUPERMERCADOS
// * Criado em: 17/07/2012 por Roberta Schimidt                               
// * Descrição: Ajustes EM$
// * Entrada:   
// * Origens:   
//           
//**************************************************************************
//*/
//
// 


class models_T0111 extends models
{

    public function __construct($conn,$verificaConexao,$db)
    {
        parent::__construct($conn,$verificaConexao,$db);
    }

    public function retornaLojasSelectBox()
    {
       
        
        $sql = "SELECT TF1.T006_codigo  Codigo
                     , TF1.T006_nome    Nome
                  FROM T006_loja TF1                  
                 WHERE TF1.T006_codigo <> 0";
        
        return $this->query($sql);
    }
    
    public function retornaLojaFixaSelectBox($loja)
    {
       
        
        $sql = "SELECT TF1.T006_codigo  Codigo
                     , TF1.T006_nome    Nome
                  FROM T006_loja TF1                  
                 WHERE TF1.T006_codigo <> 0
                   AND TF1.T006_codigo = '$loja'";
        
        return $this->query($sql);
    }
    
    
    public function inserir($tabela,$campos)
    {
        $insere =  $this->exec($this->insere($tabela, $campos));
        
        if($insere)
            $this->alerts('false', 'Alerta!', 'Incluído com Sucesso!');
        else
            $this->alerts('true', 'Erro!', 'Não foi possível Incluir!');  
        
        return $insere;
    }
    
 
    
    public function numeroLoja($loja) {
        
        switch ($loja) {
            case "19":
                $n_loja = '1';
            break;
        case "27":
            $n_loja = '2';
            break;
        case "35":
            $n_loja = '3';
            break;
        case "43":
            $n_loja = '4';
            break;
        case "51":
            $n_loja = '5';
            break;
        case "60":
            $n_loja = "6";
            break;
        case "78":
            $n_loja = "7";
            break;
        case "86":
            $n_loja = "8";
            break;
        case "94":
            $n_loja = "9";
            break;
        case "108":
            $n_loja = "10";
            break;
        case "116":
            $n_loja = "11";
            break;
        case "124":
            $n_loja = "12";
            break;
        case "132":
            $n_loja = "13";
            break;
        case "140":
            $n_loja = "14";
            break;
        case "159":
            $n_loja = "15";
            break;
        case "167":
            $n_loja = "16";
            break;
        case "175":
            $n_loja = "17";
            break;
        case "183":
            $n_loja = "18";
            break;
                 
        }
        return $n_loja;
        
    }
    

public function retornaStatus($status, $cod, $EtapaCod, $Etapa, $user,$pEtapa){
    
    if($status == 0 && $Etapa == 1)
        {
        $retorna = "<a href='?router=T0111/atualizar&cod=$cod'>Atualizar</a>";
        }
    elseif ($status == 0 && $Etapa != 1 && $user == $_SESSION['user'])
    {
        $retorna = "<a href='?router=T0111/atualizar&cod=$cod'>Atualizar</a>";
    }
    elseif ($status == 1 && $Etapa == 9)
    {
        $retorna = "<a href='#' onclick='lancarLinha(".$cod.",". $EtapaCod.")'>Lançado no EM$</a>";
    }
    elseif($status == '1' && $Etapa != 1)
    {
       $retorna = "Confirmado";
    }
    elseif ($status == '2' && $Etapa == '7')
    {
        $retorna = "<a href='#' onclick='lancarLinha(".$cod.",". $EtapaCod.")'>Finalizar</a>";
    }
    elseif($status == '2' && $Etapa != '1')
    {
       $retorna = "Lançado do EM$";
    }
    elseif($status == 9)
    {
        $retorna = "Finalizado";
    }
        
       
   
     return $retorna;

        
    }
    
   
    



    public function altera($tabela,$campos,$delim)
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
    
   public function selecionaAjuste($codigo, $user) {
       
               
        $sql = "SELECT TJ3.T106_codigo						Codigo
                     , TJ3.T006_codigo						CodLoja
                     , TJ4.T006_nome						NomeLoja
                     , TJ3.T106_data_operacao                                   DataOper
                     , TJ7.T107_descricao                                       TipoOper
                     , TJ3.T107_codigo                                          CodOper
                     , TJ3.T107_codigo                                          TipoCodigo
                     , TJ3.T106_conta                                           Conta
                     , TJ3.T106_cpf                                             CPF
                     , TJ3.T106_valor_vista                                     ValorVista
                     , TJ3.T106_qtd_parc                                        QtdParc
                     , TJ3.T106_valor_par                                       ValorParc   
                     , TJ3.T106_valor_tot					ValorTotal
                     , TJ3.T106_n_cupom                                         Cupom
                     , TJ3.T106_pdv                                             Pdv
                     , TJ3.T004_login   					Elaborador	  
                     , TJ3.T106_motivo                                          Motivo
                     , TJ3.T106_justificativa                                   Justificativa
                     , TJ3.T106_instrucoes                                      Instrucoes
                     , TJ3.T106_status                                          Status
                     , TJ3.T106_st_ajuste                                       FinAjuste
                     , TJ3.T106_func_libe                                       FuncLibe
                     , TJ3.T106_dat_lanc                                        DataLanc
                     , TJ6.T004_nome						NomeElaborador
                     , TJ2.T060_codigo						EtapaCodigo
                     , TJ2.T060_proxima_etapa					ProximaEtapa
                  FROM	T106_T060                                               TF1
                  JOIN	(
                            SELECT TF2.T106_codigo                              ajuste
                                 , MIN(TF2.T106_T060_ordem)                     ordem
                              FROM T106_T060                       TF2
                             WHERE TF2.T106_T060_dt_aprovacao IS NULL
                               AND TF2.T106_T060_status = 0
                          GROUP BY TF2.T106_codigo				  	  
                        )	SE1 ON (     SE1.ajuste	= TF1.T106_codigo
                                         AND SE1.ordem  = TF1.T106_T060_ordem
                                       )
                  JOIN T060_workflow    TJ2	
                  JOIN T106_ajustes_ems TJ3     ON ( TJ3.T106_codigo                                 = TF1.T106_codigo )
                  JOIN T107_T106         TJ7     ON ( TJ3.T107_codigo                                 = TJ7.T107_codigo )
                  JOIN T006_loja	TJ4     ON ( TJ4.T006_codigo                                 = TJ3.T006_codigo )
                  JOIN T004_usuario     TJ6     ON ( TJ6.T004_login                                  = TJ3.T004_login  )
                 WHERE TF1.T060_codigo  = TJ2.T060_codigo
                   AND TJ3.T106_codigo	= '$codigo'				";
               
   //    echo $sql;
        return $this->query($sql);
       
   }
   
 public function retornaAguardandoMinhaConfirmacao($user,$filtros)
    {
        $sql = "SELECT TJ3.T106_codigo						Codigo
                     , TJ3.T006_codigo						CodLoja
                     , TJ4.T006_nome						NomeLoja
                     , TJ3.T106_data_operacao                                   DataOper
                     , TJ7.T107_sigla                                           TipoOper
                     , TJ3.T106_conta                                           Conta
                     , TJ3.T106_cpf                                             CPF
                     , TJ3.T106_valor_vista                                     ValorVista
                     , TJ3.T106_qtd_parc                                        QtdParc
                     , TJ3.T106_valor_par                                       ValorParc   
                     , TJ3.T106_valor_tot					ValorTotal
                     , TJ3.T106_n_cupom                                         Cupom
                     , TJ3.T106_pdv                                             Pdv
                     , TJ3.T004_login   					Elaborador	  
                     , TJ3.T106_motivo                                          Motivo
                     , TJ3.T106_status                                          Status
                     , TJ6.T004_nome						NomeElaborador
                     , TJ2.T060_codigo						EtapaCodigo
                     , TJ2.T060_proxima_etapa					ProximaEtapa
                     , TJ3.T106_st_ajuste                                        Contratado
                  FROM	T106_T060                                               TF1
                  JOIN	(
                            SELECT TF2.T106_codigo                              ajuste
                                 , MIN(TF2.T106_T060_ordem)     + 1                ordem
                              FROM T106_T060                       TF2
                             WHERE TF2.T106_T060_dt_aprovacao IS NULL
                               AND TF2.T106_T060_status = 0
                          GROUP BY TF2.T106_codigo				  	  
                        )	SE1 ON (     SE1.ajuste	= TF1.T106_codigo
                                         AND SE1.ordem  = TF1.T106_T060_ordem
                                       )
                  JOIN T004_T059 	TJ1	ON ( TJ1.T004_login    = '$user'   )
                  JOIN T060_workflow    TJ2     ON ( TJ2.T059_codigo   = TJ1.T059_codigo )
                  JOIN T106_ajustes_ems TJ3     ON ( TJ3.T106_codigo   = TF1.T106_codigo )
                  JOIN T107_T106        TJ7     ON ( TJ7.T107_codigo   = TJ3.T107_codigo)
                  JOIN T006_loja	TJ4     ON ( TJ4.T006_codigo   = TJ3.T006_codigo )
                  JOIN T004_usuario     TJ6     ON ( TJ6.T004_login    = TJ3.T004_login  )
                 WHERE TF1.T060_codigo  = TJ2.T060_codigo
                       and TJ3.T106_status = '0' $filtros ";
        
       
        
       //echo $sql;
        
        return $this->query($sql);
    }
    
    
    public function retornaAguardandoLancamento($user,$filtros)
    {
        $sql = "SELECT TJ3.T106_codigo						Codigo
                     , TJ3.T006_codigo						CodLoja
                     , TJ4.T006_nome						NomeLoja
                     , TJ3.T106_data_operacao                                   DataOper
                     , TJ7.T107_sigla                                           TipoOper
                     , TJ3.T106_conta                                           Conta
                     , TJ3.T106_cpf                                             CPF
                     , TJ3.T106_valor_vista                                     ValorVista
                     , TJ3.T106_qtd_parc                                        QtdParc
                     , TJ3.T106_valor_par                                       ValorParc   
                     , TJ3.T106_valor_tot					ValorTotal
                     , TJ3.T106_n_cupom                                         Cupom
                     , TJ3.T106_pdv                                             Pdv
                     , TJ3.T004_login   					Elaborador	  
                     , TJ3.T106_motivo                                          Motivo
                     , TJ3.T106_status                                          Status
                     , TJ6.T004_nome						NomeElaborador
                     , TJ2.T060_codigo						EtapaCodigo
                     , TJ2.T060_proxima_etapa					ProximaEtapa
                     , TJ3.T106_st_ajuste                                        Contratado
                  FROM	T106_T060                                               TF1
                  JOIN	(
                            SELECT TF2.T106_codigo                              ajuste
                                 , MIN(TF2.T106_T060_ordem)     + 2                ordem
                              FROM T106_T060                       TF2
                             WHERE TF2.T106_T060_dt_aprovacao IS NULL
                               AND TF2.T106_T060_status = 0
                          GROUP BY TF2.T106_codigo				  	  
                        )	SE1 ON (     SE1.ajuste	= TF1.T106_codigo
                                         AND SE1.ordem  = TF1.T106_T060_ordem
                                       )
                  JOIN T004_T059 	TJ1	ON ( TJ1.T004_login    = '$user'   )
                  JOIN T060_workflow    TJ2     ON ( TJ2.T059_codigo   = TJ1.T059_codigo )
                  JOIN T106_ajustes_ems TJ3     ON ( TJ3.T106_codigo   = TF1.T106_codigo )
                  JOIN T107_T106        TJ7     ON ( TJ7.T107_codigo   = TJ3.T107_codigo)
                  JOIN T006_loja	TJ4     ON ( TJ4.T006_codigo   = TJ3.T006_codigo )
                  JOIN T004_usuario     TJ6     ON ( TJ6.T004_login    = TJ3.T004_login  )
                 WHERE TF1.T060_codigo  = TJ2.T060_codigo
                       and TJ3.T106_status = '1' $filtros ";
        
       
        
   //    echo $sql;
        
        return $this->query($sql);
    }
    
    
      public function retornaMinhasDigitadas($user,$filtros)
    {
        $sql = "SELECT DISTINCT     TJ3.T106_codigo                 Codigo 
                                  , TJ3.T006_codigo             CodLoja
                                  , TJ3.T106_data_operacao      DataOper
                                  , TJ7.T107_sigla              TipoOper
                                  , TJ3.T107_codigo             CodOper
                                  , TJ3.T106_conta              Conta
                                  , TJ3.T106_cpf                CPF
                                  , TJ3.T106_valor_vista        ValorVista
                                  , TJ3.T106_qtd_parc           QtdParc
                                  , TJ3.T106_valor_par          ValorParc   
                                  , TJ2.T006_nome               NomeLoja 
                                  , TJ3.T106_valor_tot          ValorTotal
                                  , TJ3.T106_n_cupom            Cupom
                                  , TJ3.T106_pdv                Pdv
                                  , TJ3.T004_login		Elaborador	  
                                  , TJ3.T106_motivo             Motivo
                                  , TJ3.T106_status             Status
                                  , TJ3.T004_login              Elaborador 
                                  , TJ4.T004_nome               NomeElaborador 
                                  , TJ3.T106_st_ajuste           Contratado
                            FROM T106_T060 TF1 
                            JOIN T106_ajustes_ems TJ3 ON ( TJ3.T106_codigo = TF1.T106_codigo ) 
                            JOIN T107_T106        TJ7 ON ( TJ7.T107_codigo = TJ3.T107_codigo)
                            JOIN T006_loja TJ2 ON ( TJ2.T006_codigo = TJ3.T006_codigo ) 
                            JOIN T004_usuario TJ4 ON ( TJ4.T004_login = TJ3.T004_login ) 
                            WHERE TJ3.T106_status = 0 
                            AND TJ3.T004_login = '$user'
          ";
        
        $sql .= $filtros;
        
      //  echo $sql;
        
        return $this->query($sql);
    }
    
     
      public function retornaAjustesLancados($user,$filtros)
    {
        $sql = "SELECT DISTINCT     TJ3.T106_codigo                 Codigo 
                                  , TJ3.T006_codigo             CodLoja
                                  , TJ3.T106_data_operacao      DataOper
                                  , TJ3.T107_codigo            TipoOper
                                  , TJ3.T106_conta              Conta
                                  , TJ3.T106_cpf                CPF
                                  , TJ3.T106_valor_vista        ValorVista
                                  , TJ3.T106_qtd_parc           QtdParc
                                  , TJ3.T106_valor_par          ValorParc   
                                  , TJ2.T006_nome               NomeLoja 
                                  , TJ3.T106_valor_tot          ValorTotal
                                  , TJ3.T106_n_cupom            Cupom
                                  , TJ3.T106_pdv                Pdv
                                  , TJ3.T004_login		Elaborador	  
                                  , TJ3.T106_motivo             Motivo
                                  , TJ3.T106_status             Status
                                  , TJ3.T004_login              Elaborador 
                                  , TJ4.T004_nome               NomeElaborador 
                                  , TJ3.T106_st_ajuste           Contratado
                            FROM T106_T060 TF1 
                            JOIN T106_ajustes_ems TJ3 ON ( TJ3.T106_codigo = TF1.T106_codigo ) 
                            JOIN T006_loja TJ2 ON ( TJ2.T006_codigo = TJ3.T006_codigo ) 
                            JOIN T004_usuario TJ4 ON ( TJ4.T004_login = TJ3.T004_login ) ";
        
        $sql .= $filtros;
        
    //   echo $sql;
        
        return $this->query($sql);
    }
    
    
    public function retornaAnteriores($user,$filtros)
    {
        $sql = "SELECT DISTINCT TJ3.T106_codigo                              Codigo
                     , TJ3.T006_codigo                                      CodLoja
                     , TJ6.T006_nome                                        NomeLoja 
                     , TJ3.T106_data_operacao                               DataOper
                     , TJ3.T106_tip_operacao                                TipoOper
                     , TJ3.T106_conta                                       Conta
                     , TJ3.T106_cpf                                         CPF
                     , TJ3.T106_valor_vista                                 ValorVista
                     , TJ3.T106_qtd_parc                                    QtdParc
                     , TJ3.T106_valor_par                                   ValorParc
                     , TJ3.T106_valor_tot                                   ValorTotal
                     , TJ3.T106_n_cupom                                     Cupom
                     , TJ3.T106_pdv                                         Pdv
                     , TJ3.T004_login                                       Elaborador	  
                     , TJ3.T106_motivo                                      Motivo
                     , TJ3.T106_status                                      Status
                     , TJ8.T004_nome                                        NomeElaborador
                     , TJ3.T106_st_ajuste           Contratado
                                    FROM (  SELECT TF1.T106_codigo ajuste , max(TF1.T106_T060_ordem) ordem
                                            FROM T106_T060 TF1
                                            JOIN ( -- retorna as notas que ja foram aprovadas
                                                    SELECT TF2.T106_codigo ajuste, max(T106_T060_ordem) ordem
                                                    FROM T106_T060 TF2
                                                    WHERE TF2.T106_T060_ordem  IS NOT NULL
                                                    AND T106_T060_dt_aprovacao IS NULL -- nao aprovadas
                                                    GROUP BY  TF2.T106_codigo
                                                  ) SE1 ON ( SE1.ajuste  = TF1.T106_codigo )
                                                -- retorna grupos do usuario
                                            JOIN T004_T059 TJ2      ON ( TJ2.T004_login = '$user' )
                                                -- retorna etapas dos grupos
                                            JOIN T060_workflow TJ5    ON ( TJ5.T059_codigo  =  TJ2.T059_codigo )
                                            WHERE TF1.T060_codigo  = TJ5.T060_codigo
                                              AND TF1.T106_T060_dt_aprovacao IS NULL -- em que o usuario logado nao aprovou
                                            GROUP BY TF1.T106_codigo
                                          ) SE2
                                    JOIN T106_T060 TJ4 ON (     TJ4.T106_codigo     = SE2.ajuste
                                                                AND TJ4.T106_T060_ordem < SE2.ordem -- etapas anteriores ao usuario logado
                                                            )
                                    -- detalhes da AP
                                    JOIN T106_ajustes_ems TJ3    ON ( TJ3.T106_codigo  =  TJ4.T106_codigo )
                                    AND TJ3.T106_status   in ( '0','1' ) -- novas ou ja aprovadas
                                     AND TJ4.T106_T060_dt_aprovacao IS NULL  /*somente nao aprovadas*/
                                  JOIN T006_loja			TJ6   ON ( TJ6.T006_codigo                                 = TJ3.T006_codigo )
                                  JOIN T004_usuario     TJ8   ON ( TJ8.T004_login     = TJ3.T004_login  )    	";
        
        $sql .= $filtros;
        
       // echo $sql;
        
        return $this->query($sql);
    }
    
    
     public function retornaPosteriores($user,$filtros)
    {
        $sql = "SELECT DISTINCT TJ3.T106_codigo                                 Codigo 
                              , TJ3.T006_codigo                                 CodLoja 
                              , TJ3.T106_data_operacao                          DataOper 
                              , TJ7.T107_sigla                                  TipoOper 
                              , TJ3.T107_codigo                                 CodOper
                              , TJ3.T106_conta                                  Conta 
                              , TJ3.T106_cpf                                    CPF
                              , TJ3.T106_valor_vista                            ValorVista 
                              , TJ3.T106_qtd_parc                               QtdParc 
                              , TJ3.T106_valor_par                              ValorParc
                              , TJ3.T106_valor_tot                              ValorTotal
                              , TJ3.T106_n_cupom                                Cupom 
                              , TJ3.T106_pdv                                    Pdv 
                              , TJ3.T004_login                                  Elaborador 
                              , TJ3.T106_motivo                                 Motivo 
                              , TJ3.T106_status                                 Status 
                              , T06.T006_nome NomeLoja 
                              , T04.T004_nome NomeElaborador 
                              , TJ3.T106_st_ajuste           Contratado
              FROM ( SELECT TF1.T106_codigo ajuste , MIN(TF1.T106_T060_ordem)  ordem 
              FROM T106_T060 TF1 JOIN ( -- retorna os Ajustes que ja foram aprovadas 
              SELECT T106_codigo ajuste
              , max(T106_T060_ordem) ordem 
              FROM T106_T060 T 
              WHERE T106_T060_ordem IS NOT NULL 
              GROUP BY T106_codigo ) SE1 ON ( SE1.ajuste = TF1.T106_codigo ) -- retorna grupos do usuario 
              JOIN T004_T059 TJ1 ON ( TJ1.T004_login = '$user' ) -- retorna etapas dos grupos 
              JOIN T060_workflow TJ2 ON ( TJ2.T059_codigo = TJ1.T059_codigo ) 
              WHERE TF1.T060_codigo = TJ2.T060_codigo 
              AND TF1.T106_T060_dt_aprovacao IS NOT NULL -- em que o usuario JA aprovou 
              GROUP BY TF1.T106_codigo ) SE2 
              JOIN T106_T060 TJ3X ON ( TJ3X.T106_codigo = SE2.ajuste AND TJ3X.T106_T060_ordem > SE2.ordem ) -- detalhes da                 despesa
              JOIN T106_ajustes_ems TJ3 ON ( TJ3.T106_codigo = TJ3X.T106_codigo ) 
              JOIN T107_T106 TJ7 ON ( TJ3.T107_codigo = TJ7.T107_codigo ) 
              JOIN T006_loja T06 ON ( T06.T006_codigo = TJ3.T006_codigo ) 
              JOIN T004_usuario T04 ON ( T04.T004_login = TJ3.T004_login ) WHERE TJ3.T106_status = '1' ";
        
        $sql .= $filtros;
        
        //echo $sql;
        
        return $this->query($sql);
    }
    
    
    public function retornaAguardandoFinalizar($user,$filtros)
    {
        $sql = "SELECT TJ3.T106_codigo						Codigo
                     , TJ3.T006_codigo						CodLoja
                     , TJ4.T006_nome						NomeLoja
                     , TJ3.T106_data_operacao                                   DataOper
                     , TJ7.T107_sigla                                           TipoOper
                     , TJ3.T106_conta                                           Conta
                     , TJ3.T106_cpf                                             CPF
                     , TJ3.T106_valor_vista                                     ValorVista
                     , TJ3.T106_qtd_parc                                        QtdParc
                     , TJ3.T106_valor_par                                       ValorParc   
                     , TJ3.T106_valor_tot					ValorTotal
                     , TJ3.T106_n_cupom                                         Cupom
                     , TJ3.T106_pdv                                             Pdv
                     , TJ3.T004_login   					Elaborador	  
                     , TJ3.T106_motivo                                          Motivo
                     , TJ3.T106_status                                          Status
                     , TJ6.T004_nome						NomeElaborador
                     , TJ2.T060_codigo						EtapaCodigo
                     , TJ2.T060_proxima_etapa					ProximaEtapa
                     , TJ3.T106_st_ajuste           Contratado
                  FROM	T106_T060                                               TF1
                  JOIN	(
                            SELECT TF2.T106_codigo                              ajuste
                                 , MIN(TF2.T106_T060_ordem) + 3                 ordem
                              FROM T106_T060                       TF2
                             WHERE TF2.T106_T060_dt_aprovacao IS NULL
                               AND TF2.T106_T060_status = 0
                          GROUP BY TF2.T106_codigo				  	  
                        )	SE1 ON (     SE1.ajuste	= TF1.T106_codigo
                                         AND SE1.ordem  = TF1.T106_T060_ordem
                                       )
                  JOIN T004_T059 	TJ1	ON ( TJ1.T004_login         = '$user'   )
                  JOIN T060_workflow    TJ2     ON ( TJ2.T059_codigo   = TJ1.T059_codigo )
                  JOIN T106_ajustes_ems TJ3     ON ( TJ3.T106_codigo   = TF1.T106_codigo )
                  JOIN T107_T106        TJ7     ON ( TJ3.T107_codigo   = TJ7.T107_codigo )
                  JOIN T006_loja	TJ4     ON ( TJ4.T006_codigo   = TJ3.T006_codigo )
                  JOIN T004_usuario     TJ6     ON ( TJ6.T004_login    = TJ3.T004_login  )
                 WHERE TF1.T060_codigo  = TJ2.T060_codigo
                       and TJ3.T106_status = '2'  ";
        
       $sql .= $filtros;
        
       // echo $sql;
        
        return $this->query($sql);
    }
    
    
    
      public function retornaFinalizadas($user,$filtros)
    {
        $sql = "SELECT DISTINCT   				  TJ3.T106_codigo		 		                Codigo
                                , TJ3.T006_codigo                              CodLoja
                                , T06.T006_nome                                NomeLoja     
                                , TJ3.T106_data_operacao                       DataOper 
                                , TJ3.T107_codigo                              TipoOper 
                                , TJ3.T106_conta                               Conta 
                                , TJ3.T106_cpf                                 CPF
                                , TJ3.T106_valor_vista                         ValorVista 
                                , TJ3.T106_qtd_parc                            QtdParc 
                                , TJ3.T106_valor_par                           ValorParc 
                                , TJ3.T106_valor_tot                           ValorTotal    
                                , TJ3.T106_n_cupom                             Cupom 
                                , TJ3.T106_pdv                                 Pdv 
                                , TJ3.T004_login                               Elaborador 
                                , TJ3.T106_motivo                              Motivo 
                                , TJ3.T106_status                              Status 
                                , T04.T004_nome                                NomeElaborador
                                , TJ3.T106_st_ajuste           Contratado
            FROM T106_ajustes_ems TJ3
            -- retorna etapas dos Ajustes
            JOIN T106_T060 T10660      ON ( T10660.T106_codigo = TJ3.T106_codigo )
            JOIN T107_T106 TJ7         ON (TJ7.T107_codigo = TJ3.T107_codigo)
            -- retorna grupos do usuario
            JOIN T004_T059 T0459      ON ( T0459.T004_login = '$user' )
            -- retorna etapas dos grupos do usuario
            JOIN T060_workflow T60    ON (      T60.T059_codigo    =  T0459.T059_codigo
                                            AND T10660.T060_codigo  =  T60.T060_codigo
												     )
			   JOIN T006_loja			 T06    ON  ( T06.T006_codigo  =  TJ3.T006_codigo )
                            JOIN T004_usuario     T04    ON  ( T04.T004_login   =  TJ3.T004_login  )
        WHERE TJ3.T106_status = '9'";
        
        $sql .= $filtros;
        
       //echo $sql."<br>";
        
        return $this->query($sql);
    }
    
     public function retornaCanceladas($user,$filtros)
    {
        $sql = "SELECT DISTINCT TJ3.T106_codigo                Codigo 
                              , TJ3.T106_data_operacao         DataOper 
                              , TJ3.T106_tip_operacao          TipoOper 
                              , TJ3.T106_conta                 Conta 
                              , TJ3.T106_cpf                   CPF 
                              , TJ3.T106_valor_vista           ValorVista 
                              , TJ3.T106_qtd_parc              QtdParc 
                              , TJ3.T106_valor_par             ValorParc
                              , TJ3.T106_valor_tot             ValorTotal
                              , TJ3.T106_n_cupom               Cupom 
                              , TJ3.T106_pdv                   Pdv 
                              , TJ3.T004_login                 Elaborador 
                              , TJ3.T106_motivo                Motivo 
                              , TJ3.T106_status                Status 
                              , TJ3.T006_codigo                CodLoja 
                              , T06.T006_nome                   NomeLoja 
                              , TJ3.T004_login                 Elaborador 
                              , T04.T004_nome                   NomeElaborador 
                              , TJ3.T106_st_ajuste           Contratado
              FROM T106_ajustes_ems TJ3 -- retorna etapas dos Ajustes 
              JOIN T106_T060 T10660 ON ( T10660.T106_codigo = TJ3.T106_codigo ) -- retorna grupos do usuario 
              JOIN T004_T059 T0459 ON ( T0459.T004_login = '$user' ) -- retorna etapas dos grupos do usuario 
              JOIN T060_workflow T60 ON ( T60.T059_codigo = T0459.T059_codigo AND T10660.T060_codigo = T60.T060_codigo )
              JOIN T006_loja T06 ON ( T06.T006_codigo = TJ3.T006_codigo ) 
              JOIN T004_usuario T04 ON ( T04.T004_login = TJ3.T004_login ) WHERE TJ3.T106_status = '4' ";
        
        $sql .= $filtros;
        
        //echo $sql;
        
        return $this->query($sql);
    }
    
    
     public function retornaDetalhesAjuste($cod)
    {
        $sql = "SELECT DISTINCT     TJ1.T106_codigo             Codigo 
                                  , TJ1.T006_codigo             CodLoja
                                  , TJ1.T106_data_operacao      DataOper
                                  , TJ1.T106_tip_operacao       TipoOper
                                  , TJ1.T106_conta              Conta
                                  , TJ1.T106_cpf                CPF
                                  , TJ1.T106_valor_vista        ValorVista
                                  , TJ1.T106_qtd_parc           QtdParc
                                  , TJ1.T106_valor_par          ValorParc   
                                  , TJ2.T006_nome               NomeLoja 
                                  , TJ1.T106_valor_tot          ValorTotal
                                  , TJ1.T106_n_cupom            Cupom
                                  , TJ1.T106_pdv                Pdv
                                  , TJ1.T004_login		Elaborador	  
                                  , TJ1.T106_motivo             Motivo
                                  , TJ1.T106_status             Status
                                  , TJ1.T004_login              Elaborador 
                                  , TJ4.T004_nome               NomeElaborador 
                                  , TJ3.T107_descricao          DescricaoTipo
                                  , TJ3.T106_st_ajuste           Contratado
                            FROM T106_T060 TF1 
                            JOIN T106_ajustes_ems TJ1 ON ( TJ1.T106_codigo = TF1.T106_codigo ) 
                            JOIN T006_loja TJ2 ON ( TJ2.T006_codigo = TJ1.T006_codigo ) 
                            JOIN T107_106  TJ3 ON ( TJ3.T107_codigo = TJ1.T107_codigo ) 
                            JOIN T004_usuario TJ4 ON ( TJ4.T004_login = TJ1.T004_login ) 
                            WHERE TJ1.T106_codigo = $cod ";
        
        return $this->query($sql);
    }
    
    
       public function retornaTxtAjustes($data)
    {
        $sql = "SELECT DISTINCT     TJ1.T106_codigo             Codigo 
                                  , TJ1.T006_codigo             CodLoja
                                  , TJ1.T106_data_operacao      DataOper 
                                  , TJ1.T107_codigo             TipoOper 
                                  , TJ1.T106_conta              Conta
                                  , TJ1.T106_cpf                CPF
                                  , TJ1.T106_valor_vista        ValorVista
                                  , TJ1.T106_qtd_parc           QtdParc
                                  , TJ1.T106_valor_par          ValorParc   
                                  , TJ2.T006_nome               NomeLoja 
                                  , TJ1.T106_valor_tot          ValorTotal
                                  , TJ1.T106_n_cupom            Cupom
                                  , TJ1.T106_pdv                Pdv
                                  , TJ1.T004_login		Elaborador	  
                                  , TJ1.T106_motivo             Motivo
                                  , TJ1.T106_status             Status
                                  , TJ1.T004_login              Elaborador 
                                  , TJ4.T004_nome               NomeElaborador 
                                  , TJ3.T107_descricao          DescricaoTipo
                                  , TJ1.T106_st_ajuste           Contratado
                            FROM T106_T060 TF1 
                            JOIN T106_ajustes_ems TJ1 ON ( TJ1.T106_codigo = TF1.T106_codigo ) 
                            JOIN T006_loja TJ2 ON ( TJ2.T006_codigo = TJ1.T006_codigo ) 
                            JOIN T107_T106  TJ3 ON ( TJ3.T107_codigo = TJ1.T107_codigo ) 
                            JOIN T004_usuario TJ4 ON ( TJ4.T004_login = TJ1.T004_login ) 
                            WHERE TJ1.T106_dat_lanc = '$data' ";
        
  //     echo  $sql;
        
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
    
    
        public function retornaGruposWF($user)
    {
        $sql = "SELECT TF1.T059_codigo          Codigo
                     , TF1.T059_nome		Nome
                  FROM T059_grupo_workflow      TF1
                  JOIN T060_workflow 		TJ1 ON ( TJ1.T059_codigo = TF1.T059_codigo )
                  JOIN T004_T059				TJ2 ON ( TJ2.T059_codigo = TF1.T059_codigo )
                 WHERE TF1.T061_codigo	=	4	
                   AND TJ1.T060_ordem	=	1
                   AND TJ2.T004_login	=	'$user'";
        
        //echo $sql;
        
        return $this->query($sql);
    }
    
    public function InserirFluxo($codNd, $codLoja, $codEtapa, $ordem, $user)
    {   
        $tabela = "T106_T060";
        
        if(!is_null($codEtapa))
        {
            $Etapas = $this->retornaProximaEtapa($codEtapa);

            foreach($Etapas as $campos=>$valores)
            {
                $array = array ( "T060_codigo"      =>  $valores['EtapaCodigo']
                               , "T106_codigo"      =>  $codNd
                               , "T006_codigo"       => $codLoja                    
                               , "T106_T060_ordem"  =>  $ordem
                               , "T106_T060_status" =>  0
                               , "T004_login"       =>  $user   );
                
                $this->inserir($tabela, $array);
                
                $this->InserirFluxo($codNd, $codLoja, $valores['ProxCodigoEtapa'], $ordem+1 , $user);
            }
        }
        
        return true;
    }   
  
    
       public function retornaEtapaGrupo($cod)
   {
       $sql = "SELECT T1.T060_codigo              EtapaCodigo
                    , T1.T060_proxima_etapa       ProxEtapaCodigo
                 FROM T060_workflow               T1
                WHERE T1.T059_codigo              = $cod";
             
      // echo $sql;
       
       return $this->query($sql);
   }    
   

   
   
   public function retornaND()
   {
       $sql =   "SELECT T106_codigo   codigo
                   FROM T106_ajustes_ems 
                     order by T106_codigo desc limit 1";
       return $this->query($sql);
       
   }
   
       
   public function retornaProximaEtapa($codEtapa)
   {
       return $this->query("SELECT T1.T060_codigo              EtapaCodigo
                                 , T1.T060_proxima_etapa       ProxCodigoEtapa
                              FROM T060_workflow               T1
                             WHERE T1.T060_codigo              = $codEtapa");
   }   
   
   
      
    public function retornaUltimaEtapaAjuste($AjusteCodigo)
    {
        $sql    =   " SELECT T060_codigo UltimaEtapa 
                        FROM
                            (
                                SELECT T106_T060.T106_codigo cod ,  max(T106_T060_ordem) ordem 
                                FROM T106_T060
                                WHERE T106_codigo = $AjusteCodigo
                                GROUP BY T106_T060.T106_codigo
                            ) SE1
                        JOIN T106_T060  ON (     T106_codigo     = SE1.cod
                                             AND T106_T060_ordem = SE1.ordem
                                            )";

        
        echo $sql;
        return $this->query($sql);
    }   
    
    
    public function retornaTipoSelectBox($tipo) 
    {
        
        if($tipo == '1'){
            $delim = "WHERE  T107_codigo in (1,2)";
        } elseif($tipo == "2") {
           $delim = "WHERE  T107_codigo in (3,4,5,6,7,8)";
        } else {
             $delim = " ";
        }
            
            
        $sql = "SELECT  T107_codigo         Codigo
                      , T107_descricao      Descricao
                      , T107_sigla          Sigla
                  FROM  T107_T106           TB1
                 $delim " ;
      
        return $this->query($sql);
        
    }
    
    public function selecionaDadosUser($user) {
        
        $sql = "SELECT T004_login            Login
                     , T004_nome             Nome
                     , T004_matricula        Matricula 
                  FROM T004_usuario          tb_user
        
                 WHERE T004_login       =       '$user'   ";
        
        //echo $sql;
        
        return $this->query($sql);
        
        
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
    
   
    public function retornaNcartao($cpf)
    {
        
        $connMSSQL = $this->consulta;
         
        $sql = "SELECT NUM_CARTAO_CEV       NUM_CARTAO
                  FROM dbo.CLIENTE_CORP_0116T       a (nolock)
                  JOIN dbo.CLIENTE_CARTAO_CEV_0148T b (nolock) 
                    ON      (A.COD_LOCAL_CLIENTE = B.COD_LOCAL_CLIENTE
                       AND   A.COD_CLIENTE = B.COD_CLIENTE)
                 WHERE       CPF_CLIENTE like '$cpf'
                   AND       COD_SITUACAO_CARTAO_CEV        in       ('1','2','3')     
                   AND       NUM_TITULAR_OU_DEPEND = '0'";
        
      //  echo $sql;
        
         $stid = mssql_query($sql, $connMSSQL);
                 return $stid;
        
    }
    
    function retornaMotivo($cod){
        $sql = "SELECT      T106_motivo     MOTIVO
                    FROM    T106_ajustes_ems
                   WHERE    T106_codigo     =       '$cod'";
        
        
        return $this->query($sql);
            
    }
    
}

  
?>