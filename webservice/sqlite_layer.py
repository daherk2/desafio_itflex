# -*- coding: utf-8 -*-
"""
Created on Fri Mar 11 16:13:48 2016

@author: fabio
"""

import sqlite3

class Db_layer(object):
    
    caminho = None
    conn = None        
    c = None    
    
    
    def __init__(self):
        self.caminho = 'tasklist.db'
        self.conn = sqlite3.connect(self.caminho)
        self.c = self.conn.cursor()
              
        
    def lista_tarefa(self, query):
        self.c.execute(query)
        var = []        
        for linha in self.c:
            var.append(linha)
        return var
    
    def fechar(self):
        self.c.close()
        
    def salvar(self, dic):
        var = -1
        if(str(dic['done']) == 'false'):
            var = 0
        else:
            var = 1
        query = "insert into task (task, done) VALUES ('"+str(dic['task'])+"', "+str(var)+");"
        #print query
        self.c.execute(query)
        self.conn.commit()
        
    def alterar(self, index ,var, atr):
        query = ''            
        if atr == 'task':
            query = "update task set task ='"+str(var)+"' where id ="+str(index)+";" 
        if atr == 'done':
            n = -1                
            if var == 'false':
                n = 0
            if var == 'true':
                n = 1
            query = "update task set done ="+str(n)+" where id = "+str(index)+";"
            self.c.execute(query)
            self.conn.commit()
            
    def apagar(self, query):
        self.c.execute(query)
        self.conn.commit()        
            

'''        
var = Db_layer()
query1 = "select * from task where id = "+str(1)+";"
query2 = "select * from task ORDER BY id DESC;"

print var.lista_tarefa(query1)
print var.lista_tarefa(query2)
var.fecha()
'''


        
                
        
