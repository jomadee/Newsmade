<?php/**** Newsmade | lliure 5** @Vers�o 4.0* @Desenvolvedor Jeison Frasson <jomadee@lliure.com.br>* @Colaborador Rodrigo Dechen <mestri.rodrigo@gmail.com>* @Entre em contato com o desenvolvedor <jomadee@lliure.com.br> http://www.lliure.com.br/* @Licen�a http://opensource.org/licenses/gpl-license.php GNU Public License**/header("Content-Type: text/html; charset=ISO-8859-1",true);require_once("../../etc/bdconf.php"); require_once("../../includes/jf.funcoes.php"); ?><h1>Gerenciar not�cias</h1><?phpif(!empty($_POST)){	$_POST =  jf_iconv('UTF-8', 'ISO-8859-1', $_POST);		if(!isset($_POST['postagem'])){		$dados = mysql_fetch_assoc(mysql_query('select titulo from '.PREFIXO.'newsmade_postagens where id = "'.$_POST['noticia'].'" limit 1'));		?>		<span class="titNot"><?php echo $dados['titulo']?></span>		<form class="form jfbox addnewsBox" method="post" action="<?php echo 'app/newsmade/ajax.addnews.php?news='.$_GET['news']?>" >			<input type="hidden" name="postagem" value="<?php echo $_POST['noticia']?>">			<input type="hidden" name="titulo" value="<?php echo $dados['titulo']?>">			<div>				<label>Marque at� quatro fotos</label>				<?php								$consulta = mysql_query('select a.foto, a.id, b.idPostagem 					from '.PREFIXO.'newsmade_albuns_fotos as a										left join '.PREFIXO.'newsmade_postagens_albuns as b					on b.idAlbum = a.album										where b.idPostagem = "'.$_POST['noticia'].'"					');				while($dados = mysql_fetch_assoc($consulta)){					?>					<div class="fotos">						<img src="includes/thumb.php?i=../../uploads/album/<?php echo $dados['foto']?>:58:70:c" class="img" />						<input type="checkbox" name="cor[]" value="<?php echo $dados['id']?>"/>					</div>					<?php				}				?>			</div>						<div class="both">				<span class="botao"><a href="<?php echo 'app/newsmade/ajax.addnews.php?news='.$_GET['news']?>" class="jfbox">Voltar</a></span>				<span class="botao"><button type="submit">Adcionar</button></span>			</div>		</form>		<?php	} else {		$dados['idNews'] = $_GET['news'];		$dados['idNoticia'] = $_POST['postagem'];				if(isset($_POST['cor']))		foreach($_POST['cor'] as $chave => $valor){			$dados['foto'.$chave] = $valor;						if($chave > 2)			break;		}				jf_insert(PREFIXO.'newsmade_newsletter_noticias', $dados);		?>		<div class="sucesso">Not�cia adicionada com sucesso!</div>		<script type="text/javascript">			$(document).ready(function() {				$('#notNews').prepend('<span id="notNew<?php echo $ml_ultmo_id?>"><?php echo $_POST['titulo']?></span>');				setTimeout("carregaJfbox('<?php echo 'app/newsmade/ajax.addnews.php?news='.$_GET['news']?>')", 1000);			});		</script>		<?php	}	} else {	if(isset($_GET['del'])){		jf_delete(PREFIXO.'newsmade_newsletter_noticias', array('id' => $_GET['del']));		?>		<script type="text/javascript">		$(document).ready(function() {			$('#notNew<?php echo $_GET['del']?>').css('display', 'none');						mLaviso('Not�cia excluida da newsletter com sucesso');					});		</script>		<?php			}		$sql = 'select a.id, a.titulo 			from '.PREFIXO.'newsmade_postagens as a						left join '.PREFIXO.'newsmade_newsletter_noticias as b			on b.idNoticia = a.id						where b.id is NULL						order by a.id desc';	$consulta = mysql_query($sql);	?>		<form class="form jfbox addnewsBox" method="post" action="<?php echo 'app/newsmade/ajax.addnews.php?news='.$_GET['news']?>" >		<div>			<label>Adcionar uma not�cia</label>			<select name="noticia">				<?php				while($dados = mysql_fetch_assoc($consulta)){					echo '<option value="'.$dados['id'].'">'.$dados['titulo'].'</option>';				}				?>			</select>		</div>		<span class="botao"><button type="submit">Adcionar</button></span>	</form>		<div class="noticiasBox">	<h2>Not�cias</h2>		<table class="table">			<tr>				<th></th>				<th width="16px"></th>			</tr>						<?php			$sql = mysql_query('select a.id, b.titulo 					from '.PREFIXO.'newsmade_newsletter_noticias as a										left join '.PREFIXO.'newsmade_postagens as b					on b.id = a.idNoticia										where a.idNews = "'.$_GET['news'].'"					order by a.id desc					');								while($dados = mysql_fetch_assoc($sql)){				?>				<tr>					<td><?php echo $dados['titulo']?></td>								<td><a href="<?php echo 'app/newsmade/ajax.addnews.php?news='.$_GET['news'].'&amp;del='.$dados['id']?>" class="jfbox"><img src="<?php echo $_ll['tema']['icones'];?>/trash.png" alt="excluir"/></a></td>				</tr>				<?php			}						?>		</table>	</div>	<?php}?>