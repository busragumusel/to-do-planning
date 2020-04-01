## TO-DO PLANNING

First make sure you're using PHP 7.1 or higher and have Composer installed.

#### To make Composer install the project's dependencies into vendor, run: 
```
composer install
```

#### To create database, run:
```
 php bin/console doctrine:database:create
```

#### To make migrations, run:
```
 php bin/console doctrine:migrations:migrate
```


#### To save provider's data to DB, run:
```
php bin/console app:save-issue-list
```

#### To start the server, run:
```
php bin/console server:run
```
