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

/* -------------------------------------------------------------------- */
/* Contient diverses fonctions permettant la récupération de listes     */
/* relatives aux acteurs :                                              */
/* - Le nombre d'acteurs (et/ou en fonction d'une lettre)               */
/* - Une liste de tous les acteurs d'un certain index à un certain      */
/*   nombre (et/ou en fonction d'une lettre)                            */
/* -------------------------------------------------------------------- */

/* Retourne le nombre d'acteurs dans la base */
function get_actors_number()
{
  global $dtb;
  $sth = $dtb->prepare("SELECT COUNT(*) FROM Actor");
  $sth->execute();
  return $sth->fetch()[0];
}

/* Retourne le nombre d'acteurs dans la base dont le nom commence par $letter */
function get_actors_l_number($letter)
{
  global $dtb;
  $sth = $dtb->prepare("SELECT COUNT(*) FROM Actor WHERE Name LIKE ?");
  $sth->execute(array(ucfirst($letter) . '%'));
  return $sth->fetch()[0];
}

/* Retourne la totalité des acteurs de la base */
function get_actors_list($start, $limit)
{
  global $dtb;
  $sth = $dtb->prepare("SELECT Id, Name FROM Actor ORDER BY Name ASC LIMIT :start, :limit");
  $sth->bindParam(':start', $start, PDO::PARAM_INT);
  $sth->bindParam(':limit', $limit, PDO::PARAM_INT);
  $sth->execute();
  return $sth->fetchAll(PDO::FETCH_ASSOC);
}

/* Retourne la liste des acteurs dont le nom commence par $letter */
function get_actors_l_list($letter, $start, $limit)
{
  global $dtb;
  $letter = ucfirst($letter) . '%';
  $sth = $dtb->prepare("SELECT Id, Name FROM Actor WHERE Name LIKE :letter
                        ORDER BY Name ASC LIMIT :start, :limit");
  $sth->bindParam(':letter', $letter, PDO::PARAM_STR);
  $sth->bindParam(':start', $start, PDO::PARAM_INT);
  $sth->bindParam(':limit', $limit, PDO::PARAM_INT);
  $sth->execute();
  return $sth->fetchAll(PDO::FETCH_ASSOC);
}
