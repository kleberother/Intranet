<?php
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 14/09/2011 por Jorge Nova                              
 * Descrição: Querys para programa 32 (Gerenciamento de Centro de Custo)
 * Entrada:   
 * Origens:   
           
**************************************************************************
*/

class models_T0032 extends models
{


    public function inserir($tabela,$campos)
    {
        $insere =  $this->exec($this->insere($tabela, $campos));
        if($insere)
             $this->alerts('false', 'Alerta!', 'Incluído com Sucesso!');
        else
             $this->alerts('true', 'Erro!', 'Não foi possível Incluir!');         
        
        return $insere;
    } 

    public function excluir($tabela, $delim)
    {
        $exclui = $this->exec($this->exclui($tabela, $delim));

       	if($exclui)
		$this->alerts('false', 'Alerta!', 'Excluído com Sucesso!');
       	else
		$this->alerts('true', 'Erro!', 'Não foi possível Excluir!'); 

	return $exclui;
    }

    public function listaCentroCusto()
    {
       return $this->query("SELECT T013_codigo	Codigo
                                 , T013_nome 	Nome
                              FROM T013_centro_custo");
    }

}
?>

<?php
/* -------- Controle de versões - T0032.php --------------
 * 1.0.0 - 14/09/2011 - Jorge --> Liberada versao inicial
 */
?>