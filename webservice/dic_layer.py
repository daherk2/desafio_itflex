# -*- coding: utf-8 -*-
"""
Created on Fri Mar 11 18:32:53 2016

@author: fabio
"""

class Dic_layer(object):
    
    tabela = None
    dic = None
    valores = None
    
    def __init__(self):
        self.dic = {}
        self.valores = []
        self.tabela = ['id','task','done']
        
    def parser(self, var):
        
        for i in range(0,len(var)):
            for j in range(0,3):
                if j == 2:
                    if int(var[i][2]) == 0:
                        #print 'false'
                        self.dic[self.tabela[j]]='false'
                    else:
                        #print 'true'
                        self.dic[self.tabela[j]]='true'
                else:        
                    self.dic[self.tabela[j]]=var[i][j]            
                    #print var[i][j]
            self.valores.append(self.dic.copy())
            self.dic.clear()   
        
        return self.valores