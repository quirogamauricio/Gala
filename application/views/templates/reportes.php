<div class="container">
	<div id="divError" style="display:none;" class="alert alert-warning"></div>
</div>

<div style="margin-right: auto; margin-left: 20%; width: 800px; margin-top: 5%;">
	<canvas id="productosMasVendidos" width="400" height="400"></canvas>
	<canvas id="periodoMayorVenta" width="400" height="400"></canvas>
</div>

<script type="text/javascript">

	$("#divError").hide();

	//Productos más vendidos
	var ctxCanvProd = document.getElementById("productosMasVendidos").getContext("2d");

	var display_data = [];

	var url = "<?php echo site_url('reportes/obtener_productos_mas_vendidos')?>";

	$.get(url).done(function(data){

		switch(data.length) {

			case 0: 

			$("#divError").html("Aún no se han registrado ventas");
			$("#divError").show();

			break;

			case 1:

			display_data.push({
				value:  data[0].cantidad_vendida,
				color:"#F7464A",
				highlight: "#FF5A5E",
				label:  'Producto '+data[0].producto
			}); 

			break;

			case 2:

			display_data.push({
				value:  data[0].cantidad_vendida,
				color:"#F7464A",
				highlight: "#FF5A5E",
				label:  'Producto '+data[0].producto
			}); 
			display_data.push({
				value: data[1].cantidad_vendida,
				color: "#46BFBD",
				highlight: "#5AD3D1",
				label: 'Producto '+data[1].producto
			}); 

			break;

			case 3:

			display_data.push({
				value:  data[0].cantidad_vendida,
				color:"#F7464A",
				highlight: "#FF5A5E",
				label:  'Producto '+data[0].producto
			}); 
			display_data.push({
				value: data[1].cantidad_vendida,
				color: "#46BFBD",
				highlight: "#5AD3D1",
				label: 'Producto '+data[1].producto
			}); 
			display_data.push({
				value: data[2].cantidad_vendida,
				color: "#FDB45C",
				highlight: "#FFC870",
				label: 'Producto '+data[2].producto
			});

			break;
		}

		var myDoughnutChart = new Chart(ctxCanvProd).Doughnut(display_data);
	});
	
	//Ventas por mes
	var ctxCanvPeriod = document.getElementById("periodoMayorVenta").getContext("2d");

	var cant_ventas_mes = [];

 	url = "<?php echo site_url('reportes/obtener_ventas_por_periodo')?>";

	$.get(url).done(function(data){

		if (data.length == 0) {

			$("#divError").html("Aún no se han registrado ventas");
			$("#divError").show();
			return;
		};

		for (var i = 1; i < 13; i++) {

			for (var j = 0; j < data.length; j++) {

				if (data[j].mes == i) {
					cant_ventas_mes.push(data[j].cant_ventas);
				}
				else {

					cant_ventas_mes.push(0);
				}
			};
		};

		var data = {
	    labels: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
	    datasets: [
			        {
			            label: "Productos",
			            fillColor: "rgba(220,220,220,0.5)",
			            strokeColor: "rgba(220,220,220,0.8)",
			            highlightFill: "rgba(220,220,220,0.75)",
			            highlightStroke: "rgba(220,220,220,1)",
			            data: cant_ventas_mes
			        }
	   			  ]
		};

		var myBarChart = new Chart(ctxCanvPeriod).Bar(data);
	}); 

</script>