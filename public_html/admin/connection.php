<?php

/**
 * Created by PhpStorm.
 * User: Mayara
 * Date: 25/07/2017
 * Time: 04:12
 */

/**
 * @author damith
 * @copyright 2011
 */

class createConnection //create a class for make connection
{
    var $host="127.0.0.1";
    var $username="admin";    // specify the sever details for mysql
    Var $password="6qv7g00cs6";
    var $database="kfn2xcj5b45awrentabil";
    var $myconn;

    function connectToDatabase() // create a function for connect database
    {

//        $conn= mysqli_connect($this->host,$this->username,$this->password, $this->database);
        $conn = new PDO("mysql:host=$this->host;dbname=$this->database;",$this->username,$this->password);

        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if(!$conn)// testing the connection
        {
            die ("Cannot connect to the database");
        }

        else
        {

            $this->myconn = $conn;

            //echo "Connection established";

        }

        return $this->myconn;

    }

    function selectDatabase() // selecting the database.
    {
        mysqli_select_db($this->database);  //use php inbuild functions for select database

        if(mysqli_error()) // if error occured display the error message
        {

            echo "Cannot find the database ".$this->database;

        }
        echo "Database selected..";
    }

    function runQuery($query){
        //echo $query+"<BR />";
        $result = $this->myconn->query($query) or die($this->myconn->error);
        return $result;
    }

    function closeConnection() // close the connection
    {
        mysqli_close($this->myconn);

        echo "Connection closed";
    }



}

?>