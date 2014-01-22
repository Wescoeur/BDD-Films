<?php

/* ---------------------------------------------------------------------- */
/* Filename: controller/random.php                                        */
/* Author: ABHAMON Ronan                                                  */
/* Date: 2014-01-22 - 16:15:54                                            */
/* Site: https://github.com/Wescoeur                                      */
/*                                                                        */
/* ---------------------------------------------------------------------- */

/* Model */
include_once('model/movie.php');

$movie = get_random_movie_full();

/* Controller */
include_once('controller/abstract/abstract_movie.php');

/* View */
if($movie)
  include_once('view/movie.php');
else
  include_once('view/movie_error.php');
