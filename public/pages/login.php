<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php
        include PATH_INCLUDES . 'head.php';
    ?>
</head>
<body>
    <main class="login">
        <form action="" method="post">
            <header>
                <figure>
                    <img src="<?= URL_ASSETS . 'img/logo/logo.png' ?>" alt="Logo">
                    <figcaption>PineAppleStorm</figcaption>
                </figure>
            </header>
            <section>
                <div>
                    <label for="usuario">Usuário</label>
                    <input type="text" name="usuario" id="usuario">
                </div>
                <div>
                    <label for="senha">Senha</label>
                    <input type="password" name="senha" id="senha">
                    <a href="">Esqueci minha senha</a>
                </div>
                <div>
                    <input type="submit" value="Entrar">
                    <input type="button" value="Cadastrar-se">
                </div>
            </section>
            <footer>
                <p>PineAppleStorm - Sistema Acadêmico - Faculdade de Americana (FAM)</p>
            </footer>
        </form>
    </main>
</body>
</html>