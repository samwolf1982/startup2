<?php 


 define('MAIL_USER', 'biryukwolf1@gmail.com');
 // define('MAIL_USER', 'kidu@micsocks.net');
 // define('MAIL_USER', 'dukagux@dnsdeer.com');



//if (!isset($_POST['data'])) {
//	 echo json_encode(['status'=>false]);
//	 die();
//}

$params = array();
//parse_str($_POST['data'], $params);


 // var_dump($params);

// echo count($_POST['data']);


// $_POST=$_POST['data'];


$subject ='Registration';

$u_name=$params["name"]='BMW';
$u_tname=$params["tel"]='1234567899';
$u_oname=$params["org"]='My office';

   $body = "<html><head><title>Contact Form - " . stripslashes($subject) . "</title></head>
<body><p>Принять участие</p><table width='100%' >";  

 $body.="<tr><td><strong>Участник :</strong></td><td>{$u_name}</td>
<td>{$u_tname}</td><td>{$u_oname}</td>
 </tr>";





$name="Участник";
$phone="232423";
$email="site";


 $name="Участник";
 $body.="</table></body></html>";

        $headers = "MIME-Version: 1.0\n";
        $headers .= "Content-Type: text/html; charset=\"UTF-8\"\n";
        $headers .= "X-Priority: 1 (Highest)\n";
        $headers .= "X-MSMail-Priority: High\n";
        $headers .= "Importance: High\n";
        $headers .= 'From:' . $subject . "\r\n";
   //     if ()
   if(mail(MAIL_USER, "Registration", $body, $headers)) {
       $data['message'] = "<h3>Сообщение отправлено</h3> Спасибо за обращение " . $name . " в ближайшее время мы с Вами свяжемся.";

       echo json_encode(['status' => true]);
   }else{
       echo json_encode(['status' => 'mail return false']);
   }

    // if ($data['success'] == 1) {
   










        

        //здесь нужно вписать свой email
        // @mail("powerlll@mail.ru", "APRO_Contact_Form - " . stripslashes($subject), $body, $headers);
  //       $data['message'] = "<h3>Сообщение отправлено</h3> Спасибо за обращение " . $name . " в ближайшее время мы с Вами свяжемся.";

     
    // }

  




 ?>

 <?php



die();
// error_reporting(0);

require_once 'config.php';
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['lead_phone'])) {

    // collect all input and trim to remove leading and trailing whitespaces
    $name = trim($_POST['lead_name']);
    $phone = trim($_POST['lead_phone']);
    $subject ='Сотрудничество'; 
    $message='Сотрудничество';

 

    // проверки
    //провекрка имя
    if (strlen($name) == 0) {
        $name="Клиент";
    }

    //поле для email
    /*if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'укажите реальный email';
    }*/

    //телефон
    // if (!preg_match('/^\(?[0-9]{3}\)?|[0-9]{3}[-. ]? [0-9]{3}[-. ]?[0-9]{4}$/', $phone)) {
    //     $errors['phone'] = 'номер телефона, пожалуйста в формате +7 (XХХ) ХХХ-ХХ-ХХ';
    // }
     if (!preg_match('/^\+[0-9]{1} \([0-9]{3}\) [0-9]{3}-[0-9]{2}-[0-9]{2}$/', $phone)) {
        $errors['phone'] = 'Телефон введён неверно!';
    }

    //тема сообщения
    // if (strlen($subject) == 0) {
    //     $errors['subject'] = 'Укажите тему, пожалуйста';
    // }

// $ru="АаБбВвГгДдЕеЁёЖжЗзИиЙйКкЛлМмНнОоПпРрСсТтУуФфХхЦцЧчШшЩщЪъЫыЬьЭэЮюЯяАаБбВвГгҐґДдЕеЄєЖжЗзИиIіЇїЙйКкЛлМмНнОоПпРрСсТтУуФфХхЦцЧчШшЩщЬьЮюЯя";
// $ua="АаБбВвГгҐґДдЕеЄєЖжЗзИиIіЇїЙйКкЛлМмНнОоПпРрСсТтУуФфХхЦцЧчШшЩщЬьЮюЯя";
// $cp1251=iconv("UTF-8","windows-1251",$ua.$ru);


 if (!preg_match( "/^([a-zA-ZАаБбВвГгДдЕеЁёЖжЗзИиЙйКкЛлМмНнОоПпРрСсТтУуФфХхЦцЧчШшЩщЪъЫыЬьЭэЮюЯяАаБбВвГгҐґДдЕеЄєЖжЗзИиIіЇїЙйКкЛлМмНнОоПпРрСсТтУуФфХхЦцЧчШшЩщЬьЮюЯя]{3,32})$/u", $name) || $name=='Как вас зовут?') {
        $errors['name'] = 'Имя должно быть от 3 до 32 символов!';
    }

 // if (!preg_match( '/^([а-яА-ЯЁёa-zA-Z_]{3,32}+)$/u', $name) || $name=='Как вас зовут?') {
 //        $errors['name'] = 'Имя должно быть от 3 до 32 символов!';
 //    }

    ;

   //проверочный пример или вопрос, в данном случае ответ 4
   /*if($_REQUEST['sc'] != '4') {
    $errors['sc'] = 'ответьте на вопрос, пожалуйста';
   }

    //проверка чтобы сообщение не было пустым
    if (strlen($message) == 0) {
        $errors['message'] = 'сообщение пустое';
    }*/

    //чекбокс
    /*if (!isset($_POST['condition'])) {
        $errors['condition'] = 'поставьте галочку, если Вы человек, а не робот';
    }*/

       // if ($subject=='как к Вам обращаться') $subject="User";
     $data['errors'] = $errors;
    $data['success'] = (count($errors)) ? 0 : 1;

    // If no errors were found, proceed sending email
    if ($data['success'] == 1) {
   





        $body = "<html><head><title>Contact Form - " . stripslashes($subject) . "</title></head>
<body><table width='100%' cellspacing='3' cellpadding='3'>
<tr><td width='40%'><strong>Тема вопроса: </strong></td><td width='60%'>Стать партнером</td></tr>
<tr><td width='40%'><strong>Имя: </strong></td><td width='60%'>" . $name . "</td></tr>
<tr><td><strong>Телефон: </strong></td><td>" . $phone . "</td></tr>

</table></body></html>";




        $headers = "MIME-Version: 1.0\n";
        $headers .= "Content-Type: text/html; charset=\"UTF-8\"\n";
        $headers .= "X-Priority: 1 (Highest)\n";
        $headers .= "X-MSMail-Priority: High\n";
        $headers .= "Importance: High\n";
        $headers .= 'From:' . $email . "\r\n";

        //здесь нужно вписать свой email
        // @mail("powerlll@mail.ru", "APRO_Contact_Form - " . stripslashes($subject), $body, $headers);
  //       $data['message'] = "<h3>Сообщение отправлено</h3> Спасибо за обращение " . $name . " в ближайшее время мы с Вами свяжемся.";

        @mail(MAIL_USER, "APRO_Contact_Form", $body, $headers);
        $data['message'] = "<h3>Сообщение отправлено</h3> Спасибо за обращение " . $name . " в ближайшее время мы с Вами свяжемся.";
    }

    echo json_encode($data);




}
elseif($_SERVER["REQUEST_METHOD"] == "POST") {           //  UP FORM 

    // collect all input and trim to remove leading and trailing whitespaces
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $subject = trim($_POST['subject']);
    $message = trim($_POST['message']);
    $color = trim($_POST['color']);

    $errors = array();

    // проверки

	//провекрка имя
	if (strlen($name) == 0) {
        $errors['name'] = 'назовитесь, пожалуйста ';
    }
    if ($name=='как к Вам обращаться') {
          $name="Обратний звонок";
    }

	//поле для email
    /*if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'укажите реальный email';
    }*/

    //телефон
   // if (!preg_match('/^\(?[0-9]{3}\)?|[0-9]{3}[-. ]? [0-9]{3}[-. ]?[0-9]{4}$/', $phone)) {
   //      $errors['phone'] = 'номер телефона, пожалуйста в формате +7 (XХХ) ХХХ-ХХ-ХХ';
   //  }
    
	    if (!preg_match('/^\+[0-9]{1} \([0-9]{3}\) [0-9]{3}-[0-9]{2}-[0-9]{2}$/', $phone)) {
        $errors['phone'] = 'Телефон введён неверно!';
    }
     
 if (!preg_match( "/^([a-zA-ZАаБбВвГгДдЕеЁёЖжЗзИиЙйКкЛлМмНнОоПпРрСсТтУуФфХхЦцЧчШшЩщЪъЫыЬьЭэЮюЯяАаБбВвГгҐґДдЕеЄєЖжЗзИиIіЇїЙйКкЛлМмНнОоПпРрСсТтУуФфХхЦцЧчШшЩщЬьЮюЯя]{3,32})$/u", $name) || $name=='Как вас зовут?') {
        $errors['name'] = 'Имя должно быть от 3 до 32 символов!';
    }
     
    //тема сообщения
	if (strlen($subject) == 0) {
        $errors['subject'] = 'Укажите тему, пожалуйста';
    }

   //проверочный пример или вопрос, в данном случае ответ 4
   /*if($_REQUEST['sc'] != '4') {
    $errors['sc'] = 'ответьте на вопрос, пожалуйста';
   }

    //проверка чтобы сообщение не было пустым
	if (strlen($message) == 0) {
        $errors['message'] = 'сообщение пустое';
    }*/

    //чекбокс
	/*if (!isset($_POST['condition'])) {
        $errors['condition'] = 'поставьте галочку, если Вы человек, а не робот';
    }*/

       // if ($subject=='как к Вам обращаться') $subject="User";
    
    $data['errors'] = $errors;
    $data['success'] = (count($errors)) ? 0 : 1;

    // If no errors were found, proceed sending email
    if ($data['success'] == 1) {


        $body = "<html><head><title>Contact Form - " . stripslashes($subject) . "</title></head>
<body><table width='100%' cellspacing='3' cellpadding='3'>
<tr><td width='40%'><strong>Тема вопроса: </strong></td><td width='60%'>" . $subject . "</td></tr>
<tr><td width='40%'><strong>Имя: </strong></td><td width='60%'>" . $name . "</td></tr>
<tr><td><strong>Телефон: </strong></td><td>" . $phone . "</td></tr>

</table></body></html>";

//<tr><td><strong>Сообщение</strong></td><td>" . $message . "</td></tr>


        $headers = "MIME-Version: 1.0\n";
        $headers .= "Content-Type: text/html; charset=\"UTF-8\"\n";
        $headers .= "X-Priority: 1 (Highest)\n";
        $headers .= "X-MSMail-Priority: High\n";
        $headers .= "Importance: High\n";
        $headers .= 'From:' . $email . "\r\n";

        //здесь нужно вписать свой email
		// @mail("powerlll@mail.ru", "APRO_Contact_Form - " . stripslashes($subject), $body, $headers);
  //       $data['message'] = "<h3>Сообщение отправлено</h3> Спасибо за обращение " . $name . " в ближайшее время мы с Вами свяжемся.";

        @mail(MAIL_USER, "APRO_Contact_Form", $body, $headers);
        $data['message'] = "<h3>Сообщение отправлено</h3> Спасибо за обращение в ближайшее время мы с Вами свяжемся.";
    }

    echo json_encode($data);
}
?>