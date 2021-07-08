<?php
class Author
{
    private $connection;

    function __construct() 
    {
        include_once "ConnectionClass.php";
        $conn = new Connection();
        $this->connection = $conn->openConnection();
    }
   
    public function insertAuthor($Name, $Email, $Password, $Bio, $Image)
    {
        $Name = mysqli_real_escape_string($this->connection, $Name);
        $Email = mysqli_real_escape_string($this->connection, $Email);
        $Bio = mysqli_real_escape_string($this->connection, $Bio);

        $sqlQuery = "INSERT INTO `author`(`id`, `Name`, `Email`, `Password`, `Bio`, `Role`, `Image`) VALUES (NULL, '$Name', '$Email', '$Password','$Bio', 'author', '$Image')";
        $result = mysqli_query($this->connection, $sqlQuery);
        return $result;   
    }

    public function allAuthors()
    {
        $sqlQuery="SELECT * FROM `author`";
        $result = mysqli_query($this->connection, $sqlQuery);
        return $result; 
    }
    
    public function getAuthorById($id)
    {
        $sqlQuery=" SELECT * FROM `author` WHERE `id` = $id";
        $result = mysqli_query($this->connection, $sqlQuery);
        return $result; 
    }

    public function getAuthorByEmail($Email)
    {
        $Email = mysqli_real_escape_string($this->connection, $Email);
        
        $sqlQuery=" SELECT * FROM `author` WHERE `Email` = '$Email'";
        $result = mysqli_query($this->connection, $sqlQuery);
        return $result; 
    }

    public function allAuthorsLimit($start, $end)
    {
        $sqlQuery="SELECT * FROM `author` ORDER BY id DESC LIMIT $start, $end";
        $result = mysqli_query($this->connection, $sqlQuery);
        return $result; 
    }

    public function deleteAuthor($id)
    {
        $sqlQuery=" DELETE FROM `author` WHERE `id`= $id";
        $result = mysqli_query($this->connection, $sqlQuery);
        return $this->connection->affected_rows; 
    }

    public function editAuthor($id,$Name, $Email, $Password, $Bio, $Image)
    {
        $Name = mysqli_real_escape_string($this->connection,$Name);
        $Email = mysqli_real_escape_string($this->connection, $Email);
        $bio = mysqli_real_escape_string($this->connection, $Bio);

        $sqlQuery="UPDATE author SET Name='$Name', Email='$Email', Bio='$Bio', Image='$Image' ".$Password." WHERE id='$id'";
        $result = mysqli_query($this->connection, $sqlQuery);
        return $result;  
    }

    public function editAuthorWithoutImage($id,$Name, $Email, $Password, $Bio)
    {
        $Name = mysqli_real_escape_string($this->connection,$Name);
        $Email = mysqli_real_escape_string($this->connection, $Email);
        $Bio = mysqli_real_escape_string($this->connection, $Bio);

        $sqlQuery="UPDATE author SET Name='$Name', Email='$Email', Bio='$Bio' ".$Password." WHERE id='$id'";
        $result = mysqli_query($this->connection, $sqlQuery);
        return $result;  
    }

    function __destruct() 
    {
        unset($this->connection);
    }

}
?>