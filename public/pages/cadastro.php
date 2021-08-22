<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php

        use app\include\inclusao;

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
                <article>
                    <div>
                        <label for="nomeCompleto">Nome Completo:</label>
                        <input type="text" name="nomeCompleto" id="nomeCompleto">
                    </div>
                    <div>
                        <label for="dataNascimento">Data de Nascimento:</label>
                        <input type="date" name="dataNascimento" id="dataNascimento">
                    </div>
                    <a class="botao disable">Avançar</a>
                </article>
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