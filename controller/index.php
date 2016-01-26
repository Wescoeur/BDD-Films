<?php

# ----------------------------------------------------------------------- #
# Copyright (C) 2014-2016 ABHAMON Ronan                                   #
#                                                                         #
# This program is free software: you can redistribute it and/or modify    #
# it under the terms of the GNU General Public License as published by    #
# the Free Software Foundation, either version 3 of the License, or       #
# (at your option) any later version.                                     #
#                                                                         #
# This program is distributed in the hope that it will be useful,         #
# but WITHOUT ANY WARRANTY; without even the implied warranty of          #
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the           #
# GNU General Public License for more details.                            #
#                                                                         #
# You should have received a copy of the GNU General Public License       #
# along with this program.  If not, see <http://www.gnu.org/licenses/>. 1 #
#                                                                         #
# ----------------------------------------------------------------------- #

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
