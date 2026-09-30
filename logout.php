<?php
require __DIR__.'/config.php';Auth::logout();header('Location: login.php');exit;
