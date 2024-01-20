<form method="post" id="add_support">
	<div class="row">
		<div class="col-xxl-3 col-md-6">
			<div>
				<label for="labelInput" class="form-label">User Name</label>
				<input type="text" class="form-control" id="username" name="username">
				<label id="username-error" class="error" for="username"></label>
			</div>
		</div>
		<div class="col-xxl-3 col-md-6">
			<div>
				<label for="labelInput" class="form-label">E-mail</label>
				<input type="text" class="form-control" id="user_email" name="user_email">
				<label id="user_email-error" class="error" for="user_email"></label>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-xxl-3 col-md-6">
			<div>
				<label for="labelInput" class="form-label">Problem Type</label>
				<input type="text" class="form-control" id="problem_type" name="problem_type">
				<label id="problem_type-error" class="error" for="problem_type"></label>
			</div>
		</div>
		<div class="col-xxl-3 col-md-6">
			<div>
				<label for="labelInput" class="form-label">Reported Problem</label>
				<input type="text" class="form-control" id="reported_problem" name="reported_problem">
				<label id="reported_problem-error" class="error" for="reported_problem"></label>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-xxl-3 col-md-6">
			<div>
				<label for="labelInput" class="form-label">Subject</label>
				<input type="text" class="form-control" id="subject" name="subject">
				<label id="subject-error" class="error" for="subject"></label>
			</div>
		</div>
		<div class="col-xxl-3 col-md-6">
			<div>
				<label for="labelInput" class="form-label">Message</label>
				<input type="text" class="form-control" id="message" name="message">
				<label id="message-error" class="error" for="message"></label>
			</div>
		</div>
	</div>
</form>

<div class="text-end mb-3 mt-3">
	<!--									<button type="button" class="btn btn-outline-danger waves-effect waves-light w-lg" id="cancel_btn">Cancel</button>-->
	<button type="button" class="btn btn-info waves-effect waves-light w-lg" id="save_support">Submit</button>
</div>
