<?php
/**
 * @author Wellerson
 */
class ModeloPratica
{
    //delete
    function deletePratica($id_modelo_pratica)
    {
        $db = Conexao::getInstance();
        $sql = 'DELETE FROM modelo_pratica
                WHERE id_modelo_pratica = :id_modelo_pratica';
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id_modelo_pratica',$id_modelo_pratica);
        $stmt->execute();
        return true;
    }

    //Pega aulas cadastradas dentro de cada disciplina
    function getPraticasDisciplina($id_disciplina)
    {
        $db = Conexao::getInstance();
        $sql = 'SELECT 
                   *
                FROM modelo_pratica mp
                LEFT JOIN disciplinas dd ON mp.id_disciplina=dd.id_disciplina 
                WHERE mp.id_disciplina=:id_disciplina 
                ORDER BY id_modelo_pratica DESC';
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id_disciplina',$id_disciplina);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Retorna um JSON com todo o conteudo necessario para a pratica ser exibida
    function getJsonLabPratica($id_pratica)
    {
        $db = Conexao::getInstance();
        $sql = "SELECT 
                    id_modelo_pratica as id,
                    fk_id_cenario,
                    nome_pratica as nome,
                    id_usuario,
                    resumo,
                    id_disciplina,
                    disponivel_mopr,
                    fk_cod_mopr_u_us as id_save,
                    data
                FROM modelo_pratica where id_modelo_pratica=:id_pratica";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id_pratica',$id_pratica);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $result['data'] = json_decode($result['data'], true);
        return $result;
    }
    
    public function getPraticaPorCod($id_modelo_pratica)
    {
        $db = Conexao::getInstance();
        $sql = "SELECT * FROM modelo_pratica 
                WHERE id_modelo_pratica=:id_modelo_pratica";
        $stmt = $db->prepare($sql);
        $stmt->execute(array(
            ':id_modelo_pratica' => $id_modelo_pratica
        ));
        $dados = $stmt->fetch(PDO::FETCH_ASSOC);
        if (empty($dados)) {
            return NULL;
        }

        $dados['dados'] = json_decode($dados['data'], true);
        return $dados;
    }

    public function salvarPratica($dados)
    {
        if(empty($dados['fk_cod_mopr_u_us'])){
            $dados['fk_cod_mopr_u_us'] = null;
        }

        $db = Conexao::getInstance();
        if (!empty($dados['id_modelo_pratica'])) { // Atualizar
            try {
                $sql = "UPDATE modelo_pratica 
                        SET
                            fk_id_cenario=:fk_id_cenario,
                            nome_pratica=:nome_pratica,
                            resumo=:resumo,
                            disponivel_mopr=:disponivel_mopr,
                            fk_cod_mopr_u_us=:fk_cod_mopr_u_us,
                            data=:data
                        WHERE id_modelo_pratica=:id_modelo_pratica";
                $stmt = $db->prepare($sql);
                $stmt->execute(array(
                    ':fk_id_cenario' => $dados['fk_id_cenario'],
                    ':nome_pratica' => $dados['nome'],
                    ':resumo' => $dados['resumo'],
                    ':disponivel_mopr' => $dados['disponivel_mopr'],
                    ':fk_cod_mopr_u_us' => $dados['fk_cod_mopr_u_us'],
                    ':data' => $dados['data'],
                    ':id_modelo_pratica' => $dados['id_modelo_pratica']
                ));
                return $dados['id_modelo_pratica'];
            } catch (Exception $e) {
                return false;
            }
        } else { //insert
            $sql = "INSERT INTO modelo_pratica
                    (fk_id_cenario, id_disciplina, nome_pratica, resumo, data, disponivel_mopr, fk_cod_mopr_u_us)
                    VALUES
                    (:fk_id_cenario, :id_disciplina, :nome_pratica, :resumo, :data, :disponivel_mopr, :fk_cod_mopr_u_us)";
            $stmt = $db->prepare($sql);
            $stmt->execute(array(
                ':fk_id_cenario' => $dados['fk_id_cenario'],
                ':id_disciplina' => $dados['id_disciplina'],
                ':nome_pratica' => $dados['nome'],
                ':resumo' => $dados['resumo'],
                ':data' => $dados['data'],
                ':disponivel_mopr' => $dados['disponivel_mopr'],
                ':fk_cod_mopr_u_us' => $dados['fk_cod_mopr_u_us']
            ));
            return $db->lastInsertId();
        }
    }
}
