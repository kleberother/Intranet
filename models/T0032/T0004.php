<?php

/**************************************************************************/
/*                          DAVÓ SUPERMERCADOS                            */
/* Criado em: 09/04/2011 por Rodrigo Alfieri e Jorge Nova                 */
/* Descrição: Classe para executar as Querys do Programa T0004            */
/**************************************************************************/

class models_T0032 extends models
{


    public function __construct()
    {
        $conn = "";
        parent::__construct($conn);
    }

    public function conora()
    {
       $conn = "ora";
       parent::__construct($conn);
    }


    public function listarEstrutura()
    {
       $conn = "";
       return $this->query("SELECT E.T007_codigo        COD
                                 , E.T007_nome          NOM
                                 , E.T007_desc          DES
                                 , E.T007_pai           PAI
                                 , E.T007_prog          PRO
                                 , E.T007_tp            TIP
                              FROM T007_estrutura       E
                          ORDER BY 4,1");
    }

    public function selecionaEstrutura($cod)
    {
       $conn = "";
       return $this->query("SELECT T1.T007_codigo       COD
                                 , T1.T007_nome         NOM
                                 , T1.T007_desc         DES
                                 , T1.T007_pai          PAI
                                 , T1.T007_prog         PRO
                                 , T1.T007_tp           TIP
                              FROM T007_estrutura       T1
                             WHERE T007_codigo  =       $cod
                          ORDER BY 4,1");
    }

    public function alteraEstrutura($tabela,$campos,$delim,$cod)
    {
       $conn = "";
       $altera = $this->exec($this->atualiza($tabela, $campos, $delim, $cod));

        if ($altera)
        {
            $msg = "S";
            header('location:?router=T0004/altera&cod='.$cod.'&msg='.$msg);
        }
        else
        {
            $msg = "N";
            header('location:?router=T0004/altera&cod='.$cod.'&msg='.$msg);
        }
    }


    public function listarPai()
    {
       $conn = "";
       return $this->query("SELECT E.T007_codigo        COD
                                 , E.T007_nome          NOM
                                 , E.T007_pai           PAI
                              FROM T007_estrutura       E
                          ORDER BY 1");
    }

    public function listarAssociados($cod)
    {
       $conn = "";
       return $this->query("SELECT T1.T007_codigo       C07
                                 , T3.T007_nome         N07
                                 , T1.T009_codigo       C09
                                 , T2.T009_nome         N09
                              FROM T007_T009            T1
                                 , T009_perfil          T2
                                 , T007_estrutura       T3
                             WHERE T1.T009_codigo   =   T2.T009_codigo
                               AND T1.T007_codigo   =   T3.T007_codigo
                               AND T1.T007_codigo   =   $cod
                          ORDER BY 1");
    }

    public function listarPerfis($cod)
    {
       $conn = "";
       return $this->query("SELECT T1.T009_codigo       COD
                                 , T1.T009_nome         NOM
                              FROM T009_perfil          T1
                             WHERE T1.T009_codigo       NOT IN (SELECT T.T009_codigo
                                                                FROM T007_T009 T
                                                               WHERE T.T007_codigo = $cod)
                          ORDER BY 1");
    }

    public function insereEstrutura($tabela,$campos)
    {
        $insere = $this->exec($this->insere($tabela, $campos));

        if ($insere)
        {
            $msg = "S";
            header('location:?router=T0004/novo&msg='.$msg);
        }
        else
        {
            $msg = "N";
            header('location:?router=T0004/novo&msg='.$msg);
        }
    }

    public function excluiEstrutura($tabela, $delim)
    {
        $exclui = $this->exec($this->exclui($tabela, $delim));
    }


}
?>