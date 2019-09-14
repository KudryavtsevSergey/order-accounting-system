# Order accounting system

```shell script
php composer install
cp -a .env.example .env
php artisan key:generate
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
