# Order accounting system

## Create .env

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=order_accounting_system
DB_USERNAME=root
DB_PASSWORD=
```

## Database initialization

```shell script
php artisan mysql:createdb
php artisan migrate
php artisan db:seed
```

## Commands

### Order creation

```shell script
php artisan accounting-system:create-order
```

### Upgrade order status

```shell script
php artisan accounting-system:upgrade-order {order_id}
```

### Lower order status

```shell script
php artisan accounting-system:lower-order {order_id}
```

## Rest api

### Order creation

```
post /api/order
```

### Upgrade order status

```
post /api/order/{order_id}/upgradeStatus
```

### Lower order status

```
post /api/order/{order_id}/lowerStatus
```

## Run tests

```shell script
vendor/bin/phpunit
```
