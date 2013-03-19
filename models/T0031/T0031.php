<?php
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 30/01/2012 por Rodrigo Alfieri
 * Descrição: 
 * Entrada:   
 * Origens:   
           
**************************************************************************
*/

class models_T0031 extends models
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

    public function retornaDeslocamentos()
    {
        $sql    =   "SELECT T15.T006_codigo_origem	CodigoOrigem
                                 , T061.T006_nome		NomeOrigem
                                 , T15.T006_codigo_destino	CodigoDestino
                                 , T062.T006_nome     		NomeDestino
                                 , T15.T015_km 			KM
                              FROM T015_deslocamentos T15
                              JOIN T006_loja T061 ON ( T061.T006_codigo = T15.T006_codigo_origem  )
                              JOIN T006_loja T062 ON ( T062.T006_codigo = T15.T006_codigo_destino )
                          ORDER BY T15.T006_codigo_origem, T15.T006_codigo_destino";
        
       return $this->query($sql);
    }
}
?>

<?php
/* -------- Controle de versões - T0031.php --------------
 * 1.0.0 - 30/01/2012 - Rodrigo Alfieri --> Liberada versao inicial
 */
?>