<?php

require_once "Database.php";

/**
 * Created by PhpStorm.
 * User: jscheq
 * Date: 20.03.17
 * Time: 13:06
 */
class Config
{
    // Хранит ассоциативный массив параметров и значений
    private static $params = array();

    /**
     * Config constructor.
     */
    function __construct()
    {
        // Создание инстанса для коннекта в БД
        $db = new SafeMySQL();

        // Получаем все параметры в виде ассоциативного массива [param] => val
        $data = $db->getIndCol("paramName", "SELECT paramName, paramValue FROM config");

        // Если получили, прописываем статическое свойство
        if( !empty( $data ) ) self::$params = $data;
    }

    /**
     * Возваращает параметр по имени $param
     *
     * @param $param
     * @return mixed
     */
    public static function getParam( $param )
    {
        return self::$params[$param];
    }

    /**
     * Возваращает массив параметров таблицы config
     * @return array
     */
    public static function getParams()
    {
        return self::$params;
    }

    /**
     * Устанавливает парметру $param значение $val
     *
     * @param $param
     * @param $val
     */
    public static function setParam( $param, $val )
    {
        self::$params[$param] = $val;
    }

    // Сохраняем все поля статического свойства $params в БД
    public static function save()
    {
        // Создание инстанса для коннекта в БД
        $db = new SafeMySQL();

        foreach ( self::$params as $p => $v)
        {
            $sql  = "INSERT INTO config SET paramName=?s, paramValue=?s";
            $db->query( $sql, $p , $v );
        }
    }
}