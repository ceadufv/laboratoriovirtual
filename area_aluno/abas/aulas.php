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
                        <th>Disciplina</th>
                        <th>Nome da Prática</th>
                        <th>Resumo</th>
                        <th>Ações</th>
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
                                <td><?php echo $row['nome']?></td>
                                <td><?php echo $row['nome_pratica']?></td>
                                <td><?php echo $row['resumo']?></td>
                                <td>
                                    <a class="btn btn-success" href="<?php echo URL_SITE; ?>area_laboratorio/lab.php?id_pratica=<?php echo $pratica['id_modelo_pratica'] ?>&tipo_acesso=salvar"><i class="far fa-eye"></i> Realizar Prática</a>
                                    <a class="btn btn-primary" href="<?php echo URL_SITE; ?>area_laboratorio/lab.php?id_pratica=<?php echo $pratica['id_modelo_pratica'] ?>&tipo_acesso=treino"><i class="far fa-eye"></i> Treinar</a>
                                </td>
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