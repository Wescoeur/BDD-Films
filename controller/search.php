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
include_once("model/movie_search.php");
include_once("model/movie.php");

/* Controller */
$themes = get_movies_themes_list();
$countries = get_movies_countries_list();
$decades = get_movies_decades_list();
$select = array('decade' => 0, 'country' => 0, 'theme' => 0, 'letter' => 0);
$movies_limit = 30;

foreach($themes as $key => $value)
  $themes[$key]['Name'] = htmlspecialchars($value['Name']);

foreach($countries as $key => $value)
  $countries[$key]['Name'] = htmlspecialchars($value['Name']);

foreach($select as $key => $select_type)
  if(isset($_GET[$key]) && preg_match('#^[0-9]+#', $_GET[$key]))
  {
    /* Décennies */
    if($key == 'decade')
    {
      foreach($decades as $decade)
	if($decade['Year'] == $_GET['decade'])
	  $select['decade'] = $decade['Year'];
    }

    /* Pays */
    else if($key == 'country')
    {
      foreach($countries as $country)
	if($country['Id'] == $_GET['country'])
	  $select['country'] = $country['Id'];
    }

    /* Thèmes */
    else if($key == 'theme')
    {
      foreach($themes as $theme)
      {
	if($theme['Id'] == $_GET['theme'])
	  $select['theme'] = $theme['Id'];
      }
    }

    /* Lettres */
    else if($_GET['letter'] > 0 && $_GET['letter'] <= 27)
      $select['letter'] = $_GET['letter'];
  }

if(isset($_GET['page']) && preg_match('#^[0-9]+#', $_GET['page']))
  $page = $_GET['page'];
else
  $page = 0;

$movies_id = get_movies_l_list($select['decade'], $select['country'], $select['theme'], $select['letter'],
			       $page * $movies_limit, $movies_limit);
$movies_count = get_movies_l_list_count($select['decade'], $select['country'], $select['theme'], $select['letter']);
$movies = [];

foreach($movies_id as $mkey => $movie_id)
{
  $movies[$mkey] = get_movie_full($movie_id);
  $movie = $movies[$mkey];

  include("controller/abstract/abstract_movie.php");

  $movies[$mkey] = $movie;
}

/* View */
include_once("view/search.php");
