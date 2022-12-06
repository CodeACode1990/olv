<?php
	function base_url($url=null) {
		$localIP = "10.84.10.163";
		$base_url = "http://".$localIP."/olv";
		//olv_die($base_url);
		if($url != null) {
			return $base_url."/".$url;
		} else {
			return $base_url;
		}
	}

	function print_var_name($var) {
		foreach($GLOBALS as $var_name => $value) {
			if ($value === $var) {
				return $var_name;
			}
		}

		return false;
	}

	function olv_dump($var){
		echo 'Variable Name ==> <b>'.print_var_name($var).'</b><br/>';
		echo'<pre>';
		var_dump($var);
		echo'</pre>';
		
		echo '<br/>';
		echo 'File : '.debug_backtrace()[0]['file'];
		echo '<br/>';
		echo 'Line : '.debug_backtrace()[0]['line'];
		
		echo '<hr/>';
		echo '<br/><br/>';
	}
	
	function olv_die($var){
		olv_dump($var);
		die();
	}

	function connect_to_database($db){
		$servername = "localhost";
		$username = "root";
		$password = "";
		$dbname = $db;

		// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);
		// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}else{
			return $conn;
		}

		//olv_dump($servername);

	}

	function deleteFiles($directory){
		foreach(glob("{$directory}/*") as $file)
		{
			if(is_dir($file)) { 
				recursiveRemoveDirectory($file);
			} else {
				unlink($file);
			}
		}
		rmdir($directory);
	}

	function olv_debug($variable){
		file_put_contents('log.txt', print_r("\n- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -\n",true), FILE_APPEND);
		file_put_contents('log.txt', print_r($variable,true), FILE_APPEND);
	}

	function createButton($arr){
		$button_d="";
		$btnActive = $arr["buttons"]["create"]["active"];
		//olv_dump($btnActive);
		if( $btnActive=="on" || isset($btnActive) ){
			$button_d = '<button type="button" class="shadow p-2 btn btn-success ml-4 mt-5 pl-5 pr-5" data-toggle="modal" data-target="#modalCreate" >Tambah Data</button>';
		}else{
			$button_d = "";
		}

		return $button_d;
	}

	function generateTable( $arr ){

		//olv_die($arr);
		$con = connect_to_database("information_schema");
    	$sql_get_columns = mysqli_query( $con,"SELECT * FROM COLUMNS WHERE TABLE_NAME='".$arr["table_name"]."'" ) or die (mysqli_error($con));
		
		$arr_columns = [];
		while($d =  mysqli_fetch_array($sql_get_columns)){
			array_push( $arr_columns, $d["COLUMN_NAME"] );
		}

		// olv_die($arr_columns);
?>
		<!-- Tambah Data modal -->
		<div class="modal fade" id="modalCreate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel" >Tambah Data</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form>
							<div class="form-group" id="modal_fields_list_insert">
								<table>
								<?php
									foreach ($arr_columns as $column) {

										echo"
											<tr>
												<td>  <b>$column </b>  </td>
												<td> <b style='margin:0px 5px 0px 5px;'>:</b> </td>
												<td> <input type='text' class='mod_cre_inp' id=inp_".$column." > </td>
											</tr>
										";
									}
								?>
								</table>

							</div>

							<!-- <div class="form-group">
								<label for="recipient-name" class="col-form-label">Plat Nomor:</label>
								<input id="inp_plat" type="text" class="form-control" id="recipient-name">
							</div> -->
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
						<button id="btn_tambahKendaraann" type="button" class="btn btn-info">Tambahkan Data</button>
					</div>
				</div>
			</div>
		</div>
		
		<?php
		 	echo createButton($arr);
		?>


		<script>
			$(document).ready(function(){
				//var inp_id_ent;

				$(document).on('click', '#btn_tambahKendaraann', function(event){

					var arr_fields	= [];
					var fields_length = <?= count($arr_columns) ?>;
					var arr = $('.mod_cre_inp');

					for(var i = 0; i < arr.length; i++){
						arr_fields.push( $(arr[i]).val() )
					}

					//console.log(arr_fields)

					var tbl_name	= "<?= $arr['table_name'] ?>";

					var form_data = new FormData();

					form_data.append('fields_length',fields_length);
					form_data.append('arr_fields',arr_fields);
					form_data.append('tbl_name',tbl_name);

					$.ajax({
						url : '<?= base_url('create.php') ?>',
						type : 'POST',
						data : 	form_data,
						cache : false,
						contentType : false,
						processData : false,
						success: function(dataResult){
									var dataResult = JSON.parse(dataResult);
									
									if(dataResult.statusCode==200){	
										location.reload(true);
									}
									else if(dataResult.statusCode==201){
										alert('create error');
									}

								}
					});
					
					
				});

			});
		</script>

		<!-- Edit Modal -->
		<div class="modal fade" id="modal_edit_kendaraan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">
						#<span id="inp_id"></span>   
						Edit Data : 
					</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form>
						<div class="form-group" id="modal_fields_list_ed">

							<table>
							<?php
								foreach ($arr_columns as $column) {

									echo"
										<tr>
											<td>  <b>$column </b>  </td>
											<td> <b style='margin:0px 5px 0px 5px;'>:</b> </td>
											<td> <input type='text' class='mod_ed_inp' id=inp_ed_".$column." > </td>
										</tr>
									";
								}
							?>
							</table>

						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button id="btn_no_edit_kendaraan" type="button" class="btn btn-danger" data-dismiss="modal"><span class="ml-5"></span>Tidak, Jangan Edit !<span class="ml-5"/></button>
					<button id="btn_yes_edit_kendaraan" type="button" class="btn btn-info">Ya, Update Data !</button>
				</div>
				</div>
			</div>
		</div>

		<!-- Delete Modal -->
		<div class="modal fade" id="modal_delete_kendaraan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">
						#<span id="inp_id"></span>   
						Yakin ingin menghapus data ini ? 
					</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form>
						<div class="form-group" id="modal_fields_list">
							
							<?php
								foreach ($arr_columns as $column) {
									echo"<b>$column :</b><span class='mod_del_inp' id=inp_".$column.">cek</span> <br/>";
								}
							?>

						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button id="btn_no_delete_kendaraan" type="button" class="btn btn-danger" data-dismiss="modal"><span class="ml-5"></span>Tidak, Jangan Hapus !<span class="ml-5"/></button>
					<button id="btn_yes_delete_kendaraan" type="button" class="btn btn-success">Ya, Hapus Data !</button>
				</div>
				</div>
			</div>
		</div>
		<!-- <div class="shadow p-1 mb-5  rounded mt-4 mr-4 ml-4"> -->
			<!-- <button type="button" class="shadow p-2 btn btn-success ml-4 mt-5 pl-5 pr-5"  data-toggle="modal" data-target="#exampleModalCenter" data-whatever="@fat"><b>Tambah Data</b></button> -->


			<div class="shadow p-3 mb-5 bg-white rounded mt-4 mr-4 ml-4">
				<table id="tabel-data-log" class="display table table-striped table-bordered nowrap" style="width:100%">
					<thead>
						<tr>

							<?php
								//olv_die($arr_columns);
								echo" <th> No. </th> ";
								foreach ($arr_columns as $column) {
									?>
										<th> <?= $column ?> </th>
									<?php
								}
								echo" <th>  </th> ";
							?>
						</tr>
					</thead>
					<tbody>
						<?php
							$con = connect_to_database("ut_manado_olv");
							$sql = mysqli_query( $con,"SELECT * FROM ".$arr['table_name']." ORDER BY id DESC" ) or die (mysqli_error($con));
							//olv_die($sql);
							$num = 1;
							while($d =  mysqli_fetch_array($sql)){
						?>
 
						<?php
								echo " <tr class='tr_parent'> ";
									echo "<td>$num</td>";
									foreach ($arr_columns as $column) {
										?>
											<td id="td_<?= $column ?>_<?= $d['id'] ?>" class="fields_with_data" style="white-space: normal !important;"> <span class="sp_w_data"> <?= $d[$column] ?></span> </td>
										<?php
									}
									echo "	<td>
												<button type='button' class='btn btn-info btn_edit_s_s'     data-toggle='modal' data-target='#modal_edit_kendaraan'>Edit</button>
												<button type='button' class='btn btn-danger btn_hapus_s_s'  data-toggle='modal' data-target='#modal_delete_kendaraan'>Hapus</button>
											</td>";
								echo " </tr> ";
								$num++;
							}
						?>
						
						
						<script>
							$(document).ready(function(){
								var inp_id_ent;
								// btn hapus handling
									$(document).on('click', '.btn_hapus_s_s', function(event){
										
											var par_cl_child = $(this).closest("ul").length;

										// if its parent      == HAS ==       "siblings class named child" (on responsive mode)
											if(par_cl_child){
												var spw_of_sibs = $(this).closest("tr.child").prev().find(".sp_w_data");
												
												for (let i = 0; i<spw_of_sibs.length; i++) {
													$('#modal_fields_list').children('span').eq(i).text( spw_of_sibs.eq(i).text() );

													if( i==0 ){
														inp_id_ent = spw_of_sibs.eq(0).text()
													}
												}
											}
										// if its parent      == HAS NO ==      "siblings class named child"  (on desktop mode)
											else{
												var child_length = $('#modal_fields_list').children('span').length;
												var fields_with_data_length = $(this).closest("tr").find(".sp_w_data");
												//console.log( fields_with_data_length.eq(1).text() );
												console.log(child_length);
												for (let i = 0; i<child_length; i++) {
													
													$('#modal_fields_list').children('span').eq(i).text( fields_with_data_length.eq(i).text() );
													
													if( i==0 ){
														inp_id_ent = fields_with_data_length.eq(0).text()
													}

												}
											}
											
									});

									
									$(document).on('click', '#btn_yes_delete_kendaraan', function(event){
										
										var id	= inp_id_ent;
										var tbl_name	= "<?= $arr['table_name'] ?>";

										var form_data = new FormData();

										form_data.append('id',id);
										form_data.append('tbl_name',tbl_name);

										$.ajax({
											url : '<?= base_url('delete.php') ?>',
											type : 'POST',
											data : 	form_data,
											cache : false,
											contentType : false,
											processData : false,
											success: function(dataResult){
														var dataResult = JSON.parse(dataResult);
														
														if(dataResult.statusCode==200){	
															location.reload(true);
														}
														else if(dataResult.statusCode==201){
															alert('Delete error');
														}

													}
										});
										
										
									});


								// btn edit handling
									$(document).on('click', '.btn_edit_s_s', function(event){
											
											var par_cl_child = $(this).closest("ul").length;
											
										// if its parent      == HAS ==       "siblings class named child" (on responsive mode)
											if(par_cl_child){
												var spw_of_sibs = $(this).closest("tr.child").prev().find(".sp_w_data");
												
												for (let i = 0; i<spw_of_sibs.length; i++) {
													$('#modal_fields_list_ed').find('.mod_ed_inp').eq(i).val( spw_of_sibs.eq(i).text() );

													if( i==0 ){
														inp_id_ent = spw_of_sibs.eq(0).text()
													}
												}
											}
										// if its parent      == HAS NO ==      "siblings class named child"  (on desktop mode)
											else{
												var child_length = $('#modal_fields_list_ed').find('.mod_ed_inp').length;
												var fields_with_data_length = $(this).closest("tr").find(".sp_w_data");

												for (let i = 0; i<child_length; i++) {
													
													$('#modal_fields_list_ed').find('.mod_ed_inp').eq(i).val( fields_with_data_length.eq(i).text() );
													
													if( i==0 ){
														inp_id_ent = fields_with_data_length.eq(0).text()
													}

												}
											}
											
									});


									$(document).on('click', '#btn_yes_edit_kendaraan', function(event){
										var id	= inp_id_ent;
										var arr_fields	= [];
										var fields_length = <?= count($arr_columns) ?>;
										var arr = $('.mod_ed_inp');

										var columns_list = []

										for(var i = 0; i < arr.length; i++){
											arr_fields.push( $(arr[i]).val() )
										}

										//store php array to js array
										<?php foreach($arr_columns as $arr_column){ ?>
											columns_list.push('<?= $arr_column ?>');
										<?php } ?>

										var tbl_name	= "<?= $arr['table_name'] ?>";

										var form_data = new FormData();

										form_data.append('id',id);
										form_data.append('fields_length',fields_length);
										form_data.append('arr_fields',arr_fields);
										form_data.append('columns_list',columns_list);
										form_data.append('tbl_name',tbl_name);

										$.ajax({
											url : '<?= base_url('update.php') ?>',
											type : 'POST',
											data : 	form_data,
											cache : false,
											contentType : false,
											processData : false,
											success: function(dataResult){
														var dataResult = JSON.parse(dataResult);
														
														if(dataResult.statusCode==200){	
															location.reload(true);
														}
														else if(dataResult.statusCode==201){
															alert('create error');
														}

													}
										});


									});


							});
						</script>


					</tbody>

					

				</table>

				<!-- <div style='width:500px; height:200px; word-wrap:break-word;'> 
				This div contains a very long word: thisisaveryveryveryveryveryverylongword. The long word will break and wrap to the next line This div contains a very long word: thisisaveryveryveryveryveryverylongword. The long word will break and wrap to the next line This div contains a very long word: thisisaveryveryveryveryveryverylongword. The long word will break and wrap to the next line This div contains a very long word: thisisaveryveryveryveryveryverylongword. The long word will break and wrap to the next line
				</div> -->

				<script>
					$(document).ready(function(){
						
						var tabelData = olvDataTable('#tabel-data-log');
						
					});
				</script>
			</div>
		<!-- </div> -->
<?php
	}
	
?>