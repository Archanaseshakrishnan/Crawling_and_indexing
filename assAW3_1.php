<?php
include 'assAW3.php';
$a="";
function clean($string) {
   $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

   return preg_replace('[^A-Za-z0-9\-]', '', $string); // Removes special chars.
}
$i=0;
 foreach($arr as $a){
	$main_url2=$a;
	 
 $str2 = file_get_contents($main_url2);
 $b2 =$main_url2;
 @$url2 = parse_url($b2);
 $doc = new DOMDocument; 
 @$doc->loadHTML($str2); 
 #echo $a."<br>";
 $div = $doc->getElementsByTagName('div');
 $j=0;
 $set = " ";
 $fname = "default";
 foreach($div as $d)
 {
	 if($d->getAttribute('class')=="mw-parser-output"){
		echo "$j"."<br>";
		$child = $d->childNodes;
		foreach($child as $b){
			if($b->nodeName=='h1' || $b->nodeName=='h2'){
				if($set != " "){
					$file = "C:\wamp64\www\project1\assi3\\files\\".$fname.".txt";
					file_put_contents($file, $set, FILE_APPEND | LOCK_EX);
				}
				$fname = $b->nodeValue;
				$fname = preg_replace("/[^a-zA-Z]/", "", $fname);
				echo $fname."<br>";
				//$b->nodeValue . "<br>";
			}else{
				$set .= $b->nodeValue."<br>";
			}
		}
		if($set != " "){
			$file = "C:\wamp64\www\project1\assi3\\files\\".$fname.".txt";
			file_put_contents($file, $set, FILE_APPEND | LOCK_EX);
		}
	 }
	 $j = $j+1;
 }
 //echo $str2;
 //$file = "C:\wamp64\www\project1\assi3\\files\\"."file".$i.".txt";
 //echo $file."<br>";
 //$i+=1;
 
 //$div = $doc->getElementsByTagName('div');
 
 //file_put_contents($file, $str2, FILE_APPEND | LOCK_EX);
 }
?>