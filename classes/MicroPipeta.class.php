<?php
/**
 * @author Wellerson
 */
class MicroPipeta{
    public function getDefaultItens(){
        $bequers = array();
        $valores = array("10-100", "50-200", "100-1000", "1000-5000");
        $disableds = array("100-1000");
        foreach($valores as $valor){
            $disabled = false;
            if(in_array($valor, $disableds))
                $disabled = true;

            $bequers[] = array(
                'disabled'=> $disabled,
                'disponivel'=> $disabled,
                'name'=> $valor,
                'qtd_maxima'=> 0,
                'volume_maximo'=> 80,
                'desvio_padrao'=> 10
            );
        }
        return $bequers;
    }

    //parce form to array
    public function getJsonForm($dados){
        $bequers = array();
        foreach ($dados['micropipeta_disponivel'] as $key => $value) {
          $bequers[] = array(
            'id' => $key+1,
            'disponivel' => $dados['micropipeta_disponivel'][$key],
            'name' => $dados['micropipeta_name'][$key],
            'qtd_maxima' => $dados['micropipeta_qtd_maxima'][$key],
            'animacao' => $dados['micropipeta_animacao'],
          );
        }
        return $bequers;
    }
}