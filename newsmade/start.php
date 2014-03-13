<?php
/**
*
* Newsmade | lliure 5.x - 6.x
*
* @Versão 4
* @Desenvolvedor Jeison Frasson <jomadee@lliure.com.br>
* @Entre em contato com o desenvolvedor <jomadee@lliure.com.br> http://www.lliure.com.br/
* @Licença http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
require_once('sys/config.php');

$botoes = array(
	array('href' => $backReal, 'img' => $_ll['tema']['icones'].'br_prev.png', 'title' => $backNome),
	array('href' => $llHome.'&amp;p=blog', 'img' => $_ll['tema']['icones'].'spechbubble_sq_line.png', 'title' => 'Blog'),
	array('href' => $llHome.'&amp;p=midia', 'img' => $_ll['tema']['icones'].'photo.png', 'title' => 'Mídias')
);

echo app_bar('Newsmade', $botoes);

$pagina = 'blog';

if(isset($_GET['p']))
	if(file_exists($_ll['app']['pasta'].$_GET['p'].'.php'))
		$pagina = $_GET['p'];

require_once($pagina.'.php');
?>

