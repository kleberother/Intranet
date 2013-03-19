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
class models_T0107 extends models
{

    public function __construct($conn,$verificaConexao,$db)
    {
        parent::__construct($conn,$verificaConexao,$db);
    }
    
    public function retornaLabore($loja)
    {   $connORA  =   $this->consulta;
    
        
$sql = "SELECT DISTINCT
                      SE1.DATAM                       DATAM
                    , SE1.DATAY                       DATAY
                    , SUM(SE1.PRECOGE)                PRECO
                    , SUM(SE1.CUSTO)                  CUSTO
   
  FROM (
                       SELECT DISTINCT
                        TRUNC(M.SGE_LOJA/10)                    LOJA
                        , to_char(M.SGE_DAT_EMISSAO, 'MM')      DATAM
                        , to_char(M.SGE_DAT_EMISSAO, 'YYYY')    DATAY
                        , COUNT(M.ROWID)                        QTD
                        , SUM(M.SGE_PRECO_PROD)                 PRECOVDA
                        , SUM(M.SGE_PRECO_GAR)                  PRECOGE
                        , SUM(O.SPZ_VAL_SEGURADORA)             CUSTO


                    FROM RMS.SEG_PRAZO O
                    JOIN RMS.SEG_FXVALOR R   ON O.SPZ_ID_FXVALOR          = R.SFV_ID
                    JOIN RMS.SEG_GARITEM M   ON M.SGE_PRAZO_GAR           = O.SPZ_PRAZO
                                            AND M.SGE_PROD_PRINC          = R.SFV_COD_ITEM_SEG
                    JOIN RMS.DIM_PER DTA     ON DTA.DT_COMPL              = TRUNC(M.SGE_DAT_EMISSAO)
                                        
                                        
                  WHERE R.SFV_VAL_INICIAL        <= M.SGE_PRECO_PROD
                    AND R.SFV_VAL_FINAL          >= M.SGE_PRECO_PROD
                    AND M.SGE_NUM_CUPOM           > 0
                    AND M.SGE_DAT_CANCELAMENTO   IS NULL";
                    
      
            if(!empty($loja))
            $sql    .=  "   AND M.SGE_LOJA                              =   $loja";
                   

             $sql    .=  "  GROUP BY to_char(M.SGE_DAT_EMISSAO, 'MM'),to_char(M.SGE_DAT_EMISSAO, 'YYYY'), M.SGE_LOJA ) SE1
 
       GROUP BY SE1.DATAM, SE1.DATAY
       ORDER BY SE1.DATAY, SE1.DATAM";
             
             

        //echo $sql;
            
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
                            , T100.T100_pct_comissao             PctComissao
                        FROM T100_meta_ge T100
                        JOIN T006_loja T06 ON T100.T006_codigo = T06.T006_codigo
                        JOIN T004_usuario T04 ON T100.T004_login = T04.T004_login
                       WHERE T100.T100_meta > 0";
        
       if(!empty($loja))
            $sql    .=  "   AND T06.T006_codigo                             =   $loja";
        
        if(!empty($mesAno))
            $sql    .=  "   AND CONCAT(T100.T100_mes ,'/', T100.T100_ano)   =   '$mesAno'";
        else
            $sql    .=  "   AND CONCAT(T100.T100_mes ,'/', T100.T100_ano) = (SELECT date_format(sysdate(), '%m/%Y'))";
        
                  
            $sql    .=  "   ORDER BY T06.T006_codigo, T100.T100_mes";
            
            // echo $sql;
        
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
