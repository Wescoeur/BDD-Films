<?php

/* ---------------------------------------------------------------------- */
/* Filename: controller/search_by_director.php                            */
/* Author: ABHAMON Ronan                                                  */
/* Date: 2014-01-22 - 16:14:20                                            */
/* Site: https://github.com/Wescoeur                                      */
/*                                                                        */
/* ---------------------------------------------------------------------- */

/* Model */
include_once("model/movie_search_by_director.php");
include_once("model/movie.php");

/* Controller */
$movies_limit = 30;

if(isset($_GET['page']) && preg_match('#^[0-9]+#', $_GET['page']))
  $page = $_GET['page'];
else
  $page = 0;

if(isset($_GET['id']) && preg_match('#^[0-9]+#', $_GET['id']))
  $id = $_GET['id'];
else
  $id = 0;

$search = $_GET['search'];
$name = get_the_director_of_this_id($id);
$movies_id = get_movies_by_director_l_list($id, $page * $movies_limit, $movies_limit);
$movies_count = get_movies_by_director_l_list_count($id);
$movies = [];

foreach($movies_id as $mkey => $movie_id)
{
  $movies[$mkey] = get_movie_full($movie_id);
  $movie = $movies[$mkey];

  include("controller/abstract/abstract_movie.php");

  $movies[$mkey] = $movie;
}

/* View */
include_once("view/search_by_person.php");
