<html>    <title>���������� �� � ����������</title>
<head>    <link rel="shortcut icon" href="dimex.jpg" type="image/x-icon">
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
    width: 220px;
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
<br/><form method="POST" action="">
  <input <button style="background: #00FF80; width: 70px; height: 40px; 
border-radius: 5px; box-shadow: 0px 1px 3px; font-size: 17px; text-align: center;" type="submit" value="�����" name="but"></button></form> 
        <br/>  
<form action="Menu.php">
    <button style="background: #D8D8D8; width: 90px; height: 35px; 
border-radius: 5px; box-shadow: 0px 1px 3px; font-size: 17px; text-align: center;" type="submit">�����</button>
</form> 
   <h3><div align="center" >���������� �� � ����������</div></h3>
<?php
session_start(); //��������� ������ 
 $FilePHP = $_SERVER['PHP_SELF'];
 $LogIP=$_SERVER['REMOTE_ADDR'];
 $Login = $_SESSION['login']; 
if (@$_POST['but'] == true){
unset($_SESSION['login']);
unset($_SESSION['CityADD']);
header("Location: index.php");
}
if(!isset($_SESSION['login'])){
     header("Location: index.php");
     exit;                       }  
if(!isset($_SESSION['CityADD'])){
     header("Location: Menu.php");
     exit;                    }  

 echo "<h3 style=\"color:#DF7401;\">�������\���� ��������� ��� ���������� ������ � ������ ���������� �� �� ��!";
     echo "<h3 style=\"color:#B22222;\">����� ���� ��������� ������ ��� �������� �� � ��!";    
echo "<br/>"; 

     include 'gsotldb.php'; 

if (!$link) { 
   printf("���������� ������������ � ���� ������. ��� ������: %s\n", mysqli_connect_error()); 
   exit; 
}
    
?>  
<br/>
<table>
    <tr>
        <td> <center><form action="CityADD.php" name="mainform" method="post"<br/>
	<label for="city"><font  color="red"><b>���������� �����:</b</font></label> 
               <br/><br/><br/><input type="text" name="city" size="40"> </td>
        <td></select>
  <?php 
     
   echo "<br/>";
    echo "<h2 style=\"color:red;\"><center><font size=\"3\">������</font>";
      echo "<br/><center><form method='post' action=''>
      <br/><select name='country'>
      <option value=''>�������� ������</option>";     
	  
      
$country =  mysqli_query($link, "SELECT hbc_country.Name FROM hbc_country ORDER BY id=7 DESC, id=18 DESC, id=113 DESC, id=173 DESC, id=70 DESC, name ASC") ;                 
 
while ($row = mysqli_fetch_assoc($country)){
 

	echo "<option value='".$row['Name']."'>".$row['Name']." </option>";
}                   
  
   ?>
                   </select></td>
      <td colspan="2">
       <?php 
   echo "<br/>";
   echo "<h2 style=\"color:#DF7401;\"><center><font size=\"3\">�������\����</font>";
   echo "<br/>";
   echo "<br/><center><form method='post' action=''>
      <select name='region'>
      <option value=''>�������� �������\����</option>";   
	                                               
$region=  mysqli_query($link, "Select hbc_fedunits.Name from hbc_fedunits order by Name");
               
 while ($row = mysqli_fetch_assoc($region)){
                                               
echo "<option value='".$row['Name']."'>".$row['Name']." </option>";
       }
?>
   </td>
    </tr>
    <tr>               
                <td><?php 

   echo "<br/>";
   echo "<h2 style=\"color:red;\"><center><font size=\"3\">��� ����������� ������</font>";
     echo "<br/><center><form method='post' action=''>
      <br/><select name='city_type'>
      <option value=''>�������� ���</option>";     
	  
      
$city_type =  mysqli_query($link, "Select hbc_fedunittypes.Name from hbc_fedunittypes order by Name") ;                 
 
while ($row = mysqli_fetch_assoc($city_type)){
 

echo "<option value='".$row['Name']."'>".$row['Name']." </option>";

}?>
    </td>
          <td>
       <?php 
   echo "<br/>";
   echo "<h2 style=\"\"><center><font size=\"3\">�������</font>";
     echo "<br/>";
   echo "<br/><center><form method='post' action=''>
      <select name='route'>
      <option value=''> �������� ������� </option>";   
	                                               
$resul =  mysqli_query($link, "select hbc_routes.Name from hbc_routes where hbc_routes.SY_Void ='0' and hbc_routes.ID not in (201,202,203,204,205,206,207,208,209,210,211,231,244,232,243) order by Name");
               
 while ($row = mysqli_fetch_assoc($resul)){
  
echo "<option value='".$row['Name']."'>".$row['Name']." </option>";

}
?>
   </td>
       
        <td><label for="tzone"><center>������� ����:</font></label> 
	<center>	<br/><select name="tzone">
        <option value="3">+3</option>
        <option value="4">+4</option>
        <option value="5">+5</option>
        <option value="6">+6</option>
        <option value="7">+7</option>
        <option value="8">+8</option>
        <option value="9">+9</option>
        <option value="10">+10</option>
        <option value="11">+11</option>
        <option value="12">+12</option>
        <option value="0">+0</option>
        <option value="1">+1</option>
        <option value="2">+2</option>
      </select><br/></td>
      <td>
 <?php 
   echo "<br/>";
   echo "<h2 style='color:red'><center><font size=\"3\">����</font>";
     echo "<br/>";
   echo "<br/><center><form method='post' action=''>
      <select name='zones'>
      <option value=''> �������� ���� </option>";   
	                                               
$resul =  mysqli_query($link, "select Name from hbc_zones");
               
 while ($row = mysqli_fetch_assoc($resul)){
  
echo "<option value='".$row['Name']."'>".$row['Name']." </option>";

}
?>      
      </td>
        </tr>
    <tr>
        <td colspan="4"> 
<?php 		
   echo "<br/>";
   echo "<br/>";
echo "<center><input type='submit' value='�������� ���������� �����' class='my_button'</input>"; 
echo "</select></form></center>"; 
echo "<br/>";
echo "<br/>";
 ?> 
    </td>
    </tr>
</table>

<?php  

  $city=trim ( @$_POST['city']);  
 # $city=@mb_strtoupper($city[0]).substr($city, 1);
  $city=@mb_strtoupper($city[0], 'cp1251').substr($city, 1);
  $region=@$_POST['region'];
  $city_type=@$_POST['city_type'];
  $route=@$_POST['route'];	
  $tzone=@$_POST['tzone']; 
  $zones=@$_POST['zones'];  
  $RF='������';
  $MO='����������';
  $country=@$_POST['country']; 
   
  if ($_SERVER['REQUEST_METHOD'] == "POST")  {
	    if (!empty($city)&&!empty($country)&&!empty($city_type))     // �������� �� ���������� �����
          
		  { 
             if (strcasecmp($country, $RF) == 0)    //�������� �� ��
			 {
                   if (!empty($region)) {          
                   if (strcasecmp($region, $MO) == 0)     //�������� �� ��
					       				       {    
						                      
						  $res =  mysqli_query($link, "SELECT hbc_cities.Name from hbc_cities where hbc_cities.Name='$city' and hbc_cities.FedUnitID='21'"); 
					         while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC))
					   {
						   $city_base=$row['Name'];                    //�������� �� ������������� � ���� ���������� ������ � ��.
						   #$city_base=mb_strtolower($city_base,'UTF-8');
					   }
					    #echo $city_base;
						mysqli_free_result($res);
   
					   	   if ( strcasecmp(mb_strtolower(@$city_base), mb_strtolower($city)) == 0 )
						   {
echo "<h2 style='color:red;'>���������� ����� <font color='#6A5ACD'>$city <font color='red'>� <font color='#6A5ACD'>$MO <font color='red'>� <font color='#6A5ACD'>$country <font color='red'>��� ����</h2>";
						   }    
/*Action1 */        else {
                           if  (empty($zones)) {echo "<h2 style=\"color:red;\">�� ������� ����</h2>";
                           exit; }
				              
				                  $res =  mysqli_query($link, "Insert into hbc_cities Values ()"); 
				                  $res =  mysqli_query($link, "Select hbc_fedunittypes.ID from hbc_fedunittypes where hbc_fedunittypes.Name='$city_type'  into @typeid"); 
				                  $res =  mysqli_query($link, "Select hbc_fedunits.ID from hbc_fedunits where hbc_fedunits.Name='$region' into @regid");
                          $res =  mysqli_query($link, "Select hbc_zones.ID from hbc_zones where hbc_zones.Name='$zones'  into @zonesID");
				                  $res =  mysqli_query($link, "Select MAX(ID) from hbc_cities into @maxid");
								  $res =  mysqli_query($link, "Select ID from hbc_routes where hbc_routes.Name='$route' into @routeid");
				                  $res =  mysqli_query($link, "Update hbc_cities SET hbc_cities.Name=(select concat(upper(mid('$city',1,1)), mid('$city',2))),
 								                       hbc_cities.UnitTypeID=@typeid, hbc_cities.FedUnitID=@regid, hbc_cities.RouteUIN=@routeid,
													   hbc_cities.TZone='3', hbc_cities.ZoneID=@zonesID, hbc_cities.ExDivUIN='1' where hbc_cities.ID = @maxid");
                             
echo "<h2 style='color:#6A5ACD;'>$city_type $city <font color='green'>� <font color='#6A5ACD'>$country <font color='green'>� ������ <font color='#6A5ACD'>$region <font color='green'>�� ��������
 <font color='#6A5ACD'>$route <font color='green'>� ����� <font color='#6A5ACD'>$zones <font color='green'>��������!</h2>";
                      
                   $res =  mysqli_query($link, "Insert into PHP_Log VALUES(DEFAULT, '$FilePHP Action1', '$Login', '$LogIP', NOW(),
                                                     'Name=$city ::=$city_type ::=$region route::=$route zones::=$zones ::=$country')");            
							    }
						   
                 }
                    else 
						      						{
									 $res =  mysqli_query($link, "SELECT hbc_cities.Name from hbc_cities where hbc_cities.Name='$city' and hbc_cities.FedUnitID<>'21' and hbc_cities.CountryID='7'"); 
					         while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC))
					   {
						   $city_base=$row['Name'];            //�������� �� ������������� � ���� ���������� ������ ����� ����� ��.
						 }
						mysqli_free_result($res);
						 	  if ( strcasecmp(mb_strtolower(@$city_base), mb_strtolower($city)) == 0 )
						   {					  
echo "<h2 style='color:red;'>��������� ����� <font color='#6A5ACD'>$city <font color='red'>� <font color='#6A5ACD'>$country <font color='red'>��� ����</h2>";                   
                  
						   }    
/*Action2 */          else {
							        
								 
				                  $res =  mysqli_query($link, "Insert into hbc_cities Values ()"); 
				                  $res =  mysqli_query($link, "Select hbc_fedunittypes.ID from hbc_fedunittypes where hbc_fedunittypes.Name='$city_type'  into @typeid"); 
				                  $res =  mysqli_query($link, "Select hbc_fedunits.ID from hbc_fedunits where hbc_fedunits.Name='$region' into @regid");
				                  $res =  mysqli_query($link, "Select MAX(ID) from hbc_cities into @maxid");
				                  $res =  mysqli_query($link, "Update hbc_cities SET hbc_cities.Name=(select concat(upper(mid('$city',1,1)), mid('$city',2))),
 								                       hbc_cities.UnitTypeID=@typeid, hbc_cities.FedUnitID=@regid, hbc_cities.TZone='$tzone' where hbc_cities.ID = @maxid");
                                        
                       $res =  mysqli_query($link, "Insert into PHP_Log VALUES(DEFAULT, '$FilePHP Action2', '$Login', '$LogIP', NOW(),
                                                     'Name=$city ::=$city_type ::=$region ::=$tzone ::=$country')");    
                                        
                                  
echo "<h2 style='color:#6A5ACD;'>$city_type $city <font color='green'>� <font color='#6A5ACD'>$country <font color='green'>� ������ <font color='#6A5ACD'>$region <font color='green'>��������!</h2>";                                        
							    }
                   						}
             }
                else {
                         echo "<h2 style=\"color:red;\">�� ������ ������</h2>";
                     }
            }
         else {     
	                $res =  mysqli_query($link, "SELECT hbc_cities.Name from hbc_cities where hbc_cities.Name='$city' and hbc_cities.CountryID<>'7'"); 
					         while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC))
					   {
						   $city_base=$row['Name'];          //�������� �� ������������� � ���� ���������� ��� ��.
						 }
						mysqli_free_result($res);
			   
			   $res =  mysqli_query($link, "SELECT hbc_country.Name as country from hbc_cities left join 
			          hbc_country on hbc_country.id=hbc_cities.CountryID where hbc_cities.Name='$city'"); 
					         while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC))
					   {
						   $country_base=$row['country'];
					   }
					   # echo $country_base;
						mysqli_free_result($res);			
			 			   
			  if ( strcasecmp(mb_strtolower(@$city_base), mb_strtolower($city)) == 0 )  
			  {      
echo "<h2 style='color:red;'>��������� ����� <font color='#6A5ACD'>$city  <font color='red'>��� ����</h2>";         
         }
		      else 
/*Action3 */           {		              
	     $res =  mysqli_query($link, "Insert into hbc_cities Values ()"); 
		   $res =  mysqli_query($link, "Select hbc_fedunittypes.ID from hbc_fedunittypes where hbc_fedunittypes.Name='$city_type'  into @typeid"); 
		   $res =  mysqli_query($link, "Select hbc_country.ID from hbc_country where hbc_country.Name='$country' into @countid");
			 $res =  mysqli_query($link, "Select MAX(ID) from hbc_cities into @maxid");
			 $res =  mysqli_query($link, "Update hbc_cities SET hbc_cities.Name=(select concat(upper(mid('$city',1,1)), mid('$city',2))), hbc_cities.UnitTypeID=@typeid, hbc_cities.CountryID=@countid, hbc_cities.TZone='$tzone' 
                                        where hbc_cities.ID = @maxid"); 
											
          $res =  mysqli_query($link, "Insert into PHP_Log VALUES(DEFAULT, '$FilePHP Action3', '$Login', '$LogIP', NOW(),
                                                     'Name=$city ::=$city_type ::=$tzone ::=$country')");    
                      
                    
echo "<h2 style='color:#6A5ACD;'>$city_type $city <font color='green'>� <font color='#6A5ACD'>$country <font color='green'>��������!</h2>";                       
                    }
			        			  }
		  
      }
        else {   
        	              echo "<h2 style=\"color:red;\">��������� ����������� ����</h2>";
             }		 
} 
   ?>
</body>
</html>