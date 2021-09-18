<?php

/**
 *## Classe de ajuda responsavel por filtrar dados
 *
 * @DavidHGJ 
 */
class Filtro {

    private static $caracteresEspeciais = ['\'', '"', '^', '~', '´', '`', '\\', '*'];

    /**
     *## Método valida o tipo de dado e remove caracteres invalidos. 
     *
     * @param $tipo
     *      Espera-se o tipo de dado que você esta querendo validar.
     */
    public static function validarDado($dado, String $tipo) {
        try {
            switch (strtolower($tipo)) {
                case 'string':
                    if (is_string($dado))
                        return trim(str_replace(static::$caracteresEspeciais, '', $dado));
                    else 
                        throw new Exception('Tipo da variável invalido, é esperado string', '1');
                break;

                case 'int':
                    if (is_numeric($dado))
                        return intval($dado);
                    else
                        throw new Exception('Tipo da variável invalido, é esperado int', '2');
                break;

                case 'float':
                    if (is_numeric($dado))
                        return floatval($dado);
                    else
                        throw new Exception('Tipo da variável invalido, é esperado float', '2');
                break;

                case 'array':
                    if (is_array($dado))
                        return $dado;
                    else 
                        throw new Exception('Tipo da variável invalido, é esperado array', '4');
                break;

                case 'boolean':
                    if (is_bool($dado))
                        return $dado;
                    else 
                        throw new Exception('Tipo da variável invalido, é esperado boolean', '5');
                break;
            }
        }
        catch (Exception $erro) {
            header('Content-type: application/json');
            echo json_encode(['error' => true, 'message' => $erro->getMessage(), 'code' => $erro->getCode()]);
            exit;
        }
    }
}