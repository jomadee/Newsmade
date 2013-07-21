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
?>

<div class="boxCenter">

	<?php
	$navegador = new navigi();
	$navegador->tabela = $llTable.'_colunas';
	$navegador->query = 'select * from ' . $navegador->tabela . ' order by nome asc';
	$navegador->exibicao = 'lista';
	$navegador->config = array('link' => $llAppHome . '&p=colunas&id=');
    $navegador->delete = TRUE;
	$navegador->monta();
	?>
	
	<span class="botao">
		<a href="<?php echo $llAppOnServer, '&ac=add';?>">Adicionar</a>
	</span>

</div>

<?php if(isset($_GET['id'])){?>
    <script>
        $(function (){
            $().jfbox({
                carrega: '<?php echo $llAppOnServer, '&ac=coluna&id=', $_GET['id'];?>',
                width: 500,
                height: 145,
                fermi: navigi_start
            });
        });
    </script>
<?php };?>
