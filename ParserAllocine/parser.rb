#!/usr/bin/ruby
# -*- coding: utf-8 -*-

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

# -------------------------------------------------
# ARGUMENTS
# -------------------------------------------------

=begin

update     => Update toute la BDD de films

=end

# -------------------------------------------------
# REQUIRE
# -------------------------------------------------

require 'find'
require './INC/Tempfile.rb'
require './INC/AllocineMovie.rb'
require './INC/Database.rb'

# -------------------------------------------------
# PARAMS
# -------------------------------------------------

# Informations de la BDD mysql
db_hostname = 'localhost'
db_username = 'wescoeur'
db_password = ''
db_database = 'Movies'

# Dossier de films
$movies_folder = '/run/media/wescoeur/Ronan/DOCUMENTS/Films/VF/'

# -------------------------------------------------
# UPDATE
# -------------------------------------------------

def db_update(dtb)
  ext = ['.avi', '.vob', '.mkv', '.mp4', '.mpeg']
  movie = AllocineMovie.new
  Find.find($movies_folder) do |f|
    if File.ftype(f) == 'file' and ext.include? File.extname(f)
      movie_name = File.basename(f, '.*')
      if not dtb.include?(f) # Si le film n'est pas dans la BDD
        results = AllocineMovie.search(movie_name)

        # 1 seul résultat
        if results.size == 1
          puts "Done: #{movie_name}"
          movie.set_id(results[0])
          dtb.add(movie, f)

          # Plusieurs résultats
        elsif results.size > 1
          arr, i = [], 0
          puts "Several results have been found: #{movie_name} (#{results.size})"
          results[0..49].each do |r|
            if not (c_movie = AllocineMovie.new(r)).id.zero?
              puts "\n-------------------------------------------------------------------------------------"
              puts "Choice: #{i.to_s} ID(#{r}) http://www.allocine.fr/film/fichefilm_gen_cfilm=#{r}.html"
              puts "--------------------------------------------------------------------------------------\n"
              puts (arr << c_movie).last
              i += 1
            end
          end

          if arr.empty?
            puts "Unable to find a correct result..."
          else
            print "\nWhat your choice for '#{movie_name}' ? "
            while (choice = $stdin.gets)[0] < '0' or choice[0] > '9' or arr[choice.to_i] == nil do end
            dtb.add(arr[choice.to_i], f)
          end

          # Aucun résultat
        else
          print "No results for '#{movie_name}'. What the movie ID ? (nil for break) "

          if (choice = $stdin.gets.to_i) != 0
            movie = AllocineMovie.new(choice)
            dtb.add(movie, f)
          end
        end
      else
        #puts "Already exist: #{movie_name}"
      end
    end
  end
end

# -------------------------------------------------
# SCRIPT
# -------------------------------------------------

begin
  dtb = Database.new(db_hostname, db_username, db_password, db_database)

  if ARGV[0] == 'update'
    db_update(dtb)
  end
rescue Mysql::Error => e
  # Gestion des erreurs Mysql
  puts "ErrorNum: #{e.errno}"
  puts "Message:  #{e.error}"
  puts "SQLSTATE: #{e.sqlstate}" if e.respond_to?("sqlstate")
rescue => e
  puts e
ensure
  # Fermeture de la base
  dtb.close
end

