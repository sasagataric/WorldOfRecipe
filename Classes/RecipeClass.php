<?php
class Recipe
{
    private $connection;

    function __construct() 
    {
        include_once "ConnectionClass.php";
        $conn = new Connection();
        $this->connection = $conn->openConnection();
    }
   
    public function insertRecipes($Title, $Content, $CategoryId, $AuthorId, $Image)
    {
        $Title = mysqli_real_escape_string($this->connection, $Title);
        $Content = mysqli_real_escape_string($this->connection, $Content);
        $CategoryId = mysqli_real_escape_string($this->connection, $CategoryId);

        $sqlQuery="INSERT INTO `recipe`(`id`, `Title`, `Content`, `CategoryId`, `AuthorId`, `Date`, `Image`)VALUES (NULL, \"$Title\", \"$Content\", '$CategoryId','$AuthorId', CURRENT_TIMESTAMP(), '$Image')";
        $result = mysqli_query($this->connection, $sqlQuery);
        return $result;   
    }

    public function allRecipes()
    {
        $sqlQuery="SELECT * FROM `recipe`";
        $result = mysqli_query($this->connection, $sqlQuery);
        return $result; 
    }

    public function getRandomRecipes($id,$number)
    {
        $sqlQuery=" SELECT * FROM `recipe` WHERE id NOT IN ('$id') ORDER BY RAND() LIMIT $number";
        $result = mysqli_query($this->connection, $sqlQuery);
        return $result; 
    }
    
    public function getRecipeById($id)
    {
        $id=mysqli_real_escape_string($this->connection, $id);
        $sqlQuery=" SELECT * FROM `recipe` WHERE `id` = $id";
        $result = mysqli_query($this->connection, $sqlQuery);
        return $result; 
    }

    public function searchRecipes($search)
    {
        $search=mysqli_real_escape_string($this->connection, $search);
        $sqlQuery="SELECT * FROM `recipe` WHERE `Title` LIKE '%$search%' OR `Content` LIKE '%$search%'";
        $result = mysqli_query($this->connection, $sqlQuery);
        return $result; 
    }

    public function allRecipesLimit($start, $end)
    {
        $sqlQuery="SELECT * FROM `recipe` ORDER BY Date DESC LIMIT $start, $end";
        $result = mysqli_query($this->connection, $sqlQuery);
        return $result; 
    }

    public function allRecipesLimitByCategoryId($start, $end ,$CategoryId)
    {
        $sqlQuery="SELECT * FROM `recipe` WHERE CategoryId=$CategoryId ORDER BY date DESC LIMIT $start, $end";
        $result = mysqli_query($this->connection, $sqlQuery);
        return $result; 
    }

    public function allRecipesLimitByAuthorId($start, $end ,$idAutora)
    {
        $sqlQuery="SELECT * FROM `recipe` WHERE AuthorId=$idAutora ORDER BY date DESC LIMIT $start, $end";
        $result = mysqli_query($this->connection, $sqlQuery);
        return $result; 
    }


    public function deleteRecipe($id)
    {
        $sqlQuery=" DELETE FROM `recipe` WHERE `id`= $id";
        $result = mysqli_query($this->connection, $sqlQuery);
        return $this->connection->affected_rows; 
    }

    public function editRecipe($id,$Title, $Content, $CategoryId, $Image)
    {
        $Title = mysqli_real_escape_string($this->connection, $Title);
        $Content = mysqli_real_escape_string($this->connection, $Content);
        $CategoryId = mysqli_real_escape_string($this->connection, $CategoryId);

        $sqlQuery=" UPDATE `recipe` SET `Title`=\"$Title\",`Content`=\"$Content\",`CategoryId`=$CategoryId,`Image`=\"$Image\" WHERE `id`=$id";
        $result = mysqli_query($this->connection, $sqlQuery);
        return $result;  
    }

    public function editRecipeWithoutImage($id,$Title, $Content, $CategoryId)
    {
        $Title = mysqli_real_escape_string($this->connection, $Title);
        $Content = mysqli_real_escape_string($this->connection, $Content);
        $CategoryId = mysqli_real_escape_string($this->connection, $CategoryId);
        
        $sqlQuery=" UPDATE `recipe` SET `Title`=\"$Title\",`Content`=\"$Content\",`CategoryId`=\"$CategoryId\" WHERE `id`=$id";
        $result = mysqli_query($this->connection, $sqlQuery);
        return $result;  
    }

    function __destruct() 
    {
        unset($this->connection);
    }

}
?>