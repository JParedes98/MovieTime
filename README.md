<p align="center"><a href="https://github.com/JParedes98" target="_blank">
    <img src="./public/logo.png" width="400"></a>
</p>

## About Movie Time

Movie time is a web application and API designed for stores looking to sell or rent movies, the application is part of the Applaudo Studios recruitment process.

Movie Time is developed with:

- Laravel Framework (PHP).
- Vue.Js.
- MYSQL.
- Bootstrap and BootstrapVue.

## Installing Movie Time
Before to start make sure [Xamp](https://www.apachefriends.org/es/index.html), [node.js](https://nodejs.org/es/) and [composer](https://getcomposer.org/) are installed in your pc.

1) Clone this Github Repository.
2) Run the command "composer install" inside the repository.
3) Run the command "npm install" inside the repository.
4) Create .env file inside the repository.
5) Define enviroment variables for connection to database, mailer provider (Check out the .env-example file).
6) Run the command "php artisan migrate" (Is optional get random data with command "php artisan migrate --seed").
7) Run the command "php artisan key:generate".
8) Run the command "php artisan jwt:secret"
9) Run the command "php artisan serve" and visit localhost:8000 on your browser.
10) Ready to go.


## License

The Movie Time App is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
