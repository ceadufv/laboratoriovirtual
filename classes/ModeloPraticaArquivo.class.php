<?php
class ModeloPraticaArquivo{

    
    public function getItensHtml($arquivos)
    {
        $html = '<table class="table">
                    <thead>
                        <tr>
                            <td>Link</td>
                            <td>Tipo</td>
                            <td>Ação</td>
                        </tr>
                    </thead>
                    <tbody>';
        foreach ($arquivos as $arquivo) { 
            $html .= "<tr id='file-{$arquivo['cod_moprar']}'>";
                $html .= '<td>';
                    $html .= "<span><a target='_blank' href='".URL_SITE.$arquivo['scr_img_moprar']."'>".URL_SITE.$arquivo['scr_img_moprar']."</a></span>";
                $html .= '</td>';
                $html .= '<td>';
                    $html .= "<span>".($arquivo['type_img_moprar'])."</span>";
                $html .= '</td>';
                $html .= '<td>';
                    $html .= '<button onclick="deletarArquivoPratica(this);" cod_moprar="'.$arquivo['cod_moprar'].'"  type="button" class="btn btn-danger btn-sm">
                                <i class="fa fa-pen"></i> DELETAR
                            </button>';
                 $html .= '</td>';
            $html .= '</tr>';
        }
        $html .= '</tbody>
                </table>';
        return $html;
    }

    public function insert($dados)
    {
        $db = Conexao::getInstance();
        $sql = "INSERT INTO modelo_pratica_arquivo
                (
                    nome_moprar,
                    scr_img_moprar,
                    type_img_moprar,
                    tipo_moprar,
                    fk_cod_mopr
                )
                VALUES
                (
                    :nome_moprar,
                    :scr_img_moprar,
                    :type_img_moprar,
                    :tipo_moprar,
                    :fk_cod_mopr
                )";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':nome_moprar', $dados['nome_moprar']);
        $stmt->bindValue(':scr_img_moprar', $dados['scr_img_moprar']);
        $stmt->bindValue(':type_img_moprar', $dados['type_img_moprar']);
        $stmt->bindValue(':tipo_moprar', $dados['tipo_moprar']);
        $stmt->bindValue(':fk_cod_mopr', $dados['fk_cod_mopr']);
        $stmt->execute();
        return $db->lastInsertId();
    }

    public function update($dados)
    {
        $db = Conexao::getInstance();
        $sql = "UPDATE modelo_pratica_arquivo
                SET
                    nome_moprar=:nome_moprar
                    scr_img_moprar=:scr_img_moprar,
                    type_img_moprar=:type_img_moprar,
                    tipo_moprar=:tipo_moprar,
                    fk_cod_mopr=:fk_cod_mopr
                WHERE cod_moprar = :cod_moprar";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':nome_moprar', $dados['nome_moprar']);
        $stmt->bindValue(':scr_img_moprar', $dados['scr_img_moprar']);
        $stmt->bindValue(':type_img_moprar', $dados['type_img_moprar']);
        $stmt->bindValue(':tipo_moprar', $dados['tipo_moprar']);
        $stmt->bindValue(':fk_cod_mopr', $dados['fk_cod_mopr']);
        $stmt->bindValue(':cod_moprar', $dados['cod_moprar']);
        $stmt->execute();
        return true;
    }

    public function getArquivosPratica($id_modelo_pratica, $tipo="CADERNO")
    {
        $db = Conexao::getInstance();
        $sql = "SELECT * FROM modelo_pratica_arquivo
                WHERE fk_cod_mopr = :fk_cod_mopr
                AND tipo_moprar = :tipo_moprar";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':fk_cod_mopr', $id_modelo_pratica);
        $stmt->bindValue(':tipo_moprar', $tipo);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function delete($cod_moprar)
    {
        $db = Conexao::getInstance();
        $sql = "DELETE FROM modelo_pratica_arquivo
                WHERE cod_moprar = :cod_moprar";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':cod_moprar', $cod_moprar);
        $stmt->execute();
        return true;
    }

}
?>