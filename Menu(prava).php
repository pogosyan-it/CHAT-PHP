 <?php  
//  Удаление организации в регионе
$Del86=array('Pogosyan', 'Admin', 'Lychkin', 'Iskandyarova',  'Golceva');
//  Создание пользователя "Старший смены/Кладовщик"
$sklad=array('Pogosyan', 'Admin', 'Pahomova', 'Evmenova', 'Dyksin', 'Iskandyarova', 'Perkova'); 
//  Прогон по зонам
$Zone=array('Pogosyan', 'Admin', 'Strejeleckii', 'Matveev', 'Iskandyarova', 'Oneshko');  
//  Принятые накладные выбранным сотрудником
$WaybillScan=array('Pogosyan', 'Admin', 'Yarovoi', 'Shalganova', 'Ilin', 'Iskandyarova', 'Telegin'); 
//  ЧЛ
$Chl=array('Pogosyan', 'Admin', 'Saltykov', 'Iskandyarova', 'A.A. Andreev');   
//  Очистка региона
$DELd86Reg=array('Pogosyan', 'Admin', 'Lychkin', 'Iskandyarova', 'Golceva');     
//  Создание пользователя "Курьер/Автокурьер"
$kurier=array('Pogosyan', 'Admin', 'Pahomova', 'Evmenova', 'Dyksin', 'Iskandyarova', 'Perkova');  
//  Прогон ВП
$VP=array('Pogosyan', 'Admin', 'Strejeleckii', 'Matveev', 'Iskandyarova', 'Oneshko');
//  Сканирование и закрытие накладной
$Waybill=array('Pogosyan', 'Admin', 'Shalganova', 'Yarovoi', 'Iskandyarova', 'A.A. Andreev', 'Ilin', 'Klopova', 'Telegin'); 
//  Сроки исполнения работ
$order_deliver=array('Pogosyan', 'Admin', 'Iskandyarova', 'A.A. Andreev','Lychkin','Golceva' );
//  Добавление адреса в справочник
$HouseADD=array('Pogosyan', 'Admin', 'Iskandyarova');
//  Создание пользователя "Менеджер/Логист/Специалист"
$CreateIAO=array('Pogosyan', 'Admin', 'Pahomova', 'Evmenova', 'Dyksin', 'Iskandyarova', 'Perkova');
//  Перевозчик
$Carrier=array('Pogosyan', 'Admin', 'Strejeleckii', 'Matveev', 'Iskandyarova', 'Oneshko'); 
//  Сканирование накладных в манифесте
$ScanMan=array('Pogosyan', 'Admin', 'Shalganova', 'Yarovoi', 'Iskandyarova', 'A.A. Andreev', 'Ilin', 'Klopova', 'Telegin'); 
//  Добавление населенного пункта
$CityADD=array('Pogosyan', 'Admin', 'Iskandyarova');
// Создание пользователя "Финансовая служба"
$Fin=array('Pogosyan', 'Admin', 'Pahomova', 'Evmenova', 'Dyksin', 'Iskandyarova', 'Perkova');
//  Информация по накладной
$waybill=array('Pogosyan', 'Admin', 'Shalganova', 'Telegin', 'Klopova', 'Iskandyarova', 'Balukova', 'A.A. Andreev','Yarovoi', 'Ilin');
//  Изменение НП РФ
$CityChange=array('Pogosyan', 'Admin', 'Iskandyarova', 'Shalganova'); 
//  Создание пользователя "Служба по развитию персонала"
$Kadry=array('Pogosyan', 'Admin', 'Pahomova', 'Evmenova', 'Dyksin', 'Jilkina', 'Iskandyarova', 'A.A. Andreev', 'Perkova');
//  Информация по удалению и переименованию накладной
$waybill_del=array('Pogosyan', 'Admin',  'Telegin', 'Iskandyarova', 'Lychkin', 'A.A. Andreev', 'Seredenko', 'Shalganova', 'Yarovoi', 'Ilin', 'Golceva', 'Balukova', 'Klopova',);
//  Добавление или Изменение адреса в ВП
$SmenaAdresaVP1=array('Pogosyan', 'Admin',  'Iskandyarova', 'A.A. Andreev', 'Lychkin', 'Golceva', 'Shalganova');            
//  Изменение пароля пользователя
$parol=array('Pogosyan', 'Admin', 'Pahomova', 'Evmenova', 'Dyksin', 'Iskandyarova', 'A.A. Andreev', 'Perkova');
//  Указание областной принадлежности НП
$SmenaPrivjazki=array('Pogosyan', 'Admin', 'Iskandyarova', 'Lychkin', 'A.A. Andreev', 'Golceva');
//  Изменение прав доступа (увольнение)
$smena_prav=array('Pogosyan', 'Admin', 'Pahomova', 'Evmenova', 'Dyksin', 'Iskandyarova', 'A.A. Andreev', 'Perkova');
//  Схема отправок
$ABR_Change=array('Pogosyan', 'Admin', 'Iskandyarova', 'A.A. Andreev', 'Lychkin', 'Golceva');
//  Проверка наличия заказа в базе
$order_check=array('Pogosyan', 'Admin', 'Iskandyarova', 'A.A. Andreev', 'Lychkin', 'Golceva','Haustov','Akopyan', 'Goloskokova', 'Droshnev', 'Akopyan', 'Haustov');
//  Лично в руки
$LVR=array('Pogosyan', 'Admin', 'Iskandyarova', 'A.A. Andreev', 'Saltykov', 'Seredenko');
//  Смена базы
$BaseChange=array('Pogosyan', 'Admin', 'Iskandyarova', 'Shalganova', 'Klopova', 'Slepinina', 'Seredenko');
//  hb_employeeIAO Отчет "операторы БД" 
$hb_employeeIAO=array('Pogosyan', 'Admin', 'Iskandyarova', 'Shalganova', 'Golceva', 'Klopova', 'Lychkin');
//  Переадресация (Сверки)
$sverki_redirect=array('Pogosyan', 'Admin', 'Iskandyarova', 'Matveev', 'Strejeleckii', 'Oneshko');
//  Отчёт по реализации услуг
$NORK_zakazy=array('Pogosyan', 'Admin', 'Iskandyarova', 'Shalganova', 'MelnikovSM', 'Tymanov', 'Tolmacheva', 'Yarovoi', 'Azhahov', 'Matveev', 'Oneshko', 'NovikovaEN', 'Strejeleckii');
// МТО
$mto=array('Pogosyan', 'Admin', 'Iskandyarova', 'Mamtaliev');
//Некорректные организации
$IncorrectClients=array('Pogosyan', 'Admin', 'Iskandyarova', 'Golceva', 'Shalganova');
  
$IPopen=array('10.10.1.15', '10.10.1.16', '10.10.1.18', '10.10.1.176', '10.10.1.31', '10.10.1.54', '10.10.1.169', '10.10.1.130', '10.10.1.71', '10.10.1.98');  
 
$_SESSION['IPopen'] = $IPopen; 
$Dostup=$_SESSION['login'];
include 'Menu(prava)_help.php';
#foreach ( $Del86 as $login  ) { if ($Dostup == $login)  { echo "TRUE"; $a = 'TRUE';} }
#if ($a != 'TRUE') {echo "FALSE";}
function button($knopka, $phpfile, $color, $name, $help)
{
global $Dostup, $Del86, $sklad, $Zone, $WaybillScan, $Chl, $DELd86Reg, $kurier, $VP, $Waybill, $order_deliver, $HouseADD, $CreateIAO, $Carrier, $ScanMan, $CityADD, $Fin, $waybill, $CityChange;
global $Kadry, $waybill_del, $SmenaAdresaVP1, $parol, $SmenaPrivjazki, $smena_prav, $ABR_Change, $order_check, $LVR, $BaseChange, $hb_employeeIAO;
  ?>  <form action="" method= "POST"><input  <button   <?php 
 foreach ( $knopka as $login  ) { if ($Dostup == $login) 
            {     echo "  style=\"background: $color;\"  type=\"submit\"  name=\"$phpfile\"  value=\"$name\"  class=\"ButAktiv\" title = \"$help\"  </button></form>";
              $a = 'TRUE'; 
            } 
                               }
                              if (@$a != 'TRUE')     
           {      echo " disabled style=\"background: $color; \" type=\"submit\" name=\"$phpfile\" value=\"$name\" class=\"ButInaktiv\" title = \"$help\" </button></form>";
           }
 }
?>      
<table cellpadding=0 align=center text-align=center >
                                                         <tr>
<td><?php button($Del86, "DELd86", "#CEF6F5", "Удаление организации в регионе", $HPDel86) ?> </td>
<td><?php button($sklad, "sklad", "#fdd7a8", "Создание пользователя &quot;Старший смены/Кладовщик&quot;", $HPsklad) ?> </td>
<td><?php button($Zone, "Zone", "#A9F5A9", "Прогон по зонам",  $HPZone) ?> </td>
<td><?php button($WaybillScan, "WaybillScan", "#E3CEF6", "Принятые накладные выбранным сотрудником", $HPWaybillScan) ?> </td>
<td><?php button($Chl, "Chl", "#48D1CC", "Доставки ЧЛ", $HPChl) ?> </td></tr><tr>
<td><?php button($DELd86Reg, "DELd86Reg", "#CEF6F5", "Удаление всех организаций в регионе", $HPDELd86Reg) ?> </td>
<td><?php button($kurier, "kurier", "#fdd7a8", "Создание пользователя &quot;Курьер/Автокурьер&quot;", $HPkurier) ?> </td>      
<td><?php button($VP, "VP", "#A9F5A9", "Прогон ВП", $HPVP) ?> </td>
<td><?php button($Waybill, "Waybill", "#E3CEF6", "Сканирование и закрытие накладной", $HPWaybill) ?> </td>
<td><?php button($order_deliver, "order_deliver", "#48D1CC", "Сроки исполнения работ", $HPorder_deliver) ?> </td></tr><tr>
<td><?php button($HouseADD, "HouseADD", "#87CEEB", "Добавление адреса в справочник", $HPHouseADD) ?> </td>
<td><?php button($CreateIAO, "CreateIAO", "#fdd7a8", "Создание пользователя &quot;Менеджер/Логист/Специалист&quot;", $HPCreateIAO) ?> </td>
<td><?php button($Carrier, "Carrier", "#A9F5A9", "Перевозчик", $HPCarrier) ?> </td>
<td><?php button($ScanMan, "ScanMan", "#E3CEF6", "Сканирование накладных в манифесте", $HPScanMan) ?> </td>
<td><?php button($LVR, "LVR", "#48D1CC", "Лично в руки", $HPLVR) ?>       </td></tr><tr>
<td><?php button($CityADD, "CityADD", "#87CEEB", "Добавление НП в справочник", $HPCityADD) ?> </td>
<td><?php button($Fin, "Fin", "#fdd7a8", "Создание пользователя &quot;Финансовая служба&quot;", $HPFin) ?> </td>
<td><?php button($sverki_redirect, "sverki_redirect", "#A9F5A9", "Переадресация", $HPsverki_redirect) ?>  </td>
<td><?php button($waybill, "waybill", "#E3CEF6", "Информация по накладной", $HPwaybill) ?> </td>
<td><?php button($order_check, "order_check", "#48D1CC", "Проверка заказов", $HPorder_check) ?> </td></tr><tr>
<td><?php button($CityChange, "CityChange", "#87CEEB", "Изменение НП РФ", $HPCityChange) ?> </td>
<td><?php button($Kadry, "Kadry", "#fdd7a8", "Создание пользователя &quot;Служба по развитию персонала&quot;", $HPKadry) ?> </td><td>    </td>
<td><?php button($waybill_del, "waybill_del", "#E3CEF6", "Информация по удалению и переименованию накладной", $HPwaybill_del) ?> </td> 
<td><?php button($IncorrectClients, "IncorrectClients", "#48D1CC", "Некорректные организации", $HPIncorrectClients) ?></td></tr><tr>
<td><?php button($SmenaAdresaVP1, "SmenaAdresaVP1", "#CEF6F5", "Добавление или Изменение адреса в ВП", $HPSmenaAdresaVP1) ?> </td>
<td><?php button($parol, "parol", "#fdd7a8", "Изменение пароля пользователя", $HPparol) ?> </td>
<td><?php button($mto, "mto", "#A9F5A9", "МТО", $HPmto) ?></td> <td></td>
<td><?php button($NORK_zakazy, "NORK_zakazy", "#48D1CC", "Отчёт по реализации услуг", $HPNORK_zakazy) ?></td></tr><tr>
<td><?php button($SmenaPrivjazki, "SmenaPrivjazki", "#CEF6F5", "Областная принадлежность НП", $HPSmenaPrivjazki) ?> </td>
<td><?php button($smena_prav, "smena_prav", "#fdd7a8", "Изменение прав доступа (увольнение)", $HPsmena_prav) ?> </td><td></td><td></td>
<td><?php button($BaseChange, "BaseChange", "#DCDCDC", "Архивные базы GSoT", $HPBaseChange) ?></td></tr><tr>
<td><?php button($ABR_Change, "ABR_Change", "#CEF6F5", "Схема отправок", $HPABR_Change) ?> </td> </tr> <tr>
<td><?php button($hb_employeeIAO, "hb_employeeIAO", "#CEF6F5", "Операторы БД", $HPhb_employeeIAO) ?> </td> </tr>
 
 
</table>
</body>
</html>

