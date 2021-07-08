<?php
class Category
{
    private $connection;

    function __construct() 
    {
        include_once "ConnectionClass.php";
        $conn = new Connection();
        $this->connection = $conn->openConnection();
    }
   
    public function allCategories()
    {
        $sqlQuery="SELECT * FROM `category`";
        $result = mysqli_query($this->connection, $sqlQuery);
        return $result; 
    }

    public function getCategorieById($id)
    {
        $sqlQuery="SELECT * FROM category WHERE id='$id'";
        $result = mysqli_query($this->connection, $sqlQuery);
        return $result; 
    }
    
    function __destruct() 
    {
        unset($this->connection);
    }

}
?>