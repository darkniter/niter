<html>
	<head>
		<meta charset=utf-8>
		<style>
			@import url("css/style.css?201905131611"); 
        </style>
    </head>
    
	<body>	
        <p>
            <form action="<?php echo $_SERVER['REQUEST_URI']?>" method="POST"><input name="ip" type= "text"  maxlength="16" required 
                <?php
                    $url_query=$_SERVER['QUERY_STRING'];
                    parse_str($url_query,$partsURL);
                    $ip=$partsURL['ip'];
                    $vendor=mb_strtolower($partsURL['vendor']);
                    
                    if($ip==null)$ip=htmlspecialchars($_POST["ip"]);
                    
                    echo "value={$ip}>";
                    
                    echo '<select name = "vendor" >';
                    if($vendor==null)$vendor=htmlspecialchars($_POST["vendor"]);
                    
                    require_once 'config.php';
                    
                    foreach($request as $value){
                        $name_vendor=key($request);
                        next($request);
                        echo '<option value="';
                        
                        echo $name_vendor;
                        echo'"';
                        if(mb_strtolower($name_vendor)==mb_strtolower($vendor)) echo 'selected';
                        echo '>';
                        echo "{$name_vendor}</option>";
                    }  
                    reset($request);
                    echo '</select>';
                    echo '<button name="activate" type="submit" value="Найти">Найти</button>';
                    echo'</form></p>';  
                    
                    $mysqli = new mysqli('localhost','mysql','mysql','radius');
                    
                    $time=0;
                    
                    $ip=htmlspecialchars($_POST["ip"]);		
                    $vendor = $_POST["vendor"];
                    $str=str_replace(".","",$ip);
                    
                    
                    if ($mysqli->connect_errno) {
                        echo "Failed to connect to MySQL: " . mysqli_connect_error();
                        echo $Err["Err1"];
                        } else {
                        echo 'Соединение установлено.<br>';
                        if((ctype_digit($str)==true) && (substr_count($ip,".")==3)){
                            
                            $time=microtime(true);
                            
                            $mysqli->query("SET profiling = 1;");
                            
                            
                            
                            if ( $result = $mysqli->query($request["{$vendor}"]) ) { //Отправление запросов на сервер
                                $exec_time_query = $request['Request_time'];
                                
                                $exec_time_result = $mysqli->query($exec_time_query);
                                $exec_time_row = $exec_time_result->fetch_array();
                                
                                
                                
                                $time = microtime(true)-$time;
                                
                                if($result->num_rows){//Обработка пустого ответа от сервера 
                                    
                                    if($result!=null){
                                        $a = mysqli_num_fields($result);//сорян мозги кипели
                                        echo'<table> <tr>';
                                        
                                        for($i=0;$i<$a;$i++){
                                            
                                            
                                            $info_column = $result->fetch_field_direct($i); 
                                            
                                            $name_column= $info_column->name;
                                            
                                            echo "<th>{$name_column}</th>";
                                            
                                        }
                                        echo '</tr>';
                                    }
                                    
                                    
                                    
                                    while($resource=$result->fetch_array(MYSQLI_ASSOC)){ //Вывод таблицы с полученными значениями
                                        echo '<tr>';
                                        for($i=0;$i<$a;$i++){
                                            $info_column = $result->fetch_field_direct($i); 
                                            
                                            $name_column= $info_column->name;
                                            
                                            echo '<td>'.$resource["{$name_column}"].'</td>';
                                        }
                                        echo '</tr>';
                                    }
                                    echo '</table>';
                                    $result->close();
                                }
                                else echo $Err["ErrEnter2"];
                                } else {
                                echo $Err["ErrRequestEmpty"];
                            }
                            
                            
                            
                        }elseif($str==""){echo $Err["info"];}
                        else echo $Err["ErrEnter1"];
                    }
                    
                    if(isset($exec_time_row[1])) echo "<p>Query executed in ".$exec_time_row[1].' seconds';
                    
                    echo "<br><br>Time request {$time}";
                ?>
                <pre style="display:none"><?php echo($SQL_time);?></pre>
                
            </body>
        </html>
