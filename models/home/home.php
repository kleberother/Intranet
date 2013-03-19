<?php

/**************************************************************************/
/*                          DAVÓ SUPERMERCADOS                            */
/* Criado em: 21/03/2011 por Rodrigo Alfieri                              */
/* Descrição: Classe para executar as Querys do Programa T00              */
/**************************************************************************/

class models_home extends models
{
   
    public function __construct()
    {
        $conn = "";
        parent::__construct($conn);        
    }

    public function atalhosGlobais()
    {
        $conn = "";
        //parent::__construct($conn);
        return $this->query("SELECT T044_codigo     Codigo
                                  , T044_titulo     Titulo
                                  , T044_url        URL
                                  , T044_caminho    Caminho
                                  , T044_global	AtalhosSistemas
                               FROM T044_atalhos
                              WHERE T044_global = '1'");//->fetchAll(PDO::FETCH_ASSOC);
    }

    public function atalhosPessoais()
    {
        $conn = "";
        //parent::__construct($conn);
        return $this->query("SELECT T044_titulo     TITULO
                                  , T044_url        URL
                                  , T044_caminho    CAMINHO
                               FROM T044_atalhos
                              WHERE T004_login = '".$_SESSION['user']."'");//->fetchAll(PDO::FETCH_ASSOC);
    }

    public function selecionaBanners()
    {
        $conn = "";
        //parent::__construct($conn);
        return $this->query("SELECT T1.T047_codigo
                                  , T1.T047_titulo      TITULO
                                  , T1.T047_caminho     CAMINHO
                               FROM T047_banners T1
                              WHERE T1.T047_codigo = (SELECT max(T047_codigo)
                                                        FROM T047_banners T2)")->fetchAll(PDO::FETCH_ASSOC);
        
    }

    public function selecionaNoticia()
    {
        $conn = "";
        //parent::__construct($conn);
        return $this->query("SELECT T046_codigo  COD
                                  , T046_titulo  TITULO
                                  , T046_chamada CHAMADA
                                  , T046_texto   TEXTO
                               FROM T046_artigos T1
                              WHERE T1.T045_codigo = 1
                           ORDER BY COD DESC LIMIT 1");
    }

    public function selecionaNoticiaPorID($cod)
    {
        $conn = "";
        //parent::__construct($conn);
        return $this->query("SELECT T046_codigo  COD
                                  , T046_titulo  TITULO
                                  , T046_chamada CHAMADA
                                  , T046_texto   TEXTO
                               FROM T046_artigos T1
                              WHERE T1.T045_codigo = 1
                                AND T1.T046_codigo = $cod");
    }
    
    public function selecionaUltimaNoticia()
    {
        $conn = "";
        //parent::__construct($conn);
        return $this->query("SELECT T046_codigo  COD
                                  , T046_titulo  TITULO
                                  , T046_chamada CHAMADA
                                  , T046_texto   TEXTO
                               FROM T046_artigos T1
                              WHERE T1.T045_codigo = 1
                           ORDER BY COD DESC");
    }
    
    public function seleciona_ora()
    {

        $conn = "ora";
        parent::__construct($conn);
        $sql="select TIP_CGC_CPF            CNPJ
                   , TIP_INSC_EST_IDENT     IE
                   , TIP_INSC_MUN           IM
                   , TIP_CODIGO             COD
                   , TIP_DIGITO             DIG
                   , TIP_RAZAO_SOCIAL       RAZ
                FROM rms.aa2ctipo
               WHERE TIP_CGC_CPF = '52130481000234'
                 and ROWNUM < 2";

        $stid = oci_parse($conn_ora, $sql);
        oci_execute($stid);
        return $row_ora = oci_fetch_assoc($stid);
//        $conn = "ora";
//        $ora = parent::__construct($conn);
//        $sql = "SELECT * FROM RMS.AA2CTIPO";
//        $this->OCIParse($ora, $sql);
//
//                if(OCIExecute($this))
//                {
//                   return $this;
//                }
//                else
//                {
//                   exit("<p>Erro Oracle: " . OCIError() . "</p>");
//                }
     }

     public function string_data($data)
     {
        $sem = $data = date('D');
        $mes = $data = date('M');
        $dia = $data = date('d');
        $ano = $data = date('Y');

        $semana = array(
                            "Sun" => "Domingo"
                          , "Mon" => "Segunda-Feira"
                          , "Tue" => "Terca-Feira"
                          , "Wed" => "Quarta-Feira"
                          , "Thu" => "Quinta-Feira"
                          , "Fri" => "Sexta-Feira"
                          , "Sat" => "Sábado"
                        );

        $mess   = array(
                            "Jan" => "Janeiro"
                          , "Feb" => "Fevereiro"
                          , "Mar" => "Marco"
                          , "Apr" => "Abril"
                          , "May" => "Maio"
                          , "Jun" => "Junho"
                          , "Jul" => "Julho"
                          , "Aug" => "Agosto"
                          , "Nov" => "Novembro"
                          , "Sep" => "Setembro"
                          , "Oct" => "Outubro"
                          , "Dec" => "Dezembro"
                        );
        $string_data = $semana["$sem"].", ".$dia." de ".$mess["$mes"]." de ".$ano;
        return $string_data;
     }
     
    public function retornaLojas()   
    { 
       return $this->query("SELECT L.T006_codigo AS LCODI
                                 , L.T006_nome   AS LNOME
                              FROM T006_loja     AS L");
    }     
    
    public function retornaUsuario($user)
    {

        $sql    =   "   SELECT T04.T004_login               UsuarioLogin
                             , T04.T004_nome                UsuarioNome
                             , T04.T004_funcao              UsuarioFuncao
                             , T04.T004_data_ult_alteracao  UsuarioDataUltAlteracao
                             , T04.T004_matricula           UsuarioMatricula
                             , T04.T006_codigo              UsuarioLoja
                          FROM T004_usuario T04 WHERE T04.T004_login = '$user'";
        
        return $this->query($sql);
        
    }
    
    public function alterar($tabela,$campos,$delim)
    {
       $conn = "";
       $altera = $this->exec($this->atualiza($tabela, $campos, $delim));

       if($altera)
            $this->alerts('false', 'Alerta!', 'Alterado com Sucesso!');
       else
            $this->alerts('true', 'Erro!', 'Não foi possível Alterar!');   

	return $altera;
    }
    
    public function retornaQtdApPendente($user)
    {
        $sql    =   " SELECT count(*) Qtde
                        FROM (  SELECT DISTINCT T08.T008_codigo                       AS APCodigo
                                    , T08.T008_nf_numero                             AS NFNumero
                                    , T08.T026_nf_serie                              AS NFSerie
                                    , T08.T004_login                                 AS Login
                                    , T08.T008_tp_nota                               AS TpNota
                                    , T08.T008_nf_valor_bruto                        AS ValorBruto
                                    , date_format(T08.T008_nf_dt_vencto,'%d/%m/%Y')  AS DtVencimento
                                    , T26.T026_codigo                                AS FornCodigo
                                    , T26.T026_rms_cgc_cpf                           AS FornCNPJ
                                    , T26.T026_rms_razao_social                      AS FornRazaoSocial
                                    , T60.T060_codigo                                AS CodigoEtapa
                                    , T60.T059_codigo                                AS CodigoGrupo
                                    , T08.T008_T026T059_T006_codigo                  AS CodigoLoja
                                    , T06.T006_nome                                  AS NomeLoja
                                    FROM T008_T060 T0860
                                    JOIN ( 
                                            SELECT T008_codigo ap, min(T008_T060_ordem) ordem
                                            FROM T008_T060 T
                                            WHERE T008_T060_dt_aprovacao IS NULL
                                            AND T008_T060_status       = '0'
                                        GROUP BY T008_codigo
                                        ) SE1 ON (      SE1.ap    = T0860.T008_codigo
                                                    AND SE1.ordem = T0860.T008_T060_ordem
                                                    )
                                    JOIN T004_T059 T0459      ON ( T0459.T004_login = '$user'                      )
                                    JOIN T060_workflow T60    ON ( T60.T059_codigo  =  T0459.T059_codigo            )
                                    JOIN T008_approval T08    ON ( T08.T008_codigo  =  T0860.T008_codigo            )
                                    JOIN T026_fornecedor T26  ON ( T26.T026_codigo  =  T08.T026_codigo              )
                                    JOIN T006_loja T06        ON (T06.T006_codigo   =  T08.T008_T026T059_T006_codigo)
                                WHERE T0860.T060_codigo  = T60.T060_codigo
                                    AND T08.T008_status in ('0','1')
                                    AND T08.T008_T026T059_T059_codigo IS NOT NULL) SE3 ";
        
        return $this->query($sql);
    }
    
    public function retornaQtdApAnteriores($user)
    {
        $sql    =   " SELECT count(*) Qtde
                        FROM (SELECT DISTINCT T08.T008_codigo             AS APCodigo
                                            , T08.T008_nf_numero          AS NFNumero
                                            , T08.T026_nf_serie           AS NFSerie
                                            , T08.T004_login              AS Login
                                            , T08.T008_nf_valor_bruto     AS ValorBruto
                                            , T08.T008_tp_nota            AS TpNota
                                            , date_format(T08.T008_nf_dt_vencto,'%d/%m/%Y') AS DtVencimento
                                            , T26.T026_codigo                  AS FornCodigo
                                            , T26.T026_rms_cgc_cpf             AS FornCNPJ
                                            , T26.T026_rms_razao_social        AS FornRazaoSocial
                                            , T08.T008_T026T059_T006_codigo    AS CodigoLoja
                                            , T06.T006_nome               AS NomeLoja
                                        FROM (  SELECT T0860.T008_codigo AP , max(T0860.T008_T060_ordem) ordem
                                                    FROM T008_T060 T0860
                                                    JOIN ( 
                                                            SELECT T008_codigo ap, max(T008_T060_ordem) ordem
                                                            FROM T008_T060 T
                                                            WHERE T008_T060_ordem        IS NOT NULL
                                                            AND T008_T060_dt_aprovacao IS NULL 
                                                        GROUP BY T008_codigo
                                                        ) SE1 ON ( SE1.ap  = T0860.T008_codigo )
                                                    JOIN T004_T059 T0459      ON ( T0459.T004_login = '$user' )
                                                    JOIN T060_workflow T60    ON ( T60.T059_codigo  =  T0459.T059_codigo )
                                                    WHERE T0860.T060_codigo  = T60.T060_codigo
                                                    AND T0860.T008_T060_dt_aprovacao IS NULL 
                                                GROUP BY T0860.T008_codigo) SE2
                                        JOIN T008_T060 T0860_2   ON ( T0860_2.T008_codigo  =  SE2.AP AND T0860_2.T008_T060_ordem < SE2.ordem )
                                        JOIN T008_approval T08   ON ( T08.T008_codigo      =  T0860_2.T008_codigo                            )
                                        JOIN T026_fornecedor T26 ON ( T26.T026_codigo      =  T08.T026_codigo                                )
                                        JOIN T006_loja T06       ON ( T06.T006_codigo      =  T08.T008_T026T059_T006_codigo                  )
                                        WHERE T08.T008_T026T059_T059_codigo IS NOT NULL 
                                            AND T08.T008_status   in ( '0','1' ) 
                                            AND T0860_2.T008_T060_dt_aprovacao IS NULL) SE3";
        
        return $this->query($sql);
    }
    
    public function retornaQtdDespesaPendente($user)
    {
        $sql    =   " SELECT count(*) Qtde
                        FROM (SELECT DISTINCT T16.T016_codigo                                   AS DespesaCodigo
                                            , T16.T004_login                                    AS Login
                                            , date_format(T16.T016_dt_elaboracao,'%d/%m/%Y')    AS DespesaData
                                            , T60.T060_codigo                                   AS CodigoEtapa
                                            , T16.T016_vl_total_geral                           AS DespesaValor
                                            , T60.T059_codigo                                   AS CodigoGrupo
                                        FROM T016_T060 T1660
                                        JOIN ( 
                                                    SELECT T016_codigo despesa, min(T016_T060_ordem) ordem
                                                    FROM T016_T060 T
                                                    WHERE T016_T060_dt_aprovacao IS NULL
                                                    AND T016_T060_status       = '0'
                                                GROUP BY T016_codigo
                                                ) SE1 ON (      SE1.despesa = T1660.T016_codigo
                                                            AND SE1.ordem   = T1660.T016_T060_ordem
                                                        )
                                        JOIN T004_T059 T0459   ON ( T0459.T004_login = '$user' )
                                        JOIN T060_workflow T60 ON ( T60.T059_codigo  =  T0459.T059_codigo )
                                        JOIN T016_despesa T16  ON ( T16.T016_codigo  =  T1660.T016_codigo )
                                        WHERE T1660.T060_codigo = T60.T060_codigo) SE3";
        
        return $this->query($sql);
    }
    
    public function retornaQtdDespesasAnteriores($user)
    {
        $sql    =   " SELECT COUNT(*) Qtde
                        FROM (SELECT DISTINCT  T16.T016_codigo                                   AS DespesaCodigo
                                                , T16.T004_login                                    AS Login
                                                , date_format(T16.T016_dt_elaboracao,'%d/%m/%Y')    AS DespesaData
                                                , T16.T016_vl_total_geral                           AS DespesaValor
                                            FROM (    SELECT T1660.T016_codigo DESPESA , max(T1660.T016_T060_ordem) ordem
                                                        FROM T016_T060 T1660
                                                        JOIN ( 
                                                                SELECT T016_codigo despesa, max(T016_T060_ordem) ordem
                                                                FROM T016_T060 T
                                                                WHERE T016_T060_ordem        IS NOT NULL
                                                                AND T016_T060_dt_aprovacao IS NULL
                                                            GROUP BY  T016_codigo
                                                            ) SE1 ON ( SE1.despesa  = T1660.T016_codigo )
                                                        JOIN T004_T059 T0459      ON ( T0459.T004_login = '$user' )
                                                        JOIN T060_workflow T60    ON ( T60.T059_codigo  =  T0459.T059_codigo )
                                                    WHERE T1660.T060_codigo  = T60.T060_codigo
                                                        AND T1660.T016_T060_dt_aprovacao IS NULL
                                                    GROUP BY T1660.T016_codigo
                                                ) SE2
                                            JOIN T016_T060 T1660_2 ON (     T1660_2.T016_codigo     = SE2.DESPESA
                                                                        AND T1660_2.T016_T060_ordem < SE2.ordem 
                                                                    )
                                            JOIN T016_despesa T16    ON ( T16.T016_codigo  =  T1660_2.T016_codigo )
                                            AND T16.T016_status   in ( '0','1' )
                                            AND T1660_2.T016_T060_dt_aprovacao IS NULL ) SE3";
        
        return $this->query($sql);
    }
    
    public function retornaQtdApsForaPrazo($user)
    {
        $sql    =   "SELECT COUNT(*) Qtde
                       FROM (  SELECT SE2.APCodigo
                                    , SE2.ExpiradoDias 
                                FROM (SELECT DISTINCT T08.T008_codigo                               AS APCodigo
                                                    , T08.T008_nf_numero                            AS NFNumero
                                                    , T08.T026_nf_serie                             AS NFSerie
                                                    , T08.T004_login                                AS Login
                                                    , T08.T008_tp_nota                              AS TpNota
                                                    , T08.T008_nf_valor_bruto                       AS ValorBruto
                                                    -- , T08.T008_nf_valor_liq                      AS ValorLiq
                                                    , date_format(T08.T008_nf_dt_vencto,'%d/%m/%Y') AS DtVencimento
                                                    , T26.T026_codigo                               AS FornCodigo
                                                    , T26.T026_rms_cgc_cpf                          AS FornCNPJ
                                                    , T26.T026_rms_razao_social                     AS FornRazaoSocial
                                                    , T60.T060_codigo                               AS CodigoEtapa
                                                    , T60.T059_codigo                               AS CodigoGrupo
                                                    , T08.T008_T026T059_T006_codigo                 AS CodigoLoja
                                                    , T06.T006_nome                                 AS NomeLoja
                                                    , fnDV_QtDiasAp(T08.T008_codigo)                AS ExpiradoDias
                                                    , T60.T060_num_dias                             AS Dias
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
                                                JOIN T006_loja T06        ON (T06.T006_codigo   =  T08.T008_T026T059_T006_codigo   )
                                                WHERE T0860.T060_codigo  = T60.T060_codigo
                                                AND T08.T008_status in ('0','1')
                                                AND T08.T008_T026T059_T059_codigo IS NOT NULL /*retira APs antigas */)SE2
                                WHERE SE2.ExpiradoDias >= SE2.Dias
                                UNION
                                SELECT SE3.APCodigo
                                    , SE3.ExpiradoDias 
                                FROM (
                                        SELECT DISTINCT T08.T008_codigo                               AS APCodigo
                                                        , T08.T008_nf_numero                            AS NFNumero
                                                        , T08.T026_nf_serie                             AS NFSerie
                                                        , T08.T004_login                                AS Login
                                                        , T08.T008_nf_valor_bruto                       AS ValorBruto
                                                        , T08.T008_tp_nota                              AS TpNota
                                                    -- , T08.T008_nf_valor_liq                        AS ValorLiq
                                                        , date_format(T08.T008_nf_dt_vencto,'%d/%m/%Y') AS DtVencimento
                                                    -- , T08.T008_nf_valor_liq                        AS ValorLiq
                                                        , T26.T026_codigo                               AS FornCodigo
                                                        , T26.T026_rms_cgc_cpf                          AS FornCNPJ
                                                        , T26.T026_rms_razao_social                     AS FornRazaoSocial
                                                        , T08.T008_T026T059_T006_codigo                 AS CodigoLoja
                                                        , T06.T006_nome                                 AS NomeLoja
                                                        , fnDV_QtDiasAp(T08.T008_codigo)                AS ExpiradoDias 
                                                        , SE2.Dias                                      AS Dias
                                                    FROM (  SELECT T0860.T008_codigo          AP 
                                                                , max(T0860.T008_T060_ordem) ordem
                                                                , T60.T060_num_dias          Dias
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
                                                    JOIN T006_loja T06        ON ( T06.T006_codigo  =  T08.T008_T026T059_T006_codigo     )
                                                    WHERE T08.T008_T026T059_T059_codigo IS NOT NULL -- retira APs antigas
                                                    AND T08.T008_status   in ( '0','1' ) -- novas ou ja aprovadas
                                                    AND T0860_2.T008_T060_dt_aprovacao IS NULL  /*somente nao aprovadas*/)SE3
                                WHERE SE3.ExpiradoDias >= SE3.Dias)SE5";
        
        return $this->query($sql);
    }
    
    public function retornaQtdApsDentroPrazo($user)
    {
        $sql    =   "SELECT COUNT(*) Qtde
                       FROM (  SELECT SE2.APCodigo
                                    , SE2.ExpiradoDias 
                                FROM (SELECT DISTINCT T08.T008_codigo                               AS APCodigo
                                                    , T08.T008_nf_numero                            AS NFNumero
                                                    , T08.T026_nf_serie                             AS NFSerie
                                                    , T08.T004_login                                AS Login
                                                    , T08.T008_tp_nota                              AS TpNota
                                                    , T08.T008_nf_valor_bruto                       AS ValorBruto
                                                    -- , T08.T008_nf_valor_liq                      AS ValorLiq
                                                    , date_format(T08.T008_nf_dt_vencto,'%d/%m/%Y') AS DtVencimento
                                                    , T26.T026_codigo                               AS FornCodigo
                                                    , T26.T026_rms_cgc_cpf                          AS FornCNPJ
                                                    , T26.T026_rms_razao_social                     AS FornRazaoSocial
                                                    , T60.T060_codigo                               AS CodigoEtapa
                                                    , T60.T059_codigo                               AS CodigoGrupo
                                                    , T08.T008_T026T059_T006_codigo                 AS CodigoLoja
                                                    , T06.T006_nome                                 AS NomeLoja
                                                    , fnDV_QtDiasAp(T08.T008_codigo)                AS ExpiradoDias
                                                    , T60.T060_num_dias                             AS Dias
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
                                                JOIN T006_loja T06        ON (T06.T006_codigo   =  T08.T008_T026T059_T006_codigo   )
                                                WHERE T0860.T060_codigo  = T60.T060_codigo
                                                AND T08.T008_status in ('0','1')
                                                AND T08.T008_T026T059_T059_codigo IS NOT NULL /*retira APs antigas */)SE2
                                WHERE SE2.ExpiradoDias < SE2.Dias
                                UNION
                                SELECT SE3.APCodigo
                                    , SE3.ExpiradoDias 
                                FROM (
                                        SELECT DISTINCT T08.T008_codigo                               AS APCodigo
                                                        , T08.T008_nf_numero                            AS NFNumero
                                                        , T08.T026_nf_serie                             AS NFSerie
                                                        , T08.T004_login                                AS Login
                                                        , T08.T008_nf_valor_bruto                       AS ValorBruto
                                                        , T08.T008_tp_nota                              AS TpNota
                                                    -- , T08.T008_nf_valor_liq                        AS ValorLiq
                                                        , date_format(T08.T008_nf_dt_vencto,'%d/%m/%Y') AS DtVencimento
                                                    -- , T08.T008_nf_valor_liq                        AS ValorLiq
                                                        , T26.T026_codigo                               AS FornCodigo
                                                        , T26.T026_rms_cgc_cpf                          AS FornCNPJ
                                                        , T26.T026_rms_razao_social                     AS FornRazaoSocial
                                                        , T08.T008_T026T059_T006_codigo                 AS CodigoLoja
                                                        , T06.T006_nome                                 AS NomeLoja
                                                        , fnDV_QtDiasAp(T08.T008_codigo)                AS ExpiradoDias 
                                                        , SE2.Dias                                      AS Dias
                                                    FROM (  SELECT T0860.T008_codigo          AP 
                                                                , max(T0860.T008_T060_ordem) ordem
                                                                , T60.T060_num_dias          Dias
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
                                                    JOIN T006_loja T06        ON ( T06.T006_codigo  =  T08.T008_T026T059_T006_codigo     )
                                                    WHERE T08.T008_T026T059_T059_codigo IS NOT NULL -- retira APs antigas
                                                    AND T08.T008_status   in ( '0','1' ) -- novas ou ja aprovadas
                                                    AND T0860_2.T008_T060_dt_aprovacao IS NULL  /*somente nao aprovadas*/)SE3
                                WHERE SE3.ExpiradoDias < SE3.Dias)SE5";
        
        return $this->query($sql);
    }
    
    public function retornaValorParametroUsuario($codigoParametro, $user)
    {
        $sql    =   " SELECT T91.T091_valor ValorParametro
                        FROM T091_parametros_usuario T91
                       WHERE T91.T003_codigo  = $codigoParametro
                         AND T91.T004_login = '$user'";
        
        
        return $this->query($sql);
    }
    
    public function retornaValorParametro($codigoParametro)
    {
        $sql    =   "  SELECT T89.T089_valor            ValorParametro
                         FROM T089_parametro_detalhe    T89
                        WHERE T89.T003_codigo  =        $codigoParametro";
        
        return $this->query($sql);
    }
    
}
?>
