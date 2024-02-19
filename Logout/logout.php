<?php
// Inicie a sessão
session_start();

// Encerre a sessão
session_destroy();

// Redirecione para a página de login ou outra página de sua escolha
header("Location: ../index.php");
exit();
?>
