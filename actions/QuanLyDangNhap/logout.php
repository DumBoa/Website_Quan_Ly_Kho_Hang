<?php
session_start();
session_destroy();

header("Location: /Project_QuanLyKhoHang/public/login.php");
exit;