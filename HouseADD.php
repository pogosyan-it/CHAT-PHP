<html>    <title>���������� ������ � ����������</title>
<head>   <link rel="shortcut icon" href="dimex.jpg" type="image/x-icon">
<meta http-equiv="content-type" content="text/html; charset=cp1251">
 <link rel="stylesheet" href="stylestreet.css"  type="text/css">
 <style type="text/css">
   table {
    width: 300px; /* ������ ������� */
    margin: auto; /* ����������� ������� �� ������ ����  */
   }
      td
 {
 border: 1px #336699 solid;  
 }
 .my_button {
    width: 170px;
    height: 30px;
border-radius: 5px; box-shadow: 1px 1px 2px; font-size: 15px
}
.my_button1 {
    width: 200px;
    height: 35px;
border-radius: 10px; box-shadow: 0px 0px 5px; font-size: 16px
}
 </style>
 <?php  
include 'profilaktika.php'; 
?>
 </head>
<body>
<br/>
<form method="POST" action="">
  <input <button style="background: #00FF80; width: 70px; height: 40px; 
border-radius: 5px; box-shadow: 0px 1px 3px; font-size: 17px; text-align: center;" type="submit" value="�����" name="but"></button></form> 
        <br/>  
<form action="Menu.php">
    <button style="background: #D8D8D8; width: 90px; height: 35px; 
border-radius: 5px; box-shadow: 0px 1px 3px; font-size: 17px; text-align: center;" type="submit">�����</button>
</form> 
   <h3><div align="center" >���������� ������ � ����������</div></h3>
<?php
session_start(); //��������� ������ 
 $FilePHP = $_SERVER['PHP_SELF'];
 $LogIP=$_SERVER['REMOTE_ADDR'];
 $Login = $_SESSION['login']; 
if (@$_POST['but'] == true){
unset($_SESSION['login']);
unset($_SESSION['HouseADD']);
header("Location: index.php");
}
if(!isset($_SESSION['login'])){
     header("Location: index.php");
     exit;                       }  
if(!isset($_SESSION['HouseADD'])){
     header("Location: Menu.php");
     exit;                    }  

 echo "<h2 style=\"color:#DF7401;\">� ������ ������������� � ���� ����, �������� � ���� ������ �� �����, �������, �������� � �������� ����������!";
     echo "<h2 style=\"color:#B45F04;\">�� ������ ���� ������� � ���� ����� ���������!";    
  #   echo "<h2 style=\"color:#B40404;\">������� �������� ������������ ���� ��� ����������!";   
 
   include 'gsotldb.php'; 
   
if (!$link) { 
   printf("���������� ������������ � ���� ������. ��� ������: %s\n", mysqli_connect_error()); 
   exit; 
}
 
 
?>  
<br/>
<table>
    <tr>
        <td colspan="2"> <center><form action="HouseADD.php" name="mainform" method="post"
		<label for="street"><font size="4" color="red"><b>��������:</b></font></label>  <br/>   
               <br/><br/><input type="text" name="street" size="50"> </td>
       
        <td></select>
  <?php 
                      
   echo "<h2 style=\"color:red;\"><center><font size=\"4\">���:</font>";
   echo "<br/><center><form method='post' action=''>
      <br/><select name='street_pref'>
      <option value=''>�������� ���</option>";     
	  
      
$res_pref =  mysqli_query($link, "Select hbc_stritpref.Name from hbc_stritpref where hbc_stritpref.ID not in (0) order by Full") ;                 
 
while ($row = mysqli_fetch_assoc($res_pref)){
 

echo "<option value='".$row['Name']."'>".$row['Name']." </option>";

} 
   ?>
                   </select></td>
        <td><?php 

   echo "<center>�������:";
   echo "<center><form method='post' action=''>
      <br/><br/><select name='street_suf'>
      <option value=''>�������� �������</option>";     
	  
      
$res_suf =  mysqli_query($link, "Select hbc_stritsuf.Name from hbc_stritsuf") ;                 
 
while ($row = mysqli_fetch_assoc($res_suf)){
 

echo "<option value='".$row['Name']."'>".$row['Name']." </option>";

}?>
    </td>
    <td>
       <?php 

   echo "<h2 style=\"color:red;\"><center><font size=\"4\">�������:</font>";
   echo "<br/>";
   echo "<br/><center><form method='post' action=''>
      <select name='route'>
      <option value=''> �������� ������� </option>";   
	                                               
$resul =  mysqli_query($link, "select hbc_routes.Name from hbc_routes where hbc_routes.SY_Void ='0' and hbc_routes.Name not like   ('%.T%')
 and hbc_routes.ID not in (201,202,203,204,205,206,207,208,209,210,211,231,244,232,243) order by Name");
               
 while ($row = mysqli_fetch_assoc($resul)){
 

echo "<option value='".$row['Name']."'>".$row['Name']." </option>";

}
?>
   </td>
    </tr>
    <tr>
        <td><label for="home"><center><font size="4" color="red"><b>� ����:</b</font></label> 
                    <center><br/><input type="text" name="home" size="4"></td><br/>   
        <td><font size="4"><label for="drob"><center>�����:</font></label><br/>
                    <br/><input type="text" name="drob" size="4"><br/></td>
        <td><font size="4"><label for="corp"><center>������:</font></label><br/>
                    <br/><input type="text" name="corp" size="4"><br/></td>
        <td><font size="4"><label for="stroen"><center>��������:</font></label><br/>
                    <br/><input type="text" name="stroen" size="4"><br/></td>
        <td><font size="4"><label for="vlad"><center>��������:</font></label><br/>
                    <br/><input type="text" name="vlad" size="4"><br/></td>
    </tr>
    <tr>
        <td colspan="5"> 
<?php 		
   echo "<br/>";
echo "<center><input type='submit' value='�������� �����' class='my_button'</input>"; 
echo "</select></form></center>"; 
echo "<br/>";
 ?> 
    </td>
    </tr>
</table>

<?php  

  $str_pref=@$_POST['street_pref'];       
 
    $res =  mysqli_query($link, "Select hbc_stritpref.Name from hbc_stritpref where hbc_stritpref.Name='$str_pref'"); 
					         while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC))
					   {
						   $pref=$row['Name'];
					   }
					    #echo $pref;
						mysqli_free_result($res);
  $str_suf=@$_POST['street_suf'];
 
  $route=@$_POST['route'];

  $street=@$_POST['street'];
#echo $street;
                 
  $home=@$_POST['home'];
  $drob=@$_POST['drob'];
  $corp=@$_POST['corp'];
  $stroen=@$_POST['stroen'];
  $vlad=@$_POST['vlad'];
  $street_full=$street.' '.$str_suf.' '.$pref;
  $street_Not_Suf=$street.' '.$pref;
 # echo $street_full, $street_Not_Suf;
  $un_num = preg_replace('/[^0-9]/', '', $street);
  $street_sname=explode(" $un_num", $street);
  $street_sname=@$street_sname[0];
    if (!empty($str_suf))  
{
$street_full=$street.' '.$str_suf.' '.$pref;
}
  else 
{
$street_full=$street.' '.$pref;
}

    if (!empty($un_num))  
{
$street=$street_sname;
}
  else 
{
$street=$street;
}
    
  if ($_SERVER['REQUEST_METHOD'] == "POST")  {
	  
   if (!(preg_match("/^[0-9\s]/",@$street[0]))) {       // �������� �� ������� ���� � ������
	if (!empty($street)&&!empty($home)&&!empty($route)&&!empty($str_pref))     // �������� �� ���������� �����

    {
       	     
		     $res =  mysqli_query($link, "Select sName from hbc_strits where hbc_strits.sName='$street_full' and hbc_strits.CityID = '2'");  
                     while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) 
                {
				   #printf($row['sName']);
				   $ssp=$row['sName'];
				}
  
                    #echo $ssp;
                    mysqli_free_result($res);
			  $res =  mysqli_query($link, "Select SNValue from hbc_stritselfnames where hbc_stritselfnames.SNValue='$street'");  
                     while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) 
                {
				     $snv=$row['SNValue'];
				}
  
                    #echo $snv;
                    mysqli_free_result($res);
         
		       if (!empty($ssp))                 //���� ����� ����������
	                {
		             
		             $res =  mysqli_query($link, "SELECT Num FROM hbc_houses
                                                  left join hbc_strits on hbc_strits.ID=hbc_houses.StreetID
                                                  WHERE hbc_houses.Num='$home' and hbc_strits.sName='$street_full' and hbc_strits.CityID = '2'"); 
					         while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC))
					   {
						   $house=$row['Num'];
					   }
					    #echo $house;
						mysqli_free_result($res);
	                 
					 if (!empty($house))               //���� ��� ����������
						  
						  { 
						    echo "<h2 style=\"color:red;\">��� �$home �� ������ $street_full ��� ����������</h2>";
						  }
					  
/*Action1 */					  else {                                    //���� ���� ���, ���������
							$res =  mysqli_query($link, "Select hbc_routes.ID from hbc_routes where hbc_routes.Name='$route' into @rid");  
							$res =  mysqli_query($link, "Select ID from hbc_strits where hbc_strits.sName='$street_full' into @sid");  
                            $res =  mysqli_query($link, "Insert into hbc_houses VALUES();");
                            $res =  mysqli_query($link, "Select MAX(ID) from hbc_houses into @mid");  							
							$res =  mysqli_query($link, "Update hbc_houses SET hbc_houses.StreetID=@sid, 
							                             hbc_houses.Num='$home', hbc_houses.Num2='$drob',hbc_houses.Corp='$corp', hbc_houses.Bild='$stroen', 
							                             hbc_houses.Vlad='$vlad', hbc_houses.RouteID=@rid  where hbc_houses.id=@mid");
							$res =  mysqli_query($link, "Update hbc_houses SET hbc_houses.Corp = null where hbc_houses.Corp=''");
                            $res =  mysqli_query($link, "Update hbc_houses SET hbc_houses.Num2 = null where hbc_houses.Num2=''");
                            $res =  mysqli_query($link, "Update hbc_houses SET hbc_houses.Bild = null where hbc_houses.Bild=''");
                            $res =  mysqli_query($link, "Update hbc_houses SET hbc_houses.Vlad = null where hbc_houses.Vlad=''");
							
							  
                if  ($res == 'true') {
                          $res =  mysqli_query($link, "Insert into PHP_Log VALUES(DEFAULT, '$FilePHP Action1', '$Login', '$LogIP', NOW(),
                                                     'existStreet=$street_full ::Num=$home ::Num2=$drob ::Corp=$corp ::Bild=$stroen ::Vlad=$vlad ::RouteID=$route')");                    
echo "<h2 style=\"color:green;\">��� $home $drob $corp $stroen $vlad $street_full  �� �������� $route ��������!</h2>"; 
                              }
      else		                   
               {
echo "<h2 style=\"color:red;\">��������� ������ ��� ����������</h2>";
                }
						  }
					}	
                
/*Action2 */				  elseif (empty($ssp)&&empty($snv))  {       //���� ����� ���, ���������
						  $res =  mysqli_query($link, "Insert into hbc_stritselfnames VALUES()");  // +
							$res =  mysqli_query($link, "Select MAX(ID) from hbc_stritselfnames into @mid"); // +
							$res =  mysqli_query($link, "Update hbc_stritselfnames SET hbc_stritselfnames.SNValue=UPPER('$street') where hbc_stritselfnames.ID=@mid "); // +
							$res =  mysqli_query($link, "Insert into hbc_strits VALUES()");// +
							$res =  mysqli_query($link, "Select hbc_routes.ID from hbc_routes where hbc_routes.Name='$route' into @rid");
							$res =  mysqli_query($link, "Select hbc_stritsuf.ID from hbc_stritsuf where hbc_stritsuf.Name='$str_suf' into @sufid");
							$res =  mysqli_query($link, "Select hbc_stritpref.ID from hbc_stritpref where hbc_stritpref.Full='$str_pref' into @prefid ");
							$res =  mysqli_query($link, "Select MAX(ID) from hbc_strits into @msid");
							$res =  mysqli_query($link, "Update hbc_strits SET hbc_strits.CityID='2' where hbc_strits.ID=@msid ");
							$res =  mysqli_query($link, "Update hbc_strits SET hbc_strits.SNameID=@mid where hbc_strits.ID=@msid ");
							$res =  mysqli_query($link, "Update hbc_strits SET hbc_strits.PrefID=UPPER(@prefid) where hbc_strits.ID=@msid ");
							$res =  mysqli_query($link, "Update hbc_strits SET hbc_strits.SufID=UPPER(@sufid) where hbc_strits.ID=@msid ");
							$res =  mysqli_query($link, "Update hbc_strits SET hbc_strits.sName=UPPER('$street_full') where hbc_strits.ID=@msid ");
							$res =  mysqli_query($link, "Update hbc_strits SET hbc_strits.UnUnicNumber='$un_num' where hbc_strits.ID=@msid ");
						#	$res =  mysqli_query($link, "Update hbc_strits SET hbc_strits.RouteID=@rid where hbc_strits.ID=@msid ");
							$res =  mysqli_query($link, "Insert into houses VALUES();");
                            $res =  mysqli_query($link, "Select MAX(ID) from hbc_houses into @hid");  							
							$res =  mysqli_query($link, "Update hbc_houses SET hbc_houses.StreetID=@msid, 
							                             hbc_houses.Num='$home', hbc_houses.Num2='$drob',hbc_houses.Corp='$corp', hbc_houses.Bild='$stroen', 
							                             hbc_houses.Vlad='$vlad', hbc_houses.RouteID=@rid  where hbc_houses.id=@hid");
							$res =  mysqli_query($link, "Update hbc_houses SET hbc_houses.Corp = null where hbc_houses.Corp=''");
                            $res =  mysqli_query($link, "Update hbc_houses SET hbc_houses.Num2 = null where hbc_houses.Num2=''");
                            $res =  mysqli_query($link, "Update hbc_houses SET hbc_houses.Bild = null where hbc_houses.Bild=''");
                            $res =  mysqli_query($link, "Update hbc_houses SET hbc_houses.Vlad = null where hbc_houses.Vlad=''");	
                                
								   if  ($res == 'true') {   
             $res =  mysqli_query($link, "Insert into PHP_Log VALUES(DEFAULT, '$FilePHP Action2', '$Login', '$LogIP', NOW(),
'NewNewStreet=$street ::Name=$str_suf ::Full=$str_pref ::sName=$street_full ::UnUnicNumber=$un_num ::Num=$home ::Num2=$drob ::Corp=$corp ::Bild=$stroen ::Vlad=$vlad ::RouteID=$route')");
                                                           echo "<h2 style=\"color:green;\">��� $home $drob $corp $stroen $vlad $street_full  �� �������� $route ��������!</h2>"; 
                                                        }
                                          else		                   
                                                        {
                                                           echo "<h2 style=\"color:red;\">��������� ������ ��� ����������</h2>";
                                                        }							
					     } 
/*Action3 */	   elseif (empty($ssp)&&!empty($snv))       //���� ���� hbc_stritselfnames, �� ��������� ����� � ���
				 {       
						    $res =  mysqli_query($link, "Select ID from hbc_stritselfnames where hbc_stritselfnames.SNValue='$street' into @mid"); // +
							$res =  mysqli_query($link, "Insert into hbc_strits VALUES()");// +
							$res =  mysqli_query($link, "Select hbc_routes.ID from hbc_routes where hbc_routes.Name='$route' into @rid");
							$res =  mysqli_query($link, "Select hbc_stritsuf.ID from hbc_stritsuf where hbc_stritsuf.Name='$str_suf' into @sufid");
							$res =  mysqli_query($link, "Select hbc_stritpref.ID from hbc_stritpref where hbc_stritpref.Full='$str_pref' into @prefid ");
							$res =  mysqli_query($link, "Select MAX(ID) from hbc_strits into @msid");
							$res =  mysqli_query($link, "Update hbc_strits SET hbc_strits.CityID='2' where hbc_strits.ID=@msid ");
							$res =  mysqli_query($link, "Update hbc_strits SET hbc_strits.SNameID=@mid where hbc_strits.ID=@msid ");
							$res =  mysqli_query($link, "Update hbc_strits SET hbc_strits.PrefID=UPPER(@prefid) where hbc_strits.ID=@msid ");
							$res =  mysqli_query($link, "Update hbc_strits SET hbc_strits.SufID=UPPER(@sufid) where hbc_strits.ID=@msid ");
							$res =  mysqli_query($link, "Update hbc_strits SET hbc_strits.sName=UPPER('$street_full') where hbc_strits.ID=@msid ");
							$res =  mysqli_query($link, "Update hbc_strits SET hbc_strits.UnUnicNumber='$un_num' where hbc_strits.ID=@msid ");
						#	$res =  mysqli_query($link, "Update hbc_strits SET hbc_strits.RouteID=@rid where hbc_strits.ID=@msid ");
							$res =  mysqli_query($link, "Insert into houses VALUES();");
                            $res =  mysqli_query($link, "Select MAX(ID) from hbc_houses into @hid");  							
							$res =  mysqli_query($link, "Update hbc_houses SET hbc_houses.StreetID=@msid, 
							                             hbc_houses.Num='$home', hbc_houses.Num2='$drob',hbc_houses.Corp='$corp', hbc_houses.Bild='$stroen', 
							                             hbc_houses.Vlad='$vlad', hbc_houses.RouteID=@rid  where hbc_houses.id=@hid");
							$res =  mysqli_query($link, "Update hbc_houses SET hbc_houses.Corp = null where hbc_houses.Corp=''");
                            $res =  mysqli_query($link, "Update hbc_houses SET hbc_houses.Num2 = null where hbc_houses.Num2=''");
                            $res =  mysqli_query($link, "Update hbc_houses SET hbc_houses.Bild = null where hbc_houses.Bild=''");
                            $res =  mysqli_query($link, "Update hbc_houses SET hbc_houses.Vlad = null where hbc_houses.Vlad=''");	
                                
								   if  ($res == 'true') {   
                   $res =  mysqli_query($link, "Insert into PHP_Log VALUES(DEFAULT, '$FilePHP Action3', '$Login', '$LogIP', NOW(),
'NewStreet=$street ::Name=$str_suf ::Full=$str_pref ::sName=$street_full ::UnUnicNumber=$un_num ::Num=$home ::Num2=$drob ::Corp=$corp ::Bild=$stroen ::Vlad=$vlad ::RouteID=$route')");
                                                           echo "<h2 style=\"color:green;\">��� $home $drob $corp $stroen $vlad $street_full  �� �������� $route ��������!</h2>"; 
                                                        }
                                          else		                   
                                                        {
                                                           echo "<h2 style=\"color:red;\">��������� ������ ��� ����������</h2>";
                                                        }

						 
	    }
		  else { echo "<h2 style=\"color:red;\">��������� ������ ��� ����������</h2>";}
	
	}
	else {
	echo "<h2 style=\"color:red;\">��������� ����������� ���� � �������� �������</h2>";
#echo "<a href='javascript:history.go(-1)'>�����</a>";
}
} else { 
         echo "<h2 style=\"color:red;\">��������� ������ ��� ����������, ���������� � IT �����</h2>";
         }  
  }
?>
</body>
</html>