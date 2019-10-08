<script type="text/javascript" src="js/abas/perfil.js"></script>
<div class="container">
  <div class="row">
    <div class="col-md-12 meuperfil">
      <h3>Meu perfil</h3>
      <h4>Aqui é possível atualizar os dados da sua conta</h4>
      <div id="dados" class="dados">
        <form>
          <div class="form-row">
            <div class="col-md-4 mb-3">
              <label for="validationDefault01">Nome</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="far fa-user"></i></span>
                </div>
                <input id="nome_novo" class="form-control" type="text" value="<?php echo ($_SESSION['nome']); ?>">
              </div>
            </div>
            <div class="w-100"></div>
            <div class="col-md-4 mb-3">
              <label for="validationDefaultUsername">Senha</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-key"></i></span>
                </div>
                <input id="senha1" class="form-control" type="password" placeholder="Digite aqui..." required>
              </div>
            </div>
            <div class="col-md-4 mb-3">
              <label for="validationDefaultUsername">Confirme sua senha</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-key"></i></span>
                </div>
                <input id="senha2" class="form-control" type="password" placeholder="Digite aqui..." required>
              </div>
            </div>
            <div class="w-100"></div>
            <div class="col-md-4 mb-3">
              <label for="validationDefaultUsername">E-mail</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="far fa-envelope"></i></span>
                </div>
                <input required id="email_novo" class="form-control" type="email" value="<?php echo $_SESSION['email']; ?>">
              </div>
            </div>
          </div>
          <button id="salvar" type="button" class="btn btn-primary atualizar">Salvar</button>
        </form>
      </div>
    </div>
  </div>
</div>