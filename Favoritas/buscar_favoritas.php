<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ritmex";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Falha na conexão com a base de dados: " . $conn->connect_error);
}

// Obter o id_Utilizador da sessão (supondo que você já tenha armazenado na sessão durante o login)
if (isset($_SESSION['user_id'])) {
    $id_Utilizador = $_SESSION['user_id'];

    // Consulta SQL para obter as músicas favoritadas pelo utilizador
    $sql = "SELECT f.id_Musica, m.titulo, a.nome_artista, m.duracao
            FROM musica m
            INNER JOIN favoritos f ON m.id_Musica = f.id_Musica
            INNER JOIN artistas a ON m.id_Artista = a.id_Artista
            WHERE f.id_Utilizador = $id_Utilizador";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Exibir todas as músicas favoritadas
        while ($row = $result->fetch_assoc()) {
            echo"<link rel='stylesheet' href=' favoritos.css'>";
            echo"<div style='color:white; font-size:17px;'>";
            echo "Título: " . $row["titulo"] . "<br>";
            echo"<br>";
            echo "Artista: " . $row["nome_artista"] . "<br>";
            echo"<br>";
            echo "Duração: " . segundosParaMinutosSegundos($row["duracao"]) . "<br>";
            echo"<br>";
            echo "</div>";
            // Botão de remoção com formulário
            echo "<form method='post' action='remover_favorita.php'>";
            echo "<input  type='hidden' name='id_Utilizador' value='$id_Utilizador'>";
            echo "<input type='hidden' name='id_Musica' value='" . $row["id_Musica"] . "'>";
            echo "<button type='submit'>Remover dos Favoritos</button>";
            echo "</form>";
            echo "<br>";
        }
    } else {
        echo "<p style='color:white;'>Nenhuma música favoritada encontrada.</p>";
    }
} else {
    echo "Sessão não iniciada ou 'user_id' não definido.";
}

$conn->close();

// Função para converter segundos em minutos e segundos
function segundosParaMinutosSegundos($segundos) {
    $minutos = floor($segundos / 60);
    $segundos = $segundos % 60;
    return sprintf('%02d:%02d', $minutos, $segundos);
}
?>
