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
                <li>
                    <a href="index.php">Cadastrar Tarefa</a>
                </li>
                <li class="active">
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
            
            <div class="row">
            	<div class="col-md-offset-4 col-md-5">
                	
			<table id="mtable" class="table table-striped">
    				<thead>
      					<tr>
						<th data-field="state" data-checkbox="true"></th>
        					<th>Código</th>
        					<th>Tarefa</th>
        					<th>Status</th>
      					</tr>
    				</thead>
				
				<tbody>

				<?php 
				
				$conteudo = file_get_contents('http://localhost:5000/task/');
				$var = json_decode($conteudo, true);
				$tamanho = count($var['task']);
				//echo '<script>alert(\''.$tamanho.'\')</script>';
				//echo var_dump($var);	
				
				for ($i = 0; $i < $tamanho ; $i++) {
    					echo '<tr>';
					echo '<td> <input id = "c' . $i . '" name="box"  type=\'radio\' /> </td>';
					echo '<td>'.  $var['task'][$i]['id'].'</td>';
					echo '<td> '.$var['task'][$i]['task'].'</td>';
					if($var['task'][$i]['done'] == 'false'){
						echo '<td>A fazer</td>';
					}else{
						echo '<td>Feito</td>';
					}
					echo '</tr>';

				}


			
				?>
   								
				</tbody>
  			</table>
			
               	  </div>
            </div>
            
            <div class="row">
            <div class="col-md-offset-5 col-md-6">
                
                    <div class="form-group" >
                        <div class="input-group"> 
                            <span class="input-group-btn">
                                <form action="<?php $_PHP_SELF ?>" method="POST">
                                 <input  type="hidden" id="transfer" name="transfer"> </input>
                                <button value = 'atualizar' name="action" type="submit" id="atualizar" class="btn btn-success" style="margin: 10px;border: #327CBB ; background-color: #327CBB;" onclick="check()"  >Atualizar Status</button> 
				                                               
				<button value= 'remover' name="action" type="submit" id="remover" class="btn btn-success" style="margin: 10px;border: #327CBB ; background-color: #327CBB;" onclick="check()" >Apagar</button> 
                                </form>
                            </span>
                        </div>
                    </div>
               
                </div>
            </div>
            
            
        </div>
    </div>
    
    <?php

        if ($_POST['action'] == 'atualizar') {
            
            $selecionado = $_POST['transfer'];
            $valor_id = '';
            $valor_task = '';
            $valor_done = ''; 

            $conteudo = file_get_contents('http://localhost:5000/task/');
            $var = json_decode($conteudo, true);
            $tamanho = count($var['task']);
            for ($i = 0; $i < $tamanho ; $i++) {
                if($selecionado == $i){
                    $valor_id = $var['task'][$i]['id'];
                    $valor_task = $var['task'][$i]['task'];
                    $valor_done = $var['task'][$i]['done'];
                }

            }
            
            if($valor_done == 'false' ){
                $valor_done = 'true';
            }else{
                $valor_done = 'false';
            }       

            //echo '<script> alert("atualizar "+'.$_POST['transfer'].'); </script>';
            $data = array("task" => $valor_task, "done" => $valor_done);
            $json_data = json_encode($data);
            //echo "<script> alert('".$json_data."'); </script>";
            //echo " <script> alert('http://localhost:5000/task/".$valor_id."'); </script>";
            $url = "http://localhost:5000/task/".$valor_id;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch,CURLOPT_HTTPHEADER,array('Content-Type: application/json','Content-Length: ' .strlen($json_data)));
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
            curl_setopt($ch, CURLOPT_POSTFIELDS,$json_data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response  = curl_exec($ch);
            curl_close($ch);
            echo "<script> alert('Tarefa atualizada com sucesso'); </script>";
            echo '
            <script>
                $(function () {
                    window.location.href = "tasks.php?reloaded=1";
                });
            </script>
       ';
    
            
        } else if ($_POST['action'] == 'remover') {
            //echo '<script> alert("remover "+'.$_POST['transfer'].'); </script>';

            $selecionado = $_POST['transfer'];
            $valor_id = '';
            
            $conteudo = file_get_contents('http://localhost:5000/task/');
            $var = json_decode($conteudo, true);
            $tamanho = count($var['task']);
            for ($i = 0; $i < $tamanho ; $i++) {
                if($selecionado == $i){
                    $valor_id = $var['task'][$i]['id'];
                }
            }

            //echo '<script> alert("atualizar "+'.$_POST['transfer'].'); </script>';
            $url = 'http://localhost:5000/task/'.$valor_id;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,$url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "delete");
            $response = curl_exec($ch);
            echo "<script> alert('Tarefa apagada com sucesso'); </script>";
            echo '
            <script>
                $(function () {
                    window.location.href = "tasks.php?reloaded=1";
                });
            </script>
       ';

        } else {
        }      


    ?>


    
    <script  type="text/javascript">
    
        function alerta(){
            var msgm = document.getElementById("entrada");
            alert("Salvo com sucesso! \nTarefa : "+msgm.value+"\nStatus : À FAZER");
        }

	function check(){
		
		var ch = " ";
		var x = document.getElementById("mtable").rows.length;
		x = x - 1 ;
		//alert(x);
		for(var i=0; i < x; i++){
		    if( document.getElementById("c"+i).checked == true){
			ch = i;
            document.getElementById('transfer').value = i;
			//alert(i);
		    }
		 //ch = ch + " , " + document.getElementById("c"+i).checked.toString();
		}
		//alert(ch);
		

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