<?php

/**************************************************************************/
/*                          DAVÓ SUPERMERCADOS                            */
/* Criado em: 15/04/2011 por Rodrigo Alfieri  e Jorge Nova                */
/* Descrição: Classe para executar as Querys do Programa T0043            */
/**************************************************************************/

class models_T0043 extends models
{

    public function __construct($conn)
    {
        parent::__construct($conn);
    }

    public function listaLojas()
    {
       return $this->query("SELECT L.T006_codigo AS LCODI
                                 , L.T006_nome   AS LNOME
                              FROM T006_loja     AS L");
    }

}
?>