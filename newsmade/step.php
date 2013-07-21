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
require_once("../../etc/bdconf.php"); 
require_once("../../includes/jf.funcoes.php"); 

$opt = array_keys($_GET);

switch($opt['0']){	
	case 'album':
		$id = $_GET['album'];
		
		$retorno = jf_form_actions('salvar', 'salvar-edit');
		

		jf_update(PREFIXO.'newsmade_albuns', $_POST, array('id' => $id));
		
		$_SESSION['aviso'] = array('Album alterado com sucesso!', 1);
		
		
		switch ($retorno){
			case 'salvar':
				$retorno = '../../index.php?plugin=newsmade&p=midia';
			break;
			
			case 'salvar-edit':
				$retorno = '../../index.php?plugin=newsmade&p=midia&album='.$id;
			break;		
		}
		
		header('location: '.$retorno);
	break;
}


?>
