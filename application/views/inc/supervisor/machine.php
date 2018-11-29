          <div class="row">
            <div class="col-md-12">
              <select id="filterMachine" class="form-control input-lg text-center">
                <option value="0">All Status</option>
                <option value="1">Stoped</option>
                <option value="-1">Active</option>
                <option value="2">Running</option>
                <option value="3">Down Time</option>
                <option value="4">Down Time Confirm</option>
              </select>
            </div>
          </div>
          <br>

          <div class="row" id="placeMachineBox">

          </div>

          <div class="modal" id="modalConfirmProblemStart">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Konfirmasi</h4>
                  </div>
                  <div class="modal-body">
                    <p>Apakah anda yakin akan mengkonfirmasi Down Time ini?</p>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-warning" id="yesConfirmProblem">Confirm Down Time</button>
                  </div>
                </div><!-- /.modal-content -->
              </div><!-- /.modal-dialog -->
            </div>

            <div class="modal" id="modalConfirmResolvProblem">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Konfirmasi</h4>
                  </div>
                  <div class="modal-body">
                    <p>Apakah anda yakin akan meresolv problem ini?</p>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success" id="yesConfirmResolvProblem">End Down Time</button>
                  </div>
                </div><!-- /.modal-content -->
              </div><!-- /.modal-dialog -->
            </div>

          <div class="modal" id="modalDetailMachine">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title">Informasi Mesin</h4>
                </div>
                <div class="modal-body" style="margin: 10px;">
                  <div class="row">
                    <div class="col-md-12" style="font-size: 28px; font-weight: bolder; text-align: center; vertical-align: middle !important;">
                      Waktu Estimasi Selesai
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12 bg-green" id="modalDetailMachine-estimated" style="font-size: 28px; font-weight: bolder; text-align: center; vertical-align: middle !important;">
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Ok</button>
                </div>
              </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
          </div>

          <div class="modal" id="modalConfirmProblem">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Konfirmasi Mesin Down Time</h4>
                  </div>
                  <div class="modal-body" style="margin: 10px;">
                    <div class="row">
                      <div class="col-md-4 col-xs-12" id="modalConfirmProblem-mesin" style="font-size: 28px; font-weight: bolder; text-align: center; vertical-align: middle !important;">
                      </div>
                      <div class="col-md-8 col-xs-12">
                      <div class="row">
                          <div class="col-md-12 col-xs-12" id="modalConfirmProblem-type" style="font-weight: bolder; text-align: center; padding: 5px;">
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12 col-xs-12 bg-red" id="modalConfirmProblem-masalah" style="text-align: center; padding: 5px;">
                          </div>
                        </div>
                        <div class="row" style="margin-top: 10px;">
                          <div class="col-md-6 col-xs-12" id="modalConfirmProblem-ket-masalah" style="text-align: center;">
                          </div>
                          <div class="col-md-6 col-xs-12" id="modalConfirmProblem-ket-operator" style="text-align: center;">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-warning" id="confirmProblem">Confirm Down Time</button>
                    <button type="button" class="btn btn-success" id="resolvProblem">End Down Time</button>
                  </div>
                </div><!-- /.modal-content -->
              </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->

            <script type="text/javascript">
              machine = {};
              machine.all = <?php echo json_encode($mesin) ?>;
              machine.selected = {};
              machine.modif = [];
              machine.problem_detail = {};
              machine.filter = 0;
              machine.running = 0;
              machine.stopped = 0;
              machine.downtime = 0;
            </script>
            <script type="text/javascript" src="<?php echo base_url('media/app/supervisor.js'); ?>"></script>