<?php

///**************************************************************************
//                Intranet - DAVÓ SUPERMERCADOS
// * Criado em: 19/10/2012 por Alexandre Alves
// * Descrição: Programa de Conciliacao Correspondente Bancario (COBAN)
// * Entrada:   
// * Origens:   
//           
//**************************************************************************
//*/
//
//
class models_T0112 extends models
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
    
    public function retornaLojasSelectBox()
    {
        $sql = "   SELECT T06.T006_codigo LojaCodigo
                        , T06.T006_nome   LojaNome
                     FROM T006_loja T06
                     JOIN T065_segmento_filiais T65 ON T06.T065_codigo = T65.T065_codigo
                    WHERE T65.T065_codigo  >= 1";
        
        return $this->query($sql);
    }

    public function retornaStatusConciliacoes()
    {   $connORA  =   $this->consulta;
        $sql = "   SELECT CSC.CSCCODIGO ,
                          CSC.CSCDESCRICAO
                     FROM DAVO.COBAN_STATUSCONCILIACAO CSC
                    ORDER BY 1    
               ";
        
        $stid    = oci_parse($connORA, $sql);
        oci_execute($stid);
        return($stid);

    }    

    public function retornaTiposTransacoes()
    {   $connORA  =   $this->consulta;
        $sql = "   SELECT CCT.CCTCODIGO,
                          CCT.CCTDESCRICAO
                     FROM DAVO.COBAN_CODIGOSTRANSACOES CCT
                     ORDER BY 1 
               ";
        
        $stid    = oci_parse($connORA, $sql);
        oci_execute($stid);
        return($stid);

    }        

    public function retornaEstadosTransacoes()
    {   $connORA  =   $this->consulta;
        $sql = "   SELECT CET.CETCODIGO,
                         CET.CETDESCRICAO
                    FROM DAVO.COBAN_ESTADOSTRANSACOES CET
               ";
        
        $stid    = oci_parse($connORA, $sql);
        oci_execute($stid);
        return($stid);

    }     
    /*
     * 
     */
    
    public function retornaTransacoesCB($Loja,$Status,$CodTransacao,$EstTransacao,$DataCI,$DataCF,$DataMI,$DataMF,$QtdeReg)
    {
        $connORA  =   $this->consulta;
        $sql    =   " SELECT 
                              CRTLoja             ,
                              CRTPDV              ,
                              CRTNSUSitef         ,
                              CRTNSUGCB           ,
                              CRTAutChave         ,
                              CRTEstadoTrans      ,
                              CRTCodigoTrans      ,
                              CRTCodigoResposta   ,
                              CRTCodigoErro       ,
                              CRTSeqErros         ,
                              to_char(CRTDataContabil,'DD/MM/YYYY')     CRTDataContabil  ,
                              to_char(CRTDataMovto,'DD/MM/YYYY')    CRTDataMovto    ,
                              CRTHorario          ,
                              CRTDocCancelado     ,
                              CRTCodigoBarras     ,
                              CRTValor            ,
                              CRTFormaPAgamento   ,
                              CRTCodigoMC7        ,
                              CRTNomeCedente      ,
                              CRTStatus           ,
                              CCT.CCTDESCRICAO    ,
                              CSC.CSCDESCRICAO    ,
                              CET.CETDESCRICAO
                        FROM DAVO.COBAN_TRANSACOES CRT
                        JOIN DAVO.COBAN_CodigosTransacoes CCT ON ( CCT.CCTCODIGO = CRT.CRTCODIGOTRANS )                        
                        JOIN DAVO.COBAN_STATUSCONCILIACAO CSC ON ( CSC.CSCCODIGO = CRT.CRTSTATUS      )
                        JOIN DAVO.COBAN_ESTADOSTRANSACOES CET ON ( CET.CETCODIGO = CRT.CRTESTADOTRANS ) 
                      WHERE 1 = 1
                        "
        ;
        if(!empty($Loja))
            $sql .= "  AND 10*CRT.CRTLoja+RMS.DAC(CRT.CRTLoja) =  ".$Loja;
        if ((!empty($Status)) && ($Status!="999"))
            $sql .= "  AND CRT.CRTStatus = ".$Status;
        if(!empty($CodTransacao))
            $sql .= "  AND CRT.CRTCodigoTrans = ".$CodTransacao;
        if(!empty($EstTransacao))            
            $sql .= "  AND CRT.CRTESTADOTRANS = ".$EstTransacao;
        if(!empty($DataCI))
            $sql .= "  AND to_date(CRT.CRTDataContabil) >= to_date('".$DataCI."','DD/MM/YYYY','nls_date_language = PORTUGUESE')";
        if(!empty($DataCF))
            $sql .= "  AND to_date(CRT.CRTDataContabil) <= to_date('".$DataCF."','DD/MM/YYYY','nls_date_language = PORTUGUESE')";
        if(!empty($DataMI))
            $sql .= "  AND to_date(CRT.CRTDataMovto) >= to_date('".$DataMI."','DD/MM/YYYY','nls_date_language = PORTUGUESE')";
        if(!empty($DataMF))
            $sql .= "  AND to_date(CRT.CRTDataMovto) <= to_date('".$DataMF."','DD/MM/YYYY','nls_date_language = PORTUGUESE')";            
        if(!empty($QtdeReg))
            $sql .= "  AND ROWNUM <= ".$QtdeReg ;            
        
        $sql .= " ORDER BY  CRTDataContabil, CRTLoja , CRTPDV , CRTDataMovto, CRTHorario";
        //echo $sql;
        
        $stid    = oci_parse($connORA, $sql);
        oci_execute($stid);
        return($stid);
        
        
    }
    
    public function retornaResumoTransacoesCB($Loja,$Status,$CodTransacao,$DataCI,$DataCF,$DataMI,$DataMF,$QtdeReg)
    {
        $connORA  =   $this->consulta;
        $sql    =   "   SELECT  to_char(CRTDataContabil,'DD/MM/YYYY')  DataContabil  ,
                                CSC.CSCCODIGO ||'-'|| CSC.CSCDESCRICAO Status ,
                                count(1) Qtde,
                                sum(CRTValor) Valor
                          FROM DAVO.COBAN_TRANSACOES CRT
                          JOIN DAVO.COBAN_STATUSCONCILIACAO CSC ON ( CSC.CSCCODIGO = CRT.CRTSTATUS      )
                        "
        ;
        if(!empty($Loja))
            $sql .= "  AND 10*CRT.CRTLoja+RMS.DAC(CRT.CRTLoja) =  ".$Loja;
        if(!empty($Status))
            $sql .= "  AND CRT.CRTStatus = ".$Status;
        if(!empty($CodTransacao))
            $sql .= "  AND CRT.CRTCodigoTrans = ".$CodTransacao;
        if(!empty($DataCI))
            $sql .= "  AND to_date(CRT.CRTDataContabil) >= to_date('".$DataCI."','DD/MM/YYYY','nls_date_language = PORTUGUESE')";
        if(!empty($DataCF))
            $sql .= "  AND to_date(CRT.CRTDataContabil) <= to_date('".$DataCF."','DD/MM/YYYY','nls_date_language = PORTUGUESE')";
        if(!empty($DataMI))
            $sql .= "  AND to_date(CRT.CRTDataMovto) >= to_date('".$DataMI."','DD/MM/YYYY','nls_date_language = PORTUGUESE')";
        if(!empty($DataMF))
            $sql .= "  AND to_date(CRT.CRTDataMovto) <= to_date('".$DataMF."','DD/MM/YYYY','nls_date_language = PORTUGUESE')";            
        if(!empty($QtdeReg))
            $sql .= "  AND ROWNUM <= ".$QtdeReg ;            
        

        $sql .= "      GROUP BY to_char(CRTDataContabil,'DD/MM/YYYY')  ,
                                CSC.CSCCODIGO ||'-'|| CSC.CSCDESCRICAO 
                         ORDER BY to_char(CRTDataContabil,'DD/MM/YYYY'),CSC.CSCCODIGO ||'-'|| CSC.CSCDESCRICAO         ";

        //echo $sql;
        $stid    = oci_parse($connORA, $sql);
        oci_execute($stid);
        return($stid);
        
        
    }

    public function retornaDetalheCB($CRTLOJA, $CRTPDV, $CRTNSUSITEF, $CRTNSUGCB, $CRTAUTCHAVE, $CRTDATACONTABIL)
    {
        $connORA  =   $this->consulta;
        $sql    =   " SELECT 
                              CRTLoja             ,
                              CRTPDV              ,
                              CRTNSUSitef         ,
                              CRTNSUGCB           ,
                              CRTAutChave         ,
                              CRTEstadoTrans      ,
                              CRTCodigoTrans      ,
                              CRTCodigoResposta   ,
                              CRTCodigoErro       ,
                              CRTSeqErros         ,
                              to_char(CRTDataContabil,'DD/MM/YYYY')     CRTDataContabil  ,
                              to_char(CRTDataMovto,'DD/MM/YYYY')    CRTDataMovto    ,
                              CRTHorario          ,
                              CRTDocCancelado     ,
                              CRTCodigoBarras     ,
                              CRTValor            ,
                              CRTFormaPAgamento   ,
                              CRTCodigoMC7        ,
                              CRTNomeCedente      ,
                              CRTStatus           ,
                              CCT.CCTDESCRICAO    ,
                              CSC.CSCDESCRICAO    ,
                              CET.CETDESCRICAO    ,
                              CFP.CFPFORMA
                        FROM DAVO.COBAN_TRANSACOES CRT
                        JOIN DAVO.COBAN_CodigosTransacoes CCT ON ( CCT.CCTCODIGO = CRT.CRTCODIGOTRANS )                        
                        JOIN DAVO.COBAN_STATUSCONCILIACAO CSC ON ( CSC.CSCCODIGO = CRT.CRTSTATUS      )
                        JOIN DAVO.COBAN_ESTADOSTRANSACOES CET ON ( CET.CETCODIGO = CRT.CRTESTADOTRANS ) 
                        JOIN DAVO.COBAN_FORMASPAGAMENTO   CFP ON ( CFP.CFPCODIGO = CRT.CRTFORMAPAGAMENTO )
                         WHERE CRTLOJA               = $CRTLOJA
                           AND CRTPDV                = $CRTPDV
                           AND CRTNSUSITEF           = $CRTNSUSITEF
                           AND CRTNSUGCB             = $CRTNSUGCB
                           AND CRTAUTCHAVE           = $CRTAUTCHAVE
                           AND to_date(CRT.CRTDATACONTABIL) >= to_date('$CRTDATACONTABIL','DD/MM/YYYY','nls_date_language = PORTUGUESE')"
        ;
        
        //echo $sql;
        
        $stid    = oci_parse($connORA, $sql);
        oci_execute($stid);
        return($stid);
        
        
    }
    
    
    public function retornaEspelhoBB($Loja,$Status,$CodTransacao,$DataCI,$DataCF,$DataMI,$DataMF,$QtdeReg)
    {
        $connORA  =   $this->consulta;
        $sql    =   " 
                    SELECT  to_char(CEB.CEBDATAARQUIVO,'DD/MM/YYYY') CEBDATAARQUIVO  ,
                            CEB.CEBCODIGOCLIENTE ,
                            CEB.CEBREMESSATO     ,
                            CEB.CEBBANCO         ,
                            to_char(CEB.CEBDATATRANS,'DD/MM/YYYY')  CEBDATATRANS   ,
                            CEB.CEBAGENCIA       ,
                            CEB.CEBOPERADOR      ,
                            CEB.CEBSEQUENCIAL    ,
                            CEB.CEBCODIGOTRANS   ,
                            to_char(CEB.CEBDATAMOVTO,'DD/MM/YYYY')   CEBDATAMOVTO  ,
                            CEB.CEBHORATRANS     ,
                            CEB.CEBVALOR         ,
                            CEB.CEBLOJA          ,
                            CEB.CEBPDV           ,
                            CEB.CEBAREALIVRE     ,
                            CEB.CEBSTATUS        ,
                            CCT.CCTDESCRICAO     ,
                            CSC.CSCDESCRICAO
                       FROM DAVO.COBAN_ESPELHOBB CEB        
                       JOIN DAVO.COBAN_CODIGOSTRANSACOES   CCT ON ( CCT.CCTCODIGO = CEB.CEBCODIGOTRANS )                       
                       JOIN DAVO.COBAN_STATUSCONCILIACAO   CSC ON ( CSC.CSCCODIGO = CEB.CEBSTATUS      )
                      WHERE 1 = 1
                        "
        ;
        
        if(!empty($Loja))
            $sql .= "  AND 10*CEB.CEBLOJA+RMS.DAC(CEB.CEBLOJA) =  ".$Loja;
        if ((!empty($Status)) && ($Status!="999"))
            $sql .= "  AND CEB.CEBSTATUS = ".$Status;
        if(!empty($CodTransacao))
            $sql .= "  AND CEB.CEBCODIGOTRANS = ".$CodTransacao;
        if(!empty($DataCI))
            $sql .= "  AND to_date(CEB.CEBDATAMOVTO) >= to_date('".$DataCI."','DD/MM/YYYY','nls_date_language = PORTUGUESE')";
        if(!empty($DataCF))
            $sql .= "  AND to_date(CEB.CEBDATAMOVTO) <= to_date('".$DataCF."','DD/MM/YYYY','nls_date_language = PORTUGUESE')";
        if(!empty($DataMI))
            $sql .= "  AND to_date(CEB.CEBDATATRANS) >= to_date('".$DataMI."','DD/MM/YYYY','nls_date_language = PORTUGUESE')";
        if(!empty($DataMF))
            $sql .= "  AND to_date(CEB.CEBDATATRANS) <= to_date('".$DataMF."','DD/MM/YYYY','nls_date_language = PORTUGUESE')";            
        if(!empty($QtdeReg))
            $sql .= "  AND ROWNUM <= ".$QtdeReg ;   
        
        
        $sql .= " ORDER BY  CEB.CEBDATATRANS, CEB.CEBLOJA , CEB.CEBPDV , CEB.CEBDATAMOVTO, CEB.CEBHORATRANS";
        //echo $sql;
        $stid    = oci_parse($connORA, $sql);
        oci_execute($stid);
        return($stid);
        
        
    }

        public function retornaResumoEspelhoBB($Loja,$Status,$CodTransacao,$DataCI,$DataCF,$DataMI,$DataMF)
    {
        $connORA  =   $this->consulta;
        $sql    =   " 
                        SELECT to_char(CEB.CEBDATAMOVTO,'DD/MM/YYYY') DataContabil  ,
                               CSC.CSCCODIGO ||'-'|| CSC.CSCDESCRICAO Status ,
                               count(1) Qtde,
                               sum(CEB.CEBVALOR) Valor     
                          FROM DAVO.COBAN_ESPELHOBB CEB        
                          JOIN DAVO.COBAN_STATUSCONCILIACAO   CSC ON ( CSC.CSCCODIGO = CEB.CEBSTATUS      )  

                    "
        ;
        
        if(!empty($Loja))
            $sql .= "  AND 10*CEB.CEBLOJA+RMS.DAC(CEB.CEBLOJA) =  ".$Loja;
        if(!empty($Status))
            $sql .= "  AND CEB.CEBSTATUS = ".$Status;
        if(!empty($CodTransacao))
            $sql .= "  AND CEB.CEBCODIGOTRANS = ".$CodTransacao;
        if(!empty($DataCI))
            $sql .= "  AND to_date(CEB.CEBDATAMOVTO) >= to_date('".$DataCI."','DD/MM/YYYY','nls_date_language = PORTUGUESE')";
        if(!empty($DataCF))
            $sql .= "  AND to_date(CEB.CEBDATAMOVTO) <= to_date('".$DataCF."','DD/MM/YYYY','nls_date_language = PORTUGUESE')";
        if(!empty($DataMI))
            $sql .= "  AND to_date(CEB.CEBDATATRANS) >= to_date('".$DataMI."','DD/MM/YYYY','nls_date_language = PORTUGUESE')";
        if(!empty($DataMF))
            $sql .= "  AND to_date(CEB.CEBDATATRANS) <= to_date('".$DataMF."','DD/MM/YYYY','nls_date_language = PORTUGUESE')";            
        
        
        
        $sql .= "     GROUP BY to_char(CEB.CEBDATAMOVTO,'DD/MM/YYYY')   ,
                               CSC.CSCCODIGO ||'-'|| CSC.CSCDESCRICAO
                      ORDER BY 1,2    ";
        //echo $sql;
        $stid    = oci_parse($connORA, $sql);
        oci_execute($stid);
        return($stid);
        
        
    }

    public function retornaDetalheBB($CEBDATAARQUIVO, $CEBCODIGOCLIENTE, $CEBREMESSATO, $CEBBANCO, $CEBDATATRANS, $CEBAGENCIA, $CEBOPERADOR, $CEBSEQUENCIAL, $CEBCODIGOTRANS)
    {   // indice unico CEBDATAARQUIVO, CEBCODIGOCLIENTE, CEBREMESSATO, CEBBANCO, CEBDATATRANS, CEBAGENCIA, CEBOPERADOR, CEBSEQUENCIAL, CEBCODIGOTRANS
        
        $connORA  =   $this->consulta;
        $sql    =   " 
                    SELECT  to_char(CEB.CEBDATAARQUIVO,'DD/MM/YYYY') CEBDATAARQUIVO  ,
                            CEB.CEBCODIGOCLIENTE ,
                            CEB.CEBREMESSATO     ,
                            CEB.CEBBANCO         ,
                            to_char(CEB.CEBDATATRANS,'DD/MM/YYYY')  CEBDATATRANS   ,
                            CEB.CEBAGENCIA       ,
                            CEB.CEBOPERADOR      ,
                            CEB.CEBSEQUENCIAL    ,
                            CEB.CEBCODIGOTRANS   ,
                            to_char(CEB.CEBDATAMOVTO,'DD/MM/YYYY')   CEBDATAMOVTO  ,
                            CEB.CEBHORATRANS     ,
                            CEB.CEBVALOR         ,
                            CEB.CEBLOJA          ,
                            CEB.CEBPDV           ,
                            CEB.CEBAREALIVRE     ,
                            CEB.CEBSTATUS        ,
                            CSC.CSCDESCRICAO     ,
                            CCT.CCTDESCRICAO     ,
                            CCB.CCBCODIGO                                    
                           FROM DAVO.COBAN_ESPELHOBB CEB

                          JOIN DAVO.COBAN_STATUSCONCILIACAO   CSC ON ( CSC.CSCCODIGO = CEB.CEBSTATUS      )
                          JOIN DAVO.COBAN_CODIGOSTRANSACOES   CCT ON ( CCT.CCTCODIGO = CEB.CEBCODIGOTRANS )
                          JOIN DAVO.COBAN_CODIGOSTRANSACOESBB CCB ON ( CCB.CCBESTADO = CCT.CCTESTADO      )
                          WHERE to_date(CEB.CEBDATAARQUIVO) = to_date('$CEBDATAARQUIVO','DD/MM/YYYY','nls_date_language = PORTUGUESE')                          
                            AND CEB.CEBCODIGOCLIENTE        = '$CEBCODIGOCLIENTE'
                            AND CEB.CEBREMESSATO            =  $CEBREMESSATO
                            AND CEB.CEBBANCO                = '$CEBBANCO'
                            AND to_date(CEB.CEBDATATRANS)   = to_date('$CEBDATATRANS','DD/MM/YYYY','nls_date_language = PORTUGUESE')   
                            AND CEB.CEBAGENCIA              = $CEBAGENCIA
                            AND CEB.CEBOPERADOR             = '$CEBOPERADOR'
                            AND CEB.CEBSEQUENCIAL           = $CEBSEQUENCIAL
                            AND CEB.CEBCODIGOTRANS          = $CEBCODIGOTRANS
                        "
       ;
        
        
        //echo $sql ;
        $stid    = oci_parse($connORA, $sql);
        oci_execute($stid);
        return($stid);
        
        
    }    

   public function conciliacaoManual($Loja,$PDV,$Sequencial,$CodTransacao,$Data,$Valor)
    {
        $connORA  =   $this->consulta;

        /*
        $Loja = 2 ;
        $PDV  = 38 ;
        $Sequencial = 3 ;
        $CodTransacao = 6 ;
         * */
         
        //$Data = '05/11/2012';
        //$Valor = 126.28;
        
       // Call database procedure...
       $in_var = 10;
       $sql = oci_parse($connORA, "begin DAVO.PCCOBAN.spConciliaManual(:Loja,:PDV,:Seq,:codT,:Dta,:Valor,:Retorno); end;");
       oci_bind_by_name($sql, ":Loja"  , $Loja);
       oci_bind_by_name($sql, ":PDV"   , $PDV);
       oci_bind_by_name($sql, ":Seq"   , $Sequencial);
       oci_bind_by_name($sql, ":codT"  , $CodTransacao);
       oci_bind_by_name($sql, ":Dta"   , $Data);
       oci_bind_by_name($sql, ":Valor" , number_format($Valor, 2, '.', ''));
       
       
   oci_bind_by_name($sql, ":Retorno", $out_var, 32); // 32 is the return length
   oci_execute($sql, OCI_DEFAULT);

 
   // Logoff from Oracle...
   oci_free_statement($s);
   oci_close($connORA);
   
       // $sql    =   " begin DAVO.PCCOBAN.FNCONCILIAMANUAL ( 2 , 38 , 3 , 6 , to_date('05/11/2012','DD/MM/YYYY','nls_date_language = PORTUGUESE') , 126.28 ); END ; " ;
            


//        echo $sql;
//        $stid    = oci_parse($connORA, $sql);
//        oci_execute($stid);
        return($out_var);
    }
    
    
    
}
 ?>
