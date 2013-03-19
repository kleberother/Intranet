<?php
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 22/11/2011 por Jorge Nova
 * Descrição: Classe para interação com banco do programa T0064 (Departamento)
           
***************************************************************************/

class models_T0064 extends models
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

    public function excluir($tabela, $delim)
    {
        $exclui = $this->exec($this->exclui($tabela, $delim));

       	if($exclui)
		$this->alerts('false', 'Alerta!', 'Excluído com Sucesso!');
       	else
		$this->alerts('true', 'Erro!', 'Não foi possível Excluir!'); 

	return $exclui;
    }

    public function alterar($tabela,$campos,$delim)
    {
       $conn = "";
       $altera = $this->exec($this->atualiza($tabela, $campos, $delim));

       if($altera)
            $this->alerts('false', 'Alerta!', 'Alterado com Sucesso!');
       else
            $this->alerts('true', 'Erro!', 'Não foi possível Alterar!');   

	return $altera;
    }    
      
    public function retornaDepartamentos($filtroLoja,$filtroDPTO)
    {
        
        $sql = "SELECT TF1.T077_codigo   CodigoDepartamento
                     , TJ2.T077_nome     NomeDepartamento
                     , TJ2.T077_pai      PaiDepartamento   
                     , TF1.T006_codigo   CodigoLoja
                     , TJ1.T006_nome     NomeLoja
                     , TF1.T004_login    Usuario
                     , TJ3.T004_nome     NomeUsuario
                     , TJ3.T004_funcao   FuncaoUsuario                                 
                  FROM T006_T077         TF1
                  JOIN T006_loja         TJ1 ON ( TJ1.T006_codigo = TF1.T006_codigo )
                  JOIN T077_departamento TJ2 ON ( TJ2.T077_codigo = TF1.T077_codigo )
                  JOIN T004_usuario      TJ3 ON ( TJ3.T004_login  = TF1.T004_login  )
                 WHERE 1 = 1";
        
        
        if (($filtroLoja != ""))
            $sql .= " AND TF1.T006_codigo = $filtroLoja";
        if (!empty($filtroDPTO))
            $sql .= " AND TF1.T077_codigo = $filtroDPTO";
              
        return $this->query($sql); 
    }
    
    public function retornaUsuariosPorDepartamento($departamento, $loja)
    {
       return $this->query("SELECT TF1.T004_login          Login
                                 , TJ1.T004_nome	   Nome
                                      , TJ1.T004_matricula Matricula 
                              FROM T004_T006_T077 TF1
                              JOIN T004_usuario   TJ1 ON ( TJ1.T004_login  = TF1.T004_login  )
                              WHERE TF1.T077_codigo = $departamento
                                AND TF1.T006_codigo = $loja");
    }    
    
    public function retornaUsuarios($nome)
    {
        return $this->query("SELECT T004_login     Login
                                  , T004_nome      Nome
                                  , T004_funcao    Funcao 
                               FROM T004_usuario
                              WHERE T004_nome LIKE '%$nome%'
                           ORDER BY T004_nome");
    }
    
    public function retornaLojas()
    {
        $sql = "SELECT  TF1.T006_codigo	Codigo
                     ,  TF1.T006_nome   Nome 
                  FROM T006_loja TF1";
        
        return $this->query($sql);
    }
    
    public function retornaDptoFiltros()
    {
        $sql = "SELECT  TF1.T077_codigo	Codigo
                     ,  TF1.T077_nome   Nome 
                  FROM T077_departamento TF1";
        
        return $this->query($sql);
    } 
    
}
?>
<?php
/* -------- Controle de versões - models/T0064.php --------------
 * 1.0.0 - 22/11/2011   --> Liberada a versão
*/
?>