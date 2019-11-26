<?php
/**
 * @author Wellerson
 */
class Ponteira{
    public function getDefaultItens(){
        $ponteiras = array();
        $ponteiras[] = array(
            'disabled'=> 'N',
            'conceito'=>'ponteira',
            'disponivel'=>'S',
            'qtd_maxima'=> '4',
            'tamanho'=> '23',
            'id'=>977,
            'nome'=>'Ponteira',
            'descricao'=> 'Ponteira'
        );
        return $ponteiras;
    }
}