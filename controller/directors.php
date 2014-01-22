<?php

/* ---------------------------------------------------------------------- */
/* Filename: controller/directors.php                                     */
/* Author: ABHAMON Ronan                                                  */
/* Date: 2014-01-22 - 16:15:03                                            */
/* Site: https://github.com/Wescoeur                                      */
/*                                                                        */
/* ---------------------------------------------------------------------- */

/* Model */
include_once('model/movie_list_directors.php');

/* Controller */
$person_limit = 200;
$person_type = 'director';

include_once('controller/abstract/abstract_person.php');

/* View */
include_once('view/person.php');
