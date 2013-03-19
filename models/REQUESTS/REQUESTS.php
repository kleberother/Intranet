<?php

/**************************************************************************/
/*                          DAVÓ SUPERMERCADOS                            */
/* Criado em: 24/11/2011 por Jorge Nova                                   */
/* Descrição: Classe para executar as Querys das funções gerais           */
/**************************************************************************/

class models_REQUESTS extends models
{
    public function inserir($tabela,$campos)
    {
        return $this->exec($this->insere($tabela, $campos));
    }

    public function excluir($tabela, $delim)
    {
        return $exclui = $this->exec($this->exclui($tabela, $delim));
    }

    public function alterar($tabela,$campos,$delim)
    {
       $conn = "";
       return $this->exec($this->atualiza($tabela, $campos, $delim));
    }    
    
    public function retornaDadosUsuario($login,$departamento)
    {
        $sql = "SELECT TF1.T004_login	   Login
                      , TF1.T004_nome      Nome
                      , TF1.T004_matricula Matricula
                      , TF1.T004_funcao    Funcao
                      , TF1.T004_email     Email
                      , TJ2.T006_nome	   NomeLoja
                      , TJ3.T077_nome      NomeDepartamento
                   FROM T004_usuario            TF1
              LEFT JOIN T004_T006_T077          TJ1 ON ( TJ1.T004_login  = TF1.T004_login  )
              LEFT JOIN T006_loja               TJ2 ON ( TJ2.T006_codigo = TJ1.T006_codigo )
              LEFT JOIN T077_departamento       TJ3 ON ( TJ3.T077_codigo = TJ1.T077_codigo )
             WHERE TF1.T004_login  = '$login'
               AND TJ3.T077_codigo = $departamento";
        
        return $this->query($sql);
    }

    public function retornaContatosUsuario($login)
    {
        $sql = "SELECT TF1.T011_pais	CodPais
                     , TF1.T010_area	CodArea
                     , TF1.T010_numero	NumeroFone
                     , TF1.T010_ramal	Rmal
                     , TJ2.T011_nome	TipoFone
                  FROM T010_fone        TF1
             LEFT JOIN T004_usuario     TJ1 ON ( TJ1.T004_login = TF1.T004_login )
             LEFT JOIN T011_fone_tipo   TJ2 ON ( TJ2.T011_codigo = TF1.T011_codigo )
                  WHERE TF1.T004_login = '$login'";
        
        return $this->query($sql);
    }    
    
    public function retornaUsuarios($nome)
    {
        return $this->query("SELECT T004_login     Login
                                  , T004_nome      Nome
                                  , T004_funcao    Funcao 
                               FROM T004_usuario
                              WHERE T004_nome  LIKE '%$nome%'
                                 OR T004_login LIKE '%$nome%'                
                           ORDER BY T004_nome");
    }

    public function retornaColaboradores($nome)
    {
        return $this->query("SELECT TF1.T052_matricula	Matricula
                                  , TF1.T052_nome	Nome
                                  , TJ1.T006_nome       NomeLoja
                               FROM T052_colaborador TF1
                               JOIN T006_loja        TJ1 ON ( TJ1.T006_codigo = TF1.T006_codigo )
                              WHERE TF1.T052_nome	LIKE '%$nome%'");
    }

    public function retornaFornecedor($nome)
    {
        return $this->query("SELECT TF1.T026_codigo             Codigo
                                  , TF1.T026_rms_razao_social   RazaoSocial
                               FROM T026_fornecedor TF1
                              WHERE TF1.T026_rms_razao_social LIKE '%$nome%'");
    }
    
    public function retornaDepartamentos($loja)
    {
        $sql = " SELECT TF1.T077_codigo   Codigo
                      , TF1.T077_nome     Nome 
                   FROM T077_departamento TF1
                  WHERE T077_codigo IN ( SELECT TW1.T077_codigo 
                                           FROM T077_departamento TW1
                                           JOIN T006_T077         TJW1 ON ( TJW1.T077_codigo = TW1.T077_codigo ) 
                                          WHERE TJW1.T006_codigo = $loja
                                       )";
        
        return $this->query($sql);
    }

    
      

}
?>