<?php

class menu{

    public function navmenu(){

        $menu = [
            [
                1 =>["Service One","Home"]
            ],
            [
                1 =>["Service Two","About"]
            ],
            [
                1 =>["Service Three","Contact"]
            ],
            [
                1 =>["Service Four","Services"]
            ],
            [
                1 =>["Service Five","Blog"]
            ]
        ];
        
        return $menu;
        }
}
$obj = new menu();

$putValue= $obj-> navmenu();
// echo"<pr>";
// var_dump($putValue);
// echo "</pr>";


foreach($putValue as $k => $v )
{
    // echo "index (row => K): ".$k." inside Array value:(V)  ".$v[1]["0"].$v[1]["1"]."\n <br>";
    echo "Default array value  [number of row] = > ".$k."<br>";
    foreach($v as $k => $v)
    {
        echo "key value given(k)______".$k."  [value of V=>".$v[0]."_____=>[0 number index] __________ [1 number index]=>".$v[1].'<br>';
    }
}
