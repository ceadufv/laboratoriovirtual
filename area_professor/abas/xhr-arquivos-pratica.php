<?php
if ($_POST['acao'] == 'deletar') {
    //não estou deletando o arquivo somente do BD
    $objModeloPraticaArquivo = new ModeloPraticaArquivo();
    $objModeloPraticaArquivo->delete($_POST['cod_moprar']);
    $result = array('success' => true, 'msg' => 'Deletado com successo!');
    echo json_encode($result);
    exit();
}

if ($_POST['acao'] == 'salvar') {
    if (empty($_FILES['imagem'])) {
        $result = array('success' => false, 'msg' => 'Arquivo invalido!');
        echo json_encode($result);
        exit();
    }

    if ($_FILES['imagem']['error'] != 0) {
        $result = array('success' => false, 'msg' => 'Error');
        echo json_encode($result);
        exit();
    }

    $path_parts = pathinfo($_FILES['imagem']['name']);
    $dir = mkdir(URL_SYSTEM . 'uploads/praticas/' . $_POST['id_pratica'] . '/', 0777);
    $src_img = 'uploads/praticas/' . $_POST['id_pratica'] . '/' . date('Y-m-d--H-i-s') . '--' . rand(0, 1000) . '.' . $path_parts['extension'];

    if (move_uploaded_file($_FILES['imagem']['tmp_name'], URL_SYSTEM . $src_img)) {
        $objModeloPraticaArquivo = new ModeloPraticaArquivo();
        $args = array(
            'nome_moprar' => $_FILES['imagem']['name'],
            'scr_img_moprar' => $src_img,
            'type_img_moprar' => $_FILES['imagem']['type'],
            'tipo_moprar' => $_POST['tipo'],
            'fk_cod_mopr' => $_POST['id_pratica']
        );
        $id = $objModeloPraticaArquivo->insert($args);
        $arquivos = $objModeloPraticaArquivo->getArquivosPratica($_POST['id_pratica'], $_POST['tipo']);
        $html = $objModeloPraticaArquivo->getItensHtml($arquivos);
        $result = array('success' => true, 'msg' => 'Salvo com successo!!!', 'html' => $html);
    } else {
        $result = array('success' => false, 'msg' => 'Error');
    }
    echo json_encode($result);
    exit();
}
