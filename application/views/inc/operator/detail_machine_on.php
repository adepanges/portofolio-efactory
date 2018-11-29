			<?php

				$time_mulai = (int) $machine_kegiatan->time_mulai;
				$duration = (int) $machine_kegiatan->duration; // minutes
				$total_downtime = (int) $machine_kegiatan->total_downtime; // second

				$jam_mulai = '-';
				$time_durasi_selesai = 0;
				$time_estimasi_selesai = 0;
				$jam_estimasi_selesai = '-';
				$running = 0;
				$remaining = 0;

				if($time_mulai){
					$jam_mulai = date('d F Y H:i:s', $time_mulai);
					$running = (time()-$time_mulai);
					$time_durasi_selesai = ($duration*60)+$total_downtime;
					$time_estimasi_selesai = $time_mulai + $time_durasi_selesai;
					$remaining = $time_estimasi_selesai - time();
					$jam_estimasi_selesai = date('d F Y H:i:s',$time_estimasi_selesai);
				}
			?>


			<?php
				$show_button_end_dt = false;
				if(!empty($machine_down_time)){
					$show_button_end_dt = true;
				}
			?>

			<?php if($show_button_end_dt){ ?>
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<button class="btn input-lg btn-success form-control" id="btnEndDT">End Down Time</button>
					</div>
				</div>
			</div>
			<?php } ?>


			<div class="row">
				<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
		              <div class="box box-widget widget-user">
		                
		                <div class="widget-user-header <?php echo bg_warna($machine->status_mesin) ?>" style="height: 100px;">
		                	<div class="row">
		                		<div class="col-md-8 col-xs-12">
				                  <h3 class="widget-user-username">Mesin <b><?php echo $machine->kode_mesin ?></b></h3>
				                  <h5 class="widget-user-desc"><?php echo status_mesin($machine->status_mesin) ?></h5>
		                		</div>
		                		<div class="col-sm-4 col-xs-12">
			                        <span id="remainingTime" style="font-size: 14px; font-weight: bolder;"></span><br>
			                        <span class="description-text">Remaining Time</span>
			                    </div>
		                	</div>
		                </div>
		                <div class="widget-user-image">
		                  <img class="img-circle" src="<?php echo $this->config->item('base_client_images') ?>photo/machine.png" alt="User Avatar">
		                </div>
		                <div class="box-footer <?php echo bg_warna($machine->status_mesin) ?>" style="height: 350px;">
		                  <div class="row fl_bottom">
			                  <div class="row">
			                    <div class="col-sm-6 border-right" style="height: 100px;">
			                      <div class="description-block">
			                        <h5 class="description-header"><?php echo $jam_mulai ?></h5>
			                        <span class="description-text">Started</span>
			                      </div>
			                    </div>

			                    <div class="col-sm-6 border-right" style="height: 100px;">
			                      <div class="description-block">
			                        <h5 class="description-header"><?php echo $jam_estimasi_selesai ?></h5>
			                        <span class="description-text">Estimated</span>
			                      </div>
			                    </div>
			                   </div>
			                   <div class="row">
			                    <div class="col-sm-12 border-right" style="height: 100px;">
			                      <div class="description-block">
			                        <h5 class="description-header"><span id="runningTime"></span></h5>
			                        <span class="description-text">Running Time</span>
			                      </div>
			                    </div>
			                   </div>

		                    <div class="col-sm-12" style="height: 100px; "	>
		                      <div class="description-block">
		                        <div class="row">
		                        		<div class="col-md-6 col-xs-12">
		                        			<button class="btn btn-lg btn-success" id="btnStartMachine">START MACHINE</button>
		                        			<button class="btn btn-lg btn-primary" id="btnPauseMachine">PAUSE MACHINE</button>
		                        		</div>
		                        		<div class="col-md-6 col-xs-12">
		                        			<button class="btn btn-lg btn-danger" id="btnStopMachine">STOP MACHINE</button>
		                        		</div>
		                        </div>
		                      </div>
		                    </div>
		                  </div>
		                </div>
		              </div>
		            </div>

		          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" id="side_problem">
		          	<div class="box box-danger">
		          		<div class="box-header with-border">
		          			<h3 class="box-title">Down Time</h3>
		          		</div>
			          	<div class="box-body">
			          		<div class="row">
			          			<form action="<?php echo site_url() ?>/operator/app/machine_add_downtime" method="POST" id="form_problem">
				          			<div class="col-md-12">
				          				<div class="form-group">
				          					<label>Chose Down Time</label>
				          					<select class="form-control input-lg" name="id_problem" required="true">
				          						<option value=""></option>
				          						<?php
				          							$type_now = 0;
					          						foreach ($problem as $d) {
					          							if($time_mulai==0 && $d->type!=1){
					          								continue;
					          							}

					          							if($d->type!=$type_now){
					          								$teks = '';
				          									if($d->type==1){
				          										$teks = 'Planned Down Time';
				          									} else if($d->type==2){
				          										$teks = 'Unplanned Down Time';
				          									}
		          											echo '<option value="">'.$teks.'</option>';

					          								$type_now = $d->type;
					          							}

					          							echo '<option value="'.$d->id_problem.'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$d->nama_problem.'</option>';
					          						}
				          						?>
				          					</select>
				          				</div>
				          			</div>
				          			<div class="col-md-12">
				          				<div class="form-group">
				          					<label>Information</label>
				          					<textarea name="keterangan" class="form-control input-lg"></textarea>
				          				</div>
				          			</div>
				          			<div class="col-md-12">
				          				<input type="submit" value="Submit" class="form-control input-lg btn btn-danger">
				          			</div>
				          		</form>
			          		</div>
			          	</div>
		          	</div>
		          	<div class="col-sm-12" style="height: 100px;">
		                      <div class="box-group" id="accordion">
			                    <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
			                    <div class="panel box box-danger">
			                      <div class="box-header with-border">
			                        <h4 class="box-title">
			                          <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
			                            Down Time Found <span class="badge bg-red"><?php echo $machine_kegiatan_detail_count ?></span>
			                          </a>
			                        </h4>
			                      </div>
			                      <div id="collapseOne" class="panel-collapse collapse">
			                        <div class="box-body" style="color: #000; height: 200px; overflow-y: scroll;">
			                        		<table class="table tabler-bordered">
				                         	<?php $i = 1;
			          						foreach ($machine_kegiatan_detail as $d) {
			          							$type = '';
			          							if($d->type==1){
			          								$type = "PDT";
			          							} else if($d->type==2){
			          								$type = "UDT";
			          							}
			          							echo '<tr>';
			          							echo '<td>'.$i.'</td>';
			          							echo '<td>'.$d->nama_problem.'</td>';
			          							echo '<td>'.$type.'</td>';
			          							echo '</tr>';
			          							$i++;
			          						}
		          						?>
			                        		</table>
			                        </div>
			                      </div>
			                    </div>
			                   </div>
		                    </div>
		          </div>
			</div>
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>

			<div class="modal" id="modalConfirmStart">
	            <div class="modal-dialog">
	              <div class="modal-content">
	                <div class="modal-header">
	                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	                  <h4 class="modal-title">Konfirmasi</h4>
	                  </div>
	                <div class="modal-body">
	                  <p>Apakah anda yakin akan menghidupkan mesin ini?</p>
	                </div>
	                <div class="modal-footer">
	                  <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
	                  <button type="button" class="btn btn-success" id="yesConfirmStart">Start Machine</button>
	                </div>
	              </div>
	            </div>
	          </div>

			<div class="modal" id="modalConfirmStop">
	            <div class="modal-dialog">
	              <div class="modal-content">
	                <div class="modal-header">
	                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	                  <h4 class="modal-title">Konfirmasi</h4>
	                  </div>
	                <div class="modal-body">
	                  <p>Apakah anda yakin mematikan mesin ini?</p>
	                </div>
	                <div class="modal-footer">
	                  <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
	                  <button type="button" class="btn btn-danger" id="yesConfirmStop">Stop Machine</button>
	                </div>
	              </div>
	            </div>
	          </div>

			<script type="text/javascript">
				machine = {
					selected: <?php echo json_encode($machine) ?>,
					last_status: <?php echo $machine->status_mesin ?>,
					status: <?php echo $machine->status_mesin ?>,
					downtime: <?php echo json_encode($machine_down_time) ?>,
					time_mulai: <?php echo $time_mulai ?>,
					remaining: <?php echo $remaining ?>,
					running: <?php echo $running ?>
				}

				cek_status_machine = function(){
					var data;
					$.ajax({
		                    method: "POST",
		                    url: app.site_url+'/operator/app/cek_status_machine',
		                    data: { id_mesin: machine.selected.id_mesin }
		                  })
		                    .done(function( res ) {
		                      var obj = jQuery.parseJSON( res );
		                      if(obj.success){
		                        data = obj.data;
		                        if(data.status_mesin!=machine.last_status){
		                    		location.reload();
		                        }
		                      }
		                      un_mask_body();
		                    })
		                    .fail(function( res ) {
		                      un_mask_body();
		                    });
				}

				$(document).ready(function(){
					if(machine.status==1){
						$('#btnPauseMachine').hide();
						$('#btnStartMachine').show();

						$('#form_problem').find('.form-control').prop('disabled',false);
						$('#btnStopMachine').prop('disabled',true);

					} else if(machine.status==3 || machine.status==4){
						$('#btnPauseMachine').show();
						$('#btnStartMachine').hide();


						$('#form_problem').find('.form-control').prop('disabled',true);
						$('#btnStopMachine').prop('disabled',true);
						$('#btnPauseMachine').prop('disabled',true);
					} else {
						$('#btnPauseMachine').show();
						$('#btnStartMachine').hide();

						$('#form_problem').find('.form-control').prop('disabled',false);
						$('#btnStopMachine').prop('disabled',false);
						// $('#btnPauseMachine').prop('disabled',false);
						$('#btnPauseMachine').prop('disabled',true);
					}

					$('#btnEndDT').click(function(){
						var params = {
							id_detailkegiatan: machine.downtime.id_detailkegiatan,
							id_mesin: machine.selected.id_mesin,
							time_mulai: machine.time_mulai
						}
						mask_body();
						$.ajax({
			                    method: "POST",
			                    url: app.site_url+'/operator/app/machine_end_dt',
			                    data: params
			                  })
			                    .done(function( res ) {
			                      var obj = jQuery.parseJSON( res );
			                      un_mask_body();
			                      if(obj.success){
		                    		location.reload();
			                      }
			                    })
			                    .fail(function( res ) {
			                      un_mask_body();
			                    });
					});

					$('#btnStopMachine').click(function(){
						$('#modalConfirmStop').modal('show');
					});

					$('#btnStartMachine').click(function(){
						$('#modalConfirmStart').modal('show');
					});
					
					$('#yesConfirmStart').click(function(){
						$.ajax({
			                    method: "POST",
			                    url: app.site_url+'/operator/app/start_machine'
			                  })
			                    .done(function( res ) {
			                      var obj = jQuery.parseJSON( res );
			                      un_mask_body();
			                      if(obj.success){
		                    		location.reload();
			                      }
			                    })
			                    .fail(function( res ) {
			                      un_mask_body();
			                    });
					});

					$('#yesConfirmStop').click(function(){
						$.ajax({
			                    method: "POST",
			                    url: app.site_url+'/operator/app/stop_machine'
			                  })
			                    .done(function( res ) {
			                      var obj = jQuery.parseJSON( res );
			                      un_mask_body();
			                      if(obj.success){
		                    		location.reload();
			                      }
			                    })
			                    .fail(function( res ) {
			                      un_mask_body();
			                    });
					});
					
					$('#runningTime').html('-');
					$('#remainingTime').html('-');

					setInterval(function(){
						var m, s, h, time1, time2;
						if(machine.time_mulai!=0 && machine.status==2){
							machine.remaining--;
							machine.running++;

							h = Math.floor(machine.remaining/3600);
							m = Math.floor((machine.remaining-(h*3600))/60);
							s = machine.remaining-((h*3600)+(m*60));
							time1 = h+' Jam '+m+' Menit '+s+' Detik';

							h = Math.floor(machine.running/3600);
							m = Math.floor((machine.running-(h*3600))/60);
							s = machine.running-((h*3600)+(m*60));
							time2 = h+' Jam '+m+' Menit '+s+' Detik';

							$('#runningTime').html(time2);
							$('#remainingTime').html(time1);
						}
					}, 1000);

					setInterval(function(){
						cek_status_machine();
					}, 10000);
				});
			</script>