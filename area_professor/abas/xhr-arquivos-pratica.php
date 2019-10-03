<?php
if($_FILES['imagem']['error'] != 0){
    $result = array('success'=>false,'msg'=>'Error');
    echo json_encode($result);
    exit();
}

$path_parts = pathinfo($_FILES['imagem']['name']);
$dir = mkdir(URL_SYSTEM.'uploads/praticas/'.$_POST['id_pratica'].'/',0777);
$src_img = 'uploads/praticas/'.$_POST['id_pratica'].'/'.date('Y-m-d').'--'.rand(0,1000).'.'.$path_parts['extension'];

if(move_uploaded_file($_FILES['imagem']['tmp_name'], URL_SYSTEM.$src_img)){
    $objModeloPraticaArquivo = new ModeloPraticaArquivo();
    $args = array(
        'nome_moprar'=> $_FILES['imagem']['name'],
        'scr_img_moprar'=> $src_img,
        'type_img_moprar'=> $_FILES['imagem']['type'],
        'tipo_moprar'=> $_POST['tipo'],
        'fk_id_modelo_pratica'=> $_POST['id_pratica']
    );
    $id = $objModeloPraticaArquivo->insert($args);
    $result = array('success'=>true,'msg'=>'Salvo com successo!!!');
}else{
    $result = array('success'=>false,'msg'=>'Error');
}
echo json_encode($result);
exit();
?>