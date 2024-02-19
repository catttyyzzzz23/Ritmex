<!DOCTYPE html>
<html>
<head>
    <title>Pesquisa de Utilizadores</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="icon" href="../Imagens/logo2.png">
    <script src="https://kit.fontawesome.com/c9a361dd57.js" crossorigin="anonymous"></script>
</head>
<body>

    <header>
        <span>
            <img src="../Imagens/logo.png" alt="Logo" width="100px" height="100px">
        </span>
        <nav class="menu" id="nav">
            <span class="nav-item active">
                <span class="icon">
                    <i class="fa-solid fa-house"></i>
                </span>
                <a href="../Login/index_artistas.php">Home</a>
            </span>
            <span class="nav-item">
                <span class="icon">
                    <i class="fa-solid fa-user"></i>
                </span>

                <?php
                    // Inicie a sessão para acessar variáveis de sessão
                    session_start();

                    // Verifique se o usuário está autenticado
                    if (isset($_SESSION['username'])) {
                        // Usuário autenticado - exiba o dropdown do perfil
                        echo '<div class="dropdown">';
                        echo '<a href="Perfis/perfil_utilizador.php">Perfil</a>';
                        echo '<div class="dropdown-child">';
                        echo '<a href="../Perfis/perfil_artista.php">Editar Perfil</a>';  // Adicione um link de logout ou outras opções
                        echo '<a href="../Logout/logout.php">Logout</a>';  // Adicione um link de logout ou outras opções
                        echo '</div>';
                        echo '</div>';
                    } else {
                        // Usuário não autenticado - exiba links de login/registrar
                        echo '<div class="dropdown">';
                        echo' <a href="#">Your Profile</a>';
                        echo '<div class="dropdown-child">';
                            echo '<a href="../Login/login.html" id="loginLink">Login</a>';
                            echo'<a href="../Registar/registar.html" id="signupLink">Sign Up</a>';
                        echo'</div>';
                        echo'</div>';
                    }
                ?>
            </span>
        </nav>
    </header>
    <center>
    <h2 style="color:white;">Pesquisar</h2>
    <form method="GET">
        <label style="color:white;"for="searchTerm">Pesquisa:</label><br>
        <input type="text" id="searchTerm" name="searchTerm"><br><br>

        <input type="radio" id="tipoUtilizadores" name="searchType" value="utilizadores" onclick="this.form.action='pesquisar_utilizadores.php'">
        <label style="color:white;"for="tipoUtilizadores">Utilizadores</label><br>

        <input type="radio" id="tipoArtistas" name="searchType" value="artistas" onclick="this.form.action='pesquisar_artistas.php'">
        <label style="color:white;"for="tipoArtistas">Artistas</label><br>

        <input type="radio" id="tipoMusicas" name="searchType" value="musicas" onclick="this.form.action='pesquisar_musicas.php'">
        <label style="color:white;"for="tipoMusicas">Musicas</label><br><br>

        <input style="display: inline-block;
    padding: 10px 20px;
    font-size: 16px;
    font-weight: bold;
    text-align: center;
    text-decoration: none;
    cursor: pointer;
    margin-top:30px;
    border: 2px solid grey;
    border-radius: 5px;
    color: black;
    background-color: white;
    transition: background-color 0.3s, color 0.3s;"type="submit" value="Pesquisar">
    </form>
    </center>
</body>
</html>
