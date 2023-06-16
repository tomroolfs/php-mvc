# PHP MVC

This is a simple PHP MVC framework. It is not meant to be used in production, but rather as a learning tool for those who are interested in learning how to build a simple MVC framework. It builds on the concepts of the [Laravel framework](https://laravel.com/). It uses the [Twig template engine](https://twig.symfony.com/) for rendering views. It uses [Composer](https://getcomposer.org/) for autoloading classes and [PHPUnit](https://phpunit.de/) for testing. As front-end it uses [Vite](https://vitejs.dev/) and [Sass](https://sass-lang.com/).

## Installation

1. Clone the repository
2. Run `composer install`
3. Run `npm install`
4. Copy `.env.example` to `.env` and fill in the database credentials
5. Run `npm run vite:build` to make a fallback if vite dev server doesnt start
6. Run `npm run dev` if you are on a unix system or `npm vite:dev` and in a separate terminal `npm serve:dev` if you are on Windows

## Usage

- Run `npm run dev` if you are on a unix system or `npm vite:dev` and in a separate terminal `npm serve:dev` if you are on Windows
- Go to `localhost:3000` in your browser

## Tutorial

1. Make sure you have PHP, Composer, Node.js and NPM installed
2. Follow the installation instructions
3. Make a new file in the `app/Controllers` folder called `Tutorial.php`
4. Add the following code to the file:

    ```php
    <?php

    namespace App\Controllers;

    use App\Core\Controller;

    class Tutorial extends Controller
    {
        public function index()
        {
            $this->view('tutorial/index');
        }
    }
    ```

5. Make a new file in the `resources/views` folder called `tutorial/index.twig`
6. Add the following code to the file:

    ```twig
    {% extends 'layouts/base.twig' %}

    {% block body %}
        <h1>Hello World!</h1>
    {% endblock %}
    ```

7. Go to `localhost:3000/tutorial` in your browser
