# Backend Developer Test - Lumen 8 test action

#### 1. Membuat API CRUD menggunakan Lumen/Node.js/.net/Go dengan layanan MongoDB Atlas / MongoDB Local.
#### 2. Membuat API Login, Check Login, Destroy Token ( Logout ) menggunakan JWT dengan Lumen/Node.js/.net/Go.
#### 3.Membuat API CRUD menggunakan Lumen/Node.js/.net/Go dengan layanan Firebase Realtime Database / Firebase Firestore.
    setup .env field below
    FIREBASE_CREDENTIALS=
    FIREBASE_DATABASE_URL=
    
    api:
    hasil: http://your-domain/api/firebase (create, update, delete);
    hasil: http://your-domain/api/firebase/{id} (read);
#### 4. Membuat dockerfile (php 7.3 , sqlsrv driver , redis driver ( redis servernya tidak perlu, hanya driver nya saja) , driver mongodb , nginx web server ) untuk membuild Lumen.
     Ex: 
        - docker build . -t sera:1.0 
        - docker run -itdp 8000:80 -v `pwd`:/var/www/html --name serav1 sera:1.0
#### 5. Membuat Unit Test API CRUD menggunakan Lumen/Node.js/.net/Go berdasarkan yang sudah dibuat ( 3 api saja ).
    - cd /path/root/project && vendro/bin/phpunit
#### 6. Integrasi API dengan handle selain response success ( 200 / 400 )
        - Register
        (POST) https://reqres.in/api/register
        {
        "email": "eve.holt@reqres.in",
        "password": "pistol"
        }
        - Login
        (POST) https://reqres.in/api/login
        {
        "email": "eve.holt@reqres.in",
        "password": "cityslicka"
        }

#### 7. Filter object dibawah ini status->response->billdetails dengan denom >= 100000
        https://gist.github.com/Loetfi/fe38a350deeebeb6a92526f6762bd719
        output harus menjadi seperti index array seperti ini :
        Array
        (
        [0] => 100000
        [1] => 150000
        [2] => 200000
        )

        bukan seperti ini
        Array
        (
        [2] => 100000
        [3] => 150000
        [4] => 200000
        )
    hasil: http://your-domain/api/task-7
#### 8. Integrasi Lumen/Node.js/.net/Go yang sudah dikerjakan dengan Sentry.
    
    hasil: http://your-domain/api/debug-sentry
#### 9. Membuat dokumentasi API diatas menggunakan swagger. ex : darkaonline/l5-swagger atau darkaonline/swagger-lume.
    hasil: http://your-domain/api/documentation
#### 10. Integrasi Lumen/Node.js/.net/Go yang sudah dikerjakan dengan Mailgun.
    setup .env field below
    MAIL_MAILER=mailgun
    MAILGUN_DOMAIN=
    MAILGUN_SECRET=
    MAILGUN_ENDPOINT=

# Lumen PHP Framework

[![Build Status](https://travis-ci.org/laravel/lumen-framework.svg)](https://travis-ci.org/laravel/lumen-framework)
[![Total Downloads](https://img.shields.io/packagist/dt/laravel/framework)](https://packagist.org/packages/laravel/lumen-framework)
[![Latest Stable Version](https://img.shields.io/packagist/v/laravel/framework)](https://packagist.org/packages/laravel/lumen-framework)
[![License](https://img.shields.io/packagist/l/laravel/framework)](https://packagist.org/packages/laravel/lumen-framework)

Laravel Lumen is a stunningly fast PHP micro-framework for building web applications with expressive, elegant syntax. We believe development must be an enjoyable, creative experience to be truly fulfilling. Lumen attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as routing, database abstraction, queueing, and caching.

## Official Documentation

Documentation for the framework can be found on the [Lumen website](https://lumen.laravel.com/docs).

## Contributing

Thank you for considering contributing to Lumen! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Security Vulnerabilities

If you discover a security vulnerability within Lumen, please send an e-mail to Taylor Otwell at taylor@laravel.com. All security vulnerabilities will be promptly addressed.

## License

The Lumen framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
