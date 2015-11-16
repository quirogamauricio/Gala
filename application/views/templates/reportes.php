<div class="container">
	<div id="divError" style="display:none;" class="alert alert-warning"></div>
</div>

<div style="margin-right: auto; margin-left: 35%; width: 800px; margin-top: 5%;">
	<canvas id="myChart" width="400" height="400"></canvas>
</div>

<script type="text/javascript">

	$("#divError").hide();

	// Get the context of the canvas element we want to select
	var ctx = document.getElementById("myChart").getContext("2d");

	var display_data = [];

	var url = "<?php echo site_url('reportes/obtener_productos_mas_vendidos')?>";

	$.get(url).done(function(data){

		// data.pop();
		// data.pop();

		switch(data.length) {

			case 0: 

			$("#divError").html("Aún no se han registrado ventas");
			$("#divError").show();

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

		var myDoughnutChart = new Chart(ctx).Doughnut(display_data);
	});


</script>