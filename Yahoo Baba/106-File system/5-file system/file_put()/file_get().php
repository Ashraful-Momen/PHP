<?php

$file = fopen('read.txt','r');
// $myfile = fopen("shuvo.txt", "r"); // fopen: for create or open file .... mode: r,r+,w,w+,a,a+,x,x+...

// echo fread($myfile,100);
// echo fread($file,filesize('read.txt'));

#file_put_contents('file','data',mode,context=optional)

file_put_contents('read.txt','Put those content inside of the file . ');

file_put_contents('read.txt','new text with mode ',FILE_APPEND ); #File_Append (a+) = previous content+ new content
file_put_contents('read.txt','new text with mode ', LOCK_EX); # Lock_EX = fclose() /execute; #overwrite the whole content cause of FILE_Append is not use in here .

// echo file_get_contents('read.txt');

#file_get_contents('file','path = False(optional)',context=NULL(optional),start_point,end_point[file_size])
echo file_get_contents("read.txt",FALSE, NULL, 0, 36). "<br><br>"; 