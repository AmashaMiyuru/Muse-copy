<?php
session_start();
session_unset();
session_destroy();

//go back to front page
header("location: ../php/index.php?error=none");