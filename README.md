# Prueba Técnica: Aplicación lista de tareas

## Requerimientos
Tabla agregada en la base de datos
PHP 8.0+

## Configuración de entorno

Renombrar el documento env a .env
Abrir .env y configurar los siguientes parametros:

database.default.hostname = <Nombre de servidor>
database.default.database = <Nombre de base de datos>
database.default.username = <Nombre de usuario de la base de datos>
database.default.password = <Contraseña de base de datos>
database.default.DBDriver = <Manejador de base de datos>
database.default.DBPrefix = <En caso de usar prefijos>
database.default.port = <Puerto de la base de datos>

## Agregar tabla a la base de datos:
Para agregar la tabla a la base de datos, usar el siguiente comando: `php spark migrate`

## Iniciar aplicación
Ejecutar comando `php spark serve`
Por defecto se ejecutará en la siguiente URL:
`http://localhost:8080/`