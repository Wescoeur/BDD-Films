<?php

# ---------------------------------------------------------------------- #
# Filename: model/movie_search_by_actor.php                              #
# Author: ABHAMON Ronan                                                  #
# Date: 2014-01-22 - 14:00:33                                            #
# Site: https://github.com/Wescoeur                                      #
#                                                                        #
# ---------------------------------------------------------------------- #

/* -------------------------------------------------------------------- */
/* Récupérations des infos sur des films d'un acteur     :              */
/* - Seulement les IDs                                                  */
/* - Le nombre de films dans lesquels il a joué                         */
/* Permet aussi la récupération du nom correspondant à un ID            */
/* -------------------------------------------------------------------- */

/* Retourne une liste d'ids de films dans lesquels un acteur d'un certain id a joué */
function get_movies_by_actor_l_list($id, $start, $limit)
{
  global $dtb;

  $id = (int)$id;
  $start = (int)$start;
  $limit = (int)$limit;

  $sth = $dtb->prepare("SELECT Movie.Id FROM Movie, Actor, Starred_in
                        WHERE Movie.Id = Starred_in.Id_movie
                        AND Starred_in.Id_actor = Actor.Id AND Actor.Id = :id
                        ORDER BY Title ASC LIMIT :start, :limit");

  $sth->bindParam(':id', $id, PDO::PARAM_INT);
  $sth->bindParam(':start', $start, PDO::PARAM_INT);
  $sth->bindParam(':limit', $limit, PDO::PARAM_INT);

  $sth->execute();
  return $sth->fetchAll(PDO::FETCH_COLUMN, 0);
}

/* Retourne le nombre de films dans lequel joue un acteur d'un certain id */
function get_movies_by_actor_l_list_count($id)
{
  global $dtb;
  $sth = $dtb->prepare("SELECT COUNT(*) FROM Actor, Starred_in
                        WHERE Actor.Id = Starred_in.Id_actor AND Id_actor = ?");
  $sth->execute(array($id));
  return $sth->fetch()[0];
}

/* Retourne le nom d'un acteur d'un certain id */
function get_the_actor_of_this_id($id)
{
  global $dtb;
  $sth = $dtb->prepare("SELECT Name FROM Actor WHERE Actor.Id = ?");
  $sth->execute(array($id));
  return $sth->fetch()[0];
}
