<?php 

class DB 
{


    /**
     *  Config Database
     */
    private static $config = array(

        "db_url"=>"localhost",
        "db_username"=>"root",
        "db_password"=>"",
        "db_name"=>"dbname",
                



    );


    /**
     * summary
     *
     * Mysqli Query Builder
     * 
     *  
     * 
     */

    private $mysqli;


    function __construct()
    {
	   	 $this->mysqli = new mysqli(self::$config['db_url'],self::$config['db_username'],self::$config['db_password'],self::$config['db_name']);
         $this->mysqli->set_charset('utf8');
    }

    function __destruct() {
       if (!is_null($this->mysqli)) {
           $this->mysqli->close();
       }
    }




    /**
     * [getConn description]
     * @return [type] [description]
     */
    public static function getConn(){
        return new DB();
    }


    /**
     * [find description]
     * @param  [type] $tableName [description]
     * @return [type]            [description]
     */
    public function find($tableName){
    	$sql = " SELECT * FROM $tableName";
    	$array = array();
    	$resultSet = $this->mysqli->query($sql);
        echo "$sql";
    	if ($resultSet) {
    		while ($row = $resultSet->fetch_assoc()) {
    			array_push($array,$row);
    		}
    	}else{
    		echo  $this->mysqli->error;
    	}
    	return $array;
    }


    public function find_by($tableName,$where,$isFirstOnly){
        $sql = "SELECT * FROM ". $tableName . " WHERE ";
        $index = 0 ;
        foreach ($where as $key => $value) {
            $sql .= "`$key`" . '=' . "'$value'" ;
            if ($index < 1 && $index != (sizeof($where)-1)){
              $sql .= " AND ";
            }
            $index++;
        }
        //echo "$sql";

        $resultSet = $this->mysqli->query($sql);
        if (!$resultSet) {
            echo $this->mysqli->error;
        }
        if ($isFirstOnly) {
            return $resultSet->fetch_assoc();
        }else{
            $arr = array();
            while ($row = $resultSet->fetch_assoc()) {
                array_push($arr,$row);
            }
            return $resultSet;
        }
    }


    /**
     * [insert description]
     * @param  [type] $tableName [description]
     * @param  [type] $data      [description]
     * @return [type]            [description]
     */
    public function insert($tableName,$data){
        $keys = array_keys($data);
        $sql = "INSERT INTO " . "`$tableName`" .'(' ;
        for($i=0;$i<sizeof($keys);$i++){
            $sql .= $keys[$i] ;
            if ($i != (sizeof($keys)-1) ) {
                $sql .= ",";
            }
        }
        $sql .= ')VALUES(';
        $index = 0 ;
        foreach ($data as $key => $value) {
            $sql .= "$value" ;
            if ($index != (sizeof($data)-1)) {
                $sql .= ',' ;
            }
            $index ++ ;
        }
        $sql .= ')';        
        if ($this->mysqli->query($sql)) {
            return true;
        }
        else{
            echo "Insert ERROR : " . $this->mysqli->error;
            return false;
        } 
    }


   /**
    * [delete description]
    * @param  [type] $tableName [description]
    * @param  [type] $data      [description]
    * @return [type]            [description]
    */
    public function delete($tableName,$data){
        $keys = array_keys($data);
        $sql="DELETE FROM " . "`$tableName`" ." WHERE ";
        $index = 0 ;
        foreach ($data as $key => $value) {
            $sql .=  "$key" . ' = ' . "$value";
            if (sizeof($data) > 1 && $index != (sizeof($data)-1) ) {
                $sql .= " AND ";
            }
            $index++;
        }

        if ($this->mysqli->query($sql)) {
            return true;
        }
        else{
            echo $this->mysqli->error;
            return true ;
        }
    }


    /**
     * [update description]
     * @param  [type] $tableName [description]
     * @param  [type] $data      [description]
     * @return [type]            [description]
     */
    public function update($tableName,$data,$where){
        $keys = array_keys($data);
        $sql="UPDATE ".$tableName." SET ";
        $index = 0 ;
        foreach ($data as $key => $value) {
           $sql .= $key . ' = ' . "'$value'" ;
           if ($index != (sizeof($data) -1)) {
               $sql .= ',';
           }
            $index++;
        }
        $index = 0 ;
        $keys = array_keys($where);
        $sql .= " WHERE ";
        foreach ($where as $key => $value) {
            $sql .= $key . ' = ' . "'$value'";
            if ($index < 1 && $index != ( sizeof($where)- 1)) {
                $sql .= " AND ";
            }
            $index++;
        }
        if ($this->mysqli->query($sql)) {
            return true;
        }
        else {
            echo $this->mysqli->error;
            return false;
        }

    }






}



 ?>