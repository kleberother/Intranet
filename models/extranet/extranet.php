<?php
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 09/11/2011 por Lucas Teixeira
 * Descrição: Classe para interação com banco do programa T0060 (Geração de Teclado Scritta)  
           
***************************************************************************/

class models_extranet extends models
{

    public function __construct($conn,$verificaConexao)
    {
        parent::__construct($conn,$verificaConexao);
    }
    
    public function inserir($tabela,$campos)
    {
        $insere =  $this->exec($this->insere($tabela, $campos));
        
        if($insere)
            $this->alerts('false', 'Alerta!', 'Incluído com Sucesso!');
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
    
}
?>
<?php
/* -------- Controle de versões - models/T0070.php --------------
 * 
*/
?>