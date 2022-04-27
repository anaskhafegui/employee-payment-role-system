# Employee

This is an Employee system to help a company determine the dates they need to pay salaries to their departments.


* PHP version:- 8.1.5

* Laravel version:- 9.0


## Run the app in your machine: -

* clone the project and setup the env file

```bash

##Mac Os, Ubuntu and windows users continue here:
* Create a database locally named `root` utf8_general_ci 
* Download composer https://getcomposer.org/download/
* Pull Laravel/php project from git provider.
* Rename .env.example file to .env inside your project root and fill the database information.
  (windows wont let you do it, so you have to open your console cd your project root directory and run `mv .env.example .env` )
* Open the console and cd your project root directory
* Run composer install or php composer.phar install
* Run php artisan key:generate
* Run php artisan migrate
* Run php artisan serve


```

## How to run the test suite

```bash
./vendor/bin/phpunit
```
## How to check schedule payment reminder mail

```bash
php artisan schedule:test
```


## Endpoints

* GET Requests

```url
/getAllPayments
```

* POST Requests

```url
/changeBonusPercentage/{id}
/register
/login
```

## API Endpoints

### Default Path

```url
/api/admin/
```

#### GET /getAllPayments

Get all payments in all monthes, they can be filtered using month parameters

##### paramaters

month

##### Sample response

```json
[
    "Apr": {
        "month": "Apr",
        "Salaries_payment_day": 28,
        "Bouns_payment_day": 21,
        "Salaries_total": 2000,
        "Bonus_total": 600,
        "Payments_total": 2600
    },
    "May": {
        "month": "May",
        "Salaries_payment_day": 31,
        "Bouns_payment_day": 15,
        "Salaries_total": 2000,
        "Bonus_total": 600,
        "Payments_total": 2600
    },
]
```

### POST Endpoints

#### POST /changeBonusPercentage/{id}

Change bonus percentage for employee

##### Sample body request (required)

```json

{
    "percentages": 0.2,
}
```

##### Sample response

```json

{
    "status": 1,
    "message": "bouns percentages changed successfully",
    "data": {
        "name": "anas",
        "salary": "1000.00",
        "bouns_percentages": "0.2",
        "updated_at": "2022-04-27T00:06:25.000000Z"
    }
}
```

#### POST /register

Register new admin

##### Sample body request (required)

```json

{
    "name": "TestAdmin",
    "email": "admin2@test.com",
    "password": "12333",
    "password_confirmation": "12333",
}
```

##### Sample response

```json

{
    "status": 1,
    "message": "register successfully",
    "data": "secrest_token"
}
```
#### POST /login

Admin login

##### Sample body request (required)

```json

{
    "email": "Hello@test.com", 
    "password": "Hello", 
}
```

##### Sample response

```json

{
    "status": 1,
    "message": "Login successfully",
    "data": {
        "user": {
            "id": 2,
            "name": "anas",
            "email": "admin@gmail.com",
            "email_verified_at": null,
            "created_at": "2022-04-25T19:11:30.000000Z",
            "updated_at": "2022-04-25T19:11:30.000000Z"
        },
        "token": "10|9xu5lwzEdHOYDDhtmYBVwdjYQfqjwouRuk2rq7yw"
    }
}
```
