# checkoutKata

## What is implemented by me?

For this project i implemented a simple system of checkout, with the 3 rules defined: 
 - MealDeal promotion;
 - BuynGetOneFree promotion;
 - Multipriced promotion;

## project structure

the project is structured using concepts of clean architecture and SOLID, like: dependecy only too interfaces not implementations, separated layers for domain, repo and useCases and their adapters, thinking and how to scale in the future and easily change implementations.

#### Description of Folders
- **`adapter/`**: Contains implementations of the domain layer.
- **`business/`**: Represents the domain layer, where core business logic resides.
- **`common/`**: Holds common utilities, helper functions, or shared classes used across the application.
- **`providers/`**: Contains relations of interfaces and their concrete implementations, likely for dependency injection.
- **`strategies/`**: Holds various strategy classes that determine which promotion to apply based on the given context.


## how to run the project

#### 1.Install the PHP, Laravel and Docker
#### 2. Run the command `docker compose up -d` in the folder `backend/backend-app/app/docker`
- to run the docker instance datbase
#### 3. Run the folder `backend/backend-app` the command `compose install`
- Install the laravel dependencies

#### 4. Create a `.env` file with the credentials from .env.example
- Setup the database

#### 5. Run the command `php artisan migrate`
- Setup the database tables

#### 6. Run the command `php artisan php artisan db:seed --class=ProductsAndPromotionsSeeder`
- Setup the seeder, this will insert the promotions and the products

#### 7. Request the endpoint `http://127.0.0.1:8000/api/checkout/total` with the body 
```json
{
    "items": [
        {"sku": "A", "quantity": 3},
        {"sku": "B", "quantity": 3},
        {"sku": "C", "quantity": 5},
        {"sku": "D", "quantity": 2},
        {"sku": "E", "quantity": 2}
    ]
}
 ```
 and get the result
 ```json
{"total":16.18}
 ```

## whats can be better in this project?

#### 1. Implement a react UI;
#### 2. 100% of covereage ( only main useCases and controller are coverage)
#### 3. Split the logic off checkout service ( is too long )