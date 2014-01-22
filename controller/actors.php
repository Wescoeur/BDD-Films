<?php

/* ---------------------------------------------------------------------- */
/* Filename: controller/actors.php                                        */
/* Author: ABHAMON Ronan                                                  */
/* Date: 2014-01-22 - 16:15:00                                            */
/* Site: https://github.com/Wescoeur                                      */
/*                                                                        */
/* ---------------------------------------------------------------------- */

/* Model */
include_once('model/movie_list_actors.php');

/* Controller */
$person_limit = 200;
$person_type = 'actor';

include_once('controller/abstract/abstract_person.php');

/* View */
include_once('view/person.php');
