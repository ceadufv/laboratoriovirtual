<?php
$objModeloPratica = new ModeloPratica();
$objModeloPratica->deletePratica($_POST['id_modelo_pratica']);
echo json_encode(array('succcess'=>true,'msg'=>'Pratica deletada com sucesso!'));
?>