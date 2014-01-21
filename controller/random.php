<?php

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
