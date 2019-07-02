<?php

class LabJogo
{
    private $_dbh;
    private $_error;

    function __construct()
    {

        //include "../lab-config.php";

        try {
            $this->_dbh = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER, DB_PASSWORD);
        } catch (PDOException $e) {
            $this->_error = $e->getMessage();
            //exit;
        }
    }

    function error()
    {
        return $this->_error;
    }

    function salvarPratica($dados)
    {
        if (!empty($dados['id'])) {
            // Atualizar

            $sql = "UPDATE modelo_pratica " .
                "SET " .
                "id_cenario=:id_cenario, " .
                "nome_pratica=:nome_pratica, " .
                "resumo=:resumo, " .
                "data=:data " .
                "WHERE " .
                "id_modelo_pratica=:id_modelo_pratica";

            $stmt = $this->_dbh->prepare($sql);

            $stmt->execute(array(
                ':id_cenario' => $dados['id_cenario'],
                ':nome_pratica' => $dados['nome'],
                ':resumo' => $dados['resumo'],
                ':data' => $dados['data'],
                ':id_modelo_pratica' => $dados['id']
            ));

            return ($stmt->rowCount()) ? $dados['id'] : 0;
        } else {

            $sql = "INSERT INTO modelo_pratica(id_cenario, id_disciplina, nome_pratica, resumo, data) ".
                "VALUES(:id_cenario, :id_disciplina, :nome_pratica, :resumo, :data)";

            $stmt = $this->_dbh->prepare( $sql );
            
            //echo $sql;

            $stmt->execute(array(
                ':id_cenario' => $dados['id_cenario'],
                ':id_disciplina' => $dados['id_disciplina'],
                ':nome_pratica' => $dados['nome'],
                ':resumo' => $dados['resumo'],
                ':data' => $dados['data']
            ));

            return $this->_dbh->lastInsertId();
        }
    }

    function getPratica($id_pratica)
    {
        $sql = $this->_dbh->prepare("SELECT id_modelo_pratica as id, nome_pratica as nome, resumo, id_cenario from modelo_pratica where id_modelo_pratica=?");
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $sql->execute(array($id_pratica));
        $result = $sql->fetchAll();

        return $result[0];
    }

    // TODO: Filtrar apenas as praticas que podem ser exibidas para o aluno
    function getPraticasAluno($id_aluno)
    {
        $sql = $this->_dbh->prepare('SELECT id_modelo_pratica as id, nome_pratica from modelo_pratica order by nome_pratica');
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $sql->execute();

        return $sql->fetchAll();
    }


    // Lista as vidrarias disponiveis no armario da pratica atual
    // TODO: Usar lista de vidrarias de fato buscadas no banco
    function getVidrariasPratica($id_pratica)
    {
        $result = array();

        $sql = $this->_dbh->prepare('SELECT max(id_solucao) as zero from solucoes');
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $sql->execute();
        $data = $sql->fetchAll(PDO::FETCH_ASSOC);
        $zero = $data[0]['zero'];

        $result[] = array(
            "id" => ++$zero,
            "nome" => "Cubeta",
            "conceito" => "cubeta",
            "descricao" => "Cubeta",
            "disponiveis" => 5,
            "data" => array(),
            "_data" => array(
                "sujo" => true,
                "volumeMaximo" => 3.5
            )
        );

        $result[] = array(
            "id" => ++$zero,
            "nome" => "Béquer 5ml",
            "conceito" => "bequer",
            "descricao" => "Béquer",
            "disponiveis" => 5,
            "data" => array(),
            "_data" => array(
                "limpo" => true,
                "volumeMaximo" => 5
            )
        );


        $result[] = array(
            "id" => ++$zero,
            "nome" => "Béquer 10ml",
            "conceito" => "bequer",
            "descricao" => "Béquer",
            "disponiveis" => 5,
            "data" => array(),
            "_data" => array(
                "limpo" => true,
                "volumeMaximo" => 10
            )
        );


        $result[] = array(
            "id" => ++$zero,
            "nome" => "Béquer 50ml",
            "conceito" => "bequer",
            "descricao" => "Béquer",
            "disponiveis" => 5,
            "data" => array(),
            "_data" => array(
                "limpo" => true,
                "volumeMaximo" => 50
            )
        );

        $result[] = array(
            "id" => ++$zero,
            "nome" => "Béquer 100ml",
            "conceito" => "bequer",
            "descricao" => "Béquer",
            "disponiveis" => 5,
            "data" => array(),
            "_data" => array(
                "limpo" => true,
                "volumeMaximo" => 100
            )
        );

        $result[] = array(
            "id" => ++$zero,
            "nome" => "Béquer 250ml",
            "conceito" => "bequer",
            "descricao" => "Béquer",
            "disponiveis" => 5,
            "data" => array(),
            "_data" => array(
                "limpo" => true,
                "volumeMaximo" => 250
            )
        );


        $result[] = array(
            "id" => ++$zero,
            "nome" => "Pipeta Volumétrica",
            "conceito" => "pipeta",
            "descricao" => "Pipeta volumétrica",
            "disponiveis" => 5,
            "data" => array(),
            "_data" => array(
                "limpo" => true,
                "volumeMaximo" => 50
            )
        );

        $result[] = array(
            "id" => ++$zero,
            "nome" => "Pipetador",
            "conceito" => "pipetador",
            "descricao" => "Pêra",
            "disponiveis" => 5,
            "data" => array()
        );

        return $result;
    }

    // Lista as solucoes disponiveis no armario da pratica atual
    function getSolucoesPratica($id_pratica)
    {
        $solucoes = array();

        $sql = $this->_dbh->prepare('select id_solucao as id, nome from solucoes order by id_solucao desc');
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as $row) {
            $row['disponiveis'] = 5;
        }

        return $result;
    }

    function getSubstancias()
    {
        $dbh = $this->_dbh;
        $data = array();
        $sql = $dbh->prepare("SELECT id_substancia as id, nome, dados FROM substancias order by id_substancia asc");
        $sql->execute();
        $data = $sql->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    function getCenario($id_cenario)
    {
        $sql = "SELECT * from cenario where id_cenario=?";

        $stmt = $this->_dbh->prepare($sql);
        $stmt->bindValue(1, $id_cenario);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $result = $data[0];
        $result['data'] = json_decode($result['data']);

        return $result;
    }

    // Retorna um JSON com todo o conteudo necessario para a pratica ser exibida
    function jsonPratica($id_pratica)
    {

        header("Content-type: application/json; charset=utf-8");

        $dbh = $this->_dbh;

        //echo $id_pratica;exit;

        $sq = sprintf('select id_modelo_pratica as id, id_cenario, nome_pratica as nome, id_usuario, resumo, id_disciplina, disponivel, data from modelo_pratica where id_modelo_pratica=%d', $id_pratica);

        $sql = $dbh->prepare($sq);
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $sql->execute();

        if ($sql->rowCount() != 0) {
            while ($row = $sql->fetch()) {
                $result = $row;
            }

            $result['data'] = json_decode($result['data']);

            return $result; //echo json_encode($result);
        }

        /*
        $data = $this->getSubstancias();

        $result = array();
        
        foreach ($data as $key => $value) {
            $result[] = array(
            "id" => (int) $value['id'],
            "nome" => $value['nome'],
            "dados" => json_decode($value['dados'])
            );
        }

        // TODO: Substituir a proxima parte do codigo por essa chamada
        //$sol = $this->getSolucoesPratica($id_pratica);

        $solucoes = array();
        $sql = $dbh->prepare('select * from solucoes');
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $sql->execute();
        if($sql->rowCount() != 0) {
            while($row=$sql->fetch()) 
            {
                $composicoes = quebra($row["nomes_composicao"]);
                $ids = quebra($row["ids_composicao"]);
                $concentracoes = quebra($row["concentracao"]);
                $substancias = substancias($composicoes,$ids,$concentracoes);      
                $solucao = array(
                    "id" => (int) $row["id_solucao"],
                    "nome" => $row["nome"],
                    "conceito" => "frasco_estoque",
                    "descricao" => $row["descricao"],
                    "tecnico" => $row["tecnico"],
                    "intervalo" => (int) $row["intervalo"],
                    "disponiveis" => 5,
                    "data" => $substancias,
                    "_data" => array(
                        "volumeMaximo" => 1000
                    )
                );

                substancias($composicoes,$ids,$concentracoes);
                array_push($solucoes,$solucao);
            }
            //echo json_encode($solucoes, JSON_PRETTY_PRINT);
        }

        // Vidrarias disponiveis na pratica atual
        $vidrarias = $this->getVidrariasPratica($id_pratica);

        $pratica = $this->getPratica( $id_pratica );

        $id_cenario = (!empty($pratica['id_cenario']))?$pratica['id_cenario']:1;

        $cenario = $this->getCenario($id_cenario)['data'];

        echo json_encode(
            array(
                "id" => $id_pratica,
                "nome" => $pratica['nome'],
                "elementos" => $result,
                "armario" => array_merge($solucoes, $vidrarias),
                "cenario" => $cenario
            ), JSON_PRETTY_PRINT);
        */
    }

    //Pega os alunos cadastrados no banco de dados
    //TODO: relacionar alunos e professores
    function getAlunos($id_professor)
    {
        $sql = $this->_dbh->prepare('SELECT nome, email, usuario FROM usuarios_cadastrados WHERE id_tipo_usuario = 1');
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $sql->execute();

        return $sql->fetchAll();
    }

    //inserir aluno novo
    function insertAluno($nome, $email, $usuario)
    {
        $senha = sha1('123456');

        $sql = "INSERT INTO usuarios_cadastrados (nome, email, usuario, senha, id_tipo_usuario) 
                        VALUES (?,?,?,?, 1)";
        $stmt1 = $this->_dbh->prepare($sql);
        $stmt1->bindValue(1, $nome);
        $stmt1->bindValue(2, $email);
        $stmt1->bindValue(3, $usuario);
        $stmt1->bindValue(4, $senha);

        if ($stmt1->execute()) {
            return true;
        } else {
            return false;
        }
    }

    //Pega aulas cadastradas dentro de cada disciplina
    //TODO: linkar disciplina
    function getAulas($id_disciplina)
    {
        $sql = sprintf('select id_modelo_pratica as id, nome_pratica, disponivel from modelo_pratica where id_disciplina=%d order by nome_pratica', $id_disciplina);
        //$sql = sprintf('select id_modelo_pratica as id, nome_pratica, disponivel from modelo_pratica order by nome_pratica where id_disciplina=1',$id_disciplina);
        //exit $sql;
        $sql = $this->_dbh->prepare(
            $sql
        );
        //$sql->bindValue(1,$id_disciplina);
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $sql->execute();

        return $sql->fetchAll();
    }

    function apagarAula($id_pratica)
    { }

    function apagarDisciplina($id_disciplina)
    {
        global $banco;
        $apagar_disciplina = $banco->prepare("DELETE FROM disciplinas WHERE id_disciplina=?");

        $apagar_disciplina->bindValue(1, $id_disciplina);
        $apagar_disciplina->execute();
        $apagar = $apagar_disciplina->fetchAll(PDO::FETCH_ASSOC);
        return true;
    }

    function getResumo($id_pratica)
    {
        $sql = $this->_dbh->prepare('SELECT resumo FROM modelo_pratica WHERE id_modelo_pratica = ?');
        $sql->bindValue(1, $id_pratica);
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $sql->execute();

        return $sql->fetchAll();
    }

    function getDisciplinasProfessor($id_professor)
    {
        $sql = 'SELECT * FROM disciplinas WHERE id_professor = ?';
        $sql = $this->_dbh->prepare($sql);
        $sql->bindValue(1, $id_professor);
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $sql->execute();

        return $sql->fetchAll();
    }

    function insertDisciplina($nome, $id_professor)
    {

        $sql_pratica = "INSERT INTO disciplinas (nome, id_professor) VALUES (?,?)";
        $stmt1 = $this->_dbh->prepare($sql_pratica);
        $stmt1->bindValue(1, $nome);
        $stmt1->bindValue(2, $id_professor);

        if ($stmt1->execute()) {
            return true;
        } else {
            return false;
        }
    }

    function setDisciplina($nome, $id_disciplina)
    {
        $sql = "UPDATE disciplinas
                SET nome = ?
                WHERE id_disciplina = ?;";
        $stmt1 = $this->_dbh->prepare($sql);
        $stmt1->bindValue(1, $nome);
        $stmt1->bindValue(2, $id_disciplina);

        if ($stmt1->execute()) {
            return true;
        } else {
            return false;
        }
    }

    function codificarSenha($senha)
    {
        return sha1($senha);
    }

    function setPerfil($nome, $senha, $email, $id_usuario)
    {
        $senha_codificada = $this->codificarSenha($senha);

        if (!empty($nome) && !empty($senha) && !empty($email)) // nenhum vazio
        {
            $sql = "UPDATE usuarios_cadastrados
                    SET nome = ?, senha = ?, email = ?
                    WHERE id_usuario = ?;";
            $stmt1 = $this->_dbh->prepare($sql);
            $stmt1->bindValue(1, $nome);
            $stmt1->bindValue(2, $senha_codificada);
            $stmt1->bindValue(3, $email);
            $stmt1->bindValue(4, $id_usuario);
        } else if (!empty($senha) && !empty($email)) // nome vazio
        {
            $sql = "UPDATE usuarios_cadastrados
                    SET senha = ?, email = ?
                    WHERE id_usuario = ?;";
            $stmt1 = $this->_dbh->prepare($sql);
            $stmt1->bindValue(1, $senha_codificada);
            $stmt1->bindValue(2, $email);
            $stmt1->bindValue(3, $id_usuario);
        } else if (!empty($nome) && !empty($email)) // senha vazia
        {
            $sql = "UPDATE usuarios_cadastrados
                    SET nome = ?, email = ?
                    WHERE id_usuario = ?;";
            $stmt1 = $this->_dbh->prepare($sql);
            $stmt1->bindValue(1, $nome);
            $stmt1->bindValue(2, $email);
            $stmt1->bindValue(3, $id_usuario);
        } else if (!empty($nome) && !empty($senha)) // email vazio
        {
            $sql = "UPDATE usuarios_cadastrados
                    SET nome = ?, senha = ?
                    WHERE id_usuario = ?;";
            $stmt1 = $this->_dbh->prepare($sql);
            $stmt1->bindValue(1, $nome);
            $stmt1->bindValue(2, $senha_codificada);
            $stmt1->bindValue(3, $id_usuario);
        } else if (!empty($email)) // nome e senha vazios
        {
            $sql = "UPDATE usuarios_cadastrados
                    SET email = ?
                    WHERE id_usuario = ?;";
            $stmt1 = $this->_dbh->prepare($sql);
            $stmt1->bindValue(1, $email);
            $stmt1->bindValue(2, $id_usuario);
        } else if (!empty($senha)) // nome e email vazios
        {
            $sql = "UPDATE usuarios_cadastrados
                    SET senha = ?
                    WHERE id_usuario = ?;";
            $stmt1 = $this->_dbh->prepare($sql);
            $stmt1->bindValue(1, $senha_codificada);
            $stmt1->bindValue(2, $id_usuario);
        } else if (!empty($nome)) // senha e email vazios
        {
            $sql = "UPDATE usuarios_cadastrados
            SET nome = ?
            WHERE id_usuario = ?;";
            $stmt1 = $this->_dbh->prepare($sql);
            $stmt1->bindValue(1, $nome);
            $stmt1->bindValue(2, $id_usuario);
        }
        if ($stmt1->execute()) {
            return true;
        } else {
            return false;
        }
    }

    function getRegistros($filtros)
    {
        $sql = $this->_dbh->prepare('SELECT nome_pratica, u.nome, data_acao, descricao FROM acao_pratica, usuarios_cadastrados AS u, modelo_pratica 
                                        WHERE u.id_usuario = id_aluno AND id_pratica = id_modelo_pratica ORDER BY u.nome, data_acao');
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $sql->execute();

        return $sql->fetchAll();
    }

    function getRegistrosAluno($id_aluno)
    {
        $sql = $this->_dbh->prepare('SELECT nome_pratica, data_acao, descricao FROM acao_pratica, usuarios_cadastrados AS u, modelo_pratica 
                                        WHERE u.id_usuario = id_aluno AND id_pratica = id_modelo_pratica AND id_aluno = ? ORDER BY data_acao');
        $sql->bindValue(1, $id_aluno);
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $sql->execute();

        return $sql->fetchAll();
    }

    function getPraticaEdit($id_pratica)
    {
        $resultado = array();
        $id_solucao = 2;
        $id_bequer = 4;
        $id_balaovolumetrico = 5;
        $id_pipetavolumetrica = 6;
        $id_pipetador = 7;
        $id_micropipeta = 8;

        $id_categoria = $id_solucao;
        $solucoes_selecionadas = $this->_dbh->prepare("SELECT * FROM objeto WHERE id_pratica=$id_pratica and id_categoria=$id_categoria");
        $solucoes_selecionadas->execute();
        $solucao = $solucoes_selecionadas->fetchAll(PDO::FETCH_ASSOC);

        $lista_solucao = array();
        $p = json_decode($solucao[0]['json_dados']);

        foreach ($p as $value) {
            $nome_solucao = $this->_dbh->prepare("SELECT * FROM solucoes WHERE id_solucao=$value");
            $nome_solucao->execute();
            $lista_solucao[] = $nome_solucao->fetchAll(PDO::FETCH_ASSOC)[0];
        }

        $id_categoria = $id_bequer;
        $solucoes_selecionadas = $this->_dbh->prepare("SELECT * FROM objeto WHERE id_pratica=$id_pratica and id_categoria=$id_categoria");
        $solucoes_selecionadas->execute();
        $bequer = $solucoes_selecionadas->fetchAll(PDO::FETCH_ASSOC);

        $id_categoria = $id_balaovolumetrico;
        $solucoes_selecionadas = $this->_dbh->prepare("SELECT * FROM objeto WHERE id_pratica=$id_pratica and id_categoria=$id_categoria");
        $solucoes_selecionadas->execute();
        $balaovolumetrico = $solucoes_selecionadas->fetchAll(PDO::FETCH_ASSOC);

        $id_categoria = $id_pipetavolumetrica;
        $solucoes_selecionadas = $this->_dbh->prepare("SELECT * FROM objeto WHERE id_pratica=$id_pratica and id_categoria=$id_categoria");
        $solucoes_selecionadas->execute();
        $pipetavolumetrica = $solucoes_selecionadas->fetchAll(PDO::FETCH_ASSOC);

        $id_categoria = $id_pipetador;
        $solucoes_selecionadas = $this->_dbh->prepare("SELECT * FROM objeto WHERE id_pratica=$id_pratica and id_categoria=$id_categoria");
        $solucoes_selecionadas->execute();
        $pipetador = $solucoes_selecionadas->fetchAll(PDO::FETCH_ASSOC);

        $id_categoria = $id_micropipeta;
        $solucoes_selecionadas = $this->_dbh->prepare("SELECT * FROM objeto WHERE id_pratica=$id_pratica and id_categoria=$id_categoria");
        $solucoes_selecionadas->execute();
        $micropipeta = $solucoes_selecionadas->fetchAll(PDO::FETCH_ASSOC);


        $resultado['solucao'] = $solucao;
        $resultado['bequer'] = $bequer;
        $resultado['balaovolumetrico'] = $balaovolumetrico;
        $resultado['pipetavolumetrica'] = $pipetavolumetrica;
        $resultado['pipetador'] = $pipetador;
        $resultado['micropipeta'] = $micropipeta;

        $resultado['lista_solucao'] = $lista_solucao;

        $resultado['status'] = true;

        return $resultado;
    }

    function getSolucaoEdit($id_solucao)
    {
        $resultado = array();

        $solucoes_selecionadas = $this->_dbh->prepare("SELECT * FROM solucoes WHERE id_solucao = $id_solucao");
        $solucoes_selecionadas->execute();
        $item = $solucoes_selecionadas->fetchAll(PDO::FETCH_ASSOC);

        $nome_tecnico = $item[0]['tecnico'];
        $descricao_solucao  = $item[0]['descricao'];
        $nome_solucao  = $item[0]['nome'];
        $data_de_criacao = $item[0]['intervalo'];
        $conc_lista_solucao = $item[0]['concentracao'];
        $nomes_composicao = $item[0]['nomes_composicao'];
        $ids_composicao = $item[0]['ids_composicao'];


        $resultado['status'] = true;
        $resultado['id_solucao'] = $id_solucao;
        $resultado['nome_tecnico'] = $nome_tecnico;
        $resultado['descricao_solucao'] = $descricao_solucao;
        $resultado['nome_solucao'] = $nome_solucao;
        $resultado['data_de_criacao'] = $data_de_criacao;
        $resultado['conc_lista_solucao'] = explode(",", $conc_lista_solucao);
        $resultado['nomes_composicao'] =  explode(",", $nomes_composicao);
        $resultado['ids_composicao'] =  explode(",", $ids_composicao);

        return $resultado;
    }

    function getSolucoes()
    {
        $sql = $this->_dbh->prepare('SELECT * FROM substancias');
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $sql->execute();

        return $sql->fetchAll();
    }

    function getPraticaEdicao($id_pratica)
    {
        $resultado = array();
        $id_solucao = 2;
        $id_bequer = 4;
        $id_balaovolumetrico = 5;
        $id_pipetavolumetrica = 6;
        $id_pipetador = 7;
        $id_micropipeta = 8;

        $id_categoria = $id_solucao;
        $banco =  $this->_dbh;
        $solucoes_selecionadas = $banco->prepare("SELECT * FROM objeto WHERE id_pratica=$id_pratica and id_categoria=$id_categoria");
        $solucoes_selecionadas->execute();
        $solucao = $solucoes_selecionadas->fetchAll(PDO::FETCH_ASSOC);

        $lista_solucao = array();
        $p = json_decode($solucao[0]['json_dados']);

        foreach ($p as $value) {
            $nome_solucao = $banco->prepare("SELECT * FROM solucoes WHERE id_solucao=$value");
            $nome_solucao->execute();
            $lista_solucao[] = $nome_solucao->fetchAll(PDO::FETCH_ASSOC)[0];
        }

        $id_categoria = $id_bequer;
        $solucoes_selecionadas = $banco->prepare("SELECT * FROM objeto WHERE id_pratica=$id_pratica and id_categoria=$id_categoria");
        $solucoes_selecionadas->execute();
        $bequer = $solucoes_selecionadas->fetchAll(PDO::FETCH_ASSOC);

        $id_categoria = $id_balaovolumetrico;
        $solucoes_selecionadas = $banco->prepare("SELECT * FROM objeto WHERE id_pratica=$id_pratica and id_categoria=$id_categoria");
        $solucoes_selecionadas->execute();
        $balaovolumetrico = $solucoes_selecionadas->fetchAll(PDO::FETCH_ASSOC);

        $id_categoria = $id_pipetavolumetrica;
        $solucoes_selecionadas = $banco->prepare("SELECT * FROM objeto WHERE id_pratica=$id_pratica and id_categoria=$id_categoria");
        $solucoes_selecionadas->execute();
        $pipetavolumetrica = $solucoes_selecionadas->fetchAll(PDO::FETCH_ASSOC);

        $id_categoria = $id_pipetador;
        $solucoes_selecionadas = $banco->prepare("SELECT * FROM objeto WHERE id_pratica=$id_pratica and id_categoria=$id_categoria");
        $solucoes_selecionadas->execute();
        $pipetador = $solucoes_selecionadas->fetchAll(PDO::FETCH_ASSOC);

        $id_categoria = $id_micropipeta;
        $solucoes_selecionadas = $banco->prepare("SELECT * FROM objeto WHERE id_pratica=$id_pratica and id_categoria=$id_categoria");
        $solucoes_selecionadas->execute();
        $micropipeta = $solucoes_selecionadas->fetchAll(PDO::FETCH_ASSOC);

        //Nome Prática
        $g = $banco->prepare("SELECT nome_pratica, resumo, id_disciplina FROM modelo_pratica WHERE id_modelo_pratica=$id_pratica");
        $g->execute();
        $pratica = $g->fetchAll(PDO::FETCH_ASSOC);


        $resultado['solucao'] = $solucao;
        $resultado['bequer'] = $bequer;
        $resultado['balaovolumetrico'] = $balaovolumetrico;
        $resultado['pipetavolumetrica'] = $pipetavolumetrica;
        $resultado['pipetador'] = $pipetador;
        $resultado['micropipeta'] = $micropipeta;
        $resultado['pratica'] = $pratica;


        $resultado['lista_solucao'] = $lista_solucao;

        $resultado['status'] = true;

        return $resultado;
    }
}
