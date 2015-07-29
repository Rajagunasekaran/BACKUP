<div class="container">
	<p>
		<h3>System Settings</h3>
		<h5>Please update the information below</h5>
	</p>
</div>
<div class="container">
	<div class="row">
		<div class="control-group">
			<div class="input-group">
				<div class="col-md-4">
					<label for="code"> Site Name</label>
					<input class="form-control" type="text"placeholder="Simple POS"/><br><br>
					<label for="code">Default Discount</label>
					<input class="form-control" type="text"placeholder="0"/><br><br>
					<label for="code">Product Display</label>
					<select class="form-control col-md-4">
						<option></option>
						<option></option>
					</select><br><br>
					<label for="code">Default Category</label>
					<select class="form-control col-md-4">
						<option></option>
						<option></option>
					</select><br><br>
					<label for="code">Date Formate</label>
					<select class="form-control col-md-4">
						<option></option>
						<option></option>
					</select><br><br>
				</div>
				<div class="col-md-4">
					<label for="code">Tel</label>
					<input class="form-control" type="text"placeholder="0105292122"></input><br>
					<label for="code">Default Tax Rate</label>
					<input class="form-control" type="text"placeholder="5%"></input><br>
					<label for="code">Display Time</label>
					<select class="form-control col-md-4">
						<option></option>
						<option></option>
					</select><br><br>
					<label for="code">Default Customer</label>
					<select class="form-control col-md-4">
						<option></option>
						<option></option>
					</select><br><br>
				</div>
				<div class="col-md-4">
					<label for="code">Currency Code</label>
					<input class="form-control" type="text"placeholder="USD"></input><br>
					<label for="code">Rows Per Page</label>
					<input class="form-control" type="text"placeholder="10"></input><br>
					<label for="code">Display Keyboard</label>
					<select class="form-control col-md-4">
						<option></option>
						<option></option>
					</select><br><br>
					<label for="code">Barcode Symbology</label>
					<select class="form-control col-md-4">
						<option></option>
						<option></option>
					</select><br><br>
				</div>
			</div>
		</div>
	</div>
</div><br>
<div class="container">
	<div class="row">
		<div class="col-md-6">
		<label for="code">Receipt Header</label><br>
			<div class="panel panel-default">
				<div class="panel-heading">
					<a href="#"><span class="glyphicon glyphicon-th-list"></span></a>
					<a href="#"><span class="glyphicon glyphicon-align-left"></span></a>
					<a href="#"><span class="glyphicon glyphicon-align-center"></span></a>
					<a href="#"><span class="glyphicon glyphicon-align-right"></span></a>
					<a href="#"><span class="glyphicon glyphicon-align-justify"></span></a>
					<a href="#"><span class="glyphicon glyphicon-align-bold"></span></a>
					<a href="#"><span class="glyphicon glyphicon-align-italic"></span></a>
					<a href="#"><span class="glyphicon glyphicon-align-underline"></span></a>
					<a href="#"><span class="glyphicon glyphicon-align-center"></span></a>
				</div>
				<div class="panel-body">
				<p>
					<h3>Simple POS</h3>
					<h5>My Shop Lot,shopping Mail<br>
					PostCode,City</h5>
				</p>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<label for="code">Receipt Footer</label><br>
			<div class="panel panel-default">
				<div class="panel-heading">
					<a href="#"><span class="glyphicon glyphicon-th-list"></span></a>
					<a href="#"><span class="glyphicon glyphicon-align-left"></span></a>
					<a href="#"><span class="glyphicon glyphicon-align-center"></span></a>
					<a href="#"><span class="glyphicon glyphicon-align-right"></span></a>
					<a href="#"><span class="glyphicon glyphicon-align-justify"></span></a>
					<a href="#"><span class="glyphicon glyphicon-align-bold"></span></a>
					<a href="#"><span class="glyphicon glyphicon-align-italic"></span></a>
					<a href="#"><span class="glyphicon glyphicon-align-underline"></span></a>
					<a href="#"><span class="glyphicon glyphicon-align-center"></span></a>
				</div>
				<div class="panel-body">
				<p>
					<h3>Simple POS</h3>
					<h5>My Shop Lot,shopping Mail<br>
					PostCode,City</h5>
				</p>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
        <?php echo $form->labelEx($model, 'orderproducts'); ?>
        <?php
        echo $form->radioButtonList(
                $model,
                'orderproducts',
                $this->imageList(CHtml::listData(
                                Product::model()->findAll(),
                                'Id',
                                'imagepath')
                ),
                array('separator' => '')
        );
        ?>
        <?php echo $form->error($model, 'orderproducts'); ?>
    </div>