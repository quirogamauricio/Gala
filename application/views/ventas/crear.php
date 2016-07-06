<div class="container">
	<div id="divErrorVenta" style="display:none;" class="alert alert-warning"></div>
	<div class="panel panel-info">
		<div class="panel-heading">
			<h2 class="panel-title"><?php echo $titulo; ?></h2>
		</div>
		<div class="panel-body">

			<?php echo form_open('ventas/nueva'); ?>

			<div class="form-group">
				<label for="descripcion">Producto</label> 
				<?php echo form_dropdown('producto', $productos, array(), 'id="productos" class="form-control"') ?> 
				<br />
				<input id="btnAgregarProducto" type="button" class="btn btn-default form-control" value="Agregar producto a la venta" />
			</div>

			<br />

			<div class="form-group">
				<label for="descripcion">Cliente</label> 
				<?php echo form_dropdown('cliente', $clientes, array(), 'id="cliente" class="form-control"') ?>
			</div>

			<br />

			<div class="form-group">
				<label for="descripcion">Caja</label> 
				<?php echo form_dropdown('caja', $cajas, array(), 'id="caja" class="form-control"') ?>
			</div>

			<br />

			<div class="panel panel-info">
				<div class="panel-heading">
					<h3 class="panel-title">Detalles de venta</h3>
				</div>
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table">
							<thead>
								<tr>
									<th></th>
									<th>Producto</th>
									<th>Forma de pago</th>
									<th>Precio</th>
									<th>Cantidad</th>
									<th>Subtotal</th>
								</tr>
							</thead>
							<tbody id="tProductos">
								<tr>
									<td colspan="5">
										<label>
											TOTAL
										</label>
									</td>
									<td>
										<input id="txtTotal" type="textbox" disabled="disabled" class="form-control" value="0">
									</td>
								</tr>
							</tbody>
						</table>  
					</div>
				</div>
			</div>

			<input id="txtAceptar" type="button" class="btn btn-default" name="submit" value="Aceptar">
		</form>	

	</div><!-- Fin panel body -->
</div><!-- Fin panel -->
</div><!-- Fin container -->

<script type="text/javascript">
	
	var productosEnVenta = [];
	var url = "<?php echo site_url('ventas/obtener_datos_producto/')?>/";

	//Agrega el producto a la venta con todos sus datos recuperándolo a través de AJAX
	$("#btnAgregarProducto").click(function(){

		var idProducto = $("#productos").val();

		//Pregunto si el producto NO se agregó al array
		if ($.inArray(idProducto, productosEnVenta) === -1) {

			$.get(url+idProducto).done(function(data){

				$("#divErrorVenta").hide();

				var producto = $( "#productos option:selected" ).text();
				var formasPago = "<select class='formaspago form-control'><option value='1'>Efectivo</option><option value='2'>Tarjeta</option></select>";
				var btnEliminar = "<input type='button' class='eliminarprod btn btn-danger' value='Eliminar'>";
				var txtPrecio = "<input type='textbox' disabled='disabled' class='txtprecio form-control' value='"+data.precio_venta_efectivo+"'>";
				var txtSubtotal = "<input type='textbox' disabled='disabled' class='txtsubtotal form-control' value='"+data.precio_venta_efectivo+"'>";
				var hdProducto = "<input type='hidden' class='hdProducto' value='"+JSON.stringify(data)+"'>";
				var cantidades;

				for (var i = 0; i < data.stock_actual; i++) {
					cantidades+="<option>"+(i+1)+"</option>";
				};

				var cantidad = "<select class='ddlcantidades form-control'>"+cantidades+"</select>";

				var clase = "producto";

				//Si el stock actual es menor al mínimo notifico
				if (parseInt(data.stock_actual) <= parseInt(data.stock_minimo)) {
					clase = clase + " alerta-stock";
				}

				var fila = "<tr class='"+clase+"'><td class='tdproducto'>"+btnEliminar+hdProducto+"</td><td>"+producto+"</td><td class='tdformaspago'>"+formasPago+"</td><td class='tdprecio'>"+txtPrecio+"</td><td class='tdcantidad'>"+cantidad+"</td><td class='tdsubtotal'>"+txtSubtotal+"</td></tr>";
				

				$("#tProductos").prepend(fila);
				productosEnVenta.push(idProducto);

				$(".txtsubtotal").trigger("change");
				
			}).fail(function(){

				$("#divErrorVenta").html("Error al intentar recuperar datos del producto");
				$("#divErrorVenta").show();

			});
		}
		else {

			$("#divErrorVenta").html("El producto seleccionado ya se agregó");
			$("#divErrorVenta").show();
		}

	});

	//Elimina el producto agregado a la venta
	$("#tProductos").on("click", 'input.eliminarprod', function(){

		//Obtengo el string producto guardado en el hidden y lo parseo a objeto JSON
		var producto = JSON.parse($(this).parents(".producto").children(".tdproducto").children(".hdProducto").val());

		//Elimino el producto del array
		productosEnVenta.splice(productosEnVenta.indexOf(producto.id_producto),1);

		//Elimino la fila de la tabla
		$(this).parents(".producto").remove();

		/*Si se eliminaron todos los productos no existen subtotales por lo tanto asigno 0 al total,
		caso contrario sumo los subtotales existentes.
		Ésto es porque disparar el change no funciona si se eliminaron todos los controles con la clase .txtsubtotal*/


		var cantProductos = 0;
		var sum = 0;

	    $(".txtsubtotal").each(function(){
	        cantProductos ++;
	        sum += +$(this).val();
	    });

	    if (cantProductos == 0) {
	    	$("#txtTotal").val(0);
	    }
	    else {
	    	
		    $("#txtTotal").val(sum);
	    }
	});

	//Actualiza el precio en base a la forma de pago seleccionada
	$("#tProductos").on("change", 'select.formaspago', function(){

		//Obtengo el string producto guardado en el hidden y lo parseo a objeto JSON
		var producto = JSON.parse($(this).parents(".producto").children(".tdproducto").children(".hdProducto").val());

		//Obtengo el precio en base a lo que está seleccionado en el combo de formas de pago
		var precio = $(this).val() == 1 ? producto.precio_venta_efectivo : producto.precio_venta_tarjeta;

		//Actualizo el textbox de precio
		$(this).parents(".producto").children(".tdprecio").children(".txtprecio").val(precio);

		//Disparo evento change manualmente (para actualizar el subtotal) ya que el cambiar el valor usando .val() no lo hace automáticamente
		$(this).parents(".producto").children(".tdprecio").children(".txtprecio").trigger("change");
	});

	//Actualiza el subtotal
	$("#tProductos").on("change", 'input.txtprecio', function(){

		//Obtengo la cantidad seleccionada
		var cantidad = $(this).parents(".producto").children(".tdcantidad").children(".ddlcantidades").val();

		var precio = $(this).val();

		//Actualizo el textbox de subtotal
		$(this).parents(".producto").children(".tdsubtotal").children(".txtsubtotal").val(cantidad*precio);

		//Disparo el change para que se actualice el total
		$(this).parents(".producto").children(".tdsubtotal").children(".txtsubtotal").trigger("change");
	});

	//Actualiza el subtotal
	$("#tProductos").on("change", 'select.ddlcantidades', function(){
		
		var cantidad = $(this).val();

		//Obtengo el precio
		var precio = $(this).parents(".producto").children(".tdprecio").children(".txtprecio").val();

		//Actualizo el textbox de subtotal
		$(this).parents(".producto").children(".tdsubtotal").children(".txtsubtotal").val(cantidad*precio);

		//Disparo el change para que se actualice el total
		$(this).parents(".producto").children(".tdsubtotal").children(".txtsubtotal").trigger("change");
	});

	//Actualiza el total
	$("#tProductos").on("change", '.txtsubtotal', function(){
		
		var sum = 0;

	    $(".txtsubtotal").each(function(){
	        sum += +$(this).val();
	    });

	    $("#txtTotal").val(sum);
	});

	//Envía por AJAX los datos de la venta
	$("#txtAceptar").click(function(){

		if ($("#caja").val() === null) 
		{
	    	$("#divErrorVenta").html("No se seleccionó una caja");
			$("#divErrorVenta").show();
			return;
		};

		if ($("#cliente").val() === null) 
		{
	    	$("#divErrorVenta").html("No se seleccionó un cliente");
			$("#divErrorVenta").show();
			return;
		};

		var cantProductos = 0;

		$(".producto").each(function(){
	        cantProductos++;
	    });

		//Si no se agregaron productos muestro error
	    if (cantProductos == 0)
	    {
	    	$("#divErrorVenta").html("No se agregaron productos a la venta");
			$("#divErrorVenta").show();
	    }
	    //Creo objeto para enviar por AJAX
	    else {

	    	$("#divErrorVenta").hide();
	    	var venta = {};
	    	venta.detalles_venta = [];
	    	venta.id_cliente = $("#cliente").val();
	    	venta.id_caja = $("#caja").val();
	    	venta.importe_total = $("#txtTotal").val();

	    	$(".producto").each(function(){

	    		var detalle_venta = {};
	    		var producto = JSON.parse($(this).children(".tdproducto").children(".hdProducto").val());
	    		var id_producto = producto.id_producto;
	    		var cantidad = $(this).children(".tdcantidad").children(".ddlcantidades").val();
	    		var id_forma_pago = $(this).children(".tdformaspago").children(".formaspago").val();

	    		detalle_venta.id_producto = id_producto;
	    		detalle_venta.cantidad = cantidad;
	    		detalle_venta.id_forma_pago = id_forma_pago;

	    		venta.detalles_venta.push(detalle_venta);
	        	
	   		 });

	    	var url = "<?php echo site_url('ventas/registrar_venta')?>";

	    	//Llamada AJAX al método registrar venta del controlador de venta

	    	$.post(url, {"venta" : venta}).done(function(data){

	    		window.location.replace("<?php echo site_url('ventas/resultado')?>/"+data);

	    	}).fail(function(){

				$("#divErrorVenta").html("Error al intentar registrar la venta");
				$("#divErrorVenta").show();

			});
	    }
	});

</script>