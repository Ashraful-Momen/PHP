<?php
#========================__LINE__============================
#print the line number : 

// echo "Line Number : ".__LINE__;

#=======================__FILE=============================
#print the full path of the file:


// echo "\nFull path of the file : ".__FILE__;
#========================__DIR__==========================
#print the full path of the Directory:

// echo "\n Full path of the directory: ".__DIR__;

#=========================__FUNCTION__===================
#print the name of the function : 

// function show (){
//     echo "\n The Functin Name is :".__FUNCTION__;
// }

// show();
#==========================__CLASS__===================
#print the name of class :

// class ABC{
//     public function Display(){
//         echo "\nThe Class Name is : ".__CLASS__;
//         echo "\nName of the Class & Method: ".__METHOD__;
//     }
// }
//  $obj= new ABC();

//  $obj->Display();
#=======================__NAMESPACE==================
#PRINT THE NAMESPAE NAME:

// namespace Momen;
// class A{
//     function show (){
//         echo "\n the namespace name is: ".__NAMESPACE__;
        
//     }
// }
// $obj=new A();

// $obj-> show ();
#-======================__TRAIT__========================
#print the name of the Trait:

// trait A{
//      function show (){
//        return __TRAIT__;
        
//     }
// }
// class B{
//     use A;
   
// }
// $obj=new B();

// echo $obj->show(); # the trait name is A;
#=======================================================