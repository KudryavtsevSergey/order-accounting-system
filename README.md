# Order accounting system

```shell script
composer install
cp -a .env.example .env
```

Then configure .env file.

Two ways for installing:

# 1 Installing via docker

```shell script
sudo docker-compose build
sudo docker-compose up -d
sudo docker-compose exec fpm php artisan key:generate
sudo docker-compose exec fpm bash /tmp/init_db.sh
```

# 2 Or self installing

```shell script
php artisan key:generate
php artisan mysql:createdb
php artisan migrate
php artisan db:seed
```

## Commands for docker

### Order creation

```shell script
sudo docker-compose exec fpm php artisan accounting-system:create-order
```

### Upgrade order status

```shell script
sudo docker-compose exec fpm php artisan accounting-system:upgrade-order {order_id}
```

### Lower order status

```shell script
sudo docker-compose exec fpm php artisan accounting-system:lower-order {order_id}
```

## Commands for self installing

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

```shell script
curl -X POST -H "Accept: application/json" -H "Content-Type: application/json" --data '{"products":[{"product_id":1}, {"product_id":2}, {"product_id":3}]}' http://127.0.0.1/api/order
```

### Upgrade order status

```shell script
curl -X POST http://127.0.0.1/api/order/{order_id}/upgradeStatus
```

### Lower order status

```shell script
curl -X POST http://127.0.0.1/api/order/{order_id}/lowerStatus
```

## Run tests for docker

```shell script
sudo docker-compose exec fpm vendor/bin/phpunit
```

## Run tests for self installing

```shell script
vendor/bin/phpunit
```
