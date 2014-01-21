<?php

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
