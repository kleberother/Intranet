<?php
/**************************************************************************/
/*                          DAVÓ SUPERMERCADOS                            */
/* Criado em: 15/03/2011 por Rodrigo Alfieri     teste teste te           */
/* Descrição: Arquivo de configurações e definições do sistema            */
/**************************************************************************/
  
/* Habilitar de 0 para 1 para exibir erros do PHP                 */
ini_set("display_errors",0);    

/* Inicializa characters com UTF-8 */
ini_set('default_charset','UTF-8');

/* Definir header depois de fazer um print          */
ob_start();

/* Configuração de DATA             */
date_default_timezone_set('America/Sao_Paulo');

/* Configuração de LOCAL     */
setlocale(LC_ALL, 'pt_BR', 'ptb', 'pt_BR.utf-8', 'br');

header ('Content-type: text/html; charset=UTF-8');

/* Nome do Sistema                      */
define("NOME_SISTEMA","INTRANET, Quem acessa, conhece!");

/* Constantes de Ambiente (Produção, Teste e Extranet)*/
define("SERVER_QAS","10.2.1.141");
define("SERVER_PRD","10.2.1.41");
define("EXTRANET_HOST","172.17.0.3");

/* Definições para AD */
define("DOMINIO_AD","grupodavo.davo.com.br");
define("HOST_AD","ldap://grupodavo.davo.com.br");
define("DN_AD","dc=grupodavo,dc=davo,dc=com,dc=br");

/* Caminho                                             */
define("CAMINHO_FISICO", dirname(getcwd()));

/* Caminho para Gravação de Arquivos Físicos no S.O.   */
define("CAMINHO_ARQUIVOS", "/Dados/files/");

/* Caminho arquivo de conexão com os BDs (MySQL, SQL Server, Oracle)*/
if ($_SERVER['SERVER_NAME']=='localhost')
    define("CONEXOES","databases.conf");
else
    define("CONEXOES","/Dados/connection/databases.conf");

/* Router Atual                                        */
$router     =   explode("/",$_SERVER['QUERY_STRING']);
define("ROUTER", "?".$router[0]."/");

/*Programa Atual*/
$programa   =   explode("=",$router[0]);
define("PROGRAMA",$programa[1]);

/*Array Global para datatype (tipo de campo das tabelas)*/
$arr    =   array();

/* Include de arquivo de Conexões com os BDs*/
require_once(CONEXOES);

//abre sessões
session_start();

?>