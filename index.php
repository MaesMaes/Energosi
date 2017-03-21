<?
    require_once "classes/Config.php";

    // Инициализируем класс для работы с данными(запускаем конструктор), т.к. все свойства
    // и методы статические конкретный экземпляр нам не понадобиться. Интересно так вообще делают?)
    new Config();
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Config</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
<div class="container">
    <h1>Работа с классом Config</h1>
    <div class="test">
        <h2>Получаем все параметры</h2>
        <pre><? print_r( Config::getParams() ) ?></pre>
    </div>
    <div class="test">
        <h2>Получаем параметр <span>param1</span></h2>
        <pre><? print_r( Config::getParam( "param1" ) ) ?></pre>
    </div>
    <div class="test">
        <h2>Меняем значение <span>param1</span> на <span>12345</span> и выведем этот параметр</h2>
        <? Config::setParam( "param1", "12345" ); ?>
        <pre><? print_r( Config::getParam( "param1" ) ) ?></pre>
    </div>
    <div class="test">
        <h2>Добавим параметр <span>param7</span> со значением <span>sq-777</span> и выведем его</h2>
        <? Config::setParam( "param7", "sq-777" ); ?>
        <pre><? print_r( Config::getParam( "param7" ) ) ?></pre>
    </div>
    <div class="test">
        <h2>Сохраним изменения и выведем список параметров</h2>
        <? Config::save(); ?>
        <pre><? print_r( Config::getParams() ) ?></pre>
    </div>
</div>
</body>
</html>