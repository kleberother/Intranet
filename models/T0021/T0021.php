<?php

/**************************************************************************/
/*                          DAVÓ SUPERMERCADOS                            */
/* Criado em: 15/04/2011 por Rodrigo Alfieri  e Jorge Nova                */
/* Descrição: Classe para executar as Querys do Programa T0021            */
/**************************************************************************/

class models_T0021 extends models
{

    public function __construct()
    {
        $conn = "";
        parent::__construct($conn);
        return $this->query("Select * From T004_usuario")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function alteraT045($cod)
    {
       return $this->query("SELECT T045_codigo  P0018_T045_COD
                                 , T045_nome    P0018_T045_NOM
                                 , T045_desc    P0018_T045_DES
                              FROM T045_categoria_artigos
                             WHERE T045_codigo = $cod");
    }

    public function listaT056()
    {
        return $this->query("SELECT T.T056_codigo            P0021_T056_COD
                                  , T.T056_nome              P0021_T056_NOM
                               FROM T056_categoria_arquivo   T;");
    }

    public function listaT002()
    {
        return $this->query("SELECT T.T002_codigo            P0021_T002_COD
                                  , T.T002_valor             P0021_T002_VAL
                               FROM T002_datatype   T;");
    }




}
?>