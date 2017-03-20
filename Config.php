<?php

require_once "Query.php";

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
        /**
         * Ссылка на соединение с БД, можно было создать еще одну абстрацию вынеся этот возврат в метод данного
         * класса или создать вспомогательный класс с таким методом и наследовать его, но в данной задаче
         * такое решение не целесообразно. Не будем плодить абстрации.
         */
        $db = Query::getInstance()->getSafeMySQL();

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
        $db = Query::getInstance()->getSafeMySQL();

        foreach ( self::$params as $p => $v)
        {
            $sql  = "INSERT INTO config SET paramName=?s, paramValue=?s";
            $db->query( $sql, $p , $v );
        }
    }
}