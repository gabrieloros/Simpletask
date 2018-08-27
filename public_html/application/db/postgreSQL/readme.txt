Seguir la orden de ejecución de los scripts como se indica en esta carpeta, al instalar por primera vez:

01_create_database.sql: Crea el rol y la base de datos.

02_gdr_structure.sql: Sobre la base de datos creada en el script anterior, crear la estructura de tablas de la aplicación.

03_phone_directory.sql.tar.gz: Guía telefonica. Descomprimir el archivo y correr el script sobre la base de datos ya creada.

04_phone_directory_full.rar: Guía telefónica extendida. No tiene un solo campo de domicilio, sino que lo posee separado en cada una de sus 
					partes. Actualmente tiene solo los datos de Godoy Cruz (version 1.0.2), pero la idea es que contenga todo lo que tiene
					la guía telefónica nacional. Cuando esto sea así solo existirá esta tabla.