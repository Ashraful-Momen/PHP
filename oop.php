<?php
#----------public-----------------
// class Base{

//     public $name;

//     public function __construct($n)
//     {
//         echo $this->name= $n."\n";
//     }
//     // public function show()
//     // {
//     //     echo $this->name;
//     // }
// }

// class Drive extends Base{

//     public function  display(){

//         echo $this->name;
//     }
// }

// $obj= new Drive("Md.Ashraful Momen");

// $obj->name ="Md.Ashraful Momen Shuvo";

// $obj->display();
#-------------------Protected--------------------------

// class Base{

//     protected $name;

//     public function __construct($n)
//     {
//         echo $this->name= $n."\n";
//     }
//     protected function show()
//     {
//         echo $this->name;
//     }
// }

// class Drive extends Base{

//     public function  display(){

//         echo $this->name;
//     }
// }

// $obj = new Drive("shuvo");

#---------------------Private--------------------



// class Base{

//     private $name;

//     public function __construct($n)
//     {
//         echo $this->name= $n." <= I am form constructor\n"; # it will be print cz of same class private properti accessible.
//     }
  
// }

// class Drive extends Base{

//     public function  display(){

//         echo $this->name;
//     }
// }

// $obj = new Drive("shuvo");

// $obj->display();
#---------------------------------------------------------------
// class Base{

//     private $name;

//     public function __construct($n)
//     {
//         echo $this->name= $n." <= I am form constructor=>\n"; # it will be print cz of same class private properti accessible.
//     }
  
// }

// class Drive extends Base{

//     public function  display(){

//         echo $this->name;
//     }
// }

// $obj = new Base("shuvo");

// $obj2= new Drive("Momen");
// $obj2->display();
#=====================================================================

#====================Properties & Method Over-riding===============================

// class A{
//     public $name="some text";
//     public function display()
//     {
//         echo "hi";
//     }
// }
// class B extends A {             #use same variable and methods from Base class is defied as Properties & Method Over-riding.
//     public $name=" Another Text";
//     public function display()
//     {
//         echo "bye";
//     }
// }

#====================Abstruction===============================
//can't create the object from class and use for secure coding .

// abstract class A {
//     protected $name;
//     // protected function __construct($n)
//     // {
//     //     $this-> name =$n ;
//     // }
//    abstract protected function show ($a,$b); # Declare but not code in Base class but can code in Drive class.
// }
// Class B extends A {
//     public function show ($c,$d){
//         echo $c+$d; #Implement code in here .
//     }
// }
// $obj = new B();
// $obj-> show (2,3);

#=======================Interface===========================
//interface drive class can extends/implements more Base class which in not possible in Abstruction :
// access modifire :public , private , protected not need before methods.

// interface A{
//     function sum($a,$b);
// }
// interface B{
//     function sub($c,$d);
// }

// class C implements A,B{
//     public function sum($a,$b){
//       echo  $a+$b."\n";
//     }
//     public function sub($a,$b){
//         echo $a+$b."\n";
//     }

// }

// $obj = new C();
// $obj-> sum(2,3);
// $obj-> sub(5,6);

//
#----------------------------Static Class: static all propertise:variable,Methods--------------------
//After working of function and variable then static data not lost from memory 

// class A {
//     public static $name="Ashraful Momen";
//     public static function show (){
//         echo self::$name."\n";  #in Base clase use (self::) alternative ($this-> )
//     }
// }
// Class B extends A{
//     public static function show (){

//         echo parent::$name="momen" ;#in Drive clase use (parent::) alternative ($this-> )
//     }
// }
// A::show();
// B::show();

#===============================Static binding==========================================
// #Declaring class properties or methods as static makes them accessible without needing an instantiation of the class. These can also be accessed statically within an instantiated class object.
// class A {
//     protected static $name="Ashraful"; # Access modifire must be same Base + Drive class for static binding
//     public static function show (){
//         echo static::$name."\n";  #For Drive clase use (static::) connect object form Drive Class 
//         echo self::$name."\n";  #For Base clase use (self::) alternative ($this-> )
       
//     }
// }
// Class B extends A{
//     protected static $name="Momen";
// }
// $obj=new B;
// $obj-> Show();
#===============================Static binding==========================================
//In PHP, a trait class is a way to enable developers to reuse methods of independent classes that exist in different inheritance hierarchies.

// trait A{
//    public function greating(){
//     echo "Hi"."<br>";
//    }
// }
// trait B{
//     public function byebye(){
//      echo "Bye";
//     }
//  }

//  class C {
//     use A,B;
//  }
//  $obj=new C();
//  $obj-> greating();
//  $obj->byebye();
#=========================================Trait=====================================================
// trait is a global function that can able to use in any class for class calling the trait, inside of a class "use" keyword need to call the trait class.

trait A{
  public function greating (){
    echo "hi";
  }
  trait B{ public function bye (){
    echo "Bye"."<br>"}
         }
  class C { use A,B}}

$obj = new c ();
$obj->greating();
$obj->bye();
?>
