<?php


class gelo
{
    public $text;
    public $data = [];
   
    public function dataprint(){
        $this->data=[
            0 => [
                'Name' => 'Oleraj',
                'ID' => '18192103072',
                'Dept' => 'CSE',
                'Year' => '2019'
            ],
            1 => [
                'Name' => 'Oleraj',
                'ID' => '18192103072',
                'Dept' => 'EEE',
                'Year' => '2019'
            ],
            2 => [
                'Name' => 'Oleraj',
                'ID' => '18192103044',
                'Dept' => 'EEE',
                'Year' => '2020'
            ]
            
        ];
        return $this->data;
    }
}

                
$person = new gelo();
$try=$person->dataprint();

// echo $try[0]["Year"];
$keyvalue=array_keys($try);
// print_r($keyvalue);
// echo $keyvalue[2]; #print first key offset:  0,1,2;
// echo $try[2]["Name"]; #print insite array value ;


echo "<pre>";
print_r($try);
// $len =array_keys($try);
echo "</pre>";

$i=0;
foreach($try as $k => $v) #data
{
    echo $keyvalue[$i].' = this is  key of index (out side of array): <br>';
    $i++;
    echo "[Another technique for print the key Numbers] =>".$k.' <= index of out of array [ Inside key value print]=>'.$v["Name"]." ".$v["ID"].$v["Dept"].$v["Year"]."<br>"; # here $k is the : 0,1,2 offset
   foreach($v as $k =>$v) 
{
    // echo $k."=  \n".$v."<br>"; #here also i can print the value of array
    
   
}
}

?>