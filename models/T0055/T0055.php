<?php

/*******************************************************************************************/
/*                          DAVÓ SUPERMERCADOS                                             */
/* Criado em: 20/10/2011 por Rodrigo Alfieri, Jorge Nova e Roberta Schimidt                */
/* Descrição: Classe para executar as Querys do Programa T0055                             */
/*******************************************************************************************/
 
class models_T0055 extends models
{

    public function __construct($conn,$verificaConexao,$db)
    {
        parent::__construct($conn,$verificaConexao,$db);
    }

    
    // Seleciona as movimentações das captações do cartão confiança
    public function retornaRankingCartao($dataini, $datafim, $lojaMeta)
    {
        $connMSSQL  =   $this->consulta;
        
        $sql= "SELECT    LOJA               AS LOCAL
                        ,ATIVOS             AS ATIVOS
                        ,CAPTADOS           AS CAPTADOS
                        ,APROVADOS          AS APROVADOS
                        ,ADICIONAIS         AS ADICIONAIS
                 FROM   dbo.TB_PARCIAL_CARTAO
                WHERE   DAT_INC >= '$datafim'
                 AND   LOJA = '$lojaMeta'
                GROUP BY LOJA, ATIVOS, CAPTADOS, APROVADOS,   ADICIONAIS  ";
               
        //echo $sql."<br>";
        
            $stid    = mssql_query($sql,$connMSSQL);   
       
       return $stid;

       }
    //Seleciona as movimentações dos seguros mensal
    public function retornaSeguro($seg, $datafimS, $lojaMeta, $tipo2)
    {
        
        if($tipo2 == "dia"){
            
                  $sql = "SELECT TIPO              AS 'COD_SEGURO_EMS'
                     , COD_LOCAL         AS 'COD_LOCAL'
                     , SUM(QTD_TOT)      AS 'QTD_TOT'
                  FROM TB_FLASHES_SEGURO
                 WHERE DATA = '$datafimS'
                   AND TIPO = '$seg'
                   AND COD_LOCAL = '$lojaMeta'
              GROUP BY TIPO, COD_LOCAL";
            
        } else {
            
                $sql = "SELECT  QTD_TOT  
                          FROM  TB_PARCIAL_SEGURO
                         WHERE  TIPO    =   '$seg'
                           AND  COD_LOCAL   =   '$lojaMeta'
                           AND  DAT_INC     =    CONVERT(VARCHAR(10), '$datafimS', 101)  ";
            
        }
        
        $connMSSQL = $this->consulta; 

 
      // echo $sql."<br>";
        
       
     $stid2    = mssql_query($sql,$connMSSQL);     
    
    return $stid2;
}

    public function retornaAProvadosParcial($loja, $data) {
        
        $connMSSQL = $this->consulta;
        
        $sql = "SELECT  APROVADOS
                  FROM  TB_PARCIAL_APROVADOS
                 WHERE  DAT_INC = CONVERT(VARCHAR(10), '$data', 101)
                   AND  LOJA = '$loja' ";
        
        $stid2 = mssql_query($sql, $connMSSQL);
        return $stid2;
       
    }


    //Retorna lojas cadastradas no EM$
    public function retornaLoja()
    {

        $connMSSQL = $this->consulta; 

        $sql = "SELECT COD_LOCAL
                     , DSC_LOCAL 
                  FROM dbo.LOCAL_CREDIARIO_0142T(NOLOCK)
                 WHERE COD_LOCAL <= 13
                   AND COD_LOCAL <> 11
                   AND COD_LOCAL <> 10
                   AND COD_LOCAL <> 9
                   AND COD_LOCAL <> 8
              ORDER BY COD_LOCAL";

        $stid2    = mssql_query($sql,$connMSSQL);       

           return $stid2;
    }
 //Inseri dados em tabelas Satelite 
    public function inserir($tabela,$campos)
    {
        $insere =  $this->exec($this->insere($tabela, $campos));
        
      
    
        return $insere;
    } 
    //Retorna as metas de cada ranking
    public function retornaMeta($mes_dataini,  $ano_dataini)
    {                          
         $sql = "SELECT T082_mes
        
        , T082_perda_e_roubo
        , T082_desemprego
        , T082_ativados
        , T082_adicionais
        , T082_aprovados
        , T082_loja 
        FROM T082_metas
        WHERE  T082_mes = '$mes_dataini' 
        and T082_ano = '$ano_dataini'  ";
         
         return $this->query($sql);                                 
     }
     
         public function retornaAllMeta()
    {                          
         $sql = "SELECT T082_mes FROM T082_metas order by T082_mes asc ";
         
         
         
         return $this->query($sql);                                 
     }
     //Retorna nome das lojas
    public function retornaNomeLoja($loja)
    {         
         if ($loja == 1)
         {
            $nLoja = "Itaquera";
         }
         elseif($loja == 2)
         {
            $nLoja = "Oratório";
         }
         elseif($loja == 3)
         {
            $nLoja = "Guaianazes";
         } 
         elseif($loja == 4)
         {
            $nLoja = "São Miguel";
         } 
         elseif ($loja == 5){
            $nLoja = "Itaim Paulista";
         } 
         elseif($loja == 6){
            $nLoja = "Suzano";
         }
         elseif($loja == 7)
         {
            $nLoja = "Mogi das Cruzes";
         } 
         elseif ($loja == 12)
         {
            $nLoja = "São Bernardo do Campo";
         } else 
         {
            $nLoja = "Taboão da Serra";
         }

         return $nLoja;

    }
     //Retorna projeção do Mês
    function retornaProjecao($mes_dataini, $ano_dataini)
    {
         
         $sql = "SELECT T083_projecao FROM T083_projecao WHERE T083_mes = '$mes_dataini' and T083_ano = '$ano_dataini' ";
         
         return $this->query($sql);
         
     }
     // retorna ultimo dia do mês 
    function UltimoDia($ano_qtd,$mes_qtd)
    { 
        if (((fmod($ano_qtd,4)==0) and (fmod($ano_qdt,100)!=0)) or (fmod($ano_qtd,400)==0)) 
        { 
            $dias_fevereiro = 29; 
        } 
        else 
        { 
            $dias_fevereiro = 28; 
        }
        
    switch($mes_qtd) 
    { 
       case 01: return 31; break; 
       case 02: return $dias_fevereiro; break; 
       case 03: return 31; break; 
       case 04: return 30; break; 
       case 05: return 31; break; 
       case 06: return 30; break; 
       case 07: return 31; break; 
       case 08: return 31; break; 
       case 09: return 30; break; 
       case 10: return 31; break; 
       case 11: return 30; break; 
       case 12: return 31; break; 
   }
   
   return $mes_qtd;
} 


   

   
    //Seleciona valores PV do seguro de perda e roubo
    
    function selecionaPv($data, $tipo, $loja)
    {
        
        
        
    if ($tipo ==  "dia"){
        
        $dataini = $data;
    
        
    } else {
      
        $mes_data = substr($data, 5,2);
        $ano_data = substr($data, 0,4 );
        
        $dataini = $ano_data."-".$mes_data."-"."01";
        
    }
        
        
        $connMSSQL  =   $this->consulta;
        
     $sql = "   SELECT      COD_LOCAL             LOJA
                           ,DATA                  DATA    
                           ,SUM(QTD_TOT)          QTD
                  FROM      dbo.TB_FLASHES_PV A (NOLOCK)
                 WHERE      COD_LOCAL       =       '$loja'
                   AND      DATA            >=      '$dataini'
                   AND      DATA            <       '$data'  
              GROUP BY      COD_LOCAL, DATA ";
     


                $stid = mssql_query($sql,$connMSSQL);      
  
                return $stid;
         }
         
         function retornaPV($datafimS, $tipo2)
         {
             
             $sql = "SELECT * FROM T084_pv_seguro 
                        WHERE 
                            T084_data = '$datafimS'
                            AND T084_tipo_busca = '$tipo2' ";
             

             return $this->query($sql);
             
             }
             
             function retornaElegiveis($loja, $datafim, $tipo2)
                     
             {
                 
                 if($tipo2 == "dia"){
                     
                     $dataini = $datafim;
                     
                 } else {
                     
                           $mes_data = substr($datafim, 5,2);
        $ano_data = substr($datafim, 0,4 );
        
        $dataini = $ano_data."-".$mes_data."-"."01";
                     
                 }
                 
                 
                 $connMSSQL  =   $this->consulta;
                 
                 $sql = "select x.COD_LOCAL_CLIENTE,COUNT(*) Qtd
                            from CLIENTE_CARTAO_CEV_0148T		v   (NOLOCK),
                                     CLIENTE_CRED_0117T				w	(NOLOCK),
                                     CLIENTE_CORP_0116T				x	(NOLOCK),
                                     CLIENTE_VINEMP_0122T			y	(NOLOCK),
                                     NATUREZA_PROFISSAO_0429T		z	(NOLOCK)
                            WHERE (DATEDIFF(day,DAT_NASCIMENTO,getdate())/365) BETWEEN 18 AND 65
                              AND x.COD_CLIENTE				=		y.COD_CLIENTE
                              and x.COD_LOCAL_CLIENTE		=		y.COD_LOCAL_CLIENTE
                              AND x.COD_CLIENTE				=		w.COD_CLIENTE
                              and x.COD_LOCAL_CLIENTE		=		w.COD_LOCAL_CLIENTE
                              AND x.COD_CLIENTE				=		v.COD_CLIENTE
                              and x.COD_LOCAL_CLIENTE		=		v.COD_LOCAL_CLIENTE
                              and y.NUM_EMPREGO				=		1
                              and y.COD_NATUREZA_PROFISSAO	=		z.COD_NATUREZA_PROFISSAO
                              and z.COD_NATUREZA_PROFISSAO	in (2,1)
                              and w.VAL_LIM_CRE_CONCEDIDO > 0
                              and COD_SITUACAO_CARTAO_CEV in (2,1)
                              and substring(NUM_CARTAO_CEV,6,1)='1'
                              and v.DAT_ENVIO_GRAFICA >= convert(varchar(10), '$dataini', 101)
                              and v.DAT_ENVIO_GRAFICA < convert(varchar(10), dateadd(day,1, '$datafim'), 101)
                                    and substring(NUM_CARTAO_CEV, 1, 6) = '900001'
                                    and x.COD_LOCAL_CLIENTE = '$loja'
                            group by x.COD_LOCAL_CLIENTE
                            order by x.COD_LOCAL_CLIENTE";
   
                 
                 $stid2 = mssql_query($sql, $connMSSQL);
                 
               return $stid2;
               
               
             }
             
             public function retornaParcialDia($lojaMeta, $datafim) {
                 
                 $dataini = $datafim;
                 
                   
                 $connMSSQL  =   $this->consulta;
                 
                 $sql ="SELECT    LOJA      AS LOCAL
                        ,sum(ATIVOS)        AS ATIVOS
                        ,SUM(CAPTADOS)      AS CAPTADOS
                        ,SUM(APROVADOS)     AS APROVADOS
                        ,SUM(ADICIONAIS)    AS ADICIONAIS
                 FROM   dbo.TB_FLASHES_CARTAO
                WHERE   DATA >= '$dataini'
                  AND   DATA < DATEADD(DAY, 1, '$datafim')
                  AND   LOJA = '$lojaMeta'
                GROUP BY LOJA 
                 order by sum(APROVADOS) DESC";
                  
                // echo $sql."<br>";
                 
                       $stid2 = mssql_query($sql, $connMSSQL);
                 
               return $stid2;
           
                 
             }
             
             
             function retornaCorFundo($valor){
                 
                 
                 if($valor >= 100){
                     
                      $cor = "#FFFFFF";
                 } elseif(($valor < 100) and ($valor >= 80)){
                     
                     $cor = "#fcd3a1";
                     
                 } else {
                     
                     $cor = "#D14836";
                 }
                 
                 

                 
                     return $cor;
                 
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
             
                  
                  function retornaCorDia($valor)
                  {
                      if($valor == '0'){
                          $cor = "#D14836";
                      } else {
                          $cor = "#FFFFFF";
                      }
                      
                      return $cor;
                  }
             
                  
                  function retornaCorFalta($valor1, $valor2)
                  {
                      if($valor1 >= $valor2)
                      {
                          $cor = "#A1C16E";
                      } elseif (($valor1 > 0 ) and ($valor1 < $valor2))
                      {
                          $cor = "#ffffff";
                      } else {
                          
                          $cor = "#D14836";
                      }
                      
                      return $cor;
                  }
       
}
?>