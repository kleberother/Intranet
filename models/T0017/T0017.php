<?php

/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 21/03/2011 por Jorge Nova                              
 * Descrição: Arquivo contém query para retornar contúdo a pagina de artigos
 * Entrada:   
 * Origens:   
           
**************************************************************************
*/

class models_T0017 extends models
{

    public function __construct()
    {
        $conn = "";
        parent::__construct($conn);
        return $this->query("Select * From T004_usuario")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function retornaArtigos()
    {
      $sql =  "SELECT T046_codigo                               Codigo
                    , T046_titulo                               Titulo
                    , date_format(T046_data_inicial,'%d/%m/%Y') DataInicial
                    , date_format(T046_data_final,'%d/%m/%Y')   DataFinal
                 FROM T046_artigos";
      
      return $this->query($sql);
    }

    public function buscaT046($cod)
    {
       return $this->query("SELECT T046_codigo       P0017_T046_COD
                                 , T046_titulo       P0017_T046_TIT
                                 , T046_data_inicial P0017_T046_DTI
                                 , T046_data_final   P0017_T046_DTF
                                 , T046_chamada      P0017_T046_CHA
                                 , T046_texto        P0017_T046_TEX
                              FROM T046_artigos
                             WHERE T046_codigo = $cod");
    }

    public function listaT045()
    {
       return $this->query("SELECT T045_codigo  P0017_T045_COD
                                 , T045_nome    P0017_T045_NOM
                              FROM T045_categoria_artigos");
    }

    public function inserir($tabela,$campos)
    {
        $insere = $this->exec($this->insere($tabela, $campos));
        
        //return $insere;
       if($insere)
            $this->alerts('false', 'Alerta!', 'Incluído com Sucesso!');
       else
            $this->alerts('true', 'Erro!', 'Não foi possível Incluir!');          
    }

    public function exclui($tabela,$campos,$delim)
    {
        $exclui = $this->exec($this->exclui($tabela, $campos, $delim));
       if($exclui)
            $this->alerts('false', 'Alerta!', 'Excluído com Sucesso!');
       else
            $this->alerts('true', 'Erro!', 'Não foi possível Excluir!'); 
    }

    public function altera($tabela,$campos,$delim)
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

<?php
/* -------- Controle de versões - T0036.php --------------
 * 1.0.0 - 21/03/2011 - Jorge --> Liberada versao inicial
 * 1.0.1 - 03/10/2011 - Jorge --> Nomes das funções alteradas
 *                                
 */
?>