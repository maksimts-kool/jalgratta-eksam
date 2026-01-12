<?php  
 require_once("konf.php");  
 if(!empty($_REQUEST["teooriatulemus"])){ 
 $kask=$yhendus->prepare( 
 "UPDATE jalgrattaeksam SET teooriatulemus=? WHERE id=?"); 
$kask->bind_param("ii", $_REQUEST["teooriatulemus"], $_REQUEST["id"]); $kask->execute(); 
 } 
 $kask=$yhendus->prepare("SELECT id, eesnimi, perekonnanimi   FROM jalgrattaeksam WHERE teooriatulemus=-1"); 
 $kask->bind_result($id, $eesnimi, $perekonnanimi); 
 $kask->execute(); 
?>
<!doctype html>
<html>

<head>
    <title>Teooriaeksam</title>
</head>

<body>
    <table>
        <?php 
 while($kask->fetch()){ 
 echo " 
 <tr> 
 <td>$eesnimi</td> 
 <td>$perekonnanimi</td> 
 <td><form action=''> 
 <input type='hidden' name='id' value='$id' /> 
 <input type='text' name='teooriatulemus' />
 <input type='submit' value='Sisesta tulemus' /> 
 </form> 
 </td> 
</tr> 
 "; 
} 
 ?>
    </table>
</body>

</html>