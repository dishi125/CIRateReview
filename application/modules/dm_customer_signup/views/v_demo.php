<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>aksFileUpload Draggable File Upload Component Example</title>
</head>
<body>
<form method="post" id="add_property">
	<div class="row">
		<div class="col-6">
			<div>
				<label for="labelInput" class="form-label">Property Name</label>
				<input type="text" name="PropertyName" id="PropertyName" class="form-control">
			</div>
		</div>
		<div class="col-6">
			<div>
				<label for="labelInput" class="form-label">Property Code</label>
				<input type="text" name="HotelCode" id="HotelCode" class="form-control">
			</div>
		</div>
	</div>

	<div class="text-end mb-3 mt-3">
		<button type="button" class="btn btn-outline-danger waves-effect waves-light w-lg" id="cancel_btn">Cancel</button>
		<button type="button" class="btn btn-info waves-effect waves-light w-lg" id="save_property">Save</button>
	</div>
</form>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
	$(document).on("click", "#save_property", function (){
		location.reload();
	})
</script>

</body>
</html>
