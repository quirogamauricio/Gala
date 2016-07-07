<div class="container">
	<div id="divError" style="display:none;" class="alert alert-warning"></div>

	<div class="row">
		<div class="col-md-6" style="text-align: center;">
			<h3 class="alert alert-info">TOP 3 PRODUCTOS MÁS VENDIDOS</h3>
			<br>
			<canvas id="productosMasVendidos" width="400" height="400"></canvas>
		</div>
		<div class="col-md-6" style="text-align: center;">
			<h3 class="alert alert-info">VENTAS POR MES</h3>
			<br>
			<canvas id="periodoMayorVenta" width="400" height="400"></canvas>
		</div>
		<div class="col-md-6" style="text-align: center;">
			<h3 class="alert alert-info">VENTAS POR CLIENTE</h3>
			<br>
			<canvas id="ventasPorCliente" width="400" height="400"></canvas>
		</div>
	</div>
	<div class="row">
		
	</div>
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

			cant_ventas_mes.push(0);

			for (var j = 0; j < data.length; j++) {

				if (data[j].mes == i) {
					cant_ventas_mes[i-1]=data[j].cant_ventas;
				}
			};
		};

		var data = {
	    labels: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
	    datasets: [
			        {
			            label: "Ventas por mes",
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

	//Ventas por cliente
	var ctxCanvVentasPorCliente = document.getElementById("ventasPorCliente").getContext("2d");
	var url = "<?php echo site_url('reportes/obtener_ventas_por_cliente')?>";
	
	$.get(url).done(function(data){

		if (data.length == 0) {

			$("#divError").html("Aún no se han registrado ventas");
			$("#divError").show();
			return;
		};

		var clientes = [];
		var cant_ventas_cliente = [];

		for (var i = 0; i < data.length; i++) {

			clientes.push(data[i].cliente);
		};

		for (var i = 0; i < data.length; i++) {

			if (clientes[i] == data[i].cliente)
			 {
			 	cant_ventas_cliente.push(data[i].cant_ventas);
			 }
		};

		var data = {
	    labels: clientes,
	    datasets: [
			        {
			            label: "Ventas por cliente",
			            fillColor: "rgba(255,224,230,1)",
			            strokeColor: "rgba(255,136,161,1)",
			            highlightFill: "rgba(220,220,220,0.75)",
			            highlightStroke: "rgba(220,220,220,1)",
			            data: cant_ventas_cliente
			        }
	   			  ]
		};

		var myBarChart = new Chart(ctxCanvVentasPorCliente).Bar(data);
	});

</script>