<?php
require 'config.php';
require_once 'functions.php';
session_destroy();
header('Location: index.php');
