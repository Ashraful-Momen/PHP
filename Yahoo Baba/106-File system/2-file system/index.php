<?php
// $myfile = fopen("shuvo.txt", "r"); // fopen: for create or open file .... mode: r,r+,w,w+,a,a+,x,x+...

// echo fread($myfile,100);
// echo fread($myfile,filesize('shuvo.txt')); // Read content of the file ....

// $len = filesize('shuvo.txt');
// echo $len;


// echo fgets($myfile); //return the first line of file 
// echo ftell($myfile); // return the total byte of character and point of curser until the end of line ....

// echo fgets($myfile);
// echo ftell($myfile);

// fseek($myfile,15); // change the curser postion ....
// echo fgets($myfile);


#read the full content inside of the file : -----------------------------------

// echo fpassthru($myfile);

#----------------------------------------change the curser position in 0:----------------------------------
// rewind($myfile);
// echo fpassthru($myfile);
#_________________________read line to line of file code : __________________________________________

// $file = fopen('shuvo.txt','r');
// while(!feof($file)){
//     $line = fgets($file);
//     echo "<br>".$line."<br>";
// }


#------------------------------------------- //Output lines until EOF is reached----------------------------------------------------------------

// $file = fopen('shuvo.txt','r');
//
// echo "<ul>";
// while(! feof($file)) {
//   $line = fgets($file);
//   echo "<li>". $line. "</li>";
// }
// echo "</ul>";
#---------------------------------------------//read the first character of file : --------------------------------------------------------------

// $file = fopen('shuvo.txt','r');

// echo fgetc($file);
// echo fgetc($file);
// echo fgetc($file);
#------------------------------------------------file content convert into array: -----------------------------------------------------------


// echo "<pre>";
// print_r(file('shuvo.txt'));
// echo "</pre>"; 
#---------------------------------------------------------------------------------------------
// $file = fopen("shuvo.txt", 'r+'); //------- add at the first line of the file and other content will be the same 

// fwrite($file,"\nHere is new line."); // fwrite(): write content inside of the file.

// echo fread($file,filesize('shuvo.txt'));
#-------------------------------------------w+ = over write of the file content .--------------------------------------------------
// $file = fopen('shuvo.txt','w+'); //w+ = over write of the file content .

// fwrite($file,'Here is the overwrite content.');
#-------------------------------------------fputs() same as : fwrite()---------------------------
// $file = fopen('shuvo.txt','a+'); //a+ = previous content +  write file content .

// fputs($file,"\nI am add ass end of the file content .");
#________________________________________ftruncate (file name, [keep content (size of content: 100byte)])__________________________________________

// $file = fopen('shuvo.txt','r+'); //a+ = previous content +  write file content .

// ftruncate($file,100); # keep 100 byte content inside of file and other content will be remove ...

// echo fread($file,filesize('shuvo.txt'));

// fclose($file); // end of the file operation.



?>