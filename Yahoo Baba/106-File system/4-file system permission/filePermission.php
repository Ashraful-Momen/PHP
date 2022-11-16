<?php 
// (user,group,world)=(7,6,4)
// 0	cannot read, write or execute(---)
// 1	can only execute(x)
// 2	can only write(w)
// 3	can write and execute(wx)
// 4	can only read(r)
// 5	can read and execute(rx)
// 6	can read and write(rw)
// 7	can read, write and execute(rwx)

#----------------------------------------
// Use the is_readable(), is_writable(), is_executable() to check if a file exists and readable, writable, and executable.
// Use the chmod() function to set permissions for a file.



/* -------Fileperms-------*/
echo fileperms("readme.txt") ."<br><br>";

echo decoct(fileperms("readme.txt")) ."<br><br>";

echo substr(decoct(fileperms("readme.txt")),2) ."<br><br>";

/* -------On SERVER-------*/

if(is_readable("readme.txt")){
  echo "Yes it is Readable.";
}else{
  echo "No it is not Readable.";
}

/* -------Read and write for owner, nothing for everybody else-------*/
chmod("readme.txt",0600); //last 3 digits is important

/* -------Read and write for owner, read for everybody else-------*/
chmod("readme.txt",0644);

/* -------Everything for owner, read and execute for everybody else-------*/
chmod("readme.txt",0755);

/* -------Everything for owner, read for owner's group-------*/
chmod("readme.txt",0740);
?>