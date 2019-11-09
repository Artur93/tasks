<?php

session_start();

if(!isset($_SESSION['user'])) {
    session_destroy();
    echo "<meta http-equiv=\"refresh\" content=\"0;URL='index.php'\" />";
}
?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Index</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
	
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
	
	<script>
		$( document ).ready(function() {
			
			getData();
			
			$('#data_table').on("click", 'input[name="edit"]', function() {
				$(".form-control").css("width", "auto");
				var tsk_name = $(this).parent().siblings(".tsk_name").text();
				var tsk_email = $(this).parent().siblings(".tsk_email").text();
				var tsk_id = $(this).parent().siblings(".tsk_id")[0].value;
				var tsk = $(this).parent().siblings(".tsk").text();
				
				$("#name").val(tsk_name);
				$("#email").val(tsk_email);
				$("#tsk").val(tsk);
				$("#c_id").val(tsk_id);
			});
			
			$('#data_table').on("click", 'input[name="approve_data"]', function() {
				var approve = $(this).siblings('input[name="approve"]').val();
				var tsk_id = $(this).parent().parent().siblings(".tsk_id")[0].value;
				statusChange(tsk_id, approve);
			});
			
			
			$("#submit_form").on("click", 'input[id="send"]', function() {
				var id = $(this).parent().siblings().children('input[name="row_id"]').val();
				var name = $(this).parent().siblings().children('input[name="nm"]').val();
				var email = $(this).parent().siblings().children('input[name="email"]').val();
				var tsk = $(this).parent().siblings().children('textarea[name="task"]').val();
				
				$.ajax({
					url: '../handler.php',
					type: 'POST',
					data: {"updFlag": 1, "row_id": id, "nm": name, "em": email, "tsk": tsk},					
					success: function (data) {
						alert(data);
						$("#name").val("");
						$("#email").val("");
						$("#tsk").val("");
						$("#exampleModal").hide();
						$(".modal-backdrop").hide();
						$("body").removeClass("modal-open");
						getData();
					}
				});
			});
			
			
			
			setInterval(getData, 10000);		
			
		});
		
		function statusChange(id, status) {
			$.ajax({
				url: '../handler.php',
				type: 'POST',
				data: {"updateStat": true, "row_id": id, "stat": status},
				success: function (data) {
					alert(data);
					getData();
				}
			});
		}
		
	function populateDataTable(data) {
		var row = "";
		if(data.id != null) {
			$("#data").children().remove();
			for(var i = 0; i < data.id.length; i++) {
				if(data.is_done[i] == 1){
					row += '<tr>\
							<td class="tsk_name">' + data.name[i] + '</td>\
							<td class="tsk_email">' + data.email[i] + '</td>\
							<td class="tsk">' + data.task[i] + '</td>\
							<td tsk_inputs>\
								<input type="button" class="btn btn-primary" 						value="Редактирование" data-toggle="modal" name="edit" 					data-target="#exampleModal">\
							</td>\
							<td>\Выполнено</td>\
							<input type="hidden" class="tsk_id" value="' + data.id[i] + '">\
					   </tr>'
				}else {
					row += '<tr>\
							<td class="tsk_name">' + data.name[i] + '</td>\
							<td class="tsk_email">' + data.email[i] + '</td>\
							<td class="tsk">' + data.task[i] + '</td>\
							<td tsk_inputs>\
								<input type="button" class="btn btn-primary" 						value="Редактирование" data-toggle="modal" name="edit" 					data-target="#exampleModal">\
							</td>\
							<td>\
								<span>\
									<input type="button" class="btn btn-success" 					name="approve_data" value="Подтвердить">\
									<input type="hidden" value="1" name="approve">\
								</span>\
							</td>\
							<input type="hidden" class="tsk_id" value="' + data.id[i] + '">\
					   </tr>'
				}


			}
			$("#data").append(row);
			$('#data_table').DataTable({
				"ordering": true,
				columnDefs: [{ 
					orderable: false, 
					targets:  "no-sort"
				}],
				"order": [[ 0, "asc" ]],
				"aLengthMenu": [3, 10, 50, 25, 100],
				"pageLength": 3,
				destroy: true
			});
		}
	}				
		
		function getData() {
			$.ajax({
				url: '../handler.php',
				type: 'POST',	
				cache: false,
				data: {"getFlagAll": true},
				dataType: 'JSON',
				success: function (data) {
					$("#data_table").DataTable().destroy();
					populateDataTable(data);										
				}
			});
		}
	</script>
	<style>
		.dataTables_wrapper {
			width: 70%;
			margin-left:auto; 
    		margin-right:auto;
		}
	</style>
</head>

<body>
	<br>
	<div align="right" style="margin-right: 10px;">
		<form action="user_handler.php" method="post">
            <input type="submit" class="btn btn-default" name="logout" value="Выход"/>
        </form>
	</div>
	
	<!-- Modal -->
	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel">Редактирование</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
			<form enctype="multipart/form-data" id="submit_form" class="col-md-12">
				<div class="form-group col-sm-4">
					<label for="name">Имя</label>
					<input type="text" name="nm" class="form-control" id="name" required>
					<input type="hidden" name="row_id" id="c_id">
				</div>
				<div class="form-group col-sm-4">
					<label for="email">Электронная почта</label>
					<input type="email" name="email" class="form-control" id="email" aria-describedby="emailHelp" required>
				</div>
				<div class="form-group col-sm-4">
					<label>Задача</label>
					<textarea name="task" id="tsk" class="form-control" required></textarea>
				</div>
				<br>
				<div class="modal-footer">
					<input type="button" class="btn btn-secondary" data-dismiss="modal" value="Отмена">
					<input type="button" id="send" class="btn btn-primary" value="Отправить" />
			  	</div>				
			</form>
		  </div>
		  
		</div>
	  </div>
	</div>

	<br>
	
	<table id="data_table" class="table table-striped table-bordered" align="center">
        <thead>
            <tr>
                <th>Имя</th>
                <th>Электронная почта</th>
                <th>Задача</th>              
                <th>Ред.</th>
                <th>Подт.</th>
            </tr>
        </thead>
        <tbody id="data" class="data">
        </tbody>
        <tfoot>
            <tr>
                <th>Имя</th>
                <th>Электронная почта</th>
                <th>Задача</th>
                <th>Ред.</th>                
                <th>Подт.</th>
            </tr>
        </tfoot>
    </table>
</body>
</html>