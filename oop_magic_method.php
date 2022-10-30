<?php
<?php
#=============================__get(), __call()=========================
// class A {
//     private $name="Ashraful Momen";
//     public function display()
//     {
//         echo " I'm from class A ";
//     }

//     function __get($property){
//         echo "\nError popup for Variable or property : Not exit the propertiy/vaiable ";
//     }
//     function __call($name, $arguments) # Error : use for undefine method 
//     {
//         echo "\n Error popup for Methods : Not exit the propertiy {$name} or private methods";
//     }
// }

// $obj = new A();

// $obj->age();
// $obj->age;
#====================================================================
// class A {
//  	private $Name1;
// 	private $Name2;

// 	private function setName($fname, $lname){
// 		$this->Name1 = $fname;
// 		$this->Name2 = $lname;
// 	}
//     function display()
//     {
//         echo "First Name: $this->Name1";
//         echo "\n Last Name: $this->Name2\n";
//     }
//     function __get($property)
//     {
//         echo "\n$property = is not found or private property";
//     }
//     function __call($method, $argc){
//         if(method_exists($this,$method)){
//             call_user_func_array([$this,$method],$argc);
//         }
//         else{
//             echo "\n $method = does not exit ";
//         }
//     }

// }
// $obj=new A();
// $obj->setName("Ashraful","Momen");

// $obj->display();
// $obj->age();
// $obj->name;


// echo "<pre>";
// print_r($obj);
// echo "</pre>";
#======================================__call static method==============================================

// class A {
//     private $Name;
//     private static function show($name){
//         echo " Static Name=$name\n";
//     }
//     public function display($name){
//         echo "nonstatic Name=$name\n";
//     }
//     public static function __callStatic($method, $argc)
//     {
//         if(method_exists(__CLASS__,$method)){
//             call_user_func_array([__CLASS__,$method],$argc);
//         }
//         else{
//             echo "the method not exit : $method and value =$argc\n";
//         }
//     }


// }



// A::show("Md Ashraful momen");

// A::name("mukti");

// $obj=new A();
// $obj->display("Shuvo");

#======================___isset() :==========================

// class A {
//     public $name="Momen";
   
//     public function __isset($name) 
//     {
//         if(property_exists($this,$name))
//         {return true;}
//         return "Nai";
//     }
    
// }

// $obj = new A ();
// var_dump(isset($obj->name));


// echo isset($obj->name);
#============================================================
// class User
// {
//   private $data = [
//     'name' => 'John',
//     'age' => 34,
//   ];

//   public function __isset($name)
//   {
//     if (array_key_exists($name, $this->data)) {
//       return true;
//     }

//     return false;
//   }
// }

// $user = new User();

// var_dump(isset($user->name));

#===================End is isset()==============================
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

//  class foo{
//     private $name;
//     private $phone;

//     function setValue($sname,$sphone){
//         $this->name=$sname;
//         $this->phone=$sphone;
//     }
//     function __wakeup() #it's call auto when serialize ($obj) call in class below, just object serialize / decorating as the position 1st or 2nd etc;
//     {
//         echo "\n I can reconnect DataBase when unserialized\n";
        
        
//     }
//  }
//  $obj=new foo();
//  $obj->setValue("Mukti","019456987"); #object convert into array;

//  $srl=serialize($obj);
//  print_r($srl);
//  $unsrl=unserialize($srl);

//  print_r($unsrl);

//  print_r($obj);
  #======================__clone()=================================

// $a=5;
// $b=& $a; #b point a  and if the change value of any (a or b ) variable then change for boths.
// $b=10;
// echo $b;
#======================clone keyword used : for cloning the objects====================

// class A{
//     private $name ;
//     function setValue($n){
//         echo $this->name=$n;
//     }
// }

// $obj= new A();
// $obj->setValue("Md.Ashraful Momen\n");

// $obj2= clone $obj;

// $obj2->setValue("Shuvo");

#===================================__invoke(): call object as function =======================================
#call object of class as function getting error then __invoke() function automatically run and handle the error:

// class A{
//     private $name ;
//     function __construct($n){
//          echo $this->name=$n;
//     }
//     public function __invoke($k)
//     {
//         echo $this->name = $k;
//     }
// }

// $obj= new A("Momen");


// $obj("shuvo"); #we can't use this $obj () function without the __invoke() magic methods.

