<html>    <title>Создание ВП</title>
<head>    <link rel="shortcut icon" href="dimex.jpg" type="image/x-icon">
<meta http-equiv="content-type" content="text/html; charset=cp1251">
 <link rel="stylesheet" href="vp.css"  type="text/css">
 <style type="text/css">
  </style>
 </head>
<body>
<br/><br/>

<?php
 @ include 'TehRaboty.php'; 
include 'profilaktika.php'; 
 
session_start(); 
if(!isset($_SESSION['login'])){
     header("Location: index.php");
     exit;                       }  
if(!isset($_SESSION['createVP3'])){
     header("Location: Menu.php");
     exit;                    } 
    $weight = $_SESSION['weight'];
    $countr = $_SESSION['countr'];
  #  $fio = $_SESSION['FIO'];
    $countr = $_SESSION['countr'];
    $city = $_SESSION['city'];
    $Addr = $_SESSION['addr'];
    $phone = $_SESSION['phone'];
    $places = $_SESSION['places'];
    $instruct = $_SESSION['instruct'];
    $text = $_SESSION['text'];
    $discr = $_SESSION['discr'];
    $tipe = $_SESSION['tipe']; 
  #  echo $send;
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
   
         if ($tipe==1)           //по умолчанию экспресс
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
?>

<div id="text_dest"><?php echo $dest = $_SESSION['dest']; ?></div>
<div id="text_user"><?php echo $send = $_SESSION['send'];  ?></div>
<div id="text_send"><?php echo $send = $_SESSION['send'];  ?></div>
<div id="text_FIO"><?php echo $fio = $_SESSION['FIO']; ?></div>
<div id="text_DM"><?php echo $dmx = $_SESSION['dmx']; ?></div>
<div id="text_city"><?php echo $countr.', г.'.$city; ?></div>
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
<div id="text_instruct"><?php echo $instruct=wordwrap($instruct, 70, "<br />\n"); ?></div></div>
<div id="text_day"><?php echo date("d"); ?></div></div>
<div id="text_month"><?php echo date("m"); ?></div></div>  
<div id="text_year"><?php echo date("Y"); ?></div></div> 
<div id="text_Hour"><?php echo date("H"); ?></div></div> 
<div id="text_Min"><?php echo date("i"); ?></div></div> 
<div id="text_v"><b>v</b></div> 
<div id="text_v1"><b>v</b></div>
<div id="glavn"><form action="index.php">
    <button style="background: #F5ECCE; width: 300px; height: 50px; 
border-radius: 5px; box-shadow: 0px 1px 3px; font-size: 18px; text-align: left;" type="submit">Вернуться на главную страницу</button>
 </form></div>  
 <div id="print"><a href="javascript:window.print()"><img src="print.jpg"></a></div>
 <div id="back"><input type="button" <button style="background: #D8D8D8; width: 130px; height: 35px; 
border-radius: 5px; box-shadow: 0px 1px 3px; font-size: 17px; text-align: center;" onclick="history.back();" value="Создать еще"/> </div> 
<div id="print"><p><a href="javascript:window.print()"><img src="folder-Printer.jpg" width="150" height="150" ></a></p></div>
 <div id="error"><font size="5" color="green">Накладная <?php echo$text;?> создана!</font></div>
 <div id="reestr"><form action="Examples\01simple.php">
    <button style="background: #58FAF4; width: 190px; height: 55px; 
border-radius: 5px; box-shadow: 0px 1px 3px; font-size: 18px; text-align: left;" type="submit">Печать реестра за последние 12 часов</button>
<br/></form></div>  
<?php 

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
        $html.='<SPAN style="BORDER-LEFT: 0.01in solid; DISPLAY: inline-block; width:0.1; height: 23px;"></SPAN>';
      } else {
        $html.='<SPAN style="BORDER-LEFT: white 0.01in solid; DISPLAY: inline-block; width:0.1; height: 23px;"></SPAN>';
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