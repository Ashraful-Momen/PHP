<?php
#---------------------------__unset(): Distroy /Delete the property with value -----------------
//  class A{
//     public $course="php";
//     private $FirstName;
//     private $LastName;
//     public function setName($fname,$lname)
//     {
//         $this->FirstName=$fname;
//         $this->LastName=$lname;
//     }
//     public function __unset($name)
//     {
//         unset($this->$name);
//     }
//  }

//  $obj=new A();

//  $obj->setName("Ashraful","Momen");

//  unset($obj->FirstName);
//  print_r($obj);
 #=======================================__tostring()=========================================
//  class abc{

//     function __toString() #Fix the below error with the __tostring()
//     {
//         return "can't convertede the class in string (echo converted the value in string mode) class Name: ".get_class($this);
//     }

//  }

//  $obj=new abc();
//  echo $obj; #Recoverable fatal error: Object of class abc could not be converted to string
 #================================================__sleep()==============================================
 #to update data in DataBase before need to serialized those data: but before serialize we can decorate those data more efficent with __sleep() method. 
#serialize($object);

//  class foo{
//     private $name;
//     private $phone;

//     function setValue($sname,$sphone){
//         $this->name=$sname;
//         $this->phone=$sphone;
//     }
//     function __sleep() #it's call auto when serialize ($obj) call in class below, just object serialize / decorating as the position 1st or 2nd etc and colse the database connection also ;
//     {
//         return array("phone","name");
//     }
//  }
//  $obj=new foo();
//  $obj->setValue("Mukti","019456987"); #object convert into array;

//  $srl=serialize($obj);
// echo $srl;

// //  print_r($obj);
#=================================__wakeup()====================================================

 class foo{
    private $name;
    private $phone;

    function setValue($sname,$sphone){
        $this->name=$sname;
        $this->phone=$sphone;
    }
    function __wakeup() #it's call auto when serialize ($obj) call in class below, just object serialize / decorating as the position 1st or 2nd etc;
    {
        echo "\n I can reconnect DataBase when unserialized\n";
        
        
    }
 }
 $obj=new foo();
 $obj->setValue("Mukti","019456987"); #object convert into array;

 $srl=serialize($obj);
 print_r($srl);
 $unsrl=unserialize($srl);

 print_r($unsrl);

//  print_r($obj);