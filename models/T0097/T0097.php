<?php


///**************************************************************************
//                Intranet - DAVÓ SUPERMERCADOS
// * Criado em: 16/05/2012 por Rodrigo Alfieri
// * Descrição: Relatório Vendas Assistidas
// * Entrada:   
// * Origens:   
//           
//**************************************************************************
//*/
//
//
class models_T0097 extends models
{

    public function __construct($conn,$verificaConexao,$db)
    {
        parent::__construct($conn,$verificaConexao,$db);
    }
    
    public function retornaDados($loja, $dataI, $dataF, $tipo, $filtro)
    {   $connORA  =   $this->consulta;
        
        $sql = "SELECT A.SGE_LOJA                                   LOJA
                     , nvl(10*T.TIP_CODIGO+T.TIP_DIGITO,0)          COD_RMS
                     , nvl(T.TIP_RAZAO_SOCIAL,'NAO CADASTRADO RMS') NOME
                     , DECODE( T.TIP_NATUREZA,'OC'
                     , 'OPERADOR DE CAIXA'
                     , 'VENDEDOR')                                  OPER_VEND
                     , count(A.ROWID)                               QTDE
                     , sum(A.SGE_PRECO_GAR)                         VALOR
                  FROM RMS.SEG_GARITEM A
             LEFT JOIN RMS.AA2CTIPO T  ON (A.SGE_VENDEDOR = T.TIP_CODIGO)
             LEFT JOIN RROCHA.DATA_RMS H ON H.DRDATE = trunc(A.SGE_DAT_EMISSAO)                  
                 WHERE A.SGE_NUM_CUPOM              > 0
                   AND A.SGE_DAT_CANCELAMENTO       IS NULL 
                   AND A.SGE_VENDEDOR > 0";        

        if (!empty($loja))
            $sql    .=  " AND A.SGE_LOJA                 =   $loja";
        if (!empty($tipo))
            $sql    .=  " AND T.TIP_NATUREZA             =   '$tipo'";
        if (!empty($dataI))                    
            $sql    .=  " AND H.DRDATER7   >= '$dataI'";
        if (!empty($dataF))
            $sql    .=  " AND H.DRDATER7   <= '$dataF'";
        
        $sql    .=       " GROUP BY A.SGE_LOJA 
                                  , 10*T.TIP_CODIGO+T.TIP_DIGITO 
                                  , T.TIP_RAZAO_SOCIAL 
                                  , T.TIP_NATUREZA
                                  

                           ORDER BY $filtro DESC";  
        
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
    
    public function retornaLojas()
    {
        $sql    =   "  SELECT T06.T006_codigo LojaCodigo
                            , T06.T006_nome   LojaNome
                         FROM T006_loja T06
                         JOIN T065_segmento_filiais T65 ON T06.T065_codigo = T65.T065_codigo
                        WHERE T65.T065_codigo  = 1";
        
        return $this->query($sql);
    }
    

    
}
 ?>
