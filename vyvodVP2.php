<html>    <title>Просмотр внутренней почты</title>
<head> <link rel="shortcut icon" href="dimex.jpg" type="image/x-icon">
<meta http-equiv="content-type" content="text/html; charset=cp1251">
 <link rel="stylesheet" href="vp.css"  type="text/css">
 <style type="text/css">
  </style>
 </head>
<body>
<br/><br/>

<?php 
session_start();
if(!isset($_SESSION['login'])){
     header("Location: index.php");
     exit;                       }  
if(!isset($_SESSION['vyvodVP1'])){
     header("Location: Menu.php");
     exit;                    }  
include 'profilaktika.php'; 
 
 @ include 'TehRaboty.php'; 
include 'gsotldb.php'; 

    $text= $_POST['nomer'];
    $soderjimoe=$_POST['soderjimoe'];
    $pattern1 = "/^[0-9_]+$/i";
    if (!empty($text) && empty($soderjimoe))        {
        //проверка на кирилицу
 #   $pattern1 = "/^[".chr(0xC0)."-".chr(0xff)."_-]+$/"; 
    
   $found1 = (preg_match($pattern1,$text));
    if (!$found1 )
    {
     $_SESSION['rusnakl'] = 'rusnakl';
  header("Location: vyvodVP1.php");  
      exit;
    } 
      else
      {
  $res =  mysqli_query($link, "Select WayBillNum from d15_departures where d15_departures.fSidePost='1' and d15_departures.WayBillNum='$text';");
while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC))
					   {
						   $nakl=$row['WayBillNum'];
              					   }
           mysqli_free_result($res);   
           
            if (!empty ($nakl))     
         {
         # print("ok $nakl"); 
     
 $res =  mysqli_query($link, "Select hbc_country.Name from d15_departures left join hbc_divisions on d15_departures.ToDivID=hbc_divisions.ID
                               left join hbc_country on hbc_divisions.CountryID=hbc_country.ID where d15_departures.WayBillNum='$text';");
while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC))
					   {
						   $countr=$row['Name'];
                }
                 mysqli_free_result($res);
                 
               $res =  mysqli_query($link, "select hbc_divisions.Name as destname, hbc_cities.Name from hbc_divisions left join d15_departures on d15_departures.ToDivID=hbc_divisions.ID
                                            left join hbc_cities on hbc_cities.ID=d15_departures.R_CityID where d15_departures.WayBillNum='$text';");
while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC))
					   {
						       $city=$row['Name'];
                   $dest=$row['destname'];
                } 
                  mysqli_free_result($res);
                               
  /* $res =  mysqli_query($link, "Select hb_employee.SName from hb_employee left join d15_departures on d15_departures.SY_Empl=hb_employee.ID where d15_departures.WayBillNum='$text'");
                    while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC))     
					   {
						   $send=$row['SName'];
                }              
                  mysqli_free_result($res);     */ 
                  
                  $res =  mysqli_query($link, "Select S_Contact, R_Contact, R_Addr, R_Phone, Sh_Place, Sh_Weight, Sh_Instructions, Sh_discr, Ser_type, R_Name from d15_departures
                                                where d15_departures.WayBillNum='$text'");
                    while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC))
					   {
						   $send1=$row['S_Contact'];
               $fio=$row['R_Contact'];
               $Addr=$row['R_Addr'];
               $phone=$row['R_Phone'];
               $places=$row['Sh_Place'];
               $weight=$row['Sh_Weight'];
               $instruct=$row['Sh_Instructions'];
               $discr=$row['Sh_discr'];
               $Ser_type=$row['Ser_type'];
               $dmx=$row['R_Name'];
                }              
                  mysqli_free_result($res);
                  
                                
                 $res =  mysqli_query($link, "Select Date_Format(WayBillDate, '%d') as day, 
                                              Date_Format(WayBillDate, '%m') as month, Date_Format(WayBillDate, '%y') as year from d15_departures where d15_departures.WayBillNum='$text';");
                    while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC))
					   {
						   $day=$row['day'];
               $month=$row['month'];
               $year=$row['year'];
                }              
                  mysqli_free_result($res);
                  
                   $res =  mysqli_query($link, "Select Time_Format(SY_Adding, '%H') as hour, Time_Format(SY_Adding, '%i') as min from d15_departures where d15_departures.WayBillNum='$text';");
                    while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC))
					   {
						   $hour=$row['hour'];
               $min=$row['min'];
                  }              
                  mysqli_free_result($res); 
                    
                       if($Ser_type==1)          //по умолчанию экспресс
         {    
    ?>
     <div id="text_type2"><b>v</b></div>
    <?php
}
else
{    
     ?>
     <div id="text_type1"><b>v</b></div>
    <?php
}   

$n=mb_strlen($discr);
   #echo $n;
   if ( $n < 70) {
   $discr=wordwrap($discr, 80, "<br />\n");
     ?>
   <div id="text_discr"><?php echo $discr; ?></div></div> 
     <?php             
                 }
   else {
         ?>
         <div id="text_discr"><b><i>Смотри перечень содержимого на обороте.</i></b></div></div>
         <div id="text_soderj"><i><b>Перечень содержимого:</i></b></div></div>
         <div id="text_perechen"><?php echo wordwrap($discr, 70, "<br />\n"); ?></div></div>
         <?php  
        }                                    
?>
 
<div id="text_dest"><?php print $dest; ?></div>
<div id="text_user"><?php print $send1; ?></div>
<div id="text_send"><?php print $send1; ?></div>
<div id="text_FIO"><?php echo $fio; ?></div>
<div id="text_DM"><?php echo $dmx; ?></div>
<div id="text_city"><?php echo $countr.', г.'.$city.'.'; ?></div>
<div id="text_addr"><?php echo $Addr; ?></div>
<div id="text_phone"><?php echo $phone; ?></div>
<div id="text_company">ООО "Даймэкс-Корп"</div>
<div id="text_CORP_country">Россия</div>
<div id="text_CORP_adr">КОТЛЯКОВСКИЙ 1-Й ПЕР., д. 6, стр. 1.</div>
<div id="text_CORP_phone">84996104152, 84995506902</div>
<div id="text_CORP_city">г. Москва</div>
<div id="text_CORP">CORP</div>
<div id="text_RUS"><?php echo $countr; ?></div></div> 
<div id="text_places"><?php echo $places; ?></div></div> 
<div id="text_weight"><?php echo $weight; ?></div></div> 
<div id="text_instruct"><?php echo $instruct=wordwrap($instruct, 60, "<br />\n"); ?></div></div>
<div id="text_day"><?php echo $day; ?></div></div>
<div id="text_month"><?php echo $month; ?></div></div>  
<div id="text_year"><?php echo $year; ?></div></div> 
<div id="text_Hour"><?php echo $hour; ?></div></div> 
<div id="text_Min"><?php echo $min; ?></div></div> 
<div id="text_v"><b>v</b></div> 
<div id="text_v1"><b>v</b></div>
<div id="glavn"><form action="index.php">
    <button style="background: #F5ECCE; width: 290px; height: 50px; 
border-radius: 5px; box-shadow: 0px 1px 3px; font-size: 18px; text-align: left;" type="submit">Вернуться на главную страницу</button>
<br/></form></div>  
 <div id="print"><a href="javascript:window.print()"><img src="print.jpg"></a></div>
 <div id="back"><input type="button" <button style="background: #D8D8D8; width: 90px; height: 35px; 
border-radius: 5px; box-shadow: 0px 1px 3px; font-size: 17px; text-align: center;" onclick="history.back();" value="Назад"/> </div>
  
<?php
  
             
 }
 else {
 $_SESSION['netnakl'] = 'asd';
  header("Location: vyvodVP1.php");  
      exit;
           }
           }  
           }
 elseif (empty($text) && !empty($soderjimoe))        {
  $found = (preg_match($pattern1, $soderjimoe));
  if ( $found )   
          {
    $myresult=array();  
    $index=0;            
    $result = mysqli_query($link, "select d15_departures.WayBillNum from d15_departures where d15_departures.Sh_discr like '%$soderjimoe%'");
                  while ($row = mysqli_fetch_array($result)) 
                  {
                   
                  $myresult[$index]=$row[0];
                  $index++; 
                   $array[] = $row['WayBillNum'];
                  }
                   
                  $get_array = implode(",", $array);
                  if (!empty($get_array))
                  {
                  $_SESSION['myresult'] = $get_array;
                  header("Location: vyvodVP1.php"); 
                  exit;
                  } 
                  else
                  {
                  $_SESSION['netdiscr'] = 'asd';
  header("Location: vyvodVP1.php");  
      exit;
      }
                 } 
                 
            else {
 $_SESSION['rusnakl'] = 'rusnakl';
  header("Location: vyvodVP1.php");  
      exit;}
 }  else 
           {
        $_SESSION['error'] = 'rusnakl';
  header("Location: vyvodVP1.php");  
      exit;}
  
$pkgs = array(
  array('sku' => $text ),
 );
?>

<?php foreach ($pkgs as $item): ?>
 <div class="b-sticker">
        <table>
          <colgroup>
            <col width="20%">
            <col width="10%">
            <col width="90%">
          </colgroup>
          <tr>
            <td class="customer-info" colspan="2">
  
              </p>
            </td>
            <td>

              <div class="barcode" ><?php echo barcode::code39($item['sku']); ?></div>
            </td>
          </tr>
          <tr>
           
          </tr>
        </table>
      </div>        

<?php endforeach; ?>

  </body>
</html>

<?php
class barcode {

  protected static $code39 = array(
    '0' => 'bwbwwwbbbwbbbwbw', '1' => 'bbbwbwwwbwbwbbbw',
    '2' => 'bwbbbwwwbwbwbbbw', '3' => 'bbbwbbbwwwbwbwbw',
    '4' => 'bwbwwwbbbwbwbbbw', '5' => 'bbbwbwwwbbbwbwbw',
    '6' => 'bwbbbwwwbbbwbwbw', '7' => 'bwbwwwbwbbbwbbbw',
    '8' => 'bbbwbwwwbwbbbwbw', '9' => 'bwbbbwwwbwbbbwbw',
    'A' => 'bbbwbwbwwwbwbbbw', 'B' => 'bwbbbwbwwwbwbbbw',
    'C' => 'bbbwbbbwbwwwbwbw', 'D' => 'bwbwbbbwwwbwbbbw',
    'E' => 'bbbwbwbbbwwwbwbw', 'F' => 'bwbbbwbbbwwwbwbw',
    'G' => 'bwbwbwwwbbbwbbbw', 'H' => 'bbbwbwbwwwbbbwbw',
    'I' => 'bwbbbwbwwwbbbwbw', 'J' => 'bwbwbbbwwwbbbwbw',
    'K' => 'bbbwbwbwbwwwbbbw', 'L' => 'bwbbbwbwbwwwbbbw',
    'M' => 'bbbwbbbwbwbwwwbw', 'N' => 'bwbwbbbwbwwwbbbw',
    'O' => 'bbbwbwbbbwbwwwbw', 'P' => 'bwbbbwbbbwbwwwbw',
    'Q' => 'bwbwbwbbbwwwbbbw', 'R' => 'bbbwbwbwbbbwwwbw',
    'S' => 'bwbbbwbwbbbwwwbw', 'T' => 'bwbwbbbwbbbwwwbw',
    'U' => 'bbbwwwbwbwbwbbbw', 'V' => 'bwwwbbbwbwbwbbbw',
    'W' => 'bbbwwwbbbwbwbwbw', 'X' => 'bwwwbwbbbwbwbbbw',
    'Y' => 'bbbwwwbwbbbwbwbw', 'Z' => 'bwwwbbbwbbbwbwbw',
    '-' => 'bwwwbwbwbbbwbbbw', '.' => 'bbbwwwbwbwbbbwbw',
    ' ' => 'bwwwbbbwbwbbbwbw', '*' => 'bwwwbwbbbwbbbwbw',
    '$' => 'bwwwbwwwbwwwbwbw', '/' => 'bwwwbwwwbwbwwwbw',
    '+' => 'bwwwbwbwwwbwwwbw', '%' => 'bwbwwwbwwwbwwwbw'
  );

  public static function code39($text) {
    if (!preg_match('/^[A-Z0-9-. $+\/%*]+$/i',$text)) {
      throw new Exception('Ошибка ввода');
    }
    $text_1=strtoupper($text);
    $text = '*'.strtoupper($text).'*';
    #$text_1=strtoupper($text);
    #echo $text;
    $length = strlen($text);
    #echo date("Ymd"); 
    $chars = str_split($text);
    #echo $chars;
    $colors = '';

    foreach ($chars as $char) {
      $colors .= self::$code39[$char];
    }

    $html = '
            <div style=" float:left;">
            <div>';

    foreach (str_split($colors) as $i => $color) {
      if ($color=='b') {
        $html.='<SPAN style="BORDER-LEFT: 0.01in solid; DISPLAY: inline-block; width: 0.1px; height: 24px;"></SPAN>';
      } else {
        $html.='<SPAN style="BORDER-LEFT: white 0.01in solid; DISPLAY: inline-block; width: 0.1px; height: 24px;"></SPAN>';
      }
    }  
   
    $html.='</div>
            <div style="float:left; width:100%;" align=center >'.$text_1.'</div></div>';
    //echo htmlspecialchars($html);
    ?> 
    <div id="text_1"><?php echo $html; ?></div>
 <?php
  }                                   
 }  
 
    

            ?>        
  
</body>
</html>