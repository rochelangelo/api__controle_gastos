<?php

class Carteira
{
    public function mostrar()
    {
        $con = new PDO('mysql: host=localhost; dbname=controle_gastos;', 'root', '');

        $sql = 'SELECT * FROM carteira ORDER BY date ASC';
        $sql = $con->prepare($sql);
        $sql->execute();

        $resultados = array();

        while($row = $sql->fetch(PDO::FETCH_ASSOC)) {
            $resultados[] = $row;
        }

        if (!$resultados) {
            throw new Exception("Nenhum registro na Carteira!");
        }
        return $resultados;
    }
}
