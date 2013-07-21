<?php
/**
*
* Newsmade | lliure 4.10
*
* @Versão 3.1
* @Desenvolvedor Jeison Frasson <jomadee@lliure.com.br>
* @Entre em contato com o desenvolvedor <jomadee@lliure.com.br> http://www.lliure.com.br/
* @Licença http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
require_once('sys/config.php');

$botoes = array(
	array('href' => $backReal, 'img' => $plgIcones.'br_prev.png', 'title' => $backNome),
	array('href' => $llHome.'&amp;p=blog', 'img' => $plgIcones.'spechbubble_sq_line.png', 'title' => 'Blog'),
	array('href' => $llHome.'&amp;p=midia', 'img' => $plgIcones.'photo.png', 'title' => 'Mídias'),
	array('href' => $llHome.'&amp;p=colunas', 'img' => $plgIcones.'list_bullets.png', 'title' => 'Colunas')
);

echo app_bar('Newsmade', $botoes);

$pagina = 'blog';
if(isset($_GET['p']))
	if(file_exists($llPasta.$_GET['p'].'.php'))
		$pagina = $_GET['p'];
    
require_once($pagina.'.php');
?>

