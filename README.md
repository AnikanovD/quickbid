# QuickBid

QuickBid - это простая аукционная система, позволяющая пользователям создавать и участвовать в аукционах. Система построена с использованием PHP, фреймворка Yii2, MySQL, Redis и RabbitMQ.

## Функционал

-   Создание аукционов и участие в них;
-   Упрощенная регистрация и вход только по имени пользователя;
-   Начисление приветственного бонуса в размере 1000 ₽ всем новым участникам.

### Установка и запуск

Следуйте этим шагам, чтобы установить и запустить QuickBid:

1.  Клонируйте репозиторий:

`git clone https://github.com/AnikanovD/quickbid.git` 

2.  Перейдите в директорию с проектом и соберите Docker-контейнеры:

`cd quickbid
docker-compose build` 

3.  Запустите Docker-контейнеры:

`docker-compose up` 

4.  Откройте браузер и перейдите по адресу `http://localhost:8080`. Вы должны увидеть домашнюю страницу QuickBid.

---

## Структура проекта

-   `commands/` - содержит консольные команды (контроллеры);
-   `config/` - содержит конфигурации приложения;
-   `controllers/` - содержит классы веб-контроллеров;
-   `models/` - содержит классы моделей;
-   `views/` - содержит файлы представлений для веб-приложения;
-   `web/photo/` - содержит изображения для демо аукционов

### Доступ к базе данных

Для доступа к базе данных QuickBid вы можете использовать PHPMyAdmin. Он будет доступен по адресу `http://localhost:8081`. Для входа используйте логин `quickbid` и пароль `quickbid`.

### Команды и миграции

Для запуска консольных команд и миграций в Docker-контейнере PHP выполните следующие действия:

1.  Подключитесь к контейнеру PHP:

`docker-compose exec php bash` 

2.  Выполните необходимую команду. Например:

`./yii migrate/create create_user_table
./yii migrate/create create_auction_table
./yii migrate/create create_bid_table
./yii migrate/up` 


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