<?
if($AApw=="sethrules"){

$filename = "pages/includes/AudioAimWebApplication.display" ; 
$file = file($filename); 
$fd = fopen ($filename , "w"); 
$message="<? ";
$message.="\$PlaySong=\"$CurrentSong\";";
$message.="\$PlayTime=\"$Time\";";
$message.="\$PlayDate=\"$Date\";";
$message.=" ?>";
$fout= fwrite ($fd , "$message");
fclose($fd);

include('pages/includes/aaDBADD.php');

?>
Audio Application Running Normally
<?
}else{
?>
You are not authorized to use this application.
<?
}
?>