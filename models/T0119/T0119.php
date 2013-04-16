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
    
    public function ConsultaLotesLoja($Loja)
    {
        $sql="  SELECT l.lote_numero , l.store_key , l.amount
                  FROM davo_ccu_lote l
                 where l.store_key = 2
                   and l.aprovacao_status_id = 0 
                 LIMIT 10
              ";
        
        return $this->query($sql) ; // ->fetchAll(PDO::FETCH....);
    }

    public function ConsultaDetalhesLoteLoja($Loja,$Lote)
    {
        $sql="  SELECT d.sequence , d.plu_id , d.desc_plu , d.quantity , d.unit_price , d.amount
                  FROM davo_ccu_lote_detalhe d
                 where d.store_key = 2
                   and d.lote_numero = 419
                 LIMIT 10
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
        
        # $Retorno=$this->query($sql) ; #->fetchAll(PDO::FETCH_COLUMN,2);
        return $this->query($sql);
        # echo $sql;
        # print_r($Retorno);
        foreach($Retorno as $campos=>$valores)
        {
            $TipoPai=$valores['tipo_codigo_pai'] ;
            $String=$String.$valores['descricao'].RetornaStringTipo($TipoPai);
            echo $TipoPai;
            # echo $String;
            echo "a";
            # if ($TipoPai <> 0)
              // RetornaStringTipo($TipoPai);
            # return $String ; 
        }
        
        // return $String ; 
        # RetornaStringTipo(5);
        
    }
            
    
}
 ?>
