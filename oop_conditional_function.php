<?php 
#contitional function : class_exist(), property_exit(), method_exit(), sub_class_of(), trait_exist(), interface_exist(),a_exist();

#============================================================class_exist()========================================================================

// class MyClass{
//     public $name;
//     public function show(){
//         echo "Hi";
//     }
    
// }
// class B extends MyClass{

// }

// if(class_exists('MyClass'))
// {
//      echo "Yes class exist";
//  }
//  else
//  {
//    echo "No class exist";
//  }
 #======================================property_exits()=======================
//  class MyClass{
//     public $name;
//     public function show(){
//         echo "Hi";
//     }
    
// }


// if(property_exists('MyClass',"name")) #(class,PropertyName)
// {
//      echo "Yes property exist";
//  }
//  else
//  {
//    echo "No property exist";
//  }
#=========================================method_exist()========================
// class MyClass{
//     public $name;
//     public function show(){
//         echo "The Name of CLass & Method() : ".__METHOD__;
//     }
    
// }
// $obj=new MyClass();

// if(method_exists($obj,'show')) #without create the object method_exist() :won't be worked;
// {
//      echo "Yes method exist\n";
//      $obj->show();
//  }
//  else
//  {
//    echo "No method exist";
//  }
 #==========================================is_a():object exits or not =============================
//  class MyClass{
//     public $name;
//     public function show(){
//         echo "Hi";
//     }
    
// }

// $obj= new MyClass;

// if(is_a($obj,"Myclass")) #(object,ClassName)
// {
//      echo "Yes object exist";
//  }
//  else
//  {
//    echo "No object exist";
//  }
#============================================is_subclass_of():check subclass or not ========================
//  class Parents{
    
    
// }
// class child extends Parents{
   
// }

// $obj= new child;

// if(is_subclass_of($obj,"Parents")) #(object,ClassName)
// {
//      echo "Yes its parents class object exist";
//  }
//  else
//  {
//    echo "No parents class  object exist";
//  }


#====================================interface_exist()========================
// interface A{
//     function show();
    
// }


// if(interface_exists('A'))
// {
//      echo "Yes interface exist";
//  }
//  else
//  {
//    echo "No interface  exist";
//  }

#====================================trait_exist()===========================
// trait MyClass{
//     public $name;
//     public function show(){
//         echo "Hi";
//     }
    
// }


// if(trait_exists('MyClass'))
// {
//      echo "Yes trait exist";
//  }
//  else
//  {
//    echo "No trait exist";
//  }
