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
			
			$("#submit_form").on( "submit", function(e) {

                    var formData = new FormData($(this)[0]);

                    $.ajax({
                        url: 'handler.php',
                        type: 'POST',
                        data: formData,
                        async: false,
                        success: function (data) {
                            alert(data);
							$("#name").val("");
							$("#email").val("");
							$("#tsk").val("");
							getData();
                        },
                        cache: false,
                        contentType: false,
                        processData: false
                    });

                    return false;

                });                
			setInterval(getData, 10000);
		});
		
		
		function populateDataTable(data) {
			var row = "";
			if(data.id != null) {
				
				$("#data").children().remove();
				for(var i = 0; i < data.id.length; i++) {
					
					row += '<tr>';
					row += '<td>' + data.name[i] + '</td>\
							<td>' + data.email[i] + '</td>';
							
					if(data.is_edited[i] == 1){
						row += '<td>' + data.task[i] + '<br><sub>отредактировано администратором</sub></td>';
					}else{
						row += '<td>' + data.task[i] + '</td>';
					}
					
					if(data.is_done[i] == 1){
						row += '<td>Выполнено</td>';
					}else{
						row += '<td>Не выполнено</td>';
					}
					row += '</tr>';
					
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
				url: 'handler.php',
				type: 'POST',	
				cache: false,
				data: {"getFlagAll": true},
				dataType: 'JSON',
				success: function (data) {
					$("#data_table").DataTable().destroy();
					populateDataTable(data);					
				},error: function (xhr, ajaxOptions, thrownError) {
						console.log(xhr);
						console.log(ajaxOptions);
						console.log(thrownError);
					  }
			});
		}
	</script>
	<style>
		.dataTables_wrapper {
			width: 80%;
			margin-left:auto; 
    		margin-right:auto;
		}
	</style>
</head>

<body>
	<div align="right" style="margin: 10px;">
		<a href="admin/index.php">Авторизация</a>
	</div>
	<div align="center">
		<form enctype="multipart/form-data" id="submit_form" class="col-md-12" style="width: 100%">
			<div class="form-group col-sm-4">
				<label for="name">Имя</label>
				<input type="text" name="nm" class="form-control" id="name" required>
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
			<input type="submit" id="send" class="btn btn-primary" value="Отправить" />
		</form>
	</div>
	<br>
	<br>
	<br>
	
	<table id="data_table" class="table table-striped table-bordered" align="center">
        <thead>
            <tr>
                <th>Имя</th>
                <th>Электронная почта</th>
                <th>Задача</th>          
                <th>Статус</th>                
            </tr>
        </thead>
        <tbody id="data">
        </tbody>
        <tfoot>
            <tr>
                <th>Имя</th>
                <th>Электронная почта</th>
                <th>Задача</th>
                <th>Статус</th>
            </tr>
        </tfoot>
    </table>
	
</body>
</html>