<?php 

    $link_mto = mysqli_connect( 
         '10.10.1.2',  // Хост, к которому мы подключаемся 
            'root',      // Имя пользователя  
            '2me32jvppn',    // Используемый пароль 
            'MTO');     // База данных для запросов по умолчанию  
    $link_mto->set_charset("cp1251");
   # $link->set_charset('utf8');
    
   /* $link = mysqli_connect( 
         '10.10.1.2',  // Хост, к которому мы подключаемся 
            'root',      // Имя пользователя  
            '2me32jvppn',    // Используемый пароль 
            'Caiser');     // База данных для запросов по умолчанию  
    $link->set_charset("cp1251");
     $link->set_charset('utf8');   */
   ?>