<?php

# ---------------------------------------------------------------------- #
# Filename: view/connection.php                                          #
# Author: ABHAMON Ronan                                                  #
# Date: 2014-01-22 - 14:00:37                                            #
# Site: https://github.com/Wescoeur                                      #
#                                                                        #
# ---------------------------------------------------------------------- #

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
