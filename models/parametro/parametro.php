<?php

/**************************************************************************/
/*                          DAVÓ SUPERMERCADOS                            */
/* Criado em: 18/04/2012 por Rodrigo Alfieri                              */
/* Descrição: Classe para executar as Querys do Programa de Parametros    */
/**************************************************************************/

class models_parametro extends models
{
   
    public function __construct()
    {
        $conn = "";
        parent::__construct($conn);        
    }

    public function alterar($tabela,$campos,$delim)
    {
       $conn = "";
       $altera = $this->exec($this->atualiza($tabela, $campos, $delim));

       if($altera)
            $this->alerts('false', 'Alerta!', 'A\lterado com Sucesso!');
       else
            $this->alerts('true', 'Erro!', 'Não foi possível Alterar!');   

	return $altera;
    }
    
    public function retornaValorParametro($nome)
    {
        $sql    =   " SELECT T89.T089_valor
                        FROM T003_parametros T03
                        JOIN T089_parametro_detalhe T89 ON T89.T003_codigo = T03.T003_codigo
                       WHERE T03.T003_nome  = '$nome'";
        
        return $this->query($sql)->fetchAll(PDO::FETCH_COLUMN);
    }
        
}
?>
