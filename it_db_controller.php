<?php

/**
 * Description of it_db_controller
 * Sqllite database, PDO
 * @author -- wildernix
 */
class it_db_controller
{
   
    // connecting to database file
    public function connect()
    {  
       $DB = new PDO("sqlite:db/maindb.db");       
       return $DB;
    }
   
    // selecting data from database
    public function select()
    {  
        $result=$this->connect()->query("SELECT * FROM it_post_list"); // request for data        
        
        $result->setFetchMode(PDO::FETCH_OBJ); // selection mode
        
        echo 'Listing';
        
        // print data from request
        
        while($fields = $result->fetch()) 
                {              
                 echo $fields->it_id; echo '<br>';  
                }
        
    }
    
}
