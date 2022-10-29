<?php
#================Tutorialspoint==========================
// class Person{
//     private $name;
//     public function setName($name){
//        $this->name = $name;
//     }
//     public function getName(){
//        return 'welocme'. $this->name;
//     }
//  }
//  $person = new Person();
//  $person->setName('Alex');
//  $name = $person->getName();
//  echo $name;
 #==============================Getter : YahooBaba==============================

// class foo{
//     private $name= "Md Ashraful Momen";
//     public function __get($property)
//     {
//         if($property=="name")
//         {
//             echo $this->name;
//         }
//         else{
                
//         echo "it's non existing or private property {$property}";
//         }
//     }
// }
// $obj= new foo();
// $obj->hi;

 #==================================================================

//  class abc{
//      private $data = ["name"=>"Yahoo Baba","course"=>"PHP","fee"=>"2000"];
 
//      public function __get($key){
//          if(array_key_exists($key, $this->data)){ 
//              return $this->data[$key];
//          }else{
//              return "This key($key) is not defined.";
//          }
//      }
//  }
 
//  $test = new abc();
 
//  echo $test->cahr;


#====================================setter : Yahoobaba====================================
class student{
	
	private $name;

	public function hello(){
		echo $this->name;
	}

	public function __get($property)
	{
		echo "Your are trying to access Non existing or private property ($property)\n";		
	}

	public function __set($property, $value)
	{
		if(property_exists($this , $property)){ #(class,property)
			$this->$property = $value; #(property="value" ex: name="Yahoo Baba")
		}else{
			echo "Property does not exist : $property";
		}
	}
}

$test = new student();
$test->hi;
 $test->age = "Yahoo Baba";
$test->hello();

