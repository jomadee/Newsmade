<?php/**** Newsmade | lliure 5.x - 6.x** @Vers�o 4* @Pacote lliure* @Entre em contato com o desenvolvedor <lliure@lliure.com.br> http://www.lliure.com.br/* @Licen�a http://opensource.org/licenses/gpl-license.php GNU Public License**/header("Content-Type: text/html; charset=ISO-8859-1",true);require_once("../../etc/bdconf.php"); require_once("../../includes/jf.funcoes.php"); ?><h1>Gerenciar refer�ncias</h1><?phpif(isset($_GET['del'])){	jf_delete(PREFIXO.'newsmade_postagens_referencias', array('id' => $_GET['del']));}if(!empty($_POST)){	$_POST['idNoticia'] = $_GET['notic'];	jf_insert(PREFIXO.'newsmade_postagens_referencias', $_POST);}?><form class="form jfbox addnewsBox" method="post" action="<?php echo 'plugins/newsmade/ajax.referencias.php?notic='.$_GET['notic']?>" >	<div>		<label>T�tulo</label>		<input type="text" name="titulo" />	</div>		<div>		<label>Link</label>		<input type="text" name="link" />	</div>	<span class="botao"><button type="submit">Adicionar</button></span></form><div class="noticiasBox">	<h2>Refer�ncias</h2>	<table class="table">		<tr>			<th></th>			<th width="16px"></th>		</tr>		<?php		$sql = mysql_query('select * from '.PREFIXO.'newsmade_postagens_referencias where idNoticia = "'.$_GET['notic'].'" order by id desc');						while($dados = mysql_fetch_assoc($sql)){			?>			<tr>				<td><?php echo $dados['titulo']?></td>							<td><a href="<?php echo 'plugins/newsmade/ajax.referencias.php?notic='.$_GET['notic'].'&amp;del='.$dados['id']?>" class="jfbox"><img src="<?php echo $_ll['tema']['icones'];?>/trash.png" alt="excluir"/></a></td>			</tr>			<?php		}					?>	</table></div>