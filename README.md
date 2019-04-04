
# TimeControl Manager для time-control.ru

В блиблиотеке реализован минимальный функционал, который позволяет работать с:
- пользователями TC
- справочниками TC
- группами пользователей TC
- отделами TC
- проходными TC
- правами доступа TC
- событиями проходных TC

> TC - Time Control

## Требования

* Time-Control >= 4.6
* php >= 7.2
* ext-interbase (pdo_firebird)

## Установка

```shell
cd /path/to/project
composer require alexmorbo/time-control-manager
```

## Использование

Дня начала необходимо инициализировать библиотеку

```php
<?php
$config = [  
    'db' => [  
        'user' => 'DB_LOGIN',  
        'pass' => 'DB_PASS',  
        'host' => 'DB_HOST',  // ip
        'port' => 'DB_PORT',  // 3053
        'base' => 'DB_ALIAS', // timeserver
    ],  
];  
$tc = new \TimeControlManager\TimeControl($config);
```

# Методы

## Работа с пользователями

Для получения модели пользователя необходимо вызвать метод ```findOne``` модели ```User```

```php
$user = \TimeControlManager\Entities\User::findOne(9);

TimeControlManager\Entities\User {#6
  +"id": 9                            // Идентификатор в БД TC
  +"userGroup": 1                     // Группа
  +"surname": "Иванов"                // Фамилия
  +"name": "Иван"                     // Имя 
  +"patronymic": "Иванович"           // Отчество
  +"fullName": "Иванов Иван Иванович" // ФИО
  +"gender": 1                        // Пол
  +"externalId": "5ca5de99383a8"      // Внешний идентификатор
  +"departmentId": 2                  // Отдел
  +"positionId": 3                    // Должность
  +"accessCardNumber": "7213251"      // Карта доступа
  +"deviceId": 9                      // Идентификатор в БД ТС
}
```


## Работа с группами пользователя

Для получения модели пользователя необходимо вызвать метод ```findOne``` модели ```UserGroup```

```php
$user = \TimeControlManager\Entities\UserGroup::findOne(1);
```php
TimeControlManager\Entities\UserGroup {#7
  +"id": 1                  // Идентификатор в БД ТС
  +"name": "Администратор"  // Наименование группы
  +"comment": null          // Комментарий к группе
  +"code": "01"             // Числовой код
  +"isDefault": 0           // по умолчанию при добавлении
}
```