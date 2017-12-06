<?php

header("Content-type: text/xml");


@include('function_mysqlConnectClass.php');

$dUser=new mysql_MediAccount();


$sql = "SELECT * FROM `AudioAIM` ORDER BY `id` DESC"; 



if(!$dUser->mysqlConnect("database",$sql)){
echo "Database error!";
}else{




$xml_output ="<?xml version=\"1.0\" encoding=\"iso-8859-1\"?>\n";
$xml_output .="<rss version=\"2.0\" xmlns:atom=\"http://www.w3.org/2005/Atom\">\n";
$xml_output .="<!-- site.net WinAmp Playlist Lister-mo-bob-thinger c/o Seth Dara! -->\n";
$xml_output .="\t<channel>\n";
$xml_output .="\t\t<title>site.net WinAmp Feed</title>\n";
$xml_output .="\t\t<language>en-us</language>\n";
$xml_output .="\t\t<description>winamp feed from Seth's computer, such a nerd</description>\n";
$xml_output .="\t\t<link>http://site.net/</link>\n";
$xml_output .="\t\t<atom:link href=\"http://site.net/pages/songlist.php\" rel=\"self\" type=\"application/rss+xml\" />\n";

//make sure to remove duplicatation
$bufferSongTitle="";

while($row = mysql_fetch_object($dUser->mysqlGetResults())){

//Correct the Entries to Output
if(stristr($row->SongTitle,"www.di.fm/mag")) continue;
if(stristr($row->SongTitle,"Get DI.fm")) continue;
if(stristr($row->SongTitle,"D I G I T A L L Y - I M P O R T E D")) continue;
if(stristr($row->SongTitle,"Sponsored Message (")) continue;
if(stristr($row->SongTitle,"Wolfservers.com")) continue;
if(strlen($row->SongTitle)<=0) continue;

if($bufferSongTitle==$row->SongTitle) continue; else $bufferSongTitle=$row->SongTitle;

$crapDate=explode("/",$row->LastUpdate_Date);
$crapTime=explode(":",$row->LastUpdate_Time);
$crapAMPM=explode(" ",$crapTime[2]);
//$fixdtime= ($crapAMPM[1]=="PM" && $crapTime[0]!=12) ? $crapTime[0]+12 : $crapTime[0] ;
//$fixdtime= ($crapAMPM[1]=="PM" && $crapTime[0]==12) ? $crapTime[0]+12 : $crapTime[0] ;


$myTime= date("H:i:s", strtotime("$crapTime[0]:$crapTime[1]:$crapTime[2] $crapTime[3]")); 
$myTime = explode(":",$myTime);

$finalPD = date("D, d M Y H:i:s \E\S\T", mktime($myTime[0], $myTime[1], $myTime[2], $crapDate[0], $crapDate[1], $crapDate[2]));


$xml_output .="\t\t\t<item>\n";
        $finalST = str_replace("&", "&amp;", $row->SongTitle);
        $finalST = str_replace("<", "&lt;", $finalST);
        $finalST = str_replace(">", "&gt;", $finalST);
        $finalST = str_replace("\"", "&quot;", $finalST);
$xml_output .="\t\t\t\t<title>" . $finalST . "</title>\n";
$xml_output .="\t\t\t\t<pubDate>".$finalPD."</pubDate>\n";
$xml_output .="\t\t\t\t<guid isPermaLink=\"false\">SONG NUMBER ".$row->id." PLAYED AT ".$finalPD."</guid>\n";
$xml_output .="\t\t\t</item>\n";


}


$xml_output .="\t</channel>\n";
$xml_output .="</rss>\n";

}

echo $xml_output;

?> 