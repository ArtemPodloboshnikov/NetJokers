<?php 

	if (isset($_POST['deleteOne']))
	{
		$deleteFromHistory($_POST['idHistory']);
	}
	else if (isset($_POST['deleteAll']))
	{
		$deleteFromHistory();
	}
	$_SESSION['data'] = $history;
	
 ?>
<div class="mainAdmin">
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<script type="text/javascript" src="https://unpkg.com/canvg@3.0.4/lib/umd.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
      	<?php
      		$countYears = count(array_keys($countEvent));
      		for ($i = 0; $i < $countYears; $i++) {
      			$countMonth = count(array_keys($countEvent[array_keys($countEvent)[$i]]));
      			for ($j = 0; $j < $countMonth; $j++) {
      				echo "let data".$i.$j." = google.visualization.arrayToDataTable([

          			['Day', 'Количество событий'],".$this->graphicData($countEvent, array_keys($countEvent)[$i], array_keys($countEvent[array_keys($countEvent)[$i]])[$j])."]);";

          			echo "

          				let options".$i.$j." = {
				          title: '".$titleDate[array_keys($countEvent)[$i]][array_keys($countEvent[array_keys($countEvent)[$i]])[$j]]."',
				          curveType: 'function',
				          legend: { position: 'bottom' },
				          backgroundColor: 'transparent',
				          pointSize: 5,
						  series: { 
						  	0: { color: '#E81E6A' }
						  },
						  legendTextStyle: { color: '#17E666', fontName: 'AlegreyaRegular' },
				    	  titleTextStyle: { color: '#17E666', fontName: 'AlegreyaRegular' },
						  hAxis: {
						    textStyle:{color: '#17E666', fontName: 'AlegreyaRegular'}
						    
						  },
						  vAxis: {
						    textStyle:{color: '#17E666', fontName: 'AlegreyaRegular'},
						    gridlines: {color: '#7D0E3B'}
						  }
				        };

          			";
      			}
      			
      		}
        	

?>
        
		let node = document.getElementsByClassName('curve_chart');
		function load(event)
        			{
        				    const canvas = document.querySelector('canvas');
    const ctx = canvas.getContext('2d');
    
    
        				num = event.path[1].id.replace('downloadChart', '')
        				var e = document.getElementById('curve_chart'+ num);
        				svg = e.getElementsByTagName('svg')[0].outerHTML;
        				v = canvg.Canvg.fromString(ctx, svg);

    // Start SVG rendering with animations and mouse handling.
    v.start();
        				console.log(svg);
        			}

          function getImgData(chartContainer) {
    var chartArea = chartContainer.getElementsByTagName('svg')[0].parentNode;
    var svg = chartArea.innerHTML;
    var doc = chartContainer.ownerDocument;
    var canvas = doc.createElement('canvas');
    canvas.setAttribute('width', chartArea.offsetWidth);
    canvas.setAttribute('height', chartArea.offsetHeight);


    canvas.setAttribute(
        'style',
        'position: absolute; ' +
        'top: ' + (-chartArea.offsetHeight * 2) + 'px;' +
        'left: ' + (-chartArea.offsetWidth * 2) + 'px;');
    doc.body.appendChild(canvas);
    canvg(canvas, svg);
    var imgData = canvas.toDataURL("image/png");
    canvas.parentNode.removeChild(canvas);
    return imgData;
  }
        <?php 

        	for ($i = 0; $i < $countYears; $i++)
        	{
        		for ($j = 0; $j < $countMonth; $j++){
        		echo "

        			
        			let div".$i.$j." = document.createElement('div');
        			div".$i.$j.".id = 'curve_chart".$i.$j."'
        			div".$i.$j.".style.width = 900 + 'px'
        			div".$i.$j.".style.height = 500 + 'px'
        			
        			let button".$i.$j." = document.createElement('button');
        			button".$i.$j.".className = 'load'
        			//button".$i.$j.".type = 'submit'
        			button".$i.$j.".onclick = load;
        			button".$i.$j.".id = 'downloadChart".$i.$j."'
        			button".$i.$j.".innerHTML = '<p>Скачать</p>'
        			

        			var chart = new google.visualization.AreaChart(div".$i.$j.");

        			node[0].appendChild(div".$i.$j.");
        			chart.draw(data".$i.$j.", options".$i.$j.");
        			node[0].insertBefore(button".$i.$j.", div".$i.$j.");
        			
        			/*let input".$i.$j." = document.createElement('input');
        			input".$i.$j.".type = 'hidden'
        			input".$i.$j.".id = 'input".$i.$j."'
        			input".$i.$j.".value = ''*/
        		";
        	}
        	}
        ?>
        
        
      }
    </script>
	<div class="mainAdmin__history">
		<?php 

			if (!empty($history))
			{
				
				$this->showTable(4, ['Id', 'Пользователь', 'Описание', 'Время'], $history, ['history_id', 'user_name', 'action', 'date']);  
				form("method='POST'");
					input("type='number' min='1' value='1' name='idHistory'");
					button("type='submit' formaction='' class='preview' name='deleteOne'");
						p("");
							echo "Удалить";
						p();
					button();
					button("type='submit' formaction='' class='load' name='deleteAll'");
						p("");
							echo "Удалить всё";
						p();
					button();
					button("type='submit' formaction='".$_SESSION['constants']['CURRENT_DOMEN']."download' class='load' name='download'");
						p("");
							echo "Скачать";
						p();
					button();
					input("type='hidden'", "value='history'", "name='action'");
				form();
				
  			}

		?>
		
	</div>
	<div class='curve_chart'></div>
</div>