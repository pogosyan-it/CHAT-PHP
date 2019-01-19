#!/usr/bin/php 

 <?php  

include 'gsotldb.php';
$time = date("Hi");
$idl='���';
$search=mb_strtolower('�������� �� ��������� ������� ���� �� 12.00 �� �������� ������� ����������', 'cp1251');
$replace=mb_strtolower('�� 12.00', 'cp1251');
$string=mb_strtolower('��1, �������� �� ��������� ������� ���� �� 12.00 �� �������� ������� ����������', 'cp1251');

$pos = strripos($string, $search);
if ($pos === false) {
    echo "No such substring";
} else {
    $string=iconv("cp1251", "utf-8", str_replace($search, $replace, $string));
    #echo $pos;
}
#echo str_replace($search, $replace, $string);
#echo iconv("cp1251", "utf-8", str_replace($search, $replace, $string));
#$d00_idl='�������������� ����� ��������������� ������������ ����� (���)';
$d00_idl=mb_strtolower('�������������� ����� ��������������� ������������ ����� (���)', 'cp1251');
$d00_idl_1=mb_strtolower('�������������� ����� ��������������� ������������ �����', 'cp1251');
$d00_18=mb_strtolower('�������� �� ��������� ������� ���� �� 18:00 �� �������� ������� ����������', 'cp1251');
$d00_18_1=mb_strtolower('�������� �� ��������� ������� ���� �� 18.00 �� �������� ������� ����������', 'cp1251');
$d00_next_12=mb_strtolower('�������� �� ������ ������� ���� �� 12:00 �� �������� ������� ����������', 'cp1251');
$d00_next_12_1=mb_strtolower('�������� �� ������ ������� ���� �� 12.00 �� �������� ������� ����������', 'cp1251');
$d00_next_9=mb_strtolower('�������� �� ������ ������� ���� � 9:00 �� �������� ������� ����������', 'cp1251');
$d00_next_9_1=mb_strtolower('�������� �� ������ ������� ���� � 9.00 �� �������� ������� ����������', 'cp1251');
$d00_orig_idl=mb_strtolower('�������������� ��������� ��������������� ������������ ����� (���)', 'cp1251');
$d00_orig_idl_1=mb_strtolower('�������������� ��������� ��������������� ������������ �����', 'cp1251');
$d00_lr=mb_strtolower('�������� ����� � ����', 'cp1251');
$d00_ov=mb_strtolower('�������� � ������ �������� ��� �������� ��� ��������', 'cp1251');
$d00_osd=mb_strtolower('�������� � ������ �������� � ��������� ��� ��������','cp1251');
$d00_9=mb_strtolower('�������� �� ��������� ������� ���� � 9:00 �� �������� ������� ����������', 'cp1251');
$d00_9_1=mb_strtolower('�������� �� ��������� ������� ���� � 9.00 �� �������� ������� ����������', 'cp1251');
$d00_vko=mb_strtolower('������� ����� ����� ��������', 'cp1251');
$d00_voo=mb_strtolower('������� ��������� ����� ��������', 'cp1251');
$d00_12_1=mb_strtolower('�������� �� ��������� ������� ���� �� 12.00 �� �������� ������� ����������', 'cp1251');
$d00_12=mb_strtolower('�������� �� ��������� ������� ���� �� 12:00 �� �������� ������� ����������', 'cp1251');
$string_test=mb_strtolower('�������� �� ������ ������� ���� �� 12:00 �� �������� ������� ���������� ������ ������ ����� ������ ��������', 'cp1251');       
if (  $time > '0010' && $time < '1600' || $time > '1610' ) { 
$index=0;
$DateOfRequest1 = date("Y-m-d").'_More_50_char'.'.txt';
$DateOfRequest2 = date("Y-m-d").'_Less_50_char'.'.txt';
$head="����� ���������    �������            ����               ����. ����������";
$fd1 = fopen("/var/www/files//test/$DateOfRequest1",'a+') or die("�� ������� ������� ����");
$fd2 = fopen("/var/www/files//test/$DateOfRequest2",'a+') or die("�� ������� ������� ����");
$size1 = filesize("/var/www/files/test/$DateOfRequest1"); 
$size2 = filesize("/var/www/files/test/$DateOfRequest2");
  if ($size1 < '1') {
  fwrite($fd1, iconv("cp1251", "utf-8", $head."\r\n")); 
                    }
  if ($size2 < '1') {
  fwrite($fd2, iconv("cp1251", "utf-8", $head."\r\n")); 
                    }
                    
  $pos_test = strpos($string_test, $d00_next_12);
   if ($pos_test !== false ) { 
                                 $string_test=iconv("cp1251", "utf-8", str_replace($d00_next_12, '����� 12:00', $string_test));}                  
#echo $string_test;       

    $result = mysqli_query($link,  "Select  d15_departures.WayBillNum, hbc_routes.Name, d15_departures.SY_Adding,
                                            d15_departures.Sh_Instructions, d00_buff.str67, d15_departures.ID
                                    from d15_departures
            												left join hbc_routes on hbc_routes.ID=d15_departures.R_RouteID 
                                    left join d00_buff on d00_buff.dXXID=d15_departures.ID 
                                    where  d15_departures.SY_Void=0 and d15_departures.ToDivID='1' and d15_departures.SY_Adding > '2017-06-20 00:00:01' 
            												and d15_departures.SY_Adding < '2017-06-20 23:59:59' and d15_departures.WayBillNum <>'����!'
            												and d15_departures.fSidePost=0 and d00_buff.str67 != '' and d00_buff.str67 !=',';");
                  while ($row = mysqli_fetch_array($result, MYSQL_NUM)) 
                  {
                      $row[3]=mb_strtolower($row[3],'cp1251');
                      $row[4]=mb_strtolower(rtrim($row[4],' ,'),'cp1251');

                            
                                 
                      if ($row[4]==$d00_idl or $row[4]==$d00_idl_1)  {$row[4]='����� ���';}
                      #if (iconv("cp1251", "utf-8", $row[4])==iconv("cp1251", "utf-8", $d00_idl) or iconv("cp1251", "utf-8", $row[4])==iconv("cp1251", "utf-8", $d00_idl_1[0]))  {$row[4]='����� ���';}
                      if ($row[4]==$d00_18 or $row[4]==$d00_18_1)  {$row[4]='�� 18:00';}
                      if ($row[4]==$d00_next_12 or $row[4]==$d00_next_12_1)  {$row[4]='������ ���� �� 12:00';}
                      if ($row[4]==$d00_12 or $row[4]==$d00_12_1)  { $row[4]='�� 12:00';}
                      if ($row[4]==$d00_next_9 or $row[4]==$d00_next_9_1)  {$row[4]='������ ���� � 9:00';}
                      if ($row[4]==$d00_orig_idl or $row[4]==$d00_orig_idl_1)  {$row[4]='�������� ���';}
                      if ($row[4]==$d00_lr)  {$row[4]='����� � ����';}
                      if ($row[4]==$d00_ov)  {$row[4]='����� ��� ��������';}
                      if ($row[4]==$d00_osd)  {$row[4]='����� � ���������';}
                      if ($row[4]==$d00_9 or $row[4]==$d00_9_1)  {$row[4]='� 9:00';}
                      if ($row[4]==$d00_vko)  {$row[4]='����� ��';}
                      if ($row[4]==$d00_voo)  {$row[4]='�������� ��';}
                          $length = strlen(utf8_decode($row[3].$row[4]));
                          $new_instr=$row[3].'/'.$row[4];
                      if ($length > 50 & strcmp($row[3], $row[4])<>0 ) {
                      
                        fwrite($fd1, iconv("cp1251", "utf-8", '  '.$row[0].'         '.$row[1].'       ' .$row[2].'        ' .$new_instr."\r\n"));
                                          }
                      if ($length < 51 & strcmp($row[3], $row[4])<>0) {
                              #echo  "$new_instr and $row[4]";
                              #$res=mysqli_query($link, "Update d15_departures SET d15_departures.Sh_Instructions='$new_instr' where d15_departures.ID='$row[5]';");
                              fwrite($fd2, iconv("cp1251", "utf-8", '  '.$row[0].'         '.$row[1].'       ' .$row[2].'        ' .$new_instr."\r\n"));
                          }                  
                   $index++;

                  }
#$out = shell_exec('mail -s \'TEST\' -a /var/www/files/2017-06-05.txt it@corp.dimex.ws');
#var_dump($out);   
fclose($fd1);
fclose($fd2);                                                         }                                                     
                              
 ?>

