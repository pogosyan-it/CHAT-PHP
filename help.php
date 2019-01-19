<html><title>Помощь</title>
<head>   <link rel="shortcut icon" href="dimex.jpg" type="image/x-icon">
<meta http-equiv="content-type" content="text/html; charset=cp1251">
 <link rel="stylesheet" href="style.css"  type="text/css">        
 <style type="text/css">
 
 
 </style>
 
  <?php
   include 'profilaktika.php'; 
 session_start();  
  

 ?>

<table align=center text-align=center >
     
    <tr>
        <td><form method="POST" action="">
  <input <button style="background: #00FF80; width: 70px; height: 40px; 
border-radius: 5px; box-shadow: 0px 1px 3px; font-size: 17px; text-align: center;" type="submit" value="Выход" name="but"></button></form> </td>
        <td><form action="Menu.php">
    <button style="background: #D8D8D8; width: 90px; height: 35px; 
border-radius: 5px; box-shadow: 0px 1px 3px; font-size: 17px; text-align: center;" type="submit">Назад</button>
</form> </td> 
    </tr>
</table>

<table align=center text-align=center border=1 >
    <tr>
        <td><button  style="background: #CEF6F5; width: 260px; height: 50px; border-radius: 5px; white-space: pre-line; box-shadow: 0px 1px 3px; font-size: 15px; text-align: left;" 
   >Удаление организации в регионе</button></td>
        <td>Мониторинг и чистки баз Клиентов по отправкам Москвы. В случае если, организация (адрес) вбиты некорректно, или данные по Клиенту настолько объемны, что программа зависает
         при набивке данных этого Клиента в ИС GSoT - удаление Клиента. Тем самым база не переполняется вновь создаваемыми аналогичными организациями и Клиентами.</td>
    </tr>
    <tr>
        <td><button  style="background: #CEF6F5; width: 260px; height: 50px; border-radius: 5px; white-space: pre-line; box-shadow: 0px 1px 3px; font-size: 15px; text-align: left;" 
   >Очистка региона</button></td>
        <td>Мониторинг и чистки Клиентских баз по отправкам Москвы по региону. В случае если весь регион зависает или вообще на нем вылетает ИС GSoT,
         о чем информируют операторы БД - очищаем полностью регион. Также использем, если считаем, что многие клиенты находящиеся в одном регионе вбиты некорректно. 
         Что бы не несколько Клиентов удалять, а сразу почистить всех Клиентов одного региона. </td>
    </tr>
    <tr>
        <td><button  style="background: #CEF6F5; width: 260px; height: 50px; border-radius: 5px; white-space: pre-line; box-shadow: 0px 1px 3px; font-size: 15px; text-align: left;" 
   >Добавление адреса в справочник</button></td>
        <td>Пополнения базы для импорта и экспорта таблиц БД. Позволяет создать улицу по Москве, добавить дом. Важен для закачки АД от городов для 
        корректности и скорости определения маршрута сотрудником ИАО.</td>
    </tr>
    <tr>
        <td><button  style="background: #CEF6F5; width: 260px; height: 50px; border-radius: 5px; white-space: pre-line; box-shadow: 0px 1px 3px; font-size: 15px; text-align: left;" 
   >Добавление населенного пункта</button></td>
        <td>Пополнения базы для импорта и экспорта таблиц.  Позволяет создать НП как по МО, так и по всей РФ и странам страны (Украина, Казахстан, Белоруссия и т.д.). </td>
    </tr>
    <tr>
        <td><button  style="background: #CEF6F5; width: 260px; height: 50px; border-radius: 5px; white-space: pre-line; box-shadow: 0px 1px 3px; font-size: 15px; text-align: left;" 
   >Изменение маршрута у населенного пункта МО</button></td>
        <td>Корректность закачки таблиц БД (Адреса на доставку). Необходим в случае, когда ОВЛ изменяет полностью маршрут у НП МО.</td>
    </tr>
    <tr>
        <td><button  style="background: #CEF6F5; width: 260px; height: 50px; border-radius: 5px; white-space: pre-line; box-shadow: 0px 1px 3px; font-size: 15px; text-align: left;" 
   >Изменение или добавление адреса в ВП</button></td>
        <td>Данные (адреса и телефоны) региональных офисов Даймэкс, которые отображаются в графе № 2 при оформлении накладной внутренней почты. 
        Позволяет своевременно изменить информацию, что важно при создании ВП.</td>
    </tr>
    <tr>
        <td><button  style="background: #CEF6F5; width: 260px; height: 50px; border-radius: 5px; white-space: pre-line; box-shadow: 0px 1px 3px; font-size: 15px; text-align: left;" 
   >Указание областной принадлежности НП</button></td>
        <td>Корректность внесения информации в ИС GSoT. Существуют НП с одинаковыми названиями, но в разных областях/краях. При закачки таблиц, ИС GSoT не 
        отображает, какой именно НП, какой области используется. Аналогичная ситуация с базой данных по клиентам МСК. Данная функция позволяет в скобках указывать областную 
        принадлежность, тем самым исключить некорректное заполнение информации. </td>
    </tr>
  
</table> 
    </br>
  <?php   


      ?>

 
