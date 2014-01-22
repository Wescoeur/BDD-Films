<?php

# ---------------------------------------------------------------------- #
# Filename: model/movie_base.php                                         #
# Author: ABHAMON Ronan                                                  #
# Date: 2014-01-22 - 14:00:33                                            #
# Site: https://github.com/Wescoeur                                      #
#                                                                        #
# ---------------------------------------------------------------------- #

/* -------------------------------------------------------------------- */
/* Récupérations des infos basiques de la table movie et rien d'autre ! */
/* -------------------------------------------------------------------- */

/* Retourne un film */
function get_movie_base($id)
{
  global $dtb;
  $sth = $dtb->prepare("SELECT Id, Title, Date, Duration, Story, Extension, Size
                        FROM Movie
                        WHERE Id = ?");
  $sth->execute(array((int)$id));
  return $sth->fetch(PDO::FETCH_ASSOC);
}

/* Retourne un film au hasard */
function get_random_movie_base()
{
  global $dtb;
  $sth = $dtb->prepare("SELECT Id, Title, Date, Duration, Story, Extension, Size
                        FROM Movie
                        ORDER BY RAND() LIMIT 1");
  $sth->execute();
  return $sth->fetch(PDO::FETCH_ASSOC);
}
