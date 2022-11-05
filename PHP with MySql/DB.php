<?php
#Raw PHP with CRUD
class db{
    public $host;
    public $username;
    public $password;
    public $db_name;
    public $conn;

    #Create Connection with DB: _____________________________________________

    public function __construct($host,$username,$password,$db_name){
        $this->host=$host;
        $this->username=$username;
        $this->password=$password;
        $this->db_name=$db_name;
        $this->conn= mysqli_connect($this->host,$this->username,$this->password,$this->db_name);
        
        if(!$this->conn){
            echo mysqli_error($this->conn);
           
        }
        else{
            echo "connected\n <br>";
        }
    }

    #Insert data into DB: ________________________________________________

    public function insert($name,$password,$email){
        // $sql = "INSERT INTO employee(username, password,email) VALUES('SUMAYA','123456','sumaya@gmail.com')"; 
        $sql = "INSERT INTO employee(username, password,email) VALUES('$name','$password','$email')";
        
        if(mysqli_query($this->conn,$sql)==TRUE)
        {
            echo "\n <br>Data INSERTED";
        }
        else{
            echo mysqli_error($this->conn);
        }

    }

    #UPdate data in to DB : _______________________________________________
    
    public function update()
    {
        $sql = "UPDATE employee SET
                                    username='Momen',
                                    password='321654',
                                    email='momen@gmail.com'
                               WHERE ID=17";

        if(mysqli_query($this->conn,$sql)==TRUE){
            echo "<br>Data Updated!";
        }
        else{
            echo mysqli_error($this->conn);
        }
    }
    #Read/show data from DB: __________________________________________________

    // public function select(){
    //     $sql="SELECT * FROM employee";
    //     $data=mysqli_query($this->conn,$sql);

    //     // $row =mysqli_fetch_array($data);
    //     // $ID= $row['ID'];
    //     // $email=$row['email'];
    //     // echo $ID." ".$email;

    //     while($row=mysqli_fetch_array($data))
    //     {
            
    //         $ID= $row['ID'];
    //         $Name= $row['username'];
    //         $Password = $row['password'];
    //         $email= $row['email'];
    //         echo "ID:".$ID." Email: ".$email." Passowrd: ".$Password."<br>";
    //     }
        
    // }
     #Read/show data from DB: __________________________________________________

    public function select($tableName,$columnID,$columnUsername,$columnpassword,$columnemail){
        $sql= "SELECT * FROM $tableName";
        $data = mysqli_query($this->conn,$sql);
        while($row=mysqli_fetch_array($data)){
            
            $ID= $row[$columnID];
            $Name= $row[$columnUsername];
            $Password = $row[$columnpassword];
            $email= $row[$columnemail];
            echo "ID:".$ID." User Name: ".$Name." Email: ".$email." Passowrd: ".$Password."<br>";
        }
    }

    #Delete from DB:----------------------------------------------------------------------

    // public function delete(){
    //     $sql="DELETE FROM employee WHERE ID=19";
    //     if(mysqli_query($this->conn,$sql))
    //     {
    //         echo "\n <br> Data Deleted";
    //     }
    //     else{
    //         echo mysqli_error($this->conn);
    //     }
    // }
    #Delete Data From DB:___________________________________________________________________
    public function delete($tableName,$columnName,$value){
        $sql="DELETE FROM $tableName WHERE $columnName=$value";
        if(mysqli_query($this->conn,$sql))
        {
            echo "\n <br> Data Deleted";
        }
        else{
            echo mysqli_error($this->conn);
        }
    }

}
$DataBase = new db("localhost","root","","shuvo");

// $DataBase->insert();

// $DataBase->insert('Adhiha','123123','adhiha@gmail.com');

// $DataBase->update();

// $DataBase->select('employee','ID','username','password','email'); //Table name and  column name in here: 

// $DataBase->delete();

$DataBase->delete('employee','ID',20);

?>
