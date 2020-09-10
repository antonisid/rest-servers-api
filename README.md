## Installation
(through command line)

- git clone https://github.com/antonisid/rest-servers-api.git
- composer install
- copy the .env.example to .env file (cp .env.example .env)
- create a mysql DB and add the credentials to the following section of the .env file:<br><br>
    _DB_CONNECTION=mysql<br>
    DB_HOST=127.0.0.1<br>
    DB_PORT=3306<br>
    DB_DATABASE=leaseweb<br>
    DB_USERNAME=root<br>
    DB_PASSWORD=password<br>_

- php artisan migrate
- php artisan db:seed --class=ServerSeeder (seeds the DB from the csv file)
- php artisan jwt:secret
- php artisan serve (it serves the application on 127.0.0.1:8000)

*You can refresh the database with: php artisan migrate:fresh

Please refer to **Leaseweb.pdf** for more information.
