<head>
<LINK href="main.css" rel="stylesheet" type="text/css" />
</head>

<div class="container">
<center>    
<table class="container_table">
 <tr>
  <td valign = "top" class="container_table_header">
   <h1>Test task</h1>
  </td>    
 </tr>
 
 <tr>
  <td valign = "top">   
   <?php
   /**
    * Description - index page
    *
    * @author -- wildernix
    */
   session_start();

   require 'db_controller.php';
   require 'siteactions.php';

   $DataBase = new db_controller();
   $DataBase->connect();
 
   // if user authorized show full menu - login_flag = 1
   if ($_SESSION['login_flag'] === '1') {$DataBase->showmenu(1);} else {$DataBase->showmenu(0);}

   if ($user_id == NULL) {$user_id = $_SESSION['user_id'];}
   if ($act == "") {$act = $_GET['siteaction'];}

   switch ($act)
   {
    case 'show_login_form': {show_login_form(); break; }
    case 'registration': {show_registration_form(); break; }
    case 'insert_new_user': {$DataBase->insert_new_user($_GET['loginname'],$_GET['password'],$_GET['first_name'],$_GET['second_name'],$_GET['email'],$_GET['phone'],$_GET['birthday']); break; }
    case 'show_user_profile':{$DataBase->show_user_profile($user_id); break;}
    case 'authorize_user':{$DataBase->authorize_user($_GET['loginname'],$_GET['password']); break;}
    case 'profile_change_form':{$DataBase->get_user_profile_for_edit($user_id); break;}
    case 'update_user_profile':{$DataBase->update_user_profile($_GET['user_id'],$_GET['loginname'],$_GET['password'],$_GET['first_name'],$_GET['second_name'],$_GET['email'],$_GET['phone'],$_GET['birthday']); break;}
    case 'user_log_out':{$DataBase->user_log_out(); break;}
    case 'upload_user_file':{$DataBase->upload_user_file(); break;}
    case 'delete_user_file':{$DataBase->delete_user_file($fileid,$filename); break;}
    case 'delete_user_file_record':{$DataBase->delete_user_file_record($fileid); break;}
    case 'show_user_profile_history':{$DataBase->show_user_profile_history($user_id); break;}
   }

   ?>  
  </td>    
 </tr>
 
 <tr>
  <td valign = "bottom">
   <hr>Footer
  </td>    
 </tr>        
</table>
</center>
</div>

