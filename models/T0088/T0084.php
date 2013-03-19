<?php


/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 26/01/2012 por Jorge Nova
 * Descrição: Classe de models para o programa T084
 * Entrada:   
 * Origens:   
           
**************************************************************************
*/


class models_T0084 extends models
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
    
    public function retornaNotas()
    {
        $sql = "SELECT TF1.T013_codigo			Codigo
                     , TF1.T006_codigo			CodLoja
                     , TJ1.T006_nome			NomeLoja
                     , TF1.T026_codigo                  CodFornecedor 
                     , TJ2.T026_rms_razao_social	RazaoSocial
                     , TJ2.T026_rms_cgc_cpf		CNPJ        
                     , TJ2.T026_rms_insc_est_ident	IE                     
                     , TF1.T013_total_geral             ValorTotal
                     , TF1.T004_login                   Elaborador	  
                     , TJ3.T004_nome                    NomeElaborador
                  FROM T013_nota_debito TF1
                  JOIN T006_loja			TJ1 ON ( TJ1.T006_codigo = TF1.T006_codigo )
                  JOIN T026_fornecedor                  TJ2 ON ( TJ2.T026_codigo = TF1.T026_codigo )
                  JOIN T004_usuario                     TJ3 ON ( TJ3.T004_login  = TF1.T004_login  )";
        
        return $this->query($sql);
    }

    public function retornaNota($codigo)
    {
        $sql = "SELECT TF1.T013_codigo			Codigo
                     , TF1.T006_codigo			CodLoja
                     , TJ1.T006_nome			NomeLoja
                     , TF1.T026_codigo                  CodFornecedor 
                     , TJ2.T026_rms_razao_social	RazaoSocial
                     , TJ2.T026_rms_cgc_cpf		CNPJ    
                     , TJ2.T026_rms_insc_est_ident	IE              
                     , TF1.T013_total_geral             ValorTotal
                     , TF1.T004_login                   Elaborador	  
                     , TJ3.T004_nome                    NomeElaborador
                  FROM T013_nota_debito TF1
                  JOIN T006_loja			TJ1 ON ( TJ1.T006_codigo = TF1.T006_codigo )
                  JOIN T026_fornecedor                  TJ2 ON ( TJ2.T026_codigo = TF1.T026_codigo )
                  JOIN T004_usuario                     TJ3 ON ( TJ3.T004_login  = TF1.T004_login  )
                 WHERE TF1.T013_codigo = $codigo";
        
        return $this->query($sql);
    }
    
    public function retornaLojas()
    {
        $sql = "SELECT TF1.T006_codigo      Codigo
                     , TF1.T006_nome        Nome
                  FROM T006_loja            TF1
                 WHERE TF1.T006_codigo <> 0";
        
        return $this->query($sql);
    }    
        
   
}
?>
