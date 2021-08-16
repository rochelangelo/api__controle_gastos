<?php

class Enviroment{

    /**
     * @param string $dir caminho absoluto da pasta do arquivo .env
     */
    public static function load($dir){
        if(!file_exists($dir.'/.env')){
            return false;
        }

        $lines = file($dir.'/.env');
        foreach($lines as $line){
            putenv(trim($line));
        }
    }
}