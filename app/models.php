<?php

/**************************************************************************/
/*                          DAVÓ SUPERMERCADOS                            */
/* Criado em: 21/03/2011 por Rodrigo Alfieri                              */
/* Descrição: Classe para realizar conexão com os BD's e
 *           funções utilizadas em todos os programas                     */
/**************************************************************************/
  
class models extends PDO
{

    var $usuario;
    var $senha;
    var $consulta = "";
      
    public function __construct($conn,$verificaConexao,$db)
    { 
        //Verifica se o servidor é PRD, strings de conxão assumirão PRD para Oracle, SQL Server, MySQL
        if($_SERVER['SERVER_ADDR'] == PRD_HOST)
        {    
            try
                {
                    //Verifica qual tipo de conexão a classe deve fazer
                    switch ($conn)
                    {

                     //Para conexão Oracle usar string "ora"
                     case "ora" :
                                try
                                {
                                    $i  =   1;
                                    while ($i <= 25)
                                    {
                                        $this->consulta = oci_connect(PRD_USER_ORACLE,PRD_PASS_ORACLE,PRD_TNS_ORACLE);
                                        if(!$this->consulta)
                                        {                                            
                                            if($verificaConexao==1)
                                            {
                                                echo "Não Foi Possível Conectar no Oracle";
                                                break;
                                            }
                                            else
                                            {
                                                $i++;
                                            }
                                        }
                                        else
                                        {
                                            return $this->consulta;
                                            break;                                        
                                        }
                                    }
                                }
                                catch(oci_error $i)
                                {
                                    //print "Erro Conexao Oracle";
                                    print $i;
                                }
                            break;
                     //Para conexão SQL Server usar a string "mssql"
                     case "mssql"       :
                            $i  =   1;
                            while ($i <= 25)
                            { 
                                $conn = mssql_connect(PRD_HOST_MSSQL, PRD_USER_MSSQL, PRD_PASS_MSSQL);
                                mssql_select_db($db, $conn);
                                $this->consulta = $conn;
                                if($this->consulta)
                                {
                                    return $this->consulta;
                                    break;
                                }
                                else
                                    $i++;
                            }
                            break;
                     case "emporium"     :   
                         //Testa se deve apresentar erro de conexão na view
                            $link = mysql_connect(PRD_HOST_EMPORIUM, PRD_USER_EMPORIUM, PRD_PASS_EMPORIUM);    
                            if (!$link) 
                                echo ($verificaConexao==1)?"":die('' . mysql_error());
                            else 
                                parent::__construct('mysql:host='.PRD_HOST_EMPORIUM.';dbname='.PRD_BD_EMPORIUM, PRD_USER_EMPORIUM, PRD_PASS_EMPORIUM);
                            break; 
                     //Caso não seja nenhum dos casos acima ele faz a conexão com o MySQL Satélite/Intranet
                     default :
                            parent::__construct('mysql:host='.PRD_HOST.';dbname='.PRD_BD, PRD_USER, PRD_PASS);
                            $this->exec("SET NAMES 'utf8'");
                            $this->exec("SET character_set_connection=utf8");
                            $this->exec("SET character_set_client=utf8");
                            $this->exec("SET character_set_results=utf8");
                            break;      
                    }
                }
                //Exceções que ocorrem no Banco **** CRIAR AS MENSAGENS *****
                catch (PDOException $i)
                {
                    print $i;
                }            
        }
        else
        {
            try
                {
                    //Verifica qual tipo de conexão a classe deve fazer
                    switch ($conn)
                    {

                     //Para conexão Oracle usar string "ora"
                     case "ora" :
                                try
                                {
                                    $i  =   1;
                                    while ($i <= 25)
                                    {
                                        //$this->consulta = oci_connect(QAS_USER_ORACLE,QAS_PASS_ORACLE,QAS_TNS_ORACLE);
                                        $this->consulta = oci_connect(PRD_USER_ORACLE,PRD_PASS_ORACLE,PRD_TNS_ORACLE);
                                        if(!$this->consulta)
                                        {                                            
                                            if($verificaConexao==1)
                                            {
                                                echo "Não Foi Possível Conectar no Oracle";
                                                break;
                                            }
                                            else
                                            {
                                                $i++;
                                            }
                                        }
                                        else
                                        {
                                            return $this->consulta;
                                            break;                                        
                                        }
                                    }
                                }
                                catch(oci_error $i)
                                {
                                    //print "Erro Conexao Oracle";
                                    print $i;
                                }
                            break;
                     //Para conexão SQL Server usar a string "mssql"
                     case "mssql"       :
                            $i  =   1;
                            while ($i <= 25)
                            { 
                              //$conn = mssql_connect(QAS_HOST_MSSQL, QAS_USER_MSSQL, QAS_PASS_MSSQL);
                              $conn = mssql_connect(PRD_HOST_MSSQL, PRD_USER_MSSQL, PRD_PASS_MSSQL);
                                mssql_select_db($db, $conn);
                                $this->consulta = $conn;
                                if($this->consulta)
                                {
                                    return $this->consulta;
                                    break;
                                }
                                else
                                    $i++; 
                            }
                            break;
                     case "emporium"     :   
                         //Testa se deve apresentar erro de conexão na view
                 // $link = mysql_connect(QAS_HOST_EMPORIUM, QAS_USER_EMPORIUM, QAS_PASS_EMPORIUM);    
                   $link = mysql_connect(PRD_HOST_EMPORIUM, PRD_USER_EMPORIUM, PRD_PASS_EMPORIUM); 
                            if (!$link) 
                                echo ($verificaConexao==1)?"Não foi possivel conectar":die('Não foi possível conectar: ' . mysql_error());
                            else 
                             parent::__construct('mysql:host='.PRD_HOST_EMPORIUM.';dbname='.PRD_BD_EMPORIUM, PRD_USER_EMPORIUM, PRD_PASS_EMPORIUM);
                           // parent::__construct('mysql:host='.QAS_HOST_EMPORIUM.';dbname='.QAS_BD_EMPORIUM, QAS_USER_EMPORIUM, QAS_PASS_EMPORIUM);
                                
                            break; 
                     //Caso não seja nenhum dos casos acima ele faz a conexão com o MySQL Satélite/Intranet
                     default :
                            parent::__construct('mysql:host='.QAS_HOST.';dbname='.QAS_BD, QAS_USER, QAS_PASS);
                            $this->exec("SET NAMES 'utf8'");
                            $this->exec("SET character_set_connection=utf8");
                            $this->exec("SET character_set_client=utf8");
                            $this->exec("SET character_set_results=utf8");
                            break;      
                    }
                }
                //Exceções que ocorrem no Banco **** CRIAR AS MENSAGENS *****
                catch (PDOException $i)
                {
                    print $i;   
                }             
        }
    }

/***************************************************************/
/*                                                             */
/*                 A U T E N T I C A Ç Ã O   A D               */
/*                                                             */
/***************************************************************/


    //Função para fazer autenticação, verifica o action do botão Login
    public function autentica()
    {
        $action = $_REQUEST['action'];
        switch($action)
        {
            case "login":
                $this->usuario  =   $_REQUEST["usuario"];
                $this->senha    =   $_REQUEST["senha"];
                $host           =   $_SERVER["REMOTE_ADDR"];
                switch($host)
                {
                    /*
                        Caso seja extranet verifica valida o usuario pelo banco, 
                        caso não, autentica pelo AD (Intranet QAS e PRD) 
                    */
                    case EXTRANET_HOST:
                        self::autenticaExtranet($this->usuario, $this->senha);
                        break;
                    default: 
                        self::autenticaAD($this->usuario, $this->senha);
                        break;
                }
                break;
            case "logout":
                self::logout();
                $_SERVER['msg'] = "Você ainda não está logado, clique aqui para logar!";
                break;
            case "":
                $_SERVER['msg'] = "Você ainda não está logado, clique aqui para logar!";
                break;
        }
    }

    public function autenticaExtranet($user, $pass)
    {
        $sql    =   "   SELECT T04.T004_login               usuarioLogin
                             , T04.T004_nome                usuarioNome
                             , T04.T004_senha               usuarioSenha
                             , T04.T004_matricula           usuarioMatricula
                             , T04.T004_funcao              usuarioFuncao
                             , T04.T004_data_ult_alteracao  usuarioAlteracao
                             , T04.T004_adm                 usuarioAdm
                             , T04.T006_codigo              lojaCodigo
                             , T04.T004_permissao_arquivo   usuarioPermArquivo
                             , T04.T004_REMOTE_HOST         usuarioRemoteHost
                             , T04.T004_email               usuarioEmail
                             , T04.T004_cpf                 usuarioCpf
                          FROM T004_usuario T04
                         WHERE T04.T004_login = '$user'";
        if (empty($pass))
            $sql .= " AND T04.T004_senha IS NULL";
        else
            $sql .= " AND T04.T004_senha = '".md5($pass)."'";
        
        //echo $sql;
                
        $dados  =   $this->query($sql);
        
        foreach($dados  as $campos=>$valores)
        {
            $_SESSION['displayName']    = $valores['usuarioNome']   ;   
            $_SESSION['senha']          = $valores['usuarioSenha']  ;  
            $_SESSION['user']           = $valores['usuarioLogin']  ;  
        }        
    }
    //Captura as informações do AD
    public function autenticaAD($user, $pass)
    {
        //Verifica se o ambiente é de Produção
        if($_SERVER['SERVER_ADDR'] == PRD_HOST)   
        {
             $conn = ldap_connect(HOST_AD);
             ldap_set_option($conn, LDAP_OPT_PROTOCOL_VERSION, 3);
             ldap_set_option($conn, LDAP_OPT_REFERRALS, 0);
             if(!$conn)
             {
                $_SERVER['msg']="não foi possível efetuar conexão com o Active Directory";
                //header("Location:index.php");
             }
             else
             {
                $bind = ldap_bind($conn, $user."@".DOMINIO_AD, $pass);
                if(!$bind)
                {
                    $_SERVER['msg']="Usuário ou senha incorreto(s)";
                }
                else
                {  $attributes = array
                                (
                                  "displayname"
                                 ,"mail"
                                 ,"department"
                                 ,"title"
                                );
                    $filter   = "(&(objectCategory=person)(sAMAccountName=$user))";
                    $result   = ldap_search($conn, DN_AD, $filter, $attributes);
                    if($result)
                    {
                        $entries  = ldap_get_entries($conn, $result);
                        $_SESSION['displayName']    = $entries[0]['displayname'][0];
                        $_SESSION['mail']           = $entries[0]['mail'][0];
                        $_SESSION['department']     = $entries[0]['department'][0];
                        $_SESSION['title']          = $entries[0]['title'][0];
                        $_SESSION['user']           = $user;
                        $displayname                = $_SESSION['displayName'];                    
                        self::verificaUsuario($user, $displayname);
                    }else
                    {
                        $_SERVER['msg']="Usuário ou senha incorreto(s)";
                    }                               
                }
             }            
        }
        else
            {
                $_SESSION['title']          = $entries[0]['title'][0]   ;
                $_SESSION['user']           = $user                     ;
                $displayname                = $_SESSION['displayName']  ;                   
            }

    }

    //Apaga o valor da variável $_SESSION['user']
    private static function logout()
    {
        session_destroy();
        session_regenerate_id();
        $_SESSION['user'] = null;
        //header("Location:index.php");
    }

    private function verificaUsuario($user, $displayname)
    {
        $this->query("   SELECT T004_login          T04_LOG
                              , T004_nome           T04_NOM
                              , T004_matricula      T04_MAT
                              , T004_adm            T04_ADM
                              , T006_codigo         T06_COD
                              , T026_codigo         T26_COD
                           FROM Satelite.T004_usuario
                          WHERE T004_login = '$user'");
        $i  =   0;
        foreach($usuario as $campos=>$valores)
        {
            $i++;
        }

        if($i == 0 )
        {
            $tabela =   "T004_usuario";
            $campos =   array( "T004_login"         => "$user"
                             , "T004_nome"          => "$displayname"
                             , "T004_matricula"     => "null");

            $insere = $this->exec($this->insere($tabela, $campos));
            //header("Location:index.php");
        }
    }
/***************************************************************/
/*                                                             */
/*               F I M   A U T E N T I C A Ç Ã O               */
/*                                                             */
/***************************************************************/
/***************************************************************/
/*                                                             */
/*                          M E N U                            */
/*                                                             */
/***************************************************************/

    //Gera $superArray para criar o menu
    public function menu($tipo, $grps)
    {
        $superArray = array ();
        
        if($tipo == "privado")
        {
            $menu = $this->query("SELECT DISTINCT T1.T007_codigo
                                                , T1.T007_pai
                                                , T1.T007_nome
                                                , T1.T007_tp
                                             FROM T007_estrutura   T1
                                                , T007_T009        T2
                                            WHERE T1.T007_pai IS NUll
                                              AND T2.T007_codigo = T1.T007_codigo
                                              AND T2.T009_codigo IN ($grps)
                                         GROUP BY T1.T007_codigo
                                                , T1.T007_pai
                                                , T1.T007_nome
                                                , T1.T007_tp
                                         ORDER BY 4 DESC");
            foreach ($menu as $campos=>$valores)
            {
                $this->query("SELECT *
                                FROM T007_estrutura T1
                                JOIN T007_T009 T2 ON (     T2.T007_codigo = T1.T007_codigo
                                                       AND T2.T009_codigo IN ( $grps )	
						     )                                
                               WHERE T007_pai = " . $valores['T007_codigo'])->fetchAll(PDO::FETCH_ASSOC);
                $superArray[$valores['T007_nome']] = $this->tem_filho($valores['T007_codigo'],$tipo,$grps);
            }
        return $superArray;
        }
        else
        {
            
            $sql  = "SELECT DISTINCT T1.T007_codigo
                                                , T1.T007_pai
                                                , T1.T007_nome
                                                , T1.T007_tp
                                             FROM T007_estrutura    T1
                                            WHERE T007_pai          IS NUll
                                              AND T007_tp           =   1";
            
            
            $menu = $this->query($sql);//->fetchAll(PDO::FETCH_ASSOC);
            
            foreach ($menu as $campos=>$valores)
            {
               
                $this->query("SELECT * 
                                FROM T007_estrutura T1
                               WHERE T007_pai = " . $valores['T007_codigo'])->fetchAll(PDO::FETCH_ASSOC);

                $superArray[$valores['T007_nome']] = $this->tem_filho($valores['T007_codigo'],$tipo,$grps);
            }
        return $superArray;
        }
    }

    //Função para verificar os sub-menus
    public function tem_filho($id_menu,$tipo,$grps)
    {

        $superArray =   array();
        $sql        =   "SELECT T1.*
                           FROM T007_estrutura T1
                           JOIN T007_T009 T2 ON (T2.T007_codigo = T1.T007_codigo";
        
        // verifica se possui perfis de permissao à serem verificados
        // ou verifica se menu é publico
        if((is_null($grps)) || (is_null($tipo)))
            // retorna todos os menus que possuem esse pai
            $sql .= ") WHERE T007_pai = " . $id_menu;            
        else
            // retorna todos os menus que possuem esse pai e que os perfis possuem permissao
            $sql .= "   AND T2.T009_codigo IN ($grps))
                      WHERE T007_pai = " . $id_menu;

        
        
        $menu       =   $this->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        if($menu)
        {
            foreach ($menu as $campos=>$valores)
            {
                $superArray[$valores['T007_nome']] = $this->tem_filho($valores['T007_codigo'],$tipo,$grps);
            }
            return $superArray;
        }
        else
        {
            return $id_menu;
        }
    }

    //Função para verificar os sub-menus
    public function tem_pai($id_menu)
    {
        $superArray = array();
        $menu = $this->query("SELECT *
                                FROM T007_estrutura T1
                                JOIN T007_T009 T2 ON (     T2.T007_codigo = T1.T007_codigo
                                                       AND T2.T009_codigo IN ( 28 )	
						     )                                
                                
                               WHERE T007_codigo = " . $id_menu);//fetchAll(PDO::FETCH_ASSOC);
        if($menu)
        {
            foreach ($menu as $campos=>$valores)
            {
                if (is_null($valores['T007_pai']))
                {
                    $superArray[$valores['T007_nome']] = $valores['T007_codigo'];
                }
                else
                {
                    $superArray[$valores['T007_nome']] = $this->tem_pai($valores['T007_pai']);
                }
            }
            return $superArray;
        }
        else
        {
            return $id_menu;
        }
    }

    public function retornaTpMenu($id)
    {
        return $this->query("SELECT T007_tp
                                  , T007_extranet   extranet
                               FROM T007_estrutura
                              WHERE T007_codigo = $id");
    }


/***************************************************************/
/*                                                             */
/*                    F I M    M E N U                         */
/*                                                             */
/***************************************************************/

/***************************************************************/
/*                                                             */
/*                      T I T U L O                            */
/*                                                             */
/***************************************************************/

    //Função retorna titulo da Tela/Programa
    public function title($prog)
    {
        $sql = "SELECT T07.T007_codigo  EstruturaCodigo
                     , T07.T007_desc    EstruturaDescricao
                     , T07.T007_nome    EstruturaNome
                     , T07.T007_titulo  EstruturaTitulo
                     , T07.T007_pai     EstruturaPai
                  FROM T007_estrutura T07 
                 WHERE T07.T007_codigo  =$prog";
        
       $title=$this->query($sql)->fetchAll(PDO::FETCH_ASSOC);
       return $title;
    }
    
/***************************************************************/
/*                                                             */
/*                    F I M    T I T U L O                     */
/*                                                             */
/***************************************************************/   
/***************************************************************/
/*                                                             */
/*                    S U B T I T U L O                        */
/*                                                             */
/***************************************************************/

    //Gera $superArray para criar o subtitutlo
    public function subtitulo($cod)
    {
        $superArray = array ();
            $subTitulo = $this->query("SELECT T1.T007_codigo        COD
                                            , T1.T007_nome          NOM
                                            , T1.T007_pai           PAI
                                         FROM T007_estrutura        T1
                                        WHERE T1.T007_codigo= $cod");
            foreach($subTitulo  as  $campos=>$valores)
            {
                $superArray[$valores['COD']]    =   $valores;
                $this->subtitulo($valores['PAI']);
            }

    return ($superArray);

    }

/***************************************************************/
/*                                                             */
/*                    F I M    S U B T I T U L O               */
/*                                                             */
/***************************************************************/

    public function seleciona($tabela,$campos="*",$delimitador="",$quantidade)
    {
        $sql = false;
        if(!empty($tabela))
        {
            $sql = "SELECT ".$campos." FROM ".$tabela;
            if($delimitador!="")
            {
                $sql .= " WHERE ".$delimitador;
            }
        }
        
        if (!empty($quantidade))
            $sql    .=  " LIMIT $quantidade";
        
        return $sql;
    }

    public function insere($tabela,$campos)
    {
        $sql = false;
        if(!empty($tabela))
        {
            $sql = "INSERT INTO ".$tabela." (";
            foreach($campos as $nomes => $valores)
            {                
                $sql_aux1 .= $nomes. ",";
                $sql_aux2 .= $this->formataValor($tabela,$nomes,$valores). ",";
            }
            $sql_aux1 = substr($sql_aux1,0,strlen($sql_aux1)-1);
            $sql_aux2 = substr($sql_aux2,0,strlen($sql_aux2)-1);
//            echo $sql.$sql_aux1.") VALUES (".$sql_aux2.")";  
//            echo "<br/><br/><br/>";   
            return  $sql.$sql_aux1.") VALUES (".$sql_aux2.")";
        }
    }

    public function atualiza($tabela,$campos,$delimitador)
    {
        $sql = false;
        if(!empty($tabela))
        {
            $sql = "UPDATE ".$tabela." SET ";
            foreach($campos as $nomes => $valores)
            {
                $sql_aux .= $nomes." = ".$this->formataValor($tabela,$nomes,$valores). ",";
            }
            $sql_aux = substr($sql_aux, 0, (strlen($sql_aux)-1));
//            echo  $sql.$sql_aux. " WHERE ".$delimitador;
//            echo "<br/>";
            return  $sql.$sql_aux. " WHERE ".$delimitador;
        }
    }

    public function exclui($tabela,$delimitador)
    {
        $sql = false;
        if(!empty($tabela))
        {
            $sql = "DELETE FROM ".$tabela. " WHERE ".$delimitador;
           // echo  $sql;
        }
        return $sql;
    }

    public function formataValor($tabela,$campo,$valor)
    {        
        if(strpos($campo,"senha") === 0)
        {
            return  "'".md5($valor)."'";

        }
        elseif($this->verificaTipo($tabela,$campo) == "VAR_STRING"
            || $this->verificaTipo($tabela,$campo) == "STRING"
            || $this->verificaTipo($tabela,$campo) == "TIME"
            || $this->verificaTipo($tabela,$campo) == "BLOB")
        {
            $valor  = str_replace("'", "`", $valor);
            return "'".$valor."'";
        }
        elseif($this->verificaTipo($tabela,$campo) == "DATE")
        {
            if(empty($valor))
                return "null";
            else
                return "'".$this->formataData($valor)."'";
        }
        elseif ($this->verificaTipo($tabela,$campo) == "DATETIME")
        {
            if(empty($valor))
                return "null";
            else
            {
            $valor      = explode(" ", $valor);
            $valor[0]   = $this->formataData($valor[0]);

            $valor      = "'".$valor[0]." ".$valor[1]."'";
            return $valor;
            }
        }
        elseif($this->verificaTipo($tabela,$campo) == "LONG")
        {
            $valor  = str_replace("R$", "", $valor);
            $valor  = trim($valor);
            $valor  = str_replace(".","",$valor);
            $valor  = str_replace(",",".",$valor);
            return $valor;
        }
        else
        {                       
            $valor  = str_replace("R$", "", $valor);
            $valor  = trim($valor);
            if (strstr($valor, ','))
            {
                $valor  = str_replace(".","",$valor);
                $valor  = str_replace(",",".",$valor);
            }
            return $valor;
        }
    }

    private function validaHora($tempo)
    {
       list($hora,$minuto) = explode(':',$tempo);

       if ($hora > -1 && $hora < 24 && $minuto > -1 && $minuto < 60)
       {
          return true;
       }
    }

    private function validaData($data)
    {
        $data = split("[-,/]", $data);
        if(!checkdate($data[1], $data[0], $data[2]) and !checkdate($data[1], $data[2], $data[0]))
        {
            return false;
        }
        return true;
    }

    public function formataData($data)
    {
        
        if(empty($data))
        {
            $data   =   "null";
            return $data;
            
        }
            
        if($this->validaData($data))
        {
            return implode(!strstr($data, '/') ? "/" : "-", array_reverse(explode(!strstr($data, '/') ? "-" : "/", $data)));
        }
    }
    
    //Formata data para as views sem Hora [Ex.: 01/10/2011]
    public function formataDataView($data)
    {
        $data = explode(" ",$data);
        if($this->validaData($data[0]))
        {
            return implode(!strstr($data[0], '/') ? "/" : "-", array_reverse(explode(!strstr($data[0], '/') ? "-" : "/", $data[0])));
        }
    }    

    private function verificaTipo($tabela,$campo)
    {
        if (array_key_exists($campo, $GLOBALS['arr'])){
                return $GLOBALS['arr'][$campo];}
        else
        {
            $coluna = $this->query($this->seleciona($tabela,$campo,false,1));
            if($coluna!==false)
            {            
                $resultado = $coluna->getColumnMeta(0);
                $GLOBALS['arr'][$campo]   =   $resultado["native_type"];
                return $resultado["native_type"];
            }
        }
    }

    public function retiraMascara($valor)
    {
        $valor  = str_replace('/', "", $valor);
        $valor  = str_replace('_', "", $valor);
        $valor  = str_replace('-', "", $valor);
        $valor  = str_replace('|', "", $valor);
        $valor  = str_replace('.', "", $valor);
        $valor  = str_replace(',', "", $valor);
        $valor  = str_replace(':', "", $valor);
        $valor  = str_replace(':', "", $valor);
        $valor  =   trim($valor);

        return $valor;
    }

    public function preencheZero($posicao,$qtd,$valor)
    {
        //Preenche com Zero a Esquerda
        if ($posicao=="E")
            return $valor  =   str_pad($valor, $qtd, "0", STR_PAD_LEFT);
        //Preenche com Zero a Direita
        if ($posicao=="D")
            return $valor  =   str_pad($valor,$qtd, "0", STR_PAD_RIGHT);
        //Prenche com Zero Ambos
        if(empty($posicao))
            return $valor  =   str_pad($valor,$qtd, "0", STR_PAD_BOTH);

    }

    public function array_reverso($array)
    {
        $array = array_reverse($array);
        ksort($array);
        return($array);
    }

    public function selecionaPerfil($user)
    {
        return $this->query("SELECT T009_codigo     COD
                               FROM T004_T009
                              WHERE T004_login  = '$user'");
    }

    public function FormataCGCxCPF($cgc)
    {

     $cpf      = ltrim($cgc, "0");
     $Array    = str_split($cpf);
     $Array2   = str_split($cgc);
     $i        = count($Array);
     if ($i < 12)
     {
      $cgc      =  $Array[0].$Array[1].$Array[2].".".$Array[3].$Array[4]
                  .$Array[5].".".$Array[6].$Array[7].$Array[8]."-".$Array[9]
                  .$Array[10];
     }
     else
     {
      $cgc      = $Array2[0].$Array2[1].".".$Array2[2].$Array2[3].$Array2[4]
                  .".".$Array2[5].$Array2[6].$Array2[7]."/".$Array2[8].$Array2[9]
                  .$Array2[10].$Array2[11]."-".$Array2[12].$Array2[13];
     }

    return $cgc;
    } 
    
    public function SepararExtensao($arquivo)
    {
     if (substr($arquivo,(strlen($arquivo)-4),1) == ".")
        {    
         $extensao = substr($arquivo,(strlen($arquivo)-3),3);
        }
    if  (substr($arquivo,(strlen($arquivo)-5),1) == ".")
        {    
         $extensao = substr($arquivo,(strlen($arquivo)-4),4);
        }
     return $extensao;
    }
    
    public function SepararNome($arquivo)
    {
     if (substr($arquivo,(strlen($arquivo)-4),1) == ".")
        {    
         $nome_arquivo = substr($arquivo,0,strlen($arquivo)-4);
        }
     if (substr($arquivo,(strlen($arquivo)-5),1) == ".")
        {    
         $nome_arquivo = substr($arquivo,(strlen($arquivo)-4),4);
        }
     return $nome_arquivo; 
    }      

    public function retornaLojaUsuario($user)
    {
        $sql = "SELECT T04.T004_login   Login
                     , T06.T006_codigo  LojaCodigo
                     , T06.T006_nome    LojaNome
                  FROM T004_usuario T04
                  JOIN T006_loja T06 ON T04.T006_codigo = T06.T006_codigo
                 WHERE T04.T004_login = '$user'";
        
        $resultado = $this->query($sql);
        
        foreach($resultado as $campo=>$valor)
        {
            return $valor['LojaCodigo'];
        }                       
    }
    
    // Função é utilizada para formatar o dado encontrado por um autocomplete do jquery
    public function formataLoginAutoComplete($string)
    {
        // Formata a string de Strting para deixar apenas o login
        $arrayLogin = explode("-",$string);
        // Iguala o Login para a ultima posição após separar a string em traços ex: JORGE NOVA - JNOVA
        $login = trim($arrayLogin[1]);  
        
        return $login;        
    }

    // Função é utilizada para formatar o dado encontrado por um autocomplete do jquery
    public function retornaCodigoFornecedorAutoComplete($string)
    {
        // Formata a string de Strting para deixar apenas o nome
        $arrayFornecedor = explode("-",$string);
        // retorna a primeira posição após separar a string em traços ex: 138 - ENKEN
        $codigo          = trim($arrayFornecedor[0]);  
        
        return $codigo;        
    }
    
    // Retorna string de data para padrão MySQL
    public function retornaMySQLData($data)
    {
        $array_data = explode("/",$data);
        
        $data_nova  = $array_data[2]."-".$array_data[1]."-".$array_data[0];
        
        return $data_nova;
    }
    
   
    public function alerts($err, $titulo, $mensagem)
    {
        //Preenche variáveis para mensagem
            $_SESSION['alert']['err']       =   $err        ; //se erro (true/false)
            $_SESSION['alert']['titulo']    =   $titulo     ; //titulo mensagem
            $_SESSION['alert']['mensagem']  =   $mensagem   ; //corpo mensagem
            $_SESSION['alert']['true']      =   true;
    }
    
    public function gerarSenha() 
    {
        $length = 7;

        $characters = "0123456789abcdefghijklmnopqrstuvwxyz";

        $string = "";    

        for ($p = 0; $p < $length; $p++) 
        {
            $string .= $characters[mt_rand(0, strlen($characters))];
        }
        return $string;
    }

    
    public function insereAuditoria($numprog,$nomeprog,$ocorrencia)
    {
            // Formata a Data
            $data   =   date('d/m/Y H:i:s');
            
            // Prepara array para inserir na tabela de auditoria 
            $campos =   array   (   "T066_data"         => $data
                                ,   "T066_usu_login"    => $_SESSION['user']
                                ,   "T066_usu_nome"     => $_SESSION['DisplayNome']
                                ,   "T066_obj_codigo"   => $numprog
                                ,   "T066_obj_nome"     => $nomeprog
                                ,   "T066_ocorrencia"   => $ocorrencia
                                ,   "T066_address"      => $_SERVER['REMOTE_ADDR'] );
                        
            // Escolhe a tabela para inserir dados
            $tabela =   "T066_auditoria";
                       
            // Insere dados na tabela de auditoria
            return $inserir    =   $this->exec($this->insere($tabela, $campos));   
            
    }
    
    //Função monta link do arquivo
    public function linkArquivo($CategoriaCodigo,   $ArquivoCodigo, $Extensao)
    {
        $link   =   CAMINHO_ARQUIVOS."CAT".$this->preencheZero("E", 4, $CategoriaCodigo)."/".$this->preencheZero("E", 4, $ArquivoCodigo).".".$Extensao;
        
        return $link;
    }  
    
    //ToolTipo Fluxo WorkFlow
    public function fluxoWorkFlow($Codigo, $NumeroTabela)
    {
        $sql = "SELECT T".$NumeroTabela."60.T0".$NumeroTabela."_T060_ordem                                  Ordem
                     , T".$NumeroTabela."60.T0".$NumeroTabela."_T060_status                                 Status
                     , T60.T059_codigo                                                                      GrupoWkfCodigo
                     , T59.T059_nome                                                                        GrupoWkfNome
                     , date_format(T".$NumeroTabela."60.T0".$NumeroTabela."_T060_dt_aprovacao, '%d/%m/%Y')  DtAprovacao
                     , T".$NumeroTabela."60.T004_login                                                      Login
                  FROM T0".$NumeroTabela."_T060 AS T".$NumeroTabela."60
                  JOIN T060_workflow       T60 ON (T".$NumeroTabela."60.T060_codigo = T60.T060_codigo)
                  JOIN T059_grupo_workflow T59 ON T60.T061_codigo = T59.T061_codigo 
                                              AND T60.T059_codigo = T59.T059_codigo                        
                 WHERE T0".$NumeroTabela."_codigo = $Codigo
                 ORDER BY 1";
        
        return $this->query($sql);
    }    
        
    //Monta tabela ToolTip Fluxo WorkFlow
    public function tabelaToolTipFluxoWorkFlow($Codigo, $NumeroTabela)
    {
            $buscaFluxo = $this->fluxoWorkFlow($Codigo, $NumeroTabela);
            
            $AD =   '"';
            $htmlTooltip = "<table>";
            $htmlTooltip .= "<tr>";
            $htmlTooltip .=     "<td><b>Grupos:</b></td>";
            $htmlTooltip .=     "<td>&nbsp;&nbsp;</td>";
            $htmlTooltip .=     "<td><b>Status Aprovações:</b></td>";
            $htmlTooltip .= "</tr>";
            foreach($buscaFluxo as $campos=>$vlsFluxo)
            {
                $htmlTooltip .= "<tr>";
                $htmlTooltip .=     "<td>".$vlsFluxo['GrupoWkfCodigo'] = $this->preencheZero('E', 3, $vlsFluxo['GrupoWkfCodigo']). " - " .$vlsFluxo['GrupoWkfNome']."</td>";
                $htmlTooltip .=     "<td>&nbsp;&nbsp;</td>";
                if ($vlsFluxo["Status"] == 1)
                    $htmlTooltip .=     "<td><b>em:</b> ".$vlsFluxo["DtAprovacao"]."<b>&nbsp;&nbsp;por:</b> ".strtolower($vlsFluxo["Login"])."</td>";
                else
                    $htmlTooltip .=     "<td>Não Aprovado</td>";          

                $htmlTooltip .= "</tr>";
            }
            
            $htmlTooltip .="</table>";        
            
            return $htmlTooltip;
    }
    
    public function criaOptionCombo($Codigo, $Nome)
    {
        $html   =   "<option value='".$Codigo."'>".$this->preencheZero("E", 3, $Codigo)."-".$Nome."</option>";
        
        return $html;
    }

    /**************************************************************************
                    Intranet - DAVÓ SUPERMERCADOS
    * Criado em: 17/04/2012 por Rodrigo Alfieri
    * Descrição: esta função recebe um valor numérico e retorna uma 
    *           string contendo o valor de entrada por extenso
    * Entrada:  $valor (formato que a função number_format entenda :) 
    * Origens:  string com $valor por extenso 

    **************************************************************************
    */    

    function retornaValorPorExtenso($valor=0) {
        
            $singular = array(  "centavo"
                              , "real"
                              , "mil"
                              , "milhão"
                              , "bilhão"
                              , "trilhão"
                              , "quatrilhão"
                             );
            
            $plural = array(  "centavos"
                            , "reais"
                            , "mil"
                            , "milhões"
                            , "bilhões"
                            , "trilhões"
                            , "quatrilhões"
                           );

            $c = array(  ""
                       , "cem"
                       , "duzentos"
                       , "trezentos"
                       , "quatrocentos"
                       , "quinhentos"
                       , "seiscentos"
                       , "setecentos"
                       , "oitocentos"
                       , "novecentos"
                      );
            
            $d = array(  ""
                       , "dez"
                       , "vinte"
                       , "trinta"
                       , "quarenta"
                       , "cinquenta"
                       , "sessenta"
                       , "setenta"
                       , "oitenta"
                       , "noventa"
                      );
            
            $d10 = array(  "dez"
                         , "onze"
                         , "doze"
                         , "treze"
                         , "quatorze"
                         , "quinze"
                         , "dezesseis"
                         , "dezesete"
                         , "dezoito"
                         , "dezenove"
                        );
            
            $u = array(  ""
                       , "um"
                       , "dois"
                       , "três"
                       , "quatro"
                       , "cinco"
                       , "seis"
                       , "sete"
                       , "oito"
                       , "nove"
                      );

            $z=0;

            $valor = str_replace(".", "", $valor);
            $valor = str_replace(",", ".", $valor);
            
            $valor = number_format($valor, 2, ".", ".");
            $inteiro = explode(".", $valor);
            for($i=0;$i<count($inteiro);$i++)
                    for($ii=strlen($inteiro[$i]);$ii<3;$ii++)
                            $inteiro[$i] = "0".$inteiro[$i];

            // $fim identifica onde que deve se dar junção de centenas por "e" ou por "," ;)
            $fim = count($inteiro) - ($inteiro[count($inteiro)-1] > 0 ? 1 : 2);
            for ($i=0;$i<count($inteiro);$i++) 
            {
                $valor = $inteiro[$i];
                $rc = (($valor > 100) && ($valor < 200)) ? "cento" : $c[$valor[0]];
                $rd = ($valor[1] < 2) ? "" : $d[$valor[1]];
                $ru = ($valor > 0) ? (($valor[1] == 1) ? $d10[$valor[2]] : $u[$valor[2]]) : "";

                $r = $rc.(($rc && ($rd || $ru)) ? " e " : "").$rd.(($rd && $ru) ? " e " : "").$ru;
                $t = count($inteiro)-1-$i;
                $r .= $r ? " ".($valor > 1 ? $plural[$t] : $singular[$t]) : "";
                if ($valor == "000")$z++; elseif ($z > 0) $z--;
                if (($t==1) && ($z>0) && ($inteiro[0] > 0)) $r .= (($z>1) ? " de " : "").$plural[$t]; 
                if ($r) $rt = $rt . ((($i > 0) && ($i <= $fim) && ($inteiro[0] > 0) && ($z < 1)) ? ( ($i < $fim) ? ", " : " e ") : " ") . $r;
            }

            return($rt ? $rt : "zero");
    } 
    
    public function dateDiff($sDataInicial, $sDataFinal)
    {
        $sDataI = explode("-", $sDataInicial);
        $sDataF = explode("-", $sDataFinal);

        $nDataInicial = mktime(0, 0, 0, $sDataI[1], $sDataI[0], $sDataI[2]);
        $nDataFinal = mktime(0, 0, 0, $sDataF[1], $sDataF[0], $sDataF[2]);

        return ($nDataInicial > $nDataFinal) ?
            floor(($nDataInicial - $nDataFinal)/86400) : floor(($nDataFinal - $nDataInicial)/86400);
    }
    
    function calculaDigitoMod11($NumDado, $NumDig, $LimMult)
    {
        $Dado = $NumDado;
        for($n=1; $n<=$NumDig; $n++)
        {
            $Soma = 0;
            $Mult = 2;
            
            for($i=strlen($Dado) - 1; $i>=0; $i--)
            {
                $Soma += $Mult * intval(substr($Dado,$i,1));
                if(++$Mult > $LimMult) $Mult = 2;
            }
            
            $Dado .= strval(fmod(fmod(($Soma * 10), 11), 10));
        }
        return substr($Dado, strlen($Dado)-$NumDig);        
    } 
    
    public function retornaDataRMS ($data)
    {
        $arrayData      = explode("/", $data);   
        $ano    =   $arrayData[2];
        $mes    =   $arrayData[1];
        $dia    =   $arrayData[0];
        
        $data  =   $ano.$mes.$dia;
        
        return $data;
        
    }

    public function retornaHtmlComboLojas($loja, $user)
    {
        //retorna um combo com as lojas de acordo com o usuário logado
        $lojaUsuario    =   $this->retornaLojaUsuario($user);
        
        if ($lojaUsuario==0)
        {
            $sql    =   "  SELECT T06.T006_codigo   CodigoLoja
                                , T06.T006_nome     NomeLoja
                             FROM T006_loja T06
                            WHERE T06.T006_codigo NOT IN (0,999)";
            
            $option =   "<option value='0'></option>";
            
            $dados  =   $this->query($sql);
        }
        else
        {
            $sql    =   "SELECT T06.T006_codigo     CodigoLoja
                              , T06.T006_nome       NomeLoja
                           FROM T006_loja T06
                          WHERE T06.T006_codigo NOT IN (0,999)
                            AND T06.T006_codigo  = $lojaUsuario";
            
            $dados  =   $this->query($sql);            
        }
        
        $htmlComboLojas     =   "<label class='label'>Loja</label>";
        $htmlComboLojas    .=   "<select name='T006_codigo'>";
                              
        foreach($dados  as  $campos=>$valores)
        {           
            if ($valores['CodigoLoja'] == $loja)
                $selected   =   "selected";
            else
                $selected   =   "";
            
            $htmlComboLojas .=  "<option value='".$valores['CodigoLoja']."' $selected>".$this->preencheZero("E", 3, $valores['CodigoLoja'])."-".$valores['NomeLoja']."</option>";
        }
        
        $htmlComboLojas .=  "</select>";
            
        
        return $htmlComboLojas;
    }
    
    //Validar CPF
    function validaCPF($cpf)
    {	// Verifiva se o número digitado contém todos os digitos
        $cpf = str_pad(ereg_replace('[^0-9]', '', $cpf), 11, '0', STR_PAD_LEFT);

            // Verifica se nenhuma das sequências abaixo foi digitada, caso seja, retorna falso
        if (strlen($cpf) != 11 || $cpf == '00000000000' || $cpf == '11111111111' || $cpf == '22222222222' || $cpf == '33333333333' || $cpf == '44444444444' || $cpf == '55555555555' || $cpf == '66666666666' || $cpf == '77777777777' || $cpf == '88888888888' || $cpf == '99999999999')
            {
            return false;
        }
            else
            {   // Calcula os números para verificar se o CPF é verdadeiro
            for ($t = 9; $t < 11; $t++) {
                for ($d = 0, $c = 0; $c < $t; $c++) {
                    $d += $cpf{$c} * (($t + 1) - $c);
                }

                $d = ((10 * $d) % 11) % 10;

                if ($cpf{$c} != $d) {
                    return 0;
                }
            }

            return 1;
        }
    }  
    
    public function retornaQtdeRegistros($dados)
    {
        $qtde = 0;
        foreach ($dados as $cps => $vls)
        {
            $qtde++;
        }
        
        return $qtde;
        
    }
    // retorna 1 se o usuário pertence ao perfil 
    public function verificaPerfilUsuario($user, $perfil)
    {
     
        $sql = "   SELECT COUNT(*) 
                     FROM T004_T009 T0409
                    WHERE T0409.T004_login   =  '$user'
                      AND T0409.T009_codigo  IN ($perfil) ";
        
        $result =   $this->query($sql)->fetchAll(PDO::FETCH_COLUMN);
        
        return $result[0];
        
    }
    
    public function comboHora()
    {
        $html   =   "<option>00:00</option>";
        $html  .=   "<option>00:30</option>";
        $html  .=   "<option>01:00</option>";
        $html  .=   "<option>01:30</option>";
        $html  .=   "<option>02:00</option>";
        $html  .=   "<option>02:30</option>";
        $html  .=   "<option>03:00</option>";
        $html  .=   "<option>03:30</option>";
        $html  .=   "<option>04:00</option>";
        $html  .=   "<option>04:30</option>";
        $html  .=   "<option>05:00</option>";
        $html  .=   "<option>05:30</option>";
        $html  .=   "<option>06:00</option>";
        $html  .=   "<option>06:30</option>";
        $html  .=   "<option>07:00</option>";
        $html  .=   "<option>07:30</option>";
        $html  .=   "<option>08:00</option>";
        $html  .=   "<option>08:30</option>";
        $html  .=   "<option>09:00</option>";
        $html  .=   "<option>09:30</option>";
        $html  .=   "<option>10:00</option>";
        $html  .=   "<option>10:30</option>";
        $html  .=   "<option>11:00</option>";
        $html  .=   "<option>11:30</option>";
        $html  .=   "<option>12:00</option>";
        $html  .=   "<option>12:30</option>";
        $html  .=   "<option>13:00</option>";
        $html  .=   "<option>13:30</option>";
        $html  .=   "<option>14:00</option>";
        $html  .=   "<option>14:30</option>";
        $html  .=   "<option>15:00</option>";
        $html  .=   "<option>15:30</option>";
        $html  .=   "<option>16:00</option>";
        $html  .=   "<option>16:30</option>";
        $html  .=   "<option>17:00</option>";
        $html  .=   "<option>17:30</option>";
        $html  .=   "<option>18:00</option>";
        $html  .=   "<option>18:30</option>";
        $html  .=   "<option>19:00</option>";
        $html  .=   "<option>19:30</option>";
        $html  .=   "<option>20:00</option>";
        $html  .=   "<option>20:30</option>";
        $html  .=   "<option>21:00</option>";
        $html  .=   "<option>21:30</option>";
        $html  .=   "<option>22:00</option>";
        $html  .=   "<option>22:30</option>";
        $html  .=   "<option>23:00</option>";
        $html  .=   "<option>23:30</option>";
        
        echo $html;
    }    
    
    public function retornaFormatoDataHora($data)
    {
        $arrData    =   explode(" ",$data);
        $data       =   $arrData[0];
        $hora       =   $arrData[1];
        
        $strDataHora=   $this->formataDataView($data)." ".$hora;
        
        return $strDataHora;
        
    }
    
    public function formataMoeda($valor)
    {
        return $valor  =   'R$ ' . number_format($valor, 2, ',', '.'); // retorna R$100.000,50
    }   
    
    public function uploadArquivo($path)
    {       
            if(!(isset($_POST['submit']))){exit;}        
            if($_FILES["file"]["size"] > 99999999){exit;}
            $err=$_FILES["file"]["error"];
            $message='<div style="margin:5px; color:red;">Upload falhou! ';
            if ($err > 0){
                       switch($err){
                                     case '1':
                                               $message.='php.ini max file size exceeded.';
                                               break;
                                     case '2':
                                               $message.='tamanho máximo excedido.';
                                               break;
                                     case '3':
                                               $message.='file upload was only partial.';
                                               break;
                                     case '4':
                                               $message.='no file was attached.';
                                               break;
                                     case '7':
                                               $message.='permissão negada.';
                                               break;
                                     default :
                                               $message.='Unexpected error occers.';}
                                     $message.='</div>';
            }
            else{
                       if (file_exists($path.$_FILES["file"]["name"])){
                                     $message.='arquivo ja existe.</div>';}
                       else{
                                     @move_uploaded_file($_FILES["file"]["tmp_name"],$path.$_FILES["file"]["name"]);
                                     $message='<div style="margin:5px; color:green;">Upload realizado com sucesso!</div>';}
            }
            
            return $message;
    } 
    
    public function retornaExtensaoArquivo($extensao)
    {
       return $this->query(" SELECT T57.T057_codigo codifoExtensao
                                  , T57.T057_nome   nomeExtensao
                                  , T57.T057_desc   descricaoExtensao
                               FROM T057_extensao   T57
                              WHERE T57.T057_nome = '$extensao'");
    }       
    
}
?>
