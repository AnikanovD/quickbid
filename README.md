

<div align="center">
  <h1 align="center">💎 QuickBid 💎</h1>
</div>
    
![screenshot_auctions.png](https://github.com/AnikanovD/quickbid/blob/main/web/screenshot_auctions.png?raw=true)

Эта аукционная система QuickBid позволяет пользователям просматривать и участвовать в аукционах, а также просматривать историю ставок. 
Явно, этот проект был разработан с использованием современных технологий и фреймворков.

<div align="center">
  <p align="center">
    <br />
    <a href="https://github.com/AnikanovD/quickbid/blob/main/ChatGPT.md"><strong>Explore the domains via ChatGPT » </strong></a>
    <a href="https://github.com/AnikanovD/quickbid/blob/main/initial-assignment.txt"><strong>По мотивам тестового задания</strong></a>
    <br />
  </p>
</div>



## 🚀 Функционал

-   Вход без пароля, только по имени пользователя
-   Просмотр аукционов и участие в них
-   Просмотр истории ставок
-   Отображение баланса

## 🛠️ Технологии и инструменты

Проект QuickBid использует следующие технологии и инструменты:

-   Docker - для локальной разработки и развертывания приложения
-   PHP - основной язык программирования
-   Yii2 - фреймворк для написания серверной и клиентской частей приложения
-   MySQL - для хранения данных приложения
-   Redis - для хранения промежуточных результатов запросов и ускорения работы приложения
-   RabbitMQ - для обработки задач в фоновом режиме

## 💻 Установка и запуск

Следуйте этим шагам, чтобы установить и запустить QuickBid:

1.  Клонируйте репозиторий:

```
git clone https://github.com/AnikanovD/quickbid.git
``` 

2.  Перейдите в директорию с проектом, соберите и запустите Docker-контейнеры:

```
cd quickbid
docker-compose build
docker-compose up
``` 

3.  Откройте браузер и перейдите по адресу (http://localhost:8080). 

##### Вы должны увидеть домашнюю страницу QuickBid.
![localhost_8080_.png](https://github.com/AnikanovD/quickbid/blob/main/web/localhost_8080_.png?raw=true)

## 💾 Доступ к базе данных

Для доступа к базе данных QuickBid вы можете использовать PHPMyAdmin. 
Для входа используйте логин `quickbid` и пароль `quickbid`.
Он будет доступен по адресу (http://localhost:8081`). 

### Команды и миграции

Для запуска консольных команд и миграций в Docker-контейнере PHP выполните следующие действия:

1.  Подключитесь к контейнеру PHP:

`docker-compose exec php bash` 

2.  Выполните необходимую команду. Например:

```
./yii migrate/create create_user_table
./yii migrate/create create_auction_table
./yii migrate/create create_bid_table
./yii migrate/up
``` 

## 📁 Структура проекта

Структура проекта QuickBid включает в себя несколько директорий:

-   `commands/` - содержит консольные команды (воркер для обновления состояния аукционов);
-   `config/` - содержит конфигурации приложения;
-   `controllers/` - содержит файлы контроллеров (AuctionController и BidController);
-   `models/` - содержит классы моделей (User, Auction, Bid);
-   `migrations/` - содержит миграции;
-   `views/` - содержит файлы представлений;
-   `web/photo/` - содержит изображения для демо аукционов.


## docker-compose.yml

docker-compose.yml - файл, который содержит настройки и конфигурации для запуска Docker-контейнеров. В нем определены сервисы для PHP, MySQL, Redis, RabbitMQ и PHPMyAdmin, а также указаны порты, которые они используют.

```
version: '3'
services:
  php:
    image: yiisoftware/yii2-php:8.1-fpm-nginx
    volumes:
      - ~/.composer-docker/cache:/root/.composer/cache:delegated
      - ./:/app:delegated
    ports:
      - 8080:80

  mysql:
    image: mysql:latest
    environment:
      MYSQL_DATABASE: quickbid
      MYSQL_USER: quickbid
      MYSQL_PASSWORD: quickbid
      MYSQL_ROOT_PASSWORD: quickbid
    ports:
      - 3307:3306

  redis:
    image: redis:latest
    ports:
    - 6380:6379
    networks:
      net: {}

  rabbitmq:
    image: rabbitmq:latest
    ports:
    - 5673:5672
    networks:
      net: {}

  phpmyadmin:
    image: phpmyadmin/phpmyadmin
    ports:
        - 8081:80
    environment:
        - PMA_ARBITRARY=1
        - PMA_HOST=mysql
    depends_on:
        - mysql

networks:
  net:
    name: quickbid_net
```