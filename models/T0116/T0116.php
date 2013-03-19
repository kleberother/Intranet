<?php

///**************************************************************************
//                Intranet - DAVÓ SUPERMERCADOS
// * Criado em: 02/05/2012 por Roberta Schimidt                               
// * Descrição: Tela controle de cheques
// * Entrada:   
// * Origens:   
//           
//**************************************************************************
//*/
//
//
class models_T0116 extends models
{
    
    public function __construct($conn,$verificaConexao,$db)
    {
        parent::__construct($conn,$verificaConexao,$db);
    }
    
    public function inserir($tabela,$campos)
    {
        
        $insere = $this->exec($this->insere($tabela, $campos));
        
//       if($insere)
//            $this->alerts('false', 'Alerta!', 'Incluido com Sucesso!');
//       else
//            $this->alerts('true', 'Erro!', 'Não foi possível Incluir!');
       
       return $insere;
    }      
       
    public function altera($tabela,$campos,$delim)
    {              
       $altera = $this->exec($this->atualiza($tabela, $campos, $delim));
       
//       if($altera)
//            $this->alerts('false', 'Alerta!', 'Alterado com Sucesso!');
//       else
//            $this->alerts('true', 'Erro!', 'Não foi possível Alterar!');          
       
      // echo $altera;
       return $altera;
    }   
    
    public function retornaAreas($codigoArea, $userPrincipal, $userSuplente, $nomeArea)
    {
        $sql    =   "  SELECT T114.T114_codigo     CodigoArea
                            , T114.T004_principal  PrincipalArea
                            , T114.T004_suplente   SuplenteArea
                            , T114.T114_descricao  DescricaoArea
                            , T114.T114_nome       NomeArea
                         FROM T114_areas_negocio T114
                        WHERE 1  = 1";
        
        if(!empty($codigoArea))
            $sql    .=  " AND T114.T114_codigo       =        $codigoArea     ";
        if(!empty($userPrincipal))
            $sql    .=  " AND T114.T004_principal    like   '%$userPrincipal%'  ";
        if(!empty($userSuplente))
            $sql    .=  " AND T114.T004_suplente     like   '%$userSuplente%'   ";
        if(!empty($nomeArea))
            $sql    .=  " AND T114.T114_nome         like   '%$nomeArea%'       ";
       
        return $this->query($sql);
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
    
}
 ?>
