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
