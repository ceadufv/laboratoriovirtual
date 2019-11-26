<?php
header("Content-type: application/json; charset=utf-8");
$args = array(
    'fk_id_usuario'=>$_POST['id_aluno'],
    'dados_mopr_u_us'=>$_POST['data'],
    'fk_id_modelo_pratica'=>$_POST['id_pratica'],
    'des_mopr_u_us'=>$_POST['desc'],
    'type_mopr_u_us'=>$_POST['type'],
);

if(empty($args['fk_id_usuario']) || empty($args['fk_id_modelo_pratica']) || empty($args['des_mopr_u_us'])){
    echo json_encode(array('success'=>false,'msg'=>'ERROR'));
    exit();
}

$objModeloPraticaUUsuario = new ModeloPraticaUUsuario();
$id = $objModeloPraticaUUsuario->salvarHistorico($args);
echo json_encode(array('success'=>true,'msg'=>'OK', 'id'=>$id));
