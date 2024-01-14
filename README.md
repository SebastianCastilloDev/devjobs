# Devjobs
Proyecto formativo para practicar con laravel.

# Autenticacion con Laravel

Existen varios paquetes para manejar la autenticación.

## Breeze

Es un paquete de laravel para manejar la autenticacion de nuestras aplicaciones, incluye todas las funcionalidades.

Está hecho con Blade y tailwindcss.

https://laravel.com/docs/10.x/starter-kits#laravel-breeze

## Fortify

Fortify es un paque de auth para frontend. No se limita solo a laravel, se puede utilizar en cualquier frontend.

* Permite autenticacion de dos factores.
* No incluye interfaz de usuario.
* Utiliza los endpoints de breeze.

## Sanctum

Esta diseñado para ser utilizado con SPA's

* Utiliza los endpoints de breeze.
* Añade nuevos endpoints para almacenar y generar Tokens que permitan el acceso al backend de Laravel.
* Se puede utilizar junto con fortify.

Por ejemplo podemos crear una tienda virtual en Laravel, frontend en nextjs y una app mobile hecho en flutter.

## Jetstream

Es una interfaz completa ideal para ser utilizada como el inicio de una aplicación de laravel.

* Esta hecha con tailwindcss.
* Se puede utilizar junto a Inertia o Livewire.
* Utiliza Inertia o Livewire
* Utiliza Sanctum e incluye todas las funcionalidades necesarias para hacer un login.

**NOTA: En este proyecto utilizaremos Laravel Breeze**

# Instalando Laravel Breeze

Para descargar:
`sail composer require laravel/breeze --dev`

Para instalarlo en nuestro proyecto:
`sail artisan breeze:install`
luego seleccionamos las opciones que instalaremos

```
(base) sebastiancastillo@Sebastians-iMac devjobs % sail artisan breeze:install

 ┌ Which Breeze stack would you like to install? ───────────────┐
 │ Blade with Alpine                                            │
 └──────────────────────────────────────────────────────────────┘

 ┌ Would you like dark mode support? ───────────────────────────┐
 │ Yes                                                          │
 └──────────────────────────────────────────────────────────────┘

 ┌ Which testing framework do you prefer? ──────────────────────┐
 │ PHPUnit                                                      │
 └──────────────────────────────────────────────────────────────┘
 ```
Tambien debemos estar ejecutando nuestro frontend con:

`sail npm run dev`

Al visitar `http://localhost/login` podremos ver nuestra ventana de inicio de sesion.

![login breeze](./readmeimg/Captura%20de%20pantalla%202024-01-12%20a%20la(s)%2014.01.01.png)

Al ejecutar `sail artisan route:list`

podemos ver que se han generado nuevas rutas:

```php
  GET|HEAD  / ................................................................................................................... 
  POST      _ignition/execute-solution ............ ignition.executeSolution › Spatie\LaravelIgnition › ExecuteSolutionController
  GET|HEAD  _ignition/health-check ........................ ignition.healthCheck › Spatie\LaravelIgnition › HealthCheckController
  POST      _ignition/update-config ..................... ignition.updateConfig › Spatie\LaravelIgnition › UpdateConfigController
  GET|HEAD  api/user ............................................................................................................ 
  GET|HEAD  confirm-password ......................................... password.confirm › Auth\ConfirmablePasswordController@show
  POST      confirm-password ........................................................... Auth\ConfirmablePasswordController@store
  GET|HEAD  dashboard ................................................................................................. dashboard
  POST      email/verification-notification .............. verification.send › Auth\EmailVerificationNotificationController@store
  GET|HEAD  forgot-password .......................................... password.request › Auth\PasswordResetLinkController@create
  POST      forgot-password ............................................. password.email › Auth\PasswordResetLinkController@store
  GET|HEAD  login ............................................................ login › Auth\AuthenticatedSessionController@create
  POST      login ..................................................................... Auth\AuthenticatedSessionController@store
  POST      logout ......................................................... logout › Auth\AuthenticatedSessionController@destroy
  PUT       password ........................................................... password.update › Auth\PasswordController@update
  GET|HEAD  profile ....................................................................... profile.edit › ProfileController@edit
  PATCH     profile ................................................................... profile.update › ProfileController@update
  DELETE    profile ................................................................. profile.destroy › ProfileController@destroy
  GET|HEAD  register ............................................................ register › Auth\RegisteredUserController@create
  POST      register ........................................................................ Auth\RegisteredUserController@store
  POST      reset-password .................................................... password.store › Auth\NewPasswordController@store
  GET|HEAD  reset-password/{token} ........................................... password.reset › Auth\NewPasswordController@create
  GET|HEAD  sanctum/csrf-cookie ............................... sanctum.csrf-cookie › Laravel\Sanctum › CsrfCookieController@show
  GET|HEAD  verify-email ........................................... verification.notice › Auth\EmailVerificationPromptController
  GET|HEAD  verify-email/{id}/{hash} ........................................... verification.verify › Auth\VerifyEmailController
```

Finalmente ejecutamos las migraciones que se han creado.

`sail artisan migrate`

## Cambiando los mensajes de error a español

clonamos el repo con: (recordar eliminar "es" de la ruta)
`git clone https://github.com/MarcoGomesr/laravel-validation-en-espanol.git resources/lang`

## Modificando el login

Aprovecharemos de crear un componente extra para enlaces, de esta forma, lo podremos reutilizar en otras partes de la aplicación. Para este fin, crearemos un componente a través de artisan.

`sail artisan make:component Link`

Esto nos creará el archivo `link.blade.php` dentro de la carpeta `resources/views/components`.

Para llamarlo dentro de nuestro archivo `login.blade.php` utilizaremos la notacion de componentes haciendo mencion al nombre del componente. Utilizaremos un slot para dotarlo de mayor funcionalidad.

```html
<x-link>
  ¿Olvidaste tu password?
</x-link>
```


