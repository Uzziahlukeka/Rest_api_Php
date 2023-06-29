<?php
class Registration{
    //DB stuff
    private $con;
    private $table='registration';

    //registration properties 
    public $name;
    public $email;
    public $passw;
    public $id;
    private $hash;

    public function __construct($db)
    {
        $this->con=$db;
    }

    public function login(string $email, string $password)
    {
        $this->email = $email;
        $this->passw = $password;
    
        $pv = "SELECT password, name FROM registration WHERE email = :email";
        $stmt1 = $this->con->prepare($pv);
        $stmt1->bindParam(':email', $email);
        $stmt1->execute();
        $result = $stmt1->fetch(PDO::FETCH_ASSOC);
    
        if ($result !== false) {
            $storedPassword = $result['password'];
            $verif = password_verify($this->passw, $storedPassword);
    
            if ($verif === true) {
                $this->name=$result['name'];
                return true;
            } else {
                echo "Something went wrong";
            }
        }
    }

    //create post 

    public function create(){
        //create query
            $query='INSERT INTO '.$this->table.'
             SET
                name=:name,
                email=:email,
                password=:password
            ';
        //prepare statement 
        $stmt=$this->con->prepare($query);

        //clean data
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->passw=htmlspecialchars(strip_tags($this->passw));

        //bind data
        $stmt->bindParam(':name',$this->name);
        $stmt->bindParam(':email',$this->email);
        $stmt->bindParam(':password',$this->hash);
        
        if($this->validatePassword($this->passw)){
            $this->hash = password_hash($this->passw, PASSWORD_DEFAULT);

            //execute query 
            if($stmt->execute()){
            return true;
            }
            else{
            echo'Error : '.$stmt->error;
            }

        } 
        else{
            echo "something went wrong";
        }
    }

    //Get posts
    public function read(){
        //create query
        $query='SELECT id,name,email,created_at
        FROM
        '. $this->table . '
        ORDER BY
       created_at DESC';

        // prepare statement
        $stmt=$this->con->prepare($query);

        //execute queery
        $stmt->execute();

        return $stmt;
    }

    //get a single post
    
    public function read_single(){
        //create query
        $query='SELECT 
        id,name,email,created_at
        FROM
        '. $this->table . '
        WHERE
        name=?
        LIMIT 0,1';
        
         // prepare statement
         $stmt=$this->con->prepare($query);

         //bind ID
         $stmt->bindParam(1,$this->name);
        
          //execute queery
        $stmt->execute();

        $row=$stmt->fetch(PDO::FETCH_ASSOC);

        //set propreties
        $this->id=$row['id'];
        $this->name=$row['name'];
        $this->email=$row['email'];
    }

    //delete 
    public function delete(){
        //create query 
        $query='DELETE FROM '.$this->table.'
        WHERE 
        id=:id';

        //prepare statement
        $stmt=$this->con->prepare($query);
        //clean data
        $this->id=htmlspecialchars(strip_tags($this->id));
        //bind
        $stmt->bindParam(':id',$this->id);

        if($stmt->execute()){
            return true;
        }
        else{
            echo'Error : '.$stmt->error;
        }
    
    }

    //update
    public function update(){
        //create query
        $query='UPDATE '.$this->table.'
        SET
        name=:name,
            email=:email
        WHERE 
            id=:id
        ';

        //prepare statement 
        $stmt=$this->con->prepare($query);

        //clean data
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->id=htmlspecialchars(strip_tags($this->id));

        //bind data
        $stmt->bindParam(':name',$this->name);
        $stmt->bindParam(':email',$this->email);
        $stmt->bindParam(':id',$this->id);

        //execute query 
        if($stmt->execute()){
            return true;
        }
        else{
            echo'Error : '.$stmt->error;
        }

    }

    private function validatePassword(string $password) {
        // Check if the password has at least 8 characters
        if (strlen($password) < 8) {
            echo "Please enter a password with at least 8 characters.";
            return false;
        }
    
        // Check if the password contains at least one uppercase letter
        if (!preg_match('/[A-Z]/', $password)) {
            echo "Please enter a password with at least one uppercase letter.";
            return false;
        }
    
        // Check if the password contains at least one digit or special character
        if (!preg_match('/[0-9\W]/', $password)) {
            echo "Please enter a password with at least one digit or special character.";
            return false;
        }
    
        // All conditions are satisfied
        return true;
    }

}
