# ---------------------------------------------------------------------- #
# Filename: INC/Tempfile.rb                                              #
# Author: ABHAMON Ronan                                                  #
# Date: 2014-01-21 - 21:52:28                                            #
# Site: https://github.com/Wescoeur                                      #
#                                                                        #
# ---------------------------------------------------------------------- #

#!/usr/bin/ruby
# -*- coding: utf-8 -*-
# ABHAMON Ronan

require 'tempfile'

class Tempfile
  def parse(regex)
    res = []
    while l = self.gets and res.empty? 
      res = l.scan(regex)
    end
    res
  end
end
