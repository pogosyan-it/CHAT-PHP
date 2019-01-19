<html><title>Главная страница</title>
<head>   <link rel="shortcut icon" href="dimex.jpg" type="image/x-icon">
<meta http-equiv="content-type" content="text/html; charset=cp1251">
 <link rel="stylesheet" href="style.css"  type="text/css">        
 <style type="text/css">
 
 
 </style>
 
  <?php
    
 session_start();  
 include 'profilaktika.php'; 
 if(!isset($_SESSION['login'])){

  include 'gsotldb.php';     

    if (isset($_POST['login'])) { $login = $_POST['login']; if ($login == '') { unset($login);} } //заносим введенный пользователем логин в переменную $login, если он пустой, то уничтожаем переменную
    if (isset($_POST['ID'])) { $ID = $_POST['ID']; if ($ID == '') { unset($ID);} }
    if (isset($_POST['password'])) { $password=$_POST['password']; if ($password =='') { unset($password);} }
    //заносим введенный пользователем пароль в переменную $password, если он пустой, то уничтожаем переменную

if (empty($ID) and empty($login)) //если пользователь не ввел логин  то выдаем ошибку и останавливаем скрипт
    {   
      $_SESSION['NoLog'] = 'NoLog';                //не введен логин или пароль
  header("Location: index.php");
  unset($_SESSION['login']);
      exit;
    }  
  if (empty($password)) //если пользователь не ввел пароль, то выдаем ошибку и останавливаем скрипт
    {   
      $_SESSION['NoPas'] = 'NoPas';                //не введен логин или пароль
  header("Location: index.php");
  unset($_SESSION['login']);
      exit;
    }    
  $res = mysqli_query($link, "Select ID from hb_employee where hb_employee.login='$login'");
        while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC))
             {
						   
               $LogID=$row['ID'];
					   }
					 		mysqli_free_result($res);
              
        #  echo $sname;
 $res = mysqli_query($link, "Select Password('$password') like hb_employee.crPassword as paslog from hb_employee where hb_employee.login='$login'");
        while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC))
           {
						   $passLog=$row['paslog'];
					   }
					 		mysqli_free_result($res);
              
                $res = mysqli_query($link, "Select Password('$password') like hb_employee.crPassword as pasid from hb_employee where hb_employee.ID='$ID'");
        while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC))
           {
						   $passID=$row['pasid'];
					   }
             
              if ( $passLog=='1')
             {    
              $LogIP=$_SERVER['REMOTE_ADDR'];                
             $Vhod=$login.'('.$LogID.')'.'@'.$LogIP;
       $res =  mysqli_query($link,  "INSERT INTO syEvents (LogText,OperKey) VALUES ('$Vhod','0')");     
       session_unset();              
  $_SESSION['login'] = $login; // сохраняем переменную содержащую логин
  $_SESSION['ID'] = $LogID;
  $_SESSION['symembID'] = $LogID;
         header("Location: Menu.php");
                   
             } 
             elseif ( $passID=='1' )
             {    
              $LogIP=$_SERVER['REMOTE_ADDR'];
              $res = mysqli_query($link, "select Login from hb_employee where hb_employee.ID='$ID'");
        while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC))
           {
						   $loginID=$row['Login'];
					   }
                            
             $Vhod=$ID.'('.$loginID.')'.'@'.$LogIP;
       $res =  mysqli_query($link,  "INSERT INTO syEvents (LogText,OperKey) VALUES ('$Vhod','0')");     
    #  if ($loginID<>'Pogosyan' or $loginID<>'Admin') {           
           #  $string=iconv("cp1251", "utf-8", $t2[0].$t1[1]);
          # $FromMail =
          #     echo shell_exec(sprintf("LANG=ru_RU.utf-8; echo $loginID | mail -s 'vhod po ID' -r '<byhgalter@corp.dimex.ws>' it@corp.dimex.ws", escapeshellarg($loginID)));
               # }
             session_unset();
             $_SESSION['symembID'] = $ID;     
             $_SESSION['login'] = $loginID; // сохраняем переменную содержащую логин
  
         header("Location: Menu.php");
                           
             }               
   else                                                   
   {
   $_SESSION['WrongPas'] = 'WrongPas';                //не верный пароль
  header("Location: index.php");  
      exit;
    }       
  exit; }
 #  echo  $LogID, $loginID, $ID;
   #echo $_SESSION['symembID'];
   $Dostup=$_SESSION['login'];
 ?>
<table align=center text-align=center >
<tr> <?php if (isset($_SESSION['ID'])) {  ?>
<td><font size="4" color="green">Ваш ID для входа в GSoT и на сайт:</font><font size="5" > <?php print $_SESSION['ID'] ?></font> </h2> </td> <?php  }   ?>
 <td><div align="center"><form action= "" method= "POST"> 
  <input <button style="background: #00FF80; cursor: pointer;   width: 70px; height: 40px; 
border-radius: 5px; box-shadow: 0px 1px 3px; font-size: 17px; text-align: center;" type="submit" value="Выход" name="but"></button>
</form></div> </td>

<td><form action= "" method= "POST"><input  <button 
  style="background: #808080; cursor: pointer;   width: 140px; height: 41px; border-radius: 5px; white-space: pre-line; box-shadow: 0px 1px 3px; font-size: 14px; text-align: left;" 
   type="submit" name="smenaPass" value="Изменение своего пароля в GSoT"</button></form> </td>
    <td>    <span id="date" style="color:blue;">Дата</span>&nbsp;&nbsp;&nbsp;
 <span id="time" style="color:blue;">Время</span>
<script type="text/javascript">
function clock() {
var d = new Date();
var day = d.getDate();
var hours = d.getHours();
var minutes = d.getMinutes();
var seconds = d.getSeconds();

month=new Array("января", "февраля", "марта", "апреля", "мая", "июня",
"июля", "августа", "сентября", "октября", "ноября", "декабря");
days=new Array("Воскресенье", "Понедельник", "Вторник", "Среда",
"Четверг", "Пятница", "Суббота");

if (day <= 9) day = "0" + day;
if (hours <= 9) hours = "0" + hours;
if (minutes <= 9) minutes = "0" + minutes;
if (seconds <= 9) seconds = "0" + seconds;

date_date = day + " " + month[d.getMonth()] + " " + d.getFullYear() + " (" +
days[d.getDay()] + ")";
date_time = hours + ":" + minutes + ":" + seconds;

if (document.layers) {
 document.layers.date.document.write(date_time);
 document.layers.date.document.close();
 document.layers.time.document.write(date_time);
 document.layers.time.document.close();
}
else {
 document.getElementById("date").innerHTML = date_date;
 document.getElementById("time").innerHTML = date_time;
}
 setTimeout("clock()", 1000);
}
clock();
</script> </td>
</tr></table> </br>

<table align=center text-align=center >
     
    <tr>
        <td><form action= "" method= "POST"><input  <button  style="background: #32CD32; cursor: pointer;   width: 160px; height: 55px; border-radius: 5px; white-space: pre-line; box-shadow: 0px 1px 3px; font-size: 16px; text-align: left;" 
   type="submit" name="Cartrige" value="Заказ картриджа"</button></form></td>
        <td><form action= "" method= "POST"><input  <button    style="background: #FAAC58; cursor: pointer;   width: 260px; height: 55px; border-radius: 5px; white-space: pre-line; box-shadow: 0px 1px 3px; font-size: 16px; text-align: left;" 
   type="submit" name="createVP3" value="Создание ВП"</button></form></td>
        <td><form action= "" method= "POST"><input  <button    style="background: #FAAC58; cursor: pointer;   width: 260px; height: 55px; border-radius: 5px; white-space: pre-line; box-shadow: 0px 1px 3px; font-size: 16px; text-align: left;" 
   type="submit" name="vyvodVP1" value="Просмотр ВП"</button></form></td>
        <td><form action= "" method= "POST"><input  <button    style="background: #FAAC58; cursor: pointer;   width: 260px; height: 55px; border-radius: 5px; white-space: pre-line; box-shadow: 0px 1px 3px; font-size: 16px; text-align: left;" 
   type="submit" name="01simple" value="Печать реестра ВП за последние 12 часов"</button></form></td>
   
    </tr>
</table> 
    </br>
  <?php   

if (@$_POST['but'] == true){
unset($_SESSION['login']);
header("Location: index.php");
}  
if (@$_POST['help'] == true){
$_SESSION['help']='test';
header("Location: help.php");
}        

if (@$_POST['DELd86'] == true){
$_SESSION['DELd86']='test';
header("Location: DELd86.php");
}  
if (@$_POST['DELd86Reg'] == true){
$_SESSION['DELd86Reg']='test';
header("Location: DELd86Reg.php");
}
if (@$_POST['HouseADD'] == true){
$_SESSION['HouseADD']='test';
header("Location: HouseADD.php");
}
if (@$_POST['CityADD'] == true){
$_SESSION['CityADD']='test';
header("Location: CityADD.php");
}
if (@$_POST['CityChange'] == true){
$_SESSION['CityChange']='test';
header("Location: CityChange.php");
}
if (@$_POST['SmenaAdresaVP1'] == true){
$_SESSION['SmenaAdresaVP1']='test';
header("Location: SmenaAdresaVP1.php");
}
if (@$_POST['SmenaPrivjazki'] == true){
$_SESSION['SmenaPrivjazki']='test';
header("Location: SmenaPrivjazki.php");
}
if (@$_POST['Chl'] == true){
$_SESSION['Chl']='test';
header("Location: Chl.php");
}
if (@$_POST['sklad'] == true){
$_SESSION['sklad']='test';
header("Location: sklad.php");
}
if (@$_POST['kurier'] == true){
$_SESSION['kurier']='test';
header("Location: kurier.php");
}
if (@$_POST['CreateIAO'] == true){
$_SESSION['CreateIAO']='test';
header("Location: CreateIAO.php");
}
if (@$_POST['Fin'] == true){
$_SESSION['Fin']='test';
header("Location: Fin.php");
}
if (@$_POST['Kadry'] == true){
$_SESSION['Kadry']='test';
header("Location: Kadry.php");
}
if (@$_POST['parol'] == true){
$_SESSION['parol']='test';
header("Location: parol.php");
}
if (@$_POST['smena_prav'] == true){
$_SESSION['smena_prav']='test';
header("Location: smena_prav.php");
}
if (@$_POST['smenaPass'] == true){
$_SESSION['smenaPass']='test';
header("Location: smenaPass.php");
}
if (@$_POST['Zone'] == true){
$_SESSION['Zone']='test';
header("Location: Zone.php");
}
if (@$_POST['VP'] == true){
$_SESSION['VP']='test';
header("Location: VP.php");
}
if (@$_POST['Carrier'] == true){
$_SESSION['Carrier']='test';
header("Location: Carrier.php");
}
if (@$_POST['WaybillScan'] == true){
$_SESSION['WaybillScan']='test';
header("Location: WaybillScan.php");
}
if (@$_POST['Waybill'] == true){
$_SESSION['Waybill']='test';
header("Location: Waybill.php");
}
if (@$_POST['ScanMan'] == true){
$_SESSION['ScanMan']='test';
header("Location: ScanMan.php");
}
if (@$_POST['createVP3'] == true){
$_SESSION['createVP3']='test';
header("Location: createVP3.php");
}
if (@$_POST['vyvodVP1'] == true){
$_SESSION['vyvodVP1']='test';
header("Location: vyvodVP1.php");
}
if (@$_POST['01simple'] == true){
$_SESSION['01simple']='test';
header("Location: Examples/01simple.php");
}
if (@$_POST['order_deliver'] == true){
$_SESSION['order_deliver']='test';
header("Location: order_deliver.php");
}
if (@$_POST['waybill'] == true){
$_SESSION['waybill']='test';
header("Location: waybill.php");
}  
 if (@$_POST['Cartrige'] == true){
$_SESSION['Cartrige']='test';
header("Location: Cartrige.php");
}
 if (@$_POST['waybill_del'] == true){
$_SESSION['waybill_del']='test';
header("Location: waybill_del.php");
}
if (@$_POST['ABR_Change'] == true){
$_SESSION['ABR_Change']='test';
header("Location: ABR_Change.php");
}
if (@$_POST['order_check'] == true){
$_SESSION['order_check']='test';
header("Location: order_check.php");
 }
if (@$_POST['LVR'] == true){
$_SESSION['LVR']='test';
header("Location: LVR.php");
}
if (@$_POST['BaseChange'] == true){
$_SESSION['BaseChange']='test';
header("Location: BaseChange.php");
}
if (@$_POST['hb_employeeIAO'] == true){
$_SESSION['hb_employeeIAO']='test';
header("Location: hb_employeeIAO.php");
}
if (@$_POST['sverki_redirect'] == true){
$_SESSION['sverki_redirect']='test';
header("Location: sverki_redirect.php");
}
if (@$_POST['NORK_zakazy'] == true){
$_SESSION['NORK_zakazy']='test';
header("Location: NORK_zakazy.php");
}
if (@$_POST['mto'] == true){
$_SESSION['mto']='test';
header("Location: mto.php");
}
if (@$_POST['IncorrectClients'] == true){
$_SESSION['IncorrectClients']='test';
header("Location: IncorrectClients.php");
}


  include 'Menu(prava).php';
      ?>

 
  