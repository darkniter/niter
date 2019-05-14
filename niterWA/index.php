<html>
	<head>
		<meta charset=utf-8>
		<style>
			@import url("css/style.css?201905131612"); 
		</style>
	</head>

	<body>	
	<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="GET">
	<input name="ip" type= "text"  maxlength="16" required <?php $ip=htmlspecialchars($_GET["ip"]);  print ("value=$ip");?> >
	<button name="activate" type="submit" value="Найти">Найти</button>
	<p>Dlink<input name="vendor" type="radio" value="Dlink" <?php $radio=htmlspecialchars($_GET["vendor"]); if(($radio =="Dlink")||($radio==null)) print ("checked");?>>
	Eltex<input name="vendor" type="radio" value="Eltex" <?php $radio=htmlspecialchars($_GET["vendor"]); if($radio =="Eltex") print ("checked");?>>
	</p></form>
	
<?php
	require_once 'config.php';
		
		
		//if(isset($_GET["activate"])){
		$time=0;
		$ip=htmlspecialchars($_GET["ip"]);		
		$radio = $_GET["vendor"];
		$str=str_replace(".","",$ip);
		
		//Проверка правильности ввода
		
		
		error_reporting(E_ALL);
	
		ini_set('display_errors', 1);
			
		$link =  mysqli_connect($line["host"],$line["username"],$line["passwd"],$line["dbnam"]);

		if (mysqli_connect_errno()){ //Тест подключения
		  echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		if($link){
		echo 'Соединение установлено.<br>';
		if((ctype_digit($str)==true) ||(substr_count($ip,".")==3)){
				
		$time=microtime(true);
		mysqli_query($link, "SET profiling = 1;");
		
		if (mysqli_errno($link)) { die( "ERROR ".mysqli_errno($link) . ": " . mysqli_error($link) ); }
		
		$result =($radio=="Eltex")? mysqli_query($link,$request['Eltex']):mysqli_query($link,$request['Dlink']); //Отправление запросов на сервер
		
		if (mysqli_errno($link )) { die( "ERROR ".mysqli_errno($link) . ": " . mysqli_error($link) ); }

		$exec_time_result=mysqli_query($link, "SELECT query_id, SUM(duration) FROM information_schema.profiling GROUP BY query_id ORDER BY query_id DESC LIMIT 1;");
		
		if (mysqli_errno($link )) { die( "ERROR ".mysqli_errno($link) . ": " . mysqli_error($link) ); }
		$exec_time_row = mysqli_fetch_array($exec_time_result);

		
		$time = microtime(true)-$time;
			
		
		
		if($result->num_rows){//Обработка пустого ответа от сервера 
		
		echo'<table><tr><th>Логин</th><th>MAC-адрес</th><th>Порт</th><th> Дата </th></tr>';
		
	
	while($resource=mysqli_fetch_array($result)){ //Вывод таблицы с полученными значениями
			
		echo "<tr><td>{$resource['login']}</td><td>{$resource['mac']}</td><td>{$resource['port']}</td><td>{$resource['date']}</td></tr>";
		
		}
		  
		echo '</table>';
		}	
		else 
		echo $Err["ErrEnter2"];
		}
		elseif($str==""){echo $Err["info"];}
		else echo $Err["ErrEnter1"];
		}
		else
		echo $Err["Err1"];
		if(isset($exec_time_row[1])) echo "<p>Query executed in ".$exec_time_row[1].' seconds';
		echo "<br><br>Time request {$time}";
		?>
		</body>
		</html>