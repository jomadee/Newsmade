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

$nome = $_GET['nome'];
$url = jf_formata_url($nome);
$insert = array('nome' => $nome, 'url' => $url);

jf_update($llTable.'_colunas', $insert, array('id' => $_GET['id']));


echo json_encode($insert);
?>
