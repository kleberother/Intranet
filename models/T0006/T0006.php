    <?php

/**************************************************************************/
/*                          DAVÓ SUPERMERCADOS                            */
/* Criado em: 10/04/2011 por Rodrigo Alfieri                              */
/* Descrição: Classe para executar as Querys do Programa T0008            */
/**************************************************************************/

class models_T0006 extends models
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

    public function selecionaArquivos()
    {
        return $this->query("SELECT T1.T055_codigo          COD
                                  , T1.T055_nome            NOM
                                  , T1.T055_desc            DES
                                  , T1.T055_dt_upload       DUP
                                  , T1.T004_login           LOG
                                  , T3.T057_nome            N57
                                  , T2.T056_nome            N56
                                  , T1.T059_codigo          C59
                                  , T1.T061_codigo          C61
                               FROM T055_arquivos           T1
                                  , T056_categoria_arquivo  T2
                                  , T057_extensao           T3
                              WHERE T1.T056_codigo = T2.T056_codigo
                                AND T1.T057_codigo = T3.T057_codigo")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscaArquivo($cod)
    {
        return $this->query("SELECT T056_codigo     COD
                                  , T056_nome       NOM
                                  , T056_desc       DES
                               FROM T056_categoria_arquivo
                              WHERE T056_codigo =   $cod")->fetchAll(PDO::FETCH_ASSOC);
    }


}
?>