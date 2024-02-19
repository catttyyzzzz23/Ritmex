<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <title>Página Artista</title>
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
                    <i class="fa-solid fa-magnifying-glass"></i>
                </span>
                <a href="../Pesquisar/pesquisar2.php">Pesquisar</a>
            </span>
            <span class="nav-item">
                <span class="icon">
                    <i class="fa-solid fa-upload"></i>
                </span>
                <a href="../Publicar_musicas/upload_musica.html">Adicionar músicas</a>
            </span>
            <span class="nav-item">
                <span class="icon">
                    <i class="fa-solid fa-user"></i>
                </span>

                <?php
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
    <h2 style="color:white;">Upload de Música</h2>
    <form action="upload_musica.php" method="post" enctype="multipart/form-data" style="color:white; font-size:20px;">
        <label for="titulo">Título:</label><br>
        <input type="text" id="titulo" name="titulo" required><br><br>

        <label for="artista">Artista:</label><br>
        <input type="text" id="artista" name="artista" required><br><br>

        <label for="duracao">Duração:</label><br>
        <input type="text" id="duracao" name="duracao" required><br><br>

        <label for="album">Álbum:</label><br>
        <input type="text" id="album" name="album"><br><br>

        <label for="genero">Género:</label><br>
        <input type="text" id="genero" name="genero" required><br><br>

        <label for="data_lancamento">Data de Lançamento:</label><br>
        <input type="text" id="data_lancamento" name="data_lancamento" required><br><br>

        <label for="caminho_mp3">Escolha a Música:</label><br>
        <input style="font-size:16px;" type="file" id="caminho_mp3" name="caminho_mp3" accept=".mp3" ><br><br>

        <input style="display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            text-decoration: none;
            cursor: pointer;
            margin-top: 10px;
            margin-bottom: 10px;
            border: 2px solid grey;
            border-radius: 5px;
            color: black;
            background-color: white;
            transition: background-color 0.3s, color 0.3s;" type="submit" value="Enviar Música">
    </form>
                </center>
</body>
</html>

