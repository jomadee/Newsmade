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

function url_disponivel($url, $id, $num = null){
	
	if(!empty($num)){
		$url_new = $url.'-'.$num;
		$num++;
	} else {
		$url_new = $url;
		$num = 2;
	}
	
	$consulta = mysql_query('select * from '.PREFIXO.'newsmade_postagens where url = "'.$url_new.'" and id != "'.$id.'" limit 1');
	
	if(mysql_num_rows($consulta) > 0)
		return url_disponivel($url, $id, $num);
	else
		return $url_new;
}

switch(isset($_GET['ac']) ? $_GET['ac'] : 'home' ){
	case 'home':
		$consulta = "select * from ".PREFIXO."newsmade_postagens order by id desc ";
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
					<li><a href="<?php echo $llPasta.'blog.php?ac=criar'?>"><img src="<?php echo $_ll['tema']['icones'];?>/lightbulb.png"> Postar</a></li>
					<li><a href="<?php echo $llHome.'&amp;p=blog'?>"><img src="<?php echo $_ll['tema']['icones'];?>list_num.png"> Listar postagens</a></li>
					<li><a href="<?php echo $llHome.'&amp;p=comentarios'?>"><img src="<?php echo $_ll['tema']['icones'];?>/spechbubble_2.png"> Comentários</a></li>
				</ul>
			</div>
			
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
					
					<td class="ico"><a href="<?php echo $llPasta.'del.php?post='.$dados['id']?>" title="excluir" class="excluir"><img src="<?php echo $_ll['tema']['icones'];?>/trash.png" alt="excluir"/></a></td>
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
		
	case 'criar':
		require_once("../../etc/bdconf.php");
		require_once("../../includes/jf.funcoes.php"); 

		$_POST['data'] = time();
		$_POST['data_up'] = $_POST['data'];
		$_POST['user'] = $_SESSION['logado']['id'];
		
		jf_insert(PREFIXO.'newsmade_postagens', $_POST);
		
		header('location: ../../index.php?app=newsmade&p=blog&ac=editar&id='.$jf_ultimo_id);
		break;
		
	case 'alterar':
		require_once("../../etc/bdconf.php");
		require_once("../../includes/jf.funcoes.php"); 

		$id = $_GET['id'];

		$_POST['data_up'] = time();
		
		switch (jf_form_actions('salvar', 'public')){
			case 'salvar':

				break;

			case 'public':
				$_POST['publicar'] = 1;				
				break;		
		}

		$retorno = '../../index.php?app=newsmade&p=blog&ac=editar&id='.$id;

		jf_update(PREFIXO.'newsmade_postagens', $_POST, array('id' => $id));

		$_SESSION['aviso'] = array('Alteração realizada com sucesso!', 1);

		header('location: '.$retorno);
		break;
		
	case 'editar':
		$consulta = "select * from ".PREFIXO."newsmade_postagens where id =".jf_anti_injection($_GET['id']);
		$dados = mysql_fetch_assoc(mysql_query($consulta));
		
		$consulta = "select id, nome from " . PREFIXO . "newsmade_colunas ORDER BY nome";
		$consulta = mysql_query($consulta);
        
		$colunas['null'] = 'Sem coluna';
		while($coluna = mysql_fetch_assoc($consulta))
			$colunas[$coluna['id']] = $coluna['nome'];

		?>
		<div class="contBlog">
			<div class="menuBlog">
				<?php
				if(!empty($_GET['id'])){
					?>
					<ul>
						<li class="top">Coluna</li>
						<li><a class='midasBox' href="<?php echo $llPasta."ajax.gen_midias.php?notic=".$_GET['id']?>"><img src="<?php echo $_ll['tema']['icones'];?>/picture.png"> Mídias</a></li>
						<?php /*<li><a class='jfbox' href="<?php echo $llPasta."ajax.referencias.php?notic=".$_GET['id']?>"><img src=<?php echo $_ll['tema']['icones'];?"/globe_2.png"> Referências</a></li> */?>
					</ul>

					<div class="topicos">
						<div class="padding">	
							<span class="titulo">Tópicos</span>
						
							<div id="relacionados"></div>
							
							<form id="topicosForm" action="<?php echo 'app/newsmade/ajax.topicos.php?id='.$_GET['id']?>" >
								<input type="text" name="topico" autocomplete="off" id="pesquisa"/>
								<div id="sugestao"></div>
								<span class="botao"><button type="submit">Adicionar</button></span>
							</form>
							<div class="both"></div>
						</div>
					</div>
					<?php
				} else {
					?>
					<span class="explic">Após salvar sua postagem, será liberado o acesso para adicionar citações, fotos e vídeos. <br><br> Clique no botão <strong>Salvar e continuar editando</strong> para salvar e continuar nesta mesma página.</span>
					<?php
				}
				?>
			</div>
			
			<div class="limitBlog">
				<form method="post" class="form" id="formBlog" action="<?php echo $llPasta.'blog.php?ac=alterar&id='.$_GET['id']; ?>">
				
					<div class="controles">

						<div class="categoira">
							<div class="padding">
								<span class="titulo">Coluna</span>
								<select name="coluna">
								<?php
								foreach($colunas as $chave => $dado)
									echo '<option value="' . $chave . '"' . ($dados['coluna'] == $chave? 'selected="selected"': '') . '>' . $dado . '</option>';
								?>
								</select>
							</div>
						</div>
						
						
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
						
						$.post('<?php echo $llPasta.'blog.php?ac=gera_url&id='.$dados['id']; ?>', titulo, function(url){
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
                
				$('#relacionados').load('<?php echo 'app/newsmade/ajax.topicos.php?id='.$dados['id'];?>');
				$('#pesquisa').keydown(function (event){
                    
                    if ($('#sugestao').css('display') == 'block' && (event.keyCode == 38 || event.keyCode == 40 || event.keyCode == 27)){
                    
                        var lista = $('#sugestao a');
                        var total = lista.length;
                        var cele = null;
                        lista.each(function (index, unid){
                            if ($(unid).hasClass('cele')){
                                cele = index;
                            }
                            $(unid).removeClass('cele');
                        });
                    
                        //Apertou para cima
                        if (event.keyCode == 38){
                            if(cele !== null && (cele - 1) >= 0){
                                lista.eq(cele - 1).addClass('cele');
                            }else{
                                lista.eq(total - 1).addClass('cele');
                            }
                        }
                    
                        //apertou para baixo
                        if (event.keyCode == 40){
                            if(cele !== null && (cele + 1) < total){
                                lista.eq(cele + 1).addClass('cele');
                            }else{
                                lista.eq(0).addClass('cele');
                            }
                        }
                        
                        if(event.keyCode == 27){
                            event.isPropagationStopped();
        					$('#sugestao').fadeOut(500, function (){$(this).html('')});
                        }
                        
                    }
                
                }).keyup(function(event){
                    
					if(event.keyCode != 13 && event.keyCode != 32 && event.keyCode != 38 && event.keyCode != 40 && event.keyCode != 27){
                
						var termo = new Array();
						
						termo = $(this).val().split(',').reverse();
						termo = termo[0].replace(/^\s+|\s+$/g,"").replace(/ /gi, '+');
						
                        visible = false;
						if(termo.length > 2 && termo != ''){
							$('#sugestao').load("app/newsmade/ajax.topicos.php?ac=consult&pesquisa="+termo, function(){
                                if(visible)
                                    $('#sugestao').fadeIn(500);
                                else
                                    $('#sugestao').hide().html('');
							});
                        }else
                            $('#sugestao').hide().html('');
					}
				});
			});
			
			$('#topicosForm').submit(function(event){
            
                if ($('#sugestao').css('display') == 'block' && $('#sugestao a.cele').length > 0){
                    
                    var termo = $('#pesquisa').val().split(',');
                    termo.pop();

                    termo = termo.toString();

                    $('#pesquisa').val((termo == '' ? termo : termo+', ')+$('#sugestao a.cele').attr('rel')+', ').focus();
                    $('#sugestao').hide().html('');
                    
                }else{
                    var campos =  $(this).serializeArray();

                    $('#relacionados').load('app/newsmade/ajax.topicos.php?id=<?php echo $_GET['id']?>', campos, function(){
                        $('#pesquisa').val(''); 
                        $('#sugestao').hide().html('');
                    });
                }
				
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
		
	case 'gera_url':
		header("Content-Type: text/html; charset=ISO-8859-1",true);
		require_once("../../etc/bdconf.php");
		require_once("../../includes/jf.funcoes.php"); 

		$consulta = "select * from ".PREFIXO."newsmade_postagens where id =".jf_anti_injection($_GET['id']);
		$dados = mysql_fetch_assoc(mysql_query($consulta));
		
		if($dados['publicar'] == 1)
			break;
		
		
		$_POST['titulo'] = trim(jf_iconv2($_POST['titulo']));
		
		$gravar['url'] = url_disponivel(jf_urlformat(str_replace('/', ' ', $_POST['titulo'])), $dados['id']);
	
		if(empty($dados['titulo'])){
			$gravar['titulo'] = $_POST['titulo'];
			
			jf_update(PREFIXO.'newsmade_postagens', $gravar, array('id' => $_GET['id']));
		}

		echo $gravar['url'];		
		break;
}
?>
