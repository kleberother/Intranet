<?php 

/**************************************************************************/
/*                          DAVÓ SUPERMERCADOS                            */
/* Criado em: 15/03/2011 por Rodrigo Alfieri                              */
/* Descrição: Arquivo de configurações e definições do sistema            */
/**************************************************************************/


/* Habilitar com 1 para exibir erros do PHP                 */
ini_set("display_errors",0);

/* Definir header depois de fazer um print          */
ob_start();

/* Configuração de DATA             */
date_default_timezone_set('America/Sao_Paulo');

/* Configuração de LOCAL     */
setlocale(LC_ALL, 'pt_BR', 'ptb', 'pt_BR.utf-8', 'br');

header ('Content-type: text/html; charset=utf-8');

/* Nome do Sistema                      */
define("NOME_SISTEMA","INTRANET, Quem acessa, conhece!");


/* Banco de dados Satélite/Intranet     */
define("HOST_BANCO","localhost");
define("BD_BANCO","satelite");
define("USER_BANCO","root");
define("PASS_BANCO","");

/* Banco de dados Oracle RMS            */
define("HOST_ORACLE","oraas005");
define("BD_ORACLE","davoprd");
define("USER_ORACLE","rms");
define("PASS_ORACLE",'rm$r35n2gr');
define("TNS_ORACLE","(DESCRIPTION =(ADDRESS=(PROTOCOL=TCP)(HOST=10.2.1.5)(PORT=1521)) (CONNECT_DATA=(SERVER=DEDICATED) (SERVICE_NAME=davoprd)))");


/* Banco de dados SQL Server            */
define("HOST_MSSQL","");
define("BD_MSSQL","");
define("USER_MSSQL","");
define("PASS_MSSQL","");

/* Definições para AD */
define("DOMINIO_AD","grupodavo.davo.com.br");
define("HOST_AD","ldap://grupodavo.davo.com.br");
define("DN_AD","dc=grupodavo,dc=davo,dc=com,dc=br");

/* Caminho                                             */
define("CAMINHO_FISICO", dirname(getcwd()));

//abre sessões
session_start();

?>