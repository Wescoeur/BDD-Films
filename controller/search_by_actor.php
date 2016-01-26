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
include_once("model/movie_search_by_actor.php");
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
$name = get_the_actor_of_this_id($id);
$movies_id = get_movies_by_actor_l_list($id, $page * $movies_limit, $movies_limit);
$movies_count = get_movies_by_actor_l_list_count($id);
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
