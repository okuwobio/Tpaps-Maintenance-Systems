<!-- Add or Edit Aircraft Modal -->
<?php
if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT * from `aircrafts_list` where id = '{$_GET['id']}' ");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=stripslashes($v);
        }
    }
}
?>
<div class="card card-outline card-info">
	<div class="card-header">
		<h3 class="card-title"><?php echo isset($id) ? "Update ": "Create New " ?> Aircraft</h3>
	</div>
	<div class="card-body">
		<form action="" id="engineer-form">
			<input type="hidden" name ="id" value="<?php echo isset($id) ? $id : '' ?>">
			<div class="form-group">
				<label for="name" class="control-label">Aircraft Name:</label>
                <input name="name" id="name" type="text" class="form-control rounded-0" value="<?php echo isset($name) ? $name : ''; ?>" required>
			</div>
			<div class="form-group">
				<label for="name" class="control-label">Aircraft Reg No:</label>
                <input name="reg_no" id="reg_no" type="text" class="form-control rounded-0" value="<?php echo isset($reg_no) ? $reg_no : ''; ?>" required>
			</div>
			<div class="form-group">
				<label for="name" class="control-label">Aircraft Model No:</label>
                <input name="model_no" id="model_no" type="text" class="form-control rounded-0" value="<?php echo isset($model_no) ? $model_no : ''; ?>" required>
			</div>
			<div class="form-group">
				<label for="name" class="control-label">Aircraft Model:</label>
                <input name="model" id="model" type="text" class="form-control rounded-0" value="<?php echo isset($model) ? $model : ''; ?>" required>
			</div>
			<div class="form-group">
				<label for="name" class="control-label">Aircraft Hrs in air:</label>
                <input name="in_air" id="in_air" type="text" class="form-control rounded-0" value="<?php echo isset($in_air) ? $in_air : ''; ?>" required>
			</div>
            <div class="form-group">
				<label for="status" class="control-label">Status</label>
                <select name="status" id="status" class="custom-select selevt">
                <option value="1" <?php echo isset($status) && $status == 1 ? 'selected' : '' ?>>Active</option>
                <option value="0" <?php echo isset($status) && $status == 0 ? 'selected' : '' ?>>Inactive</option>
                </select>
			</div>
		</form>
	</div>
	<div class="card-footer">
		<button class="btn btn-flat btn-primary" form="engineer-form">Save</button>
		<a class="btn btn-flat btn-default" href="?page=engineer">Cancel</a>
	</div>
</div>
<script>

	// Add and Update Script using Ajax
	$(document).ready(function(){
       
		$('#engineer-form').submit(function(e){
			e.preventDefault();
            var _this = $(this)
			 $('.err-msg').remove();
			start_loader();
			$.ajax({
				url:_base_url_+"classes/Master.php?f=save_aircraft",
				data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
				error:err=>{
					console.log(err)
					alert_toast("An error occured",'error');
					end_loader();
				},
				success:function(resp){
					if(typeof resp =='object' && resp.status == 'success'){
						location.href = "./?page=aircrafts";
					}else if(resp.status == 'failed' && !!resp.msg){
                        var el = $('<div>')
                            el.addClass("alert alert-danger err-msg").text(resp.msg)
                            _this.prepend(el)
                            el.show('slow')
                            $("html, body").animate({ scrollTop: _this.closest('.card').offset().top }, "fast");
                            end_loader()
                    }else{
						// alert_toast("An error occured",'error');
						end_loader();
                        console.log(resp)
					}
				}
			})
		})

        $('.summernote').summernote({
		        height: 200,
		        toolbar: [
		            [ 'style', [ 'style' ] ],
		            [ 'font', [ 'bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear'] ],
		            [ 'fontname', [ 'fontname' ] ],
		            [ 'fontsize', [ 'fontsize' ] ],
		            [ 'color', [ 'color' ] ],
		            [ 'para', [ 'ol', 'ul', 'paragraph', 'height' ] ],
		            [ 'table', [ 'table' ] ],
		            [ 'view', [ 'undo', 'redo', 'fullscreen', 'codeview', 'help' ] ]
		        ]
		    })
	})
</script>