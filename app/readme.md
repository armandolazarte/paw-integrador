##Sistema de Control de Stock
Pasos:
1. Crear schema en la base de datos
2. configurar en el .env los datos de la db creada y mis credenciales
3. Ejecutar: php artisan migrate
4. Ejecutar: php artisan db:seed --class=Roles --class=permissions --class=GivePermissions --class=admin
