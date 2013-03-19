<?php


/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 31/01/2012 por Jorge Nova
 * Descrição: Classe de models para o programa T088
 * Entrada:   
 * Origens:   
           
**************************************************************************
*/


class models_T0093 extends models
{

    public function __construct($conn,$verificaConexao,$db)
    {
        parent::__construct($conn,$verificaConexao,$db);
    }
    
    public function inserir($tabela,$campos)
    {
        
        $insere = $this->exec($this->insere($tabela, $campos));
        
//       if($insere)
//            $this->alerts('false', 'Alerta!', 'Incluido com Sucesso!');
//       else
//            $this->alerts('true', 'Erro!', 'Não foi possível Incluir!');
       
       return $insere;
    }   
    
    public function altera($tabela,$campos,$delim)
    {              
       $altera = $this->exec($this->atualiza($tabela, $campos, $delim));
       
//       if($altera)
//            $this->alerts('false', 'Alerta!', 'Alterado com Sucesso!');
//       else
//            $this->alerts('true', 'Erro!', 'Não foi possível Alterar!');          
       
       echo $altera;
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
      
    public function retornaArquivos($codigoArquivo)
    {   
        $sql    =   "  SELECT T93.T093_codigo        CodigoArquivo
                            , T06.T006_codigo               CodigoLoja
                            , T06.T006_nome                 NomeLoja
                            , T04.T004_login                LoginUsuario
                            , T04.T004_nome                 NomeUsuario
                            , CASE T20D.T020_departamento
                              WHEN 0 THEN NULL
                              ELSE T20D.T020_departamento
                              END                           CodigoDpto
                            , CASE T20D.T020_departamento
                              WHEN 0 THEN ''
                              ELSE T20D.T020_descricao
                              END                           DescricaoDpto
                            , CASE T20S.T020_secao
                              WHEN 0 THEN NULL
                              ELSE T20S.T020_secao
                              END                           CodigoSecao
                            , CASE T20S.T020_secao
                              WHEN 0 THEN ''
                              ELSE T20S.T020_descricao
                              END                           DescricaoSecao
                            , CASE T20G.T020_grupo
                              WHEN 0 THEN NULL
                              ELSE T20G.T020_grupo
                              END                           CodigoGrupo
                            , CASE T20G.T020_grupo
                              WHEN 0 THEN ''
                              ELSE T20G.T020_descricao
                              END                           DescricaoGrupo
                            , CASE T20SB.T020_subgrupo
                              WHEN 0 THEN NULL
                              ELSE T20SB.T020_subgrupo
                              END                           CodigoSubgrupo
                            , CASE T20SB.T020_subgrupo
                              WHEN 0 THEN ''
                              ELSE T20SB.T020_descricao
                              END                           DescricaoSubgrupo
                            , date_format(T93.T093_dt_inicio,'%d/%m/%Y %H:%i:%s')            DtInicioArquivo
                            , date_format(T93.T093_dt_fim,'%d/%m/%Y %H:%i:%s')               DtFimArquivo
                        FROM T093_auditoria T93
                        JOIN T006_loja T06                           ON T93.T006_codigo       = T06.T006_codigo
                        JOIN T020_classificacao_mercadologica T20D   ON T93.T020_departamento = T20D.T020_departamento 
                                                                    AND T20D.T020_secao        = 0 
                                                                    AND T20D.T020_grupo        = 0 
                                                                    AND T20D.T020_subgrupo     = 0
                        JOIN T020_classificacao_mercadologica T20S   ON T93.T020_departamento = T20S.T020_departamento 
                                                                    AND T93.T020_secao        = T20S.T020_secao 
                                                                    AND T20S.T020_grupo        = 0 
                                                                    AND T20S.T020_subgrupo     = 0
                        JOIN T020_classificacao_mercadologica T20G   ON T93.T020_departamento = T20G.T020_departamento 
                                                                    AND T93.T020_secao        = T20G.T020_secao 
                                                                    AND T93.T020_grupo        = T20G.T020_grupo 
                                                                    AND T20G.T020_subgrupo     = 0
                        JOIN T020_classificacao_mercadologica T20SB  ON T93.T020_departamento = T20SB.T020_departamento 
                                                                    AND T93.T020_secao        = T20SB.T020_secao 
                                                                    AND T93.T020_grupo        = T20SB.T020_grupo 
                                                                    AND T93.T020_subgrupo     = T20SB.T020_subgrupo
                        JOIN T004_usuario T04                        ON T93.T004_login        = T04.T004_login
                       WHERE T93.T093_tipo  = 'I'";
                  
        
        
        if (!empty($codigoArquivo))
        {
            $sql    .="   AND T93.T093_codigo  = $codigoArquivo";
            return $this->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        }
        else
            return $this->query($sql);
                        
    }  
    
    public function retornaItens($codigoAuditoria)
    {
        $sql    =   "   SELECT T94.T093_codigo          CodigoAuditoria
                             , T94.T094_EAN             EAN
                             , T94.T094_descricao       Descricao
                             , CASE T94.T094_oferta
                               WHEN 'S' THEN 'SIM'
                               ELSE 'NÃO'
                               END                      Oferta
                             , CASE T94.T094_linha
                               WHEN 'S' THEN 'SIM'
                               ELSE 'NÃO'
                               END                      EmLinha        
                             , T94.T094_qtde_etiqueta   QtdeEtiqueta
                             , T094_preco_rms           PrecoRMS
                             , T94.T094_preco_auditado  PrecoAuditado   
                             , T105.T105_descricao      Status
                          FROM T094_auditoria_detalhes T94
                          JOIN T105_auditoria_item_status T105 ON T105.T105_codigo = T94.T105_status
                         WHERE T94.T093_tipo = 'I'
                           AND T94.T093_codigo =    $codigoAuditoria";
        
        return $this->query($sql);
    }
    
    public function retornaDadosItem($dataRMS7, $lojaSemDigito, $loja, $ean)
    {
        $connORA  =   $this->consulta;
        
        $sql = "   SELECT ITM.GIT_CODIGO_EAN13                               EAN
                        , SE1.EAN_COD_PRO_ALT                                CODIGOINTERNO
                        , ITM.GIT_CODIGO_PAI                                 CODIGOPAI
                        , ITM.GIT_DESC_COML                                  DESCRICAO
                        , RMS.F_RETORNA_PRECOS(ITM.GIT_COD_ITEM, $dataRMS7, $lojaSemDigito) INFOPRECO
                        , to_char(EST.GET_VEND_ACUM_ANO,'90.99')             SAIDAMEDIA
                        , decode(ITM.GIT_DAT_SAI_LIN, 0, 'S', 'N')           EMLINHA
                        , EST.GET_ESTOQUE                                    ESTOQUE
                        , GIT_COD_FOR                                        CODIGOFORNECEDOR
                        , GIT_COMPRADOR                                      CODIGOCOMPRADOR
                    FROM (SELECT EAN.EAN_COD_PRO_ALT                     
                            FROM RMS.AA3CCEAN EAN 
                            WHERE EAN.EAN_COD_EAN = $ean
                        ) SE1
                        , RMS.AA3CITEM ITM 
                    JOIN RMS.AA2CESTQ EST ON (EST.GET_COD_PRODUTO  = (10*ITM.GIT_COD_ITEM)+ITM.GIT_DIGITO)      
                   WHERE TRUNC(SE1.EAN_COD_PRO_ALT/10,0) = ITM.GIT_COD_ITEM 
                     AND EST.GET_COD_LOCAL               = $loja";
                        
        $stid    = oci_parse($connORA, $sql);
        oci_execute($stid);
        return($stid);
    }
    
    public function retornaStrLojaSegmento()
    {        
        $sql = "  SELECT T06.T006_codigo Loja
                    FROM T006_loja T06 
                    JOIN T065_segmento_filiais T065 
                      ON T06.T065_codigo = T065.T065_codigo
                   WHERE T06.T065_codigo = 1" ;
        
        $dados  = $this->query($sql);
        
        foreach ($dados as $campos => $valores) 
        {
            $strFiliais .=   $valores['Loja'].",";
        }
        
        $strFiliais = substr($strFiliais, 0, -1);
        
        return $strFiliais;
        
    }

    public function retornaDadosEstoque($ean, $lojas) {
        
         $connORA  =   $this->consulta;
        
       $sql="  SELECT    EST.GET_ESTOQUE    ESTOQUE
                        ,EST.GET_COD_LOCAL  LOCAL
                 FROM (SELECT EAN.EAN_COD_PRO_ALT                     
                            FROM RMS.AA3CCEAN EAN 
                            WHERE EAN.EAN_COD_EAN = '$ean'
                        ) SE1
                        , RMS.AA3CITEM ITM 
                    JOIN RMS.AA2CESTQ EST ON (EST.GET_COD_PRODUTO  = (10*ITM.GIT_COD_ITEM)+ITM.GIT_DIGITO)      
                   WHERE TRUNC(SE1.EAN_COD_PRO_ALT/10,0) = ITM.GIT_COD_ITEM
                      AND  GET_COD_LOCAL IN ($lojas)";
       
            $stid    = oci_parse($connORA, $sql);
            oci_execute($stid);
            return($stid);
    }
    
    public function retornaRupturasComercial($codigoArquivo)
    {
        $sql    =   "   SELECT T94.T093_codigo                              Auditoria
                             , T94.T094_descricao                           Descricao
                             , T94.T094_codigo_rms                          CodigoRMS
                             , T94.T094_EAN                                 Ean
                             , CASE T94.T094_oferta
                               WHEN 'S' THEN 'SIM'
                               ELSE 'NÃO'
                               END                                          Oferta 
                             , T94.T094_preco_rms                           PrecoRMS
                             , T94.T094_preco_auditado                      PrecoAuditado                             
                             , T93.T006_codigo                              Loja
                             , T06.T006_nome                                LojaNome
                             , T94.T094_estoque_rms                         Estoque
                             , date_format(T93.T093_dt_inicio,'%d/%m/%Y')   Data
                             , T93.T020_departamento                        Departamento
                             , T93.T020_secao                               Secao
                             , T93.T020_grupo                               Grupo
                             , T93.T020_subgrupo                            Subgrupo                                 
                          FROM T094_auditoria_detalhes T94
                          JOIN T093_auditoria T93 ON T93.T093_codigo    = T94.T093_codigo 
                                                 AND T93.T093_tipo      = T94.T093_tipo
                          JOIN T006_loja T06 ON T06.T006_codigo = T93.T006_codigo
                         WHERE T94.T093_codigo = $codigoArquivo
                           AND T94.T093_tipo = 'C'
                           AND T94.T094_linha= 'S'
                           AND T94.T094_item_pai_rms NOT IN (
                                                                SELECT T94.T094_item_pai_rms
                                                                  FROM T094_auditoria_detalhes T94 
                                                                 WHERE T093_codigo = $codigoArquivo
                                                                   AND T093_tipo = 'I' 
                                                             )
                           AND T94.T094_estoque_rms =   0
             GROUP BY T94.T094_item_pai_rms
             ORDER BY 7 DESC";
        
        //echo $sql;
        
        return $this->query($sql);
    }


    public function dadosintra()
    {
        $sql    =   "  SELECT T94.T093_codigo    Codigo
                            , T94.T094_EAN       Ean
                            , T93.T006_codigo    Loja
                            , date_format(T93.T093_dt_inicio,'%d') Dia
                            , date_format(T93.T093_dt_inicio,'%m') Mes
                            , date_format(T93.T093_dt_inicio,'%Y') ano
                        FROM T094_auditoria_detalhes T94
                        JOIN T093_auditoria T93 ON T93.T093_codigo = T94.T093_codigo 
                                                AND T93.T093_tipo = T94.T093_tipo
                        WHERE T94.T094_fornecedor_rms is null";
        
        return $this->query($sql);        
    }

    public function checkRMS($ean)
    {
        
      //  $lojaSemDigito  =   substr ($loja, 0, strlen($loja) - 1);        
    
        $connORA  =   $this->consulta;
        
        $sql = "   SELECT 
                        GIT_COD_FOR                                        CODIGOFORNECEDOR
                    FROM (SELECT EAN.EAN_COD_PRO_ALT                     
                            FROM RMS.AA3CCEAN EAN 
                            WHERE EAN.EAN_COD_EAN = $ean
                        ) SE1
                        , RMS.AA3CITEM ITM 
                    JOIN RMS.AA2CESTQ EST ON (EST.GET_COD_PRODUTO  = (10*ITM.GIT_COD_ITEM)+ITM.GIT_DIGITO)      
                   WHERE TRUNC(SE1.EAN_COD_PRO_ALT/10,0) = ITM.GIT_COD_ITEM ";
                     
                      
        
//        echo $sql;
        $stid    = oci_parse($connORA, $sql);
        oci_execute($stid);
        return($stid);    
            
    }
    
    public function retornaRupturas($codigoAuditoria)
    {
       // echo "EXECUTEI ESSA QUERY....";
        $sql    =   "   SELECT T94.T093_codigo                              Auditoria
                             , T94.T093_tipo                                Tipo
                             , T94.T094_descricao                           Descricao
                             , T94.T094_codigo_rms                          CodigoRMS
                             , T94.T094_linha                               Linha
                             , T94.T094_EAN                                 Ean
                             , T94.T094_estoque_rms                         Estoque
                             , CASE T94.T094_oferta
                               WHEN 'S' THEN 'SIM'
                               ELSE 'NÃO'
                               END                                          Oferta 
                             , T94.T094_preco_rms                           PrecoRMS
                             , T93.T006_codigo                              Loja
                             , FNDVINT_Auditoria_QtEmLinha(T93.T093_codigo) EmLinha
                          FROM T094_auditoria_detalhes T94
                          JOIN T093_auditoria T93 ON T93.T093_codigo = T94.T093_codigo 
                                                 AND T93.T093_tipo = T94.T093_tipo
                         WHERE T94.T093_codigo = $codigoAuditoria
                           AND T94.T093_tipo = 'C'
                           AND T94.T094_linha= 'S'
                           AND T94.T094_item_pai_rms NOT IN (
                                                                SELECT T94.T094_item_pai_rms
                                                                  FROM T094_auditoria_detalhes T94 
                                                                 WHERE T093_codigo = $codigoAuditoria
                                                                   AND T093_tipo = 'I' 
                                                             )
             GROUP BY T94.T094_item_pai_rms
             ORDER BY 7 DESC";
        
        return $this->query($sql);
    }
    
    public function verificaReceita($codigoRMS)
    {
        $connORA  =   $this->consulta;
        
        $sql = "  SELECT REC.RECE_PRODUTO
                    FROM RMS.AA1CRECE REC
                   WHERE REC.RECE_PRODUTO = $codigoRMS";

        $stid    = oci_parse($connORA, $sql);
        oci_execute($stid);
        return($stid);
    }     
    
       public function retornaGerente() {
        
        $sql = "SELECT T004_login Usuario
                  FROM T004_T009
                 WHERE T009_codigo = 56";
        //echo $sql."<br>";
        return $this->query($sql);
    }
    
        public function retornaContatos($user, $loja) {
        
        $sql =  "SELECT T004_login  Usuario
                       ,T004_nome   Nome
                   FROM T004_usuario
                  WHERE T004_login  =   '$user'
                    AND T006_codigo =    $loja";
        
        //echo $sql."<br>";
        
        return $this->query($sql);
        
    }
    
    public function enviaEmailRuptInclusao($loja, $auditoria) {


        $retornaGerente = $this->retornaGerente();

        foreach ($retornaGerente as $cpsGe => $valoresGe) {
            $retornaContatos = $this->retornaContatos($valoresGe["Usuario"], $loja);
            foreach ($retornaContatos as $cpsCont => $valoresCont) {
                
                $from       =   "web@davo.com.br";
                $to         =   $valoresCont["Usuario"]."@davo.com.br";
                $subject    =   "[Intranet] - Confirmacao de Rupturas na Loja - ".date("d/m/Y");
                $message    =   "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />".$valoresCont["Nome"].",<br><br>A auditoria ".$auditoria." contém Rupturas na Loja a serem confirmadas. ";
                $headers    =   "From: $from\r\n"; 
                $headers   .=   "Content-type: text/html\r\n";
                $headers   .=   "Cc: web@davo.com.br, marcio@davo.com.br";


                mail($to, $subject, $message,$headers);
            }
        }
    }
    
    
    
}
?>
