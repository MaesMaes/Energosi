<?php

require_once "Database.php";

/**
 * Created by PhpStorm.
 * User: jscheq
 * Date: 20.03.17
 * Time: 23:54
 */
class Query
{
    private static $_instance;
    private $safeMySQL;

    /**
     * Получаем экземпляр класса
     *
     * @return Query
     */
    public static function getInstance()
    {
        if(!self::$_instance)
        {
            // Если инстанса нет - создадим
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    private function __construct()
    {
        $this->safeMySQL = new SafeMySQL();
    }

    /**
     * Делаем клон пустым дабы предотвратить дублирование соединения
     */
    private function __clone() { }

    /**
     * Возвращаем соединение
     *
     * @return SafeMySQL
     */
    public function getSafeMySQL()
    {
        return $this->safeMySQL;
    }

}