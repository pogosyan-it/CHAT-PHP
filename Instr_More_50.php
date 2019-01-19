#!/usr/bin/php 

 <?php  
$FilePHP = $_SERVER['PHP_SELF'];
include 'gsotldb.php';
$time = date("Hi");
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
                    
   function Zamena($string1,$search1,$replace1) {
   
 
   if (strpos($string1, $search1) !== false ) { 
                                 
                                 $string1=str_replace($search1, $replace1, $string1);} 
                                 return $string1;  

                                  }

    $result = mysqli_query($link, "Select MAX(PHP_Log.Date) from PHP_Log where PHP_Log.`Values`='Spec Instruction update less 50 char' into @last_date");
    $result = mysqli_query($link,  "Select  d15_departures.WayBillNum, hbc_routes.Name, d15_departures.SY_Adding,
                                            d15_departures.Sh_Instructions, d00_buff.str67, d15_departures.ID
                                    from d15_departures
            												left join hbc_routes on hbc_routes.ID=d15_departures.R_RouteID 
                                    left join d00_buff on d00_buff.dXXID=d15_departures.ID 
                                    where  d15_departures.SY_Void=0 and d15_departures.ToDivID='1' and d15_departures.SY_Adding > @last_date
            												and d15_departures.WayBillNum <>'����!'
            												and d15_departures.fSidePost=0 and d00_buff.str67 != '' and d00_buff.str67 !=',' and d00_buff.str67 !='�������������� �����';");
                  while ($row = mysqli_fetch_array($result, MYSQL_NUM)) 
                  {
                      $row[3]=mb_strtolower($row[3],'cp1251');
                      $row[4]=mb_strtolower(rtrim($row[4],' ,'),'cp1251');
                    
$row[4]=Zamena($row[4], $d00_idl, '����� ���');
$row[4]=Zamena($row[4], $d00_idl_1, '����� ���');
$row[4]=Zamena($row[4], $d00_18, '�� 18:00');
$row[4]=Zamena($row[4], $d00_18_1, '�� 18:00');
$row[4]=Zamena($row[4], $d00_next_12, '������ ���� �� 12:00');
$row[4]=Zamena($row[4], $d00_next_12_1, '������ ���� �� 12:00');
$row[4]=Zamena($row[4], $d00_12, '�� 12:00');
$row[4]=Zamena($row[4], $d00_12_1, '�� 12:00');
$row[4]=Zamena($row[4], $d00_next_9, '������ ���� � 9:00');
$row[4]=Zamena($row[4], $d00_next_9_1, '������ ���� � 9:00');
$row[4]=Zamena($row[4], $d00_orig_idl, '�������� ���');
$row[4]=Zamena($row[4], $d00_orig_idl_1, '�������� ���') ;
$row[4]=Zamena($row[4], $d00_lr, '����� � ����');
$row[4]=Zamena($row[4], $d00_ov, '����� ��� ��������' );
$row[4]=Zamena($row[4], $d00_osd, '����� � ���������');
$row[4]=Zamena($row[4], $d00_9, '� 9:00') ;
$row[4]=Zamena($row[4], $d00_9_1, '� 9:00') ;
$row[4]=Zamena($row[4], $d00_vko, '����� ��');
$row[4]=Zamena($row[4], $d00_voo, '�������� ��');
                                                    
                                 
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
$result = mysqli_query($link,  "Insert into PHP_Log VALUES(DEFAULT, '$FilePHP Action', 'Server', '10.10.1.10', NOW(), 'Spec Instruction update less 50 char')");                  
#$out = shell_exec('mail -s \'TEST\' -a /var/www/files/2017-06-05.txt it@corp.dimex.ws');
#var_dump($out);   
fclose($fd1);
fclose($fd2);                                                         }                                                     
                              
 ?>

