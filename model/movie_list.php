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
# along with this program.  If not, see <http://www.gnu.org/licenses/>.   #
#                                                                         #
# ----------------------------------------------------------------------- #

/* -------------------------------------------------------------------- */
/* Contient diverses fonctions permettant la récupération de listes     */
/* relatives aux films/themes/pays/décennies :                          */
/* - Le nombre d'acteurs (et/ou en fonction d'une lettre)               */
/* - Une liste de tous les acteurs d'un certain index à un certain      */
/*   nombre (et/ou en fonction d'une lettre                             */
/* -------------------------------------------------------------------- */

/* Retourne les n derniers films ajoutés */
function get_movies_list($n)
{
  global $dtb;
  $n = (int)$n;
  $sth = $dtb->prepare("SELECT Id, Title FROM Movie ORDER BY Date_add DESC LIMIT :n");
  $sth->bindParam(':n', $n, PDO::PARAM_INT);
  $sth->execute();
  return $sth->fetchAll(PDO::FETCH_ASSOC);
}

/* Retourne une liste de thèmes de films */
function get_movies_themes_list()
{
  global $dtb;
  $sth = $dtb->prepare("SELECT Id, Name FROM Theme ORDER BY Name ASC");
  $sth->execute();
  return $sth->fetchAll(PDO::FETCH_ASSOC);
}

/* Retourne une liste de pays de films */
function get_movies_countries_list()
{
  global $dtb;
  $sth = $dtb->prepare("SELECT Id, Name FROM Country ORDER BY Name ASC");
  $sth->execute();
  return $sth->fetchAll(PDO::FETCH_ASSOC);
}

/* Retourne un tableau contenant les décennies existantes,
   ainsi que le nombre de films présents pour chaque décennie */
function get_movies_decades_list()
{
  global $dtb;
  $current_year = date("Y") / 10 + 1;
  $array = [];
  $i = 0;

  for($year = 190; $year < $current_year; $year++)
  {
    $real_year = $year . "[0-9]";
    $sth = $dtb->prepare("SELECT COUNT(*) FROM Movie WHERE Date REGEXP :regex");
    $sth->bindParam(':regex', $real_year, PDO::PARAM_STR);
    $sth->execute();

    if(($val = $sth->fetch()[0]))
    {
      $array[$i]['Year'] = $year * 10;
      $array[$i]['Count'] = $val;
      $i++;
    }
  }

  return $array;
}
