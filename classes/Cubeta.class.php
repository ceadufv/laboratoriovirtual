<?php
/**
 * @author Wellerson
 */
class Cubeta{
    public function getDefaultItens(){
        $cubetas = array();
        $valores =  array("Cubeta de vidro","Cubeta de quartzo");
        foreach($valores as $valor){
            $cubetas[] = array(
                'disponivel'=> true,
                'nome'=> $valor,
                'qtd_maxima'=> 0,
            );
        }
        return $cubetas;
    }

    //parce form to array
    public function getJsonForm($dados){
        $bequers = array();
        foreach ($dados['cubeta_disponivel'] as $key => $value) {
          $bequers[] = array(
            'id' => $key+1,
            'disponivel' => $dados['cubeta_disponivel'][$key],
            'nome' => $dados['cubeta_nome'][$key],
            'qtd_maxima' => $dados['cubeta_qtd_maxima'][$key],
          );
        }
        return $bequers;
    }
}