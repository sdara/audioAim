<?
@include('AudioAimWebApplication.display');
if(isset($PlaySong) && isset($PlayTime) && isset($PlayDate) && (substr($PlaySong, 0, 4)!="http" && substr($PlaySong, 0, 4)!="[Con" && substr($PlaySong, 0, 4)!="[Buf" && substr($PlaySong, 0, 4)!="[ICY")){
@include('../function_mysqlConnectClass.php');

$dUser=new mysql_MediAccount();
$sql1 = "SELECT `SongTitle` FROM `AudioAIM` ORDER BY `id` DESC LIMIT 1"; 
if(!$dUser->mysqlConnect("database",$sql1)){
echo "Database error!";
}else{
$row = mysql_fetch_object($dUser->mysqlGetResults());
if($row->SongTitle != $PlaySong)
{

$dUser=new mysql_MediAccount();
$sql = "INSERT INTO `AudioAIM` (`SongTitle`, `LastUpdate_Time`, `LastUpdate_Date`) VALUES ('$PlaySong','$PlayTime','$PlayDate')"; 



if(!$dUser->mysqlConnect("site_net_-_site",$sql)){
echo "Database error!";
}else{
?>
echo "Playlist Information:<BR>";
echo $PlaySong."<BR>";
echo $PlayTime."<BR>";
echo $PlayDate."<BR>";
<?
}
}
}
}


?>