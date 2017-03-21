<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/db/Query.php";

/**
 * Created by PhpStorm.
 * User: jscheq
 * Date: 20.03.17
 * Time: 13:06
 */
class Config
{
    // Хранит ассоциативный массив параметров и значений из БД
    private static $params = array();

    // Новые параметры для добавления в базу
    private static $paramsNew = array();

    // Параметры из БД которые изменили в ходе выполнения программы
    private static $paramsChange = array();

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
        // Если параметр есть в основном списке
        if( self::$params[$param] ) return self::$params[$param];

        // Новый параметр
        return self::$paramsNew[$param];
    }

    /**
     * Возваращает массив параметров таблицы config
     * @return array
     */
    public static function getParams()
    {
        return array_merge( self::$params, self::$paramsNew );
    }

    /**
     * Устанавливает парметру $param значение $val
     *
     * @param $param
     * @param $val
     */
    public static function setParam( $param, $val )
    {
        // Если параметр существует - запишем в обновленные, иначе запишем в новые
        if( self::$params[$param] )
        {
            // Это для update DB
            self::$paramsChange[$param] = $val;

            // Это для вывода пользователю
            self::$params[$param] = $val;
        }
        else
        {
            self::$paramsNew[$param] = $val;
        }
    }

    // Сохраняем все поля статических свойств $params и $paramsNew в БД
    public static function save()
    {
        // Создание инстанса для коннекта в БД
        $db = Query::getInstance()->getSafeMySQL();

        $start = microtime( true );

        // Добовляем товары в базу
        foreach ( self::$paramsNew as $p => $v )
        {
            $sql  = "INSERT INTO config SET paramName=?s, paramValue=?s";
            $db->query( $sql, $p , $v );
        }

        // Изменяем товары в базе
        foreach ( self::$paramsChange as $p => $v )
        {
            $sql = "UPDATE config SET paramValue=?s WHERE paramName=?s";
            $db->query( $sql, $v , $p );
        }

        // Получил 0.0025 сек. - в данном случае можно оставить
        echo 'Время выполнения метода save(): '.( microtime( true ) - $start ).' сек.';
    }
}