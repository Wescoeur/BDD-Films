<?php

/* Model */
include_once('model/movie.php');

/* Controller */
if(isset($_GET['id']))
{
  $id = (int)$_GET['id'];

  if($movie = get_movie_full($id))
    include_once('controller/abstract/abstract_movie.php');
}

/* View */
if($movie)
  include_once('view/movie.php');
else
  include_once('view/movie_error.php');