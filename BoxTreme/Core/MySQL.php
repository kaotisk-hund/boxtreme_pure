<?php

namespace BoxTreme\Core;


class MySQL{
    
    private $host;
    private $user;
    private $pass;
    private $db;
    private $result;
    public $return_data = array();
    private $con;
    private $last_query;
    private $last_table;
    private $rows_affected;
 
    // Constructor and goes for connection
    function __construct($user, $pass, $db, $host = 'localhost'){
        $this->host = $host;
        $this->user = $user;
        $this->pass = $pass;
        $this->db = $db;
        $this->connect();
    }

    // Connection
    function connect(){
        try{
            $this->con = new \PDO('mysql: host='.$this->host.';dbname='.$this->db, $this->user, $this->pass);
        } catch (\PDOException $e ){
            print "(!) Error: " . $e->getMessage() ."</br>";
            die;
       }
        return $this->con;
    }


    /*
     * Use this to insert data to tables.
     *
     */
    function insert($table, $data){
        $this->last_table = $table;
        $counter = count($data);

        //      Creating my query
        $query = "INSERT INTO {$this->last_table} VALUES('',";
        for ($i=0;$i<$counter;$i++){
            $query .= "'".$data[$i] . "'";
            if($counter-1 == $i){
                $query .= ")";
            }
            else{
                $query .= ",";
            }
        }
        
        // Query is ready so we making it available!
        $this->last_query = $query;

        // And we execute it!
        $this->rows_affected = $this->execute($this->last_query);
    }

    // Here we update the row
    function update($table,$id,$data){
        $this->last_table = $table;

        // Create query
        $query = "UPDATE ".$this->last_table." SET ";
        foreach ($data as $key=>$val){
            $query .= "`".$key."`='".$val."',";
            
        }
        $query = substr($query, 0, -1);
        $query .= " WHERE `ID`='".$id."'";

        $this->last_query = $query;

        // Execute query
        $this->rows_affected = $this->execute($this->last_query);
    }

    // Function for deleting rows
    function delete($table,$id){
        $this->last_table = $table;

        // Create query
        $query= "DELETE FROM {$this->last_table} WHERE `ID` = $id";

        $this->last_query = $query;

        // Execute query
        $this->rows_affected = $this->execute($this->last_query);
    }

    /* This gets the data of the tables and saves it to return  *
     * data array.                                              */
    function select($table,$cols='*',$row='',$data_to_seek='') {
        $this->last_table = $table;

        // Create query
        $query = "SELECT {$cols} FROM {$this->last_table}";
        if($row!='' && $data_to_seek!=''){
            $query .=  " WHERE `". $row ."` = '".$data_to_seek."'";
        }
        $this->last_query = $query;

        // Execute query
        $this->result = $this->execute($this->last_query);
        $this->return_data = $this->result->fetchAll();
    }
    
    /* Executor!!
     * Note: this is not private function 'cause may be helpful for use
     *       outside the class.
     */
    function execute($query){
        $prepared = $this->con->prepare($query);
        $prepared->execute();
        return $prepared;
    }

    /*
     * Clean the return data so next time the array is clean from previous results.
     *
     */
    function clean(){
        unset($this->return_data);
    }
}
