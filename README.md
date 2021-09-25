Тестовое задание:
```
Задачи:

Вы имеете две сущности: Категория, Товар с следующими полями:

Category:
id (int)
title (string length min: 3, max 12)
eId (int|null)

Product:
id (int)
categories (связь: ManyToMany)
title (string length min: 3, max 12)
price (float range min: 0, max 200)
eId (int|null)

*eId – произвольный id из любой другой системы

Вам необходимо реализовать консольную команду, которая читает два нижеприведенных файла Json и добавляет/обновляет записи в БД:

- файл categories.json имеет не более 100 строк
- файл products.json имеет ~ 3млн. строк
- учесть валидацию данных

categories.json:
[
{"eId": 1, "title": "Category 1"},
{ "eId": 2,"title": "Category 2"},
{ "eId": 2,"title": "Category 33333333"},
... + ~ 100 rows
]

products.json
[
{"eId": 1, "title": "Product 1", "price": 101.01, "categoriesEId": [1,2]},
{"eId": 2, "title": "Product 2", "price": 199.01, "categoryEId": [2,3]},
{"eId": 3, "title": "Product 33333333", "price": 999.01, "categoryEId": [3,1]},
... + ~ 3000000 rows
]

```

### Комментарий
В основе использовал части symfony, nette для работы с БД вместо ORM,
и maxakawizard/json-collection-parser - это потоковый JSON ридер,
можно было и самому наколхозить через генераторы, но не вижу смысла.
Все обернуто в докер. 

В постановке задачи меня смутило совпадение идентификаторов eId в категории, 
поэтому я не стал рассчитывать на поле eId как на uid. И упростил логику без
многочисленных проверок и связей. Засунул в data тестовые данные - не хорошо понимаю.

Тут много чего не хватает, к примеру инсертов с мультивставками, нормальные транзакции,
кешера при импорте категорий, чтобы сократить кол-во обращений к БД, правильной валидации,
логеров ошибок, метрик, да и вообще изначальных условий, нет тестов, но в целом получилось близко к MVP.

### Установка

```shell
composer install
cp .env_dev .env
chmod +x start.sh
chmod +x stop.sh
chmod +x stop.sh
./start.sh
```

### Запуск с тестовыми данными
```shell
chmod +x import.sh
```

Запуск из докера
Сначала ложим файлики в `/var/www/data`
```shell
php /var/www/bin/console import data/categories.json data/products.json
```