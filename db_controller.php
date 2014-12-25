<?php

/**
 * Description of db_controller
 * Sqllite database, PDO
 * @author -- wildernix
 */
class db_controller
{
   
// DATABASE CONNECTION
    public function connect()
    {  
        $DB = new PDO("sqlite:db/maindb.db");       
        return $DB;
    }
//---
    
// SHOW MENU SECTION
    public function showmenu($authorized)
    {
        // 1 = full user menu, 0 = simple guest menu
        if ($authorized == 1)
         {
          echo "<a href='index.php'>Main page</a>&nbsp|&nbsp<a href='index.php?act=show_user_profile'>profile</a>&nbsp|&nbsp<a href='index.php?act=user_log_out'>log out</a><br><hr>"; 
         }
        else
         {
          echo "<a href='index.php'>Main page</a>&nbsp|&nbsp<a href='index.php?act=show_login_form'>sign in</a>&nbsp|&nbsp<a href='index.php?act=registration'>registration</a><br><hr>";  
         }
    }
// ---
   
// SHOW USER PROFILE
    public function show_user_profile($iid)
    {  
        $result=$this->connect()->query("SELECT * FROM users WHERE id = {$iid}"); // request for data         
        $result->setFetchMode(PDO::FETCH_OBJ); // selection mode
       
        echo "<h3>User profile:</h3>";
        // print data from request
        while($fields = $result->fetch()) 
         {              
          $temp_user_id = $fields->id;
            
          echo "<table>";
          echo "<tr><td>Login name:</td><td>{$fields->loginname}</td></tr>";
          echo "<tr><td>First name:</td><td>{$fields->first_name}</td></tr>";
          echo "<tr><td>Second name:</td><td>{$fields->second_name}</td></tr>";
          echo "<tr><td>E-mail:</td><td>{$fields->email}</td></tr>";
          echo "<tr><td>Phone:</td><td>{$fields->phone}</td></tr>";
          echo "<tr><td>Birthday:</td><td>{$fields->birthday}</td></tr>";
          echo "</table>";
         }
        echo "<br>";
        echo "<a href='index.php?user_id={$temp_user_id}&act=profile_change_form'>change my profile</a>&nbsp;|&nbsp<a href='index.php?user_id={$temp_user_id}&act=show_user_profile_history'>show history of changes</a>"; echo '<br>';        
        echo "<br>";
        echo "Work files";
        echo "<hr>";
        $this->show_user_files($temp_user_id); // list of user files
        echo "<hr>";
        
        // calculate, how many files left to upload
        $sql = "SELECT COUNT(*) FROM files WHERE user_id = {$temp_user_id}";
        $tempcount=$this->connect()->query($sql);
        $total_files=$tempcount->fetchColumn();
        $files_left = 20-$total_files;
        // ---
        
        echo "Uploaded - ".$total_files." files, you can upload ".$files_left." more files<br><br>";
        
        // show upload section 
        if ($files_left != 0)
         {
          echo "<form action='index.php' method='POST' enctype='multipart/form-data'>";                 
          echo "chose file for upload  ";
          echo "<input type=hidden name=act value=upload_user_file>";
          echo "<input type='file' name='uploadfile'>";
          echo "<input type='submit' value='upload'>";   
          echo "</form>"; 
         }
    }
//---
    
// GET USER ID BASED ON LOGINNAME
    public function get_user_id($iloginname)
    {  
        $result=$this->connect()->query("SELECT * FROM users WHERE loginname = '{$iloginname}'"); // request for data         
        $result->setFetchMode(PDO::FETCH_OBJ); // selection mode       
        // print data from request
        while($fields = $result->fetch()) 
          {              
           $user_id = $fields->id;
          }
        return $user_id;        
    }
//---
    
// GET USER DATA FOR UPDATE FORM AND BUILD THE FORM
    public function get_user_profile_for_edit($iid)
    {  
        $result=$this->connect()->query("SELECT * FROM users WHERE id = '{$iid}'"); // request for data         
        $result->setFetchMode(PDO::FETCH_OBJ); // selection mode
       
       // print data from request
       while($fields = $result->fetch()) 
        {              
         $user_data['id'] = $fields->id;
         $user_data['loginname'] = $fields->loginname;
         $user_data['password'] = $fields->password;
         $user_data['first_name'] = $fields->first_name;
         $user_data['second_name'] = $fields->second_name;
         $user_data['email'] = $fields->email;
         $user_data['phone'] = $fields->phone;
         $user_data['birthday'] = $fields->birthday;
        }
       // build form for edit data
       echo "<h3>Change profile data:</h3>"; 
       echo "<form method='GET' action='index.php'>";
       echo "<table border='0' class='datatable' align=left valign=top>";
       echo "<tr><td>*Login name:</td> <td><input type='text' name='loginname' value='{$user_data['loginname']}' required=''/></td></tr>";
       echo "<tr><td>*Password:</td> <td><input type='text' name='password' value='{$user_data['password']}' required=''/></td></tr>";
       echo "<tr><td>*First name:</td> <td><input type='text' name='first_name' value='{$user_data['first_name']}' required=''/></td></tr>";
       echo "<tr><td>*Second name:</td> <td><input type='text' name='second_name' value='{$user_data['second_name']}' required=''/></td></tr>";
       echo "<tr><td>E-mail:</td> <td><input type='text' name='email' value='{$user_data['email']}'/></td></tr>";
       echo "<tr><td>Phone:</td> <td><input type='text' name='phone' value='{$user_data['phone']}'/></td></tr>";
       echo "<tr><td>BirthDay:</td> <td><input type='text' name='birthday' value='{$user_data['birthday']}'/></td></tr>";
       echo "<tr><td><input type='hidden' name='user_id' value='{$user_data['id']}'/><input type='hidden' name='siteaction' value='update_user_profile'/></td><td><input type='submit' value='ok'/></td></tr>";
       echo "<tr><td>* required to fill</td><td></td></tr>";
       echo "</table>";
       echo "</form>";
       //---
    }
//---
    
// INSERT NEW USER
    public function insert_new_user($iloginname, $ipassword, $ifirst_name, $isecond_name, $iemail, $iphone, $ibirthday)
    {  
       try
        {        
         $sql="INSERT INTO users (loginname, password, first_name, second_name, email, phone, birthday) VALUES ('{$iloginname}', '{$ipassword}', '{$ifirst_name}', '{$isecond_name}', '{$iemail}', '{$iphone}', '{$ibirthday}')";    
         $this->connect()->exec($sql);
        }
       catch (PDOException $e)
        {
         $e->getMessage();
         echo $e;
        }
       echo "<h4>User {$iloginname} has been added.</h4><br>";
       echo "You can sign in on web site";
    }
//---
    
//UPDATE USER PROFILE
    public function update_user_profile($iid, $iloginname, $ipassword, $ifirst_name, $isecond_name, $iemail, $iphone, $ibirthday)
    {
       try
        {        
         $sql="UPDATE users SET loginname='{$iloginname}', password='{$ipassword}', first_name='{$ifirst_name}', second_name='{$isecond_name}', email='{$iemail}', phone='{$iphone}', birthday='{$ibirthday}' WHERE id={$iid}";    
         $this->connect()->exec($sql);
        }
       catch (PDOException $e)
        {
         $e->getMessage();
         echo $e;
        }
       $id=$this->get_user_id($iloginname);
       echo "<h4>Profile of user {$iloginname} has been changed.</h4>";
        
       // history update
       $this->update_history($id, $iloginname, $ipassword, $ifirst_name, $isecond_name, $iemail, $iphone, $ibirthday);
        
       echo "<a href='index.php?user_id={$id}&act=show_user_profile'>Back to the {$iloginname} profile";
    }
//---
   
//UATHORIZE USER (LOGON)
    public function authorize_user($iloginname, $ipassword)
    {
       $result=$this->connect()->query("SELECT * FROM users WHERE loginname = '{$iloginname}'"); // request for data         
       $result->setFetchMode(PDO::FETCH_OBJ); // selection mode
       // print data from request
       while($fields = $result->fetch()) 
        {
         $user_id = $fields->id;
         $user_loginname = $fields->loginname;
         $user_password = $fields->password;
        }
            
       if ($ipassword === $user_password)
        {// password is OK                                  
         session_start();
         $_SESSION['login_flag']='1';
         $_SESSION['user_id']=$user_id;  
         header("Location: http://".$_SERVER['HTTP_HOST']."/index.php?act=show_user_profile&user_id={$user_id}");
        }
       else 
        {// wrong password                 
         echo "wrong username or password!";
        }                      
    }
//---
    
// LOGOUT USER
    public function user_log_out()
    {
       session_start();
       $_SESSION['login_flag']='0';                       
       header("Location: http://".$_SERVER['HTTP_HOST']."/index.php");
    }
//---

// UPLOAD USER FILE
    public function upload_user_file()
    {
       $uploaddir = 'userfiles/';
       $uploadfile = $uploaddir.date('YmdHis').rand(10,100).$_FILES['uploadfile']['name'];
       if ($_FILES['uploadfile']['size']>1048576) 
        {
         echo "Size of file more than 1Mb<br><br>";
         echo "<a href='index.php?act=show_user_profile'>Back to my profile page</a>";
         exit;
        }
       else 
        {
         if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $uploadfile))
          {
           session_start();
           $this->insert_file_record($_SESSION['user_id'], $uploadfile);
           echo "<h4>File has been uploaded</h4>";
           echo "<a href='index.php?act=show_user_profile'>back to my profile page</a>";
          }
         else
          { 
           echo "<h4>Uploading error!</h4>";
           echo $_FILES['uploadfile']['error'];   
           echo "<a href='index.php?act=show_user_profile'>back to my profile page</a>";
           exit; 
          }
        } 
    }
//---
      
// INSERT INFORMATION ABOUT FILE
    public function insert_file_record($iuser_id, $ifilename)
    {
     try
      {        
       $sql="INSERT INTO files (user_id, filename, onsite) VALUES ('{$iuser_id}', '{$ifilename}', 1)";    
       $this->connect()->exec($sql);
      }
     catch (PDOException $e)
      {
       $e->getMessage();
       echo $e;
      } 
    }
//---
       
// DELETE FILE AND CHANGE STATUS OF FILE
    public function delete_user_file($fileid,$ifilename)
    {
     try
      {        
       $sql="UPDATE files SET onsite=0 WHERE id={$fileid}";    
       $this->connect()->exec($sql);
      }
     catch (PDOException $e)
      {
       $e->getMessage();
       echo $e;
      }
     unlink($ifilename); //deleting file  
        
     echo "<h4>File was deleted</h4><br><br>";
     echo "<a href='index.php?act=show_user_profile'>Back to my profile page</a>";
    }
//---
       
// SHOW LIST OF USER FILES
    public function show_user_files($iuser_id)
    {
     $result=$this->connect()->query("SELECT * FROM files WHERE user_id = '{$iuser_id}'"); // request for data         
     $result->setFetchMode(PDO::FETCH_OBJ); // selection mode
     // print data from request
     $i =  1;
     while($fields = $result->fetch()) 
      {
       $fileid = $fields->id;
       echo $i.'. ';
       $filename = $fields->filename;
       echo "<a href='{$filename}'>{$filename}</a>";
       $onsite = $fields->onsite;
       echo "&nbsp;&nbsp;&nbsp;";
       if ($onsite == 1) {echo "<a href='index.php?act=delete_user_file&fileid={$fileid}&filename={$filename}'>delete file</a>";} else { echo "file was deleted  <a href='index.php?act=delete_user_file_record&fileid={$fileid}'>delete record from database</a>";}
       echo "<br>";
       $i++;
       }
      $i= 1;                            
    }
//---
       
// DELETE USER FILE RECORD FROM DATABASE
    public function delete_user_file_record($ifile_id)
    {
     $sql = "DELETE FROM files WHERE id = {$ifile_id}"; // request for data         
     $this->connect()->exec($sql);
        
     echo "<h4>Record was deleted from database</h4><br><br>";
     echo "<a href='index.php?act=show_user_profile'>Back to my profile page</a>";
     // print data from request            
    }
//--- 
       
//ADD RECORD TO HISTORY TABLE
    public function update_history($iuser_id,$iloginname, $ipassword, $ifirst_name, $isecond_name, $iemail, $iphone, $ibirthday)
    {
     //$post_date = date('YmdHis');
     $post_date = date('d-m-Y');
     try
      {        
       $sql="INSERT INTO history (user_id, loginname, password, first_name, second_name, email, phone, birthday, change_date) VALUES ({$iuser_id},'{$iloginname}', '{$ipassword}', '{$ifirst_name}', '{$isecond_name}', '{$iemail}', '{$iphone}', '{$ibirthday}', '{$post_date}')";    
       $this->connect()->exec($sql);
      }
     catch (PDOException $e)
      {
       $e->getMessage();
       echo $e;
      }
     echo "<h4>Profile history was updated</h4>";
     }       
//---
       
//SHOW HISTORY OF CHANGES
    public function show_user_profile_history($iuser_id)
     {
      $result=$this->connect()->query("SELECT * FROM history WHERE user_id = '{$iuser_id}'"); // request for data         
      $result->setFetchMode(PDO::FETCH_OBJ); // selection mode
      
      // print data from request
      echo "<table border=1>";
      echo "<tr><td>Id</td><td>User ID</td><td>Loginname</td><td>Password</td><td>First name</td><td>Second name</td><td>E-Mail</td><td>Phone</td><td>Birthday</td><td>Change date</td></tr>";
      while($fields = $result->fetch()) 
       { 
        echo "<tr>";
        echo "<td>"; echo $fields->id; echo "</td>";
        echo "<td>"; echo $fields->user_id; echo "</td>";
        echo "<td>"; echo $fields->loginname; echo "</td>";
        echo "<td>"; echo $fields->password; echo "</td>";
        echo "<td>"; echo $fields->first_name; echo "</td>";
        echo "<td>"; echo $fields->second_name; echo "</td>";
        echo "<td>"; echo $fields->email; echo "</td>";
        echo "<td>"; echo $fields->phone; echo "</td>";
        echo "<td>"; echo $fields->birthday; echo "</td>";
        echo "<td>"; echo $fields->change_date; echo "</td>";
        echo "</tr>";
       } 
      echo "</table>";
      echo "<br>";
      echo "<a href='index.php?user_id={$iuser_id}&act=show_user_profile'>Back to profile";
    }
//---    
}
