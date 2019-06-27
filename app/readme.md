#Sistema de Control de Stock

###Requisitos
- php7.2
- mysql

###Pasos de instalación:
1. Clonar el repositorio
2. Crear schema en la base de datos
3. Configurar nuestro .env a partir del .env.example
    1. En DB_DATABASE= poner el nombre del schema creado
    2. En DB_USERNAME= poner nuestro usuario de mysql (por defecto es root)
    3. En DB_PASSWORD= poner nuestra clave de usuario de mysql (por defecto no tiene)
    4. En el apartado MAIL_ poner los datos del mail para recuperación de contraseñas que elijamos. Por ej:
        1. MAIL_DRIVER=smtp
        2.   MAIL_HOST=smtp.gmail.com
        3.   MAIL_PORT=587
        4.   MAIL_USERNAME=noreply@xxx.com
        5.   MAIL_PASSWORD=xxx
        6.   MAIL_ENCRYPTION=tls
4. Ejecutar el comando 'php artisan key:generate'
5. Ejecutar el comando 'composer install'
6. Ejecutar: php artisan migrate
7. Ejecutar: php artisan db:seed --class=Roles --class=permissions --class=GivePermissions --class=admin
8. Ejecutar el comando 'php artisan serve'