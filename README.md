# QuickBid

Это аукционная система QuickBid позволяет пользователям участвовать в аукционах, а также просматривать историю ставок. Явно, этот проект был разработан с использованием современных технологий и фреймворков, таких как Docker, PHP, Yii2, MySQL, Redis и RabbitMQ.

## Функционал

-   Вход без пароля, только по имени пользователя;
-   Просмотр аукционов и участие в них;
-   Просмотр истории ставок.

## Установка и запуск

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

Вы должны увидеть домашнюю страницу QuickBid.

## Доступ к базе данных

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

## Структура проекта

-   `commands/` - содержит консольные команды (воркер для обновления состояния аукционов);
-   `config/` - содержит конфигурации приложения;
-   `controllers/AuctionController.php` - список аукционов, просмотр аукциона и истории ставок, совершение ставки;
-   `controllers/BidController` - мои ставки;
-   `models/` - содержит классы моделей;
-   `models/User.php` - модель пользователя (username, balance);
-   `models/Auction.php` - модель аукциона (name, photo, description, start_time, end_time, bid_step, starting_bid, current_bid, state, created_at, updated_at);
-   `models/Bid.php` - модель ставки (auction_id, user_id, amount, created_at);
-   `migrations/` - миграции ;
-   `views/` - содержит файлы представлений ;
-   `web/photo/` - содержит изображения для демо аукционов


## docker-composer.yml
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