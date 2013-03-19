<?php

/**************************************************************************/
/*                          DAVÓ SUPERMERCADOS                            */
/* Criado em: 21/03/2011 por Rodrigo Alfieri                              */
/* Descrição: Classe para executar as Querys do Programa T00              */
/**************************************************************************/

class models_T0023 extends models
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




}
?>