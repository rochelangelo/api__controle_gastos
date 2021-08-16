<?php

header('Content-Type: application/json; charset=utf-8');

require_once 'classes/Carteira.php';


class Rest
{
    public static function open($req)
    {
        $url = explode('/', $req['url']);
        $classe = ucfirst($url[0]);
        array_shift($url);

        $metodo = $url[0];
        array_shift($url);

        $parametros = array();
        $parametros = $url;

        try{
            if (class_exists($classe)) {
                if (method_exists($classe, $metodo)) {
                    $retorno = call_user_func_array(array(new $classe, $metodo), $parametros);
    
                    return json_encode(array('status' => 'sucesso', 'dados' => $retorno));
                } else {
                    return json_encode(array('status' => 'erro', 'dados' => 'Metodo requisitado, INEXISTENTE!'));
                }
            } else {
                return json_encode(array('status' => 'erro', 'dados' => 'Classe requisitada, INEXISTENTE!'));
            }
        }catch (Exception $e){
            return json_encode(array('status' => 'erro', 'dados' => $e->getMessage()));
        }
        
    }
}

if (isset($_REQUEST)) {
    echo Rest::open($_REQUEST);
}
