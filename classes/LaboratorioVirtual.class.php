<?php
/**
 * @author wellerson
 */
class LaboratorioVirtual{

    public function formatTolab($result){
        //tratando os dados
        $result = $this->tratarBaloes($result);
        $result = $this->tratarBequers($result);
        $result = $this->tratarMicropipetas($result);
        $result = $this->tratarPipetas($result);

        //formatacoes extras
        $result = $this->formatSolucoes($result);
        $result = $this->formatArmarioVidrarias($result);
        $result = $this->formatSubstancias($result);
        return $result;
    }

    private function formatSubstancias($resultado){
        $result = array();
        foreach ($resultado['substancias'] as $key => $value) {
            $result[] = array(
                "id" => (int) $value['id_substancia'],
                "nome" => $value['nome'],
                "dados" => json_decode($value['dados'], true)
            );
        }
        unset($resultado['substancias']);
        $resultado['elementos'] = $result;
        return $resultado;
    }

    private function tratarBaloes($result){
        $itens = $result['data']['baloes'];
        foreach($itens as $key=>$item){
            $itens[$key]['nome'] = 'Balão '.$item['tamanho'].'mL';
            $itens[$key]['conceito'] = 'balao';
        }
        $result['data']['baloes'] = $itens;
        return $result;
    }
    
    private function tratarBequers($result){
        $itens = $result['data']['bequers'];
        foreach($itens as $key=>$item){
            $itens[$key]['nome'] = 'Bequer '.$item['tamanho'].'mL';
            $itens[$key]['conceito'] = 'bequer';
        }
        $result['data']['bequers'] = $itens;
        return $result;
    }

    private function tratarMicropipetas($result){
        $itens = $result['data']['micropipetas'];
        foreach($itens as $key=>$item){
            $itens[$key]['nome'] = 'Micropipeta '.$item['nome'].'mL';
            $itens[$key]['tamanho'] = $item['nome'];
            $itens[$key]['conceito'] = 'micropipeta';
        }
        $result['data']['micropipetas'] = $itens;
        return $result;
    }

    private function tratarPipetas($result){
        $itens = $result['data']['pipeta_volumetrica'];
        foreach($itens as $key=>$item){
            $itens[$key]['nome'] = 'Pipeta '.$item['tamanho'].'mL';
            $itens[$key]['conceito'] = 'pipeta';
        }
        $result['data']['pipeta_volumetrica'] = $itens;
        return $result;
    }

    /**
     * formata os dados para a pratica
     */
    private function formatArmarioVidrarias($result){
        
        //baloes
        $result['data']['armario_vidrarias']['balao'] = $result['data']['baloes'];
        unset($result['data']['baloes']);

        //bequer
        $result['data']['armario_vidrarias']['bequer'] = $result['data']['bequers'];
        unset($result['data']['bequers']);
       
        //pipeta_volumetrica
        $result['data']['armario_vidrarias']['pipeta'] = $result['data']['pipeta_volumetrica'];
        unset($result['data']['pipeta_volumetrica']);
        
        //cubetas
        $result['data']['armario_vidrarias']['cubeta'] = $result['data']['cubetas'];
        unset($result['data']['cubetas']);
        
        //pipetadores
        $result['data']['armario_vidrarias']['pipetador'] = $result['data']['pipetadores'];
        unset($result['data']['pipetadores']);
        
        //micro pipeta
        $result['data']['armario_vidrarias']['micropipeta'] = $result['data']['micropipetas'];
        unset($result['data']['micropipetas']);

        return $result;
    }

    private function formatSolucoes($result){

        $solucoes = array();
        $solucoes_armario = array();
        foreach ($result['solucoes'] as $solucao) {
            $solucao_t = array(
                'composicao'=> json_decode($solucao['composicoes'], true),
                'descricao'=> $solucao['desc_moprsi'],
                'disponiveis'=> 5,
                'id'=>$solucao['cod_moprsi'],
                'intervalo'=> 3,
                'nome'=>$solucao['nome_moprsi'],
                'tecnico'=>$solucao['resp_moprsi']
            );

            if($solucao['armario_moprsi'] == 'S'){
                $solucoes_armario[] = $solucao_t;
            }else{
                $solucoes[] = $solucao_t;
            }
        }
        $result['data']['armario_solucoes'] = $solucoes_armario;
        $result['data']['solucoes'] = $solucoes;
        return $result;
    }

}
?>