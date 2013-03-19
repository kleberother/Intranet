<?php


///**************************************************************************
//                Intranet - DAVÓ SUPERMERCADOS
// * Criado em: 22/05/2012 por Rodrigo Alfieri
// * Descrição: Cadastro de Metas de Garantia Estendida.
// * Entrada:   
// * Origens:   
//           
//**************************************************************************
//*/
//
//
class models_T0103 extends models
{

    public function __construct($conn,$verificaConexao,$db)
    {
        parent::__construct($conn,$verificaConexao,$db);
    }
    
    public function retornaGrupos($loja, $dataI,$dataF, $tipo, $grupo, $subgrupo)
    {   $connORA  =   $this->consulta;
    
        
        $sql = " SELECT se6.grupo                        GRUPO,
                        se6.SubGrupo                     SUBGRUPO,
                        sum(SE6.QtdeVda)                 VENDA_ELEGIDOS_GERAL,
                        sum(SE6.QtdeGE)                  QTDGE_GERAL,
                        sum(SE6.VDA_ASS_ELE)             ELEGI_VENDEDOR,
                        sum(SE6.QtdeVE)                  GEVEN,
                        sum(SE6.QtdeOC)                  GEOPER
                FROM (SELECT
                     (SELECT CM1.NCC_DESCRICAO descricao
                        FROM RMS.AA3CNVCC CM1
                       WHERE CM1.NCC_DEPARTAMENTO = SE5.Depto
                         AND CM1.NCC_SECAO = SE5.Secao
                         AND CM1.NCC_GRUPO = SE5.Grupo
                         AND CM1.NCC_SUBGRUPO = 0
                         AND ROWNUM = 1)                GRUPO,
                     (SELECT DISTINCT CM1.NCC_DESCRICAO descricao
                        FROM RMS.AA3CNVCC CM1
                       WHERE CM1.NCC_DEPARTAMENTO = SE5.Depto
                         AND CM1.NCC_SECAO = SE5.Secao
                         AND CM1.NCC_GRUPO = SE5.Grupo
                         AND CM1.NCC_SUBGRUPO = SE5.Subgrupo
                         AND ROWNUM = 1)                SUBGRUPO,
(SELECT SUM(DT.PED_QTD_DT)
  FROM RMS.AG3PVEDT DT
  LEFT JOIN RMS.AG3PVECP PED ON PED.PED_NUM_PEDIDO_CP = DT.PED_NUM_PEDIDO_DT
                             AND PED.PED_VENDEDOR_CP = DT.PED_VENDEDOR_DT
WHERE PED.PED_STATUS_CP IN (28, 60)
   AND (to_char(RMS.rms7to_date(RMS.ADICIONA_SECULO(PED.PED_DATA_EMISSAO_CP)),'YYYYMMDD')) >= '$dataI'
   AND (to_char(RMS.rms7to_date(RMS.ADICIONA_SECULO(PED.PED_DATA_EMISSAO_CP)),'YYYYMMDD')) <= '$dataF'
   AND DT.PED_PROD_PRINC_DT = SE5.CitemSD
   AND DT.PED_LOJA_DT       = 10*SE5.Loja+RMS.DAC(SE5.Loja) ) VDA_ASS_ELE,
                                   SE5.QtdeVda,
                                   SE5.QtdeGE,
                                   SE5.QtdeVE,
                                   SE5.QtdeOC
          FROM (SELECT SE4.Loja,
                       SE4.CitemSD,
                       SE4.Depto,
                       SE4.Secao,
                       SE4.Grupo,
                       SE4.Subgrupo,
                       sum(SE4.QtdeGE) QtdeGE,
                       sum(SE4.QtdeOC) QtdeOC,
                       sum(SE4.QtdeVE) QtdeVE,
                       sum(SE4.QtdeVda) QtdeVda
                  FROM (SELECT SE3.Loja,
                               SE3.Depto,
                               SE3.Secao,
                               SE3.Grupo,
                               SE3.Subgrupo,
                               SE3.cItemSD,
                               SE3.QtdeOC + SE3.QtdeVE QtdeGE,
                               SE3.QtdeOC,
                               SE3.QtdeVE,
                               sum(VDA.QTD_VDA) - sum(VDA.QTD_DVOL_VDA) QtdeVda
                          FROM (SELECT LOJ.LOJ_CODIGO Loja,
                                       SE2.Depto,
                                       SE2.Secao,
                                       SE2.Grupo,
                                       SE2.Subgrupo,
                                       SE2.CitemSD,
                                       (SELECT count(*)
                                          FROM  RMS.SEG_GARITEM SGEO
                                         WHERE SGEO.SGE_LOJA = 10*LOJ.LOJ_CODIGO+RMS.DAC(LOJ.LOJ_CODIGO)
                                           AND SGEO.SGE_PROD_PRINC_SEG = SE2.CitemSD
                                           AND to_char(SGEO.SGE_DAT_EMISSAO, 'YYYYMMDD') >= '$dataI'
                                           AND to_char(SGEO.SGE_DAT_EMISSAO, 'YYYYMMDD') <= '$dataF'
                                           AND SGEO.SGE_NUM_PEDIDO = 0) QtdeOC,
                                      count(SGEV.SGE_ID) QtdeVE
                                  FROM (SELECT DISTINCT GIT.GIT_DEPTO    Depto,
                                                        GIT.GIT_SECAO    Secao,
                                                        GIT.GIT_GRUPO    Grupo,
                                                        GIT.GIT_SUBGRUPO Subgrupo,
                                                        GIT.GIT_COD_ITEM CitemSD
                                          FROM RMS.SEG_PROD_ELEGIVEL PEL
                                          JOIN RMS.AA3CITEM GIT
                                            ON (GIT.GIT_COD_ITEM = PEL.SPE_COD_ITEM
                                           AND GIT.GIT_DIGITO = RMS.DAC(PEL.SPE_COD_ITEM))) SE2
                                  JOIN RMS.AA2CLOJA LOJ ON  (";
        if (!empty($loja))
            $sql    .=  " 10 * LOJ.LOJ_CODIGO + LOJ.LOJ_DIGITO  =   $loja)";
       else
            $sql    .=  " LOJ.LOJ_CODIGO                        >   0   )";
       
            $sql    .=  "         LEFT JOIN RMS.SEG_GARITEM SGEV
                                    ON (SGEV.SGE_LOJA = 10 * LOJ.LOJ_CODIGO + LOJ.LOJ_DIGITO
                                    AND SGEV.SGE_PROD_PRINC_SEG = SE2.CitemSD
                                    AND to_char(SGEV.SGE_DAT_EMISSAO, 'YYYYMMDD') >= '$dataI'
                                    AND to_char(SGEV.SGE_DAT_EMISSAO, 'YYYYMMDD') <= '$dataF'
                                    AND SGEV.SGE_NUM_PEDIDO > 0)
                                 GROUP BY LOJ.LOJ_CODIGO,
                                          SE2.Depto,
                                          SE2.Secao,
                                          SE2.Grupo,
                                          SE2.Subgrupo,
                                          SE2.CitemSD) SE3
                          JOIN RMS.AGG_VDA_PROD_VEND VDA
                            ON (VDA.CD_PROD = SE3.CitemSD)
                          JOIN RMS.DIM_PER DTA
                            ON (DTA.ID_DT = VDA.ID_DT)
                         WHERE DTA.DT_AAMD >= '$dataI'
                           AND DTA.DT_AAMD <= '$dataF'
                           AND VDA.CD_FIL = SE3.Loja";  
       
       if (!empty($grupo))
            $sql    .=  " AND (SELECT CM1.NCC_DESCRICAO descricao
                                 FROM RMS.AA3CNVCC CM1
                                WHERE CM1.NCC_DEPARTAMENTO = SE3.Depto
                                  AND CM1.NCC_SECAO        = SE3.Secao
                                  AND CM1.NCC_GRUPO        = SE3.Grupo
                                  AND CM1.NCC_SUBGRUPO     = 0
                                  AND ROWNUM = 1
                                )                      = $grupo";
        
        if (!empty($subgrupo))
            $sql    .=  " AND (SELECT DISTINCT CM1.NCC_DESCRICAO descricao
                                 FROM RMS.AA3CNVCC CM1
                                WHERE CM1.NCC_DEPARTAMENTO  = SE3.Depto
                                  AND CM1.NCC_SECAO        = SE3.Secao
                                  AND CM1.NCC_GRUPO        = SE3.Grupo
                                  AND CM1.NCC_SUBGRUPO     = SE3.Subgrupo
                                  AND ROWNUM = 1
                                )                      = $subgrupo";
               
            $sql    .=     " GROUP BY SE3.Loja , SE3.Depto , SE3.Secao ,  SE3.Grupo , SE3.Subgrupo, SE3.cItemSD , SE3.QtdeOC , SE3.QtdeVE
                 ) SE4
          GROUP BY SE4.Loja, SE4.Depto , SE4.Secao ,  SE4.Grupo , SE4.Subgrupo, SE4.CitemSD
     ) SE5

)SE6

   GROUP BY se6.grupo, se6.SubGrupo";
        
   $sql    .=      " ORDER BY $tipo DESC";

       //echo $sql;  
            
        $stid    = oci_parse($connORA, $sql);
        oci_execute($stid);
        return($stid);
        
}
    
    
    
        public function retornaComboGrupos()
    {   $connORA  =   $this->consulta;
        
        $sql = "  SELECT  
                         SE1.Grupo
                    FROM   
          ( SELECT DISTINCT
          
                       (  SELECT CM1.NCC_DESCRICAO descricao
                            FROM RMS.AA3CNVCC CM1
                            WHERE CM1.NCC_DEPARTAMENTO = GIT.GIT_DEPTO
                            AND CM1.NCC_SECAO        = GIT.GIT_SECAO
                            AND CM1.NCC_GRUPO        = GIT.GIT_GRUPO
                            AND CM1.NCC_SUBGRUPO     = 0
                            AND ROWNUM               = 1
                        ) Grupo

        FROM RMS.SEG_PROD_ELEGIVEL PEL
        LEFT JOIN RMS.AA3CITEM          GIT ON (GIT.GIT_COD_ITEM = PEL.SPE_COD_ITEM )ORDER BY 1) SE1 " ;
        
        
            
           // echo $sql;
            
        $stid    = oci_parse($connORA, $sql);
        oci_execute($stid);
        return($stid);             
                 
    }        
    
    public function retornaComboSubGrupos($grupo)
    {   $connORA  =   $this->consulta;
        
        $sql = "  SELECT  
                         SE1.SubGrupo
                    FROM   
          ( SELECT DISTINCT
          
                        ( SELECT DISTINCT CM1.NCC_DESCRICAO descricao
                            FROM RMS.AA3CNVCC CM1
                            WHERE CM1.NCC_DEPARTAMENTO = GIT.GIT_DEPTO
                            AND CM1.NCC_SECAO        = GIT.GIT_SECAO
                            AND CM1.NCC_GRUPO        = GIT.GIT_GRUPO
                            AND CM1.NCC_SUBGRUPO     = GIT.GIT_SUBGRUPO
                            AND ROWNUM               = 1
                         ) SubGrupo 

        FROM RMS.SEG_PROD_ELEGIVEL PEL
        LEFT JOIN RMS.AA3CITEM          GIT ON (GIT.GIT_COD_ITEM = PEL.SPE_COD_ITEM ) ";
        
        if (!empty($grupo))
            $sql    .=  " WHERE (SELECT CM1.NCC_DESCRICAO descricao
                                 FROM RMS.AA3CNVCC CM1
                                WHERE CM1.NCC_DEPARTAMENTO = GIT.GIT_DEPTO
                                  AND CM1.NCC_SECAO        = GIT.GIT_SECAO
                                  AND CM1.NCC_GRUPO        = GIT.GIT_GRUPO
                                  AND CM1.NCC_SUBGRUPO     = 0
                                  AND ROWNUM               = 1
                                    )                      = $grupo";

            $sql    .= "ORDER BY 1) SE1 " ;
        
        
            
           // echo $sql;
            
        $stid    = oci_parse($connORA, $sql);
        oci_execute($stid);
        return($stid);             
                 
    }
            
    public function retornaItensGrupos($loja, $dataI,$dataF, $tipos, $grupo, $subgrupo)
    {   
        $connORA  =   $this->consulta;
    
        
        $sql = 
                "SELECT
                se6.grupo                                GRUPO,
                se6.SubGrupo                             SUBGRUPO,
                10*SE6.CitemSD+SE6.CitemD                ITEM,
                SE6.CdescrI                              DESCRICAO,
                sum(SE6.QtdeVda)                         VENDA,
                sum(SE6.QtdeGE)                          QTDGE,
                sum(SE6.VDA_ASS_ELE)                     ELEGIV,
                sum(SE6.QtdeVE)                          GEVEN,
                sum(SE6.QtdeOC)                          GEOPER
       
  FROM (SELECT (SELECT CM1.NCC_DESCRICAO descricao
                  FROM RMS.AA3CNVCC CM1
                 WHERE CM1.NCC_DEPARTAMENTO = SE5.Depto
                   AND CM1.NCC_SECAO = SE5.Secao
                   AND CM1.NCC_GRUPO = SE5.Grupo
                   AND CM1.NCC_SUBGRUPO = 0
                   AND ROWNUM = 1) GRUPO,
                   
               (SELECT DISTINCT CM1.NCC_DESCRICAO descricao
                  FROM RMS.AA3CNVCC CM1
                 WHERE CM1.NCC_DEPARTAMENTO = SE5.Depto
                   AND CM1.NCC_SECAO = SE5.Secao
                   AND CM1.NCC_GRUPO = SE5.Grupo
                   AND CM1.NCC_SUBGRUPO = SE5.Subgrupo
                   AND ROWNUM = 1) SUBGRUPO,
                   
               (SELECT SUM(DT.PED_QTD_DT)
                  FROM RMS.AG3PVEDT DT
                  LEFT JOIN RMS.AG3PVECP PED
                    ON PED.PED_NUM_PEDIDO_CP = DT.PED_NUM_PEDIDO_DT
                   AND PED.PED_VENDEDOR_CP = DT.PED_VENDEDOR_DT
                  WHERE PED.PED_STATUS_CP IN (28,60)
                    AND (to_char(RMS.rms7to_date(RMS.ADICIONA_SECULO(PED.PED_DATA_EMISSAO_CP)),'YYYYMMDD')) >= '$dataI'
                    AND (to_char(RMS.rms7to_date(RMS.ADICIONA_SECULO(PED.PED_DATA_EMISSAO_CP)),'YYYYMMDD')) <= '$dataF'";
        
     if (!empty($loja))
            $sql    .=  " AND DT.PED_LOJA_DT  =   $loja";
    
            $sql    .= "  AND DT.PED_PROD_PRINC_DT = SE5.CitemSD ) VDA_ASS_ELE,
                   
                   SE5.QtdeVda, SE5.QtdeGE, SE5.QtdeVE, SE5.QtdeOC, SE5.CitemSD, SE5.CitemD, SE5.CdescrI
                  
          FROM (SELECT SE4.CitemSD, SE4.CitemD,SE4.CdescrI,SE4.Depto,SE4.Secao,SE4.Grupo,SE4.Subgrupo,sum(SE4.QtdeGE) QtdeGE, sum(SE4.QtdeOC) QtdeOC, sum(SE4.QtdeVE) QtdeVE, sum(SE4.QtdeVda) QtdeVda
                  FROM (SELECT SE3.Loja, SE3.Depto, SE3.Secao, SE3.Grupo, SE3.Subgrupo, SE3.cItemSD, SE3.CitemD, SE3.CdescrI, SE3.QtdeOC + SE3.QtdeVE QtdeGE, SE3.QtdeOC, SE3.QtdeVE, sum(VDA.QTD_VDA) - sum(VDA.QTD_DVOL_VDA) QtdeVda
                          FROM (SELECT LOJ.LOJ_CODIGO Loja, SE2.Depto, SE2.Secao, SE2.Grupo, SE2.Subgrupo, SE2.CitemSD, SE2.CitemD, SE2.CdescrI, count(SGEO.SGE_ID) QtdeOC, count(SGEV.SGE_ID) QtdeVE
                                  FROM (SELECT DISTINCT GIT.GIT_DEPTO    Depto,
                                                        GIT.GIT_SECAO    Secao,
                                                        GIT.GIT_GRUPO    Grupo,
                                                        GIT.GIT_SUBGRUPO Subgrupo,
                                                        GIT.GIT_COD_ITEM CitemSD,
                                                        GIT.GIT_DIGITO   CitemD,
                                                        GIT.GIT_DESCRICAO CdescrI
                                          FROM RMS.SEG_PROD_ELEGIVEL PEL
                                          JOIN RMS.AA3CITEM GIT ON (GIT.GIT_COD_ITEM = PEL.SPE_COD_ITEM 
                                                               AND GIT.GIT_DIGITO    = RMS.DAC(PEL.SPE_COD_ITEM))) SE2
                                                               
                                  JOIN RMS.AA2CLOJA LOJ ON (";
        if (!empty($loja))
            $sql    .=  " 10 * LOJ.LOJ_CODIGO + LOJ.LOJ_DIGITO  =   $loja)";
       else
            $sql    .=  " LOJ.LOJ_CODIGO                        >   0   )";
       
            $sql    .=  " LEFT JOIN RMS.SEG_GARITEM SGEO ON (SGEO.SGE_LOJA = 10 * LOJ.LOJ_CODIGO + LOJ.LOJ_DIGITO 
                                                                AND  SGEO.SGE_PROD_PRINC_SEG = SE2.CitemSD 
                                                                AND  to_char(SGEO.SGE_DAT_EMISSAO,'YYYYMMDD') >= '$dataI' 
                                                                AND  to_char(SGEO.SGE_DAT_EMISSAO,'YYYYMMDD') <= '$dataF'
                                                                AND  SGEO.SGE_NUM_PEDIDO = 0)
                                  LEFT JOIN RMS.SEG_GARITEM SGEV ON (SGEV.SGE_LOJA = 10 * LOJ.LOJ_CODIGO + LOJ.LOJ_DIGITO 
                                                                AND  SGEV.SGE_PROD_PRINC_SEG = SE2.CitemSD 
                                                                AND  to_char(SGEV.SGE_DAT_EMISSAO, 'YYYYMMDD') >= '$dataI' 
                                                                AND  to_char(SGEV.SGE_DAT_EMISSAO, 'YYYYMMDD') <= '$dataF' 
                                                                AND  SGEV.SGE_NUM_PEDIDO > 0)
                                 GROUP BY LOJ.LOJ_CODIGO, SE2.Depto, SE2.Secao, SE2.Grupo, SE2.Subgrupo, SE2.CitemSD, SE2.CitemD, SE2.CdescrI) SE3
                                 
                          JOIN RMS.AGG_VDA_PROD_VEND VDA ON (VDA.CD_PROD = SE3.CitemSD)
                          JOIN RMS.DIM_PER DTA           ON (DTA.ID_DT = VDA.ID_DT)
    
                         WHERE DTA.DT_AAMD                      >= '$dataI'
                           AND DTA.DT_AAMD                      <= '$dataF'
                           AND VDA.CD_FIL = SE3.Loja";  
       
       if (!empty($grupo))
            $sql    .=  " AND (SELECT CM1.NCC_DESCRICAO descricao
                                 FROM RMS.AA3CNVCC CM1
                                WHERE CM1.NCC_DEPARTAMENTO = SE3.Depto
                                  AND CM1.NCC_SECAO        = SE3.Secao
                                  AND CM1.NCC_GRUPO        = SE3.Grupo
                                  AND CM1.NCC_SUBGRUPO     = 0
                                  AND ROWNUM = 1
                                )                      = $grupo";
        
        if (!empty($subgrupo))
            $sql    .=  " AND (SELECT DISTINCT CM1.NCC_DESCRICAO descricao
                                 FROM RMS.AA3CNVCC CM1
                                WHERE CM1.NCC_DEPARTAMENTO  = SE3.Depto
                                  AND CM1.NCC_SECAO        = SE3.Secao
                                  AND CM1.NCC_GRUPO        = SE3.Grupo
                                  AND CM1.NCC_SUBGRUPO     = SE3.Subgrupo
                                  AND ROWNUM = 1
                                )                      = $subgrupo";
               
            $sql    .=     " GROUP BY SE3.Loja,
                                  SE3.Depto,
                                  SE3.Secao,
                                  SE3.Grupo,
                                  SE3.Subgrupo,
                                  SE3.cItemSD,
                                  SE3.CitemD,
                                  SE3.CdescrI,
                                  SE3.QtdeOC,
                                  SE3.QtdeVE) SE4
                 GROUP BY SE4.Depto,
                          SE4.Secao,
                          SE4.Grupo,
                          SE4.Subgrupo,
                          SE4.CitemSD,
                          SE4.CitemD,
                          SE4.CdescrI) SE5) SE6
 GROUP BY se6.grupo, se6.SubGrupo, 10*SE6.CitemSD+SE6.CitemD, SE6.CdescrI";
            
        
   $sql    .=      " ORDER BY $tipos DESC";

        $stid    = oci_parse($connORA, $sql);
        oci_execute($stid);
        return($stid);
        
}
    
    
   
   
    
    public function retornaPerfil($user)
    {
        $sql    =   "  SELECT T0409.T009_codigo  CodigoPerfil
                         FROM T004_T009 T0409 
                        WHERE T009_codigo IN (47,48) 
                          AND T004_login = '$user'";
        
        return $this->query($sql)->fetchAll(PDO::FETCH_COLUMN);
    }
    
    public function retornarLoja()
    {
        $sql    =   "  SELECT T06.T006_codigo LojaCodigo
                            , T06.T006_nome   LojaNome
                         FROM T006_loja T06
                         JOIN T065_segmento_filiais T65 ON T06.T065_codigo = T65.T065_codigo
                        WHERE T65.T065_codigo  = 1";
        
        return $this->query($sql);
    }
    
    
    public function retornaMes($mesAno)
    {
        $sql    =   "  SELECT DISTINCT
                       CONCAT(T100.T100_mes ,'/', T100.T100_ano) MesMeta
                         FROM T100_meta_ge T100
                         JOIN T006_loja T06 ON T100.T006_codigo = T06.T006_codigo
                         JOIN T004_usuario T04 ON T100.T004_login = T04.T004_login";
        
        if(empty($mesAno))
            $sql    .=  "   AND CONCAT(T100.T100_mes ,'/', T100.T100_ano) = (SELECT date_format(sysdate(), '%m/%Y'))";
            
        
        return $this->query($sql);
        
    }
    
    public function retornaMetas($mesAno, $loja)
    {
        $sql    =   "  SELECT T100.T100_codigo                   CodigoMeta
                            , T06.T006_codigo                    CodigoLoja
                            , T06.T006_nome                      NomeLoja
                            , T04.T004_login                     Login
                            , CONCAT(T100.T100_mes ,'/', T100.T100_ano) MesMeta
                            , T100.T100_quantidade               QtdeMeta
                            , T100.T100_meta                     ValorMeta
                        FROM T100_meta_ge T100
                        JOIN T006_loja T06 ON T100.T006_codigo = T06.T006_codigo
                        JOIN T004_usuario T04 ON T100.T004_login = T04.T004_login
                       WHERE T100.T100_meta > 0";
        
       if(!empty($loja))
            $sql    .=  "   AND T06.T006_codigo                             =   $loja";
        
        if(!empty($mesAno))
            $sql    .=  "   AND CONCAT(T100.T100_mes ,'/', T100.T100_ano)   =   $mesAno";
        else
            $sql    .=  "   AND CONCAT(T100.T100_mes ,'/', T100.T100_ano) = (SELECT date_format(sysdate(), '%m/%Y'))";
        
                  
            $sql    .=  "   ORDER BY T06.T006_codigo, T100.T100_mes";
            
            //echo $sql;
        
        return $this->query($sql);
    }
    
    
    
    public function retornaLojas()
    {
        $sql    =   "  SELECT T06.T006_codigo LojaCodigo
                            , T06.T006_nome   LojaNome
                         FROM T006_loja T06
                         JOIN T065_segmento_filiais T65 ON T06.T065_codigo = T65.T065_codigo
                        WHERE T65.T065_codigo  = 1";
        
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
    }
    
    
    
    public function inserir($tabela,$campos)
    {
        $insere = $this->exec($this->insere($tabela, $campos));  
        
    }
    
    
    
    
    
     public function excluir($tabela, $delim)
    {
        $exclui = $this->exec($this->exclui($tabela, $delim));
        
       if($exclui)
            $this->alerts('false', 'Alerta!', 'Excluído com Sucesso!');
       else
            $this->alerts('true', 'Erro!', 'Não foi possível Excluir!'); 
    }
    

    
}
 ?>
