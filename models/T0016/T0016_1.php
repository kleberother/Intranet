<?php
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 14/04/2011 por Rodrigo Alfieri e Jorge Nova                              
 * Descrição: Classe para executar as Querys do Programa T0016
 * Entradas:  Vide Cada função
 * Origens:   T0016/*
           
**************************************************************************
*/

class models_T0016 extends models
{

    public function __construct($conn)
    {
        parent::__construct($conn);
    }

    public function GruposWorkflowUsuario($user)
    {
        return $this->query("SELECT T4.T059_codigo COD
                                  , T59.T059_nome NOME
                               FROM T004_T059 T4 , T059_grupo_workflow  T59
                              WHERE T4.T004_login = '$user'
                                AND T4.T059_codigo = T59.T059_codigo");
    }

   public function selecionaUser($user)
   {
       return $this->query("SELECT T1.T004_nome      P0016_T004_NOM
                              FROM T004_usuario      T1
                             WHERE T1.T004_login    = '$user'");
   }


    public function retornaApsPendentesAprovacao($user,$Filtro,$Limite)
    {
            
        $sql="SELECT DISTINCT
                                    T08.T008_codigo                               AS APCodigo
                                  , T08.T008_nf_numero                            AS NFNumero
                                  , T08.T026_nf_serie                             AS NFSerie
                                  , T08.T004_login                                AS Login
                                  , T08.T008_nf_valor_bruto                       AS ValorBruto
                                  -- , T08.T008_nf_valor_liq                      AS ValorLiq
                                  , date_format(T08.T008_nf_dt_vencto,'%d/%m/%Y') AS DtVencimento
                                  , T26.T026_codigo                               AS FornCodigo
                                  , T26.T026_rms_cgc_cpf                          AS FornCNPJ
                                  , T26.T026_rms_razao_social                     AS FornRazaoSocial
                                  , T60.T060_codigo                               AS CodigoEtapa
                                  , T60.T059_codigo                               AS CodigoGrupo
                                  , T08.T006_codigo                               AS CodigoLoja
                                  , T06.T006_nome                                 AS NomeLoja
                               FROM T008_T060 T0860
                               JOIN ( -- retorna as APs pendentes de aprovacao
                                      SELECT T008_codigo ap, min(T008_T060_ordem) ordem
                                        FROM T008_T060 T
                                      WHERE T008_T060_dt_aprovacao IS NULL
                                        AND T008_T060_status       = '0'
                                   GROUP BY T008_codigo
                                     ) SE1 ON (     SE1.ap       = T0860.T008_codigo
                                                AND SE1.ordem    = T0860.T008_T060_ordem
                                              )
                                    -- retorna grupos do usuario
                               JOIN T004_T059 T0459      ON ( T0459.T004_login = '$user' )
                                    -- retorna etapas dos grupos
                               JOIN T060_workflow T60    ON ( T60.T059_codigo  =  T0459.T059_codigo )
                                    -- detalhes da AP
                               JOIN T008_approval T08    ON ( T08.T008_codigo  =  T0860.T008_codigo )
                                    -- detalhes do fornecedor
                               JOIN T026_fornecedor T26  ON ( T26.T026_codigo  =  T08.T026_codigo   )
                                    -- detalhes da loja
                               JOIN T006_loja T06        ON (T06.T006_codigo   =  T08.T006_codigo   )
                              WHERE T0860.T060_codigo  = T60.T060_codigo
                                AND T08.T008_status in ('0','1')
                                AND T08.T059_codigo IS NOT NULL /*retira APs antigas */
                                ";
       
        // Monta SQL com os Filtros passados
        $sql .= $Filtro ;

        $sql .= " ORDER BY T08.T008_nf_dt_vencto ,  T08.T008_codigo";
        if (!empty($Limite))
           $sql .= " LIMIT ".$Limite.";";
        
        //echo $sql;
        return $this->query($sql);
               
    }

    public function retornaApsDigitadas($user,$Filtro,$Limite)
    {
        $sql="SELECT DISTINCT
                                   T08.T008_codigo             AS APCodigo
                                 , T08.T008_nf_numero          AS NFNumero
                                 , T08.T026_nf_serie           AS NFSerie
                                 , T08.T004_login              AS Login
                                 , T08.T008_nf_valor_bruto     AS ValorBruto
                                 -- , T08.T008_nf_valor_liq    AS ValorLiq
                                 , date_format(T08.T008_nf_dt_vencto,'%d/%m/%Y') AS DtVencimento
                                 , T26.T026_codigo             AS FornCodigo
                                 , T26.T026_rms_cgc_cpf        AS FornCNPJ
                                 , T26.T026_rms_razao_social   AS FornRazaoSocial
                                 , T08.T006_codigo             AS CodigoLoja
                                 , T06.T006_nome               AS NomeLoja
                              FROM T008_approval T08
                                   -- detalhes do fornecedor
                              JOIN T026_fornecedor T26  ON ( T26.T026_codigo  =  T08.T026_codigo   )
                                   -- detalhes da loja
                              JOIN T006_loja T06        ON ( T06.T006_codigo  =  T08.T006_codigo   )
                            WHERE T08.T008_status = '0' -- aps novas e nao aprovadas
                               AND T08.T004_login  = '$user'
                               AND T08.T059_codigo IS NOT NULL  /*retira APs antigas*/
                               AND T08.T008_status <> 4
                               ";
       
        // Monta SQL com os Filtros passados
        $sql .= $Filtro ;
        
        $sql .= " ORDER BY T08.T008_nf_dt_vencto , T08.T008_codigo";
        if (!empty($Limite))
           $sql .= " LIMIT ".$Limite.";";
        
        //echo $sql;
        return $this->query($sql);
               
    }

    public function retornaApsAnteriores($user,$Filtro,$Limite)
    {
        $sql="-- APROVACOES ANTERIORES AO USUARIO
                            -- *** PENDENTES DE APROVACAO ***
                            SELECT DISTINCT
                                   T08.T008_codigo             AS APCodigo
                                 , T08.T008_nf_numero          AS NFNumero
                                 , T08.T026_nf_serie           AS NFSerie
                                 , T08.T004_login              AS Login
                                 , T08.T008_nf_valor_bruto     AS ValorBruto
                                 -- , T08.T008_nf_valor_liq    AS ValorLiq
                                 , date_format(T08.T008_nf_dt_vencto,'%d/%m/%Y') AS DtVencimento
                                 , T08.T008_nf_valor_bruto                       AS ValorBruto
                                 -- , T08.T008_nf_valor_liq                      AS ValorLiq
                                 , T26.T026_codigo             AS FornCodigo
                                 , T26.T026_rms_cgc_cpf        AS FornCNPJ
                                 , T26.T026_rms_razao_social   AS FornRazaoSocial
                                 , T08.T006_codigo             AS CodigoLoja
                                 , T06.T006_nome               AS NomeLoja
                              FROM (  SELECT T0860.T008_codigo AP , max(T0860.T008_T060_ordem) ordem
                                        FROM T008_T060 T0860
                                        JOIN ( -- retorna as APs que ja foram aprovadas
                                              SELECT T008_codigo ap, max(T008_T060_ordem) ordem
                                                FROM T008_T060 T
                                              WHERE T008_T060_ordem        IS NOT NULL
                                                -- AND T008_T060_status       = '1'
                                                AND T008_T060_dt_aprovacao IS NULL -- nao aprovadas
                                                GROUP BY  T008_codigo
                                              ) SE1 ON ( SE1.ap  = T0860.T008_codigo )
                                            -- retorna grupos do usuario
                                        JOIN T004_T059 T0459      ON ( T0459.T004_login = '$user' )
                                            -- retorna etapas dos grupos
                                        JOIN T060_workflow T60    ON ( T60.T059_codigo  =  T0459.T059_codigo )
                                       WHERE T0860.T060_codigo  = T60.T060_codigo
                                         AND T0860.T008_T060_dt_aprovacao IS NULL -- em que o usuario logado nao aprovou
                                      GROUP BY T0860.T008_codigo
                                    ) SE2
                               JOIN T008_T060 T0860_2 ON (     T0860_2.T008_codigo     = SE2.AP
                                                           AND T0860_2.T008_T060_ordem < SE2.ordem -- etapas anteriores ao usuario logado
                                                         )
                               -- detalhes da AP
                               JOIN T008_approval T08    ON ( T08.T008_codigo  =  T0860_2.T008_codigo )
                               -- detalhes do fornecedor
                               JOIN T026_fornecedor T26  ON ( T26.T026_codigo  =  T08.T026_codigo     )
                                    -- detalhes da loja
                               JOIN T006_loja T06        ON ( T06.T006_codigo  =  T08.T006_codigo     )
                              WHERE T08.T059_codigo IS NOT NULL -- retira APs antigas
                                AND T08.T008_status   in ( '0','1' ) -- novas ou ja aprovadas
                                AND T0860_2.T008_T060_dt_aprovacao IS NULL  /*somente nao aprovadas*/
                                    ";
        // Monta SQL com os Filtros passados
        $sql .= $Filtro ;
        
        $sql .= "ORDER BY T08.T008_nf_dt_vencto , T08.T008_codigo";
        if (!empty($Limite))
           $sql .= " LIMIT ".$Limite.";";
        
        //echo $sql;
        return $this->query($sql);
       
        
    }

    public function retornaApsPosteriores($user,$Filtro,$Limite)
    {
        $sql="-- APS POSTERIORES AO USUARIO
                            -- *** JA FORAM APROVADAS ***
                            SELECT DISTINCT
                                   T08.T008_codigo             AS APCodigo
                                 , T08.T008_nf_numero          AS NFNumero
                                 , T08.T026_nf_serie           AS NFSerie
                                 , T08.T004_login              AS Login
                                 , T08.T008_nf_valor_bruto                       AS ValorBruto
                                 -- , T08.T008_nf_valor_liq                      AS ValorLiq
                                 , date_format(T08.T008_nf_dt_vencto,'%d/%m/%Y') AS DtVencimento
                                 , T08.T008_nf_valor_bruto                       AS ValorBruto
                                 -- , T08.T008_nf_valor_liq                      AS ValorLiq
                                 , T26.T026_codigo             AS FornCodigo
                                 , T26.T026_rms_cgc_cpf        AS FornCNPJ
                                 , T26.T026_rms_razao_social   AS FornRazaoSocial
                                 , T08.T006_codigo             AS CodigoLoja
                                 , T06.T006_nome               AS NomeLoja
                              FROM (  SELECT T0860.T008_codigo AP , max(T0860.T008_T060_ordem) ordem
                                        FROM T008_T060 T0860
                                        JOIN ( -- retorna as APs que ja foram aprovadas
                                              SELECT T008_codigo ap, max(T008_T060_ordem) ordem
                                                FROM T008_T060 T
                                              WHERE T008_T060_ordem        IS NOT NULL
                                                -- AND T008_T060_status       = '1'
                                                -- AND T008_T060_dt_aprovacao IS NOT NULL
                                                GROUP BY  T008_codigo
                                              ) SE1 ON ( SE1.ap  = T0860.T008_codigo )
                                            -- retorna grupos do usuario
                                        JOIN T004_T059 T0459      ON ( T0459.T004_login = '$user' )
                                            -- retorna etapas dos grupos
                                        JOIN T060_workflow T60    ON ( T60.T059_codigo  =  T0459.T059_codigo )
                                       WHERE T0860.T060_codigo  = T60.T060_codigo
                                         AND T0860.T008_T060_dt_aprovacao IS NOT NULL -- em que o usuario JA aprovou
                                      GROUP BY T0860.T008_codigo
                                    ) SE2
                               JOIN T008_T060 T0860_2 ON (     T0860_2.T008_codigo     = SE2.AP
                                                           AND T0860_2.T008_T060_ordem > SE2.ordem
                                                         )
                               -- detalhes da AP
                               JOIN T008_approval T08    ON ( T08.T008_codigo  =  T0860_2.T008_codigo )
                               -- detalhes do fornecedor
                               JOIN T026_fornecedor T26  ON ( T26.T026_codigo  =  T08.T026_codigo     )
                               -- detalhes da loja
                               JOIN T006_loja T06        ON ( T06.T006_codigo  =  T08.T006_codigo     )
                              WHERE T08.T059_codigo IS NOT NULL -- retira APs antigas
                                AND T08.T008_status   = '1' -- somente com aprovacao
                                -- AND T0860_2.T008_T060_dt_aprovacao IS NOT NULL /*somente aprovadas*/
                               ";

        // Monta SQL com os Filtros passados
        $sql .= $Filtro ;
        
        $sql .= " ORDER BY T08.T008_nf_dt_vencto , T08.T008_codigo";
        if (!empty($Limite))
           $sql .= " LIMIT ".$Limite.";";
        
        //echo $sql;
        return $this->query($sql);
               
        
    }

    public function retornaApsCanceladas($user,$Filtro,$Limite)
    {
        // SQL Principal
        $sql  = "   SELECT DISTINCT
                                       T08.T008_codigo             AS APCodigo
                                     , T08.T008_nf_numero          AS NFNumero
                                     , T08.T026_nf_serie           AS NFSerie
                                     , T08.T004_login              AS Login
                                     , T08.T008_nf_valor_bruto                       AS ValorBruto
                                     -- , T08.T008_nf_valor_liq                      AS ValorLiq
                                     , date_format(T08.T008_nf_dt_vencto,'%d/%m/%Y') AS DtVencimento
                                     , T08.T008_nf_valor_bruto                       AS ValorBruto
                                     -- , T08.T008_nf_valor_liq                      AS ValorLiq
                                     , T26.T026_codigo             AS FornCodigo
                                     , T26.T026_rms_cgc_cpf        AS FornCNPJ
                                     , T26.T026_rms_razao_social   AS FornRazaoSocial
                                     , T08.T006_codigo             AS CodigoLoja
                                     , T06.T006_nome               AS NomeLoja
                                  FROM T008_approval T08
                                   -- retorna etapas das APs
                                  JOIN T008_T060 T0860      ON ( T0860.T008_codigo = T08.T008_codigo )
                                   -- retorna grupos do usuario
                                  JOIN T004_T059 T0459      ON ( T0459.T004_login = '$user' )
                                   -- retorna etapas dos grupos do usuario
                                  JOIN T060_workflow T60    ON (    T60.T059_codigo    =  T0459.T059_codigo
                                                                                                                        AND T0860.T060_codigo  =  T60.T060_codigo
                                                                                                                  )
                                  JOIN T026_fornecedor T26  ON ( T26.T026_codigo  =  T08.T026_codigo     )
                                   -- detalhes da loja
                                  JOIN T006_loja T06        ON ( T06.T006_codigo  =  T08.T006_codigo     )
                                 WHERE T08.T008_status = 4  /*somente canceladas*/ ";
        
        // Monta SQL com os Filtros passados
        $sql .= $Filtro ;
        
        $sql .= " ORDER BY 1 DESC";
        if (!empty($Limite))
           $sql .= " LIMIT ".$Limite.";";
        
        //echo $sql;
        return $this->query($sql);
        
    }

    public function retornaApsFinalizadas($user,$Filtro,$Limite)
    {
        
        // SQL Principal
        $sql  = "   SELECT DISTINCT
                                       T08.T008_codigo             AS APCodigo
                                     , T08.T008_nf_numero          AS NFNumero
                                     , T08.T026_nf_serie           AS NFSerie
                                     , T08.T004_login              AS Login
                                     , T08.T008_nf_valor_bruto                       AS ValorBruto
                                     -- , T08.T008_nf_valor_liq                      AS ValorLiq
                                     , date_format(T08.T008_nf_dt_vencto,'%d/%m/%Y') AS DtVencimento
                                     , T08.T008_nf_valor_bruto                       AS ValorBruto
                                     -- , T08.T008_nf_valor_liq                      AS ValorLiq
                                     , T26.T026_codigo             AS FornCodigo
                                     , T26.T026_rms_cgc_cpf        AS FornCNPJ
                                     , T26.T026_rms_razao_social   AS FornRazaoSocial
                                     , T08.T006_codigo             AS CodigoLoja
                                     , T06.T006_nome               AS NomeLoja
                                  FROM T008_approval T08
                                   -- retorna etapas das APs
                                  JOIN T008_T060 T0860      ON ( T0860.T008_codigo = T08.T008_codigo )
                                   -- retorna grupos do usuario
                                  JOIN T004_T059 T0459      ON ( T0459.T004_login = '$user' )
                                   -- retorna etapas dos grupos do usuario
                                  JOIN T060_workflow T60    ON (    T60.T059_codigo    =  T0459.T059_codigo
                                                                                                                        AND T0860.T060_codigo  =  T60.T060_codigo
                                                                                                                  )
                                  JOIN T026_fornecedor T26  ON ( T26.T026_codigo  =  T08.T026_codigo     )
                                  -- detalhes da loja
                                  JOIN T006_loja T06        ON ( T06.T006_codigo  =  T08.T006_codigo     )
                                 WHERE T08.T008_status = 9 /*somente finalizadas*/ ";
        
        // Monta SQL com os Filtros passados
        $sql .= $Filtro ;
        
        $sql .= " ORDER BY 1 DESC";
        if (!empty($Limite))
           $sql .= " LIMIT ".$Limite.";";
        
        //echo $sql;
        return $this->query($sql);
       

    }
    
    public function retornaUltimasApsFornecedor($FornCodigo,$Filtro,$Limite)
    {
        // SQL Principal
        $sql  = "SELECT DISTINCT
                   T08.T008_codigo             AS APCodigo
                 , T08.T008_nf_numero          AS NFNumero
                 , T08.T026_nf_serie           AS NFSerie
                 , T08.T004_login              AS Login
                 , T08.T008_nf_valor_bruto                       AS ValorBruto
                 -- , T08.T008_nf_valor_liq                      AS ValorLiq
                 , date_format(T08.T008_nf_dt_vencto,'%d/%m/%Y') AS DtVencimento
                 , T08.T008_nf_valor_bruto                       AS ValorBruto
                 -- , T08.T008_nf_valor_liq                      AS ValorLiq
                 , T26.T026_codigo             AS FornCodigo
                 , T08.T006_codigo             AS CodigoLoja
                 , T06.T006_nome               AS NomeLoja
                 , T08.T008_status             As StatusCod 
                 , CASE T08.T008_status
                     WHEN 0 THEN 'Digitadas'
                     WHEN 1 THEN 'À Aprovar'
                     WHEN 4 THEN 'Cancelada'
                     WHEN 9 THEN 'Finalizada'
                     ELSE 'Antiga' END         AS Status
                 , T08.T008_tp_despesa         AS DespesaCod
                 , CASE T08.T008_tp_despesa
                     WHEN 1 THEN 'Eventual'
                     WHEN 2 THEN 'Por Demanda'
                     WHEN 3 THEN 'Regular'
                     ELSE 'Indefinido' END         AS Despesa        
              FROM T008_approval T08
               -- retorna etapas das APs
              JOIN T008_T060 T0860      ON ( T0860.T008_codigo = T08.T008_codigo )
               -- retorna grupos do usuario
              JOIN T026_fornecedor T26  ON ( T26.T026_codigo  =  T08.T026_codigo     )
              -- detalhes da loja
              JOIN T006_loja T06        ON ( T06.T006_codigo  =  T08.T006_codigo     )
             WHERE T26.T026_codigo  = $FornCodigo";
        
        // Monta SQL com os Filtros passados
        $sql .= $Filtro ;
        
        $sql .= " ORDER BY 1 DESC";
        if (!empty($Limite))
           $sql .= " LIMIT ".$Limite.";";
        
        //echo $sql;
        return $this->query($sql);
        
    }    


    public function selecionaAPMon()
    {
        return $this->query("SELECT A.T008_codigo            AS COD
                                  , A.T008_nf_numero         AS NNF
                                  , A.T026_nf_serie          AS SER
                                  , A.T004_login             AS LOG
                                  , A.T008_status            AS STA
                                  , F.T026_codigo            AS CFO
                                  , F.T026_rms_cgc_cpf       AS CGC
                                  , F.T026_rms_razao_social  AS RAZ
                               FROM T008_approval            AS A
                              INNER JOIN T026_fornecedor     AS F
                                 ON F.T026_codigo = A.T026_codigo
                              WHERE ( A.T059_codigo IS NULL -- somente APs antigas
                                      OR
                                      A.T008_status > 10 -- antigas c/ status anterior
                                    )
                           ORDER BY A.T008_status, T004_login");

    }

    public function retornaAp($ap)
    {
        return $this->query("SELECT A.T008_codigo            AS COD
                                  , A.T008_nf_numero         AS NNF
                                  , A.T026_nf_serie          AS SER
                                  , A.T004_login             AS LOG
                                  , A.T008_status            AS STA
                                  , F.T026_codigo            AS CFO
                                  , F.T026_rms_cgc_cpf       AS CGC
                                  , F.T026_rms_razao_social  AS RAZ
                               FROM T008_approval            AS A
                              INNER JOIN T026_fornecedor     AS F
                                 ON F.T026_codigo = A.T026_codigo
                              WHERE A.T008_codigo   =   $ap
                           ORDER BY A.T008_status ASC");

    }



    public function selecionaTipoArquivo()
    {
        return $this->query("SELECT T.T056_codigo            AS COD
                                  , T.T056_nome              AS NOM
                               FROM T056_categoria_arquivo   AS T;");
    }

    public function listaLojas()
    {
       return $this->query("SELECT L.T006_codigo AS LCODI
                                 , L.T006_nome   AS LNOME
                              FROM T006_loja     AS L
                             WHERE L.T006_codigo > 0");
    }

    public function listaWF()
    {
       return $this->query("SELECT T59.T059_codigo	COD
                                 , T59.T059_nome        NOM
                              FROM T060_workflow T60
                              JOIN T059_grupo_workflow T59 ON ( T59.T059_codigo = T60.T059_codigo )
                             WHERE T60.T060_ordem = 1
                             ORDER BY 1");
    }

    public function selecionaGrupofkw($cod, $loja)
    {
      return $this->query("SELECT T1.T059_codigo       COD
                                , T3.T059_nome         NOM
                             FROM T026_T059            T1
                                , T026_fornecedor      T2
                                , T059_grupo_workflow  T3
                            WHERE T1.T026_codigo = T2.T026_codigo
                              AND T1.T059_codigo = T3.T059_codigo
                              AND T2.T026_codigo = $cod");
    }

    public function buscaGrupo($cod, $loja)
    {
        $sql = "SELECT T1.T059_codigo       COD
                                , T3.T059_nome         NOM
                             FROM T026_T059            T1
                                , T026_fornecedor      T2
                                , T059_grupo_workflow  T3
                            WHERE T1.T026_codigo = T2.T026_codigo
                              AND T1.T059_codigo = T3.T059_codigo
                              AND T2.T026_codigo = $cod
                              AND T1.T006_codigo = $loja";
        
        return $this->query($sql);
        
    }

    public function BuscaAPPorNF($cnpj, $num_nf)
    {
      return $this->query(" SELECT  T08.T008_codigo           APCodigo
                                  , T08.T008_nf_dt_emiss      DataEmissao
                                  , T08.T008_nf_valor_bruto                       AS ValorBruto
                                  -- , T08.T008_nf_valor_liq                      AS ValorLiq
                                  , T08.T008_nf_valor_bruto   ValorBruto
                                  , T08.T008_dt_elaboracao    DataElaboracao
                                  , T08.T004_login            Login
                                  , T26.T026_rms_cgc_cpf
                                  , T026_nf_serie
                                  , T26.T026_codigo
                                  , T08.T026_codigo
                                  ,T08.T008_nf_numero
                              FROM T008_approval   T08
                             INNER JOIN T026_fornecedor T26 ON ( T08.T026_codigo         = T26.T026_codigo )
                             WHERE T08.T008_nf_numero        = $num_nf
                               -- AND upper(T08.T026_nf_serie)  = '$serie'
                               AND T26.T026_rms_cgc_cpf      = '$cnpj'
                                ")->fetchAll(PDO::FETCH_ASSOC);
    }


    public function selecionaForn($cnpj)
    {
       return $this->query(" SELECT T1.T026_codigo          COD
                                  , T1.T026_rms_cgc_cpf     CGC
                               FROM T026_fornecedor         T1
                              WHERE T1.T026_rms_cgc_cpf = '$cnpj'");

    }

    public function selecionaFornRMS($cnpj,$cod)
    {
        $connORA  =   $this->consulta;
        $sql = "SELECT T1.TIP_CODIGO
                    || T1.TIP_DIGITO            COD
                     , T1.TIP_RAZAO_SOCIAL      RAZ
                     , T1.TIP_CGC_CPF           CGC
                     , T1.TIP_INSC_EST_IDENT    IES
                     , T1.TIP_INSC_MUN          IMN
                  FROM RMS.AA2CTIPO             T1";
        if($cod == 0)
            $sql = $sql . " WHERE T1.TIP_CGC_CPF  =   '$cnpj'";
        else
            $sql = $sql . " WHERE T1.TIP_CODIGO
                               || T1.TIP_DIGITO   =   $cod";
        $stid    = oci_parse($connORA, $sql);
        oci_execute($stid);
        return($stid);
    }

    public function inserir($tabela,$campos)
    {
        return $this->exec($this->insere($tabela, $campos));
    }

    //Para Upload
    public function selecionaExtensao($extensao)
    {
       return $this->query("SELECT T1.T057_codigo   COD
                                  , T1.T057_nome    NOM
                                  , T1.T057_desc    DES
                               FROM T057_extensao   T1
                              WHERE T1.T057_nome = '$extensao'");
    }

    public function selecionaArquivos($ap)
    {
        return $this->query("SELECT T5.T056_nome           NOM
                                  , T5.T056_codigo         CAT
                                  , T3.T055_codigo         ARQ
                                  , T5.T056_desc           DES
                                  , T4.T057_nome           EXT
                               FROM T008_T055              T1
                                  , T008_approval          T2
                                  , T055_arquivos          T3
                                  , T057_extensao          T4
                                  , T056_categoria_arquivo T5
                              WHERE T1.T008_codigo =   T2.T008_codigo
                                AND T1.T055_codigo =   T3.T055_codigo
                                AND T3.T056_codigo =   T5.T056_codigo
                                AND T3.T057_codigo =   T4.T057_codigo
                                AND T1.T008_codigo =   $ap");
   }

   public function selecionaAPDF($cod)
   {
       return $this->query("SELECT A.T008_codigo              P0016_T008_COD
                                 , A.T008_nf_numero             P0016_T008_NNF
                                 , A.T008_nf_dt_emiss           P0016_T008_DTE
                                 , A.T008_nf_dt_receb           P0016_T008_DTR
                                 , A.T008_nf_valor_bruto        P0016_T008_VAB
                                 , A.T008_forma_pagto           P0016_T008_FPA
                                 , A.T008_num_contrato          P0016_T008_NCO
                                 , A.T008_tp_despesa            P0016_T008_TDE
                                 , A.T008_desc                  P0016_T008_DES
                                 , A.T008_justificativa         P0016_T008_JUS
                                 , A.T008_inst_controladoria    P0016_T008_INS
                                 , A.T008_dados_controladoria   P0016_T008_CON
                                 , A.T008_ft_numero             P0016_T008_FAT
                                 , A.T026_nf_serie              P0016_T026_SER
                                 , A.T008_nf_dt_vencto          P0016_T008_DTV
                                 , B.T026_rms_cgc_cpf           P0016_T026_CGC
                                 , B.T026_rms_razao_social      P0016_T026_RAZ
                                 , B.T026_rms_codigo            P0016_T026_COD
                                 , B.T026_rms_digito            P0016_T026_DIG
                                 , B.T026_rms_insc_est_ident    P0016_T026_INE
                                 , B.T026_rms_insc_mun          P0016_T026_INM
                                 , C.T006_codigo                P0016_T006_COD
                                 , C.T006_nome                  P0016_T006_NOM
                                 , D.T004_nome                  P0016_T004_NOM
                                 , E.T059_codigo                P0016_T059_COD
                                 , E.T059_nome                  P0016_T059_NOM
                              FROM T008_approval as A
                             INNER JOIN T026_fornecedor as B
                                ON A.T026_codigo = B.T026_codigo
                             INNER JOIN T006_loja as C
                                ON A.T006_codigo = C.T006_codigo
                             INNER JOIN T004_usuario as D
                                ON A.T004_login = D.T004_login
                             INNER JOIN T059_grupo_workflow as E
                                ON A.T059_codigo = E.T059_codigo
                             WHERE A.T008_codigo = $cod");
   }

   public function selecionaGrpWkfUser($user)
   {
       return $this->query("SELECT T2.T059_codigo
                                 , T2.T059_nome
                                 , T3.T060_codigo
                              FROM T004_T059            T1
                                 , T059_grupo_workflow  T2
                                 , T060_workflow        T3
                             WHERE T1.T059_codigo  = T2.T059_codigo
                               AND T1.T059_codigo  = T3.T059_codigo
                               AND T2.T059_codigo  = T3.T059_codigo
                               AND T1.T004_login  = '$user'
                               AND T1.T061_codigo = 1");
   }

   public function selecionaGrpsDp($cod)
   {
       return $this->query("SELECT T1.T059_codigo
                                 , T1.T059_nome
                              FROM T059_grupo_workflow  T1
                                 , T060_workflow        T2
                             WHERE T1.T059_codigo = T2.T059_codigo
                               AND T2.T060_proxima_etapa  = $cod");
   }

   public function retornaEtapaGrupo($cod)
   {
       return $this->query("SELECT T1.T060_codigo              EtapaCodigo
                                 , T1.T060_proxima_etapa       ProxEtapaCodigo
                              FROM T060_workflow               T1
                             WHERE T1.T059_codigo              = $cod");
   }

   public function RetornaUltimaEtapaAP($cod)
   { /*Função para retornar última etapa da AP*/
       return $this->query("SELECT T060_codigo EtapaCodigo -- retorna última etapa da AP
                              FROM
                                 (
                                    SELECT T008_T060.T008_codigo cod ,  max(T008_T060_ordem) ordem -- retorna ultima ordem da AP
                                      FROM T008_T060
                                     WHERE T008_codigo = $cod
                                    GROUP BY T008_T060.T008_codigo
                                  ) SE1
                               JOIN T008_T060  ON (     T008_codigo     = SE1.cod
                                                    AND T008_T060_ordem = SE1.ordem
                                                  )
                            ");
   }


   public function retornaProximaEtapa($codEtapa)
   {
       return $this->query("SELECT T1.T060_codigo              EtapaCodigo
                                 , T1.T060_proxima_etapa       ProxCodigoEtapa
                              FROM T060_workflow               T1
                             WHERE T1.T060_codigo              = $codEtapa");
   }

   public function RetornaGrupoWorkflowAP($cod_AP)
   {
       return $this->query("SELECT T059_codigo
                                 , T008_status
                              FROM T008_approval
                             WHERE T008_codigo = $cod_AP");
   }

    public function altera($tabela,$campos,$delim)
    {
       $conn = "";
       $altera = $this->exec($this->atualiza($tabela, $campos, $delim));
       return $altera;
    }


   public function ConferenciaAp($ap)
   {
       return $this->query("SELECT T04.T004_nome                                                AS NomeUsuario
                                 , date_format(T860.T008_T060_dt_aprovacao,'%d/%m/%Y %h:%m:%s') AS DtAprovacao
                              FROM T008_T060 T860
                              JOIN T004_usuario T04 ON (T860.T004_login = T04.T004_login)
                             WHERE T008_codigo          = $ap
                               AND T860.T008_T060_ordem = 1
                               AND T860.T008_T060_dt_aprovacao IS NOT NULL");
   }

   //========================================================================
   public function retornaEtapaUsuario($user)
   {
       return $this->query("SELECT T060_codigo etapa
                              FROM T060_workflow wkf
                             WHERE T061_codigo = 1
                               AND T059_codigo IN
                                          (SELECT T059_codigo
                                             FROM T004_T059
                                            WHERE T061_codigo = 1
                                              AND T004_login = '$user')");
   }

   public function Lista_AP_abaixo($etapa)
   {
     $i = 0;
     $x = $this->retornaProxEtapa($etapa);
     foreach ($x as $x_campos=>$x_val)
     {
       $y = $this->quais_aps_deste_grupo($x_val['grupo']);
       foreach ($y as $y_campos=>$y_val)
       {
        $z = $this->verifica_se_ap_foi_aprovada($y_val['ap'],$etapa);
        foreach ($z as $z_campos=>$z_val) $existe=$z_val['existe'];
        if  ($existe == 0)
            {
             $dados[$i] = $this->retornaAp($y_val['ap']);
             $i++;
            }
       }
       $x= $this->Lista_AP_abaixo($x_val['etapa']);
     }
     return $dados;
   }

   public function verifica_se_ap_foi_aprovada($ap,$etapa)
   {
    return $this->query("select count(*) existe
                            from T008_T060
                            where
                            T008_codigo = $ap and
                            T060_codigo = $etapa");
   }

   public function quais_aps_deste_grupo($grupo)
   {
    return $this->query("select T008_codigo ap, T008_status, T059_codigo
                            from T008_approval
                            where
                            T061_codigo   = 1 and
                            T059_codigo   = $grupo");
   }


   public function retornaProxEtapa($etapa)
   {
       return $this->query("SELECT T059_codigo grupo
                                 , T060_codigo  etapa
                              FROM T060_workflow
                             WHERE T060_proxima_etapa = $etapa");
   }

   public function dados_ap($ap)
   {
     $sql = "SELECT A.T008_codigo            AS COD
                  , A.T008_nf_numero         AS NNF
                  , A.T026_nf_serie          AS SER
                  , A.T004_login             AS LOG
                  , F.T026_codigo            AS CFO
                  , F.T026_rms_cgc_cpf       AS CGC
                  , F.T026_rms_razao_social  AS RAZ
                FROM T008_approval        AS A
               INNER JOIN T026_fornecedor AS F
                  ON F.T026_codigo = A.T026_codigo
               WHERE T008_codigo = $ap";
     return $this->query($sql);
   }


   public function retornaUltimaAprovacao($ap)
   {
        return $this->query("  -- aps que nunca foram aprovadas
                            SELECT '000'                           AS GrupoCodigo
                                 , 'AP digitada e não aprovada'    AS GrupoNome
                                 , date_format(T08.T008_dt_elaboracao,'%d/%m/%Y') DtAprovacao
                                 , time(T08.T008_dt_elaboracao)                   TimeAprovacao
                                 , T08.T004_login                AS Login
                              FROM T008_approval       T08
                              JOIN T059_grupo_workflow T59 ON  ( T59.T059_codigo  = T08.T059_codigo   )
                              WHERE T08.T008_codigo  = $ap
                                AND T08.T008_status    = '0'
                            UNION
                            -- aps que ja sofreram alguma aprovacao
                            SELECT T59.T059_codigo AS GrupoCodigo
                                 , T59.T059_nome   AS GrupoNome
                                 , date_format(T0860.T008_T060_dt_aprovacao,'%d/%m/%Y') dtAprovacao
                                 , time(T0860.T008_T060_dt_aprovacao)                   TimeAprovacao
                                 , T0860.T004_login        AS Login
                              FROM T008_T060 T0860
                             JOIN  (  SELECT T060_codigo etapa, max(T008_T060_ordem) ordem
                                        FROM T008_T060 T
                                       WHERE T008_T060_dt_aprovacao IS NOT NULL
                                         AND T008_T060_status       IN ('1') -- Aprovadas
                                         AND T008_codigo            = $ap
                                    GROUP BY T.T008_codigo
                                   ) SE1 ON ( SE1.etapa  = T0860.T060_codigo )
                              JOIN T060_workflow  T60      ON  ( T60.T060_codigo  = T0860.T060_codigo )
                              JOIN T059_grupo_workflow T59 ON  ( T59.T059_codigo  = T60.T059_codigo   )
                              JOIN T008_approval       T08 ON  ( T08.T008_codigo  = $ap               )
                            WHERE T0860.T008_codigo  = $ap
                              AND T08.T008_status    IN ('1','4','9') -- Finalizadas");
   }

   public function retornaProximaEtapaAp($ap)
   {
        return $this->query("SELECT T060_proxima_etapa
                               FROM T060_workflow wkf
                              WHERE T061_codigo = 1
                                 AND T059_codigo IN
                                              (SELECT ap.T059_codigo
                                                 FROM T008_approval ap
                                                WHERE ap.T008_codigo  = $ap)");
   }

    public function retornaApsParadasEtapa($tipo)
    {
        //Aps Paradas no Provisionador
        if ($tipo == 3)
        {
            return $this->query("
                                -- APS Paradas para o Provisionador aprovar
                                SELECT DISTINCT
                                       T08.T008_codigo             AS APCodigo
                                     , T08.T008_nf_numero          AS NFNumero
                                     , T08.T026_nf_serie           AS NFSerie
                                     , T08.T004_login              AS Login
                                     , T08.T008_nf_valor_bruto     AS ValorBruto
                                    -- , T08.T008_nf_valor_liq       AS ValorLiq
                                     , date_format(T08.T008_nf_dt_vencto,'%d/%m/%Y') AS DtVencimento
                                     , T26.T026_codigo             AS FornCodigo
                                     , T26.T026_rms_cgc_cpf        AS FornCNPJ
                                     , T26.T026_rms_razao_social   AS FornRazaoSocial
                                     , T08.T006_codigo             AS CodigoLoja
                                     , T06.T006_nome               AS NomeLoja
                                  FROM (
                                          -- retorna as APs que ja foram aprovadas e que existe e etapa 1
                                          SELECT T008_codigo ap, max(T008_T060_ordem) ordem
                                            FROM T008_T060 T
                                            WHERE T008_T060_ordem        IS NOT NULL
                                              AND T060_codigo            = 1 -- etapa do Provisionador
                                            -- AND T008_T060_status       = '1'
                                              AND T008_T060_dt_aprovacao IS NULL
                                            GROUP BY  T008_codigo
                                        ) SE1
                                  JOIN T008_T060 T0860A ON (    T0860A.T008_codigo     = SE1.ap
                                                            AND T0860A.T008_T060_ordem = SE1.ordem - 1 -- etapa anterior ao provisionador
                                                           )
                                   -- detalhes da AP
                                   JOIN T008_approval T08    ON ( T08.T008_codigo  =  T0860A.T008_codigo )
                                   -- detalhes do fornecedor
                                   JOIN T026_fornecedor T26  ON ( T26.T026_codigo  =  T08.T026_codigo     )
                                  -- detalhes da loja
                                  JOIN T006_loja T06        ON ( T06.T006_codigo  =  T08.T006_codigo     )
                                WHERE T0860A.T008_T060_dt_aprovacao IS NOT NULL     -- qdo o lançador JÁ aprovou
                                  AND T08.T059_codigo IS NOT NULL -- retira APs antigas
                                  AND T08.T008_status   = '1'  -- somente aprovadas
                                ORDER BY T08.T008_nf_dt_vencto;");
        }

        // Aps Paradas no lançador
        if ($tipo==4)
        {

            return $this->query("
                                    -- APS Paradas para o Lançador aprovar
                                    SELECT DISTINCT
                                           T08.T008_codigo             AS APCodigo
                                         , T08.T008_nf_numero          AS NFNumero
                                         , T08.T026_nf_serie           AS NFSerie
                                         , T08.T004_login              AS Login
                                         , T08.T008_nf_valor_bruto     AS ValorBruto
                                        -- , T08.T008_nf_valor_liq       AS ValorLiq
                                         , date_format(T08.T008_nf_dt_vencto,'%d/%m/%Y') AS DtVencimento
                                         , T26.T026_codigo             AS FornCodigo
                                         , T26.T026_rms_cgc_cpf        AS FornCNPJ
                                         , T26.T026_rms_razao_social   AS FornRazaoSocial
                                         , T08.T006_codigo             AS CodigoLoja
                                         , T06.T006_nome               AS NomeLoja
                                      FROM (
                                              -- retorna as APs que ja foram aprovadas e que existe e etapa 1
                                              SELECT T008_codigo ap, max(T008_T060_ordem) ordem
                                                FROM T008_T060 T
                                                WHERE T008_T060_ordem        IS NOT NULL
                                                  AND T060_codigo            = 1 -- etapa do Provisionador
                                                -- AND T008_T060_status       = '1'
                                                -- AND T008_T060_dt_aprovacao IS NOT NULL
                                                GROUP BY  T008_codigo
                                            ) SE1
                                      JOIN T008_T060 T0860A ON (    T0860A.T008_codigo     = SE1.ap
                                                                AND T0860A.T008_T060_ordem = SE1.ordem - 1 -- etapa anterior ao provisionador
                                                                AND T0860A.T060_codigo     = 2 -- somente etapa Lançador
                                                               )
                                      JOIN T008_T060 T0860B ON (    T0860B.T008_codigo     = SE1.ap
                                                                AND T0860B.T008_T060_ordem = SE1.ordem - 2 -- etapa anterior ao lançador
                                                               )
                                       -- detalhes da AP
                                       JOIN T008_approval T08    ON ( T08.T008_codigo  =  T0860A.T008_codigo )
                                       -- detalhes do fornecedor
                                       JOIN T026_fornecedor T26  ON ( T26.T026_codigo  =  T08.T026_codigo     )
                                       -- detalhes da loja
                                       JOIN T006_loja T06        ON ( T06.T006_codigo  =  T08.T006_codigo     )
                                    WHERE T0860A.T008_T060_dt_aprovacao IS NULL     -- qdo o lançador ainda nao aprovou
                                      AND T0860B.T008_T060_dt_aprovacao IS NOT NULL -- qdo está parada para o lançador
                                      AND T08.T059_codigo IS NOT NULL -- retira APs antigas
                                      AND T08.T008_status   = '1'  -- somente aprovadas
                                    ORDER BY T08.T008_nf_dt_vencto;
                                ");
        }
        // Aps Paradas no Conferente de impostos
        if ($tipo==5)
        {

            return $this->query("
                                -- APS Paradas para o Conferente de Impostos aprovar
                                SELECT DISTINCT
                                       T08.T008_codigo             AS APCodigo
                                     , T08.T008_nf_numero          AS NFNumero
                                     , T08.T026_nf_serie           AS NFSerie
                                     , T08.T004_login              AS Login
                                     , T08.T008_nf_valor_bruto     AS ValorBruto
                                        -- , T08.T008_nf_valor_liq       AS ValorLiq
                                     , date_format(T08.T008_nf_dt_vencto,'%d/%m/%Y') AS DtVencimento
                                     , T26.T026_codigo             AS FornCodigo
                                     , T26.T026_rms_cgc_cpf        AS FornCNPJ
                                     , T26.T026_rms_razao_social   AS FornRazaoSocial
                                     , T08.T006_codigo             AS CodigoLoja
                                     , T06.T006_nome               AS NomeLoja
                                  FROM (
                                          -- retorna as APs que ja foram aprovadas e que existe e etapa 1
                                          SELECT T008_codigo ap, max(T008_T060_ordem) ordem
                                            FROM T008_T060 T
                                            WHERE T008_T060_ordem        IS NOT NULL
                                              AND T060_codigo            = 2 -- etapa do Lançador
                                            -- AND T008_T060_status       = '1'
                                            -- AND T008_T060_dt_aprovacao IS NOT NULL
                                            GROUP BY  T008_codigo
                                        ) SE1
                                  JOIN T008_T060 T0860A ON (    T0860A.T008_codigo     = SE1.ap
                                                            AND T0860A.T008_T060_ordem = SE1.ordem - 1 -- etapa anterior ao Lançador
                                                            AND T0860A.T060_codigo     = 3 -- somente etapa Conferente de Impostos
                                                           )
                                  JOIN T008_T060 T0860B ON (    T0860B.T008_codigo     = SE1.ap
                                                            AND T0860B.T008_T060_ordem = SE1.ordem - 2 -- etapa anterior ao Conferente
                                                           )
                                   -- detalhes da AP
                                   JOIN T008_approval T08    ON ( T08.T008_codigo  =  T0860A.T008_codigo )
                                   -- detalhes do fornecedor
                                   JOIN T026_fornecedor T26  ON ( T26.T026_codigo  =  T08.T026_codigo     )
                                   -- detalhes da loja
                                   JOIN T006_loja T06        ON ( T06.T006_codigo  =  T08.T006_codigo     )
                                WHERE T0860A.T008_T060_dt_aprovacao IS NULL     -- qdo o lançador ainda nao aprovou
                                  AND T0860B.T008_T060_dt_aprovacao IS NOT NULL -- qdo está parada para o lançador
                                  AND T08.T059_codigo IS NOT NULL -- retira APs antigas
                                  AND T08.T008_status   = '1'  -- somente aprovadas
                                ORDER BY T08.T008_nf_dt_vencto
                                ;
                                ");

        }
        //  APS Paradas para os Gestores aprovarem
        if ($tipo==6)
        {

            return $this->query("
                                    SELECT DISTINCT
                                           T08.T008_codigo             AS APCodigo
                                         , T08.T008_nf_numero          AS NFNumero
                                         , T08.T026_nf_serie           AS NFSerie
                                         , T08.T004_login              AS Login
                                         , T08.T008_nf_valor_bruto     AS ValorBruto
                                        -- , T08.T008_nf_valor_liq       AS ValorLiq
                                         , date_format(T08.T008_nf_dt_vencto,'%d/%m/%Y') AS DtVencimento
                                         , T26.T026_codigo             AS FornCodigo
                                         , T26.T026_rms_cgc_cpf        AS FornCNPJ
                                         , T26.T026_rms_razao_social   AS FornRazaoSocial
                                         , T08.T006_codigo             AS CodigoLoja
                                         , T06.T006_nome               AS NomeLoja
                                      FROM (
                                              -- retorna as APs que ja foram aprovadas e que existe e etapa 1
                                              SELECT T008_codigo ap, max(T008_T060_ordem) ordem
                                                FROM T008_T060 T
                                                WHERE T008_T060_ordem        IS NOT NULL
                                                  AND T060_codigo            = 3 -- etapa do Conferente de Impostos
                                                -- AND T008_T060_status       = '1'
                                                -- AND T008_T060_dt_aprovacao IS NOT NULL
                                                GROUP BY  T008_codigo
                                            ) SE1
                                      JOIN T008_T060 T0860A ON (    T0860A.T008_codigo     = SE1.ap
                                                                AND T0860A.T008_T060_ordem = SE1.ordem - 1 -- etapa anterior ao Conferente
                                                               )
                                      JOIN T008_T060 T0860B ON (    T0860B.T008_codigo     = SE1.ap
                                                                AND T0860B.T008_T060_ordem = SE1.ordem - 2 -- etapa anterior ao Gestor
                                                               )
                                       -- detalhes da AP
                                       JOIN T008_approval T08    ON ( T08.T008_codigo  =  T0860A.T008_codigo )
                                       -- detalhes do fornecedor
                                       JOIN T026_fornecedor T26  ON ( T26.T026_codigo  =  T08.T026_codigo     )
                                       -- detalhes da loja
                                       JOIN T006_loja T06        ON ( T06.T006_codigo  =  T08.T006_codigo     )
                                    WHERE T0860A.T008_T060_dt_aprovacao IS NULL     -- qdo o gestor ainda nao aprovou
                                      AND T0860B.T008_T060_dt_aprovacao IS NOT NULL -- qdo está parada para o gestor
                                      AND T08.T059_codigo IS NOT NULL -- retira APs antigas
                                      AND T08.T008_status   = '1'  -- somente aprovadas
                                    ORDER BY T08.T008_nf_dt_vencto
                                    ;
                                ");

        }
        //  APS Paradas em qualquer status anteriores ao Gestor
        if ($tipo==7)
        {

            return $this->query("
                                -- APS Paradas em qualquer status anteriores ao Gestor
                                SELECT DISTINCT
                                       T08.T008_codigo             AS APCodigo
                                     , T08.T008_nf_numero          AS NFNumero
                                     , T08.T026_nf_serie           AS NFSerie
                                     , T08.T004_login              AS Login
                                     , T08.T008_nf_valor_bruto     AS ValorBruto
                                        -- , T08.T008_nf_valor_liq       AS ValorLiq
                                     , date_format(T08.T008_nf_dt_vencto,'%d/%m/%Y') AS DtVencimento
                                     , T26.T026_codigo             AS FornCodigo
                                     , T26.T026_rms_cgc_cpf        AS FornCNPJ
                                     , T26.T026_rms_razao_social   AS FornRazaoSocial
                                     , T08.T006_codigo             AS CodigoLoja
                                     , T06.T006_nome               AS NomeLoja
                                  FROM (
                                          -- retorna as APs que ja foram aprovadas e que existe e etapa 1
                                          SELECT T008_codigo ap, max(T008_T060_ordem) ordem
                                            FROM T008_T060 T
                                            WHERE T008_T060_ordem        IS NOT NULL
                                              AND T060_codigo            = 3 -- etapa do Conferente de Impostos'
                                            -- AND T008_T060_status       = '1'
                                            -- AND T008_T060_dt_aprovacao IS NOT NULL
                                            GROUP BY  T008_codigo
                                        ) SE1
                                  JOIN T008_T060 T0860A ON (    T0860A.T008_codigo     = SE1.ap
                                                            AND T0860A.T008_T060_ordem < (SE1.ordem - 2) -- qualquer etapa anterior ao Gestor
                                                           )
                                   -- detalhes da AP
                                   JOIN T008_approval T08    ON ( T08.T008_codigo  =  T0860A.T008_codigo )
                                   -- detalhes do fornecedor
                                   JOIN T026_fornecedor T26  ON ( T26.T026_codigo  =  T08.T026_codigo     )
                                   -- detalhes da loja
                                   JOIN T006_loja T06        ON ( T06.T006_codigo  =  T08.T006_codigo     )
                                WHERE T0860A.T008_T060_dt_aprovacao IS NULL   -- qdo ainda nao houve alguma provacao até o gestor
                                  AND T08.T059_codigo IS NOT NULL -- retira APs antigas
                                  AND T08.T008_status   = '1'  -- somente aprovadas
                                ORDER BY T08.T008_nf_dt_vencto
                                ;                                ");

        }
        //  APS Paradas em digitação
        if ($tipo==8)
        {

            return $this->query("
                                SELECT DISTINCT
                                       T08.T008_codigo             AS APCodigo
                                     , T08.T008_nf_numero          AS NFNumero
                                     , T08.T026_nf_serie           AS NFSerie
                                     , T08.T004_login              AS Login
                                     , T08.T008_nf_valor_bruto     AS ValorBruto
                                        -- , T08.T008_nf_valor_liq       AS ValorLiq
                                     , date_format(T08.T008_nf_dt_vencto,'%d/%m/%Y') AS DtVencimento
                                     , T26.T026_codigo             AS FornCodigo
                                     , T26.T026_rms_cgc_cpf        AS FornCNPJ
                                     , T26.T026_rms_razao_social   AS FornRazaoSocial
                                     , T08.T006_codigo             AS CodigoLoja
                                     , T06.T006_nome               AS NomeLoja
                                  FROM T008_approval T08
                                   -- detalhes do fornecedor
                                   JOIN T026_fornecedor T26  ON ( T26.T026_codigo  =  T08.T026_codigo 
                                   )
                                   -- detalhes da loja
                                   JOIN T006_loja T06        ON ( T06.T006_codigo  =  T08.T006_codigo     )

                                WHERE T08.T059_codigo IS NOT NULL -- retira APs antigas
                                  AND T08.T008_status   = '0'  -- somente nunca aprovadas
                                ORDER BY T08.T008_nf_dt_vencto
                                ; ");

        }

        //APs Finalizadas
        if ($tipo==9)
        {

            return $this->query("
                                SELECT DISTINCT
                                       T08.T008_codigo             AS APCodigo
                                     , T08.T008_nf_numero          AS NFNumero
                                     , T08.T026_nf_serie           AS NFSerie
                                     , T08.T004_login              AS Login
                                     , T08.T008_nf_valor_bruto     AS ValorBruto
                                        -- , T08.T008_nf_valor_liq       AS ValorLiq
                                     , date_format(T08.T008_nf_dt_vencto,'%d/%m/%Y') AS DtVencimento
                                     , T26.T026_codigo             AS FornCodigo
                                     , T26.T026_rms_cgc_cpf        AS FornCNPJ
                                     , T26.T026_rms_razao_social   AS FornRazaoSocial
                                     -- , T08.T006_codigo             AS CodigoLoja
                                     -- , T06.T006_nome               AS NomeLoja
                                  FROM T008_approval T08
                                   -- detalhes do fornecedor
                                   JOIN T026_fornecedor T26  ON ( T26.T026_codigo  =  T08.T026_codigo     )
                                   -- detalhes da loja
                                   -- JOIN T006_loja T06        ON ( T06.T006_codigo  =  T08.T006_codigo
                                WHERE T08.T059_codigo IS NOT NULL -- retira APs antigas
                                  AND T08.T008_status   = '9'  -- APs que foram finalizadas
                                ORDER BY T08.T008_nf_dt_vencto
                                ; ");

        }

        //APs Canceladas
        if ($tipo==10)
        {

            return $this->query("
                                SELECT DISTINCT
                                       T08.T008_codigo             AS APCodigo
                                     , T08.T008_nf_numero          AS NFNumero
                                     , T08.T026_nf_serie           AS NFSerie
                                     , T08.T004_login              AS Login
                                     , T08.T008_nf_valor_bruto     AS ValorBruto
                                        -- , T08.T008_nf_valor_liq       AS ValorLiq
                                     , date_format(T08.T008_nf_dt_vencto,'%d/%m/%Y') AS DtVencimento
                                     , T26.T026_codigo             AS FornCodigo
                                     , T26.T026_rms_cgc_cpf        AS FornCNPJ
                                     , T26.T026_rms_razao_social   AS FornRazaoSocial
                                     -- , T08.T006_codigo             AS CodigoLoja
                                     -- , T06.T006_nome               AS NomeLoja
                                  FROM T008_approval T08
                                   -- detalhes do fornecedor
                                   JOIN T026_fornecedor T26  ON ( T26.T026_codigo  =  T08.T026_codigo     )
                                   -- detalhes da loja
                                   -- JOIN T006_loja T06        ON ( T06.T006_codigo  =  T08.T006_codigo
                                WHERE T08.T059_codigo IS NOT NULL -- retira APs antigas
                                  AND T08.T008_status   = '4'  -- APs que foram canceladas
                                ORDER BY T08.T008_nf_dt_vencto
                                ; ");

        }

    }

    public function inserirFluxoAp($codAp, $codEtapa, $ordem)
    {   $tabela = "T008_T060";
        $user   = $_SESSION['user'];
        if(!is_null($codEtapa))
        {
            $Etapas = $this->retornaProximaEtapa($codEtapa);

            foreach($Etapas as $campos=>$valores)
            {
                $array = array ( "T060_codigo"=>$valores['EtapaCodigo']
                               , "T008_codigo"=>$codAp
                               , "T008_T060_ordem"=>$ordem
                               , "T008_T060_status"=>0
                               , "T004_login"=>$user);
                $this->inserir($tabela, $array);
                $this->inserirFluxoAp($codAp, $valores['ProxCodigoEtapa'], $ordem+1);
            }
        }
        return true;
    }
 
    //FUNÇAO TEMPORÁRIA
    public function TemporariaInclusaoFluxoAP($cod)
    {
        return $this->query("SELECT T08.T008_codigo    CodigoAP
                                  , T08.T059_codigo    CodigoGP
                                  , T08.T004_login     Login
                               FROM T008_approval T08
                             --  LEFT JOIN T008_T060 T0860 ON ( T08.T008_codigo = T0860.T008_codigo )
                             WHERE T08.T008_codigo in ($cod)");
    }

    public function TemporariaInserirFluxoAp($codAp, $codEtapa, $ordem, $user)
    {   $tabela = "T008_T060";
        if(!is_null($codEtapa))
        {
            $Etapas = $this->retornaProximaEtapa($codEtapa);

            foreach($Etapas as $campos=>$valores)
            {
                $array = array ( "T060_codigo"=>$valores['EtapaCodigo']
                               , "T008_codigo"=>$codAp
                               , "T008_T060_ordem"=>$ordem
                               , "T008_T060_status"=>0
                               , "T004_login"=>$user);
                $this->inserir($tabela, $array);
                $this->TemporariaInserirFluxoAp($codAp, $valores['ProxCodigoEtapa'], $ordem+1 , $user);
            }
        }
        return true;
    }

    public function excluir($tabela, $delim)
    {
        return $this->exec($this->exclui($tabela, $delim));
    }

    //FUNÇAO BUSCA AP
    public function BuscaFluxo($cod)
    {
        $sql = "SELECT T0860.T008_T060_ordem                                 Ordem
                     , T0860.T008_T060_status                                Status
                     , T60.T059_codigo                                       Codigo59
                     , date_format(T0860.T008_T060_dt_aprovacao, '%d/%m/%Y') DtAprovacao
                     , T0860.T004_login                                      Login
                  FROM T008_T060 AS T0860
                  JOIN T060_workflow AS T60
                    ON (T0860.T060_codigo = T60.T060_codigo)
                 WHERE T008_codigo = $cod
                 ORDER BY 1";
        
        return $this->query($sql);
    }

    public function BuscaGruposNomes($cod)
    {
        return $this->query(" SELECT T059_codigo Codigo
                                   , T059_nome   Nome
                                FROM T059_grupo_workflow
                               WHERE T059_codigo = $cod");
    }

    public function BuscaUsuarioGrupo($cod)
    {
        return $this->query("SELECT T04.T004_login Login
                                  , T04.T004_nome  Nome
                               FROM T004_T059 as T0459
                               JOIN T004_usuario as T04
                                 ON (T04.T004_login = T0459.T004_login)
                              WHERE T0459.T059_codigo = $cod");
    }

    public function BuscaAP($cod)
    {
        return $this->query(" SELECT T08.T008_codigo            CodigoAP
                                   , T08.T004_login             Login
                                   , T04.T004_nome              Nome
                                   , T26.T026_rms_codigo        CodigoFor
                                   , T26.T026_rms_digito        DigitoFor
                                   , T26.T026_rms_razao_social  RazaoSocial
                                FROM T008_approval AS T08
                                JOIN T004_usuario AS T04
                                  ON (T04.T004_login = T08.T004_login)
                                JOIN T026_fornecedor AS T26
                                  ON (T26.T026_codigo = T08.T026_codigo)
                               WHERE T08.T008_codigo = $cod");
    }

    public function RetornaQtdeGrupos()
    {
       return $this->query("SELECT SE1.Grupo																	Grupo
                                 , SE1.Nome																	Nome
                                      , SE1.Qtde	 																Qtde
                                      , IF (T60.T059_codigo IS NULL,'999',	T60.T059_codigo)	  		ProxGrupo
                                 , IF ( T59.T059_nome IS NULL,'Finalizada',	 T59.T059_nome)	ProxNome
                              FROM (
                                                            SELECT count(*) 						Qtde
                                                                 , T59.T059_codigo				Grupo
                                                                 , T59.T059_nome					Nome
                                                                 , T60.T060_proxima_etapa		ProxEtapa
                                                       FROM T060_workflow T60
                                                       JOIN T008_T060 T0860A ON (T0860A.T060_codigo = T60.T060_codigo)
                                             LEFT JOIN T008_T060 T0860B ON (T0860B.T008_codigo = T0860A.T008_codigo
                                                                             AND T0860B.T008_T060_ordem = T0860A.T008_T060_ordem-1)
                                                       JOIN T059_grupo_workflow T59 ON (T59.T059_codigo = T60.T059_codigo)
                                            JOIN  T008_approval T08      ON (T08.T008_codigo = T0860A.T008_codigo)
                                                      WHERE T0860A.T008_T060_ordem IS NOT NULL
                                                        AND T0860A.T008_T060_dt_aprovacao IS NULL
                                                        AND (T0860B.T008_T060_dt_aprovacao IS NOT NULL
                                                             OR T0860B.T008_codigo	IS NULL
                                                            )
                                                             AND T08.T059_codigo IS NOT NULL -- retira APs antigas
                                                             AND T08.T008_status in (0,1) -- somente digitas e aprovadas
                                                        GROUP BY T60.T060_proxima_etapa, T59.T059_codigo
                                         ) SE1
                               LEFT JOIN  T060_workflow T60 ON (T60.T060_codigo = SE1.ProxEtapa)
                               LEFT JOIN  T059_grupo_workflow T59 ON (T59.T059_codigo = T60.T059_codigo)

                               ORDER BY SE1.Qtde DESC");
    }

    public function RetornaResumo($cod)
    {
       return $this->query("SELECT T08.T008_codigo             AS APCodigo
                                 , T08.T008_nf_numero          AS NFNumero
                                 , T08.T026_nf_serie           AS NFSerie
                                 , T08.T004_login              AS Login
                                 , T08.T008_nf_valor_bruto     AS ValorBruto
                                -- , T08.T008_nf_valor_liq       AS ValorLiq
                                 , date_format(T08.T008_nf_dt_vencto,'%d/%m/%Y') AS DtVencimento
                                 , T26.T026_codigo             AS FornCodigo
                                 , T26.T026_rms_cgc_cpf        AS FornCNPJ
                                 , T26.T026_rms_razao_social   AS FornRazaoSocial
                              FROM T008_T060 T0860
                              JOIN T008_approval T08    ON ( T08.T008_codigo  =  T0860.T008_codigo )
                              JOIN T026_fornecedor T26  ON ( T26.T026_codigo  =  T08.T026_codigo     )
                             WHERE T0860.T060_codigo = $cod
                               AND T0860.T008_T060_status = 0
                            ");
    }

    
    public function RetornaDetalhesFornecedor($FornCodigo)
    {
       return $this->query("SELECT T26.T026_rms_razao_social RazaoSocial
                             , T26.T026_rms_cgc_cpf      CNPJ
                             , T26.T026_rms_codigo       RMSCodigo
                             , T26.T026_rms_digito       RMSDigito
                             , T26.T026_rms_insc_est_ident  IE
                             , T26.T026_rms_insc_mun        IM
                          FROM T026_fornecedor T26
                         WHERE T26.T026_codigo  = $FornCodigo
                            ");
    }

    public function RetornaParametroQtdeMaxAps()
    // Funcao para retornar valor do parametro para apresentar quantidade maxima na tela de Ultimas APs do fornecedor
    {
       return $this->query("   SELECT T03.T003_valor  ParametroValor
                                 FROM T003_parametro T03
                                WHERE T03.T003_nome  = 'qtde_ultimas_aps' 
                           ");
    }        
 
}
?>

<?php
/* -------- Controle de versões - models/T0016.php --------------
 * 1.0.0 - 14/04/2011 --> Liberada versao sem controle de versionamento
 * 1.0.1 - 13/09/2011 - Alexandre --> Alteradas Funções retornaApsPendentesAprovacao, retornaApsDigitadas, retornaApsAnteriores, retornaApsPosteriores
 *                                    retornaApsCanceladas , retornaApsFinalizadas, para que sejam utilizados Filtros e Limites          
 * 1.0.2 - 14/09/2011 - Alexandre --> Inclusas funções retornaUltimasApsFornecedor , RetornaParametroQtdeMaxAps
 * 
*/
?>
