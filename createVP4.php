<html>    <title>Добавление адреса в справочник</title>
<head>
<meta http-equiv="content-type" content="text/html; charset=cp1251">
 <link rel="stylesheet" href="stylestreet.css"  type="text/css">
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
include 'gsotldb.php'; 
    
     $instruct= $_POST['instruct'];     //спец. инструкции
     $discr= $_POST['discr'];          //Описание груза
   # $weight= $_POST['weight'];        //Вес
   # $places= $_POST['places'];        //Кол-во мест
     $dest= $_POST['dest'];            //Регион Назначения
   # $text = $_POST['num'];           //№ накладной
  #  $send=$_POST['send'];            //SName(Иванов И.И.)
     $fio=$_POST['FIO'];             //Получатель (по умолчанию ССС)
     $Login = $_SESSION['login'];              
     $send = $_SESSION['send'];
   
                                  
      if (empty($_POST["weight"]))     // по умолчанию вес 0,5
        {$weight="0.5";}
        else 
         {$weight= $_POST['weight'];    //проверка на цифры и замена на точку
          $pattern = "/^[0-9.,]+$/i";
          $found = (preg_match($pattern, $weight));
          if ($found)   { $weight = str_replace(",", ".", $weight);} 
          else {
          $_SESSION['NoWeight'] = 'NoWeight';        //Неверно указан вес
  header("Location: createVP3.php");      
    exit;
    }  
         }
      if (empty($_POST["places"]))
        {$places="1";}                //по умолчанию вес 1
        else 
         { $places= $_POST['places'];       //проверка на цифры 
           $pattern1 = "/^[0-9]+$/i";
           $found1 = (preg_match($pattern1, $places));
           if ($found1) {$places=$places;}
           else {
           $_SESSION['NoPlaces'] = 'NoPlaces';            //Неверно указано Кол-во мест
  header("Location: createVP3.php");      
    exit;
           }  
         }
          if (empty($_POST["FIO"]))
        {$fio="CCC";}
        else 
         {$fio= $_POST['FIO'];}       
    
           if(isset($_POST['tipe']) &&          //по умолчанию экспресс
          $_POST['tipe'] == 'Yes')
{          $Ser_type=1;
  $_SESSION['tipe'] = $Ser_type;
    ?>
     <div id="text_type2"><b>v</b></div>
    <?php
}
else
{    $Ser_type=0;
$_SESSION['tipe'] = $Ser_type;
     ?>
     <div id="text_type1"><b>v</b></div>
    <?php
}
    
    if (empty($_POST['dest']))
              {
          $_SESSION['NoDest'] = 'NoDest';      //не выбран регион назначения
  header("Location: createVP3.php");  
      exit; 
             }  
              else
              {
                $res =  mysqli_query($link, "Select hbc_country.Name, hbc_divisions.Mask from hbc_country  left join hbc_divisions on hbc_divisions.CountryID=hbc_country.ID
                                    where hbc_divisions.Name='$dest'");
              while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC))
					   {
						   
               $countr=$row['Name'];
               $city=$row['Mask'];
					   }
					 		mysqli_free_result($res);          
   
    #$res =  mysqli_query($link, "Select hbc_divAddr.ID from hbc_divAddr where hbc_divAddr.Name=='$dest' into @dest_id;");
    $res =  mysqli_query($link, "Select ID, Phone, AddrID, d80ID, d81ID, Addr, FullName from hbc_divAddr 
                                where hbc_divAddr.Name='$dest' ;");
              while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC))
					   {
						   $dest_id = $row['ID'];
               $phone=$row['Phone'];
               $AddrID=$row['AddrID'];
               $d80ID=$row['d80ID'];
               $d81ID=$row['d81ID'];
               $Addr=$row['Addr'];
               $dmx=$row['FullName'];
					   }
					 		mysqli_free_result($res);
              
  if (!empty($Addr))   {            //проверка на адрес
     
   $res_1 =  mysqli_query($link, "Select MIN(ID) as min_id from nakl_vp where nakl_vp.exist_key=0");
          while ($row = mysqli_fetch_array($res_1, MYSQLI_ASSOC))
					   {
						   $min_id=$row['min_id'];
					   }
         
$res_1 =  mysqli_query($link, "Select DATE_FORMAT(nakl_vp.date, '%m%d') as day_start from nakl_vp where nakl_vp.ID=(Select MIN(nakl_vp.ID) from nakl_vp where nakl_vp.exist_key=1);");
          while ($row = mysqli_fetch_array($res_1, MYSQLI_ASSOC))
					   {
						   $day_start=$row['day_start'];
					   }
       
$res_1 =  mysqli_query($link, "Select DATE_FORMAT(nakl_vp.date, '%m%d') as day_stop from nakl_vp where nakl_vp.ID=(Select MAX(nakl_vp.ID) from nakl_vp where nakl_vp.exist_key=1);");
          while ($row = mysqli_fetch_array($res_1, MYSQLI_ASSOC))
					   {
						   $day_stop=$row['day_stop'];
					   }
					mysqli_free_result($res_1); 

  if ( $min_id==999 && $day_start==$day_stop)   
  
  {           
             
             $res_1 =  mysqli_query($link, "Select MIN(id) as min_id1 from nakl_vp where nakl_vp.date<>DATE_FORMAT(NOW(), '%Y-%m-%d') and nakl_vp.id<999  or nakl_vp.date is NULL;");
          while ($row = mysqli_fetch_array($res_1, MYSQLI_ASSOC))
					   {
						   $min_id1=$row['min_id1'];
					   }
             $res_1 =  mysqli_query($link, "Select MAX(id) as max_id from nakl_vp where nakl_vp.date<>DATE_FORMAT(NOW(), '%Y-%m-%d') and nakl_vp.id<999 or nakl_vp.date is NULL;");
          while ($row = mysqli_fetch_array($res_1, MYSQLI_ASSOC))
					   {
						   $max_id=$row['max_id'];
					   }
					mysqli_free_result($res_1);   
  
  
  if (empty($min_id1)&&empty($max_id))   {
  $_SESSION['NoNum'] = 'NoNum';                //номера закончились
  header("Location: createVP3.php");  
      exit; }
      else {
                                    //блок 1
                                    $_SESSION['blok'] = 'блок 1';
            $res_1 =  mysqli_query($link, "Update nakl_vp SET nakl_vp.exist_key=0, nakl_vp.date=NULL where nakl_vp.id >= $min_id1 and nakl_vp.id <= $max_id;");             
            $res_1 =  mysqli_query($link, "Select nakl_vp.num from nakl_vp where nakl_vp.ID=(Select MIN(ID) from nakl_vp where nakl_vp.exist_key=0) into @num");
            $res =  mysqli_query($link,   "Select nakl_vp.num from nakl_vp where nakl_vp.ID=(Select MIN(ID) from nakl_vp where nakl_vp.exist_key=0)"); 
            $res_1 =  mysqli_query($link, "Update nakl_vp SET nakl_vp.exist_key=1,nakl_vp.date=NOW() where nakl_vp.num=@num and nakl_vp.id<999"); 
                     while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) 
                {
				  
				   $number=$row['num'];
              	}
                mysqli_free_result($res);
   $text='1'.date("ymd").$number[1].$number[2].$number[3];
      
           }    
    }  
  elseif ( $min_id==999 && $day_start<>$day_stop )  {        // блок 2
                                         $_SESSION['blok'] = 'блок 2';
 $res_1 =  mysqli_query($link, "Update nakl_vp SET nakl_vp.exist_key=0, nakl_vp.date=NULL where nakl_vp.exist_key=1 and nakl_vp.id<999 and DATE_FORMAT(nakl_vp.date, '%Y-%m-%d') <> DATE_FORMAT(NOW(), '%Y-%m-%d') or nakl_vp.date is NULL");             
 $res_1 =  mysqli_query($link, "Select nakl_vp.num from nakl_vp where nakl_vp.ID=(Select MIN(ID) from nakl_vp where nakl_vp.exist_key=0) into @num");
 $res =  mysqli_query($link, "Select nakl_vp.num from nakl_vp where nakl_vp.ID=(Select MIN(ID) from nakl_vp where nakl_vp.exist_key=0)"); 
 $res_1 =  mysqli_query($link, "Update nakl_vp SET nakl_vp.exist_key=1,nakl_vp.date=NOW() where nakl_vp.num=@num and nakl_vp.id<999"); 
                     while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) 
                {
				  
				   $number=$row['num'];
              	}
                mysqli_free_result($res);
   $text='1'.date("ymd").$number[1].$number[2].$number[3];  
                                                 }
  else {                       //блок 3
           $_SESSION['blok'] = 'блок 3';
         $res_1 =  mysqli_query($link, "Select nakl_vp.num from nakl_vp where nakl_vp.ID=(Select MIN(ID) from nakl_vp where nakl_vp.exist_key=0) into @num");
         $res =  mysqli_query($link, "Select nakl_vp.num from nakl_vp where nakl_vp.ID=(Select MIN(ID) from nakl_vp where nakl_vp.exist_key=0)"); 
         $res_1 =  mysqli_query($link, "Update nakl_vp SET nakl_vp.exist_key=1, nakl_vp.date=NOW() where nakl_vp.num=@num and nakl_vp.id<999"); 
                     while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) 
                {
				 
				   $number=$row['num'];  
            
      }
                  
                    $text='1'.date("ymd").$number[1].$number[2].$number[3];
                      
                    mysqli_free_result($res);
        }                
                    
   $_SESSION['text'] = $text;
     
     $res2 =  mysqli_query($link, "Select d15_departures.WayBillNum as bill from d15_departures where d15_departures.WayBillNum='$text'");
              while ($row = mysqli_fetch_array($res2, MYSQLI_ASSOC))
					   {
						   $billnum=$row['bill'];
					   }
					 		mysqli_free_result($res2);
    
  if (empty($billnum)) {      //проверка на существование такой накладной в базе

  $res1 =  mysqli_query($link, "Select id from hb_employee where hb_employee.Login='$Login' into @emp_id;");
   
  $res1 =  mysqli_query($link, "Select hbc_divisions.CountryID from hbc_divisions where hbc_divisions.Name='$dest' into @country_id;");
  $res1 =  mysqli_query($link, "Select hbc_divisions.CityID from hbc_divisions where hbc_divisions.Name='$dest' into @city_id;"); 
  $res1 =  mysqli_query($link, "Insert into d15_departures Values ();");
  $res1 =  mysqli_query($link, "Select LAST_INSERT_ID() into @last_id;");
  $res1 =  mysqli_query($link, "Update d15_departures SET d15_departures.SY_Empl=@emp_id, 
                                d15_departures.FromDivID='1', d15_departures.ToDivID='$dest_id', d15_departures.fSidePost='1', 
                                d15_departures.fWayBill='1', d15_departures.WayBillNum='$text', d15_departures.WayBillDate=(Select curdate()), 
                                d15_departures.S_Name='ООО \"Даймэкс-Корп\"', d15_departures.S_Contact='$send', d15_departures.S_Phone='84996104152', 
                                d15_departures.S_CountryID='7', d15_departures.S_CityID='2', d15_departures.S_d80ID='2998',
                                d15_departures.S_d81ID='535045', d15_departures.S_AddrID='8604074',  
										            d15_departures.S_Addr='КОТЛЯКОВСКИЙ 1-Й пер., д.6, стр.1', d15_departures.PaymentTXT='КОРП', 
										            d15_departures.Otpravka='Внутренняя Почта', d15_departures.Ser_ec='3', d15_departures.SY_Adding= NOW(),
                                d15_departures.R_CountryID=@country_id, d15_departures.R_CityID=@city_id, R_Phone='$phone', R_AddrID='$AddrID', 
                                R_d80ID='$d80ID', R_d81ID='$d81ID', R_Addr='$Addr', d15_departures.Sh_Place='$places', R_Name='$dmx',
                                d15_departures.Sh_Weight='$weight', d15_departures.R_Contact='$fio', d15_departures.Sh_EWeight='$weight', d15_departures.Sh_Discr='$discr', 
                                d15_departures.Sh_Instructions='$instruct', d15_departures.Ser_type='$Ser_type', d15_departures.PayType='2',
                                d15_departures.Payment='1', d15_departures.WarehousID='2', d15_departures.DeliveryID='0' where d15_departures.ID=@last_id;"); 
  
  $res =  mysqli_query($link, "Select ID from d30_manifests where d30_manifests.ToDiv='$dest_id' and
                               d30_manifests.fLock='0' and d30_manifests.fClose='0' and d30_manifests.SY_Void='0'");
              while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC))
					   {
						   
               $mun_id=$row['ID'];
					   }
					 		mysqli_free_result($res);  
    if (!empty($mun_id)) {
       #  echo "В существующий";
        $res2 =  mysqli_query($link, "Select d30_manifests.Sh_Place from d30_manifests where d30_manifests.ID='$mun_id' into @place;");
        $res2 =  mysqli_query($link, "Select @place+'$places' into @place;");
        $res2 =  mysqli_query($link, "Select d30_manifests.SWeight from d30_manifests where d30_manifests.id='$mun_id' into @sweight;");
        $res2 =  mysqli_query($link, "Select d30_manifests.OWeight from d30_manifests where d30_manifests.id='$mun_id' into @oweight;");
        $res2 =  mysqli_query($link, "Select d30_manifests.TWeight from d30_manifests where d30_manifests.id='$mun_id' into @tweight;");
        $res2 =  mysqli_query($link, "Select @sweight+'$weight' into @weight;");
        #$res2 =  mysqli_query($link, "Select d30_manifests.Sh_Weight from d30_manifests where d30_manifests.id='$mun_id' into @weight;");
        $res2 =  mysqli_query($link, "Select @weight+@oweight+@tweight into @total_weight;");
        $res2 =  mysqli_query($link, "Update d30_manifests SET d30_manifests.Sh_Place=@place, d30_manifests.Sh_Weight=@total_weight,
                                      d30_manifests.SWeight=@weight where d30_manifests.ID='$mun_id';");
        $res2 =  mysqli_query($link, "Insert into d31_manifest2departure Values ();");   
        $res2 =  mysqli_query($link, "Select LAST_INSERT_ID() into @last_id1;"); 
        $res2 =  mysqli_query($link, "Update d31_manifest2departure SET d31_manifest2departure.SY_Adding=NOW(), d31_manifest2departure.SY_Empl=@emp_id, d31_manifest2departure.d30ID='$mun_id',
                                      d31_manifest2departure.d15ID=@last_id, d31_manifest2departure.Comments='Внутренняя Почта' where 
                                      d31_manifest2departure.ID=@last_id1;");       
                                                   }   
     else {
            # echo "Создал новый";
             $res2 =  mysqli_query($link, "Insert into d30_manifests Values ();");
             $res2 =  mysqli_query($link, "Select LAST_INSERT_ID() into @last_id2;");
             $res2 =  mysqli_query($link, "Select DATE_FORMAT(NOW(), '%Y-%m-%d') into @date;"); 
             $res2 =  mysqli_query($link, "Select d15_departures.Sh_Place from d15_departures where d15_departures.ID=@last_id into @place;");
             $res2 =  mysqli_query($link, "Select d15_departures.Sh_Weight from d15_departures where d15_departures.ID=@last_id into @weight;");
             $res2 =  mysqli_query($link, "Select Concat('NEW',RIGHT(d30_manifests.ID,4)) from d30_manifests where d30_manifests.ID=@last_id2 into @man_num");
             $res2 =  mysqli_query($link, "Update d30_manifests SET d30_manifests.SY_Adding=NOW(), d30_manifests.Sh_Place=@place, d30_manifests.Sh_Weight=@weight, 
                                          d30_manifests.ToDiv='$dest_id',  d30_manifests.ManifestDate=@date,
                                          d30_manifests.SWeight=@weight, d30_manifests.ManifestNum=@man_num, d30_manifests.SY_Empl=@emp_id where d30_manifests.ID=@last_id2;");
            $res2 =  mysqli_query($link, "Insert into d31_manifest2departure Values ();"); 
            $res2 =  mysqli_query($link, "Select LAST_INSERT_ID() into @last_id3;"); 
            $res2 =  mysqli_query($link, "Update d31_manifest2departure SET d31_manifest2departure.SY_Adding=NOW(),
                                          d31_manifest2departure.SY_Empl=@emp_id, d31_manifest2departure.d30ID=@last_id2,
                                          d31_manifest2departure.d15ID=@last_id, d31_manifest2departure.Comments='Внутренняя Почта' where 
                                          d31_manifest2departure.ID=@last_id3;"); 
         }                                                     

  $_SESSION['weight'] = $weight;
  $_SESSION['countr'] = $countr;
  $_SESSION['city'] = $city;
  $_SESSION['FIO'] = $fio;
  $_SESSION['dest'] = $dest;
  $_SESSION['addr'] = $Addr;
  $_SESSION['phone'] = $phone;
  $_SESSION['places'] = $places;
  $_SESSION['instruct'] = $instruct;
  $_SESSION['discr'] = $discr;
  $_SESSION['dmx'] = $dmx;
header("Location: createVP5.php");   
    }  
else  
{
   $_SESSION['NumThere'] = $billnum;                //Такой номер уже существует
  header("Location: createVP3.php");  
      exit;
}
}
else
      {
      $_SESSION['NoAddr'] = 'NoAddr';     //Нет отправок в данном направлении
  header("Location: createVP3.php");  
      exit;
    } 
    }
            ?>        
  
</body>
</html>