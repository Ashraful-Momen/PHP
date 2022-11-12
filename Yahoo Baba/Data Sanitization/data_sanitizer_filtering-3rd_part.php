
<?php

#very very importent => https://www.php.net/manual/en/filter.filters.sanitize.php


/*-------FILTER_SANITIZE_MAGIC_QUOTES  -- work same as addslashes() function------- */

/* Apply addslashes(). (DEPRECATED as of PHP 7.3.0 and REMOVED as of PHP 8.0.0, use FILTER_SANITIZE_ADD_SLASHES instead.) */
$var = "Yahoobaba's website!";
//$var = 'Yahoobaba"s website!';
//$var = 'Yahoobaba"s \website!';

echo filter_var($var, FILTER_SANITIZE_ADD_SLASHES)."<br>";

/*-------FILTER_SANITIZE_STRING------- */
/*Strip tags and HTML-encode double and single quotes, optionally strip or encode special characters.
 Encoding quotes can be disabled by setting FILTER_FLAG_NO_ENCODE_QUOTES.
  (Deprecated as of PHP 8.1.0, use htmlspecialchars() instead.)*/
$var = "<h1>Yahoo Baba</h1>";

echo filter_var($var, FILTER_FLAG_NO_ENCODE_QUOTES)."<br>";

/*-------FILTER_FLAG_ENCODE_AMP ------ Convert & to &amp------- */
/*Strip tags and HTML-encode double and single quotes, optionally strip or encode special characters.
 Encoding quotes can be disabled by setting FILTER_FLAG_NO_ENCODE_QUOTES.
 (Deprecated as of PHP 8.1.0, use htmlspecialchars() instead.) */
$var = "<h1>Yahoo & Baba</h1>";

echo filter_var($var, FILTER_FLAG_NO_ENCODE_QUOTES,FILTER_FLAG_ENCODE_AMP)."<br>";

/*-------Search (Ascii table) - for special characters------- */

//FILTER_FLAG_STRIP_HIGH --- ASCII value > 127
//FILTER_FLAG_STRIP_LOW  --- ASCII value < 32 
/*Strip tags and HTML-encode double and single quotes, optionally strip or encode special characters.
 Encoding quotes can be disabled by setting FILTER_FLAG_NO_ENCODE_QUOTES.
 (Deprecated as of PHP 8.1.0, use htmlspecialchars() instead.) */
$var = "<h1>Yahoo & BabaÈÒØ</h1>";
echo filter_var($var, FILTER_FLAG_NO_ENCODE_QUOTES,FILTER_FLAG_STRIP_HIGH)."<br>";

/*-------FILTER_SANITIZE_ENCODED - Encode every thing------- */
$var = "<h1>Yahoo Baba</h1>";

echo filter_var($var, FILTER_SANITIZE_ENCODED,FILTER_FLAG_STRIP_HIGH)."<br>";

/*-------FILTER_FLAG_STRIP_LOW - Remove characters with ASCII value < 32------- */
$var = "<h1>Yahoo Baba</h1>";

echo filter_var($var, FILTER_SANITIZE_ENCODED,FILTER_FLAG_STRIP_LOW)."<br>";

/*-------FILTER_FLAG_STRIP_HIGH - Remove characters with ASCII value > 127------- */
$var = "<h1>Yahoo Baba</h1>";

echo filter_var($var, FILTER_SANITIZE_ENCODED,FILTER_FLAG_STRIP_HIGH)."<br>";

/*-------FILTER_FLAG_ENCODE_LOW - Encode characters with ASCII value < 32------- */
$var = "<h1>Yahoo Baba</h1>";

echo filter_var($var, FILTER_SANITIZE_ENCODED,FILTER_FLAG_ENCODE_LOW)."<br>";

/*-------FILTER_FLAG_ENCODE_HIGH - Encode characters with ASCII value > 127------- */
$var = "<h1>Yahoo Baba</h1>";

echo filter_var($var, FILTER_SANITIZE_ENCODED,FILTER_FLAG_ENCODE_HIGH)."<br>";

/*-------FILTER_SANITIZE_SPECIAL_CHARS -- <>& and characters with ASCII value------- */
$var = "<h1>Yahoo & Baba</h1>";

echo filter_var($var, FILTER_SANITIZE_SPECIAL_CHARS);
?>