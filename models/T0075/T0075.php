<?php


///**************************************************************************
//                Intranet - DAVÓ SUPERMERCADOS
// * Criado em: 18/10/2011 por Roberta Schimidt                               
// * Descrição: Tela Conferir totais
// * Entrada:   
// * Origens:   
//           
//**************************************************************************
//*/
//
//
class models_T0075 extends models
{

    public function __construct($conn,$verificaConexao,$db)
    {
        parent::__construct($conn,$verificaConexao,$db);
    }
    
    
    public function retornaPagEmporium($dataini, $datafim, $loja)
 
    {
        if (($loja == "0")or ($loja == "")){
        
      
                $sql = " select sum(amount_due) as ValorEmp
                       ,store_key
                       ,pos_number 
                       ,count(*) as QtdEmp
                from  sale
                where 
                fiscal_date = '$dataini' 
                and  sale_type = 14   
                and void_ticket_number is null
                group by store_key, pos_number "; } else {
                    
                     $sql = " select sum(amount_due) as ValorEmp
                       ,store_key
                       ,pos_number 
                       ,count(*) as QtdEmp
                from  sale
                where 
                fiscal_date = '$dataini' 
                and store_key = '$loja'
                and  sale_type = 14 
                and  void_ticket_number IS NULL
                group by store_key, pos_number "; 
                    
                }

//echo $sql."<br>";
     
        return $this->query($sql);                                                              
        
    }
    
    public function inserirDadosTempPag($data) 
    {
        
        $connMSSQL = $this->consulta;
        
       $sql = "IF object_id('tempdb..#tempPagTotais') IS NOT NULL 
                BEGIN DROP TABLE #tempPagTotais END 

            CREATE TABLE #tempPagTotais(LOJA CHAR(3),PDV CHAR(3), QTD_PAG CHAR(5), VALOR_PAG MONEY, QTD_CAN CHAR(5), VALOR_CAN MONEY, DATA DATETIME )
        
            INSERT INTO #tempPagTotais 
            
            SELECT   substring(a.DSC_LOCAL_PAG,1,3)     as       'LOJA'
                    ,substring(a.DSC_LOCAL_PAG,4,3)     as       'PDV'
                    ,count(case when a.DAT_CAN IS  NULL   THEN a.VAL_PAG  ELSE 0 END)     AS  'QTD_PAG'			
                    ,sum(case when a.DAT_CAN is null  then  a.VAL_PAG ELSE 0 END)       AS  'VAL_PAG'		
                    ,sum(case when COD_FUNC_CAN <> '0'  then  1 ELSE 0 END)             as  'CAN_QTD'	
                    ,sum(case when a.DAT_CAN is NOT  null   AND NUM_PDV_CAN = NUM_PDV_PAG THEN  a.VAL_PAG ELSE 0 END)     'VAL_CAN'
                    ,CONVERT(VARCHAR(10), a.DAT_PAG, 101)                               AS  'DATA'
              FROM  dbo.ACERTO_PAG_PARCELAS_CTR_0140T a (NOLOCK) 
              WHERE a.DAT_PAG >= CONVERT(VARCHAR(10), '$data', 101) 
                AND a.DAT_PAG < CONVERT(VARCHAR(10), DATEADD(DAY,1,'$data' ) , 101) 
                AND a.TIP_LOCAL_PAG_PARC_CTR	=	0
              
           GROUP BY   convert(char(10),a.DAT_PAG,103)
                    , substring(a.DSC_LOCAL_PAG,1,3)
                    , substring(a.DSC_LOCAL_PAG,4,3)
                    , CONVERT(VARCHAR(10), a.DAT_PAG, 101) 
           ORDER BY   convert(char(10),a.DAT_PAG,103)
                    , substring(a.DSC_LOCAL_PAG,1,3), substring(a.DSC_LOCAL_PAG,4,3)";
     
//    echo $sql;
       
                           $stid = mssql_query($sql, $connMSSQL);
                         return $stid;
       
        
    }
    
    
    public function retornaPagEMS($dataini, $datafim, $loja, $pdv)
    {
        
        $connMSSQL = $this->consulta;
        
        $sql = "SELECT      LOJA
                           ,PDV
                           ,QTD_PAG
                           ,VALOR_PAG
                           ,QTD_CAN
                           ,VALOR_CAN
                           ,DATA
                  FROM      #tempPagTotais
                 WHERE      LOJA        =       $loja
                   AND      PDV         =       $pdv
                   AND      DATA        >=	CONVERT(VARCHAR(10), '$dataini', 101)	
                   AND      DATA        <       CONVERT(VARCHAR(10), DATEADD(DAY,1,'$dataini' ) , 101)";
        
                       //echo $sql."<br>";
        
        $stid = mssql_query($sql, $connMSSQL);
     
        
        return $stid;
        
       
    }
    
    public function retornaVendaEms($dataini,$loja,$tipVenda, $pdv)
    {
        $connMSSQL = $this->consulta;
        
        if(($loja == "0") or ($loja == "")){
            
             if($tipVenda == "1"){
        
        $sql = "SELECT
                    a.COD_LOCAL_CTR			as	'LOJA',
                    a.NUM_PDV				as	'PDV',
                    count(*)				as	'QUANTIDADE',
                    sum(a.VAL_FINANC)		as	'VALOR'
                FROM DBO_CRE.dbo.CONTRATOS_COP_0014T			a	(NOLOCK)
                WHERE
                    a.DAT_INC_CTR_SEM_HORA	>= CONVERT(VARCHAR(10), '$dataini', 101)	
                    AND a.DAT_INC_CTR_SEM_HORA	<  CONVERT(VARCHAR(10), DATEADD(DAY,1,'$dataini' ) , 101) 
                    and a.IND_LIMITE <> 'P'
                    AND a.NUM_PDV > 0
                    AND a.NUM_PDV = $pdv
                    and a.COD_TIP_CONVENIO is null
                    AND COD_FUNC_APR = '0'
                    and  a.COD_CAN_CTR in ('0', '907')  
                GROUP BY
                    a.DAT_INC_CTR_SEM_HORA,
                    a.COD_LOCAL_CTR,
                    a.NUM_PDV
                ORDER BY
                    a.DAT_INC_CTR_SEM_HORA,
                    a.COD_LOCAL_CTR,
                    a.NUM_PDV ";}
                    
                    
                    elseif($tipVenda == "3") {

            $sql =" SELECT
                        a.COD_LOCAL_CTR			as	'LOJA',
                        a.NUM_PDV				as	'PDV',
                        count(*)				as	'QUANTIDADE',
                        sum(a.VAL_FINANC)		as	'VALOR'
                    FROM
                        DBO_CRE.dbo.CONTRATOS_COP_0014T			a	(NOLOCK)
                    WHERE
                                a.DAT_INC_CTR_SEM_HORA	>=	CONVERT(VARCHAR(10), '$dataini', 101)
                        and     a.DAT_INC_CTR_SEM_HORA   <      CONVERT(VARCHAR(10), DATEADD(DAY,1,'$dataini' ) , 101)
                        and     a.COD_TIP_CONVENIO		=	2
                        AND a.NUM_PDV = $pdv
                       
                 GROUP BY
                        a.DAT_INC_CTR_SEM_HORA,
                        a.COD_LOCAL_CTR,
                        a.NUM_PDV ";
            
                    } elseif($tipVenda == "4") {
                      
            $sql =" SELECT
                        a.COD_LOCAL_CTR			as	'LOJA',
                        a.NUM_PDV				as	'PDV',
                        count(*)				as	'QUANTIDADE',
                        sum(a.VAL_FINANC)		as	'VALOR'
                    FROM
                        DBO_CRE.dbo.CONTRATOS_COP_0014T			a	(NOLOCK)
                    WHERE
                                a.DAT_INC_CTR_SEM_HORA	>=	CONVERT(VARCHAR(10), '$dataini', 101)
                        and     a.DAT_INC_CTR_SEM_HORA   <      CONVERT(VARCHAR(10), DATEADD(DAY,1,'$dataini' ) , 101)
                        and     a.COD_TIP_CONVENIO		=	1
                        AND     a.NUM_PDV = $pdv
                        and     a.DAT_CAN_CTR IS NULL
                       
                 GROUP BY
                        a.DAT_INC_CTR_SEM_HORA,
                        a.COD_LOCAL_CTR,
                        a.NUM_PDV ";  
                        
                        
                    } elseif ($tipVenda == "2")  {
                        
                        $sql =" SELECT
                        a.COD_LOCAL_CTR			as	'LOJA',
                        a.NUM_PDV				as	'PDV',
                        count(*)				as	'QUANTIDADE',
                        sum(a.VAL_FINANC)		as	'VALOR'
                    FROM
                        DBO_CRE.dbo.CONTRATOS_COP_0014T			a	(NOLOCK)
                    WHERE
                                a.DAT_INC_CTR_SEM_HORA	>=	CONVERT(VARCHAR(10), '$dataini', 101)
                        and     a.DAT_INC_CTR_SEM_HORA   <      CONVERT(VARCHAR(10), DATEADD(DAY,1,'$dataini' ) , 101)
                        and     a.IND_LIMITE = 'P'
                        and     a.NUM_PDV >= '1'
                        AND a.NUM_PDV = $pdv
                        AND COD_FUNC_APR = 0
                        and     a.DAT_CAN_CTR_SEM_HORA is null 
                        and  a.COD_CAN_CTR in ('0', '907')  
                        
       
                 GROUP BY
                         a.COD_LOCAL_CTR,
                        a.NUM_PDV
                 ORDER BY 
                         a.COD_LOCAL_CTR"; 
                        
                        
                    } else {
                        
                  $sql = " SELECT a.COD_LOCAL_CTR as 'LOJA'
                                , a.NUM_PDV as 'PDV'
                                , count(*) as 'QUANTIDADE'
                                , sum(a.VAL_FINANC) as 'VALOR' 
                           FROM DBO_CRE.dbo.CONTRATOS_COP_0014T a (NOLOCK) 
                           WHERE a.DAT_INC_CTR_SEM_HORA >= CONVERT(VARCHAR(10), '$dataini', 101)
                                 AND a.DAT_INC_CTR_SEM_HORA < CONVERT(VARCHAR(10), DATEADD(DAY,1,'$dataini' ) , 101) 
                                AND a.NUM_PDV > 0
                                AND a.NUM_PDV = '$pdv'
                                and COD_FUNC_APR = '999'
                                GROUP BY a.DAT_INC_CTR_SEM_HORA, a.COD_LOCAL_CTR, a.NUM_PDV 
                                ORDER BY a.DAT_INC_CTR_SEM_HORA, a.COD_LOCAL_CTR, a.NUM_PDV";
                        
                        
                    }
        } else {
        
        if($tipVenda == "1"){
        
        $sql = "SELECT
                    a.COD_LOCAL_CTR			as	'LOJA',
                    a.NUM_PDV				as	'PDV',
                    count(*)				as	'QUANTIDADE',
                    sum(a.VAL_FINANC)		as	'VALOR'
                FROM DBO_CRE.dbo.CONTRATOS_COP_0014T			a	(NOLOCK)
                WHERE
                    a.DAT_INC_CTR_SEM_HORA	>= CONVERT(VARCHAR(10), '$dataini', 101)	
                    AND a.DAT_INC_CTR_SEM_HORA	<  CONVERT(VARCHAR(10), DATEADD(DAY,1,'$dataini' ) , 101) 
                    and a.IND_LIMITE <> 'P'
                    AND a.COD_LOCAL_CTR = '$loja'
                    AND a.NUM_PDV = $pdv
                    AND a.NUM_PDV > 0
                    AND COD_FUNC_APR = 0
                    and a.COD_TIP_CONVENIO is null
                    and a.COD_CAN_CTR in ('907', '0')
                    -- and TIP_ST_CONF_CTR <> 0
                    
                GROUP BY
                    a.DAT_INC_CTR_SEM_HORA,
                    a.COD_LOCAL_CTR,
                    a.NUM_PDV
                ORDER BY
                    a.DAT_INC_CTR_SEM_HORA,
                    a.COD_LOCAL_CTR,
                    a.NUM_PDV "; }
                    
                    elseif($tipVenda == "3") {

            $sql =" SELECT
                        a.COD_LOCAL_CTR			as	'LOJA',
                        a.NUM_PDV				as	'PDV',
                        count(*)				as	'QUANTIDADE',
                        sum(a.VAL_FINANC)		as	'VALOR'
                    FROM
                        DBO_CRE.dbo.CONTRATOS_COP_0014T			a	(NOLOCK)
                    WHERE
                                a.DAT_INC_CTR_SEM_HORA	>=	CONVERT(VARCHAR(10), '$dataini', 101)
                        and     a.DAT_INC_CTR_SEM_HORA   <      CONVERT(VARCHAR(10), DATEADD(DAY,1,'$dataini' ) , 101)
                        and     a.COD_TIP_CONVENIO		=	2
                        and     a.COD_LOCAL_CTR  = '$loja'     
                        AND a.NUM_PDV = $pdv
                 GROUP BY
                        a.DAT_INC_CTR_SEM_HORA,
                        a.COD_LOCAL_CTR,
                        a.NUM_PDV ";
                    } elseif($tipVenda == "4") {
                      
            $sql =" SELECT
                        a.COD_LOCAL_CTR			as	'LOJA',
                        a.NUM_PDV				as	'PDV',
                        count(*)				as	'QUANTIDADE',
                        sum(a.VAL_FINANC)		as	'VALOR'
                    FROM
                        DBO_CRE.dbo.CONTRATOS_COP_0014T			a	(NOLOCK)
                    WHERE
                                a.DAT_INC_CTR_SEM_HORA	>=	CONVERT(VARCHAR(10), '$dataini', 101)
                        and     a.DAT_INC_CTR_SEM_HORA   <      CONVERT(VARCHAR(10), DATEADD(DAY,1,'$dataini' ) , 101)
                        and     a.COD_TIP_CONVENIO		=	1
                        and     a.COD_LOCAL_CTR  = '$loja'  
                        AND     a.NUM_PDV = $pdv
                        and     a.DAT_CAN_CTR IS NULL
                        
                 GROUP BY
                        a.DAT_INC_CTR_SEM_HORA,
                        a.COD_LOCAL_CTR,
                        a.NUM_PDV ";  
                        
                        
                    } elseif ($tipVenda == "2") {
                        
                        $sql =" SELECT
                        a.COD_LOCAL_CTR			as	'LOJA',
                        a.NUM_PDV				as	'PDV',
                        count(*)				as	'QUANTIDADE',
                        sum(a.VAL_FINANC)		as	'VALOR'
                    FROM
                        DBO_CRE.dbo.CONTRATOS_COP_0014T			a	(NOLOCK)
                    WHERE
                                a.DAT_INC_CTR_SEM_HORA	>=	CONVERT(VARCHAR(10), '$dataini', 101)
                        and     a.DAT_INC_CTR_SEM_HORA   <      CONVERT(VARCHAR(10), DATEADD(DAY,1,'$dataini' ) , 101)
                        and     a.IND_LIMITE = 'P'
                        and     a.COD_LOCAL_CTR  = '$loja'
                        AND a.NUM_PDV = $pdv
                        and     a.NUM_PDV >= '1'
                        and     a.DAT_CAN_CTR_SEM_HORA is null 
                        and  a.COD_CAN_CTR in ('0', '907')  
                        AND COD_FUNC_APR = 0
                        
       
                 GROUP BY
                        
                        a.COD_LOCAL_CTR,
                        a.NUM_PDV"; 
                        
                        
                    } else {
                        
                         $sql = " SELECT a.COD_LOCAL_CTR as 'LOJA'
                                , a.NUM_PDV as 'PDV'
                                , count(*) as 'QUANTIDADE'
                                , sum(a.VAL_FINANC) as 'VALOR' 
                           FROM DBO_CRE.dbo.CONTRATOS_COP_0014T a (NOLOCK) 
                           WHERE a.DAT_INC_CTR_SEM_HORA >= CONVERT(VARCHAR(10), '$dataini', 101)
                                 AND a.DAT_INC_CTR_SEM_HORA < CONVERT(VARCHAR(10), DATEADD(DAY,1,'$dataini' ) , 101) 
                                AND a.NUM_PDV > 0
                                AND a.NUM_PDV = '$pdv'
                                AND COD_FUNC_APR = '999'
                                and a.COD_LOCAL_CTR = '$loja'
                                GROUP BY a.DAT_INC_CTR_SEM_HORA, a.COD_LOCAL_CTR, a.NUM_PDV 
                                ORDER BY a.DAT_INC_CTR_SEM_HORA, a.COD_LOCAL_CTR, a.NUM_PDV";
                        
                    }
        
        
        }   
           
        
       // echo $sql."<br>";

        
  
        $stid = mssql_query($sql, $connMSSQL);
        return $stid;
        
        
    }
        
    
    public function retornaVendaEmporium($dataini, $tipVenda, $loja )
    {
        
        if(($loja == "Selecione...")or($loja == "") or ($loja == "0")){
            
            if($tipVenda == "1"){
                
                          $sql = "SELECT sum(amount) as valor
                                        , sum(amount_canc) as valorCan
                                        , store_key as loja
                                        , pos_number as pdv
                                        , quantity as qtd
                                        , quantity_canc as qtdCan
                                    FROM accum_media
                                    WHERE media_id = '11'
                                        and fiscal_date = '$dataini'
                                        and pos_number <> 0
                                    GROUP BY store_key, pos_number";
                          
            } elseif ($tipVenda == "2"){
                
                
                $sql = "CALL sp_BuscaVendaParcelada('$dataini')";

            
            } elseif($tipVenda == "3"){
                
                   $sql="SELECT sum(amount) as valor
                                        , sum(amount_canc) as valorCan
                                        , store_key as loja
                                        , pos_number as pdv
                                        , quantity as qtd
                                        , quantity_canc as qtdCan
                                    FROM accum_media
                                    WHERE media_id = '13'
                                        and fiscal_date = '$dataini'
                                        and pos_number <> 0
                                    GROUP BY store_key, pos_number";
           
                   } elseif ($tipVenda == "4") {
                
                $sql="SELECT quantity as qtd
                          ,amount as valor
                          ,quantity_canc as qtdCan
                          , store_key as loja
                          , pos_number as pdv
                          ,(SELECT SUM(amount_canc)
                            FROM 
                                accum_media
                            WHERE 
                                 fiscal_date = '$dataini'
                                 and media_id =  '23') as valorCan
                    FROM
                          accum_media
                    WHERE
                         fiscal_date = '$dataini'
                         and media_id =  '23'
                         and pos_number <> '0'
                    GROUP BY
                     store_key, pos_number";
                
            } else {
                
                $sql = "SELECT sum(amount) as valor
                                        , sum(amount_canc) as valorCan
                                        , store_key as loja
                                        , pos_number as pdv
                                        , quantity as qtd
                                        , quantity_canc as qtdCan
                                    FROM accum_media
                                    WHERE media_id = '7'
                                        and fiscal_date = '$dataini'
                                        and pos_number <> 0
                                    GROUP BY store_key, pos_number";
                
            }
            
        } else {
            
             if($tipVenda == "1"){
                
                          $sql = "SELECT sum(amount) as valor
                                        , sum(amount_canc) as valorCan
                                        , store_key as loja
                                        , pos_number as pdv
                                        , quantity as qtd
                                        , quantity_canc as qtdCan
                                    FROM accum_media
                                    WHERE media_id = '11'
                                        and fiscal_date = '$dataini'
                                        and pos_number <> 0
                                        and store_key = '$loja'
                                    GROUP BY store_key, pos_number";
                          
            } elseif ($tipVenda == "2"){
                
                
                $sql = "CALL sp_BuscaVendaParceladaLoja('$dataini', '$loja')";

            
            } elseif($tipVenda == "3"){
                
                   $sql="SELECT sum(amount) as valor
                                        , sum(amount_canc) as valorCan
                                        , store_key as loja
                                        , pos_number as pdv
                                        , quantity as qtd
                                        , quantity_canc as qtdCan
                                    FROM accum_media
                                    WHERE media_id = '13'
                                        and fiscal_date = '$dataini'
                                        and pos_number <> 0
                                        and store_key = '$loja'
                                    GROUP BY store_key, pos_number";
           
                   } elseif($tipVenda == "4") {
                
                $sql="SELECT quantity as qtd
                          ,amount as valor
                          ,quantity_canc as qtdCan
                          , store_key as loja
                          , pos_number as pdv
                          ,(SELECT SUM(amount_canc)
                            FROM 
                                accum_media
                            WHERE 
                                 fiscal_date = '$dataini'
                                 and store_key = '$loja'
                                 and media_id =  '23') as totalCanc
                    FROM
                          accum_media
                    WHERE
                         fiscal_date = '$dataini'
                         and media_id =  '23'
                         and store_key = '$loja'
                         and pos_number <> '0'
                    GROUP BY
                     store_key, pos_number";
                
            } else {
                
                $sql = "SELECT sum(amount) as valor
                                        , sum(amount_canc) as valorCan
                                        , store_key as loja
                                        , pos_number as pdv
                                        , quantity as qtd
                                        , quantity_canc as qtdCan
                                    FROM accum_media
                                    WHERE media_id = '7'
                                        and fiscal_date = '$dataini'
                                        and pos_number <> 0
                                        and store_key = '$loja'
                                    GROUP BY store_key, pos_number";
            }
            
            
        }
        
    //    echo $sql."</br>";
        
         return $this->query($sql);
        
    }
    
    
    
    
    public function retornaComboPag()
    {
       
        
        $sql = "SELECT * FROM T006_loja
                WHERE T006_codigo not in (0, 86, 94, 108, 116, 140, 159, 
                167, 175, 183, 191, 999) ";
        
        return $this->query($sql);
    
   }
   
    public function retornaNomeLojaPag($loja)
    {         
         if ($loja == 19)
         {
            $nLoja = "001";
            
         }
         elseif($loja == 27)
         {
            $nLoja = "002";
         }
         elseif($loja == 35)
         {
            $nLoja = "003";
         } 
         elseif($loja == 43)
         {
            $nLoja = "004";
         } 
         elseif ($loja == 51){
            $nLoja = "005";
         } 
         elseif($loja == 60){
            $nLoja = "006";
         }
         elseif($loja == 78)
         {
            $nLoja = "007";
         } 
         elseif ($loja == '124')
         {
            $nLoja = "012";
         } 
         elseif ($loja == '132') 
         {
            $nLoja = "013";
         }
         else 
         {
             $nLoja = "Selecione...";
         }

         return $nLoja;

    }
    
    public function formataReais($valor1, $valor2, $operacao)
    {
        
        //tirar , do valor
        $valor1 = str_replace(".", "", $valor1);
        $valor2 = str_replace(".", "", $valor2);
        $valor1 = str_replace(",", "", $valor1);
        $valor2 = str_replace(",", "", $valor2);
        
        //indentifica operação
        
        switch ($operacao)
        {
            
            case "+":
                $resultado =  $valor1 + $valor2;
                break;
            case "-":
                $resultado = $valor1 - $valor2;
                break;
            case "*":
                $resultado = $valor1 = $valor2;
                break;
        }
        
 
        
        return $resultado;
      
        }
        
        public function totalValoresRelatorio($resultado)
        {
            
          //calcula tamanho resultado
        
        $len = strlen($resultado);
        
        switch($len)
        {
            case "2":
                $retorna = "0,$resultado";
                break;
            case "3":
                $d1 = substr("$resultado",0,1);
                $d2 = substr("$resultado",-2,2);
                $retorna = "$d1,$d2";
               break;
            case "4":
               $d1 = substr("$resultado",0,2);
                $d2 = substr("$resultado",-2,2);
                $retorna = "$d1,$d2";
                break;
            case "5":
                $d1 = substr("$resultado",0,3);            
                $d2 = substr("$resultado",-2,2);
                $retorna = "$d1,$d2";            
                break;
            case "6":
                $d1 = substr("$resultado",1,3);            
                $d2 = substr("$resultado",-2,2);
                $d3 = substr("$resultado",0,1);
                $retorna = "$d3.$d1,$d2";
                break;
            case "7":
                $d1 = substr("$resultado",2,3);
                $d2 = substr("$resultado",-2,2);            
                $d3 = substr("$resultado",0,2);            
                $retorna = "$d3.$d1,$d2";
                break;
            case "8":
                $d1 = substr("$resultado",3,3);
                $d2 = substr("$resultado",-2,2);
                $d3 = substr("$resultado",0,3);            
                $retorna = "$d3.$d1,$d2";            
                break;
        }
        
        return $retorna;
            
        }
        
         public function totalValores($resultado)
        {
            
          //calcula tamanho resultado
        
        $len = strlen($resultado);
        
        switch($len)
        {
            case "2":
                $retorna = "0,$resultado";
                break;
            case "3":
                $d1 = substr("$resultado",0,1);
                $d2 = substr("$resultado",-2,2);
                $retorna = "$d1,$d2";
               break;
            case "4":
               $d1 = substr("$resultado",0,2);
                $d2 = substr("$resultado",-2,2);
                $retorna = "$d1,$d2";
                break;
            case "5":
                $d1 = substr("$resultado",0,3);            
                $d2 = substr("$resultado",-2,2);
                $retorna = "$d1,$d2";            
                break;
            case "6":
                $d1 = substr("$resultado",1,3);            
                $d2 = substr("$resultado",-2,2);
                $d3 = substr("$resultado",0,1);
                $retorna = "$d3$d1,$d2";
                break;
            case "7":
                $d1 = substr("$resultado",2,3);
                $d2 = substr("$resultado",-2,2);            
                $d3 = substr("$resultado",0,2);            
                $retorna = "$d3$d1,$d2";
                break;
            case "8":
                $d1 = substr("$resultado",3,3);
                $d2 = substr("$resultado",-2,2);
                $d3 = substr("$resultado",0,3);            
                $retorna = "$d3$d1,$d2";            
                break;
        }
        
        return $retorna;
            
        }
        
        public function retornaComboVend()
        {
     
            
        $sql =    "select * from T006_loja where T006_codigo not in (0, 999)";
        
          return $this->query($sql);
     
        }
           public function retornaNomeLojaVend($loja)
    {         
         if ($loja == 19)
         {
            $nLoja = "001";
         }
         elseif($loja == 27)
         {
            $nLoja = "002";
         }
         elseif($loja == 35)
         {
            $nLoja = "003";
         } 
         elseif($loja == 43)
         {
            $nLoja = "004";
         } 
         elseif ($loja == 51){
            $nLoja = "005";
         } 
         elseif($loja == 60){
            $nLoja = "006";
         }
         elseif($loja == 78)
         {
            $nLoja = "007";
         } 
           elseif($loja == 86)
         {
            $nLoja = "008";
         } 
           elseif($loja == 94)
         {
            $nLoja = "009";
         } 
           elseif($loja == '108')
         {
            $nLoja = "010";
         } 
           elseif($loja == '116')
         {
            $nLoja = "011";
         } 
         elseif ($loja == '124')
         {
            $nLoja = "012";   
         } 
         elseif($loja == '132') 
         {
            $nLoja = "013";
         }
           elseif($loja == '140')
         {
            $nLoja = "014";
         } 
           elseif($loja == '159')
         {
            $nLoja = "015";
         } 
           elseif($loja == '167')
         {
            $nLoja = "016";
         } 
         elseif($loja == '175')
         {
             $nLoja = "017";
         }
         elseif ($loja == '183') {
             
             $nLoja = "018";
         } else {
             
             $nLoja = "019";
         }

         return $nLoja;

    }
    
    public function retornaCancelEms($pdv, $loja, $dataini, $tipVenda) {
        
        $connMSSQL = $this->consulta;
        
        if ($tipVenda == '1'){
        
        $sql = "SELECT 
                    b.VAL_FINANC as 'VAL_CAN',
                    count(*) as 'QUANTIDADE'  
                from DBO_CRE.dbo.CONTRATOS_COP_0014T as b
               WHERE
                    b.DAT_INC_CTR_SEM_HORA = '$dataini'
                    and b.NUM_PDV = '$pdv'
                    and b.COD_LOCAL_CAN = '$loja'
                    and b.IND_LIMITE <> 'P'
                    and	(b.TIP_APR_CTR='0' or b.COD_TIP_CONVENIO is not null)
                    and	b.COD_LOCAL_CAN is not null 
                    group by b.COD_LOCAL_CAN,  b.VAL_FINANC, b.NUM_PDV "; } elseif($tipVenda == '2') {
                        
                    $sql = "SELECT 
                    sum(b.VAL_FINANC) as 'VAL_CAN',
                    count(*) as 'QUANTIDADE'  
                from DBO_CRE.dbo.CONTRATOS_COP_0014T as b
               WHERE
                    b.DAT_INC_CTR_SEM_HORA = '$dataini'
                    and b.NUM_PDV = '$pdv'
                    and b.COD_LOCAL_CAN = '$loja'
                    and b.IND_LIMITE = 'P'
                    and	(b.TIP_APR_CTR='0' or b.COD_TIP_CONVENIO is not null)
                    and	b.DAT_CAN_CTR_SEM_HORA is not null 
                    group by b.COD_LOCAL_CAN, b.NUM_PDV "   ; 
                        
                        
                    }
                    
              //      echo $sql ;
   
        $stid = mssql_query($sql, $connMSSQL);
        return $stid;
        
     
        
    }
    
    public function retornaCancelPagEms($pdv, $loja, $dataini, $datafim) {
        
        $connMSSQL=  $this->consulta;
        
        $sql="SELECT 
                convert(char(10),a.DAT_CAN,103)	as	'DATA',
                substring(a.DSC_LOCAL_PAG,1,3)	as	'LOJA',
                substring(a.DSC_LOCAL_PAG,4,3)	as	'PDV',
                count(*)						as	'QUANTIDADE',
                sum(a.VAL_PAG)					as	'VALOR'
            FROM
                DBO_CRE.dbo.ACERTO_PAG_PARCELAS_CTR_0140T			a	(NOLOCK)
            WHERE
                        a.DAT_PAG >=	CONVERT(VARCHAR(10), '$dataini', 101)
                and	a.DAT_PAG <	CONVERT(VARCHAR(10), DATEADD(DAY,1,'$datafim' ) , 101)
                and	a.TIP_LOCAL_PAG_PARC_CTR	=	0
                and     substring(a.DSC_LOCAL_PAG,1,3) =       '$loja'
                and     substring(a.DSC_LOCAL_PAG,4,3) = '$pdv'   
                and     a.DAT_CAN IS NOT NULL
            GROUP BY
                convert(char(10),a.DAT_CAN,103),
                substring(a.DSC_LOCAL_PAG,1,3),
                substring(a.DSC_LOCAL_PAG,4,3)";
        
       
        
            $stid = mssql_query($sql, $connMSSQL);
        return $stid;
    }
    
    public function retornaEstornoEmp($pdv, $loja, $data) {
        
        $sql = "select * from 
                    accum_media 
                    where 
                    fiscal_date = '$data' 
                    and media_id = '21'
                    and pos_number = '$pdv'
                    and quantity <> '0'
                    and store_key = '$loja'";
        

        
         return $this->query($sql);
        
    }
   
   public function retornaListarPdvPag($dataini, $datafim, $loja, $pdv) {
       
       $connMSSQL=  $this->consulta;
       
       $sql="SELECT 
                a.DAT_PAG	as	'DATA', 
                substring(a.DSC_LOCAL_PAG,1,3)	as	'LOJA',
                substring(a.DSC_LOCAL_PAG,4,3)	as	'PDV',
                a.VAL_PAG			as	'VALOR',
                c.NOM_CLIENTE			as	'NOME',
                c.CPF_CLIENTE			as	'CPF'
            FROM
                DBO_CRE.dbo.ACERTO_PAG_PARCELAS_CTR_0140T	a	(NOLOCK),
                DBO_CRE.dbo.CONTRATOS_0109T			b	(NOLOCK),
                DBO_CRE.dbo.CLIENTE_CORP_0116T			c	(NOLOCK)
           WHERE
                        a.DAT_PAG	>=	CONVERT(VARCHAR(10), '$dataini', 101)
                and	a.DAT_PAG	<	CONVERT(VARCHAR(10), DATEADD(DAY,1,'$datafim' ) , 101)
                and	cast(substring(a.DSC_LOCAL_PAG,1,3) as int)	=	$loja
                and	cast(substring(a.DSC_LOCAL_PAG,4,3) as int)	=	$pdv
                and	a.TIP_LOCAL_PAG_PARC_CTR			=	0
                and	a.COD_LOCAL_CTR					=	b.COD_LOCAL_CTR
                and	a.NUM_CTR					=	b.NUM_CTR
                and	b.COD_LOCAL_CLIENTE				=	c.COD_LOCAL_CLIENTE
                and	b.COD_CLIENTE					=	c.COD_CLIENTE
            ORDER BY
                a.DAT_PAG  ";
       
       
          $stid = mssql_query($sql, $connMSSQL);
        return $stid;
       
   }
   
   public function retornaListarPdvVenda($dataini, $datafim, $loja, $pdv) {
           
       $connMSSQL=  $this->consulta;
       
       $sql = "SELECT 
                    convert(char(10),a.DAT_INC_CTR_SEM_HORA,103)	as	'DATA',
                    a.COD_LOCAL_CTR			as	'LOJA',
                    a.NUM_PDV				as	'PDV',
                    isnull(DBO_CRE.dbo.ufn_TipContratoConvenio(a.COD_TIP_CONVENIO),'Cartão Private') as 'TIPO',
                    case when (a.IND_LIMITE = 'P') then 'Parcelado' else 'Rotativo' end as 'LIMITE',
                    a.VAL_FINANC            as  	'VALOR',
                    a.QTD_PARC_FIN_CTR      as  	'QTD.PARCELAS',
                    b.CPF_CLIENTE           as  	'CPF',
                    b.NOM_CLIENTE           as          'NOME'
               FROM 
                    DBO_CRE.dbo.CONTRATOS_COP_0014T			a	(NOLOCK),	
                    DBO_CRE.dbo.CLIENTE_CORP_0116T			b	(NOLOCK)
               WHERE
                        a.DAT_INC_CTR_SEM_HORA	>=      CONVERT(VARCHAR(10), '$dataini', 101)
                    and a.DAT_INC_CTR_SEM_HORA  <       CONVERT(VARCHAR(10), DATEADD(DAY,1,'$datafim' ) , 101)
                    and	a.COD_LOCAL_CTR		=	$loja
                    and	a.NUM_PDV               =	$pdv
                    and	(a.TIP_APR_CTR='0' or a.COD_TIP_CONVENIO is not null)
                    and	a.COD_LOCAL_CLIENTE		=	b.COD_LOCAL_CLIENTE
                    and	a.COD_CLIENTE			=	b.COD_CLIENTE
              ORDER BY
                    a.DAT_INC_CTR_SEM_HORA,
                    a.COD_LOCAL_CTR,
                    a.NUM_PDV,
                    a.DAT_INC_CTR,
                    isnull(DBO_CRE.dbo.ufn_TipContratoConvenio(a.COD_TIP_CONVENIO),'Cartão Private'),
                    case when (a.IND_LIMITE = 'P') then 'Parcelado' else 'Rotativo' end,
                    b.CPF_CLIENTE";
   
       $stid = mssql_query($sql, $connMSSQL);
        return $stid;
       
   }
   
   public function retornaListaCancelamentoPag($dataini, $datafim, $loja, $pdv) {
        $connMSSQL=  $this->consulta;
       
       
     $sql ="  SELECT 
                convert(char(10),a.DAT_CAN,103)	as	'DATA',
                substring(a.DSC_LOCAL_PAG,1,3)	as	'LOJA',
                substring(a.DSC_LOCAL_PAG,4,3)	as	'PDV',
                a.VAL_PAG                       as	'VALOR',
                c.NOM_CLIENTE                   as	'NOME',
                c.CPF_CLIENTE			as	'CPF'
            FROM
                DBO_CRE.dbo.ACERTO_PAG_PARCELAS_CTR_0140T			a	(NOLOCK),
                DBO_CRE.dbo.CONTRATOS_0109T							b	(NOLOCK),
                DBO_CRE.dbo.CLIENTE_CORP_0116T						c	(NOLOCK)
            WHERE
                        a.DAT_CAN                                       >=	CONVERT(VARCHAR(10), '$dataini', 101)
                and	a.DAT_CAN					<	CONVERT(VARCHAR(10), DATEADD(DAY,1,'$datafim' ) , 101)   
                and	cast(substring(a.DSC_LOCAL_PAG,1,3) as int)	=	$loja
                and	cast(substring(a.DSC_LOCAL_PAG,4,3) as int)	=	$pdv
                and	a.TIP_LOCAL_PAG_PARC_CTR			=	0
                and	a.COD_LOCAL_CTR                                 =	b.COD_LOCAL_CTR
                and	a.NUM_CTR					=	b.NUM_CTR
                and	b.COD_LOCAL_CLIENTE				=	c.COD_LOCAL_CLIENTE
                and	b.COD_CLIENTE					=	c.COD_CLIENTE
            ORDER BY
	
                a.DAT_CAN ";
     
                
       $stid = mssql_query($sql, $connMSSQL);
        return $stid;
       
   }
   
   public function retornaListaCancelamentoVend($dataini, $datafim, $loja, $pdv) {
       
               $connMSSQL=  $this->consulta;
       
       $sql = "SELECT 
                    convert(char(10),a.DAT_CAN_CTR_SEM_HORA,103)	as	'DATA',
                    a.COD_LOCAL_CTR			as	'LOJA',
                    a.NUM_PDV				as	'PDV',
                    isnull(DBO_CRE.dbo.ufn_TipContratoConvenio(a.COD_TIP_CONVENIO),'Cartão Private') as 'TIPO',
                    case when (a.IND_LIMITE = 'P') then 'Parcelado' else 'Rotativo' end as 'LIMITE',
                    a.VAL_FINANC			as	'VALOR',
                    a.QTD_PARC_FIN_CTR		as	'QTD.PARCELAS',
                    b.CPF_CLIENTE			as	'CPF',
                    b.NOM_CLIENTE           as 'NOME'
               FROM
                    DBO_CRE.dbo.CONTRATOS_COP_0014T			a	(NOLOCK),
                    DBO_CRE.dbo.CLIENTE_CORP_0116T			b	(NOLOCK)
WHERE
                        a.DAT_CAN_CTR_SEM_HORA	>=	CONVERT(VARCHAR(10), '$dataini', 101)
                    and a.DAT_CAN_CTR_SEM_HORA  <	CONVERT(VARCHAR(10), DATEADD(DAY,1,'$datafim' ) , 101)   
                    and	a.COD_LOCAL_CTR		= $loja
                    and	a.NUM_PDV		=	$pdv
                    and	(a.TIP_APR_CTR='0' or a.COD_TIP_CONVENIO is not null)
                    and	a.COD_LOCAL_CAN is not null -- Para desconsiderar cancelamento de fatura
                    and	a.COD_LOCAL_CLIENTE		=	b.COD_LOCAL_CLIENTE
                    and	a.COD_CLIENTE			=	b.COD_CLIENTE
               ORDER BY
                    a.DAT_CAN_CTR_SEM_HORA";
        
       $stid = mssql_query($sql, $connMSSQL);
        return $stid;

   }
   
   public function retornaListaCancelVoucher($dataini, $datafim, $loja, $pdv) {
       
        $connMSSQL=  $this->consulta;
       
       $sql = "SELECT 
                        convert(char(10),a.DAT_INC_CTR_SEM_HORA,103)	as	'DATA',
                        a.COD_LOCAL_CTR			as	'LOJA',
                        a.NUM_PDV				as	'PDV',
                        isnull(DBO_CRE.dbo.ufn_TipContratoConvenio(a.COD_TIP_CONVENIO),'Cartão Private') as 'TIPO',
                        case when (a.IND_LIMITE = 'P') then 'Parcelado' else 'Rotativo' end as 'LIMITE',
                        a.VAL_FINANC			as	'VALOR',
                        a.QTD_PARC_FIN_CTR		as	'QTD.PARCELAS',
                        b.CPF_CLIENTE			as	'CPF'
               FROM
                        DBO_CRE.dbo.CONTRATOS_COP_0014T			a	(NOLOCK),
                        DBO_CRE.dbo.CLIENTE_CORP_0116T			b	(NOLOCK)
               WHERE
                                a.DAT_INC_CTR_SEM_HORA          >=      CONVERT(VARCHAR(10), '$dataini', 101)
                        and     a.DAT_INC_CTR_SEM_HORA          <       CONVERT(VARCHAR(10), DATEADD(DAY,1,'$datafim' ) , 101)
                        and	a.COD_LOCAL_CTR			=	$loja
                        and	a.NUM_PDV			=	$pdv
                        and	a.COD_TIP_CONVENIO		=	2
                        and	a.COD_LOCAL_CLIENTE		=	b.COD_LOCAL_CLIENTE
                        and	a.COD_CLIENTE			=	b.COD_CLIENTE
               ORDER BY
                        a.DAT_INC_CTR_SEM_HORA,
                        a.COD_LOCAL_CTR,
                        a.NUM_PDV,
                        a.DAT_INC_CTR,
                        isnull(DBO_CRE.dbo.ufn_TipContratoConvenio(a.COD_TIP_CONVENIO),'Cartão Private'),
                        case when (a.IND_LIMITE = 'P') then 'Parcelado' else 'Rotativo' end,
                        b.CPF_CLIENTE";
       
       
       
           $stid = mssql_query($sql, $connMSSQL);
        return $stid;
   }
   
   public function cancelVendaEmporium($loja, $dataini, $datafim, $pdv) {
         if($tipVenda == "1"){
        
        $sql ="SELECT 
                    count(*) qtdVendas
                   , sum(ValorDaOperacao) SomaValor
                   ,(select sum(ValorDaOperacao)
                        FROM
                            ft094_ems 
                        WHERE 
                            DataPDV between date_format('$dataini', '%Y%m%d' ) and date_format('$datafim', '%Y%m%d') 
                            and CodigoDaLoja = $loja
                            and NumeroDoPDV = $pdv
                            and TipoDeOperacao = '212') SomaCan
                FROM
                    ft094_ems 
                WHERE 
                    DataPDV between date_format('$dataini', '%Y%m%d' ) and date_format('$datafim', '%Y%m%d') 
                    and CodigoDaLoja = $loja
                    and NumeroDoPDV = $pdv
                    and TipoDeOperacao = '111'
                    and Status  = '3' "; }
                    
                    elseif($tipVenda == "3") {

                 $sql="SELECT 
                            count(*) qtdVendas
                           , sum(ValorDaOperacao) SomaValor
                        FROM
                            ft094_ems 
                        WHERE 
                            DataPDV between date_format('$dataini', '%Y%m%d' ) and date_format('$datafim', '%Y%m%d') 
                            and CodigoDaLoja = '$loja'
                            and NumeroDoPDV = '$pdv'
                            and TipoDeOperacao = '114'
                            and Status = '3'";
                        }
                        elseif($tipVenda == "4")
                        {
                              $sql="SELECT 
                            count(*) qtdVendas
                           , sum(ValorDaOperacao) SomaValor
                        FROM
                            ft094_ems 
                        WHERE 
                            DataPDV between date_format('$dataini', '%Y%m%d' ) and date_format('$datafim', '%Y%m%d') 
                            and CodigoDaLoja = '$loja'
                            and NumeroDoPDV = '$pdv'
                            and TipoDeOperacao = '113'
                            and Status = '3'";
                            
                        }
                        else
                        {
                                  $sql="SELECT 
                            count(*) qtdVendas
                           , sum(ValorDaOperacao) SomaValor
                        FROM
                            ft094_ems 
                        WHERE 
                            DataPDV between date_format('$dataini', '%Y%m%d' ) and date_format('$datafim', '%Y%m%d') 
                            and CodigoDaLoja = '$loja'
                            and NumeroDoPDV = '$pdv'
                            and TipoDeOperacao = '112'
                            and Status = '3'";
                            
                        }
                    
      
        return $this->query($sql);
       
       }
       
       public function cancelVendaEms($dataini, $datafim, $pdv, $loja, $tipVenda) {
           
           $connMSSQL = $this->consulta;
        
        if($tipVenda == "1"){
        
        $sql = "SELECT
                    convert(char(10),a.DAT_INC_CTR_SEM_HORA,103)	as	'DATA',
                    a.COD_LOCAL_CTR			as	'LOJA',
                    a.NUM_PDV				as	'PDV',
                    isnull(DBO_CRE.dbo.ufn_TipContratoConvenio(a.COD_TIP_CONVENIO),'Cartão Private') as 'TIPO',
                    case when (a.IND_LIMITE = 'P') then 'Parcelado' else 'Rotativo' end as 'LIMITE',
                    count(*)				as	'QUANTIDADE',
                    sum(a.VAL_FINANC)		as	'VALOR'
                FROM DBO_CRE.dbo.CONTRATOS_COP_0014T			a	(NOLOCK)
                WHERE
                    a.DAT_INC_CTR_SEM_HORA	>= CONVERT(VARCHAR(10), '$dataini', 101)	
                    AND a.DAT_INC_CTR_SEM_HORA	<  CONVERT(VARCHAR(10), DATEADD(DAY,1,'$datafim' ) , 101) 
                    AND	(a.TIP_APR_CTR='0' or a.COD_TIP_CONVENIO is not null)
                    and a.IND_LIMITE <> 'P'
                    AND a.COD_LOCAL_CTR = '$loja'
                    AND a.NUM_PDV > 0
                    AND a.COD_TIP_CONVENIO is null
                    AND a.NUM_PDV = $pdv
                    and a.DAT_CAN_CTR_SEM_HORA is not null
                 GROUP BY
                    a.DAT_INC_CTR_SEM_HORA,
                    a.COD_LOCAL_CTR,
                    a.NUM_PDV,
                    isnull(DBO_CRE.dbo.ufn_TipContratoConvenio(a.COD_TIP_CONVENIO),'Cartão Private'),
                    case when (a.IND_LIMITE = 'P') then 'Parcelado' else 'Rotativo' end
                ORDER BY
                    a.DAT_INC_CTR_SEM_HORA,
                    a.COD_LOCAL_CTR,
                    a.NUM_PDV,
                    isnull(DBO_CRE.dbo.ufn_TipContratoConvenio(a.COD_TIP_CONVENIO),'Cartão Private'),
                    case when (a.IND_LIMITE = 'P') then 'Parcelado' else 'Rotativo' end"; }
                    
                    elseif($tipVenda == "3") {

            $sql =" SELECT
                        a.COD_LOCAL_CTR			as	'LOJA',
                        a.NUM_PDV				as	'PDV',
                        count(*)				as	'QUANTIDADE',
                        sum(a.VAL_FINANC)		as	'VALOR'
                    FROM
                        DBO_CRE.dbo.CONTRATOS_COP_0014T			a	(NOLOCK)
                    WHERE
                                a.DAT_INC_CTR_SEM_HORA	>=	CONVERT(VARCHAR(10), '$dataini', 101)
                        and     a.DAT_INC_CTR_SEM_HORA   <      CONVERT(VARCHAR(10), DATEADD(DAY,1,'$datafim' ) , 101)
                        and     a.COD_TIP_CONVENIO		=	2
                        and     a.COD_LOCAL_CTR  = '$loja'  
                        a.NUM_PDV = $pdv
                        and a.DAT_CAN_CTR_SEM_HORA is not null
                 GROUP BY
                        a.DAT_INC_CTR_SEM_HORA,
                        a.COD_LOCAL_CTR,
                        a.NUM_PDV ";
                    } elseif($tipVenda == "4") {
                      
            $sql =" SELECT
                        a.COD_LOCAL_CTR			as	'LOJA',
                        a.NUM_PDV				as	'PDV',
                        count(*)				as	'QUANTIDADE',
                        sum(a.VAL_FINANC)		as	'VALOR'
                    FROM
                        DBO_CRE.dbo.CONTRATOS_COP_0014T			a	(NOLOCK)
                    WHERE
                                a.DAT_INC_CTR_SEM_HORA	>=	CONVERT(VARCHAR(10), '$dataini', 101)
                        and     a.DAT_INC_CTR_SEM_HORA   <      CONVERT(VARCHAR(10), DATEADD(DAY,1,'$datafim' ) , 101)
                        and     a.COD_TIP_CONVENIO		=	1
                        and     a.COD_LOCAL_CTR  = '$loja' 
                        a.NUM_PDV = $pdv
                        and a.DAT_CAN_CTR_SEM_HORA is not null
                 GROUP BY
                        a.DAT_INC_CTR_SEM_HORA,
                        a.COD_LOCAL_CTR,
                        a.NUM_PDV ";  
                        
                        
                    } else {
                        
                        $sql =" SELECT
                        a.COD_LOCAL_CTR			as	'LOJA',
                        a.NUM_PDV				as	'PDV',
                        count(*)				as	'QUANTIDADE',
                        sum(a.VAL_FINANC)		as	'VALOR'
                    FROM
                        DBO_CRE.dbo.CONTRATOS_COP_0014T			a	(NOLOCK)
                    WHERE
                                a.DAT_INC_CTR_SEM_HORA	>=	CONVERT(VARCHAR(10), '$dataini', 101)
                        and     a.DAT_INC_CTR_SEM_HORA   <      CONVERT(VARCHAR(10), DATEADD(DAY,1,'$datafim' ) , 101)
                        and     a.IND_LIMITE = 'P'
                        and     a.COD_LOCAL_CTR  = '$loja'   
                        and     a.NUM_PDV >= '1'
                        a.NUM_PDV = $pdv
                        and a.DAT_CAN_CTR_SEM_HORA is not null
                        
       
                 GROUP BY
                        a.DAT_INC_CTR_SEM_HORA,
                        a.COD_LOCAL_CTR,
                        a.NUM_PDV "; 
                        
                        
                    }
        $stid = mssql_query($sql, $connMSSQL);
        return $stid;
           
         
           
       }
       
           public function inserir($tabela,$campos)
    {
        $insere =  $this->exec($this->insere($tabela, $campos));
        
      
  
        return $insere;
        
    }
    
    public function retornaObs($pdv, $loja, $final, $data){
        
        
        $sql = "SELECT *
                FROM    
                    T090_obs_totais
                WHERE
                    T090_data = '$data'
                    and T090_pdv = $pdv
                    and T090_loja = $loja
                    and T090_finalizadora = $final";
        
      
        
        return $this->query($sql);
        
    }
    
        public function altera($tabela,$campos,$delim)
    {
       $conn = "";
       
       $altera = $this->exec($this->atualiza($tabela, $campos, $delim));
       

       
       return $altera;
    }
    
    public function excluir($tabela, $delim) {
        
        $conn = "";
        
        $exclui = $this->exec($this->exclui($tabela, $delim));
        
        return $exclui;
        
    }
    
 
    public function  retornaBuscaCombo($tipBusca)
    {
        switch($tipBusca){
            
            case "":
                
                $busca = "<option value='1'>Diferenças        </option>
                          <option value='0'> Todos  </option>";
                break;
            case "1":
                $busca = "<option value='1'>Diferenças        </option>
                          <option value='0'> Todos  </option>";
                break;
            case "0":
                $busca = "<option value='0'>Todos        </option>
                          <option value='1'> Diferenças  </option>";
                break;
        }
        
        return $busca;
    }
    
    
     public function  retornaBuscaComboLoja($lojaPost)
    {
        switch($lojaPost){
            
            case "":
                $busca = "<option value='0'>Selecione </option>";
                break;
            case "001":
                $busca = "<option value='001'>".$lojaPost." - DAVO ITAQUERA</option>";
                break;
            case "002":
                $busca = "<option value='002'>".$lojaPost." - DAVO ORATÓRIO</option>";
                break;
            case "003":
                $busca = "<option value='003'>".$lojaPost." - DAVO GUAIANASES</option>";
                break;
            case "004":
                $busca = "<option value='004'>".$lojaPost." - DAVO SÃO MIGUEL</option>";
                break;
            case "005":
                $busca = "<option value='005'>".$lojaPost." - DAVO ITAIM</option>";
                break;
            case "006":
                $busca = "<option value='006'>".$lojaPost." - DAVO SUZANO</option>";
                break;
            case "007":
                $busca = "<option value='007'>".$lojaPost." - DAVO MOGI DAS CRUZES</option>";
                break;
            case "008":
                $busca = "<option value='008'>".$lojaPost." - DAVO FARMA ITAQUERA</option>";
                break;
            case "009":
                $busca = "<option value='009'>".$lojaPost." - DAVO FARMA MOGI DAS CRUZES</option>";
                break;
            case "010":
                $busca = "<option value='010'>".$lojaPost." - DAVO FARMA GUAIANASES</option>";
                break;
            case "011":
                $busca = "<option value='011'>".$lojaPost." - DAVO FARMA SAO B. DO CAMPO</option>";
                break;
            case "012":
                $busca = "<option value='012'>".$lojaPost." - DAVO SÃO BERNARDO DO CAMPO</option>";
                break;
            case "013":
                $busca = "<option value='013'>".$lojaPost." - DAVO TABOÃO DA SERRA</option>";
                break;
        }
        
        return $busca;
    }
    
    
    public function retornaFinalizadoras($tipVenda)
    {
        switch($tipVenda){
            
            case "":
                $finalizadora = "<option value='0'>Selecione...         </option>
                            <option value='1'> Rotativo  </option>
                            <option value='2'> Parcelado  </option>
                            <option value='3'> Voucher  </option>
                            <option value='4'> Convenio  </option>
                            <option value='5'> Ajustes  </option>";
                           
                break;
            
            case "0":
                $finalizadora = "<option value='0'>Selecione...         </option>
                            <option value='1'> Rotativo  </option>
                            <option value='2'> Parcelado  </option>
                            <option value='3'> Voucher  </option>
                            <option value='4'> Convenio  </option>
                            <option value='5'> Ajustes  </option>";
                break;
            case "1":
                $finalizadora = "
                            <option value='1'> Rotativo  </option>
                            <option value='2'> Parcelado  </option>
                            <option value='3'> Voucher  </option>
                            <option value='4'> Convenio  </option>
                            <option value='5'> Ajustes  </option>
                            ";
                break;
            case "2":
                $finalizadora = "
                            <option value='2'> Parcelado  </option>                            
                            <option value='1'> Rotativo  </option>
                            <option value='3'> Voucher  </option>
                            <option value='4'> Convenio  </option>
                            <option value='5'> Ajustes  </option>
                          ";
                break;
            case "3":
                $finalizadora = "  
                            <option value='3'> Voucher  </option>                    
                            <option value='2'> Parcelado  </option>                            
                            <option value='1'> Rotativo  </option>
                            <option value='4'> Convenio  </option>
                            <option value='5'> Ajustes  </option>
                            ";
                break;
            case "4":
                $finalizadora = "
                            <option value='4'> Convenio  </option>                    
                            <option value='3'> Voucher  </option>                    
                            <option value='2'> Parcelado  </option>                            
                            <option value='1'> Rotativo  </option>
                            <option value='5'> Ajustes  </option>
                           ";
                break;
            case "5":
                $finalizadora = "
                            <option value='5'> Ajustes  </option>                           
                            <option value='4'> Convenio  </option>                    
                            <option value='3'> Voucher  </option>                    
                            <option value='2'> Parcelado  </option>                            
                            <option value='1'> Rotativo  </option>";
          
        }
        
        return $finalizadora;
    }
    
    public function corfundo($dif, $can, $can2) {
        
        if (($dif == "") and ($can == "") and (($can2 == "0") or ($can2 == ""))){
            
            $corfundo = "#FFFFFF";
            
        } elseif (($dif == "") and (($can != "") or ($can2 != "0") or ($can2 != ""))) {
            
            $corfundo = "#FFE7A1";
        
            
        } else {
            
            $corfundo = "#F05E5E";
        }
        
        return $corfundo;
    }
    
    public function formataNumero($valor) {
        
        $len = strlen($valor);
        switch ($len) {
            case "2":
                $res = "0".$valor;
            break;
        case "1":
            $res = "00".$valor;
          break;
                        }
        
                        return $res;
    }
    
    public function retornaCancelParcEmp($loja, $pdv, $data)
    
    {
        if($loja == '0'){
        
            $sql = "SELECT amount_canc 'val_can'
      ,quantity_canc 'qtd_can'
      , store_key  'loja'
      , pos_number 'pdv'      
FROM accum_media
WHERE 
      media_id = '14'
      and fiscal_date = '$data'
      and pos_number <> 0";
        
            
            
        
        
      } else {
          
          $sql = "SELECT amount_canc 'val_can'
      ,quantity_canc 'qtd_can'
FROM accum_media
WHERE store_key = '$loja'
      and pos_number = '$pdv'
      and media_id = '14'
      and fiscal_date = '$data'"; 
      }
                  return $this->query($sql);
                  
                  }
                  
                  function retornaPerfilConfianca($user) {
                      
                      //echo $user;
                      
                      $sql= "SELECT T004_login      usuario,
                                    T009_codigo     codigo
                                FROM T004_T009        
                              WHERE T009_codigo     = '38'
                                AND T004_login      = '$user' ";
                      
                      return $this->query($sql);
                      
                  }
                  
                  function retornaTotaisEMSVendas($data)
                  {
                      
                       $connMSSQL=  $this->consulta;
                      
                      $sql = "IF object_id('tempdb..#tempTotaisAcerto2') IS NOT NULL 
                        BEGIN
                             DROP TABLE #tempTotaisAcerto2
                        END
CREATE TABLE #tempTotaisAcerto2 (CPF_CLIENTE CHAR(11), COD_LOCAL_CTR INT, NUM_CTR CHAR(15), DAT_INC_CTR DATETIME, NUM_CUPOM CHAR(14))

INSERT INTO #tempTotaisAcerto2
SELECT CPF_CLIENTE, COD_LOCAL_CTR, NUM_CTR, DAT_INC_CTR, substring(A.NUM_CUPOM,patindex('%[a-z,1-9]%',A.NUM_CUPOM),len(A.NUM_CUPOM)) as NUM_CUPOM
                FROM DBO_CRE.dbo.CONTRATOS_COP_0014T			a	(NOLOCK)
					,DBO_CRE.dbo.CLIENTE_CORP_0116T				B	(NOLOCK)
                WHERE
                    a.DAT_INC_CTR_SEM_HORA	>= CONVERT(VARCHAR(10), '$data', 101)	
                    AND a.DAT_INC_CTR_SEM_HORA	<  CONVERT(VARCHAR(10), DATEADD(DAY,1,'$data' ) , 101) 
                    AND a.NUM_PDV > 0
                    AND COD_CAN_CTR NOT IN ('0','907')
                	AND A.COD_LOCAL_CLIENTE = B.COD_LOCAL_CLIENTE
					AND A.COD_CLIENTE = B.COD_CLIENTE
					

IF object_id('tempdb..#tempTotaisAcerto') IS NOT NULL 
                        BEGIN
                             DROP TABLE #tempTotaisAcerto
                        END
CREATE TABLE #tempTotaisAcerto (CPF_CLIENTE CHAR(11), COD_LOCAL_CTR INT, NUM_CTR CHAR(15), DAT_INC_CTR DATETIME, NUM_CUPOM CHAR(13))

INSERT INTO #tempTotaisAcerto
SELECT CPF_CLIENTE, COD_LOCAL_CTR, NUM_CTR,DAT_INC_CTR, substring(A.NUM_CUPOM,patindex('%[a-z,1-9]%',A.NUM_CUPOM),len(A.NUM_CUPOM)) AS NUM_CUPOM
                FROM DBO_CRE.dbo.CONTRATOS_COP_0014T			a	(NOLOCK)
					,DBO_CRE.dbo.CLIENTE_CORP_0116T				B	(NOLOCK)
                WHERE
                    a.DAT_INC_CTR_SEM_HORA	>= CONVERT(VARCHAR(10), '$data', 101)	
                    AND a.DAT_INC_CTR_SEM_HORA	<  CONVERT(VARCHAR(10), DATEADD(DAY,1,'$data' ) , 101) 
                    AND a.NUM_PDV > 0
                    AND  COD_PEDIDO = 0
					AND  TIP_APR_CTR <> 3
					AND A.COD_LOCAL_CLIENTE = B.COD_LOCAL_CLIENTE
					AND A.COD_CLIENTE = B.COD_CLIENTE
					AND EXISTS (SELECT * FROM #tempTotaisAcerto2 C
								WHERE substring(A.NUM_CUPOM,patindex('%[a-z,1-9]%',A.NUM_CUPOM),len(A.NUM_CUPOM)) 
									= substring(C.NUM_CUPOM,patindex('%[a-z,1-9]%',C.NUM_CUPOM),len(C.NUM_CUPOM)) )
				
				
SELECT a.COD_LOCAL_CTR as 'LOJA'
                            , sum(case when a.IND_LIMITE = 'P'  and a.COD_TIP_CONVENIO is null 
                            AND COD_FUNC_APR = 0
                            and NUM_PDV >= '1'
                            AND COD_CAN_CTR IN ('0','907')
                            then a.val_financ else 0  end) as valParcelado
                            , sum(case when a.IND_LIMITE <> 'P'
                                                AND a.NUM_PDV > 0
                                                and a.COD_TIP_CONVENIO is null
                                                AND COD_FUNC_APR = 0 
                                                AND COD_CAN_CTR IN ('0','907')
                                                    then a.val_financ else 0 end) as valRotativo
                            , sum(case when a.COD_TIP_CONVENIO	=	2 
                                        AND COD_CAN_CTR IN ('0','907')
                                    then a.val_financ else 0 end) as valVoucher
                            , sum (case when a.COD_TIP_CONVENIO	=	1
                                          then a.val_financ else 0 end) as valConvenio
                            , sum (case when a.COD_TIP_CONVENIO is null 
                                                            and COD_FUNC_INC = '999'
                                                            AND COD_FUNC_APR <> 0 
                                                       then a.val_financ else 0 end) as valAjuste
                            ,sum(case when a.DAT_CAN_CTR_SEM_HORA is not null 
                                                                    and a.IND_LIMITE <> 'P'
                                                AND a.NUM_PDV > 0
                                                and a.COD_TIP_CONVENIO is null
                                                AND COD_FUNC_APR = 0 then a.val_financ else 0 end) as canRotativo
                            ,sum (case when a.COD_LOCAL_CAN is not null 
                                                    and a.IND_LIMITE = 'P'  and a.COD_TIP_CONVENIO is null 
                            AND COD_FUNC_APR = 0 
                            and num_pdv >= 1 then a.val_financ else 0  end) as canParcelado
                            , sum (case when  a.COD_LOCAL_CAN is not null
                                                            and a.COD_TIP_CONVENIO	=	2 then a.val_financ else 0 end) as canVoucher
                            ,sum (case when a.COD_LOCAL_CAN is not null  and  a.COD_TIP_CONVENIO	=	1
                                            then a.val_financ else 0 end) as canConvenio
                            ,sum (case when  a.COD_LOCAL_CAN is not null  and  a.COD_TIP_CONVENIO is null 
                                                            and COD_FUNC_INC = '999'
                                                            AND COD_FUNC_APR <> 0 then a.val_financ else 0 end) as canAjuste
                            FROM DBO_CRE.dbo.CONTRATOS_COP_0014T a (NOLOCK) 
                            WHERE
                             a.DAT_INC_CTR_SEM_HORA >= CONVERT(VARCHAR(10), '$data', 101) 
                                    AND a.DAT_INC_CTR_SEM_HORA < CONVERT(VARCHAR(10), DATEADD(DAY,1,'$data' ) , 101)
                            and a.cod_local_ctr <=  18
			            		GROUP BY 
                             a.COD_LOCAL_CTR 
                            ORDER BY  a.COD_LOCAL_CTR  ";
                      
                         
  //   echo $sql."<br>";
                      
                      $stid = mssql_query($sql, $connMSSQL);
        return $stid;
        
     
                  }
                  
                  
                  
                  function retornaParceladoEmp($data, $loja)
                  {
                      
                      $sql = "select 
                                store_key as 'loja'
                               ,sum(amount) as 'valor'
                               ,sum(amount_canc) as 'valor_canc'
                                from 
                                    accum_media  
                               where
                                   media_id = '14' 
                               and fiscal_date = '$data'
                               and store_key = '$loja'
                               and pos_number <> '0'
                             GROUP BY store_key";
                      
                      return $this->query($sql);
                      
                  }
                  
                  
                  function retornaTotaisPagEms($data, $loja)
                  {
                       $connMSSQL=  $this->consulta;
                       
                       $sql = "select LOJA
                                      ,VALOR_CAN as valCanPagamento
                                      ,VALOR_PAG as valPagamento
                                 FROM
                                      #tempTotaisPag
                                 WHERE
                                       LOJA = '$loja' ";
                       
                      // echo $sql."<br>";
                       
                                $stid = mssql_query($sql, $connMSSQL);
                                    return $stid;
             }
             
             function insereDadosPagTemp($data)
             {
                 $connMSSQL=  $this->consulta;
                 
              $sql = "IF object_id('tempdb..#tempTotaisPag') IS NOT NULL 
                        BEGIN
                             DROP TABLE #tempTotaisPag
                        END

                CREATE TABLE #tempTotaisPag(LOJA CHAR(3), VALOR_CAN MONEY, VALOR_PAG MONEY )
                INSERT INTO #tempTotaisPag
                select
                        substring(a.DSC_LOCAL_PAG,1,3)	as	'LOJA'
                       ,sum(case when a.DAT_CAN IS not NULL then a.val_pag else 0 end) as valCanPagamento
                       ,sum(case when a.DAT_CAN IS NULL then a.val_pag else 0 end) as valPagamento
                    from dbo.ACERTO_PAG_PARCELAS_CTR_0140T   a	(NOLOCK)
                   where
                            a.DAT_PAG	>=	CONVERT(VARCHAR(10), '$data', 101)	
                    and	a.DAT_PAG	<       CONVERT(VARCHAR(10), DATEADD(DAY,1,'$data' ) , 101)                                      and	a.TIP_LOCAL_PAG_PARC_CTR	=	0
                group by
                      substring(a.DSC_LOCAL_PAG,1,3)
                order by
                      substring(a.DSC_LOCAL_PAG,1,3)";
              
              
                                 
                                 $stid = mssql_query($sql, $connMSSQL);
                                    return $stid;
                 
             }
             
             
             
                  
                  function retornaSomaEms($valor)
                  {
                      $numero = $valor;
                      $numero = number_format($numero, 2,",","");
                      $numero = str_replace(",", "", $numero);
                     
                      
                      return $numero;
                      
                  }
                  
                  function retornaSomaEmp($valor)
                  {
                      
                       $numero = $valor;
                      $numero = str_replace(",", "", $numero);
                     
                      
                      return $numero;
                      
                  }
                
                  
   public function retornaAjusteEms($data, $loja, $pdv, $tipo) {
       
        $sql = "SELECT TJ3.T106_codigo						Codigo
                     , TJ3.T006_codigo						CodLoja
                     , TJ4.T006_nome						NomeLoja
                     , TJ3.T106_data_operacao                                   DataOper
                     , TJ3.T107_codigo                                          TipoOper
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
                  JOIN T006_loja	TJ4     ON ( TJ4.T006_codigo                                 = TJ3.T006_codigo )
                  JOIN T004_usuario     TJ6     ON ( TJ6.T004_login                                  = TJ3.T004_login  )
                 WHERE TF1.T060_codigo          = TJ2.T060_codigo
                   AND TJ3.T106_data_operacao   = '$data'
                   AND  TJ3.T006_codigo         = '$loja'
                   AND  TJ3.T106_pdv            = '$pdv'
                   AND  TJ3.T107_codigo         = '$tipo'";
               
      //  echo $sql;
        return $this->query($sql);
       
   }      
   
   public function retornaSomaTotalAjuste($data, $loja, $pdv, $tipo) {
       
      switch($loja){
         
          case "1":
              $lj = "19";
              break;
          case "2":
              $lj = "27";
              break;
          case "3":
              $lj = "35";
              break;
          case "4":
              $lj = "43";
              break;
          case "5":
              $lj = "51";
              break;
          case "6":
              $lj = "60";
              break;
          case "7":
              $lj = "78";
              break;
          case "8":
              $lj = "86";
              break;
          case "9":
              $lj = "94";
              break;
          case "10":
              $lj = "108";
              break;
          case "11":
              $lj = "116";
              break;
          case "12":
              $lj = "124";
              break;
          case "13":
              $lj = "132";
              break;
          case "14":
              $lj = "140";
              break;
          case "15":
              $lj = "159";
              break;
          case "16":
              $lj = "167";
              break;
          case "17":
              $lj = "175";
              break;
          case "18":
              $lj = "183";
              break;
          
      }   
      
      switch($tipo){
          case "1":
              $tipo1 = "TB1.T107_codigo in ('3','5','7')";
              $tipo2 = "TB1.T107_codigo in ('4','6','8')";
              break;
          case "2":
              $tipo1 = "TB1.T107_codigo in ('2')";
              $tipo2 = "TB1.T107_codigo in ('1')";
              break;
          
      }
       
       
       $sql = " SELECT     TB1.T106_pdv             pdv
                        ,  TB1.T006_codigo          loja
                        ,  TB1.T107_codigo          tipo
                        , sum(case when $tipo1 then T106_valor_tot else 0 end ) as SomaInc
                        , sum(case when $tipo2 then T106_valor_tot else 0 end ) as SomaEst
      FROM T106_ajustes_ems         TB1
                   WHERE  TB1.T106_data_operacao    =   '$data' 
                   AND    TB1.T106_status           in   ('2', '9')
                   AND    TB1.T106_pdv              =   '$pdv'
                   AND    TB1.T006_codigo           =   '$lj'   ";
       
     //echo $sql."<br>";
       
                    return $this->query($sql);
       
       
       }
       
       public function editaLoja($loja) {
           switch($loja){
         
          case "19":
              $lj = "1";
              break;
          case "27":
              $lj = "2";
              break;
          case "35":
              $lj = "3";
              break;
          case "43":
              $lj = "4";
              break;
          case "51":
              $lj = "5";
              break;
          case "60":
              $lj = "6";
              break;
          case "78":
              $lj = "7";
              break;
          case "86":
              $lj = "8";
              break;
          case "94":
              $lj = "9";
              break;
          case "108":
              $lj = "10";
              break;
          case "116":
              $lj = "11";
              break;
          case "124":
              $lj = "12";
              break;
          case "132":
              $lj = "13";
              break;
          case "140":
              $lj = "14";
              break;
          case "159":
              $lj = "15";
              break;
          case "167":
              $lj = "16";
              break;
          case "175":
              $lj = "17";
              break;
          case "183":
              $lj = "18";
              break;
          
      }   
      return $lj;
           
       }
                  
       
            public function retornaDetalhesAjuste($cod)
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
                            FROM T106_T060 TF1 
                            JOIN T106_ajustes_ems TJ1 ON ( TJ1.T106_codigo = TF1.T106_codigo ) 
                            JOIN T006_loja TJ2 ON ( TJ2.T006_codigo = TJ1.T006_codigo ) 
                            JOIN T107_T106  TJ3 ON ( TJ3.T107_codigo = TJ1.T107_codigo ) 
                            JOIN T004_usuario TJ4 ON ( TJ4.T004_login = TJ1.T004_login ) 
                            WHERE TJ1.T106_codigo = $cod ";
        
        //echo $sql;
        
        return $this->query($sql);
    }
                  
    
    }
?>
