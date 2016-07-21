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
        $this->con = new \mysqli($this->host,$this->user,$this->pass,$this->db);
        if(mysqli_connect_errno()){
            printf("Connect failed: %s\n", mysqli_connect_errno());
            exit();
        }
        return $this->con;
    }

    // Filter the data [escape_string]
    private function filter($data){
        if(is_array($data)){
            foreach($data as $key=>$val){
                if(!is_array($data[$key])){
                    $data[$key] = $this->con->real_escape_string($data[$key]);
                }
            }
        }
        else{
            $data = $this->con->real_escape_string($data);
        }
        return $data;
    }

    // to insert xes'to den to exw doylepsei akoma
    function insert($table, $data){
        // Apply filters
        $this->last_table = $this->filter($table);
        $data = $this->filter($data);
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
        
        // Query is ready so we making it availiable!            
        $this->last_query = $query;

        // And we execute it!
        $this->execute($this->last_query);
    }

    // Here we update the row
    function update($table,$id,$data){
        // Apply filters
        $this->last_table = $this->filter($table);
        $id = intval($this->filter($id));
        $data = $this->filter($data);

        // Create query
        $query = "UPDATE `{$this->last_table}` SET ";
        foreach ($data as $key=>$val){
            $query .= "`".$key."`='".$val."',";
            
        }
        $query = substr($query, 0, -1);
        $query .= " WHERE `ID`='".$id."'";

        $this->last_query = $query;

        // Execute query
        $this->execute($this->last_query);
    }

    // Function for deleting rows
    function delete($table,$id){
        // Apply filters
        $this->last_table = $this->filter($table);
        $id = $this->filter($id);
        $id = intval($id);

        // Create query
        $query= "DELETE FROM {$this->last_table} WHERE `ID` = $id";

        $this->last_query = $query;

        // Execute query
        $this->execute($this->last_query);
    }

    /* This gets the data of the tables and saves it to return  *
     * data array.                                              */
    function select($table,$cols='*',$row='',$data_to_seek='') {
        // Apply filters
        $this->last_table = $this->filter($table);
        $cols = $this->filter($cols);
        $row = $this->filter($row);
        $data_to_seek = $this->filter($data_to_seek);


        // Create query
        $query = "SELECT {$cols} FROM {$this->last_table}";
        if($row!='' && $data_to_seek!=''){
            $query .=  " WHERE `". $row ."` = '".$data_to_seek."'";
        }
        $this->last_query = $query;

        // Execute query
        $this->execute($this->last_query);

        // Get data back to array
        $this->arrayTheData();
    }
    
    // For getting back an array
    private function arrayTheData(){
        // Empty array
        $this->clean();
        // Get data
        while ($row = $this->result->fetch_array(MYSQLI_ASSOC)) {
            $this->return_data[] = $row;
        }
        $this->result->free();
        // $this->result->close();
    }
    /* Executor!!
     * Note: this is not private function 'cause may be helpful for use
     *       outside the class.
     */
    function execute($query){
        $this->result = $this->con->query($query);
        if(!$this->result){
            die(print('Error while executing: '. $query));
        }
    }

    // Clean the return data so next time the array is clean from previous results.
    function clean(){
        unset($this->return_data);
    }
    

}


