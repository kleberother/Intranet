<?php

///**************************************************************************
//                Intranet - DAVÓ SUPERMERCADOS
// * Criado em:                
// * Descrição: 
// * Entrada:   
// * Origens:   
//           
//**************************************************************************
//*/

class models_T0119 extends models
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
//       
       return $insere;
    }      
       
    public function altera($tabela,$campos,$delim)
    {              
       $altera = $this->exec($this->atualiza($tabela, $campos, $delim));
       
       if($altera)
            $this->alerts('false', 'Alerta!', 'Alterado com Sucesso!');
       else
            $this->alerts('true', 'Erro!', 'Não foi possível Alterar!');          
       
      // echo $altera;
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
    
    public function ConsultaLotesLoja($filtroLoja, $filtroDtInicio, $filtroDtFim, $filtroStatusConsumo, $filtroStatusIntegracao, $filtroStatusAprovacao, $filtroRegistros)
    {
        $sql="  SELECT l.store_key , l.lote_numero , l.start_time 
                     , l.amount , l.quantity_rows 
                     , t.tipo_codigo 
                     , sc.status_consumo_id     , sc.status_consumo_descricao
                     , si.status_integracao_id  , si.status_integracao_descricao
                     , sa.status_aprovacao_id   , sa.status_aprovacao_descricao
                      -- l.lote_numero , l.store_key , l.amount
                  FROM davo_ccu_lote l
                  INNER JOIN davo_ccu_tipo t                 ON (     t.tipo_codigo           = l.tipo_codigo          )
                  INNER JOIN davo_ccu_status_consumo    sc   ON (     sc.status_consumo_id    = l.consumo_status_id    )
                  INNER JOIN davo_ccu_status_integracao si   ON (     si.status_integracao_id = l.integracao_status_id )
                  INNER JOIN davo_ccu_status_aprovacao  sa   ON (     sa.status_aprovacao_id  = l.aprovacao_status_id  )                  
                 WHERE 1    =   1";
                 
                 if(!empty($filtroLoja))
                    $sql   .=  " AND l.store_key                = $filtroLoja";
                 
                 if(!empty($filtroDtInicio))
                    $sql   .=  " AND l.l.start_time            >= $filtroDtInicio 00:00:00";
                 
                 if(!empty($filtroDtFim))
                    $sql   .=  " AND l.l.start_time            <= $filtroDtFim 23:59:59";
                 
                 if(!empty($filtroStatusConsumo))
                    $sql   .=  " AND sc.status_consumo_id       = $filtroStatusConsumo";
                 
                 if(!empty($filtroStatusIntegracao))
                    $sql   .=  " AND si.status_integracao_id    = $filtroStatusIntegracao";
                 
                 if(!empty($filtroStatusAprovacao))
                    $sql   .=  " AND sa.status_aprovacao_id     = $filtroStatusAprovacao";
                 
                  $sql  .=  " ORDER BY l.start_time ";
                  
                  if(!empty($filtroRegistros))
                    $sql  .=  " LIMIT $filtroRegistros";
                
 
        return $this->query($sql) ; // ->fetchAll(PDO::FETCH....);
    }

    public function ConsultaDetalhesLoteLoja($Loja,$Lote)
    {
        $sql="  SELECT d.sequence , d.plu_id , d.desc_plu , d.quantity , d.unit_price , d.amount
                  FROM davo_ccu_lote_detalhe d
                 where d.store_key   = $Loja
                   and d.lote_numero = $Lote
              ";
        
        return $this->query($sql) ; // ->fetchAll(PDO::FETCH....);
    }

    public function RetornaStringTipo ($Tipo)
    {
        // funcao recursiva para retornar a String Completa do Tipo de Movimentacao
        
        $sql="
                SELECT t.tipo_codigo , t.descricao , IFNULL(t.tipo_codigo_pai,0) tipo_codigo_pai
                  FROM davo_ccu_tipo t
                 WHERE t.tipo_codigo = $Tipo
             ";        
        
        $Retorno=$this->query($sql) ; #->fetchAll(PDO::FETCH_COLUMN,2);
        #return $this->query($sql);
        # echo $sql;
       
        foreach($Retorno as $campos=>$valores)
        {
            $valores['tipo_codigo'] ;
            $TipoPai=$valores['tipo_codigo_pai'] ;
            
            if ($TipoPai)
              $String=$this->RetornaStringTipo($TipoPai).' -> '.$valores['descricao'];
            else
              $String=$valores['descricao'];
            
        }
        
        return $String ; 
        # RetornaStringTipo(5);
        
    }
    
    public function retornaLojasSelectBox()
    {
        $sql = "   SELECT T06.T006_codigo LojaCodigo
                        , T06.T006_nome   LojaNome
                     FROM T006_loja T06
                     JOIN T065_segmento_filiais T65 ON T06.T065_codigo = T65.T065_codigo
                    WHERE T65.T065_codigo  = 1";
        
        return $this->query($sql);
    }
    
    public function retornaStatusIntegracao()
    {
        $sql    =   "  SELECT si.status_integracao_id               Codigo
                            , si.status_integracao_descricao        Descricao
                         FROM davo_ccu_status_integracao si";
        
        return $this->query($sql);          
    }
    
    public function retornaStatusConsumo()
    {
        $sql    =   "  SELECT sc.status_consumo_id              Codigo
                            , sc.status_consumo_descricao       Descricao
                         FROM davo_ccu_status_consumo sc";
        
        return $this->query($sql);        
    }
    
    public function retornaStatusAprovacao()
    {
        $sql    =   "  SELECT sa.status_aprovacao_id            Codigo
                            , sa.status_aprovacao_descricao     Descricao
                         FROM davo_ccu_status_aprovacao sa";
        
        return $this->query($sql);
    }
            
    
}
 ?>
