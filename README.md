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

## Registrando una cuenta

Ingresamos a `/register`

Breeze por defecto nos registra automáticamente y nos lleva al panel de dashboard. 
Si revisamos la base de datos, podremos ver que existe un campo que registra cuando se verificó la cuenta, `email_verified_at` y aparece como NULL. tal como se puede ver en la siguiente salida de MySQL.

```
mysql> select * from users;
+----+-----------+-------------------+-------------------+--------------------------------------------------------------+----------------+---------------------+---------------------+
| id | name      | email             | email_verified_at | password                                                     | remember_token | created_at          | updated_at          |
+----+-----------+-------------------+-------------------+--------------------------------------------------------------+----------------+---------------------+---------------------+
|  1 | sebastian | correo@correo.com | NULL              | $2y$12$DG9AyadShuiWyYqOmycYJOlxVgDsECNGA1b./PjfBPuQjQMUFet1S | NULL           | 2024-01-14 12:43:49 | 2024-01-14 12:43:49 |
+----+-----------+-------------------+-------------------+--------------------------------------------------------------+----------------+---------------------+---------------------+
1 row in set (0.00 sec)

```

Podemos forzar al usuario a confirmar su cuenta. Para ello modificaremos la ruta /dashboard en el archivo web.php, agregando la opcion 'verified' al arreglo. 
Adicionalmente debemos implementar la interfaz MustVerifyEmail en el modelo de User

```php
class User extends Authenticatable implements MustVerifyEmail
```

Al recargar la ruta `/dashboard` nos va a llevar a la ruta `/verify-email`.

Breeze utiliza las siguientes variables de entorno:

```php
MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

En Docker podremos ver que el servicio de mailpit esta activo. Es decir en local ya podemos enviar email.
![mailpit](/readmeimg/Captura%20de%20pantalla%202024-01-14%20a%20la(s)%2010.03.08.png)

En el navegador accederemos al puerto 8025, para acceder al cliente de correo

![mailpit](/readmeimg/Captura%20de%20pantalla%202024-01-14%20a%20la(s)%2010.11.17.png)

Haremos click en el enlace de correo para verificar el email. Al consultar la tabla users, obtendremos el siguiente resultado:
```
mysql> select * from users;
+----+-----------+-------------------+---------------------+--------------------------------------------------------------+----------------+---------------------+---------------------+
| id | name      | email             | email_verified_at   | password                                                     | remember_token | created_at          | updated_at          |
+----+-----------+-------------------+---------------------+--------------------------------------------------------------+----------------+---------------------+---------------------+
|  1 | sebastian | correo@correo.com | 2024-01-14 13:12:35 | $2y$12$DG9AyadShuiWyYqOmycYJOlxVgDsECNGA1b./PjfBPuQjQMUFet1S | NULL           | 2024-01-14 12:43:49 | 2024-01-14 13:12:35 |
+----+-----------+-------------------+---------------------+--------------------------------------------------------------+----------------+---------------------+---------------------+
```

En donde podremos apreciar que se ha completado el campo `email_verified_at` 

### Modificando el mensaje de envío de correo de confirmación.

En nuestro archivo `verify-email.blade.php` Podremos modificar nuestros mensajes. En este caso lo reescribiremos en español.

### Modificando el correo de confirmación.

Para modificar el correo de confirmación vamos a abrir el archivo `AuthServiceProvider.php`. En esta clase se encuentra el método `boot`, el cual se llama cuando el usuario presiona en el boton de envio de correo electronico. 

modificaremos nuestro metodo boot de la siguiente manera:

```php
 public function boot(): void
    {
        $this->registerPolicies();
        VerifyEmail::toMailUsing(function($notifiable, $url) {
            return (new MailMessage)
                ->subject('Verificar dirección de correo electrónico')
                ->line('Presiona en el botón para verificar tu dirección de correo electrónico.')
                ->action('Verificar dirección de correo electrónico', $url)
                ->line('Si no creaste una cuenta, no es necesario realizar ninguna acción.');
        });
    }
```

### Creando una migracion para agregar la columna rol en la tabla usuarios.

`sail artisan make:migration add_rol_to_users_table`

Nuestra migracion quedará de la siguiente forma:

```php
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('rol'); //1=dev, 2=recruiter
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('rol');
        });
    }
};
```

Ahora ejecutamos  `sail artisan migrate` para agregar la columna rol

Al consultar la estructura de la tabla users, obtenemos el siguiente resultado

```
mysql> describe users;
+-------------------+-----------------+------+-----+---------+----------------+
| Field             | Type            | Null | Key | Default | Extra          |
+-------------------+-----------------+------+-----+---------+----------------+
| id                | bigint unsigned | NO   | PRI | NULL    | auto_increment |
| name              | varchar(255)    | NO   |     | NULL    |                |
| email             | varchar(255)    | NO   | UNI | NULL    |                |
| email_verified_at | timestamp       | YES  |     | NULL    |                |
| password          | varchar(255)    | NO   |     | NULL    |                |
| remember_token    | varchar(100)    | YES  |     | NULL    |                |
| created_at        | timestamp       | YES  |     | NULL    |                |
| updated_at        | timestamp       | YES  |     | NULL    |                |
| rol               | int             | NO   |     | NULL    |                |
+-------------------+-----------------+------+-----+---------+----------------+
9 rows in set (0.01 sec)
```

Finalmente en nuestro modelo `User.php` agregamos nuestro campo rol al $fillable, quedando nuestra variable $fillable de la siguiente forma:

```php
protected $fillable = [
    'name',
    'email',
    'password',
    'rol'
];
```

Al registrar un nuevo usuario, y consultando la tabla `users` vemos el siguiente resultado:

```
mysql> select * from users;
+----+------------+--------------------+---------------------+--------------------------------------------------------------+----------------+---------------------+---------------------+-----+
| id | name       | email              | email_verified_at   | password                                                     | remember_token | created_at          | updated_at          | rol |
+----+------------+--------------------+---------------------+--------------------------------------------------------------+----------------+---------------------+---------------------+-----+
|  3 | Sebastian2 | correo2@correo.com | 2024-01-15 03:52:48 | $2y$12$g3EXDi19K36Bw9hW1M9X8uKJc1TsCu0JpnKmGYVHDY/ldPEiX.hP6 | NULL           | 2024-01-15 03:52:36 | 2024-01-15 03:52:48 |   2 |
+----+------------+--------------------+---------------------+--------------------------------------------------------------+----------------+---------------------+---------------------+-----+
```

Una vez hemos ingresado con nuestra cuenta de usuario, podremos ingresar al dashboard.

### Moviendo el dashboard hacia vacantes

Ejecutaremos la siguiente migración:

`sail artisan make:controller VacanteController -r`

Agregamos la abreviación de flag -r para indicar que es un Resource Controller

Creamos el modelo Vacante:

`sail artisan make:model Vacante`

Creamos la siguiente migracion con el flag --create:vacantes , con vacantes en MINUSCULAS para asociarlo a esa tabla (siguiendo las convenciones de laravel)

`sail artisan make:migration create_vacante_table --create=vacantes`