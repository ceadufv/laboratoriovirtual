<?php
/**
 * @author Wellerson
 */
class Bequer{
    public function getDefaultItens(){
        $bequers = array();
        $valores = array(5, 10, 50, 100, 250, 400, 500, 600, 1000, 2000);
        $disableds = array(50,100);
        foreach($valores as $valor){
            $disabled = 'N';
            if(in_array($valor, $disableds))
                $disabled = 'S';

            $bequers[] = array(
                'disabled'=> $disabled,
                'disponivel'=> 'N',
                'tamanho'=> $valor,
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
        foreach ($dados['bequer_desvio_padrao'] as $key => $value) {
          $bequers[] = array(
            'id' => $key+1,
            'disabled' => $dados['bequer_disabled'][$key],
            'disponivel' => $dados['bequer_disponivel'][$key],
            'qtd_maxima' => $dados['bequer_qtd_maxima'][$key],
            'ambientacao' =>  $dados['bequer_ambientacao'],
            'qtd_ambientes' => $dados['bequer_qtd_ambientes'],
            'agitacao' => $dados['bequer_agitacao'],
            'volume_maximo' => $dados['bequer_volume_maximo'][$key],
            'desvio_padrao' => $dados['bequer_desvio_padrao'][$key],
            'tamanho' => $dados['bequer_tamanho'][$key],
            'mistura' => $dados['bequer_mistura'],
            'volume' => $dados['bequer_tamanho'][$key],
          );
        }
        return $bequers;
    }
}