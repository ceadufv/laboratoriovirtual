<?php
/**
 * @author Wellerson
 */
class Pipetador{
    public function getDefaultItens(){
        $pipetadores = array();

        $valores = array(
            "pera" => "Pipetador de três vias",
            "pi-pump2" => "Pi-pump de até 2 ml ",
            "pi-pump5" => "Pi-pump de até 5 ml",
            "pi-pump10" => "Pi-pump de até 10 ml",
            "macropipetador" => "Macropipetador",
            "automatico" => "Pipetador automático"
        );

        foreach($valores as $key=>$valor){
            $pipetadores[] = array(
                'img'=>$key,
                'disabled'=> false,
                'disponivel'=> true,
                'nome'=>$valor,
                'qtd_maxima'=> 0,
                'volume_maximo'=> 80,
                'desvio_padrao'=> 10
            );
        }
        return $pipetadores;
    }

    //parce form to array
    public function getJsonForm($dados){
        $pipetas = array();
        foreach ($dados['pipetador_nome'] as $key => $value) {
          $pipetas[] = array(
            'id' => $key+1,
            'disponivel' => $dados['pipetador_disponivel'][$key],
            'nome' => $dados['pipetador_nome'][$key],
            'img' => $dados['pipetador_img'][$key],
            'tamanho' => $dados['pipetador_tamanho'][$key],
            'qtd_maxima' => $dados['pipetador_qtd_maxima'][$key],
            'animacao' => $dados['pipetador_animacao']
          );
        }
        return $pipetas;
    }

}
