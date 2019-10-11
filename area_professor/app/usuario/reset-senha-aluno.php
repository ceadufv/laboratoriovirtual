<?php
//se confirmado, reseta a senha do aluno para 123456
if ($_POST['resetar'] == 'S') {
    //reseta a senha para 123456
    $objUsuario = new Usuario();
    $objUsuario->resetarSenhaAluno($_POST['cod_usuario']);
    echo json_encode(array('succcess'=>true,'msg'=>''));
}
?>