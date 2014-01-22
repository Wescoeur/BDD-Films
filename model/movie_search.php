<?php

# ---------------------------------------------------------------------- #
# Filename: model/movie_search.php                                       #
# Author: ABHAMON Ronan                                                  #
# Date: 2014-01-22 - 14:00:33                                            #
# Site: https://github.com/Wescoeur                                      #
#                                                                        #
# ---------------------------------------------------------------------- #

/* -------------------------------------------------------------------- */
/* Permet de récupérer une liste d'IDs de films relatifs à un thème,    */
/* pays, décennie ou lettre. Ou permet de calculer le nombre de films   */
/* liés à ces mêmes paramètres.                                         */
/* -------------------------------------------------------------------- */

/* Retourne une liste d'ID de films plus ou moins complète ou le nombre de films correspondant */
function get_abstract_movies_l_list($decade, $country, $theme, $letter, $start, $limit, $count)
{
  global $dtb;

  $decade  = (int)$decade;
  $country = (int)$country;
  $theme   = (int)$theme;
  $letter  = (int)$letter;
  $start   = (int)$start;
  $limit   = (int)$limit;
  $count   = (bool)$count;

  if($count) $query = "SELECT COUNT(*) FROM Movie";
  else $query = "SELECT Movie.Id FROM Movie";

  if($country) $query .=", Country, Made_in";
  if($theme)   $query .= ", Theme, Is_a";

  if($decade)
  {
    $query .= " WHERE Date REGEXP :decade ";
    $decade = $decade / 10 . '[0-9]';
  }
  else $query .= " WHERE 1 ";

  if($country) $query .= "AND Country.Id = Id_country AND Made_in.Id_movie = Movie.Id AND Id_country = :country ";
  if($theme)   $query .= "AND Theme.Id = Id_theme AND Is_a.Id_movie = Movie.Id AND Id_theme = :theme ";

  if($letter)
  {
    if($letter > 1)
    {
      $letter = chr($letter - 2 + ord('A')) . '%';
      $query .= "AND Title LIKE :letter ";
    }
    else
    {
      $letter = "^[0-9]";
      $query .= "AND Title REGEXP :letter ";
    }
  }

  if(!$count) $query .= "ORDER BY Title ASC LIMIT :start, :limit";

  $sth = $dtb->prepare($query);

  if($country) $sth->bindParam(':country', $country, PDO::PARAM_STR);
  if($theme)   $sth->bindParam(':theme', $theme, PDO::PARAM_INT);
  if($decade)  $sth->bindParam(':decade', $decade, PDO::PARAM_STR);
  if($letter)  $sth->bindParam(':letter', $letter, PDO::PARAM_STR);

  if(!$count)
  {
    $sth->bindParam(':start', $start, PDO::PARAM_INT);
    $sth->bindParam(':limit', $limit, PDO::PARAM_INT);
  }

  $sth->execute();

  if(!$count)
    return $sth->fetchAll(PDO::FETCH_COLUMN, 0);
  return $sth->fetch()[0];
}

/* Retourne une liste d'ID de films plus ou moins complète  */
function get_movies_l_list($decade, $country, $theme, $letter, $start, $limit)
{
  return get_abstract_movies_l_list($decade, $country, $theme, $letter, $start, $limit, false);
}

/* Retourne le nombre de films correspondant à la recherche */
function get_movies_l_list_count($decade, $country, $theme, $letter)
{
  return get_abstract_movies_l_list($decade, $country, $theme, $letter, 0, 0, true);
}
