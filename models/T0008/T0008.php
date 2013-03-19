    <?php

/**************************************************************************/
/*                          DAVÓ SUPERMERCADOS                            */
/* Criado em: 10/04/2011 por Rodrigo Alfieri                              */
/* Descrição: Classe para executar as Querys do Programa T0008            */
/**************************************************************************/

class models_T0008 extends models
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

    public function selecionaCategorias()
    {
        return $this->query("SELECT T056_codigo     COD
                                  , T056_nome       NOM
                                  , T056_desc       DES
                               FROM T056_categoria_arquivo")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscaCategoria($cod)
    {
        return $this->query("SELECT T056_codigo     COD
                                  , T056_nome       NOM
                                  , T056_desc       DES
                               FROM T056_categoria_arquivo
                              WHERE T056_codigo =   $cod");
    }


    public function insereT056($tabela,$campos)
    {
        $insere = $this->exec($this->insere($tabela, $campos));
        if($insere)
        {
            $codCat     = $this->lastInsertId();
            echo "CÓDIGO CATEGORIA     ".$codCat;
            $codCat     =   $this->preencheZero("E", 4, $codCat);
            mkdir(CAMINHO_ARQUIVOS."CAT".$codCat."/");
        }
    }

    public function excluiT056($tabela,$campos,$delim)
    {
        $exclui = $this->exec($this->exclui($tabela, $campos, $delim));
        
        if($exclui)
            $this->alerts('false', 'Alerta!', 'Excluído com Sucesso!');
        else
            $this->alerts('true', 'Erro!', 'Não foi possível Excluir!');         
        
    }

    public function alteraT056($tabela,$campos,$delim)
    {
       $conn = "";
       $altera = $this->exec($this->atualiza($tabela, $campos, $delim));
       
       if($altera)
            $this->alerts('false', 'Alerta!', 'Alterado com Sucesso!');
       else
            $this->alerts('true', 'Erro!', 'Não foi possível Alterar!');   

    }


}
?>