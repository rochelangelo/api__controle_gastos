<?php

require_once('./common/Environment.php');

Enviroment::load('D:\wamp64\www\api__controle_gastos\api\v1');

$env = getenv();

class Carteira
{

    public function mostrar()
    {

        $host = getenv('DB_HOST');
        $user = getenv('DB_USER');
        $pass = getenv('DB_PASS');
        $dbName = getenv('DB_NAME');

        $con = new PDO("mysql: host={$host}; dbname={$dbName};", $user, $pass);

        $sql = 'SELECT * FROM carteira ORDER BY date ASC';
        $sql = $con->prepare($sql);
        $sql->execute();

        $resultados = array();

        while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
            $resultados[] = $row;
        }

        if (!$resultados) {
            throw new Exception("Nenhum registro na Carteira!");
        }
        return $resultados;
    }

    public function inserir(){
        $host = getenv('DB_HOST');
        $user = getenv('DB_USER');
        $pass = getenv('DB_PASS');
        $dbName = getenv('DB_NAME');

        $con = new PDO("mysql: host={$host}; dbname={$dbName};", $user, $pass);
    }
}
