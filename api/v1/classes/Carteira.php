<?php

use JetBrains\PhpStorm\Internal\ReturnTypeContract;

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

            $novaData = "";
            $array = explode('-', $row['date']);
            $novaData = $array[2].'/'.$array[1] .'/'.$array[0];

            $novoAmount = intval($row['amount']);

            $row['amount'] = $novoAmount;

            $row['date'] = $novaData;

            $resultados[] = $row;
        }

        if (!$resultados) {
            throw new Exception("Nenhum registro na Carteira!");
        }

        
        return $resultados;
    }

    public function inserir(){
        $data = $_POST;
        return Carteira::insert($data);
    }

    public static function insert($data){
        $host = getenv('DB_HOST');
        $user = getenv('DB_USER');
        $pass = getenv('DB_PASS');
        $dbName = getenv('DB_NAME');

        $con = new PDO("mysql: host={$host}; dbname={$dbName};", $user, $pass);

        $ndata = Carteira::novaData($data['date']);

        $sql = 'INSERT INTO carteira (description, amount, date) VALUES (:de, :am, :da)';
        $sql = $con->prepare($sql);
        $sql->bindValue(':de', $data['description']);
        $sql->bindValue(':am', intval($data['amount']));
        $sql->bindValue(':da', date($ndata));
        $sql->execute();

        if($sql->rowCount() > 0){
            return 'Dados inseridos com sucesso!';
        }else{
            throw new Exception("Falha ao inserir dados!");
        }
    }

    public static function novaData(string $data){
        $novaData = date("Y-m-d", strtotime(str_replace('/', '-', $data)));
        return $novaData;
    }
}
