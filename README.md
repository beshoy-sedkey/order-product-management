# E-commerce System
This repository houses a simplified e-commerce system implemented with Laravel, providing a RESTful API for managing products and orders. It focuses on key backend functionalities, including database design, API endpoint development, security, and testing.

## Features
- Register
- Login
- List Products
- Place Order
- Get Order By Id

## Requirements

- PHP >= 8.1
- Composer
- MySQL or any other database supported by Laravel
- Laravel >= 10.x
- Redis for cacheing
- Unit and Feature Testing

## Installation
Clone the repository and install dependencies:
```bash
git clone https://github.com/beshoy-sedkey/order-product-management
cd order-product-management
cp .env.example .env
```
- Database Configuration
```
DB_CONNECTION=mysql
DB_HOST=e-commerce-db
DB_PORT=3306
DB_DATABASE=e-commerce
DB_USERNAME=root
DB_PASSWORD=123456789
```

- Redis Configuration
```
REDIS_HOST=redis
REDIS_PASSWORD=null
REDIS_PORT=6379
CACHE_DRIVER=redis
QUEUE_CONNECTION=redis
SESSION_DRIVER=redis

```
## RUN Docker
```bash
docker-compose build --up -d 
```

## Runing Test
```bash
RUN docker ps (select the CONTAINER ID for auth service)
RUN docker exec -ti --user root (container_id) /bin/bash
RUN php artisan test
```


## API Reference

#### Register

```http
  POST /api/register
```

| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `name` | `string` | **Required** |
| `email` | `string` | **Required**|**Unique**| 
| `password` | `string` | **Required**|

#### Login

```http
  Post /api/Login
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `email` | `string` | **Required**| 
| `password` | `string` | **Required**|


#### Get Products

```http
  GET /api/products
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `name` | `string` | **Required**| 
| `price` | `float` | **Required**| 

#### Get Order By Id

```http
  GET /api/products/{orderId}
```
#### Place Order

```http
  Post /api/orders
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `products` | `json` | **Required**| 
| `products.id` | `integer` | **Required**|
| `products.quantity` | `integer` | **Required**|

