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
class models_T0101 extends models
{

    public function __construct($conn,$verificaConexao,$db)
    {
        parent::__construct($conn,$verificaConexao,$db);
    }
    
    public function retornaDados($mesAno, $loja)
    {   $connORA  =   $this->consulta;
        
        $sql = "SELECT  G.SGE_LOJA                        Loja
                 , SUM (G.SGE_PRECO_GAR)                  Valor
                 , to_char(G.SGE_DAT_EMISSAO, 'MM/YYYY')  Data              
                  FROM RMS.SEG_GARITEM G
                 WHERE G.SGE_NUM_CUPOM   > 0
                   AND G.SGE_DAT_CANCELAMENTO IS NULL " ;
              
        
        if(!empty($mesAno))
            $sql    .=  "   AND to_char(G.SGE_DAT_EMISSAO, 'MM/YYYY')   =   $mesAno";
        
        if(!empty($loja))
            $sql    .=  "   AND G.SGE_LOJA                              =   $loja";
      
            $sql    .=  " GROUP BY G.SGE_LOJA    , to_char(G.SGE_DAT_EMISSAO, 'MM/YYYY')" ;
            
           // echo $sql;
            
        $stid    = oci_parse($connORA, $sql);
        oci_execute($stid);
         while ($row_ora = oci_fetch_assoc($stid)){
             return $row_ora['VALOR'];             
         }
         
         
    }
   
    
    public function retornaPerfil($user)
    {
        $sql    =   "  SELECT T0409.T009_codigo  CodigoPerfil
                         FROM T004_T009 T0409 
                        WHERE T009_codigo IN (47,48) 
                          AND T004_login = '$user'";
        
        return $this->query($sql)->fetchAll(PDO::FETCH_COLUMN);
    }
    
    public function retornaLoja()
    {
        $sql    =   "  SELECT T06.T006_codigo LojaCodigo
                            , T06.T006_nome   LojaNome
                         FROM T006_loja T06
                         JOIN T065_segmento_filiais T65 ON T06.T065_codigo = T65.T065_codigo
                        WHERE T65.T065_codigo  = 1";
        
        return $this->query($sql);
    }
    
    
    public function retornaMes()
    {
        $sql    =   "  SELECT DISTINCT
                       CONCAT(T100.T100_mes ,'/', T100.T100_ano) MesMeta
                         FROM T100_meta_ge T100
                         JOIN T006_loja T06 ON T100.T006_codigo = T06.T006_codigo
                         JOIN T004_usuario T04 ON T100.T004_login = T04.T004_login";
        
        
            
        
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
