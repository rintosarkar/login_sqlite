<?php
   
   class MyDB extends SQLite3
   {
      function __construct()
      {
         $this->open('psw.db3');
      }
   }
   $db = new MyDB();
   if(!$db){
      echo $db->lastErrorMsg();
   }
   
   $user_id = $_POST['user_id'];
   $password = $_POST['passwd'];
   $back = "<a href='index.html'>戻る</a>";
   
   if(empty($user_id) ){
      $error = "<p style='color:red'>Name を 入力してください!</p> {$back}";
      echo $error;
      return;
      
   }
   if(empty($password)){
      $error = "<p style='color:red'>password  を 入力してください!</p> {$back}";
      echo $error;
      return;
   }
      
   $sql ='SELECT count(*) as count, user_id as name, passwd as pass FROM pssw WHERE user_id="'.$user_id.'";';
   $escaped = SQLite3::escapeString($sql);

   $res = $db->query($escaped);
   while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
      $count = $row['count'];
      $username =  $row['name'];
      $pass = $row['pass'];
   }
   if($count != 0){
      if($pass != $password){
         $error = "<p style='color:red'>パスワードが違います。</p> {$back} ";
         echo $error;
         return;
      }

      $success = "<p style='color:green'>OK.</p> {$back}";
      echo $success;
   }else{
      $error = "<p style='color:red'>ユーザーが違います。</p> {$back}";
      echo $error;
      return;
   }

   $db->close();