<?php
include('../lab-config.php');
include('conexao.php');

// TODO: Verificar se vale a pena usar input_post por questoes de seguranca
//$comandos = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$comandos = $_REQUEST;

switch ($comandos['acao']) {
	case "buscar-dados-substancia":
		buscar($comandos['substancia']);
		break;

	case "informacoes_cadastradas":
		buscarInfoVidrarias();
		break;

	case "validar_login":
		Login::logar($comandos['usuario'], $comandos['senha']);
		break;

	case "cadastrar_usuario":
		cadastrarUsuario($comandos['nome'], $comandos['email'], $comandos['usuario'], $comandos['senha'], $comandos['acesso']);
		break;

	case "carregar_id_pratica":
		carregarIDPratica2();
		break;

	case "carregar_alunos":
		carregarAlunos();
		break;

	case "nome_disciplina":
		nome_disciplina();
		break;

		break;
}
function nome_disciplina()
{
	header("Content-type: application/json; charset=utf-8");
	global $banco;
	try {
		session_start();
		$_SESSION['disciplina'] = @$_REQUEST['nomedisciplina'];
		$_SESSION['id_disciplina'] = @$_REQUEST['id_disciplina'];
		echo json_encode($_SESSION['disciplina']);
	} catch (PDOException $e) {
		echo json_encode(array('sucesso' => false, 'log' => $e->getMessage()));
	}
}

function carregarAlunos()
{
	global $banco;
	try {
		$consulta = $banco->prepare('select id_usuario, nome, email, usuario from usuarios_cadastrados WHERE id_tipo_usuario=1');
		$consulta->execute();
		$praticas = $consulta->fetchAll(PDO::FETCH_ASSOC);
		$json = array(
			'data' => array()
		);

		// Percorre as respostas encontradas
		foreach ($praticas as $pratica) {
			array_push(
				$json['data'],
				array(
					$pratica['usuario'],
					$pratica['nome'],
					$pratica['email'],
				)
			);
		}

		// Envia a resposta
		echo json_encode(array('sucesso' => true, 'data' => $json['data']));
	} catch (PDOException $e) {
		echo json_encode(array('sucesso' => false, 'log' => $e->getMessage()));
	}

	/*
		header("Content-Type: application/json");
		?>{
		"data": [
		    [
		        "Tiger Nixon",
		        "System Architect",
		        "Edinburgh",
		        "5421",
		        "2011\/04\/25",
		        "$320,800"
		    ]
		]
		}
		<?php
		*/
}

// Busca nomes de práticas disponíveis para serem realizadas
function carregarIDPratica2()
{
	global $banco;
	try {
		$consulta = $banco->prepare('SELECT id as id_pratica, titulo as nome_pratica FROM dados WHERE teste=2');
		$consulta->execute();
		$praticas = $consulta->fetchAll(PDO::FETCH_ASSOC);
		$json = array(
			'data' => array()
		);

		// Percorre as respostas encontradas
		foreach ($praticas as $pratica) {
			array_push(
				$json['data'],
				array(
					'id' => $pratica['id_pratica'],
					'nome' => $pratica['nome_pratica']
				)
			);
		}

		// Envia a resposta
		echo json_encode(array('sucesso' => true, 'data' => $json['data']));
	} catch (PDOException $e) {
		echo json_encode(array('sucesso' => false, 'log' => $e->getMessage()));
	}
}


// Busca nomes de práticas disponíveis para serem realizadas
function carregarIDPratica()
{
	global $banco;
	try {
		$consulta = $banco->prepare('SELECT id_pratica, nome_pratica FROM pratica');
		$consulta->execute();
		$praticas = $consulta->fetchAll(PDO::FETCH_ASSOC);
		$json = array(
			'id' => array(),
			'nome' => array()
		);

		// Percorre as respostas encontradas
		foreach ($praticas as $pratica) {
			array_push($json['id'], $pratica['id_pratica']);
			array_push($json['nome'], $pratica['nome_pratica']);
		}

		// Envia a resposta
		echo json_encode(array('sucesso' => true, 'log' => $json));
	} catch (PDOException $e) {
		echo json_encode(array('sucesso' => false, 'log' => $e->getMessage()));
	}
}

// Busca prática no banco e carrega as informações de configuração
function carregarDadosPratica($id)
{
	global $banco;
	try {
		// Busca a prática pelo id
		$consulta = $banco->prepare('SELECT');
	} catch (PDOException $e) {
		echo json_encode(array('sucesso' => false, 'log' => $e->getMessage()));
	}
}

// Cadastro de novo usuário
function cadastrarUsuario($nome, $email, $user, $pass, $acesso)
{
	global $banco;
	try {
		// Validação dos dados de cadastro
		if (strlen($pass) < 5) {
			echo json_encode(array('sucesso' => false, 'log' => 'Senha muito curta, falha no cadastro.'));
		} elseif (!userValido($user)) {
			echo json_encode(array('sucesso' => false, 'log' => 'Nome de usuário já existente, falha no cadastro.'));
		} else {
			// Cadastra o novo usuário no banco de dados
			$consulta = $banco->prepare('INSERT INTO usuarios_cadastrados (nome, email, usuario, senha, id_tipo_usuario) VALUES(:nome, :email, :usuario, :senha, :id_tipo_usuario)');
			$consulta->execute(array(
				':nome' => $nome,
				':email' => $email,
				':usuario' => $user,
				':senha' => sha1($pass),
				':id_tipo_usuario' => intval($acesso)
			));
			echo json_encode(array('sucesso' => true, 'log' => 'Cadastro realizado com sucesso. Fique a vontade para utilizar o sistema.'));
		}
	} catch (PDOException $e) {
		echo json_encode(array('sucesso' => false, 'log' => $e->getMessage()));
	}
}

// Função auxiliar que valida existência de usuário
function userValido($user)
{
	global $banco;
	$consulta = $banco->prepare('SELECT usuario FROM usuarios_cadastrados');
	$consulta->execute();
	$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
	$valido = true;
	foreach ($resultado as $usuario) {
		if ($user === $usuario['usuario']) {
			$valido = false;
		}
	}
	return $valido;
}


// Função de busca no banco de dados
function buscar($substancia)
{
	global $banco;
	try {
		// Busca substância no banco
		$consulta = $banco->prepare('SELECT dados FROM dados_de_substancia WHERE nome = :nome');
		$consulta->execute(array(':nome' => $substancia));
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		// Testes
		if (count($resultado) != 1) {
			// Substância não cadastrada
			echo json_encode(array('sucesso' => false, 'log' => 'Substância não encontrada'));
		} else {
			// Envia os dados obtidos do banco
			$resultado = json_decode($resultado[0]['dados'], true);
			echo json_encode(array('sucesso' => true, 'log' => $resultado));
		}
	} catch (PDOException $e) {
		echo json_encode(array('sucesso' => false, 'log' => $e->getMessage()));
	}
}

// Função para busca de vidrarias
function buscarInfoVidrarias()
{
	global $banco;
	try {
		// Busca dados no banco
		$consulta = $banco->prepare('SELECT * FROM objeto');
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		// Prepara o json de resposta
		$dados = array(
			'nomeInterno' => array(),
			'nomeFormatado' => array(),
			'volumes' => array(),
			'substancias' => array()
		);
		foreach ($resultado as $vidraria) {
			array_push($dados['nomeInterno'], $vidraria['nome_interno']);
			array_push($dados['nomeFormatado'], $vidraria['nome_formatado']);
			$volumes = json_decode($vidraria['volumes'], true);
			array_push($dados['volumes'], $volumes);
		}
		// Busca as substâncias cadastradas
		$consulta = $banco->prepare('SELECT nome FROM dados_de_substancia');
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		// Percorre o array de resposta
		foreach ($resultado as $substancia) {
			array_push($dados['substancias'], $substancia['nome']);
		}
		// Envia a resposta
		echo json_encode(array('sucesso' => true, 'log' => $dados));
	} catch (PDOException $e) {
		echo json_encode(array('sucesso' => false, 'log' => $e->getMessage()));
	}
}
