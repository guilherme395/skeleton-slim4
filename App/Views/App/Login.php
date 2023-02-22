<?php $this->layout("Layouts/Master", ["title" => $this->e($title)]); ?>

<style>
    .form-login {
        margin: 250px auto;
        max-width: 400px;
    }
</style>

<form action="/app/authUser" method="POST" class="form-login" autocomplete="off">
    <h2 class="text-center">Entrar Como User</h2>
    <div class="form-group">
        <label for="NomeUsuario">Usuário:</label>
        <input type="text" class="form-control" id="NomeUsuario" name="NomeUsuario" placeholder="Digite seu usuário">
    </div>
    <div class="form-group">
        <label for="SenhaUsuario">Senha:</label>
        <input type="password" class="form-control" id="SenhaUsuario" name="SenhaUsuario" placeholder="Digite sua senha">
    </div>
    <button type="submit" class="btn btn-primary btn-block">Entrar</button>
</form>