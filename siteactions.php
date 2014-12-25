<?php

// show registration form
function show_registration_form()
{
   /*
      var
    * loginname
    * password
    * first_name
    * second_name
    * email
    * phone
    * birthday
   */
   echo "<h3>Registration form:</h3>"; 
   echo "<form method='GET' action='index.php'>";
   echo "<table border='0' class='datatable' align=left valign=top>";
   echo "<tr><td>*Login name:</td> <td><input type='text' name='loginname' required=''/></td></tr>";
   echo "<tr><td>*Password:</td> <td><input type='password' name='password' required=''/></td></tr>";
   echo "<tr><td>*First name:</td> <td><input type='text' name='first_name' required=''/></td></tr>";
   echo "<tr><td>*Second name:</td> <td><input type='text' name='second_name' required=''/></td></tr>";
   echo "<tr><td>E-mail:</td> <td><input type='text' name='email'/></td></tr>";
   echo "<tr><td>Phone:</td> <td><input type='text' name='phone'/></td></tr>";
   echo "<tr><td>BirthDay:</td> <td><input type='text' name='birthday'/></td></tr>";
   echo "<tr><td><input type='hidden' name='siteaction' value='insert_new_user'/></td><td><input type='submit' value='ok'/></td></tr>";
   echo "<tr><td>* required to fill</td><td></td></tr>";
   echo "</table>";
   echo "</form>";
   
}

//show login form
function show_login_form()
{
   echo "<h3>Login form</h3>";
   echo "<form method='GET' action='index.php'>";
   echo "<table border='0' class='datatable' align=left valign=top>";
   echo "<tr><td>Login name:</td> <td><input type='text' name='loginname' required=''/></td></tr>";
   echo "<tr><td>Password:</td> <td><input type='password' name='password' required=''/></td></tr>";
   echo "<tr><td><input type='hidden' name='siteaction' value='authorize_user'/></td><td><input type='submit' value='login'/></td></tr>";
   echo "</table>";
   echo "</form>";
    
}

// show profile
function show_user_profile()
{
   echo "<table border='0' class='datatable' align=left valign=top>";
   echo "<tr><td>*Login name:</td> <td><input type='text' name='loginname' required=''/></td></tr>";
   echo "<tr><td>*Password:</td> <td><input type='password' name='password' required=''/></td></tr>";
   echo "<tr><td>*First name:</td> <td><input type='text' name='first_name' required=''/></td></tr>";
   echo "<tr><td>*Second name:</td> <td><input type='text' name='second_name' required=''/></td></tr>";
   echo "<tr><td>E-mail:</td> <td><input type='text' name='email'/></td></tr>";
   echo "<tr><td>Phone:</td> <td><input type='text' name='phone'/></td></tr>";
   echo "<tr><td>BirthDay:</td> <td><input type='text' name='birthday'/></td></tr>";
   echo "<tr><td><input type='hidden' name='siteaction' value='insert_new_user'/></td><td><input type='submit' value='ok'/></td></tr>";
   echo "<tr><td>* required to fill</td><td></td></tr>";
   echo "</table>";
   echo "</form>";
}

?>
