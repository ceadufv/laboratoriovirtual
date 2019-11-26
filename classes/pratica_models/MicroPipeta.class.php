<?php
/**
 * @author Wellerson
 */

 //
class MicroPipeta{
    public function getDefaultItens(){
        $micro_pipetas = array();
        $valores = array("10-100", "50-200", "100-1000", "1000-5000");
     
            $micro_pipetas[] = array(
                'disabled'=> 'S',
                'disponivel'=> 'N',
                'nome'=> "10-100",
                'qtd_maxima'=> 0,
                'volume_max'=> 100,
                'volume_min'=> 10,
                'desvio_padrao'=> 10
            );
    
            $micro_pipetas[] = array(
                'disabled'=> 'S',
                'disponivel'=> 'N',
                'nome'=> "50-200",
                'qtd_maxima'=> 0,
                'volume_max'=> 200,
                'volume_min'=> 50,
                'desvio_padrao'=> 10
            );

            $micro_pipetas[] = array(
                'disabled'=> 'S',
                'disponivel'=> 'N',
                'nome'=> "100-1000",
                'qtd_maxima'=> 0,
                'volume_max'=> 1000,
                'volume_min'=> 100,
                'desvio_padrao'=> 10
            );

            $micro_pipetas[] = array(
                'disabled'=> 'S',
                'disponivel'=> 'N',
                'nome'=> "1000-5000",
                'qtd_maxima'=> 0,
                'volume_max'=> 5000,
                'volume_min'=> 1000,
                'desvio_padrao'=> 10
            );


        return $micro_pipetas;
    }

    //parce form to array
    public function getJsonForm($dados){
        $micro_pipetas = array();
        foreach ($dados['micropipeta_disponivel'] as $key => $value) {
          $micro_pipetas[] = array(
            'id' => $key+1,
            'disponivel' => $dados['micropipeta_disponivel'][$key],
            'nome' => $dados['micropipeta_name'][$key],
            'qtd_maxima' => $dados['micropipeta_qtd_maxima'][$key],
            'animacao' => $dados['micropipeta_animacao'],
            'volume_max' => $dados['micropipeta_volume_max'][$key],
            'volume_min' => $dados['micropipeta_volume_min'][$key]
          );
        }
        return $micro_pipetas;
    }
}