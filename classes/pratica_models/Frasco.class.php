<?php
/**
 * @author Wellerson
 */
class Frasco{
    public function getDefaultItens(){
        $frascos = array();
        $frascos[] = array(
            'disabled'=> 'N',
            'conceito'=>'frasco',
            'volume_max'=>5,
            'volume_atual'=>0,
            'volume'=>0,
            'disponivel'=>'S',
            'qtd_maxima'=> '4',
            'id'=>887,
            'nome'=>'Frasco Vazio 5ml',
            'descricao'=> 'Frasco Vazio 5ml',
            'composicao'=> array()
        );
        return $frascos;
    }
}