<?php
$location = "localhost";  
$namedb = "aero";  
$user = "root";  
$password = "root";  
$link = mysqli_connect($location, $user, $password, $namedb)  
 or die("Ошибка " .mysqli_error($link));
 if (isset($_POST['g-recaptcha-response'])) {
    $url_to_google_api = "https://www.google.com/recaptcha/api/siteverify";
    $secret_key = '6Lfw55gUAAAAAGwDXW1VUsmRhOkZBEy_ikTnTejP';
    $query = $url_to_google_api . '?secret=' . $secret_key . '&response=' . $_POST['g-recaptcha-response'] . '&remoteip=' . $_SERVER['REMOTE_ADDR'];
    $data = json_decode(file_get_contents($query));
    if ($data->success) {
        $massage="";
function check_fio($fio){
    if(!empty($fio)){
        $fio = trim($fio);
        if(iconv_strlen($fio)<20){
            if(preg_match("/^[а-яА-Яa-zA-Z]+$/iu", $fio)){
                return $fio;
            }else{
                global $massage; 
                $massage.= "Значение ФИО:".$fio."указана неверно;<br>";
            }
        }
    }else{
        global $massage;
        $massage.="Значения ФИО:" .$fio."не заполнены;<br>";
    }
}
//Валидация ФИО
$last_name = check_fio($_POST["last_name"]);
$name =check_fio($_POST["name"]);
$first_name = check_fio($_POST["first_name"]);
//Валидайия номера
$number = $_POST["number"];

if(!empty($number)){
    $number = trim($number);
    if(iconv_strlen($number)<11){
        if(!ctype_digit($number)){
            $massage.="Номер введен неверно;<br>";
        }else{
            $number="8".$number;
        }
    }else{
        $massage.="Номер введен неверно";
    }
}else{
        $massage.="Введите номер телефона;<br>";
    }
//Валидация почты
$mail = $_POST["Email"];
if(!empty($mail)){
    if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        $massage.="E-mail адрес .$mail. указан неверно;<br>";
    }
}else{
    $massage.="Введите E-mail;<br>";
}
//валидация даты рождения 
    $happy_birthday =$_POST["data"]; 
    if(!empty($happy_birthday)){
        $max_data = date_create(date("Y-m-d"));
        $min_data = date_modify(date_create(date("Y-m-d")), '-100 year');  
        $happy_birthday1 =date_create($happy_birthday);
        if($min_data>$happy_birthday1 && $max_data<$happy_birthday1){
            $massage.="Дата указана неверно;<br>";
        }
    }else{
    $massage.="Введите дату;<br>";
}  
//валидация комментария
$commit =$_POST["commit"];
$commit =htmlspecialchars($commit);
$commit =mysqli_real_escape_string($link, $commit);
//загрузка в БД
if(!empty($massage)){
    echo $massage; 
}else{
    $query ="INSERT INTO academy (Last_name,Second_name,First_name,Number_tel,Email,happy_birthday,Coment) VALUES ('$last_name','$name','$first_name','$number','$mail','$happy_birthday','$commit')";
    $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 
if($result)
{
echo "Данные занесены в таблицу";
}
}	  
    } else {
        exit('Извините но похоже вы робот \(0_0)/');
    }
} else {
    exit('Вы не прошли валидацию reCaptcha');
}
mysqli_close($link);
?>