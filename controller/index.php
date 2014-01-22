<?php

/* ---------------------------------------------------------------------- */
/* Filename: controller/index.php                                         */
/* Author: ABHAMON Ronan                                                  */
/* Date: 2014-01-22 - 16:16:21                                            */
/* Site: https://github.com/Wescoeur                                      */
/*                                                                        */
/* ---------------------------------------------------------------------- */

/* Model */
include_once("model/movie_list.php");
include_once("model/movie_count.php");

$movies = get_movies_list(20);
$themes = get_movies_themes_list();
$countries = get_movies_countries_list();
$decades = get_movies_decades_list();
$movie_count = get_movies_number();

/* Params */
$w_table = 10;  /* Nombre de films par ligne dans la table */
$h_theme = 12;  /* Nombre de thèmes max par colonne */
$h_decade = 4;  /* Nombre d'époques max par colonne */
$v_letter = 14; /* Nombre de lettres par ligne */
$h_country = 7; /* Nombre de thèmes max par colonne */

/* Controller */
foreach($movies as $key => $value)
  $movies[$key]['Title'] = htmlspecialchars($value['Title']);

foreach($themes as $key => $value)
  $themes[$key]['Name'] = htmlspecialchars($value['Name']);

foreach($countries as $key => $value)
  $countries[$key]['Name'] = htmlspecialchars($value['Name']);

/* View */
include_once("view/index.php");
