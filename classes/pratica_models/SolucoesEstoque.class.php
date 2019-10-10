<?php
/**
 * @author Wellerson
 */
class SolucoesEstoque{
    public function getDefaultItens(){
        $json = '[{
            "id": 1,
            "nome": "Sol. Estoque Ácida",
            "descricao": "Solução ácida utilizada como um modelo de solução",
            "tecnico": "Técnico CEAD",
            "intervalo": "3",
            "composicao": [{
                "id": "1",
                "nome": "Ácido Forte",
                "concentracao": "1"
            }],
            "estoque": true,
            "disponiveis": 5
        },
        {
            "id": 2,
            "nome": "Sol. Estoque Básica",
            "descricao": "Solução básica utilizada como um modelo de solução",
            "tecnico": "Técnico CEAD",
            "intervalo": "4",
            "composicao": [{
                "id": "2",
                "nome": "Base Forte",
                "concentracao": "1"
            }],
            "estoque": true,
            "disponiveis": 5
        },
        {
            "id": 3,
            "nome": "Sol. Branco p/ Espectrofotômetro",
            "descricao": "Solução utilizada como branco para medição no espectrofotômetro",
            "tecnico": "Técnico CEAD",
            "intervalo": "1",
            "composicao": [{
                "id": "102",
                "nome": "Branco",
                "concentracao": "0.0005"
            }],
            "estoque": true,
            "disponiveis": 5
        }]';
        return json_decode($json, true);
    }

    //parce form to array
    public function getJsonForm($dados){
       /* $bequers = array();
        foreach ($dados['cubeta_disponivel'] as $key => $value) {
          $bequers[] = array(
            'id' => $key+1,
            'disponivel' => $dados['cubeta_disponivel'][$key],
            'nome' => $dados['cubeta_nome'][$key],
            'qtd_maxima' => $dados['cubeta_qtd_maxima'][$key],
          );
        }
        return $bequers;
        */
    }
}