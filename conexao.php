<?php

function novaConexao($banco = null)
{

    $server = "localhost:3306";
    $user = "root";
    $pass = "573068";

    try{
        $conn = new PDO('mysql:host=' . $server . ';dbname=' . $banco, $user, $pass);
        return $conn;
    }catch(Exception $e){
        die($e->getMessage());
        exit();
    }
    
}
