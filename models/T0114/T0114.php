<?php


///**************************************************************************
//                Intranet - DAVÓ SUPERMERCADOS
// * Criado em: 30/10/2012 por Roberta Schimidt                               
// * Descrição: Ranking Mensal Comissão Confiança
// * Entrada:   
// * Origens:   
//           
//**************************************************************************
//*/
//
// 


class models_T0114 extends models
{

    public function __construct($conn,$verificaConexao,$db)
    {
        parent::__construct($conn,$verificaConexao,$db);
    }
    
    
     public function retornaLoja()
    {
       
        
        $sql = "SELECT * FROM T006_loja
                WHERE T006_codigo not in (0, 86, 94, 108, 116, 140, 159, 
                167, 175, 183, 191, 999) ";
        
        return $this->query($sql);
    
   }
   
   public function retornaNumLoja($loja)
    {         
         if ($loja == 19)
         {
            $nLoja = "1";
            
         }
         elseif($loja == 27)
         {
            $nLoja = "2";
         }
         elseif($loja == 35)
         {
            $nLoja = "3";
         } 
         elseif($loja == 43)
         {
            $nLoja = "4";
         } 
         elseif ($loja == 51){
            $nLoja = "5";
         } 
         elseif($loja == 60){
            $nLoja = "6";
         }
         elseif($loja == 78)
         {
            $nLoja = "7";
         } 
         elseif ($loja == '124')
         {
            $nLoja = "12";
         } 
         elseif ($loja == '132') 
         {
            $nLoja = "13";
         }
         else 
         {
             $nLoja = "Selecione...";
         }

         return $nLoja;

    }
    
    
     public function  retornaBuscaComboLoja($lojaPost)
    {
        switch($lojaPost){
            
            case "":
                $busca = "<option value='0'>Todas </option>";
                break;
             case "0":
                $busca = "<option value='0'>Todas </option>";
                break;
            case "1":
                $busca = "<option value='1'>".$lojaPost." - DAVO ITAQUERA</option>";
                break;
            case "2":
                $busca = "<option value='2'>".$lojaPost." - DAVO ORATÓRIO</option>";
                break;
            case "3":
                $busca = "<option value='3'>".$lojaPost." - DAVO GUAIANASES</option>";
                break;
            case "4":
                $busca = "<option value='4'>".$lojaPost." - DAVO SÃO MIGUEL</option>";
                break;
            case "5":
                $busca = "<option value='5'>".$lojaPost." - DAVO ITAIM</option>";
                break;
            case "6":
                $busca = "<option value='6'>".$lojaPost." - DAVO SUZANO</option>";
                break;
            case "7":
                $busca = "<option value='7'>".$lojaPost." - DAVO MOGI DAS CRUZES</option>";
                break;
            case "8":
                $busca = "<option value='8'>".$lojaPost." - DAVO FARMA ITAQUERA</option>";
                break;
            case "9":
                $busca = "<option value='9'>".$lojaPost." - DAVO FARMA MOGI DAS CRUZES</option>";
                break;
            case "10":
                $busca = "<option value='10'>".$lojaPost." - DAVO FARMA GUAIANASES</option>";
                break;
            case "11":
                $busca = "<option value='11'>".$lojaPost." - DAVO FARMA SAO B. DO CAMPO</option>";
                break;
            case "12":
                $busca = "<option value='12'>".$lojaPost." - DAVO SÃO BERNARDO DO CAMPO</option>";
                break;
            case "13":
                $busca = "<option value='13'>".$lojaPost." - DAVO TABOÃO DA SERRA</option>";
                break;
        }
        
        return $busca;
    }
    
    
    
    public function retornaNumIndicados($mes, $ano, $CodFunc) {
        $connMSSQL  =   $this->consulta;
        
        $sql = "SELECT  CODFUNC     AS      CONTRATADO
                       ,QTD         AS      QUANTIDADE
                       ,MES         AS      MES
                       ,ANO         AS      ANO
                 FROM   TAB_CARTOES_IND
                WHERE   CODFUNC     =       '$CodFunc'
                    AND MES         =       '$mes'
                    AND ANO         =       '$ano'
                    AND CODFUNC <> '0'
                  ORDER BY QTD DESC";
        
      //  echo $sql."<br>";
        
        $stid   =   mssql_query($sql, $connMSSQL);
        
        return $stid;
    }
    
    public function retornaCartAtiv($mes, $ano, $CodFunc) {
        $connMSSQL  =   $this->consulta;
        
        $sql = "SELECT  CODFUNC     AS      CONTRATADO
                       ,QTD         AS      QUANTIDADE
                       ,MES         AS      MES
                       ,ANO         AS      ANO
                 FROM   TAB_CARTOES_IND
                WHERE   CODFUNC     =       '$CodFunc'
                    AND MES         =       '$mes'
                    AND ANO         =       '$ano'
                    AND CODFUNC <> '0'
                  ORDER BY QTD DESC";
        
   //     echo $sql."<br>";
        
        $stid   =   mssql_query($sql, $connMSSQL);
        
        return $stid;
    }
    
    
    public function retornaValComSeg($mes, $ano, $CodFunc) {
        $connMSSQL  =   $this->consulta;
        
        $sql = "SELECT  CODFUNC       AS      CONTRATADO
                       ,VALOR         AS      VALOR
                       ,MES           AS      MES
                       ,ANO           AS      ANO
                 FROM   dbo.TAB_CONFIANCA_COMISSAO_SEG
                WHERE   CODFUNC     =       '$CodFunc'
                    AND MES         =       '$mes'
                    AND ANO         =       '$ano'
                    AND CODFUNC     <>      '0'";
        
      // echo $sql."<br>";
        
        $stid   =   mssql_query($sql, $connMSSQL);
        
        return $stid;
    }
    
    public function retornaCodigoRms($cpf){
        
        $connORA    =   $this->consulta;
        
        $sql = "SELECT A.TIP_CODIGO||A.TIP_DIGITO CODRMS
                    , A.TIP_RAZAO_SOCIAL NOME
                    , A.TIP_CGC_CPF CPF
                FROM RMS.AA2CTIPO A 
                    WHERE A.TIP_NATUREZA = 'OC'
                    AND A.TIP_CGC_CPF = '$cpf'";
        
       //echo $sql."<br>";
        
        $stid = oci_parse($connORA, $sql);
        oci_execute($stid);
        return($stid);
        
        
    }
    
    public function retornaValPv($codRMS, $mes, $ano, $matricula) {
        
        $sql = "SELECT count(*) QTD
                    FROM EMS_ticket_recebimento etr, `user` u, agent a 
                   WHERE etr.cashier_key                   = a.agent_key
                     AND a.agent_key                       = u.agent_key
                     AND a.agent_type                      = 2 
                     AND etr.fiscal_date                   >= '$ano-$mes-01' 
                     AND etr.fiscal_date                   < date_add('$ano-$mes-01', INTERVAL 1 MONTH)
                     AND (a.id                              = '$codRMS' or substring(u.alternate_id,5,6) = '$matricula' )
                    GROUP BY etr.store_key, a.id, u.alternate_id, a.name
                    ORDER BY etr.store_key, a.id, u.alternate_id, a.name";
        
      //  echo $sql."<br>";
        
        return $this->query($sql);
        
        
        
    }
    
    public function retornaFuncAtivo($Loja) {
        
        if($Loja == "0" || $Loja == ""){
            $condicao = "WHERE T109_Situacao = 'ATIVO'";
            
        } else {
            
            $condicao = "WHERE  T109_Situacao = 'ATIVO' AND T109_Loja = '$Loja'";
        }
        
        $sql = "SELECT      T109_Loja       AS      LOJA
                           ,T109_Matricula  AS      CONTRATADO
                           ,T109_Nome       AS      NOME
                           ,T109_Funcao      AS      CARGO
                           ,T109_Cpf        AS      CPF
                           ,T109_Situacao   AS      SITUACAO
                  FROM     T109_func_confianca      AS      FC ".$condicao;
        
     //   echo $sql;
        
        return $this->query($sql);
        
    }
    
    public function retornaRanking($mes, $ano, $loja) {
        
        if($loja == "0" || $loja == "") {
            $condicao = "WHERE T110_Mes = '$mes' AND T110_Ano = '$ano'";
        } else {
            $condicao = "WHERE T110_Mes = '$mes' AND T110_Ano = '$ano' AND T110_Loja = '$loja'";
        }
        
        
        $sql = "SELECT      *       
                  FROM        T110_RankingComissao ".$condicao. "ORDER BY T110_ValorTot DESC" ;
        
        //echo $sql;
        
        return $this->query($sql);
        
    }
    
    public function retornaDataRanking($mes, $ano) {
        
         $sql = "SELECT      *       
                  FROM        T110_RankingComissao
                 WHERE         T110_ano = '$ano' 
                   AND         T110_mes = '$mes'";
         
       //  echo $sql."<br>";
         
         return $this->query($sql);
        
    }
    
        
     public function inserir($tabela,$campos)
    {
        $insere =  $this->exec($this->insere($tabela, $campos));
        
      
    
        return $insere;
    }
    
    public function retornaUltimaMatricula($loja) {
        
        $sql = "SELECT MAX(T109_MatriculaAgencia) as UltimaMatricula FROM T109_func_confianca
                    WHERE  T109_MatriculaAgencia is not NULL
                      AND  T109_Loja = '$loja'";
        
      //  echo $sql;
        
         return $this->query($sql);
        
    }
    
    
    
    
    }
    
    ?>