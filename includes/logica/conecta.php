<?php
   try {
    $conexao = new PDO("pgsql:host=localhost; port=5432; dbname=TrabalhoF; user=postgres; password=postgres");
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
?>