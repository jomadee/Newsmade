<?php
/**
*
* Newsmade | lliure 5
*
* @Versão 4.0
* @Desenvolvedor Jeison Frasson <jomadee@lliure.com.br>
* @Entre em contato com o desenvolvedor <jomadee@lliure.com.br> http://www.lliure.com.br/
* @Licença http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

$sql = '
    SELECT 
        a.*
    FROM
        '.$llTable.'_colunas a
    WHERE
        a.id="'.  jf_anti_injection($_GET['id']).'"
';
$dados = mysql_fetch_assoc(mysql_query($sql));
?>

<form class="form">
    <fieldset>
        <legend></legend>
        <div>
            <label>Nome</label>
            <input id="nome" type="text" name="coluna" value="<?php echo $dados['nome'] ?>" />
        </div>
        <div>
            <label>Url unica</label>
            <input id="url" type="text" name="url" value="<?php echo $dados['url'] ?>" disabled />
        </div>
    </fieldset>
</form>

<script type="text/javascript">
    $('#nome').keyup(function (event){
        
        var fechar = false;
        
        if (event.keyCode == 13 && event.which == 13){
            fechar = true;
        }
        
        $.getJSON('<?php echo 'onserver.php'.$llHome.'&ac=atualizanome&id=', $_GET['id'], '&nome=';?>'+$(this).val(), function (retorno){
            $('#url').val(retorno.url);
            if (fechar){
                fechaJfbox();
            }
        });
        
    });

</script>