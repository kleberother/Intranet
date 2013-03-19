<?php

/**************************************************************************/
/*                          DAVÓ SUPERMERCADOS                            */
/* Criado em: 21/03/2011 por Rodrigo Alfieri e Jorge Nova                 */
/* Descrição: Classe para executar as Querys do Programa T0014            */
/**************************************************************************/

class models_T0014 extends models
{

    public function __construct()
    {
        $conn = "";
        parent::__construct($conn);
        return $this->query("SELECT *
                               FROM T004_usuario")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function selecionaGrpWork()
    {
        $conn = "";
        return $this->query("SELECT W.T059_codigo       C59
                                  , W.T059_nome         NOM
                                  , W.T059_desc         DES
                                  , W.T004_login        LOG
                                  , W.T061_codigo       C61
                                  , P.T061_nome         PRO
                               FROM T059_grupo_workflow W
                         INNER JOIN T061_processo       P
                                 ON P.T061_codigo = W.T061_codigo
                           ORDER BY P.T061_codigo ASC, W.T004_login ASC, W.T059_nome ASC")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function selecionaGrpWork2($cod)
    {
       return $this->query("SELECT A.T059_codigo        C59
                                 , A.T059_nome          N59
                                 , A.T059_desc          D59
                                 , B.T061_codigo        C61
                                 , B.T061_nome          N61
                              FROM T059_grupo_workflow  A
                        INNER JOIN T061_processo        B
                                ON A.T061_codigo = B.T061_codigo
                             WHERE A.T059_codigo = $cod");
    }

    public function selecionaUserGrpWork($cod, $codpro)
    {
       return $this->query("SELECT B.T004_login     L04
                                 , B.T004_nome      N04
                              FROM T004_T059 as     A
                        INNER JOIN T004_usuario     B
                                ON B.T004_login  = A.T004_login
                             WHERE A.T059_codigo = $cod
                               AND A.T061_codigo = $codpro");
    }

    public function selecionaProcesso()
    {
       return $this->query("SELECT T061_codigo    COD
                                 , T061_nome      NOM
                              FROM T061_processo");
    }

    public function excluiGrpWork($tabela, $delim)
    {
        $exclui = $this->exec($this->exclui($tabela, $delim));
       if($exclui)
            $this->alerts('false', 'Alerta!', 'Excluído com Sucesso!');
       else
            $this->alerts('true', 'Erro!', 'Não foi possível Excluir!'); 
    }

    public function insereT059($tabela,$campos)
    {
        $insere = $this->exec($this->insere($tabela, $campos));
       if($insere)
            $this->alerts('false', 'Alerta!', 'Incluído com Sucesso!');
       else
            $this->alerts('true', 'Erro!', 'Não foi possível Incluir!');          
    }

    public function alteraT059($tabela,$campos,$delim)
    {
       $conn = "";
       $altera = $this->exec($this->atualiza($tabela, $campos, $delim));
       if($altera)
            $this->alerts('false', 'Alerta!', 'Alterado com Sucesso!');
       else
            $this->alerts('true', 'Erro!', 'Não foi possível Alterar!');   
    }

    public function insereT004_T059($tabela,$campos)
    {
        $insere = $this->exec($this->insere($tabela, $campos));
       if($insere)
            $this->alerts('false', 'Alerta!', 'Incluído com Sucesso!');
       else
            $this->alerts('true', 'Erro!', 'Não foi possível Incluir!');          
    }
   
}
?>