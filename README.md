# sheepQ
PHP Mysqli  Query Builder


#Installing

clone or dowload respository

  1. config database in DB.php
  2. require 'lib/DB.php';
  
#CRUD 

```php
DB::getConn()->find($tablename);
```
Parameters:
* $tablename (string) -- name of table

Return type:  Arrays

```php
DB::getConn()->find_by($tablename,[$where],$isFirstOnly);
```
Parameters:
* $tablename (string) -- name of table
* $where (string) -- where clause
* $isFistOnly (boolean) -- get first row only

Return type:  Arrays

#Example

SELECT * FROM 
```php
DB::getConn()->find("tablename")
```
SELECT * FROM WHERE
```php
$data = DB::getConn()->find_by('employee',array("emp_id"=>"E0001"),true);
```
INSERT INTO 
```php
  $tablName = "Users";
  
  $data = array(
    "id"=>"U001",
    "firstName"=>"Thanathep"
  );
  
  DB::getConn()->insert($tableName,$data);
```
