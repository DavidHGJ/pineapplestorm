<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php

        use app\helpers\inclusao;

        include PATH_INCLUDES . 'head.php';
        inclusao::css(['cadastro']);
    ?>
</head>
<body>
    <main class="cadastro">
        <form action="" method="post">
            <header>
                <figure>
                    <img src="<?= URL_ASSETS . 'img/logo/logo.png' ?>" alt="Logo">
                    <figcaption>PineAppleStorm</figcaption>
                </figure>
            </header>
            <section>
                <h3>Cadastro</h3>
                <article id="cadastro-parte-1">
                    <div>
                        <label for="nomeCompleto">Nome Completo:</label>
                        <input type="text" name="nomeCompleto" id="nomeCompleto" oninput="validarCampos(`#cadastro-parte-1`, `#botao-1`, `disable`)">
                    </div>
                    <div>
                        <label for="dataNascimento">Data de Nascimento:</label>
                        <input type="date" name="dataNascimento" id="dataNascimento" oninput="validarCampos(`#cadastro-parte-1`, `#botao-1`, `disable`)">
                    </div>
                    <a id="botao-1" class="botao disable" onclick="transicao(`#cadastro-parte-1`, `#cadastro-parte-2`)">Avançar</a>
                </article>
                <article id="cadastro-parte-2" style="display: none;">
                    <div>
                        <label for="usuario">Usuário:</label>
                        <input type="text" name="usuario" id="usuario" oninput="validarCampos(`#cadastro-parte-2`, `#botao-2`, `disable`)">
                    </div>
                    <div>
                        <label for="senha">Senha:</label>
                        <input type="password" name="senha" id="senha" minlength="8" oninput="validarCampos(`#cadastro-parte-2`, `#botao-2`, `disable`)">
                    </div>
                    <div>
                        <label for="senha-confirmacao">Confirme a senha:</label>
                        <input type="password" name="senhaConfirmacao" minlength="8" id="senha-confirmacao" oninput="validarCampos(`#cadastro-parte-2`, `#botao-2`, `disable`)">
                    </div>
                    <div class="botoes">
                        <a class="voltar" onclick="transicao(`#cadastro-parte-2`, `#cadastro-parte-1`)">Voltar</a>
                        <input id="botao-2" class="disable" type="submit" value="Cadastrar">
                    </div>
                </article>
                <p>Já tem conta? clique <a class="link" href="<?= URL . 'login' ?>">aqui</a></p>
            </section>
            <footer>
                <p>PineAppleStorm - Sistema Acadêmico - Faculdade de Americana (FAM)</p>
            </footer>
        </form>
    </main>
    <?php
        inclusao::js(['formularioCadastro']);
    ?>
</body>
</html>