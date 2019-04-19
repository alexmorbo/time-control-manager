
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

$dbUser = ''; // user
$dbPassword = ''; // pass
$dbHost = ''; // ip
$dbPort = ''; // port
$dbName = ''; // name

$baseConnect = new \TimeControlManager\BaseConnect($dbUser, $dbPassword, $dbHost, $dbPort, $dbName);
$tc = new \TimeControlManager\TimeControl($baseConnect);
```

# Методы

## Работа с пользователями

Для получения модели пользователя необходимо вызвать метод ```findOne``` модели ```User```

```php
$entity = \TimeControlManager\Entities\User::findOne(9);

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

Для получения модели группы пользователя необходимо вызвать метод ```findOne``` модели ```UserGroup```

```php
$entity = \TimeControlManager\Entities\UserGroup::findOne(1);

TimeControlManager\Entities\UserGroup {#7
  +"id": 1                  // Идентификатор в БД ТС
  +"name": "Администратор"  // Название группы
  +"comment": null          // Комментарий к группе
  +"code": "01"             // Текстовый код
  +"isDefault": 0           // по умолчанию при добавлении
}
```


## Работа с отделами

Для получения модели отдела пользователя необходимо вызвать метод ```findOne``` модели ```Department```

```php
$entity = \TimeControlManager\Entities\Department::findOne(2);

TimeControlManager\Entities\Department {#7
  +"id": 2                      // Идентификатор
  +"name": "Отдел снабжения"    // Название
  +"parentId": 0                // Корневое отд
  +"headId": 0                  // Руководитель отдела
  +"workStartTime": "00:00:00"  // Время начала работы отдела
  +"workEndTime": "00:00:00"    // Время конца работы отдела
  +"comment": ""                // Комментарий
  +"code": ""                   // Текстовый код
}
```


## Работа с проходными

Для получения модели проходной необходимо вызвать метод ```findOne``` модели ```Door```

```php
$entity = \TimeControlManager\Entities\Door::findOne(3);

TimeControlManager\Entities\Door {#6
  +"id": 3                          // Идентификатор
  +"useForWorkHours": 0             // Использовать проходную для учета рабочего времени
  +"defaultAccessDenied": null      // По умолчанию доступ закрыт
  +"name": "Склад - основной"       // Название
  +"useTimeIntervalAccess": null    // Использовать временной интервал доступа
  +"allowedAccessStart": null       // Начало разрешенного доступа
  +"allowedAccessEnd": null         // Конец интервала доступа
  +"department": null               // Подразделение связанное с проходной
  +"code": null                     // Текстовый код
  +"loadOnlyDepartmentUsers": null  // 1 - Загружать на устройства сотрудников только выбранного подразделения
  +"isDefault": null                // 1 - по умолчанию при регистрации прихода\ухода вручную
}
```


## Работа с справочниками

Для получения модели справочника необходимо вызвать метод ```findOne``` модели ```Directory```

```php
$entity = \TimeControlManager\Entities\Directory::findOne(1);

TimeControlManager\Entities\Directory {#6
  +"id": 1
  +"name": "DOLJNOST"
  +"title": "Справочник должностей"
  +"description": "Справочник должностей сотрудников"
  +"useSecondaryCode": null
  +"useSecondaryName": null
  +"useColor": null
  +"useCode": 1
  +"useDefault": null
  +"useIcon": null
  +"useRatio": null
}
```

Для получения списка данных по справочнику, например список должностей, нужно вызвать у этой модели метод ```getData()```

```php
$entity->getData();

array:11 [
  1 => TimeControlManager\Entities\DirectoryData {#7
    +"id": 1
    +"directoryId": 1
    +"value": "Руководитель склада"
    +"code": null
    +"secondaryCode": null
    +"secondaryValue": null
    +"color": null
    +"imageIndex": null
    +"defaultValue": null
    +"ratio": null
    +"pid": null
  }
  2 => TimeControlManager\Entities\DirectoryData {#8
    +"id": 2
    +"directoryId": 1
    +"value": "Кладовщик"
    +"code": null
    +"secondaryCode": null
    +"secondaryValue": null
    +"color": null
    +"imageIndex": null
    +"defaultValue": null
    +"ratio": null
    +"pid": null
  }
  ...
]
```


## Работа с событиями по проходным

Для получения модели проходной необходимо вызвать метод ```getEventsByPeriod``` модели ```Door```
Метод принимает 2 параметра:
- Дата начала выборки данных ```DateTime```
- Дата конца выборки данных ```DateTime```

```php
$start = new DateTime('-5 hour');  
$end = new DateTime('now');
$events = \TimeControlManager\Entities\UserDoorEvent::getEventsByPeriod($start, $end);

array:43 [
  3177 => TimeControlManager\Entities\UserDoorEvent {#8
    +"id": 3177
    +"userId": 10
    +"eventDateTime": "2019-04-04 07:04:00"
    +"doorId": 3
    +"method": 2
    +"enterType": 2
  }
  3178 => TimeControlManager\Entities\UserDoorEvent {#9
    +"id": 3178
    +"userId": 7
    +"eventDateTime": "2019-04-04 08:57:00"
    +"doorId": 4
    +"method": 2
    +"enterType": 1
  }
]
```