<?php

try
{
  $dns = 'mysql:host=localhost;dbname=Movies';
  $user = 'wescoeur';
  $password = null;
  $dtb = new PDO($dns, $user, $password);
}
catch(Exception $e)
{
  echo "MySQL error: ", $e->getMessage();
  die();
}
