<?php

$nome = $_GET['nome'];
$url = jf_formata_url($nome);
$insert = array('nome' => $nome, 'url' => $url);

jf_update($llTable.'_colunas', $insert, array('id' => $_GET['id']));


echo json_encode($insert);
?>
