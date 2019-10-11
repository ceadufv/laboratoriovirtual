<?php
//se confirmado, reseta a senha do aluno para 123456
//reseta a senha para 123456
$objUsuario = new Usuario();
$objUsuario->deleteUser($_POST['cod_usuario']);
echo json_encode(array('succcess'=>true,'msg'=>''));
?>