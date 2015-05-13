<?php
  class dBase{
      protected $connection = null;
      public function connect($database = dbName){
          print dbName;
          if($this->connection){
              return;
          }          
          
          $mssql_server = dbHost; //host server
          $mssql_data   = array('Database'  =>  $database,
                                'UID'       => dbUser,
                                'PWD'       => dbPass);
          
          $this->connection = sqlsrv_connect($mssql_server,$mssql_data);
          if(!$dbconnect){
              return 'Failed connect to host';
          }
      }
      
      public function getData($query){
          $this->data_array = array();
          $result   = $this->query($this->connection,$query);
          while($row = sqlsrv_fetch_array($result)){
              $this->data_array[] = $row;
          }
          return $this->data_array;
      }
      
      public function query($connection, $query){
          $result = sqlsrv_query($connection, $query) or die("Query didn't work...");
      }      
  }
?>