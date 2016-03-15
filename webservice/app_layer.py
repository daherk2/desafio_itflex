"""
Created on Fri Mar 11 18:32:53 2016

@author: fabio
"""

from flask import Flask, jsonify
from flask import request

import sqlite_layer
import dic_layer

app = Flask(__name__)

'''seleciona todas as tarefas'''
@app.route('/task/', methods=['GET'])
def lista_tasks():
    sqlite = sqlite_layer.Db_layer()
    dic = dic_layer.Dic_layer()
    query = "select * from task ;"
    #query2 = "select * from task ORDER BY id DESC;"
    var = sqlite.lista_tarefa(query)
    sqlite.fechar()
    return jsonify({'task': dic.parser(var)})
    
'''seleciona unica tarefa'''
@app.route('/task/<int:task_id>', methods=['GET'])
def lista_task(task_id):
    sqlite = sqlite_layer.Db_layer()
    dic = dic_layer.Dic_layer()
    query = "select * from task where id = "+str(task_id)+";"
    var = sqlite.lista_tarefa(query)
    sqlite.fechar()
    return jsonify({'task': dic.parser(var)})

'''insere tarefa'''
@app.route('/task/', methods=['POST'])
def insere_task():
    if not request.json or not 'task' in request.json:
        request.abort(400)
    task = {
    'task': request.json['task'],
    'done': request.json['done']
    }
    sqlite = sqlite_layer.Db_layer()
    sqlite.salvar(task)
    sqlite.fechar()
    return jsonify({'task': task}), 201
    
'''atualiza tarefa'''
@app.route('/task/<int:task_id>', methods=['PUT'])
def atualiza_task(task_id):
    sqlite = sqlite_layer.Db_layer()  
    if not request.json:
        request.abort(400)
    else :
        sqlite.alterar(task_id, request.json['done'],'done')
        sqlite.fechar()
    return jsonify({'task': request.json}), 201
    
'''apaga tarefa'''
@app.route('/task/<int:task_id>', methods=['DELETE'])
def apaga_task(task_id):
    sqlite = sqlite_layer.Db_layer()
    query = "DELETE from task where id = "+str(task_id)    
    sqlite.apagar(query)
    sqlite.fechar()
    return jsonify({'result': True})
    

if __name__ == '__main__':
    app.run(host='localhost')
    app.run(debug=True)