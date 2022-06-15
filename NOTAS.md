https://www.youtube.com/watch?v=Hyk5-gSraMQ
paso 1 
traer los archivos de autenticacion de laravel
composer require laravel/ui
php artisan ui:auth
paso 2 
instalar el paquete de permisos spatie
composer require spatie/laravel-permission
paso3
registrar el paquete en el array providers del archivo config/app.php
Spatie\Permission\PermissionServiceProvider::class,
***se debe incluir al final del array******

paso 4
ejecutar en consola el siguiente comando
para crear la migracion de los permisos y los controladores para autenticacion
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
paso 5 
en el archivo app/Http/Kernel.php
en el array protected $routeMiddleware[]
escribir la sigiene linea para registra los permisos en el midleware
'role' => \Spatie\Permission\Middlewares\RoleMiddleware::class,
paso 5 crear los campos neesarios en el modelo y en la migracion
***modelo**
protected $fillable = [
'name',
'email',
'password',
'tipo', //tipo 1 = cliente, 0 = admin
'estado' //activado = 1, no activado =0
];
**migracion**
$table->id();
$table->string('name');
$table->string('email')->unique();
$table->timestamp('email_verified_at')->nullable();
$table->string('password');
$table->boolean('tipo')->default(1);//1 = cliente; 0 admin
$table->boolean('estado')->default(1);//1 = activado ; 0 no activado
$table->rememberToken();
$table->timestamps();
});

paso 6 
creacion de roles admin y cliente
en el archivo routes/web.php
escribir las siguientes lineas luego referscar el proyecto para que se creen estos usuarios en la tabla roles
despues de que se creen podemos borrar estas lineas
use Spatie\Permission\Models\Role;
Role::create(['name'=>'admin']);
Role::create(['name'=>'cliente']);

paso 7 
registrar usuarios mediante la interfaz 
ir al controlador app/Http/Controllers/Auth/RegisterController.php
y en el metodo create hacer:
protected function create(array $data)
{
$user = User::create([
'name' => $data['name'],
'email' => $data['email'],
'password' => Hash::make($data['password']),
]);
$user->assignRole('admin;');
return $user;
}
ademas en el modelo user se debe agregar el rolo




