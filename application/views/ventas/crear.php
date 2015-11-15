<div class="container">
	<?php echo validation_errors(); ?>
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
				<?php echo form_dropdown('cliente', $clientes, array(), 'class="form-control"') ?>
			</div>

			<br />

			<div class="form-group">
				<label for="descripcion">Caja</label> 
				<?php echo form_dropdown('caja', $cajas, array(), 'class="form-control"') ?>
			</div>

			<br />

			<div class="panel panel-info">
				<div class="panel-heading">
					<h3 class="panel-title">Detalles de venta</h3>
				</div>
				<div class="panel-body">
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
								<td colspan="5">TOTAL</td>
								<td>
									<input type="textbox" disabled="disabled" class="form-control">
								</td>
							</tr>
						</tbody>
					</table>  
				</div>
			</div>

			<input type="submit" class="btn btn-default" name="submit" value="Aceptar">
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
				var fila = "<tr class='producto'><td class='tdproducto'>"+btnEliminar+hdProducto+"</td><td>"+producto+"</td><td>"+formasPago+"</td><td class='tdprecio'>"+txtPrecio+"</td><td class='tdcantidad'>"+cantidad+"</td><td class='tdsubtotal'>"+txtSubtotal+"</td></tr>";
				

				$("#tProductos").prepend(fila);
				productosEnVenta.push(idProducto);
				
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
	});

	//Actualiza el subtotal
	$("#tProductos").on("change", 'select.ddlcantidades', function(){
		
		var cantidad = $(this).val();

		//Obtengo el precio
		var precio = $(this).parents(".producto").children(".tdprecio").children(".txtprecio").val();

		//Actualizo el textbox de subtotal
		$(this).parents(".producto").children(".tdsubtotal").children(".txtsubtotal").val(cantidad*precio);
	});

</script>