<?php


///**************************************************************************
//                Intranet - DAVÓ SUPERMERCADOS
// * Criado em: 31/05/2012 por Rodrigo Alfieri
// * Descrição: 
// * Entrada:   
// * Origens:   
//           
//**************************************************************************
//*/
//
//
class models_T0104 extends models
{

    public function __construct($conn,$verificaConexao,$db)
    {
        parent::__construct($conn,$verificaConexao,$db);
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
