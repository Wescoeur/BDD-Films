<?php

# ---------------------------------------------------------------------- #
# Filename: model/movie_search_by_director.php                           #
# Author: ABHAMON Ronan                                                  #
# Date: 2014-01-22 - 14:00:33                                            #
# Site: https://github.com/Wescoeur                                      #
#                                                                        #
# ---------------------------------------------------------------------- #

/* -------------------------------------------------------------------- */
/* Récupérations des infos sur des films d'un réalisateur:              */
/* - Seulement les IDs                                                  */
/* - Le nombre de films réalisés                                        */
/* Permet aussi la récupération du nom correspondant à un ID            */
/* -------------------------------------------------------------------- */

/* Retourne une liste d'ids de films tournés par un certain réalisateur */
function get_movies_by_director_l_list($id, $start, $limit)
{
  global $dtb;

  $id = (int)$id;
  $start = (int)$start;
  $limit = (int)$limit;

  $sth = $dtb->prepare("SELECT Movie.Id FROM Movie, Director, Directed_by
                        WHERE Movie.Id = Directed_by.Id_movie
                        AND Directed_by.Id_director = Director.Id AND Director.Id = :id
                        ORDER BY Title ASC LIMIT :start, :limit");

  $sth->bindParam(':id', $id, PDO::PARAM_INT);
  $sth->bindParam(':start', $start, PDO::PARAM_INT);
  $sth->bindParam(':limit', $limit, PDO::PARAM_INT);

  $sth->execute();
  return $sth->fetchAll(PDO::FETCH_COLUMN, 0);
}

/* Retourne le nombre de films tournés par un réalisateur d'un certain id */
function get_movies_by_director_l_list_count($id)
{
  global $dtb;
  $sth = $dtb->prepare("SELECT COUNT(*) FROM Director, Directed_by
                        WHERE Director.Id = Directed_by.Id_director AND Id_director = ?");
  $sth->execute(array($id));
  return $sth->fetch()[0];
}

/* Retourne le nom d'un réalisateur d'un certain id */
function get_the_director_of_this_id($id)
{
  global $dtb;
  $sth = $dtb->prepare("SELECT Name FROM Director WHERE Director.Id = ?");
  $sth->execute(array($id));
  return $sth->fetch()[0];
}
