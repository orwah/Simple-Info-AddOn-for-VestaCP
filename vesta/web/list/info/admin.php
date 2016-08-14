<?php
error_reporting(NULL);
session_start();

$TAB = 'info';

// Main include
include($_SERVER['DOCUMENT_ROOT']."/inc/main.php");

// Header
include($_SERVER['DOCUMENT_ROOT'].'/templates/header.html');


  
   $filename = "info.txt";
   

  //****************************************************************************
  // save text to file
  if ( isset($_POST['BtnSave'])) 
 {
  $file = fopen( $filename, "w" );

   if( $file == false ) 
   {
   echo ( "Error in opening file <BR /> Make Sure that File 'info.txt' owner is admin:admin (<b>or</b> set permission to 666 )." );
   exit();
   }    
      
   fwrite( $file, $_POST['info'] ); 
   
   fclose( $file );
     
  }     
   
   
   //***************************************************************************
   //Read text from File
 
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
  
  //echo ( "<pre>$filetext</pre>" );
         
 
  fclose( $file );  
  


  // Panel
top_panel($user,$TAB);  
?>

<div class="l-center">
<div class="l-center units">
<div class="l-unit " >
        
<table width="800">         
<tr height="230px"><td align="right" width="200"> &nbsp; </td><td width="25">&nbsp;&nbsp;&nbsp;</td><td width="575"> &nbsp; </td></tr>     
</table>

<?php
    
//******************************************************************************
// Preview

 if ( isset($_POST['BtnPreview'])) 
 {
     
 $filetext =  $_POST['info'];
 $filetext2 = $filetext;
 
 
 

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




// replace variables with Values :

$filetext2 = str_replace('%user%'       ,$user,$filetext2) ;
$filetext2 = str_replace('%domain%'     ,$U_Domain,$filetext2) ;
$filetext2 = str_replace('%domainslist%',$U_DomainList,$filetext2) ;
$filetext2 = str_replace('%date%'       ,$U_Date,$filetext2) ;
$filetext2 = str_replace('%ip%'         ,$U_IP,$filetext2) ;

echo ( $filetext2 );

echo '<HR />';

 }

 
// if is PlainText then DoNot show WISYWIG Editor :     
  if ( isset($_POST['BtnPlainText'])) { 
   $PlainText= 1;  }
?>


<p>Put Your Info Page here : </p>
<p>You can use this variables : %domain% , %domainslist% , %user% , %Date% , %ip% </p>

<form method="post" action="admin.php">

<p>
<input type="submit" name="BtnPreview" value="Preview">  &nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;
<input type="submit" name="BtnPlainText" value="PlainText">
</p>

<div id="sample">
<script src="images/nicEdit.js" type="text/javascript"></script>
<script type="text/javascript">
bkLib.onDomLoaded(function() {
//    new nicEditor().panelInstance('area1');
    new nicEditor({fullPanel : true}).panelInstance('area1');
//    new nicEditor({buttonList : ['bold','italic','underline','forecolor','fontSize','fontFamily','left','center','right','justify','link','unlink','ol','ul','indent','outdent','hr','removeformat']}).panelInstance('area1');
});
</script>

<textarea name="info" cols="115" style="height: 400px;" <?php if ($PlainText != 1) echo 'id="area1"'; ?> ><?php echo $filetext; ?></textarea> </div>

<p><input type="submit" name="BtnSave" value="Save Info"></p>
</form>

 
<p>&nbsp;</p>

</div>
</div>
</div>

<?php
// Back uri
$_SESSION['back'] = $_SERVER['REQUEST_URI'];

// Footer
include($_SERVER['DOCUMENT_ROOT'].'/templates/footer.html');
?>