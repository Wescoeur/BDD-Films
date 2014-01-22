<?php

# ---------------------------------------------------------------------- #
# Filename: model/movie_list_directors.php                               #
# Author: ABHAMON Ronan                                                  #
# Date: 2014-01-22 - 14:00:33                                            #
# Site: https://github.com/Wescoeur                                      #
#                                                                        #
# ---------------------------------------------------------------------- #

/* -------------------------------------------------------------------- */
/* Contient diverses fonctions permettant la récupération de listes     */
/* relatives aux réalisateurs :                                         */
/* - Le nombre d'réalisateurs (et/ou en fonction d'une lettre)          */
/* - Une liste de tous les réalisateurs d'un certain index à un certain */
/*   nombre (et/ou en fonction d'une lettre)                            */
/* -------------------------------------------------------------------- */

/* Retourne le nombre de réalisateurs dans la base */
function get_directors_number()
{
  global $dtb;
  $sth = $dtb->prepare("SELECT COUNT(*) FROM Director");
  $sth->execute();
  return $sth->fetch()[0];
}

/* Retourne le nombre de réalisateurs dans la base dont le nom commence par $letter */
function get_directors_l_number($letter)
{
  global $dtb;
  $sth = $dtb->prepare("SELECT COUNT(*) FROM Director WHERE Name LIKE ?");
  $sth->execute(array(ucfirst($letter) . '%'));
  return $sth->fetch()[0];
}

/* Retourne la totalité des acteurs de la base */
function get_directors_list($start, $limit)
{
  global $dtb;
  $sth = $dtb->prepare("SELECT Id, Name FROM Director ORDER BY Name ASC LIMIT :start, :limit");
  $sth->bindParam(':start', $start, PDO::PARAM_INT);
  $sth->bindParam(':limit', $limit, PDO::PARAM_INT);
  $sth->execute();
  return $sth->fetchAll(PDO::FETCH_ASSOC);
}

/* Retourne la liste des acteurs dont le nom commence par $letter */
function get_directors_l_list($letter, $start, $limit)
{
  global $dtb;
  $letter = ucfirst($letter) . '%';
  $sth = $dtb->prepare("SELECT Id, Name FROM Director WHERE Name LIKE :letter
                        ORDER BY Name ASC LIMIT :start, :limit");
  $sth->bindParam(':letter', $letter, PDO::PARAM_STR);
  $sth->bindParam(':start', $start, PDO::PARAM_INT);
  $sth->bindParam(':limit', $limit, PDO::PARAM_INT);
  $sth->execute();
  return $sth->fetchAll(PDO::FETCH_ASSOC);
}
