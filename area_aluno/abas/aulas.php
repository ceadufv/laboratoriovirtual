<script type="text/javascript" src="js/abas/aulas.js"></script>    

<div class="row">
    <div class="col-md-12">
        <h3>
            <span>Práticas disponíveis</span>
        </h3>

        <div class="container">
            <table id="tabela" class="table table-striped table-bordered table-data" style="width:100%">
                <thead>
                    <tr>
                        <th>Nome da Prática</th>
                        <th>Resumo</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $objUsuario = new Usuario();
                        
                        // Lista as praticas disponiveis para o aluno
                        $dados = $objUsuario->getPraticasAluno($_SESSION['id_usuario']);

                        if(!empty($dados)) {
                            foreach($dados as $row) 
                            { ?>
                            <tr>
                                <td><?php echo $row['nome_pratica']?></td>
                                <td><?php echo $row['resumo']?></td>
                                <td><button class="btn btn-primary"><i class="fa fa-check-circle"></i> Realizar prática</button></td>
                                <td><button class="btn btn-success treino"><i class="fa fa-check-circle"></i> Treinar</button></td>
                            </tr>
                            <?php 
                            }
                        } else {
                            echo "Não há práticas disponíveis";
                        } 
                    ?>
                </tbody>
            </table>
            <input type="hidden" id="id_pratica" name="id_pratica" value="<?php echo $row['id'];?>">
        </div>
    </div>
</div>