<?php
error_reporting(NULL);
session_start();

$TAB = 'INFO';

// Main include
include($_SERVER['DOCUMENT_ROOT']."/inc/main.php");

// Header
include($_SERVER['DOCUMENT_ROOT'].'/templates/header.html');

// Panel
top_panel($user,$TAB);


//******************************************************************************
// Get Variables Data :
//  $U_domain ,$U_domainslist ,$U_Date ,$U_IP  

exec (VESTA_CMD."v-list-web-domains ".$user." json", $output, $return_var);
$maindomains = json_decode(implode('', $output), true);
unset($output);

foreach ($maindomains as $key => $value) { $U_Domain= htmlentities($key); Break;}


$U_DomainList = "";
foreach ($maindomains as $key => $value) { $U_DomainList.= htmlentities($key)."<br />"; }

$U_Date = $maindomains[$U_Domain]['DATE'];

$U_IP = $maindomains[$U_Domain]['IP'];

//$U_Alias = [$U_Domain]['ALIAS']

?>

<div class="l-center">


        
<table width="800">         
<tr height="230px"><td align="right" width="200"> &nbsp; </td><td width="25">&nbsp;&nbsp;&nbsp;</td><td width="575"> &nbsp; </td></tr>     
</table>


<?php

//Open and read file text :

$filename = "info.txt";
$file = fopen( $filename, "r" );

if( $file == false ) {
echo ( "Error in opening file" );
exit();
}

$filesize = filesize( $filename );
if( $filesize <= 0 ) {
echo ( "File Is Empty !" );
 // exit();
 $filetext = "";
  }
  else     
  $filetext = fread( $file, $filesize );

  //$filetext = htmlspecialchars($filetext);

  
  
  
// replace variables with Values :
  
$filetext = str_replace('%user%'       ,$user       ,$filetext) ;  
$filetext = str_replace('%domain%'     ,$U_Domain     ,$filetext) ;
$filetext = str_replace('%domainslist%',$U_DomainList,$filetext) ; 
$filetext = str_replace('%date%'       ,$U_Date   ,$filetext) ;
$filetext = str_replace('%ip%'         ,$U_IP     ,$filetext) ;
//$filetext = str_replace('%ServerDomain%','your-server.com',$filetext) ;
//$filetext = str_replace('%ServerMail%','support@your-server.com',$filetext) ;

echo $filetext ;

fclose( $file );

?>




</div>



<?php

// Back uri
$_SESSION['back'] = $_SERVER['REQUEST_URI'];

// Footer
include($_SERVER['DOCUMENT_ROOT'].'/templates/footer.html');
