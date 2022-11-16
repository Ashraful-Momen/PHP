<?php
/* -------Is File Function-------*/
if(is_file("readme.txt")){
  echo "Yes it is File.". "<br><br>"; 
}else{
  echo "No it is not file." . "<br><br>";
}

/* -------Is Direct Function-------*/
if(is_dir("test")){
  echo "Yes it is Folder." . "<br><br>";
}else{
  echo "No it is not Folder." . "<br><br>";
}

/* -------Is Writeable Function-------*/
if(is_writeable("test.txt")){
   echo "Yes it is writeable." . "<br><br>";
}else{
  echo "No it is not writeable." . "<br><br>";
}

/* -------Is Readable Function-------*/
if(is_readable("readme.txt")){
  echo "Yes it is Readable." . "<br><br>";
}else{
  echo "No it is not Readable." . "<br><br>";
}

/* -------Is Executable Function-------*/
if(is_executable("readme.txt")){
  echo "Yes it is Executable." . "<br><br>";
}else{
  echo "No it is not Executable." . "<br><br>";
}

/* -------Is Executable Function-------*/
if(is_executable("setup.exe")){
  echo "Yes it is Executable.";
}else{
  echo "No it is not Executable.";
}

?>