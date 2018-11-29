          <div class="row">

          <?php foreach ($mesin as $d) { /*echo $d['status_mesin'].' -> '.islogin_mesin($d['status_mesin'])."<br>";*/ ?>
            
          <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
              <div class="box box-widget widget-user">
                
                <div class="widget-user-header <?php echo bg_warna($d['status_mesin']) ?>">
                  <h3 class="widget-user-username">Mesin <b><?php echo $d['kode_mesin'] ?></b></h3>
                  <h5 class="widget-user-desc"><?php echo status_mesin($d['status_mesin']) ?></h5>
                </div>
                <div class="widget-user-image">
                  <img class="img-circle" src="<?php echo $this->config->item('base_client_images') ?>photo/machine.png" alt="User Avatar">
                </div>
                <div class="box-footer <?php echo bg_warna($d['status_mesin']) ?>">
                  <div class="row">
                    <div class="col-sm-12 border-right">
                      <div class="description-block">
                        <button class="btn btn-warning startMachine"><input type="hidden" value='<?php echo json_encode($d) ?>'>Operated</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          <?php } ?>
          </div>

          <div class="modal" id="modalConfirmStart">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Konfirmasi</h4>
                  </div>
                  <div class="modal-body">
                    <p>Apakah anda yakin akan memulai mesin <span id="namaMachineStart" style="font-weight: bold;"></span> &hellip; ?</p>
                    <div class="row">
                      <div class="col-md-6 col-xs-12">
                        <div class="form-group">
                          <label>Batch Code</label>
                          <input type="text" class="form-control input-lg" id="operated-kode_batch" name="kode_batch" required="true">
                        </div>
                      </div>
                      <div class="col-md-6 col-xs-12">
                        <div class="form-group">
                          <label>Product</label>
                          <select class="form-control input-lg" id="operated-id_product" name="id_product" required="true">
                            <option value=""></option>
                            <?php
                              foreach ($product as $d) {
                                echo '<option value="'.$d->id_product.'">'.$d->product_name.'</option>';
                              }
                            ?>
                          </select>
                        </div>
                      </div>
                    </div>
                    <span style="color: #F00;" id="operated-msg-error"></span>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-warning" id="yesStartMachine">Operated Mesin</button>
                  </div>
                </div><!-- /.modal-content -->
              </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->

            <script type="text/javascript">
              machine = {};
              machine.selected = {}

              $(document).ready(function(){

                $('.startMachine').click(function(){
                  var data = $(this).find('input').val();
                  data = jQuery.parseJSON( data );
                  machine.selected = data;
                  $('#namaMachineStart').html(data.nama_mesin);
                  $('#modalConfirmStart').modal();
                });

                $('#yesStartMachine').click(function(){
                  var id = parseInt(machine.selected.id_mesin);
                  var kode_batch = $('#operated-kode_batch').val();
                  var id_product = $('#operated-id_product').val();
                  if(id!=0 && kode_batch!='' && id_product != ''){
                    $('#operated-msg-error').html('');
                    $.ajax({
                        method: "POST",
                        url: app.site_url + '/operator/app/operate_machine/'+id,
                        data: {kode_batch: kode_batch, id_product: id_product}
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
                  } else {
                    $('#operated-msg-error').html('Inputan tidak lengkap, lengkapi form terlebih dahulu');
                  }
                });
              });
            </script>