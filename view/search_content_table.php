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

foreach($movies as $movie)
{
  echo "<tr>\n<td rowspan=\"2\">";
  echo '<a href="movie_' . $movie['Id'] . '.html"><img class="movie_img" src="resources/movie/' . $movie['Id'] .
    ".jpg\" alt=\"Pauvre image...\" /></a></td>\n";
  echo "<td>\n" . '<a href="movie_' . $movie['Id'] . '.html">' . $movie['Title'] . "</a>\n<br />\nde ";

  foreach($movie['Directors'] as $key => $director)
  {
    echo '<a href="search_by_director-' . $director['Id'] . '.html">' . $director['Name'] . '</a>';

    if($key + 1 != count($movie['Directors']))
      echo ', ';
  }

  echo ' avec ';

  foreach($movie['Actors'] as $key => $actor)
  {
    echo '<a href="search_by_actor-' . $actor['Id'] . '.html">' . $actor['Name'] . '</a>';

     if($key + 1 != count($movie['Actors']))
      echo ', ';
  }

  echo "<br />\nSorti le " . $movie['Date'] . ' et d\'une durée de ' . $movie['Duration'];

  echo "</td>\n</tr>\n<tr>\n<td>";
  echo substr($movie['Story'], 0, 300) . '...';
  echo "</td>\n</tr>\n";
}

echo "<tr>\n<th></th>\n<th>\n";
