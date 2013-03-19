<?php

/**************************************************************************/
/*                          DAVÓ SUPERMERCADOS                            */
/* Criado em: 15/04/2011 por Rodrigo Alfieri  e Jorge Nova                */
/* Descrição: Classe para executar as Querys do Programa T0021            */
/**************************************************************************/

class models_T0025 extends models
{

    public function __construct($conn)
    {
        parent::__construct($conn);
    }

    public function listaT026()
    {
        return $this->query("SELECT T026_codigo            Codigo
                                  , T026_rms_codigo        RMSCodigo
                                  , T026_rms_digito        RMSDigito
                                  , T026_rms_razao_social  RazaoSocial
                                  , T026_rms_cgc_cpf       CNPJxCPF
                               FROM T026_fornecedor
                           ORDER BY RazaoSocial, Codigo");
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

    public function selecionaGrupofkw($cod)
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
    
    public function listaWF()
    {
       return $this->query("SELECT W.T059_codigo       AS COD
                                 , W.T059_nome         AS NOM
                                 , W.T061_codigo       AS C61
                              FROM T059_grupo_workflow AS W");
    }

    public function listaProcesso()
    {
       return $this->query("SELECT P.T061_codigo P0025_T061_COD
                                 , P.T061_nome   P0025_T061_NOM
                              FROM T061_processo P");
    }

    public function listaT026c($cod)
    {
       return $this->query("SELECT T026_rms_razao_social  P0025_T026_RRS
                              FROM T026_fornecedor
                             WHERE T026_codigo = $cod;");
    }

    public function listaT027($cod)
    {
       return $this->query("SELECT T027_codigo  P0025_T027_COD
                                 , T027_nome    P0025_T027_NOM
                                 , T027_email   P0025_T027_EMA
                               FROM T027_fornecedor_contato
                              WHERE T026_codigo = $cod;");
    }
    
    public function buscaT027($cod,$codcont)
    {
        return $this->query(" SELECT C.T027_codigo            P0025_T027_COD
                                   , C.T027_nome              P0025_T027_NOM
                                   , C.T027_endereco          P0025_T027_END
                                   , C.T027_end_numero        P0025_T027_NUM
                                   , C.T027_cidade            P0025_T027_CID
                                   , C.T027_uf                P0025_T027_UF
                                   , C.T027_email             P0025_T027_EMA
                                   , C.T027_obs               P0025_T027_OBS
                                FROM T027_fornecedor_contato  C
                               WHERE C.T026_codigo = $cod
                                 AND C.T027_codigo = $codcont;");
    }

    public function buscaT026($cod)
    {
        return $this->query("SELECT T026_codigo             P0025_T026_COD
                                  , T026_rms_razao_social   P0025_T026_RAZ
                                  , T026_rms_codigo         P0025_T026_CRM
                                  , T026_rms_digito         P0025_T026_DIG
                                  , T026_rms_cgc_cpf        P0025_T026_CGC
                                  , T026_rms_insc_est_ident P0025_T026_EST
                                  , T026_rms_insc_mun       P0025_T026_MUN
                                  , T026_desc               P0025_T026_DES
                               FROM T026_fornecedor
                              WHERE T026_codigo = $cod");
    }

    public function alteraT026_55($tabela,$campos,$delim)
    {
       $conn = "";
       $altera = $this->exec($this->atualiza($tabela, $campos, $delim));
       
       if($altera)
            $this->alerts('false', 'Alerta!', 'Alterado com Sucesso!');
       else
            $this->alerts('true', 'Erro!', 'Não foi possível Alterar!');         
       
    }

    public function insereT027($tabela,$campos)
    {
        $insere = $this->exec($this->insere($tabela, $campos));

       if($insere)
            $this->alerts('false', 'Alerta!', 'Incluído com Sucesso!');
       else
            $this->alerts('true', 'Erro!', 'Não foi possível Incluir!');          
    }

    public function alteraT027($tabela,$campos,$delim)
    {
       $conn = "";
       $altera = $this->exec($this->atualiza($tabela, $campos, $delim));

       if($altera)
            $this->alerts('false', 'Alerta!', 'Alterado com Sucesso!');
       else
            $this->alerts('true', 'Erro!', 'Não foi possível Alterar!');        
    }

    public function excluiT027($tabela,$delim)
    {
        $exclui = $this->exec($this->exclui($tabela, $delim));
        
       if($exclui)
            $this->alerts('false', 'Alerta!', 'Excluído com Sucesso!');
       else
            $this->alerts('true', 'Erro!', 'Não foi possível Excluir!');         
        
        return $exclui;
    }

    public function inserir($tabela,$campos)
    {
       $insere = $this->exec($this->insere($tabela, $campos));
       
       if($insere)
            $this->alerts('false', 'Alerta!', 'Incluído com Sucesso!');
       else
            $this->alerts('true', 'Erro!', 'Não foi possível Incluir!');        
       
       return $insere;

    }

    public function listarAssociados($cod)
    {
        $sql = "SELECT T1.T026_codigo         CodigoFornecedor
                     , T1.T059_codigo         CodigoGWF
                     , T3.T059_nome           NomeGWF
                     , T1.T061_codigo         CodigoProcesso
                     , T4.T061_nome           NomeProcesso
                     , T1.T006_codigo         CodigoLoja
                     , T5.T006_nome           NomeLoja
                  FROM T026_T059              T1
                    , T026_fornecedor         T2
                     , T059_grupo_workflow    T3
                     , T061_processo          T4
                     , T006_loja              T5
                 WHERE T1.T026_codigo = T2.T026_codigo
                   AND T1.T059_codigo = T3.T059_codigo
                   AND T1.T061_codigo = T4.T061_codigo
                   AND T1.T026_codigo = $cod
                   AND T4.T061_codigo = 1
                   AND T5.T006_codigo = T1.T006_codigo";
        
        return $this->query($sql);
    }

    public function listarGrpAssociados($fornecedor,$loja)
    {
        $sql = "SELECT T59.T059_codigo	      Codigo
                     , T59.T059_nome          Nome
                  FROM T060_workflow T60
                  JOIN T059_grupo_workflow T59 ON ( T59.T059_codigo = T60.T059_codigo )
                 WHERE T60.T060_ordem = 1
                   AND T60.T059_codigo NOT IN  (  SELECT T.T059_codigo
                                                    FROM T026_T059 T
                                                   WHERE T.T026_codigo  =  $fornecedor
                                                     AND T.T006_codigo  =  $loja)
                 ORDER BY 1";      
        
        return $this->query($sql);
    }

    public function selecionaLoja($user)
    {
        return $this->query("SELECT T1.T006_codigo      COD
                                  , T1.T006_nome        NOM
                               FROM T006_loja    T1");
    }

}
?>