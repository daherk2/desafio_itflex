<html><head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
        <script type="text/javascript" src="http://netdna.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
        <link href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="http://pingendo.github.io/pingendo-bootstrap/themes/default/bootstrap.css" rel="stylesheet" type="text/css">
    </head><body>

<div class="navbar navbar-default navbar-static-top">
    <div class="container">
        
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-ex-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="https://www.itflex.com.br/">
                <span class="col-sm-3 hidden-xs">
                    <img src="logo.jpg"/>
                </span>
            </a>
        </div>
        
        <div class="collapse navbar-collapse" id="navbar-ex-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li class="active">
                    <a href="index.php">Cadastrar Tarefa</a>
                </li>
                <li>
                    <a href="tasks.php">Visualizar Tarefas</a>        
                </li>    
                
                <li >
                    <a href="https://github.com/itflex/vaga_dev_fullstack">Visualizar Vaga</a>
                </li>
                
                <li>
                    <a href="https://github.com/daherk2">Fábio GitHub</a>
                </li>
            
            </ul>
        </div>
    </div>
</div>
    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                   <br/>
		    <p></p>
                    <br/>
                    <h1 class="text-center">Task Manager</h1>
                    <br/>
                    <p></p>
		    <br/>
                    </div>
            </div>

            <form role="form" action="<?php $_PHP_SELF ?>" method="post">
            
            <div class="row">
            <div class="col-md-offset-4 col-md-7">
                <!--<form role="form"> --> 
                    <div class="form-group">
                        <div class="input-group"> 
                            <input name = "entrada" id="entrada" style="width: 350px;" type="text" class="form-control" placeholder="Entre com a Tarefa"> 
                            <br/>
                            <p></p>
                            <br/>
                            </div>
                    </div>
               <!-- </form> -->
                </div>
            </div>
            
            <div class="row">
            <div class="col-md-offset-7 col-md-4">
            <!--    <form role="form"> --> 
                    <div class="form-group">
                        <div class="input-group"> 
                            <span class="input-group-btn">
                                <button name="submit" class="btn btn-success" type="submit" style="border: #327CBB ; background-color: #327CBB;"  >Salvar</button> 
                            </span>
                        </div>
                    </div>
            <!--    </form>   --> 
                </div>
            </div>
            
            </form>

        </div>
    </div>


    <?php

        if(isset($_POST['submit'])){
            $data = array("task" => $_POST["entrada"], "done" => "false");
            //echo "<script> alert('".$_POST["entrada"]."'); </script>";
            $data_string = json_encode($data);
            $ch = curl_init('http://localhost:5000/task/');                                                                   
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                   
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                               
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data_string))                                                                       
            );                                                                                        
                                                                                                                     
            $result = curl_exec($ch);
           echo "<script> alert('Tarefa salva com sucesso'); </script>";
        }
    ?>


    <script>
    
        function alerta(){
            var msgm = document.getElementById("entrada");
            alert("Salvo com sucesso! \nTarefa : "+msgm.value+"\nStatus : À FAZER");
        }
    
    </script>
    
    
    <footer class="section section-primary"> 
        <div class="container"> 
            <div class="row"> 
                <div class="col-sm-6"> 
                    <h1>Obrigado po utilizar o gerenciador de Tarefas.</h1>
                    <p>Este projeto foi desenvolvido para a prova de seleção da itflex.</p>
                </div>
                <div class="col-sm-6"> 
                    <p class="text-info text-right">
                        <br><br></p>
                    <div class="row"> 
                        <div class="col-md-12 hidden-lg hidden-md hidden-sm text-left">
                            <a href="https://daherk2.github.io"><i class="fa fa-3x fa-fw fa-github text-inverse"></i></a> 
                        </div>
                    </div>
                    <div class="row"> 
                        <div class="col-md-12 hidden-xs text-right">
                            <a href="https://daherk2.github.io"><i class="fa fa-3x fa-fw fa-github text-inverse"></i></a> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    </body>
</html>