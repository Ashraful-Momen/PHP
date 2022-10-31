<?php 

#PHP Get Function :

// class abc{
//     function show(){
//         echo "The name of class : ".get_class($this);
//     }
// }

// $obj= new abc();
// $obj->show();
// echo "\nThe class name is : ".get_class($obj);
#=======================get_parent_class================================

// class A{

// }
// class B extends A{
//     function show(){
//         echo " the name of parent class :".get_parent_class("B");
//     }
// }
// $obj=new B();

// $obj->show();

// echo "\n the Parents class name is : ".get_parent_class($obj);
#============================get_class_methods=============================

// class B{
//     function show(){
//         echo " the name of parent class :".get_class_methods("B");
//     }
//     function __construct()
//     {
//         print_r(get_class_methods($this));
//     }
// }

// $obj=new B();

// $methods=get_class_methods("B");

// print_r($methods);

// foreach($methods as $k){
//     echo "\n the class methods: ".$k;
// }

#============================get_class_variable()==========================
#return those variable of class as associative array : 
// class A{
//     public $name;
//     public $age;
//     private $phone;
//     function show(){
//         // print_r(get_class_vars(__CLASS__));
//         print_r(get_class_vars(get_class($this)));
//     }
// }

// $obj = new A ();
// $obj->show();

// print_r(get_class_vars(get_class($obj)));
#===========================get_call_class() & get_declare_class===========================

// class A{
    
// }
// class B extends A{
//     static function show (){
//         print_r(get_called_class()); #output the B class
//     }
// }

// $obj = new B ();
// $obj->show();
// print_r(get_declared_classes()); #By default 142 class declared class in php .... then return mine those of 2 class .


#==============================get_declare_trait() & get_declare_interface() also same work .==================================

// trait A{

// }
// trait B{

// }

// print_r(get_declared_traits());


#========================================class_alis("class_name","change_ofClass_name")========================
// class A{
//     public function cal(){
//         return 4+4;
//     }
// }

// class_alias("A","B");

// // $obj=new A();
// // echo $obj->cal();

// $change=new B();

// echo $change->cal();

#==============================class_object_vars()===================
// class myClass{
// 	public $var1;
// 	public $var2 = "hello";
// 	public $var3 = 100;
// 	private $var4;
	
// 	// function __construct(){
// 	// 	$this->var1 = "wow";
// 	// 	$this->var2 = "Yahoo";
// 	// 	print_r(get_object_vars($this));
// 	// }
// }

// $obj = new myClass();

// $class_vars = get_object_vars($obj);

// print_r($class_vars);


