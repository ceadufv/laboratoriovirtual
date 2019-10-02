<?php
/**
 * @author Wellerson
 */
class PipetaVolumetrica{
    public function getDefaultItens(){
        $baloes = array();
        $valores = array(1.0, 2.0, 3.0, 4.0, 5.0, 6.0, 7.0, 8.0, 9.0, 10, 15, 20, 25, 50, 100);
        $disableds = array(5,10);

        foreach($valores as $valor){
            $disabled = false;
            if(in_array($valor, $disableds))
                $disabled = true;

            $baloes[] = array(
                'disabled'=> $disabled,
                'disponivel'=> $disabled,
                'tamanho'=> $valor,
                'qtd_maxima'=> 0,
                'volume_maximo'=> 80,
                'desvio_padrao'=> 10
            );
        }
        return $baloes;
    }

    //parce form to array
    public function getJsonForm($dados){
        $pipetas = array();
        foreach ($dados['pipeta_desvio_padrao'] as $key => $value) {
          $pipetas[] = array(
            'id' => $key+1,
            'disponivel' => $dados['balao_disponivel'][$key],
            'qtd_maxima' => $dados['pipeta_qtd_maxima'][$key],
            'ambientacao' =>  $dados['pipeta_ambientacao'],
            'qtd_ambientes' => $dados['pipeta_qtd_ambientes'],
            'agitacao' => $dados['pipeta_agitacao'],
            'faixa_aceitavel' => $dados['pipeta_faixa_aceitavel'][$key],
            'desvio_padrao' => $dados['pipeta_desvio_padrao'][$key],
            'tamanho' => $dados['pipeta_tamanho'][$key],
            'volume' => $dados['pipeta_tamanho'][$key],
            'mistura' => $dados['pipeta_mistura']
          );
        }
        return $pipetas;
    }

}
