<?php
/**
*
* Newsmade | lliure 5
*
* @Versão 4.0
* @Desenvolvedor Jeison Frasson <jomadee@lliure.com.br>
* @Colaborador Rodrigo Dechen <mestri.rodrigo@gmail.com>
* @Entre em contato com o desenvolvedor <jomadee@lliure.com.br> http://www.lliure.com.br/
* @Licença http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

require_once("../../etc/bdconf.php"); 
header("Content-Type: text/html; charset=ISO-8859-1", true);

$nome = "Novo album";
$executa = "INSERT INTO ".PREFIXO."newsmade_albuns (nome, data) values ('".$nome."', '".time()."')";

$query = mysql_query($executa);
?>
