<?php
    $data = $_GET['list'];
    if ($data == '' or empty($data)) {
        header('Location: ./index.php');
    }
    require './config/dbconf.php';
    $sql = "INSERT INTO `tasks` (`task`) VALUES (:task)";
    $query = $pdo->prepare($sql);
    $query->execute([':task'=>$data]);
    header('Location: ./index.php');
    