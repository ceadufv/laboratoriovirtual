<?php
/**
 * @author Wellerson
 */
class BalaoVolumetrico{
    public function getDefaultItens(){
        $baloes = array();
        $valores = array(5, 10, 25, 50, 100, 200, 250, 500, 1000, 2000);
        $disableds = array(5,10,25,50,100,200);

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
        $baloes = array();
        foreach ($dados['balao_desvio_padrao'] as $key => $value) {
          $baloes[] = array(
            'id' => $key+1,
            'disponivel' => $dados['balao_disponivel'][$key],
            'qtd_maxima' => $dados['balao_qtd_maxima'][$key],
            'ambientacao' =>  $dados['balao_ambientacao'],
            'qtd_ambientes' => $dados['balao_qtd_ambientes'],
            'agitacao' => $dados['balao_agitacao'],
            'faixa_aceitavel' => $dados['balao_faixa_aceitavel'][$key],
            'desvio_padrao' => $dados['balao_desvio_padrao'][$key],
            'tamanho' => $dados['balao_tamanho'][$key],
            'volume' => $dados['balao_tamanho'][$key],
            'mistura' => $dados['balao_mistura']
          );
        }
        return $baloes;
    }

}
