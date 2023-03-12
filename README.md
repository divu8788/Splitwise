# Splitwise
Splitwise backend for brew.com

Splitwise Backend
This project implements a backend in Laravel for Splitwise (https://www.splitwise.com/), which is a web application that helps keep track of shared expenses and balances with groups of people.

Requirements
PHP 8.1 or later
Laravel 8.x
Composer
Setup
Clone this repository to your local machine:

git clone https://github.com/example/Splitwise.git


Install the dependencies using Composer:

cd Splitwise
composer install

Create a new .env file by copying the example file:

cp .env.example .env

php artisan key:generate


Configure your database settings in the .env file:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=splitwise
DB_USERNAME=root
DB_PASSWORD=


Run the database migrations to create the necessary tables:

php artisan migrate


The server should now be running at http://localhost:8000.

Usage
The following endpoints are available:

Create a user
Request:

POST /api/users
Content-Type: application/json

{
    "name": "John Doe"
}


Response:

HTTP/1.1 201 Created
Content-Type: application/json

{
    "id": 1,
    "name": "John Doe",
    "created_at": "2023-03-06T12:00:00.000000Z",
    "updated_at": "2023-03-06T12:00:00.000000Z"
}


Create a group
Request:

POST /api/groups
Content-Type: application/json

{
    "name": "Apartment 123"
}


Response:

HTTP/1.1 201 Created
Content-Type: application/json

{
    "id": 1,
    "name": "Apartment 123",
    "created_at": "2023-03-06T12:00:00.000000Z",
    "updated_at": "2023-03-06T12:00:00.000000Z"
}


Add user to group
Request:

POST /api/groups/1/users
Content-Type: application/json

{
    "user_id": 1
}


POST /api/groups/1/users
Content-Type: application/json

{
    "user_id": 1
}


Response:

HTTP/1.1 201 Created
Content-Type: application/json

{
    "group_id": 1,
    "user_id": 1,
    "created_at": "2023-03-06T12:00:00.000000Z",
    "updated_at": "2023-03-06T12:00:00.000000Z"
}


Add an expense to group
Request:

POST /api/groups/1/expenses
Content-Type: application/json

{
    "description": "Groceries",
    "total_amount": 50.00,
    "payer_id": 1,
    "split": [
        {"user_id": 1, "split_amount": 25.00},
        {"user_id": 2, "split_amount": 25.00}
    ]
}


HTTP/1.1 201 Created
Content-Type: application/json

{
    "id": 1,
    "description": "Groceries",
    "total_amount": 50.00,
    "payer_id": 1,
    "group_id": 1,
    "created_at": "2023-03-06T12:00:00.000000Z",
    "updated_at": "2023-03-06T12:00:00.000000Z"
}


List expenses of a group
Request:

GET /api/groups/1/expenses


HTTP/1.1 200 OK
Content-Type: application/json

[
    {
        "id": 1,
        "description": "Groceries",
        "total_amount": 50.00,
        "payer_id": 1,
        "group_id": 1,
        "created_at": "2023-03-06T12:00:00.000000Z",
        "updated_at": "2023-03-06T12:00:00.000000Z"
    }
]


List total group spending, total you paid for, and your total share
Request:

GET /api/groups/1/balance?user_id=1


HTTP/1.1 200 OK
Content-Type: application/json

{
    "total_spending": 50.00,
    "total_paid": 50.00,
    "total_share": 25.00
}


List balances
Request:

GET /api/groups/1/balances


Response:

HTTP/1.1 200 OK
Content-Type: application/json

[
    {
        "user_id": 1,
        "balance": -25.00
    },
    {
        "user_id": 2,
        "balance": 25.00
    }
]

