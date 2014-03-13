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

switch(isset($_GET['ac']) ? $_GET['ac'] : 'home' ){
	case 'home':
		$consulta = 'select * from '.PREFIXO.'newsmade_postagens where blog '.($_GET['blog'] != 'default' ? '= "'.$_GET['blog'].'"' : 'is NULL').' order by id desc';
		
		$query = mysql_query($consulta);
		$tr = mysql_num_rows($query); 

		$total_reg = "10";

		if (!isset($_GET['pagina'])) {
			$pc = "1";
		} else {
			$pc = $_GET['pagina'];
		} 
		
		$inicio = $pc - 1;
		$inicio = $inicio * $total_reg; 
				
		$tp = ceil($tr / $total_reg); 
		
		$limite = mysql_query($consulta." LIMIT $inicio,$total_reg ");
		?>

		<div class="contBlog">
			<div class="menuBlog">
				<ul>
					<li class="top">Opções do blog</li>
					<li><a href="<?php echo $_ll['app']['onserver'].'&ac=b_criar&blog='.$_GET['blog']; ?>"><img src="<?php echo $_ll['tema']['icones'];?>/lightbulb.png"> Postar</a></li>
					<li><a href="<?php echo $_ll['app']['home'].'&amp;p=blog'?>"><img src="<?php echo $_ll['tema']['icones'];?>list_num.png"> Listar postagens</a></li>
					<li><a href="<?php echo $_ll['app']['home'].'&amp;p=comentarios'?>"><img src="<?php echo $_ll['tema']['icones'];?>/spechbubble_2.png"> Comentários</a></li>
					<?php
					if(ll_tsecuryt('admin'))
						echo '<li><a href="'.$_ll['app']['home'].'&amp;p=g_blogs"><img src="'.$_ll['tema']['icones'].'/layers_1.png"> Gerenciar blogs</a></li>';
					?>
				</ul>
			</div>
			
			<?php
			$query = mysql_query('select * from '.PREFIXO.'newsmade_blogs');
			while($dados = mysql_fetch_assoc($query)){
				$abas[$dados['id']] = $dados['nome'];
			}
			
			if(!empty($abas)){
				echo '<div class="abas">';
					foreach($abas as $key => $valor){
						echo '<span class="aba'.($_GET['blog'] == $key ?  ' ativo' : '').'"><a href="'.$_ll['app']['home'].'&blog='.$key.'">'.$valor.'</a></span>';
					}
					
					$default = @mysql_result(mysql_query('select id from '.PREFIXO.'newsmade_postagens where blog is NULL limit 1'));
					
					if(!empty($default))
						echo '<span class="aba'.($_GET['blog'] == 'default' ?  ' ativo' : '').'"><a href="'.$_ll['app']['home'].'&blog=default">Default</a></span>';
						
				echo '</div>';
			}
			?>
			
			<table class="table">
				<tr>
					<th>Postagem</th>		
					<th class="ico"></th>		
					<th class="ico"></th>		
				</tr>
			<?php
			$i = 1;
			while($dados = mysql_fetch_assoc($limite)){
				$alterna = ($i%2?'0':'1');
				?>
				<tr class="alterna<?php echo $alterna?>">
					<td><a href="<?php echo $llHome?>&amp;p=blog&amp;ac=editar&amp;id=<?php echo $dados['id'].(isset($_GET['pagina'])?'&amp;pagina='.$_GET['pagina']:'')?>"><?php echo ($dados['publicar'] == "0" ? '<strong>[rascunho]</strong> ' : '').$dados['titulo']; ?><a/></td>
					
					<td class="ico"><a href="<?php echo $llHome?>&amp;p=blog&amp;ac=editar&amp;id=<?php echo $dados['id']; ?>"><img src="<?php echo $_ll['tema']['icones'];?>/doc_edit.png" alt="editar"/></a></td>
					
					<td class="ico"><a href="<?php echo $_ll['app']['onserver'].'&ac=b_del&post='.$dados['id'].'&blog='.$_GET['blog']; ?>" title="excluir" class="excluir"><img src="<?php echo $_ll['tema']['icones'];?>/trash.png" alt="excluir"/></a></td>
				</tr>
				<?php		
				$i++;
			}
			?>
			</table>

			<div class="paginacao">
				<?php
				$anterior = $pc -1;
				$proximo = $pc +1;
				
				$url = "?app=newsmade&amp;p=blog";
				
				if($tp > 1){
					$tm = 3;
					
					$ini = $pc-$tm;
					if($ini < 1){
						$ini = 1;
					}

					$ult = $pc+$tm;
					if($ult > $tp){
						$ult = $tp;
					}
				
					for($i = $ini; $i <= $ult; $i++){
						echo ($i > 1?'<span>|</span>':'');
						echo "<span><a href='".$url."&amp;pagina=".$i."'".($i == $pc?"class='atual'":"").">".$i."</a></span>";
					}
				}
				?>
			</div>
		</div>
		
		<script type="text/javascript">
			$(function() {
				$('.excluir').click(function() {
					return confirmAlgo('essa postagem');
				});
				
				<?php
				if($tr < 1){
					echo 'jfAlert("Nenhuma postagem encontrada");';
				}
				?>
			});
		</script>
		
		<?php		
		break;
		
	case 'editar':
		$consulta = 'select * from '.PREFIXO.'newsmade_postagens where id ="'.jf_anti_injection($_GET['id']).'" limit 1';
		
		$dados = mysql_fetch_assoc(mysql_query($consulta));

		?>
		<div class="contBlog">
			<div class="menuBlog postInter">
				<ul>
					<li class="top">Gerenciar</li>
					<li><a class='midasBox' href="<?php echo $_ll['app']['sen_html']."&p=ajax.gen_midias&notic=".$_GET['id']?>"><img src="<?php echo $_ll['tema']['icones'];?>/picture.png"> Mídias</a></li>
					<?php /*<li><a class='jfbox' href="<?php echo $_ll['app']['pasta']."ajax.referencias.php?notic=".$_GET['id']?>"><img src=<?php echo $_ll['tema']['icones'];?"/globe_2.png"> Referências</a></li> */?>
				</ul>

				<div class="topicos">
					<div class="padding">	
						<span class="titulo">Tópicos</span>
					
						<div id="relacionados"></div>
						
						<form id="topicosForm" action="<?php echo $_ll['app']['pasta'].'ajax.topicos.php?id='.$_GET['id']?>" >
							<input type="text" name="topico" autocomplete="off" id="pesquisa"/>
							<div id="sugestao"></div>						
							<span class="botao"><button type="submit">Adicionar</button></span>
						</form>	
						
						
						<div class="both"></div>
					</div>
				</div>
			</div>
			
			<div class="limitBlog">
				<form method="post" class="form" id="formBlog" action="<?php echo $_ll['app']['onserver'].'&ac=b_alterar&id='.$_GET['id']; ?>">
				
					<div class="controles">
						<?php 
						
						$botao_alterar = ($dados['publicar'] == 0 ? 'Salvar rascunho' : 'Salvar');
						
						echo '<span class="botao"><button type="submit" name="salvar">'.$botao_alterar.'</button></span>';
						echo $dados['publicar'] == 0 
								? '<span class="botao public"><button type="submit" name="public">Publicar</button></span>' 
								: '<span class="atualizado">Atualizado em '.date('d/m/Y', $dados['data_up']).'</span>';
							
						?>
					</div>
					
					<fieldset>
						<div id="url_box" <?php echo empty($dados['titulo']) ? 'style="display: none;"' : '' ?> >
							<?php echo '<span class="fras">Endereço permanente da postagem: <span id="url">'.$dados['url'].'</span></span> <input name="url" value="'.$dados['url'].'">'; ?>
						</div>
						
						<div>
							<label>Título</label>
							<input type="text" id="titulo" value="<?php echo (isset($dados['titulo']) ? stripslashes($dados['titulo']) : ''); ?>" name="titulo" />
						</div>
					
						<div>
							<label>Subtítulo</label>
							<input type="text" value="<?php echo (isset($dados['subtitulo'])? stripslashes($dados['subtitulo']):'')?>" name="subtitulo" />
						</div>		
						
						<div>
							<label>Introdução</label>
							<textarea name="introducao" class="intro"><?php echo (isset($dados['introducao'])?stripslashes($dados['introducao']):'')?></textarea>
						</div>
						
						<div>
							<label>Texto</label>
							<textarea name="texto" class="texto"><?php echo (isset($dados['texto'])?stripslashes($dados['texto']):'')?></textarea>
						</div>
					</fieldset>
				</form>				
			</div>
		</div>
		
		<script type="text/javascript">
			$(function(){
				<?php
				if($dados['publicar'] == 0){
					?>
					$('#titulo').focusout(function(){
						var titulo = $(this).serializeArray();
						
						$.post('<?php echo $_ll['app']['onserver'].'&ac=b_gera_url&id='.$dados['id']; ?>', titulo, function(url){
							$('#url_box').show();
							$('#url').html(url);
							$('#url_box input').val(url);
						});
					});
					<?php
				}
				?>
				
				$(".jfbox").jfbox({width: 439, height: 400}); 
				$(".midasBox").jfbox({width: 439, height: 400, addClass: 'ajax-gen_midias'}); 
			
				$('#relacionados').load('<?php echo $_ll['app']['pasta'].'ajax.topicos.php?id='.$dados['id'];?>');
				$('#pesquisa').keyup(function(event){
					event.stopPropagation();
					
					if(event.keyCode != 13 && event.keyCode != 32){
						topico = false;
						$('#sugestao').hide();

						var termo = new Array();
						
						termo = $(this).val().split(',').reverse();
						termo = termo[0].replace(/^\s+|\s+$/g,"").replace(/ /gi, '+');
						
						if(termo.length > 2 && termo != '')
							$('#sugestao').load('<?php echo $_ll['app']['pasta'].'ajax.topicos.php?ac=consult&pesquisa='?>'+termo, function(){
								
								if(topico == true)
									$('#sugestao').stop(true, true).fadeIn(500);
							});	
					}
				});
			});
			
			$('#topicosForm').submit(function(){
				var campos =  $(this).serializeArray();
				
				$('#relacionados').load('<?php echo $_ll['app']['pasta'].'ajax.topicos.php?id='.$_GET['id']?>', campos, function(){
					$('#pesquisa').val(''); 
					$('#sugestao').hide();
				});
				
				return false;
			});
			
			tinyMCE.init({
				// General options
				mode : "textareas",
				theme : "lliure",
				width: '100%',

				plugins : "safari,pagebreak,style,layer,table,advhr,advimage,advlink,emotions,iespell,inlinepopups,preview,searchreplace,contextmenu,paste,directionality,fullscreen,noneditable,nonbreaking,xhtmlxtras,template,icode",

				// Theme options
				theme_advanced_buttons1 : "cut,copy,paste,|,formatselect,|,bold,italic,underline,strikethrough,|,bullist,numlist,|,forecolor,backcolor,|,link,|,code,removeformat,fullscreen",
			});
		</script>
		
		<?php
		break;
}
?>
