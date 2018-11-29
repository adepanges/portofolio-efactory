renderMachineControlBox = function(filterMachine) {
  machine.running = 0;
  machine.stopped = 0;
  machine.downtime = 0;

  $('#place_notif').html('');

  var html_str = '';
  var filterMachine = filterMachine || 0;

  machine.modif = [];
  mask_body();
  $('#placeMachineBox').html('');

  for (i = 0; i < machine.all.length; i++) {
    dt = machine.all[i];
    if (filterMachine == 0) {
      html_str += generate_html(dt);
    } else if (dt.status_mesin == filterMachine) {
      html_str += generate_html(dt);
    } else if (filterMachine == -1 && dt.status_mesin != 1) {
      html_str += generate_html(dt);
    }

  }
  $('#placeMachineBox').html(html_str);

  $('#modalConfirmProblemStart').modal('hide');
  $('#modalConfirmResolvProblem').modal('hide');
  $('#modalConfirmProblem').modal('hide');
  un_mask_body();
}

generate_html = function(dt) {
  machine.modif[dt.idcmp] = dt;
  var blink = '';
  var btn = '';
  var operated = '';
  if (dt.status_mesin == 1) {
    machine.stopped++;
  } else if (dt.status_mesin == 2) {
    machine.running++;
    btn = '<button class="btn btn-lg btn-default btn-confirm-problem" onclick=btnDetailMachine("' + dt.idcmp + '")>Detail</button>';
  } else if (dt.status_mesin == 3) {
    machine.downtime++;
    bootstrap_alert('Peringatan', 'Mesin ' + dt.kode_mesin + ' sedang Down Time', 'btnConfirmProblem("' + dt.idcmp + '","confirm")');
    blink = 'warning_blink';
    btn = '<button class="btn btn-lg btn-warning btn-confirm-problem" onclick=btnConfirmProblem("' + dt.idcmp + '","confirm")>Confirm Down Time</button>';
  } else if (dt.status_mesin == 4) {
    btn = '<button class="btn btn-lg btn-default btn-confirm-problem" onclick=btnConfirmProblem("' + dt.idcmp + '","resolv")>Detail</button>';
  }
  if (dt.id_user != null) {
    operated = '<div class="row" style="margin-bottom: 5px;">Operated by ' + dt.nama + ' (' + dt.username + ')</div>';
  }

  var html_str = '<div class="machine-box col-lg-3 col-md-4 col-sm-6 col-xs-12 ' + blink + '" id="' + dt.idcmp + '">' +
    ' <div class="box box-widget widget-user">' +
    '   <div class="widget-user-header ' + bg_warna(dt.status_mesin) + '">' +
    '     <h3 class="widget-user-username">Mesin <b>' + dt.kode_mesin + '</b></h3>' +
    '     <h5 class="widget-user-desc">' + status_mesin(dt.status_mesin) + '</h5>' +
    '   </div>' +
    '   <div class="widget-user-image">' +
    '     <img class="img-circle" src="' + app.base_client_images + 'photo/machine.png" alt="User Avatar">' +
    '   </div>' +
    '   <div class="box-footer ' + bg_warna(dt.status_mesin) + '">' +
    '     <div class="row">' +
    '       <div class="col-sm-12 border-right" style="height: 90px;">' +
    '         <div class="description-block">' + operated +
    '           <div class="row">' + btn + '</div>' +
    '         </div>' +
    '       </div>' +
    '     </div>' +
    '   </div>' +
    ' </div>' +
    '</div>';
  return html_str;
}

bg_warna = function(id = 0) {
  var id = parseInt(id);

  switch (id) {
    case 1:
      out = 'bg-gray';
      break;

    case 2:
      out = 'bg-green';
      break;

    case 3:
      out = 'bg-red';
      break;

    case 4:
      out = 'bg-yellow';
      break;

    default:
      out = '';
      break;
  }
  return out;
}

status_mesin = function(id = 0) {
  var id = parseInt(id);
  switch (id) {
    case 1:
      out = 'Stopped';
      break;

    case 2:
      out = 'Running';
      break;

    case 3:
      out = 'Down Time';
      break;

    case 4:
      out = 'Down Time is Confirmed';
      break;

    default:
      out = '';
      break;
  }
  return out;
}

btnDetailMachine = function(arg) {
  var data = machine.modif[arg];
  machine.selected = data;
  console.log(data);

  if (data.id_keg != '') {
    mask_body();
    $.ajax({
        method: "POST",
        url: app.site_url + '/supervisor/app/get_detail_machine',
        data: {
          id_keg: data.id_keg
        }
      })
      .done(function(res) {
        var obj = jQuery.parseJSON(res);
        if (obj.success) {
          var data = obj.data;
          $('#modalDetailMachine-estimated').html(data.estimated);
          $('#modalDetailMachine').modal('show');
        }
        un_mask_body();
      })
      .fail(function(res) {
        un_mask_body();
      });
  }
}

btnConfirmProblem = function(arg, confirm) {
  var confirm = confirm;
  var action_confirm = 1;
  if (confirm == 'confirm') {
    $('#confirmProblem').show();
    $('#resolvProblem').hide();
  } else if (confirm == 'resolv') {
    action_confirm = 0;
    $('#confirmProblem').hide();
    $('#resolvProblem').show();
  } else {
    action_confirm = 0;
    $('#confirmProblem').hide();
    $('#resolvProblem').hide();
  }
  var data = machine.modif[arg];
  machine.selected = data;

  if (data.id_keg != '') {
    mask_body();
    $.ajax({
        method: "POST",
        url: app.site_url + '/supervisor/app/get_machine_problem',
        data: {
          id_keg: data.id_keg,
          action_confirm: action_confirm
        }
      })
      .done(function(res) {
        var obj = jQuery.parseJSON(res);
        if (obj.success) {
          machine.problem_detail = obj.data;
          var type = '';
          var type_int = parseInt(obj.data.type);
          if (type_int == 1) {
            type = "Planned Down Time";
            $('#resolvProblem').hide();
          } else if (type_int == 2) {
            type = "Unplanned Down Time";
          }
          $('#modalConfirmProblem-type').html(type);

          $('#modalConfirmProblem-mesin').html(data.nama_mesin);
          $('#modalConfirmProblem-masalah').html(obj.data.nama_problem);
          $('#modalConfirmProblem-ket-masalah').html(obj.data.keterangan_problem);
          $('#modalConfirmProblem-ket-operator').html(obj.data.keterangan_detailkeg);
          $('#modalConfirmProblem').modal('show');
        }
        un_mask_body();
      })
      .fail(function(res) {
        un_mask_body();
      });
  }
}

get_new_data = function() {
  $.ajax({
      method: "POST",
      url: app.site_url + '/supervisor/app/get_machine_ajax'
    })
    .done(function(res) {
      var obj = jQuery.parseJSON(res);
      un_mask_body();
      if (obj.success) {
        machine.all = obj.data;
        $('#filterMachine').val(0);
        renderMachineControlBox();
      }
    })
    .fail(function(res) {
      un_mask_body();
    });
}

$(document).ready(function() {
  renderMachineControlBox();

  $('#filterMachine').change(function() {
    var id = $(this).val();
    renderMachineControlBox(id);
    machine.filter = id;
  });

  $('#placeMachineBox').delegate('.machine-box', 'click', function() {
    $(this).removeClass('warning_blink');
  });

  $('#confirmProblem').click(function() {
    $('#modalConfirmProblemStart').modal('show');
  });

  $('#yesConfirmProblem').click(function() {
    var param = {
      id_mesin: machine.selected.id_mesin,
      id_detailkegiatan: machine.problem_detail.id_detailkegiatan
    }
    $.ajax({
        method: "POST",
        url: app.site_url + '/supervisor/app/confirm_problem',
        data: param
      })
      .done(function(res) {
        var obj = jQuery.parseJSON(res);
        un_mask_body();
        if (obj.success) {
          get_new_data()
        }
      })
      .fail(function(res) {
        un_mask_body();
      });
  });

  $('#resolvProblem').click(function() {
    $('#modalConfirmResolvProblem').modal('show');
  });

  $('#yesConfirmResolvProblem').click(function() {
    var param = {
      id_mesin: machine.selected.id_mesin,
      id_detailkegiatan: machine.problem_detail.id_detailkegiatan
    }
    $.ajax({
        method: "POST",
        url: app.site_url + '/supervisor/app/resolv_problem',
        data: param
      })
      .done(function(res) {
        var obj = jQuery.parseJSON(res);
        un_mask_body();
        if (obj.success) {
          get_new_data()
        }
      })
      .fail(function(res) {
        un_mask_body();
      });
  });

  setInterval(function() {
    $.ajax({
        method: "POST",
        url: app.site_url + '/supervisor/app/cek_machine',
      })
      .done(function(res) {
        var obj = jQuery.parseJSON(res);
        un_mask_body();
        if (obj.success) {
          var count1 = parseInt(obj.machine_stopped);
          var count2 = parseInt(obj.machine_running);
          var count3 = parseInt(obj.machine_downtime);
          if (count1 != machine.stopped || count2 != machine.running || count3 != machine.downtime) {
            get_new_data();
          }
        }
      })
      .fail(function(res) {
        un_mask_body();
      });
  }, 20000);

  $(document).on('show.bs.modal', '.modal', function() {
    var zIndex = 1040 + (10 * $('.modal:visible').length);
    $(this).css('z-index', zIndex);
    setTimeout(function() {
      $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
    }, 0);
  });

});