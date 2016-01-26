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
# along with this program.  If not, see <http://www.gnu.org/licenses/>.   #
#                                                                         #
# ----------------------------------------------------------------------- #

require 'open-uri'
require 'cgi'

class AllocineMovie
  attr_reader :id, :title, :image, :date, :duration, :director, :actors, :themes, :countries, :story

  def initialize(id = 0)
    set_id(id)
  end

  # Affichage d'un film
  def to_s
    "Film: #{@id} - '#{@title}' directed by #{@director.join(', ')} in #{@date} with #{@actors.join(', ')}\nDuration: #{@duration}, Countries: #{@countries.join(', ')}\nStory: #{@story}"
  end

  # Echouera sur quelques pages allocine ne contenant pas toutes les infos d'un film
  def set_id(id)
    return nil if id == 0

    begin
      open('http://www.allocine.fr/film/fichefilm_gen_cfilm=' + id.to_s + '.html') do |f|
        @id = id
        @title = CGI.unescapeHTML(f.parse(/1>(.*?)</)[0][0])
        @image = f.parse(/src='(.*?)'/)[0][0]

        if not (@date = f.parse(/strong.*?>(.*?)<\//)[0]) or @date[0] == "Plus de détail"
          f.seek 0
          @date = "NULL"
        else
          @date = @date[0].gsub(/.*>/, '')
        end

        if not (@duration = f.parse(/duration.*?>(.*?)</)[0])
          f.seek 0 # A optimiser (un jour...)
          @duration = "NULL"
        else
          @duration = @duration[0]
        end

        @director = f.parse(/<a.*?title="(.*?)".*?>/).flatten
        @actors = f.parse(/<a.*?title="(.*?)".*?>/).flatten

        @themes = []
        f.parse(/_a/)
        until /div/ =~ (l = f.gets)
          res = l.scan(/">(.*?)</)
          @themes << res[0][0] if res[0]
        end

        # Pays
        @countries = []
        f.parse(/_a/)
        until /div/ =~ (l = f.gets)
          res = l.scan(/(.*?)</)
          @countries << res[0][0].capitalize if res[0][0] != ", "
        end

        # Résumé
        @story = CGI.unescapeHTML(f.read.scan(/description".*?>(.*?)<\/p/m)[0][0].gsub(%r{</?[^>]+?>}, ''))
      end
    rescue
      # puts "Error : This film does not exist !"
      @id = 0
    end
  end

  def self.search(movie_name)
    name = CGI.escape(movie_name)
    adress = 'http://www.allocine.fr/recherche/1/?q='
    f = open(adress + name)
    res = []

    if not (n = f.parse(/(.*?)résultat/)).empty?
      max_results = n = n[0][0].to_i
      current_page = 1
      res = []
      regex = /fichefilm_gen_cfilm=(.*?).html/

      while (n -= 1) >= 0
        f.parse(regex) # Lien de l'image à ne pas prendre
        res << f.parse(regex)[0][0].to_i

        if max_results % 20 == n % 20
          current_page += 1
          f = open(adress + name + "&p=#{current_page}")
        end
      end
    end
    res
  end
end
