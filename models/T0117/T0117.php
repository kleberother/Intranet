<?php

///**************************************************************************
//                Intranet - DAVÓ SUPERMERCADOS
// * Criado em: 13/02/2013 por Rodrigo Alfieri                               
// * Descrição: Requisição de Mudança (RM)
// * Entrada:   
// * Origens:   
//           
//**************************************************************************
//*/

class models_T0117 extends models
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
//       
       return $insere;
    }      
       
    public function altera($tabela,$campos,$delim)
    {              
       $altera = $this->exec($this->atualiza($tabela, $campos, $delim));
       return $altera;
    }  
    
    public function retornaDadosUsuario($user)
    {
        $sql    =   "  SELECT T04.T004_nome     NomeUsuario
                            , T04.T004_email    EmailUsuario
                         FROM T004_usuario T04
                        WHERE T04.T004_login = '$user'";
       // echo $sql;
        return $this->query($sql);
    }
    
    public function retornaRM($titulo, $descricao, $solicitante, $codRM)
    {        
        
        $sql    =   "  SELECT T113.T113_codigo                              CodigoRM
                            , T113.T004_solicitante                         SolicitanteLogin
                            , T04B.T004_nome                                SolicitanteNome
                            , DATE_FORMAT(T113.T113_data,    '%d/%m/%Y')    DataRM
                            , DATE_FORMAT(T113_dt_hr_inicio, '%H:%i')       HoraInicioRM
                            , DATE_FORMAT(T113_dt_hr_fim ,   '%H:%i')       HoraFimRM
                            , DATE_FORMAT(T113_dt_hr_fim ,   '%d/%m/%Y')    DataFimRM
                            , DATE_FORMAT(T113_dt_hr_inicio, '%d/%m/%Y')    DataInicioRM
                            , T113.T004_responsavel                         ResponsavelLogin
                            , T04.T004_nome                                 ResponsavelNome
                            , T113.T113_titulo                              TituloRM
                            , T113.T113_descricao                           DescricaoRM
                            , T113.T113_dt_hr_inicio                        DtHrInicioRM
                            , T113.T113_dt_hr_fim                           DtHrFimRM
                            , T113.T113_motivo                              MotivoRM
                            , T113.T113_impacto                             ImpactoRM
                            , T113.T113_status                              StatusRM
                            , T113.T113_tempo_previsto                      TempoPrevisto
                            , T113.T113_obs_contingencia                    ObsContingencia
                            , T113.T004_responsavel                         Responsavel
                            ,T113.T113_tempo_total                          TempoTotal
                            ,T113.T113_janela_disponivel                    JanelaDisp
                            ,T113.T113_hora_prevista                        HoraPrevista
                            ,T113.T113_hora_disponivel                      HoraDisponivel
                            ,T113.T113_hora_total                           HoraTotal
                         FROM T113_requisicao_mudanca T113
                         JOIN T004_usuario T04 ON T04.T004_login = T113.T004_responsavel
                         JOIN T004_usuario T04B ON T04B.T004_login = T113.T004_solicitante
                         WHERE 1 = 1
                        ";
        
        if(!empty($titulo))
            $sql    .=  " AND T113.T113_titulo       LIKE   '%$titulo%'";
        if(!empty($descricao))
            $sql    .=  " AND T113.T113_descricao    LIKE   '%$descricao%'";
        if(!empty($solicitante))
            $sql    .=  " AND T113.T004_solicitante     =   '$solicitante'";
        if(!empty($codRM))
            $sql    .=  " AND T113.T113_codigo          =   '$codRM'";

//        echo $sql;
        
        return $this->query($sql);
    }
    
    public function retornaExecutoresCont($codRm) {
        
        $sql    =   "SELECT T04113.T113_codigo      Codigo
                          , T04113.T004_T113_nome   Nome
                          , T04113.T004_login       Login
                       FROM T004_T113 T04113
                      WHERE T04113.T004_T113_tipo = 2
                        AND T04113.T113_codigo    = $codRm";
        
        //echo $sql;
        return $this->query($sql);
                
        
    }
    
        public function retornaExecutoresRM($codRm) {
        
        $sql    =   "SELECT T04113.T113_codigo      Codigo
                          , T04113.T004_T113_nome Nome
                          , T04113.T004_login       Login
                       FROM T004_T113 T04113
                      WHERE T04113.T004_T113_tipo = 1
                        AND T04113.T113_codigo    = $codRm";
        
        //echo $sql;
        return $this->query($sql);
                
        
    }
    
      public function retornaExecExternoRM($codRm) {
        
        $sql    =   "SELECT T04113.T113_codigo          Codigo
                          , T04113.T004_T113_nome       Nome
                          , T04113.T004_T113_telefone   Telefone
                          , T04113.T004_T113_email      Email
                          , T04113.T004_T113_notificado Notificado
                       FROM T004_T113 T04113
                      WHERE T04113.T004_T113_tipo = 3
                        AND T04113.T113_codigo    = $codRm";
        
        //echo $sql;
        return $this->query($sql);
                
        
    }
    
    public function retornaComiteRM($codRm){
        
           $sql    =   "SELECT T04113.T113_codigo           Codigo
                          , T04113.T004_T113_nome           Nome
                          , T04113.T004_login               Login
                          , T04113.T004_T113_justificativa  Justificativa
                          , T04113.T004_T113_aprovado       Aprovado    
                       FROM T004_T113 T04113
                      WHERE T04113.T004_T113_tipo = 4
                        AND T04113.T113_codigo    = $codRm";
           
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
    
    public function retornaPerfil($user, $perfil) {
        
        $sql = "SELECT T004_login   Login
                  FROM T004_T009    T0409
                 WHERE T009_codigo  = $perfil
                   AND T004_login   = '$user'";
        
        return $this->query($sql);
        
    }
    
    public function nomeStatus($status) {
        
        switch ($status) {
            case 1:
                echo    "Aberta";
                break;
            case 2:
               echo     "Concluída";
                break;
            case 3:
                echo    "Revisada";
                break;
            case 4:
                echo    "Suspensa";
                break;
            case 5:
                echo    "Reprovada";
                break;
            case 6:
                echo    "Aprovada";
                break;
            case 7:
                echo    "Finalizada";
                break;
        }
        
    }
    
    public function mostraBotao($perfil, $user, $status, $codRM) {
        
        if (($perfil == 57 ) && ($user == $_SESSION["user"]) && ($status == 1)){
            echo " 
                    <input type='hidden' value='".$codRM."' id='codRM'>
                  <li class='ui-state-default ui-corner-all' title='Concluir'>
                                        <a href='#' class='ui-icon ui-icon-check concluir'></a> 
                   </li>
                    <li class='ui-state-default ui-corner-all' title='Excluir'>
                                       <a href='#' onclick='excluirLinha(".$codRM.")' class='ui-icon ui-icon-closethick excluir'></a> 
                    </li>
                    <li class='ui-state-default ui-corner-all' title='Alterar'>
                                        <a href='?router=T0117/alterar&codRM=".$codRM."' class='ui-icon ui-icon-pencil alterar'></a> 
                    </li>";
        } elseif(($perfil == 59)&& ($status == 2)){
            
              echo " 
                    <input type='hidden' value='".$codRM."' id='codRM'>
                    <li class='ui-state-default ui-corner-all' title='Revisar'>
                                        <a href='#' class='ui-icon ui-icon-check revisar'></a> 
                   </li>
                    <li class='ui-state-default ui-corner-all' title='Excluir'>
                                       <a href='#' onclick='excluirLinha(".$codRM.")' class='ui-icon ui-icon-closethick'></a> 
                    </li>
                    <li class='ui-state-default ui-corner-all' title='Alterar'>
                                        <a href='?router=T0117/alterar&codRM=".$codRM."' class='ui-icon ui-icon-pencil'></a> 
                    </li>";
            
        } 
        
    }
    
    public function retornaDadosUser($user) {
        
        $sql    =   " SELECT T004_nome  Nome
                        FROM T004_usuario
                       WHERE T004_login = '$user' ";
       
        return $this->query($sql);
        
    }
    
    
    public function retornaComite() {
        $sql    =   "SELECT T04.T004_nome Nome, T04.T004_email Email
                       FROM    T004_T009 T0409
                            JOIN
                               T004_usuario T04
                            ON T0409.T004_login = T04.T004_login
                            WHERE  T0409.T009_codigo = 58";
        
    
        return $this->query($sql);
    }
    

     
}
 ?>
