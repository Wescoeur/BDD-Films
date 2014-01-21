<?php

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
