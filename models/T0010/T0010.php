<?php

/**************************************************************************/
/*                          DAVÓ SUPERMERCADOS                            */
/* Criado em: 09/04/2011 por Rodrigo Alfieri e Jorge Nova                 */
/* Descrição: Classe para executar as Querys do Programa T00              */
/**************************************************************************/

class models_T0010 extends models
{

    public function __construct()
    {
        $conn = "";
        parent::__construct($conn);
        return $this->query("Select * From T004_usuario")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function conora()
    {
       $conn = "ora";
       parent::__construct($conn);
       return $this->query("Select * From RMS.AA2CTIPO")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarUsuarios()
    {
       $sql = "SELECT U.T004_login 		Login
                    , U.T004_nome		Nome
                    , U.T004_matricula          Matricula
                    , U.T006_codigo		CodigoLoja
                    , U.T004_permissao_arquivo	Permissao
                    , L.T006_nome		NomeLoja
                 FROM T004_usuario     AS U
            LEFT JOIN T006_loja        AS L        ON L.T006_codigo = U.T006_codigo";
       
        return $this->query($sql);
    }

    public function buscaUsuario($login)
    {
       $conn = "";
       return $this->query(" SELECT TF1.T004_nome			Nome
                                  , TF1.T004_nome_display		DisplayNome
                                  , TF1.T004_funcao			Funcao
                                  , TF1.T004_departamento		Departamento
                                  , TF1.T004_ramal			Ramal
                                  , TF1.T004_celular			Celular
                                  , TJ1.T006_codigo			CodigoLoja
                                  , TJ1.T006_nome			NomeLoja
                               FROM T004_usuario     AS TF1
                               JOIN T006_loja        AS TJ1     ON ( TF1.T006_codigo = TJ1.T006_codigo )
                              WHERE TF1.T004_login = '$login'");
    }

    public function buscaUsuarioSemEmail()
    {
       $conn = "";
       return $this->query("SELECT T.T004_login Login FROM T004_usuario T WHERE T.T004_email IS NULL");
    }

    public function listaLojas($login)
    {
       $conn = "";
       return $this->query("SELECT L.T006_codigo CodigoLoja
                                 , L.T006_nome   NomeLoja
                              FROM T006_loja     AS L");
    }
    
    public function retornaDadosUsuario($usuario)
    {
        $sql = "SELECT TF1.T004_login	   Login
                      , TF1.T004_nome      Nome
                      , TF1.T004_matricula Matricula
                      , TF1.T004_funcao    Funcao
                      , TF1.T004_email     Email
                      , TJ2.T006_nome	   NomeLoja
                      , TJ3.T077_nome      NomeDepartamento
              FROM T004_usuario            TF1
              JOIN T004_T006_T077          TJ1 ON ( TJ1.T004_login  = TF1.T004_login  )
              JOIN T006_loja               TJ2 ON ( TJ2.T006_codigo = TJ1.T006_codigo )
              JOIN T077_departamento       TJ3 ON ( TJ3.T077_codigo = TJ1.T077_codigo )
             WHERE TF1.T004_login = '$usuario'";
        
        return $this->query($sql);
    }

    public function retornaContatosUsuario($usuario)
    {
        $sql = "SELECT TF1.T011_pais	CodPais
                     , TF1.T010_area	CodArea
                     , TF1.T010_numero	NumeroFone
                     , TF1.T010_ramal	Rmal
                     , TJ2.T011_nome	TipoFone
                  FROM T010_fone        TF1
                  JOIN T004_usuario     TJ1 ON ( TJ1.T004_login = TF1.T004_login )
                  JOIN T011_fone_tipo   TJ2 ON ( TJ2.T011_codigo = TF1.T011_codigo )
                  WHERE TF1.T004_login = '$usuario'";
        
        return $this->query($sql);
    }
    
    public function alterar($tabela,$campos,$delim)
    {
       $conn   = "";
       $altera = $this->exec($this->atualiza($tabela, $campos, $delim));
       
       if($altera)
            $this->alerts('false', 'Alerta!', 'Alterado com Sucesso!');
       else
            $this->alerts('true', 'Erro!', 'Não foi possível Alterar!');         
       
    }   

}
?>