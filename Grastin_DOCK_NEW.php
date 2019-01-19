<?php 
//Скрипт импорта данных по API в КС2008 из бд Grastin, имеющих пункты самовывоза по МСК
include 'courier2008.php';        // Подключение к базе КС2008
$date_now=date("Y-m-d");        // Текущая дата
#$dir = "/var/www/files/DOCK_reports";
$DateOfRequest = $date_now.'_dock.txt';
$DateOfRequest1 = $date_now.'_partly.txt';
$DateOfRequest2 = $date_now.'_done.txt';
$DateOfRequest3 = $date_now.'_return.txt';
$DateOfRequest4 = $date_now.'_else.txt';
#$DateOfRequest5 = $date_now.'_return.txt';
$head="Дата_Доставки      Номер Накладной        Статус           Стоймость      Оплата";
$fd1 = fopen("/var/www/files/DOCK_reports/Grastin/$DateOfRequest1",'a+') or die("не удалось создать файл");
$fd2 = fopen("/var/www/files/DOCK_reports/Grastin/$DateOfRequest2",'a+') or die("не удалось создать файл");
$fd3 = fopen("/var/www/files/DOCK_reports/Grastin/$DateOfRequest3",'a+') or die("не удалось создать файл");
#$fd4 = fopen("/var/www/files/DOCK_reports/Grastin/$DateOfRequest4",'a+') or die("не удалось создать файл");
#$fd_waybill = fopen("/var/www/files/DOCK_reports/Grastin/P_Return/$DateOfRequest",'a+') or die("не удалось создать файл");
#$fd_return = fopen("/var/www/files/DOCK_reports/Grastin/P_Return/$DateOfRequest3",'a+') or die("не удалось создать файл");
$size1 = filesize("/var/www/files/DOCK_reports/Grastin/$DateOfRequest1");
$size2 = filesize("/var/www/files/DOCK_reports/Grastin/$DateOfRequest2");
$size3 = filesize("/var/www/files/DOCK_reports/Grastin/$DateOfRequest3");
#$size4 = filesize("/var/www/files/DOCK_reports/Grastin/$DateOfRequest4");
  if ($size1 < '1') {fwrite($fd1, $head."\r\n"); }
  if ($size2 < '1') {fwrite($fd2, $head."\r\n"); }
  if ($size3 < '1') {fwrite($fd3, $head."\r\n"); }
 # if ($size4 < '1') {fwrite($fd4, $head."\r\n"); }
                  #15,3
$datedeliverystart=date('dmY', strtotime( ' -14 day'));
$datedeliveryend=date('dmY', strtotime( ' -1 day'));   
#$datedeliveryend=date('dmY'); 
$xml = "<File><API>2f3badcd-544a-4ac8-b6c1-44c390dd99ff</API><Method>orderinformation</Method><Orders><datedeliverystart>$datedeliverystart</datedeliverystart><datedeliveryend>$datedeliveryend</datedeliveryend></Orders></File>";
      $url = 'http://api.grastin.ru/api.php';
      $ch = curl_init();
      curl_setopt($ch,CURLOPT_URL, $url);
      curl_setopt($ch,CURLOPT_POST, 1);
      curl_setopt($ch,CURLOPT_POSTFIELDS, 'XMLPackage='.urlencode($xml));
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_HEADER, 0);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
      $result = curl_exec($ch);
      curl_close($ch);

$pattern_status = "/<Status>.*<.Status>/";
$pattern_num="/<Number>.*<.Number>/";
$pattern_date="/<StatusDateTime>[0-3][0-9].[0-1][0-9].[2-3][0-2][0-9][0-9].[0-2][0-9]:[0-5][0-9]<.StatusDateTime>/";
$pattern_fullsum="/<OrderSumma>[0-9]*,?[0-9]*<.OrderSumma>/";
$pattern_paysum="/<PaidOrder>[0-9]*,?[0-9]*<.PaidOrder>/";
$pattern_good_list="/<Good article.*/";    //шаблон с полной инфой о вложении
$pattern_good_all="/#<GoodsList>(.+?)<.GoodsList>#is/";

preg_match_all($pattern_num, $result, $m_num);
preg_match_all($pattern_status, $result, $m_status);
preg_match_all($pattern_date, $result, $m_date);
preg_match_all($pattern_fullsum, $result, $m_fullsum);
preg_match_all($pattern_paysum, $result, $m_paysum);
preg_match_all($pattern_good_list, $result, $g_list);

preg_match_all('#<GoodsList>(.+?)<.GoodsList>#is', $result, $arr_goods);   //Вырезает из всех данных блок, относящийся к списку вложенных товаров

$N=count($m_status[0]);      //Общее кол-во отправлений в указанный провежуток времени

$date=array();
$status=array();
$fullsum=array();
$paysum=array();
$date_new=array();
$waybill=array();
$time=array(); 
#$r_sum=0;
for ($i=0;$i<$N;$i++)
  {   $date[$i]=explode(">",explode(" ", $m_date[0][$i])[0])[1];
      $time[$i]=explode("<",explode(" ", $m_date[0][$i])[1])[0];          
      $base_date[$i]=explode(".", $date[$i])[2].'-'.explode(".", $date[$i])[1].'-'.explode(".", $date[$i])[0];
      $date_time[$i]=$base_date[$i].' '.$time[$i];
      $status[$i]=explode("<",explode(">",$m_status[0][$i])[1])[0];
      $paysum[$i]=explode("<",explode(">",$m_paysum[0][$i])[1])[0];
      $fullsum[$i]=explode("<",explode(">",$m_fullsum[0][$i])[1])[0];
      $waybill[$i]=explode("<",explode(">",$m_num[0][$i])[1])[0];
      #$g_name[$i]=explode("\"", $g_list[0][$i])[3];    //наименование товара
      preg_match_all($pattern_good_list, $arr_goods[1][$i], $order_goods);
        $M=count($order_goods[0]);
        #print_r($waybill[$i].' '.$M."\n");
        $r_sum=0;  // обнуление суммы по позийиям для каждой следующей накладной
  if ($status[$i]=='done')   
   {                 //Условие "статус=выполнен"соотсетствует и полностью выкупленным заказам и заказам частично выкупленным
        for ($j=0;$j<$M;$j++) 
        {
           $g_name[$j]=explode("\" cost",explode("name=\"",$order_goods[0][$j])[1])[0];
           if (empty(explode("&",$g_name[$j])[1])) 
              {$g_name[$j]=iconv("utf-8", "cp1251",$g_name[$j]);
                #print_r($g_name[$j]."\n");
                }
           else {$g_name[$j]=iconv("utf-8", "cp1251", str_replace("&quot;", "\"", "$g_name[$j]"));
                 #print_r($g_name[$j]."\n");
                } 
          $return=explode("\"",explode("returnamount=\"", $order_goods[0][$j])[1])[0];       //определяет был ли возврат по конкретной позции в отправлении или нет (0 - не было, 1 был)
          $r_sum=$r_sum+$return;  // сумма по позициям, если она равна 0, то заказ полностью выкуплен (см. выше), если >0  и меньше M то выкуплен частично.
                                    //случай когда = М должен, казалось бы, соответствовать полному отказу, но для таких накладных статус другой и они не попадают в выборку
                                    // и по условию API если заказ возвращен полностью, то блок с вложенными заказами не редактируется - и там везде returnamount=0
          include ('Grastin_Partly_NEW.php');                          
           
        }
         if ( $r_sum==0)    //условие означает что нет отказов, а значит заказ полностью выполнен.
       
                 {
                    fwrite($fd2, $base_date[$i].' '.$waybill[$i].' '.'ДОСТАВЛЕНО'.' '.$fullsum[$i].' '.$paysum[$i]."\r\n");
                    print_r( $base_date[$i].' '.$waybill[$i].' '.'ДОСТАВЛЕНО'.' '.$fullsum[$i].' '.$paysum[$i]."\n");
                    @$res=mysqli_query($link,  "Update address set address.date_put='$base_date[$i]', address.State1='7', 
                                               address.rur='$paysum[$i]' where address.client_id='$waybill[$i]';" );
                     
                }
       else             //случай, когда r_sum < M, где М общее кол-во вложений.
                {
                    fwrite($fd1, $base_date[$i].' '.$waybill[$i].' '.'ЧАСТИЧНЫЙ ОТКАЗ'.' '.$fullsum[$i].' '.$paysum[$i]."\r\n");
                    print_r( $base_date[$i].' '.$waybill[$i].' '.'ЧАСТИЧНЫЙ ОТКАЗ'.' '.$fullsum[$i].' '.$paysum[$i]."\n");
                   
                    @$res=mysqli_query($link,  "Update address set address.date_put='$base_date[$i]', address.State1='11', 
                                                address.rur='$paysum[$i]' where address.client_id='$waybill[$i]';" );
                }
   }

elseif ( $status[$i]=='return' or  $status[$i]=='returned to customer' or $status[$i]=='canceled' )  //Возвраты
                 {
                        fwrite($fd3, $base_date[$i].' '.$waybill[$i].' '.'ОТКАЗ НА АДРЕСЕ'.' '.$fullsum[$i].' '.$paysum[$i]."\r\n");
                        #fwrite($fd_return, '"'.$waybill[$i].'";'."\r\n");
                        print_r( $base_date[$i].' '.$waybill[$i].' '.'ОТКАЗ НА АДРЕСЕ'.' '.$fullsum[$i].' '.$paysum[$i]."\n");
                        @$res=mysqli_query($link,  "Update address set address.date_put='$base_date[$i]', 
                                                    address.State1='8', address.rur='0' where address.client_id='$waybill[$i]';" );
                         include ('Grastin_Returns_new.php');
                        
                 }
      
  }     
   fclose($fd1); 
   fclose($fd2);
   fclose($fd3);
 
?>    
            