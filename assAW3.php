<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'crawler');
 $main_url="https://en.wikibooks.org/wiki/Java_Programming";
 $str = file_get_contents($main_url);
 
 // Gets Webpage Title
 if(strlen($str)>0)
 {
  $str = trim(preg_replace('/\s+/', ' ', $str)); // supports line breaks inside <title>
  preg_match("/\<title\>(.*)\<\/title\>/i",$str,$title); // ignore case
  $title=$title[1];
 }
	
 // Gets Webpage Description
 $b =$main_url;
 @$url = parse_url( $b );
// @$tags = get_meta_tags($url['scheme'].'://'.$url['host'] );
// $description=$tags['description'];
	
 // Gets Webpage Internal Links
 $doc = new DOMDocument; 
 @$doc->loadHTML($str); 
 
 $items = $doc->getElementsByTagName('ul'); 
 $arr = array();
 foreach($items as $value) 
 { 
  if($value->parentNode->nodeName == 'div' && $value->parentNode->getAttribute('class') == 'mw-parser-output'){
  $value1 = $value->getElementsByTagName('a');
  
  foreach($value1 as $v){
	  
	//$attrs = $v->attributes; 
	//$sec_url[]=$attrs->getNamedItem('href')->nodeValue;
	$parent = $v->parentNode;
	if($parent->nodeName == 'li')
	{#echo $v->getAttribute('href'), '<br>';	
	array_push($arr,"https://en.wikibooks.org".$v->getAttribute('href'));}
  }
  }
 }
// $all_links=implode(",",$sec_url);
// print $all_links;
 // Store Data In Database
 $con = @mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) or die("Failed to connect to MySQL: " . mysql_error());
 $db = mysql_select_db(DB_NAME, $con) or die("Failed to connect to MySQL: " . mysql_error());
 foreach($arr as $all_links)
 
 //mysql_query("delete from webpage_details");
 $res = mysql_query("insert into webpage_details values('$main_url','$title','$all_links')");
 //$res2 = mysql_query("select * from webpage_details");
 //echo mysql_num_rows($res2);
  
?>
