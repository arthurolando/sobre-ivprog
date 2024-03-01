<?php
	if (!isset($_POST['details'])) {
    	header('Location:report.html');
    	exit;
 	}

 	try {
		// Fazendo login no wekan:
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,"http://200.144.254.107/wekan/users/login");
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,
		            "username=ivprogsite&password=T2mWR4vNr7tVwpTVR2gS");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$server_output = curl_exec($ch);
		curl_close ($ch);
		$dadosLogin = json_decode($server_output);

		if (!$dadosLogin) {
			throw new Exception();
		}

		// Preparando o texto para submeter ao wekan:
		$details = '';
		if (isset($_POST['name']) && !empty(trim($_POST['name']))) {
			$details .= 'Nome: ' . strip_tags(trim($_POST['name'])) . '\n';
		}
		if (isset($_POST['email']) && !empty(trim($_POST['email']))) {
			$details .= 'E-mail: ' . strip_tags(trim($_POST['email'])) . '\n';
		}
		$details .= 'Detalhes: ' . strip_tags(trim($_POST['details']));

		$summary = '';
		if (isset($_POST['summary']) && !empty(trim($_POST['summary']))) {
			$summary = strip_tags(trim($_POST['summary']));
		}
		// Fazendo a submissão dos dados para o Wekan:
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		    'Authorization: Bearer ' . $dadosLogin->token,
		    'Content-type:application/json'
		));
		curl_setopt($ch, CURLOPT_URL,"http://200.144.254.107/wekan/api/boards/v82Wx3C3dk79t4pJw/lists/dHNhYSSyyqWhRn6NX/cards");
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,
		            '{ "title": "'.$summary.'", "description": "'.$details.'", "authorId": "'. $dadosLogin->id.'", "swimlaneId": "HeJBje3EdmJ3GpZyb" }');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$retorno = curl_exec($ch);
		curl_close ($ch);
		$resposta = json_decode($retorno);
		if (!$resposta->_id) {
			throw new Exception();
		}
	} catch (Exception $ex) {
		if (isset($_POST['redirect'])) {
			header('Location:'.$_POST['redirect'].'?error=true');
	    	exit;
		} else {
			header('Location:report.html?error=true');
	    	exit;
		}
	}

	if (isset($_POST['redirect'])) {
		header('Location:'.$_POST['redirect'].'?reported=true');
    	exit;
	} else {
		header('Location:report.html?reported=true');
    	exit;
	}

?>



