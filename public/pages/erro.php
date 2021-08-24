<!DOCTYPE html>
<html lang="pt-br">
<head>
    
    <?php
        use app\helpers\inclusao;

        require_once PATH_INCLUDES . 'head.php';
        inclusao::css(['erro'])
    ?>
</head>
<body>
    <main class="erro">
       <header>
           <h1>ERRO 404</h1>
                <div >
                    <img src="<?= URL_ASSETS . 'img/erro/erro.png' ?>" alt = "erro" >
                    <p>URL não encontrada, retorne para a página inícial</p>
                    <div class ="btn-retornar"> 
                    <a href="<?= URL . 'login' ?>">Retornar</a>
                    </div>
                </div> 
        </header>       
    </main>
</html>
</body>
