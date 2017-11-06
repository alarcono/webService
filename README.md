# Webservice

Webservice realizado con Codeigniter Rest Server para probar métodos get.

## Como usar 

- Crear base de datos llamada "prueba"
- Cargar dump existente en repositorio , en el está contenido estructura y datos.


```
$ mysqldump -u [usuario] -p prueba < prueba_dump.sql

```

## Carga csv

Si se desea cargar un archivo .csv a la base de datos :

```
$ mysqlimport --ignore-lines=1 --default-character-set=utf8 --fields-terminated-by=,   --verbose --local -u [usuario] -p prueba [ruta]

```  

## Llamadas implementadas 

- http://localhost/webService/productos/popularProducts : obtiene los 20 productos más buscados con las respectivas 5 palabras más  utilizadas en la busqueda.

- http://localhost/webService/productos/search/{"keyword":"palabra"} : obtiene los productos asociados a al keyword 

## Otros 

La aplicación está disponible en https://pruebasvista.herokuapp.com/ 

- https://pruebasvista.herokuapp.com/productos/popularProducts

- https://pruebasvista.herokuapp.com/productos/search/{"keyword":"palabra"}
