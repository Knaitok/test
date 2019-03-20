<?php
if (isset($_POST['g-recaptcha-response'])) {
    $url_to_google_api = "https://www.google.com/recaptcha/api/siteverify";
    $secret_key = '';
    $query = $url_to_google_api . '?secret=' . $secret_key . '&response=' . $_POST['g-recaptcha-response'] . '&remoteip=' . $_SERVER['REMOTE_ADDR'];
    $data = json_decode(file_get_contents($query));
    if ($data->success) {
        //Валидация почты
        $mail = $_POST["Email"];
        $index = 0;
        if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
            echo "<script>alert(\"E-mail адрес указан верно.\");</script>";
            $index++;
        }else{
            echo "<script>alert(\"E-mail адрес '$mail' указан неверно.\");</script>";
        }
       //валидация даты рождения
       
           $happy_birthday =$_POST["data"];
           $happy_birthday =date_create($happy_birthday);
           $max_data = date_create(date("Y-m-d"));
           $min_data = date_modify(date_create(date("Y-m-d")), '-100 year');
               if($min_data<$happy_birthday && $max_data>$happy_birthday){
                   echo "<script>alert(\"Дата корректна\");</script>";
               }else{
                   echo "<script>alert(\"Дата указана неверно\");</script>";
               }
    } else {
        exit('Извините но похоже вы робот \(0_0)/');
    }
} else {
    exit('Вы не прошли валидацию reCaptcha');
}
?>