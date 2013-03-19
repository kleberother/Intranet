<?php

/**************************************************************************/
/*                          DAVÓ SUPERMERCADOS                            */
/* Criado em: 09/04/2011 por Rodrigo Alfieri e Jorge Nova                 */
/* Descrição: Classe para executar as Querys do Programa T0004            */
/**************************************************************************/

class models_T0005 extends models
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


    public function listarPerfis()
    {
       return $this->query("SELECT P.T009_codigo    COD
                                 , P.T009_nome      NOM
                                 , P.T009_desc      DES
                              FROM T009_perfil      P");
    }

    public function selecionaPerfil($cod)
    {
       return $this->query("SELECT P.T009_codigo    COD
                                 , P.T009_nome      NOM
                                 , P.T009_desc      DES
                              FROM T009_perfil      P
                             WHERE P.T009_codigo = $cod");
    }

    public function selecionaUsuario($cod)
    {
       return $this->query("SELECT T009_codigo      COD
                                 , T004_login       LOG
                              FROM T004_T009
                             WHERE T009_codigo = $cod");
    }

    public function selecionaUsuarios($cod)
    {
       return $this->query("SELECT T2.T004_matricula    MAT
                                 , T1.T004_login        L04
                                 , T2.T004_nome         N04
                              FROM T004_t009            T1
                                 , T004_usuario         T2
                             WHERE T1.T004_login  = T2.T004_login
                               AND T1.T009_codigo = $cod");
    }

    public function selecionaEstrutura($cod)
    {
       return $this->query("SELECT T1.T007_codigo       COD
                                 , T2.T007_nome         NOM
                                 , T2.T007_desc         DES
                                 , T2.T007_tp           TIP
                              FROM T007_T009            T1
                                 , T007_estrutura       T2
                             WHERE T1.T007_codigo = T2.T007_codigo
                               AND T1.T009_codigo = $cod");
    }

    public function selecionaEstrutura2()
    {
       return $this->query("SELECT T1.T007_codigo       COD
                                 , T1.T007_nome         NOM
                                 , T1.T007_desc         DES
                                 , T1.T007_tp           TIP
                              FROM T007_estrutura       T1");
    }

    public function insereT009($tabela,$campos)
    {
        $insere = $this->exec($this->insere($tabela, $campos));
        
        if($insere)
            $this->alerts('false', 'Alerta!', 'Incluído com Sucesso!');
        else
            $this->alerts('true', 'Erro!', 'Não foi possível Incluir!');  
        
        
    }

    public function insereT004_T009($tabela,$campos)
    {
        $insere = $this->exec($this->insere($tabela, $campos));
        
        if($insere)
            $this->alerts('false', 'Alerta!', 'Incluído com Sucesso!');
        else
            $this->alerts('true', 'Erro!', 'Não foi possível Incluir!');          
    }

    public function excluir($tabela,$delim)
    {
        $exclui =  $this->exec($this->exclui($tabela, $delim));
        
        if($exclui)
             $this->alerts('false', 'Alerta!', 'Excluído com Sucesso!');
        else
             $this->alerts('true', 'Erro!', 'Não foi possível Excluir!'); 
        
        return $exclui;
    }

    public function alteraT009($tabela,$campos,$delim)
    {
       $conn = "";
       $altera =  $this->exec($this->atualiza($tabela, $campos, $delim));
       
       if($altera)
            $this->alerts('false', 'Alerta!', 'Alterado com Sucesso!');
       else
            $this->alerts('true', 'Erro!', 'Não foi possível Alterar!');          
       
       return  $altera;
    }
    
    public function retornaQtdeUsuarios($CodigoPerfil)
    {
        $sql = "SELECT count(T004_login)    ContadorUsuarios
                  FROM T004_T009 
                 WHERE T009_codigo = $CodigoPerfil";
        
        return $this->query($sql);
    }

    public function retornaQtdeMenus($CodigoPerfil)
    {
        $sql = "SELECT count(T009_codigo) ContadorMenus
                  FROM T007_T009 
                 WHERE T009_codigo = $CodigoPerfil";
        
        return $this->query($sql);
    }
    

    
}
?>