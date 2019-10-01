<?php
/**
 * @author Wellerson
 */
class ModeloPratica{
    private $_dbh;
    private $_error;

    function __construct()
    {
        try {
            $this->_dbh = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER, DB_PASSWORD);
        } catch (PDOException $e) {
            $this->_error = $e->getMessage();
        }
    }

    public function getPraticaPorCod($id_modelo_pratica)
    { 
        $sql = "SELECT * FROM modelo_pratica 
                WHERE id_modelo_pratica=:id_modelo_pratica";
        $stmt = $this->_dbh->prepare($sql);
        $stmt->execute(array(
            ':id_modelo_pratica' => $id_modelo_pratica
        ));
        $dados = $stmt->fetch(PDO::FETCH_ASSOC);
        if(empty($dados)){
            return NULL;
        }
        
        $dados['dados'] = json_decode($dados['data'], true);
        return $dados;
    }

    public function salvarPratica($dados)
    {
        if (!empty($dados['id_modelo_pratica'])) { // Atualizar
            try {
                $sql = "UPDATE modelo_pratica 
                        SET
                            id_cenario=:id_cenario,
                            nome_pratica=:nome_pratica,
                            resumo=:resumo,
                            data=:data
                        WHERE id_modelo_pratica=:id_modelo_pratica";
                $stmt = $this->_dbh->prepare($sql);
                $stmt->execute(array(
                    ':id_cenario' => $dados['id_cenario'],
                    ':nome_pratica' => $dados['nome'],
                    ':resumo' => $dados['resumo'],
                    ':data' => $dados['data'],
                    ':id_modelo_pratica' => $dados['id_modelo_pratica']
                ));
                return $dados['id_modelo_pratica'];
            } catch (Exception $e) {
                return false;
            }
        } else { //insert
            $sql = "INSERT INTO modelo_pratica
                    (id_cenario, id_disciplina, nome_pratica, resumo, data)
                    VALUES
                    (:id_cenario, :id_disciplina, :nome_pratica, :resumo, :data)";
            $stmt = $this->_dbh->prepare($sql);
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


}
