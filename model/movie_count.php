<?php

# ---------------------------------------------------------------------- #
# Filename: model/movie_count.php                                        #
# Author: ABHAMON Ronan                                                  #
# Date: 2014-01-22 - 14:00:33                                            #
# Site: https://github.com/Wescoeur                                      #
#                                                                        #
# ---------------------------------------------------------------------- #

/* -------------------------------------------------------------------- */
/* Récupération du nombre de films TOTAL dans la base                   */
/* -------------------------------------------------------------------- */

/* Retourne le nombre de films dans la base de données */
function get_movies_number()
{
  global $dtb;
  $sth = $dtb->prepare("SELECT COUNT(*) FROM Movie");
  $sth->execute();
  return $sth->fetch()[0];
}
