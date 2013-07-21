<?php
/**
*
* Newsmade | lliure 4.10
*
* @Vers�o 3.1
* @Desenvolvedor Jeison Frasson <jomadee@lliure.com.br>
* @Entre em contato com o desenvolvedor <jomadee@lliure.com.br> http://www.lliure.com.br/
* @Licen�a http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
require_once("../../etc/bdconf.php"); 
require_once("../../includes/jf.funcoes.php"); 

$opt = array_keys($_GET);

switch($opt['0']){
	case 'post':
		jf_delete(PREFIXO.'newsmade_postagens', array('id' => $_GET['post']));
		
		$_SESSION['aviso'] = array('Postagem excluida com sucesso!', 1);
		header('location: ../../index.php?plugin=newsmade&p=blog');
	break;
	
	case 'news':
		jf_delete(PREFIXO.'newsmade_newsletter', array('id' => $_GET['news']));
		
		$_SESSION['aviso'] = array('Newsletter excluida com sucesso!', 1);
		header('location: ../../index.php?plugin=newsmade&p=newsletter');
	break;

}
?>
