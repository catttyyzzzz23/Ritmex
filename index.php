<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ritmex</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="../Fase_3/Imagens/logo2.png">

    <script src="https://kit.fontawesome.com/c9a361dd57.js" crossorigin="anonymous"></script>
</head>
<body>
    <header>
        <span>
                <img src="../Fase_3/Imagens/logo.png" alt="Logo" width="100px" height="100px">
            </span>
        <nav class="menu" id="nav">
            
            <span class="nav-item active">
                <span class="icon">
                    <i class="fa-solid fa-house"></i>
                </span>
                <a href="index.php">Home</a>
</span>
            <span class="nav-item">
                <span class="icon">
                    <i class="fa-solid fa-user"></i>
                </span>

                <?php

                    // Verifique se o utilizador está logado
                    if (isset($_SESSION['username'])) {
                        // Utilizador logado - exiba o dropdown do perfil
                        echo '<div class="dropdown">';
                        echo '<a href="#">Perfil</a>';
                        echo '<div class="dropdown-child">';
                        echo '<a href="../Fase_3/Perfis/perfil_utilizador.php">Editar Perfil</a>';  // Adicione um link de logout ou outras opções
                        echo '<a href="../Fase_3/Logout/logout.php">Logout</a>';  // Adicione um link de logout ou outras opções
                        echo '</div>';
                        echo '</div>';
                    } else {
                        // Usuário não autenticado - exiba links de login/registrar
                        echo '<div class="dropdown">';
                        echo' <a href="#">Perfil</a>';
                        echo '<div class="dropdown-child">';
                            echo '<a href="../Fase_3/Login/login.html" id="loginLink">Login</a>';
                            echo'<a href="../Fase_3/Registar/registar.html" id="signupLink">Sign Up</a>';
                        echo'</div>';
                        echo'</div>';
                    }
                ?>
            </span>
        </nav>
    </header>
    <section>
        <?php
            // Inclua o arquivo PHP que obtém e exibe as músicas
            include('musica.index.php');
        ?>
    </section>
</body>
</html>
