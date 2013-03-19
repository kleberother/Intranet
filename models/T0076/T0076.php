<?php


/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 19/01/2012 por Jorge Nova
 * Descrição: Classe de models para o programa T076
 * Entrada:   
 * Origens:   
           
**************************************************************************
*/


class models_T0076 extends models
{

    public function __construct($conn,$verificaConexao,$db)
    {
        parent::__construct($conn,$verificaConexao,$db);
    }
    
    public function inserir($tabela,$campos)
    {
        $insere = $this->exec($this->insere($tabela, $campos));
        
       if($insere)
            $this->alerts('false', 'Alerta!', 'Incluido com Sucesso!');
       else
            $this->alerts('true', 'Erro!', 'Não foi possível Incluir!');
       
       return $insere;
    }   
    
    public function altera($tabela,$campos,$delim)
    {
       $conn = "";
       
       $altera = $this->exec($this->atualiza($tabela, $campos, $delim));
       
       if($altera)
            $this->alerts('false', 'Alerta!', 'Alterado com Sucesso!');
       else
            $this->alerts('true', 'Erro!', 'Não foi possível Alterar!');          
       
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
    
    public function retornaEntidade()
    {
        $sql    =   "SELECT TF1.T049_codigo             Codigo
                          , TF1.T049_nome               Nome
                       FROM T049_entidade_prestadora	TF1";
        
        return $this->query($sql);
    }

    public function retornaLocal($entidade)
    {
        $sql    =   "SELECT TF1.T050_codigo	Codigo
                          , TF1.T050_nome	Nome
                       FROM T050_local_atendimento TF1 
                      WHERE TF1.T049_codigo = $entidade";
        
        return $this->query($sql);
    }
   
    
}
?>
