//<?php
//
//
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
//class models_T0075 extends models
//{
//
//    public function __construct($conn,$verificaConexao,$db)
//    {
//        parent::__construct($conn,$verificaConexao,$db);
//    }
//    
//    
//    public function retornaPagEmporium($dataini, $datafim, $loja)
// 
//    {
//        if (($loja == "0")or ($loja == "")){
//        
//      
//                $sql = " select sum(amount_due) as ValorEmp
//                       ,store_key
//                       ,pos_number 
//                       ,count(*) as QtdEmp
//                from  sale
//                where 
//                fiscal_date = '$dataini' 
//                and  sale_type = 14   
//                group by store_key, pos_number "; } else {
//                    
//                     $sql = " select sum(amount_due) as ValorEmp
//                       ,store_key
//                       ,pos_number 
//                       ,count(*) as QtdEmp
//                from  sale
//                where 
//                fiscal_date = '$dataini' 
//                and store_key = '$loja'
//                and  sale_type = 14 
//                group by store_key, pos_number "; 
//                    
//                }
//
//
// echo $sql."<br>";      
//        return $this->query($sql);
//        
//    }
//    
//    
//    public function retornaPagEMS($dataini, $datafim, $loja, $pdv)
//    {
//        
//        $connMSSQL = $this->consulta;
//        
//        if ($loja != "0"){
//        
//        $sql = "
//                select
//                    convert(char(10),a.DAT_PAG,103)	as	'DATA',
//                    substring(a.DSC_LOCAL_PAG,1,3)	as	'LOJA',
//                    substring(a.DSC_LOCAL_PAG,4,3)	as	'PDV',
//                    count(*)			as	'QUANTIDADE',
//                    sum(a.VAL_PAG)			as	'VALOR'
//                from dbo.ACERTO_PAG_PARCELAS_CTR_0140T   a	(NOLOCK)
//                where
//                        a.DAT_PAG	>=	CONVERT(VARCHAR(10), '$dataini', 101)	
//                and	a.DAT_PAG	<       CONVERT(VARCHAR(10), DATEADD(DAY,1,'$datafim' ) , 101) 				
//                and	a.TIP_LOCAL_PAG_PARC_CTR	=	0
//                and substring(a.DSC_LOCAL_PAG,1,3) = '$loja'
//                and substring(a.DSC_LOCAL_PAG,4,3) = '$pdv'
//                and a.DAT_CAN IS NULL
//             
//                group by
//                        convert(char(10),a.DAT_PAG,103),
//                        substring(a.DSC_LOCAL_PAG,1,3),
//                        substring(a.DSC_LOCAL_PAG,4,3)
//                order by
//                        1,
//                        substring(a.DSC_LOCAL_PAG,1,3),
//                        substring(a.DSC_LOCAL_PAG,4,3)"; 
//        
//                        } else {
//                            
//                             $sql = " select
//                    convert(char(10),a.DAT_PAG,103)	as	'DATA',
//                    substring(a.DSC_LOCAL_PAG,1,3)	as	'LOJA',
//                    substring(a.DSC_LOCAL_PAG,4,3)	as	'PDV',
//                    count(*)			as	'QUANTIDADE',
//                    sum(a.VAL_PAG)			as	'VALOR'
//                from dbo.ACERTO_PAG_PARCELAS_CTR_0140T   a	(NOLOCK)
//                where
//                        a.DAT_PAG	>=	CONVERT(VARCHAR(10), '$dataini', 101)	
//                and	a.DAT_PAG	<       CONVERT(VARCHAR(10), DATEADD(DAY,1,'$datafim' ) , 101) 				
//                and	a.TIP_LOCAL_PAG_PARC_CTR	=	0
//                and a.DAT_CAN IS NULL
//             
//                group by
//                        convert(char(10),a.DAT_PAG,103),
//                        substring(a.DSC_LOCAL_PAG,1,3),
//                        substring(a.DSC_LOCAL_PAG,4,3)
//                order by
//                        1,
//                        substring(a.DSC_LOCAL_PAG,1,3),
//                        substring(a.DSC_LOCAL_PAG,4,3)";
//                        }
//
//        echo $sql."<br>";
//                        
//        $stid = mssql_query($sql, $connMSSQL);
//     
//        
//        return $stid;
//        
//       
//    }
//    
//    public function retornaVendaEms($dataini, $datafim, $loja,$tipVenda, $pdv)
//    {
//        $connMSSQL = $this->consulta;
//        
//        if($loja == "0"){
//            
//             if($tipVenda == "1"){
//        
//        $sql = "SELECT
//                    a.COD_LOCAL_CTR			as	'LOJA',
//                    a.NUM_PDV				as	'PDV',
//                    count(*)				as	'QUANTIDADE',
//                    sum(a.VAL_FINANC)		as	'VALOR'
//                FROM DBO_CRE.dbo.CONTRATOS_COP_0014T			a	(NOLOCK)
//                WHERE
//                    a.DAT_INC_CTR_SEM_HORA	>= CONVERT(VARCHAR(10), '$dataini', 101)	
//                    AND a.DAT_INC_CTR_SEM_HORA	<  CONVERT(VARCHAR(10), DATEADD(DAY,1,'$datafim' ) , 101) 
//                    and a.IND_LIMITE <> 'P'
//                    AND a.NUM_PDV > 0
//                    and a.COD_TIP_CONVENIO is null
//                GROUP BY
//                    a.DAT_INC_CTR_SEM_HORA,
//                    a.COD_LOCAL_CTR,
//                    a.NUM_PDV
//                ORDER BY
//                    a.DAT_INC_CTR_SEM_HORA,
//                    a.COD_LOCAL_CTR,
//                    a.NUM_PDV ";}
//                    
//                    
//                    elseif($tipVenda == "3") {
//
//            $sql =" SELECT
//                        a.COD_LOCAL_CTR			as	'LOJA',
//                        a.NUM_PDV				as	'PDV',
//                        count(*)				as	'QUANTIDADE',
//                        sum(a.VAL_FINANC)		as	'VALOR'
//                    FROM
//                        DBO_CRE.dbo.CONTRATOS_COP_0014T			a	(NOLOCK)
//                    WHERE
//                                a.DAT_INC_CTR_SEM_HORA	>=	CONVERT(VARCHAR(10), '$dataini', 101)
//                        and     a.DAT_INC_CTR_SEM_HORA   <      CONVERT(VARCHAR(10), DATEADD(DAY,1,'$datafim' ) , 101)
//                        and     a.COD_TIP_CONVENIO		=	2
//                       
//                 GROUP BY
//                        a.DAT_INC_CTR_SEM_HORA,
//                        a.COD_LOCAL_CTR,
//                        a.NUM_PDV ";
//            
//                    } elseif($tipVenda == "4") {
//                      
//            $sql =" SELECT
//                        a.COD_LOCAL_CTR			as	'LOJA',
//                        a.NUM_PDV				as	'PDV',
//                        count(*)				as	'QUANTIDADE',
//                        sum(a.VAL_FINANC)		as	'VALOR'
//                    FROM
//                        DBO_CRE.dbo.CONTRATOS_COP_0014T			a	(NOLOCK)
//                    WHERE
//                                a.DAT_INC_CTR_SEM_HORA	>=	CONVERT(VARCHAR(10), '$dataini', 101)
//                        and     a.DAT_INC_CTR_SEM_HORA   <      CONVERT(VARCHAR(10), DATEADD(DAY,1,'$datafim' ) , 101)
//                        and     a.COD_TIP_CONVENIO		=	1
//                       
//                 GROUP BY
//                        a.DAT_INC_CTR_SEM_HORA,
//                        a.COD_LOCAL_CTR,
//                        a.NUM_PDV ";  
//                        
//                        
//                    } elseif ($tipVenda == "2")  {
//                        
//                        $sql =" SELECT
//                        a.COD_LOCAL_CTR			as	'LOJA',
//                        a.NUM_PDV				as	'PDV',
//                        count(*)				as	'QUANTIDADE',
//                        sum(a.VAL_FINANC)		as	'VALOR'
//                    FROM
//                        DBO_CRE.dbo.CONTRATOS_COP_0014T			a	(NOLOCK)
//                    WHERE
//                                a.DAT_INC_CTR_SEM_HORA	>=	CONVERT(VARCHAR(10), '$dataini', 101)
//                        and     a.DAT_INC_CTR_SEM_HORA   <      CONVERT(VARCHAR(10), DATEADD(DAY,1,'$datafim' ) , 101)
//                        and     a.IND_LIMITE = 'P'
//                        and     a.NUM_PDV >= '1'
//                        and     a.DAT_CAN_CTR_SEM_HORA is null 
//                        
//       
//                 GROUP BY
//                         a.COD_LOCAL_CTR,
//                        a.NUM_PDV
//                 ORDER BY 
//                         a.COD_LOCAL_CTR"; 
//                        
//                        
//                    } else {
//                        
//                  $sql = " SELECT a.COD_LOCAL_CTR as 'LOJA'
//                                , a.NUM_PDV as 'PDV'
//                                , count(*) as 'QUANTIDADE'
//                                , sum(a.VAL_FINANC) as 'VALOR' 
//                           FROM DBO_CRE.dbo.CONTRATOS_COP_0014T a (NOLOCK) 
//                           WHERE a.DAT_INC_CTR_SEM_HORA >= CONVERT(VARCHAR(10), '$dataini', 101)
//                                 AND a.DAT_INC_CTR_SEM_HORA < CONVERT(VARCHAR(10), DATEADD(DAY,1,'$datafim' ) , 101) 
//                                AND a.NUM_PDV > 0
//                                AND a.NUM_PDV = '$pdv'
//                                and a.COD_TIP_CONVENIO is null 
//                                and COD_FUNC_INC <> 0
//                                GROUP BY a.DAT_INC_CTR_SEM_HORA, a.COD_LOCAL_CTR, a.NUM_PDV 
//                                ORDER BY a.DAT_INC_CTR_SEM_HORA, a.COD_LOCAL_CTR, a.NUM_PDV";
//                        
//                        
//                    }
//        } else {
//        
//        if($tipVenda == "1"){
//        
//        $sql = "SELECT
//                    a.COD_LOCAL_CTR			as	'LOJA',
//                    a.NUM_PDV				as	'PDV',
//                    count(*)				as	'QUANTIDADE',
//                    sum(a.VAL_FINANC)		as	'VALOR'
//                FROM DBO_CRE.dbo.CONTRATOS_COP_0014T			a	(NOLOCK)
//                WHERE
//                    a.DAT_INC_CTR_SEM_HORA	>= CONVERT(VARCHAR(10), '$dataini', 101)	
//                    AND a.DAT_INC_CTR_SEM_HORA	<  CONVERT(VARCHAR(10), DATEADD(DAY,1,'$datafim' ) , 101) 
//                    and a.IND_LIMITE <> 'P'
//                    AND a.COD_LOCAL_CTR = '$loja'
//                    AND a.NUM_PDV > 0
//                   and a.COD_TIP_CONVENIO is null
//                GROUP BY
//                    a.DAT_INC_CTR_SEM_HORA,
//                    a.COD_LOCAL_CTR,
//                    a.NUM_PDV
//                ORDER BY
//                    a.DAT_INC_CTR_SEM_HORA,
//                    a.COD_LOCAL_CTR,
//                    a.NUM_PDV "; }
//                    
//                    elseif($tipVenda == "3") {
//
//            $sql =" SELECT
//                        a.COD_LOCAL_CTR			as	'LOJA',
//                        a.NUM_PDV				as	'PDV',
//                        count(*)				as	'QUANTIDADE',
//                        sum(a.VAL_FINANC)		as	'VALOR'
//                    FROM
//                        DBO_CRE.dbo.CONTRATOS_COP_0014T			a	(NOLOCK)
//                    WHERE
//                                a.DAT_INC_CTR_SEM_HORA	>=	CONVERT(VARCHAR(10), '$dataini', 101)
//                        and     a.DAT_INC_CTR_SEM_HORA   <      CONVERT(VARCHAR(10), DATEADD(DAY,1,'$datafim' ) , 101)
//                        and     a.COD_TIP_CONVENIO		=	2
//                        and     a.COD_LOCAL_CTR  = '$loja'        
//                 GROUP BY
//                        a.DAT_INC_CTR_SEM_HORA,
//                        a.COD_LOCAL_CTR,
//                        a.NUM_PDV ";
//                    } elseif($tipVenda == "4") {
//                      
//            $sql =" SELECT
//                        a.COD_LOCAL_CTR			as	'LOJA',
//                        a.NUM_PDV				as	'PDV',
//                        count(*)				as	'QUANTIDADE',
//                        sum(a.VAL_FINANC)		as	'VALOR'
//                    FROM
//                        DBO_CRE.dbo.CONTRATOS_COP_0014T			a	(NOLOCK)
//                    WHERE
//                                a.DAT_INC_CTR_SEM_HORA	>=	CONVERT(VARCHAR(10), '$dataini', 101)
//                        and     a.DAT_INC_CTR_SEM_HORA   <      CONVERT(VARCHAR(10), DATEADD(DAY,1,'$datafim' ) , 101)
//                        and     a.COD_TIP_CONVENIO		=	1
//                        and     a.COD_LOCAL_CTR  = '$loja'        
//                 GROUP BY
//                        a.DAT_INC_CTR_SEM_HORA,
//                        a.COD_LOCAL_CTR,
//                        a.NUM_PDV ";  
//                        
//                        
//                    } elseif ($tipVenda == "2") {
//                        
//                        $sql =" SELECT
//                        a.COD_LOCAL_CTR			as	'LOJA',
//                        a.NUM_PDV				as	'PDV',
//                        count(*)				as	'QUANTIDADE',
//                        sum(a.VAL_FINANC)		as	'VALOR'
//                    FROM
//                        DBO_CRE.dbo.CONTRATOS_COP_0014T			a	(NOLOCK)
//                    WHERE
//                                a.DAT_INC_CTR_SEM_HORA	>=	CONVERT(VARCHAR(10), '$dataini', 101)
//                        and     a.DAT_INC_CTR_SEM_HORA   <      CONVERT(VARCHAR(10), DATEADD(DAY,1,'$datafim' ) , 101)
//                        and     a.IND_LIMITE = 'P'
//                        and     a.COD_LOCAL_CTR  = '$loja'   
//                        and     a.NUM_PDV >= '1'
//                        and     a.DAT_CAN_CTR_SEM_HORA is null 
//                        
//       
//                 GROUP BY
//                        
//                        a.COD_LOCAL_CTR,
//                        a.NUM_PDV"; 
//                        
//                        
//                    } else {
//                        
//                         $sql = " SELECT a.COD_LOCAL_CTR as 'LOJA'
//                                , a.NUM_PDV as 'PDV'
//                                , count(*) as 'QUANTIDADE'
//                                , sum(a.VAL_FINANC) as 'VALOR' 
//                           FROM DBO_CRE.dbo.CONTRATOS_COP_0014T a (NOLOCK) 
//                           WHERE a.DAT_INC_CTR_SEM_HORA >= CONVERT(VARCHAR(10), '$dataini', 101)
//                                 AND a.DAT_INC_CTR_SEM_HORA < CONVERT(VARCHAR(10), DATEADD(DAY,1,'$datafim' ) , 101) 
//                                AND a.NUM_PDV > 0
//                                AND a.NUM_PDV = '$pdv'
//                                and a.COD_TIP_CONVENIO is null 
//                                and COD_FUNC_INC <> 0
//                                and a.COD_LOCAL_CTR = '$loja'
//                                GROUP BY a.DAT_INC_CTR_SEM_HORA, a.COD_LOCAL_CTR, a.NUM_PDV 
//                                ORDER BY a.DAT_INC_CTR_SEM_HORA, a.COD_LOCAL_CTR, a.NUM_PDV";
//                        
//                    }
//        
//        
//        }   
//            
//
//        $stid = mssql_query($sql, $connMSSQL);
//        return $stid;
//        
//        
//    }
//        
//    
//    public function retornaVendaEmporium($loja, $pdv, $dataini, $datafim,$tipVenda )
//    {
//        if($tipVenda == "1"){
//            
//            
//            $sql = "SELECT quantity as qtdVendas
//                          ,amount as SomaValor
//                          ,quantity_canc as SomaCan
//                          ,(SELECT SUM(amount_canc)
//                            FROM 
//                                accum_media
//                            WHERE 
//                                 fiscal_date = '$dataini'
//                                 and store_key = '$loja'
//                                 and pos_number = '$pdv'
//                                 and media_id =  '11') as totalCanc
//                           ,(SELECT quantity_canc
//                            FROM 
//                                accum_media
//                            WHERE 
//                                 fiscal_date = '$dataini'
//                                 and store_key = '$loja'
//                                 and pos_number = '$pdv'
//                                 and media_id =  '11') as nCanc
//                    FROM
//                          accum_media
//                    WHERE
//                         fiscal_date = '$dataini'
//                         and store_key = '$loja'
//                         and pos_number = '$pdv'
//                         and media_id =  '11'
//                           ";
//            
//
//            }
//        
//                    
//                    elseif($tipVenda == "3") {
//
//                 $sql="SELECT quantity as qtdVendas
//                          ,amount as SomaValor
//                          ,quantity_canc as SomaCan
//                          ,(SELECT SUM(amount_canc)
//                            FROM 
//                                accum_media
//                            WHERE 
//                                 fiscal_date = '$dataini'
//                                 and store_key = '$loja'
//                                 and media_id =  '13') as totalCanc
//                    FROM
//                          accum_media
//                    WHERE
//                         fiscal_date = '$dataini'
//                         and store_key = '$loja'
//                         and pos_number = '$pdv'
//                         and media_id =  '13'";
//                        }
//                        elseif($tipVenda == "4")
//                        {
//                              $sql="SELECT quantity as qtdVendas
//                          ,amount as SomaValor
//                          ,quantity_canc as SomaCan
//                          ,(SELECT SUM(amount_canc)
//                            FROM 
//                                accum_media
//                            WHERE 
//                                 fiscal_date = '$dataini'
//                                 and store_key = '$loja'
//                                 and media_id =  '23') as totalCanc
//                    FROM
//                          accum_media
//                    WHERE
//                         fiscal_date = '$dataini'
//                         and store_key = '$loja'
//                         and pos_number = '$pdv'
//                         and media_id =  '23'";
//                            
//                        }
//                        elseif ($tipVenda == '2')
//                        {
//                                  $sql="SELECT 
//                            count(*) qtdVendas
//                           , sum(ValorDaOperacao) SomaValor
//                           , TipoDeOperacao as tipoOp 
//                           ,(SELECT amount_canc 
//                            FROM accum_media 
//                            WHERE store_key = '$loja' 
//                            and pos_number = '$pdv' 
//                            and fiscal_date =  '$dataini' 
//                            and media_id = '14') totalCanc
//                             ,(SELECT quantity_canc 
//                            FROM accum_media 
//                            WHERE store_key = '$loja' 
//                            and pos_number = '$pdv' 
//                            and fiscal_date =  '$dataini' 
//                            and media_id = '14') nCanc
//                        FROM
//                            ft094_ems 
//                        WHERE 
//                            DataPDV between date_format('$dataini', '%Y%m%d' ) and date_format('$datafim', '%Y%m%d') 
//                            and CodigoDaLoja = '$loja'
//                            and NumeroDoPDV = '$pdv'
//                            and TipoDeOperacao = '112'
//                            and Status <> '3'";
//                            
//                        } else {
//                            
//                            if($loja == "0"){
//                            
//                            $sql = "SELECT s.store_key as loja, sum(s.amount_due) as soma, s.pos_number as pdv, 
//                                count(*) as qtd
//                                      FROM sale s
//                                       inner join sale_media sm
//                                      ON( s.store_key     > 0
//                                        AND s.pos_number    > 0
//                                        AND s.ticket_number > 0
//                                        AND s.voided        = 0
//                                        AND s.sale_type     = 0
//                                        AND s.void_ticket_number IS NULL
//                                        AND sm.store_key    = s.store_key
//                                        AND sm.pos_number   = s.pos_number
//                                        AND sm.ticket_number= s.ticket_number
//                                        AND sm.start_time   = s.start_time
//                                        AND sm.media_id  = '7'
//                                        AND s.fiscal_date   = '$dataini')
//                                        group by s.store_key,  sm.media_id
//"; } else {
//    
//        $sql = "SELECT s.store_key as loja, sum(s.amount_due) as soma, s.pos_number as pdv, 
//                                count(*) as qtd
//                                      FROM sale s
//                                       inner join sale_media sm
//                                      ON( s.store_key     > 0
//                                        AND s.pos_number    > 0
//                                        AND s.ticket_number > 0
//                                        AND s.voided        = 0
//                                        AND s.sale_type     = 0
//                                        AND s.void_ticket_number IS NULL
//                                        AND sm.store_key    = s.store_key
//                                        AND sm.pos_number   = s.pos_number
//                                        AND sm.ticket_number= s.ticket_number
//                                        AND sm.start_time   = s.start_time
//                                        AND sm.media_id  = '7'
//                                        AND s.fiscal_date   = '$dataini'
//                                        AND s.store_key = '$loja')
//                                       
//                                        group by s.store_key,  sm.media_id";
//    
//    
//}
//                        }
//                    
//                   
//     
//        return $this->query($sql);
//        
//    }
//    
//    
//    
//    
//    public function retornaComboPag()
//    {
//        $connMSSQL = $this->consulta;
//        
//        $sql = "SELECT DISTINCT 
//                    substring(a.DSC_LOCAL_PAG,1,3)	as	'LOJA'
//                FROM
//                    DBO_CRE.dbo.ACERTO_PAG_PARCELAS_CTR_0140T a	(NOLOCK)
//                WHERE 
//                    substring(a.DSC_LOCAL_PAG,1,3) < 014
//                    AND substring(a.DSC_LOCAL_PAG,1,3) <> 009
//                    AND substring(a.DSC_LOCAL_PAG,1,3) <> 010
//                ORDER BY 
//                    substring(a.DSC_LOCAL_PAG,1,3) ASC ";
//        
//        $stid = mssql_query($sql, $connMSSQL);
//        return $stid;
//   }
//   
//    public function retornaNomeLojaPag($loja)
//    {         
//         if ($loja == 001)
//         {
//            $nLoja = "Itaquera";
//         }
//         elseif($loja == 002)
//         {
//            $nLoja = "Oratório";
//         }
//         elseif($loja == 003)
//         {
//            $nLoja = "Guaianazes";
//         } 
//         elseif($loja == 004)
//         {
//            $nLoja = "São Miguel";
//         } 
//         elseif ($loja == 005){
//            $nLoja = "Itaim Paulista";
//         } 
//         elseif($loja == 006){
//            $nLoja = "Suzano";
//         }
//         elseif($loja == 007)
//         {
//            $nLoja = "Mogi das Cruzes";
//         } 
//         elseif ($loja == '012')
//         {
//            $nLoja = "São Bernardo do Campo";
//         } 
//         elseif ($loja == '013') 
//         {
//            $nLoja = "Taboão da Serra";
//         }
//         else 
//         {
//             $nLoja = "Todas";
//         }
//
//         return $nLoja;
//
//    }
//    
//    public function formataReais($valor1, $valor2, $operacao)
//    {
//        
//        //tirar , do valor
//        
//        $valor1 = str_replace(",", "", $valor1);
//        $valor2 = str_replace(",", "", $valor2);
//        
//        //indentifica operação
//        
//        switch ($operacao)
//        {
//            
//            case "+":
//                $resultado =  $valor1 + $valor2;
//                break;
//            case "-":
//                $resultado = $valor1 - $valor2;
//                break;
//            case "*":
//                $resultado = $valor1 = $valor2;
//                break;
//        }
//        
// 
//        
//        return $resultado;
//      
//        }
//        
//        public function totalValores($resultado)
//        {
//            
//          //calcula tamanho resultado
//        
//        $len = strlen($resultado);
//        
//        switch($len)
//        {
//            case "2":
//                $retorna = "0,$resultado";
//                break;
//            case "3":
//                $d1 = substr("$resultado",0,1);
//                $d2 = substr("$resultado",-2,2);
//                $retorna = "$d1,$d2";
//               break;
//            case "4":
//               $d1 = substr("$resultado",0,2);
//                $d2 = substr("$resultado",-2,2);
//                $retorna = "$d1,$d2";
//                break;
//            case "5":
//                $d1 = substr("$resultado",0,3);            
//                $d2 = substr("$resultado",-2,2);
//                $retorna = "$d1,$d2";            
//                break;
//            case "6":
//                $d1 = substr("$resultado",1,3);            
//                $d2 = substr("$resultado",-2,2);
//                $d3 = substr("$resultado",0,1);
//                $retorna = "$d3$d1,$d2";
//                break;
//            case "7":
//                $d1 = substr("$resultado",2,3);
//                $d2 = substr("$resultado",-2,2);            
//                $d3 = substr("$resultado",0,2);            
//                $retorna = "$d3$d1,$d2";
//                break;
//            case "8":
//                $d1 = substr("$resultado",3,3);
//                $d2 = substr("$resultado",-2,2);
//                $d3 = substr("$resultado",0,3);            
//                $retorna = "$d3$d1,$d2";            
//                break;
//        }
//        
//        return $retorna;
//            
//        }
//        
//        public function retornaComboVend()
//        {
//            $connMSSQL = $this->consulta;
//            
//        $sql =    "SELECT DISTINCT 
//                        a.COD_LOCAL_CTR    as	'LOJA'
//                   FROM 
//                        DBO_CRE.dbo.CONTRATOS_COP_0014T	a (NOLOCK)
//                   WHERE 
//                        a.COD_LOCAL_CTR < 19 ";
//        
//        
//        $stid = mssql_query($sql, $connMSSQL);
//        return $stid;
//        }
//           public function retornaNomeLojaVend($loja)
//    {         
//         if ($loja == 1)
//         {
//            $nLoja = "Itaquera";
//         }
//         elseif($loja == 2)
//         {
//            $nLoja = "Oratório";
//         }
//         elseif($loja == 3)
//         {
//            $nLoja = "Guaianazes";
//         } 
//         elseif($loja == 4)
//         {
//            $nLoja = "São Miguel";
//         } 
//         elseif ($loja == 5){
//            $nLoja = "Itaim Paulista";
//         } 
//         elseif($loja == 6){
//            $nLoja = "Suzano";
//         }
//         elseif($loja == 7)
//         {
//            $nLoja = "Mogi das Cruzes";
//         } 
//           elseif($loja == 8)
//         {
//            $nLoja = "Drog. Itaquera";
//         } 
//           elseif($loja == 9)
//         {
//            $nLoja = "Drog. Mogi";
//         } 
//           elseif($loja == '10')
//         {
//            $nLoja = "Drog. Guaianazes";
//         } 
//           elseif($loja == '11')
//         {
//            $nLoja = "Drog. SBC";
//         } 
//         elseif ($loja == '12')
//         {
//            $nLoja = "São Bernardo do Campo";   
//         } 
//         elseif($loja == '13') 
//         {
//            $nLoja = "Taboão da Serra";
//         }
//           elseif($loja == '14')
//         {
//            $nLoja = "Drog. Taboão";
//         } 
//           elseif($loja == '15')
//         {
//            $nLoja = "Posto Taboão";
//         } 
//           elseif($loja == '16')
//         {
//            $nLoja = "Posto Suzano";
//         } 
//         elseif($loja == '17')
//         {
//             $nLoja = "Posto SBC";
//         }
//         else {
//             
//             $nLoja = "Drog. São Miguel";
//         }
//
//         return $nLoja;
//
//    }
//    
//    public function retornaCancelEms($pdv, $loja, $dataini) {
//        
//        $connMSSQL = $this->consulta;
//        
//        $sql = "SELECT 
//                    b.VAL_FINANC as 'VAL_CAN',
//                    count(*) as 'QUANTIDADE'  
//                from DBO_CRE.dbo.CONTRATOS_COP_0014T as b
//               WHERE
//                    b.DAT_INC_CTR_SEM_HORA = '$dataini'
//                    and b.NUM_PDV = '$pdv'
//                    and b.COD_LOCAL_CAN = '$loja'
//                    and	(b.TIP_APR_CTR='0' or b.COD_TIP_CONVENIO is not null)
//                    and	b.COD_LOCAL_CAN is not null 
//                    group by b.COD_LOCAL_CAN,  b.VAL_FINANC, b.NUM_PDV ";
//
//        $stid = mssql_query($sql, $connMSSQL);
//        return $stid;
//        
//    }
//    
//    public function retornaCancelPagEms($pdv, $loja, $dataini, $datafim) {
//        
//        $connMSSQL=  $this->consulta;
//        
//        $sql="SELECT 
//                convert(char(10),a.DAT_CAN,103)	as	'DATA',
//                substring(a.DSC_LOCAL_PAG,1,3)	as	'LOJA',
//                substring(a.DSC_LOCAL_PAG,4,3)	as	'PDV',
//                count(*)						as	'QUANTIDADE',
//                sum(a.VAL_PAG)					as	'VALOR'
//            FROM
//                DBO_CRE.dbo.ACERTO_PAG_PARCELAS_CTR_0140T			a	(NOLOCK)
//            WHERE
//                        a.DAT_PAG >=	CONVERT(VARCHAR(10), '$dataini', 101)
//                and	a.DAT_PAG <	CONVERT(VARCHAR(10), DATEADD(DAY,1,'$datafim' ) , 101)
//                and	a.TIP_LOCAL_PAG_PARC_CTR	=	0
//                and     substring(a.DSC_LOCAL_PAG,1,3) =       '$loja'
//                and     substring(a.DSC_LOCAL_PAG,4,3) = '$pdv'   
//                and     a.DAT_CAN IS NOT NULL
//            GROUP BY
//                convert(char(10),a.DAT_CAN,103),
//                substring(a.DSC_LOCAL_PAG,1,3),
//                substring(a.DSC_LOCAL_PAG,4,3)";
//        
//            $stid = mssql_query($sql, $connMSSQL);
//        return $stid;
//    }
//    
//    public function retornaEstornoEmp($pdv, $loja, $data) {
//        
//        $sql = "select * from 
//                    accum_media 
//                    where 
//                    fiscal_date = '$data' 
//                    and media_id = '21'
//                    and pos_number = '$pdv'
//                    and quantity <> '0'
//                    and store_key = '$loja'";
//        
//        echo $sql."<br>";
//        
//         return $this->query($sql);
//        
//    }
//   
//   public function retornaListarPdvPag($dataini, $datafim, $loja, $pdv) {
//       
//       $connMSSQL=  $this->consulta;
//       
//       $sql="SELECT 
//                a.DAT_PAG	as	'DATA', 
//                substring(a.DSC_LOCAL_PAG,1,3)	as	'LOJA',
//                substring(a.DSC_LOCAL_PAG,4,3)	as	'PDV',
//                a.VAL_PAG			as	'VALOR',
//                c.NOM_CLIENTE			as	'NOME',
//                c.CPF_CLIENTE			as	'CPF'
//            FROM
//                DBO_CRE.dbo.ACERTO_PAG_PARCELAS_CTR_0140T	a	(NOLOCK),
//                DBO_CRE.dbo.CONTRATOS_0109T			b	(NOLOCK),
//                DBO_CRE.dbo.CLIENTE_CORP_0116T			c	(NOLOCK)
//           WHERE
//                        a.DAT_PAG	>=	CONVERT(VARCHAR(10), '$dataini', 101)
//                and	a.DAT_PAG	<	CONVERT(VARCHAR(10), DATEADD(DAY,1,'$datafim' ) , 101)
//                and	cast(substring(a.DSC_LOCAL_PAG,1,3) as int)	=	$loja
//                and	cast(substring(a.DSC_LOCAL_PAG,4,3) as int)	=	$pdv
//                and	a.TIP_LOCAL_PAG_PARC_CTR			=	0
//                and	a.COD_LOCAL_CTR					=	b.COD_LOCAL_CTR
//                and	a.NUM_CTR					=	b.NUM_CTR
//                and	b.COD_LOCAL_CLIENTE				=	c.COD_LOCAL_CLIENTE
//                and	b.COD_CLIENTE					=	c.COD_CLIENTE
//            ORDER BY
//                a.DAT_PAG  ";
//       
//       
//          $stid = mssql_query($sql, $connMSSQL);
//        return $stid;
//       
//   }
//   
//   public function retornaListarPdvVenda($dataini, $datafim, $loja, $pdv) {
//           
//       $connMSSQL=  $this->consulta;
//       
//       $sql = "SELECT 
//                    convert(char(10),a.DAT_INC_CTR_SEM_HORA,103)	as	'DATA',
//                    a.COD_LOCAL_CTR			as	'LOJA',
//                    a.NUM_PDV				as	'PDV',
//                    isnull(DBO_CRE.dbo.ufn_TipContratoConvenio(a.COD_TIP_CONVENIO),'Cartão Private') as 'TIPO',
//                    case when (a.IND_LIMITE = 'P') then 'Parcelado' else 'Rotativo' end as 'LIMITE',
//                    a.VAL_FINANC            as  	'VALOR',
//                    a.QTD_PARC_FIN_CTR      as  	'QTD.PARCELAS',
//                    b.CPF_CLIENTE           as  	'CPF',
//                    b.NOM_CLIENTE           as          'NOME'
//               FROM 
//                    DBO_CRE.dbo.CONTRATOS_COP_0014T			a	(NOLOCK),	
//                    DBO_CRE.dbo.CLIENTE_CORP_0116T			b	(NOLOCK)
//               WHERE
//                        a.DAT_INC_CTR_SEM_HORA	>=      CONVERT(VARCHAR(10), '$dataini', 101)
//                    and a.DAT_INC_CTR_SEM_HORA  <       CONVERT(VARCHAR(10), DATEADD(DAY,1,'$datafim' ) , 101)
//                    and	a.COD_LOCAL_CTR		=	$loja
//                    and	a.NUM_PDV               =	$pdv
//                    and	(a.TIP_APR_CTR='0' or a.COD_TIP_CONVENIO is not null)
//                    and	a.COD_LOCAL_CLIENTE		=	b.COD_LOCAL_CLIENTE
//                    and	a.COD_CLIENTE			=	b.COD_CLIENTE
//              ORDER BY
//                    a.DAT_INC_CTR_SEM_HORA,
//                    a.COD_LOCAL_CTR,
//                    a.NUM_PDV,
//                    a.DAT_INC_CTR,
//                    isnull(DBO_CRE.dbo.ufn_TipContratoConvenio(a.COD_TIP_CONVENIO),'Cartão Private'),
//                    case when (a.IND_LIMITE = 'P') then 'Parcelado' else 'Rotativo' end,
//                    b.CPF_CLIENTE";
//   
//       $stid = mssql_query($sql, $connMSSQL);
//        return $stid;
//       
//   }
//   
//   public function retornaListaCancelamentoPag($dataini, $datafim, $loja, $pdv) {
//        $connMSSQL=  $this->consulta;
//       
//       
//     $sql ="  SELECT 
//                convert(char(10),a.DAT_CAN,103)	as	'DATA',
//                substring(a.DSC_LOCAL_PAG,1,3)	as	'LOJA',
//                substring(a.DSC_LOCAL_PAG,4,3)	as	'PDV',
//                a.VAL_PAG                       as	'VALOR',
//                c.NOM_CLIENTE                   as	'NOME',
//                c.CPF_CLIENTE			as	'CPF'
//            FROM
//                DBO_CRE.dbo.ACERTO_PAG_PARCELAS_CTR_0140T			a	(NOLOCK),
//                DBO_CRE.dbo.CONTRATOS_0109T							b	(NOLOCK),
//                DBO_CRE.dbo.CLIENTE_CORP_0116T						c	(NOLOCK)
//            WHERE
//                        a.DAT_CAN                                       >=	CONVERT(VARCHAR(10), '$dataini', 101)
//                and	a.DAT_CAN					<	CONVERT(VARCHAR(10), DATEADD(DAY,1,'$datafim' ) , 101)   
//                and	cast(substring(a.DSC_LOCAL_PAG,1,3) as int)	=	$loja
//                and	cast(substring(a.DSC_LOCAL_PAG,4,3) as int)	=	$pdv
//                and	a.TIP_LOCAL_PAG_PARC_CTR			=	0
//                and	a.COD_LOCAL_CTR                                 =	b.COD_LOCAL_CTR
//                and	a.NUM_CTR					=	b.NUM_CTR
//                and	b.COD_LOCAL_CLIENTE				=	c.COD_LOCAL_CLIENTE
//                and	b.COD_CLIENTE					=	c.COD_CLIENTE
//            ORDER BY
//	
//                a.DAT_CAN ";
//     
//                
//       $stid = mssql_query($sql, $connMSSQL);
//        return $stid;
//       
//   }
//   
//   public function retornaListaCancelamentoVend($dataini, $datafim, $loja, $pdv) {
//       
//               $connMSSQL=  $this->consulta;
//       
//       $sql = "SELECT 
//                    convert(char(10),a.DAT_CAN_CTR_SEM_HORA,103)	as	'DATA',
//                    a.COD_LOCAL_CTR			as	'LOJA',
//                    a.NUM_PDV				as	'PDV',
//                    isnull(DBO_CRE.dbo.ufn_TipContratoConvenio(a.COD_TIP_CONVENIO),'Cartão Private') as 'TIPO',
//                    case when (a.IND_LIMITE = 'P') then 'Parcelado' else 'Rotativo' end as 'LIMITE',
//                    a.VAL_FINANC			as	'VALOR',
//                    a.QTD_PARC_FIN_CTR		as	'QTD.PARCELAS',
//                    b.CPF_CLIENTE			as	'CPF',
//                    b.NOM_CLIENTE           as 'NOME'
//               FROM
//                    DBO_CRE.dbo.CONTRATOS_COP_0014T			a	(NOLOCK),
//                    DBO_CRE.dbo.CLIENTE_CORP_0116T			b	(NOLOCK)
//WHERE
//                        a.DAT_CAN_CTR_SEM_HORA	>=	CONVERT(VARCHAR(10), '$dataini', 101)
//                    and a.DAT_CAN_CTR_SEM_HORA  <	CONVERT(VARCHAR(10), DATEADD(DAY,1,'$datafim' ) , 101)   
//                    and	a.COD_LOCAL_CTR		= $loja
//                    and	a.NUM_PDV		=	$pdv
//                    and	(a.TIP_APR_CTR='0' or a.COD_TIP_CONVENIO is not null)
//                    and	a.COD_LOCAL_CAN is not null -- Para desconsiderar cancelamento de fatura
//                    and	a.COD_LOCAL_CLIENTE		=	b.COD_LOCAL_CLIENTE
//                    and	a.COD_CLIENTE			=	b.COD_CLIENTE
//               ORDER BY
//                    a.DAT_CAN_CTR_SEM_HORA";
//        
//       $stid = mssql_query($sql, $connMSSQL);
//        return $stid;
//
//   }
//   
//   public function retornaListaCancelVoucher($dataini, $datafim, $loja, $pdv) {
//       
//        $connMSSQL=  $this->consulta;
//       
//       $sql = "SELECT 
//                        convert(char(10),a.DAT_INC_CTR_SEM_HORA,103)	as	'DATA',
//                        a.COD_LOCAL_CTR			as	'LOJA',
//                        a.NUM_PDV				as	'PDV',
//                        isnull(DBO_CRE.dbo.ufn_TipContratoConvenio(a.COD_TIP_CONVENIO),'Cartão Private') as 'TIPO',
//                        case when (a.IND_LIMITE = 'P') then 'Parcelado' else 'Rotativo' end as 'LIMITE',
//                        a.VAL_FINANC			as	'VALOR',
//                        a.QTD_PARC_FIN_CTR		as	'QTD.PARCELAS',
//                        b.CPF_CLIENTE			as	'CPF'
//               FROM
//                        DBO_CRE.dbo.CONTRATOS_COP_0014T			a	(NOLOCK),
//                        DBO_CRE.dbo.CLIENTE_CORP_0116T			b	(NOLOCK)
//               WHERE
//                                a.DAT_INC_CTR_SEM_HORA          >=      CONVERT(VARCHAR(10), '$dataini', 101)
//                        and     a.DAT_INC_CTR_SEM_HORA          <       CONVERT(VARCHAR(10), DATEADD(DAY,1,'$datafim' ) , 101)
//                        and	a.COD_LOCAL_CTR			=	$loja
//                        and	a.NUM_PDV			=	$pdv
//                        and	a.COD_TIP_CONVENIO		=	2
//                        and	a.COD_LOCAL_CLIENTE		=	b.COD_LOCAL_CLIENTE
//                        and	a.COD_CLIENTE			=	b.COD_CLIENTE
//               ORDER BY
//                        a.DAT_INC_CTR_SEM_HORA,
//                        a.COD_LOCAL_CTR,
//                        a.NUM_PDV,
//                        a.DAT_INC_CTR,
//                        isnull(DBO_CRE.dbo.ufn_TipContratoConvenio(a.COD_TIP_CONVENIO),'Cartão Private'),
//                        case when (a.IND_LIMITE = 'P') then 'Parcelado' else 'Rotativo' end,
//                        b.CPF_CLIENTE";
//       
//       
//       
//           $stid = mssql_query($sql, $connMSSQL);
//        return $stid;
//   }
//   
//   public function cancelVendaEmporium($loja, $dataini, $datafim, $pdv) {
//         if($tipVenda == "1"){
//        
//        $sql ="SELECT 
//                    count(*) qtdVendas
//                   , sum(ValorDaOperacao) SomaValor
//                   ,(select sum(ValorDaOperacao)
//                        FROM
//                            ft094_ems 
//                        WHERE 
//                            DataPDV between date_format('$dataini', '%Y%m%d' ) and date_format('$datafim', '%Y%m%d') 
//                            and CodigoDaLoja = $loja
//                            and NumeroDoPDV = $pdv
//                            and TipoDeOperacao = '212') SomaCan
//                FROM
//                    ft094_ems 
//                WHERE 
//                    DataPDV between date_format('$dataini', '%Y%m%d' ) and date_format('$datafim', '%Y%m%d') 
//                    and CodigoDaLoja = $loja
//                    and NumeroDoPDV = $pdv
//                    and TipoDeOperacao = '111'
//                    and Status  = '3' "; }
//                    
//                    elseif($tipVenda == "3") {
//
//                 $sql="SELECT 
//                            count(*) qtdVendas
//                           , sum(ValorDaOperacao) SomaValor
//                        FROM
//                            ft094_ems 
//                        WHERE 
//                            DataPDV between date_format('$dataini', '%Y%m%d' ) and date_format('$datafim', '%Y%m%d') 
//                            and CodigoDaLoja = '$loja'
//                            and NumeroDoPDV = '$pdv'
//                            and TipoDeOperacao = '114'
//                            and Status = '3'";
//                        }
//                        elseif($tipVenda == "4")
//                        {
//                              $sql="SELECT 
//                            count(*) qtdVendas
//                           , sum(ValorDaOperacao) SomaValor
//                        FROM
//                            ft094_ems 
//                        WHERE 
//                            DataPDV between date_format('$dataini', '%Y%m%d' ) and date_format('$datafim', '%Y%m%d') 
//                            and CodigoDaLoja = '$loja'
//                            and NumeroDoPDV = '$pdv'
//                            and TipoDeOperacao = '113'
//                            and Status = '3'";
//                            
//                        }
//                        else
//                        {
//                                  $sql="SELECT 
//                            count(*) qtdVendas
//                           , sum(ValorDaOperacao) SomaValor
//                        FROM
//                            ft094_ems 
//                        WHERE 
//                            DataPDV between date_format('$dataini', '%Y%m%d' ) and date_format('$datafim', '%Y%m%d') 
//                            and CodigoDaLoja = '$loja'
//                            and NumeroDoPDV = '$pdv'
//                            and TipoDeOperacao = '112'
//                            and Status = '3'";
//                            
//                        }
//                    
//      
//        return $this->query($sql);
//       
//       }
//       
//       public function cancelVendaEms($dataini, $datafim, $pdv, $loja, $tipVenda) {
//           
//           $connMSSQL = $this->consulta;
//        
//        if($tipVenda == "1"){
//        
//        $sql = "SELECT
//                    convert(char(10),a.DAT_INC_CTR_SEM_HORA,103)	as	'DATA',
//                    a.COD_LOCAL_CTR			as	'LOJA',
//                    a.NUM_PDV				as	'PDV',
//                    isnull(DBO_CRE.dbo.ufn_TipContratoConvenio(a.COD_TIP_CONVENIO),'Cartão Private') as 'TIPO',
//                    case when (a.IND_LIMITE = 'P') then 'Parcelado' else 'Rotativo' end as 'LIMITE',
//                    count(*)				as	'QUANTIDADE',
//                    sum(a.VAL_FINANC)		as	'VALOR'
//                FROM DBO_CRE.dbo.CONTRATOS_COP_0014T			a	(NOLOCK)
//                WHERE
//                    a.DAT_INC_CTR_SEM_HORA	>= CONVERT(VARCHAR(10), '$dataini', 101)	
//                    AND a.DAT_INC_CTR_SEM_HORA	<  CONVERT(VARCHAR(10), DATEADD(DAY,1,'$datafim' ) , 101) 
//                    AND	(a.TIP_APR_CTR='0' or a.COD_TIP_CONVENIO is not null)
//                    and a.IND_LIMITE <> 'P'
//                    AND a.COD_LOCAL_CTR = '$loja'
//                    AND a.NUM_PDV > 0
//                    AND a.COD_TIP_CONVENIO is null
//                    AND a.NUM_PDV = $pdv
//                    and a.DAT_CAN_CTR_SEM_HORA is not null
//                 GROUP BY
//                    a.DAT_INC_CTR_SEM_HORA,
//                    a.COD_LOCAL_CTR,
//                    a.NUM_PDV,
//                    isnull(DBO_CRE.dbo.ufn_TipContratoConvenio(a.COD_TIP_CONVENIO),'Cartão Private'),
//                    case when (a.IND_LIMITE = 'P') then 'Parcelado' else 'Rotativo' end
//                ORDER BY
//                    a.DAT_INC_CTR_SEM_HORA,
//                    a.COD_LOCAL_CTR,
//                    a.NUM_PDV,
//                    isnull(DBO_CRE.dbo.ufn_TipContratoConvenio(a.COD_TIP_CONVENIO),'Cartão Private'),
//                    case when (a.IND_LIMITE = 'P') then 'Parcelado' else 'Rotativo' end"; }
//                    
//                    elseif($tipVenda == "3") {
//
//            $sql =" SELECT
//                        a.COD_LOCAL_CTR			as	'LOJA',
//                        a.NUM_PDV				as	'PDV',
//                        count(*)				as	'QUANTIDADE',
//                        sum(a.VAL_FINANC)		as	'VALOR'
//                    FROM
//                        DBO_CRE.dbo.CONTRATOS_COP_0014T			a	(NOLOCK)
//                    WHERE
//                                a.DAT_INC_CTR_SEM_HORA	>=	CONVERT(VARCHAR(10), '$dataini', 101)
//                        and     a.DAT_INC_CTR_SEM_HORA   <      CONVERT(VARCHAR(10), DATEADD(DAY,1,'$datafim' ) , 101)
//                        and     a.COD_TIP_CONVENIO		=	2
//                        and     a.COD_LOCAL_CTR  = '$loja'  
//                        a.NUM_PDV = $pdv
//                        and a.DAT_CAN_CTR_SEM_HORA is not null
//                 GROUP BY
//                        a.DAT_INC_CTR_SEM_HORA,
//                        a.COD_LOCAL_CTR,
//                        a.NUM_PDV ";
//                    } elseif($tipVenda == "4") {
//                      
//            $sql =" SELECT
//                        a.COD_LOCAL_CTR			as	'LOJA',
//                        a.NUM_PDV				as	'PDV',
//                        count(*)				as	'QUANTIDADE',
//                        sum(a.VAL_FINANC)		as	'VALOR'
//                    FROM
//                        DBO_CRE.dbo.CONTRATOS_COP_0014T			a	(NOLOCK)
//                    WHERE
//                                a.DAT_INC_CTR_SEM_HORA	>=	CONVERT(VARCHAR(10), '$dataini', 101)
//                        and     a.DAT_INC_CTR_SEM_HORA   <      CONVERT(VARCHAR(10), DATEADD(DAY,1,'$datafim' ) , 101)
//                        and     a.COD_TIP_CONVENIO		=	1
//                        and     a.COD_LOCAL_CTR  = '$loja' 
//                        a.NUM_PDV = $pdv
//                        and a.DAT_CAN_CTR_SEM_HORA is not null
//                 GROUP BY
//                        a.DAT_INC_CTR_SEM_HORA,
//                        a.COD_LOCAL_CTR,
//                        a.NUM_PDV ";  
//                        
//                        
//                    } else {
//                        
//                        $sql =" SELECT
//                        a.COD_LOCAL_CTR			as	'LOJA',
//                        a.NUM_PDV				as	'PDV',
//                        count(*)				as	'QUANTIDADE',
//                        sum(a.VAL_FINANC)		as	'VALOR'
//                    FROM
//                        DBO_CRE.dbo.CONTRATOS_COP_0014T			a	(NOLOCK)
//                    WHERE
//                                a.DAT_INC_CTR_SEM_HORA	>=	CONVERT(VARCHAR(10), '$dataini', 101)
//                        and     a.DAT_INC_CTR_SEM_HORA   <      CONVERT(VARCHAR(10), DATEADD(DAY,1,'$datafim' ) , 101)
//                        and     a.IND_LIMITE = 'P'
//                        and     a.COD_LOCAL_CTR  = '$loja'   
//                        and     a.NUM_PDV >= '1'
//                        a.NUM_PDV = $pdv
//                        and a.DAT_CAN_CTR_SEM_HORA is not null
//                        
//       
//                 GROUP BY
//                        a.DAT_INC_CTR_SEM_HORA,
//                        a.COD_LOCAL_CTR,
//                        a.NUM_PDV "; 
//                        
//                        
//                    }
//        $stid = mssql_query($sql, $connMSSQL);
//        return $stid;
//           
//           
//           
//       }
//       
//           public function inserir($tabela,$campos)
//    {
//        $insere =  $this->exec($this->insere($tabela, $campos));
//        
//      
//  
//        return $insere;
//        
//    }
//    
//    public function retornaObs($pdv, $loja, $final, $data){
//        
//        
//        $sql = "SELECT *
//                FROM    
//                    T090_obs_totais
//                WHERE
//                    T090_data = '$data'
//                    and T090_pdv = $pdv
//                    and T090_loja = $loja
//                    and T090_finalizadora = $final";
//        
//      
//        
//        return $this->query($sql);
//        
//    }
//    
//        public function altera($tabela,$campos,$delim)
//    {
//       $conn = "";
//       
//       $altera = $this->exec($this->atualiza($tabela, $campos, $delim));
//       
//
//       
//       return $altera;
//    }
//    
//    public function excluir($tabela, $delim) {
//        
//        $conn = "";
//        
//        $exclui = $this->exec($this->exclui($tabela, $delim));
//        
//        return $exclui;
//        
//    }
//    
// 
//    public function  retornaBuscaCombo($tipBusca)
//    {
//        switch($tipBusca){
//            
//            case "":
//                
//                $busca = "<option value='1'>Diferenças        </option>
//                          <option value='0'> Todos  </option>";
//                break;
//            case "1":
//                $busca = "<option value='1'>Diferenças        </option>
//                          <option value='0'> Todos  </option>";
//                break;
//            case "0":
//                $busca = "<option value='0'>Todos        </option>
//                          <option value='1'> Diferenças  </option>";
//                break;
//        }
//        
//        return $busca;
//    }
//    
//    public function retornaFinalizadoras($tipVenda)
//    {
//        switch($tipVenda){
//            
//            case "":
//                $finalizadora = "<option value='0'>Selecione...         </option>
//                            <option value='1'> Rotativo  </option>
//                            <option value='2'> Parcelado  </option>
//                            <option value='3'> Voucher  </option>
//                            <option value='4'> Convenio  </option>
//                            <option value='5'> Ajustes  </option>";
//                break;
//            
//            case "0":
//                $finalizadora = "<option value='0'>Selecione...         </option>
//                            <option value='1'> Rotativo  </option>
//                            <option value='2'> Parcelado  </option>
//                            <option value='3'> Voucher  </option>
//                            <option value='4'> Convenio  </option>
//                            <option value='5'> Ajustes  </option>";
//                break;
//            case "1":
//                $finalizadora = "
//                            <option value='1'> Rotativo  </option>
//                            <option value='2'> Parcelado  </option>
//                            <option value='3'> Voucher  </option>
//                            <option value='4'> Convenio  </option>
//                            <option value='5'> Ajustes  </option>";
//                break;
//            case "2":
//                $finalizadora = "
//                            <option value='2'> Parcelado  </option>                            
//                            <option value='1'> Rotativo  </option>
//                            <option value='3'> Voucher  </option>
//                            <option value='4'> Convenio  </option>
//                            <option value='5'> Ajustes  </option>";
//                break;
//            case "3":
//                $finalizadora = "  
//                            <option value='3'> Voucher  </option>                    
//                            <option value='2'> Parcelado  </option>                            
//                            <option value='1'> Rotativo  </option>
//                            <option value='4'> Convenio  </option>
//                            <option value='5'> Ajustes  </option>";
//                break;
//            case "4":
//                $finalizadora = "
//                            <option value='4'> Convenio  </option>                    
//                            <option value='3'> Voucher  </option>                    
//                            <option value='2'> Parcelado  </option>                            
//                            <option value='1'> Rotativo  </option>
//                            <option value='5'> Ajustes  </option>";
//                break;
//            case "5":
//                $finalizadora = " 
//                            <option value='5'> Ajustes  </option>                               
//                            <option value='4'> Convenio  </option>                    
//                            <option value='3'> Voucher  </option>                    
//                            <option value='2'> Parcelado  </option>                            
//                            <option value='1'> Rotativo  </option>";
//                break;
//        }
//        
//        return $finalizadora;
//    }
//    
//    public function corfundo($dif, $can) {
//        
//        if (($dif == "") and ($can == "")){
//            
//            $corfundo = "#FFFFFF";
//            
//        } elseif (($dif == "") and ($can != "")) {
//            
//            $corfundo = "#FFE7A1";
//        
//            
//        } else {
//            
//            $corfundo = "#F05E5E";
//        }
//        
//        return $corfundo;
//    }
//    
//    public function formataNumero($valor) {
//        
//        $len = strlen($valor);
//        switch ($len) {
//            case "2":
//                $res = "0".$valor;
//            break;
//        case "1":
//            $res = "00".$valor;
//          break;
//                        }
//        
//                        return $res;
//    }
//               
//    
//    }
//?>
