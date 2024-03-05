<?php

class Items {
    //DB stuff
    private $con;
    private $table = 'items';

    //registration properties 
    public $item_id;
    public $item_name;
    public $item_photo;
    public $item_description;
    public $item_price;
    public $item_date;
    public $user_id;

    public function __construct($db) {
        $this->con = $db;
    }

    public function create() {
        //create query
        $query = 'INSERT INTO ' . $this->table . '
             SET
                item_name=:item_name,
                item_photo=:item_photo,
                item_description=:item_description,
                item_price=:item_price,
                user_id=:user_id';
        //prepare statement 
        $stmt = $this->con->prepare($query);

        //clean data
        $this->item_name = htmlspecialchars(strip_tags($this->item_name));
        $this->item_photo = ($this->item_photo);
        $this->item_description = htmlspecialchars(strip_tags($this->item_description));
        $this->item_price = htmlspecialchars(strip_tags($this->item_price));
        $this->user_id=$this->user_id;

        //bind data
        $stmt->bindParam(':item_name', $this->item_name);
        $stmt->bindParam(':item_photo', $this->item_photo);
        $stmt->bindParam(':item_description', $this->item_description);
        $stmt->bindParam(':item_price', $this->item_price);
        $stmt->bindParam(':user_id', $this->user_id);

        //execute query 
        if ($stmt->execute()) {
            return true;
        } else {
            echo 'Error : ' . $stmt->error;
            return false;
        }
    }

    //get post

    public function read() {
        //create query
        $query = 'SELECT *
        FROM
        ' . $this->table . ' 
        ';

        // prepare statement
        $stmt = $this->con->prepare($query);

        //execute query
        $stmt->execute();

        return $stmt;
    }

    //get a single post

    public function read_single() {
        //create query
        $query = 'SELECT 
        *
        FROM
        ' . $this->table . '
        WHERE
        item_name=?
        LIMIT 0,1';

        // prepare statement
        $stmt = $this->con->prepare($query);

        //bind ID
        $stmt->bindParam(1, $this->item_name);

        //execute query
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        //set properties
        $this->item_name = $row['item_name'];
        $this->item_photo = $row['item_photo'];
        $this->item_description = $row['item_description'];
        $this->item_price = $row['item_price'];
        $this->user_id=$row['user_id'];
    }

    //delete 
    public function delete() {
        //create query 
        $query = 'DELETE FROM ' . $this->table . '
        WHERE 
        item_name=:item_name ';

        //prepare statement
        $stmt = $this->con->prepare($query);
        //clean data
        $this->item_name = htmlspecialchars(strip_tags($this->item_name));
        //bind
        $stmt->bindParam(':item_name', $this->item_name);

        if ($stmt->execute()) {
            return true;
        } else {
            echo 'Error : ' . $stmt->error;
            return false;
        }
    }

    //update
    public function update() {
        // Create query
        $query = 'UPDATE ' . $this->table . '
            SET
                item_name = :item_name,
                item_photo = :item_photo,
                item_description = :item_description,
                item_price = :item_price
            WHERE 
                item_name = :item_name 
                AND user_id = :user_id';
    
        // Prepare statement 
        $stmt = $this->con->prepare($query);
    
        // Clean data
        $this->item_name = htmlspecialchars(strip_tags($this->item_name));
        $this->item_photo = htmlspecialchars(strip_tags($this->item_photo));
        $this->item_description = htmlspecialchars(strip_tags($this->item_description));
        $this->item_price = htmlspecialchars(strip_tags($this->item_price));
        $this->user_id = htmlspecialchars(strip_tags($this->user_id));
    
        // Bind data
        $stmt->bindParam(':item_name', $this->item_name);
        $stmt->bindParam(':item_photo', $this->item_photo);
        $stmt->bindParam(':item_description', $this->item_description);
        $stmt->bindParam(':item_price', $this->item_price);
        $stmt->bindParam(':user_id', $this->user_id);
    
        // Execute query 
        if ($stmt->execute()) {
            // Check if any rows were affected
            if ($stmt->rowCount() > 0) {
                return true; // Update successful
            } else {
                echo 'No matching item found for the provided user_id'; // Alert "not allowed"
                return false;
            }
        } else {
            echo 'Error : ' . $stmt->error;
            return false; // Update failed
        }
    }
}