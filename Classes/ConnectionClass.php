<?php
class Connection
{
    private $server = "localhost";
    private $username = "root";
    private $password ="";
    private $database = "worldofrecipes";
    public  $connection;
  
    public function openConnection()
    {
        $this->connection = mysqli_connect($this->server, $this->username, $this->password, $this->database);
        if (!$this->connection) 
        {
            echo('No connection to basic data is established!');
            echo "<br/>";
        }
        return $this->connection;
    } 

    public function closeConnection($pkonekcija)
    {
        mysqli_close($pkonekcija);
    } 
    
    function __destruct() 
    {
        unset($this->connection);
    }
} 
?>