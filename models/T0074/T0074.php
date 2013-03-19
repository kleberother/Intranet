<?php
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 10/01/2012 por Jorge Nova
 * Descrição: Classes para retornar dados de cadastro de usuários da extranet  
           
***************************************************************************/

class models_T0074 extends models
{

    public function __construct($conn)
    {
        parent::__construct($conn);
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
   
    public function retornaUsuarios($grantor)
    {
        $sql = "SELECT TF1.T004_login	Login
                     , TF1.T004_nome	Nome
                     , TF1.T004_email	Email
                     , TF1.T004_cpf	CPF
                  FROM T004_usuario     TF1
                 WHERE TF1.T004_grantor = '$grantor'";
        
        return $this->query($sql);
    }

    public function retornaGrantors($login)
    {
        $sql = "SELECT TF1.T004_grantor	Login
                     ,	TJ1.T004_nome	Nome
                  FROM T004_T004        TF1
                  JOIN T004_usuario 	TJ1 ON ( TF1.T004_grantor = TJ1.T004_login ) 
                 WHERE TF1.T004_login = '$login'";
        
        return $this->query($sql);
    }

    public function retornaArquivosUsuario($login)
    {
        $sql = "SELECT  TF1.T055_codigo Codigo
                  FROM  T055_arquivos   TF1
                 WHERE  TF1.T004_login  =   '$login'";
        
        return $this->query($sql);
    }
    
    
}
?>
<?php
/* -------- Controle de versões -------------
 * 1.0.0 - 10/01/2012   --> Liberada a versão
*/
?>