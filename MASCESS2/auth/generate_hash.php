<?php
   // Ganti 'your_password' dengan password yang ingin Anda hash
   $password = 'admin123';
   $hashed_password = password_hash($password, PASSWORD_BCRYPT);
   echo $hashed_password;
   ?>
