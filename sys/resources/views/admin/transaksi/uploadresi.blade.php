@extends('admin.part.template')

@section('content')     
        <div class="content-wrapper">
          <div class="page-header">
            <h3 class="page-title">
              Transaksi
            </h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">Transaksi</li>
              </ol>
            </nav>
          </div>
          <div class="row">

          @if (session('success'))
            <div class="col-12">
              <div class="alert alert-success">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                  {{ session('success') }}
              </div>
            </div>
          @endif

          @if(count($errors))
            <div class="col-12">
              <div class="alert alert-danger">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <ul>
                  @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                  @endforeach
                </ul>
              </div>
            </div>
          @endif
            
          <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title">Daftar Transaksi (Proses)</h4>
                <p class="card-description">
                  Semua daftar transaksi yang sedang dalama proses.
                </p>
                <button class="btn btn-primary btn-sm mb-2" id="cetakSemua">Cetak</button>
                <div class="table-responsive">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th></th>
                      <th>Invoice</th>
                      <th>Total</th>
                      <th>Date</th>
                      <th>No Resi</th>
                      <th>Cetak</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php $x=1 ?>
                  @foreach ($transaksi as $data)
                    <tr class="upload-resi">
                      <td><input type="checkbox" name="print" value="{{$data->transaksi_id}}"></td>
                      <td>INV{{$data->transaksi_id}}</td>
                      <td>{{$data->total_transaksi}}</td>
                      <td>{{$data->created_at}}</td>
                      <td>
                      @if(empty($data->no_resi))
                        <div class="d-flex">
                          <input type="text" name="resi" class="form-control">
                          <button data-id="{{$data->transaksi_id}}" class="btn btn-sm btn-warning btn-upload" onclick="return confirm('No resi yang anda masukan sudah benar?')">Proses</button> &nbsp;
                        </div>
                      @else
                        <div class="d-flex">
                          <input type="text" name="resi" class="form-control" value="{{$data->no_resi}}" disabled>
                          &nbsp;<button data-id="{{$data->transaksi_id}}" class="btn btn-warning btn-rounded btn-sm p-2 btn-edit"><i class="mdi mdi-border-color"></i></button>
                          &nbsp;<button data-resi="{{$data->no_resi}}" class="btn btn-primary btn-rounded btn-sm p-2 btn-cek"><i class="mdi mdi-magnify"></i></button>
                          &nbsp;<button data-id="{{$data->transaksi_id}}" class="btn btn-success btn-rounded btn-sm p-2 btn-confirm"><i class="mdi mdi-check"></i></button>
                        </div>
                      @endif
                      </td>
                      <td>
                        <a
                          href="javascript: w=window.open('cetak/{{$data->transaksi_id}}'); w.print(); "
                          target="_blank" class="btn btn-sm btn-danger"><i class="mdi mdi-printer"></i></a> &nbsp;
                      </td>
                    </tr>
                  @endforeach
                  </tbody>
                </table>
                </div>
                
                <div class="mt-4">
                  {{ $transaksi->links() }}
                </div>
              </div>
            </div>
          </div>

          </div>
        </div>
        <!-- content-wrapper ends -->

        <!-- Modal -->
        <div class="modal fade" id="cekResi" tabindex="-1" role="dialog" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Cek Resi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">

                <!-- Content Generate From Ajax -->
                <div class="info-pengiriman"></div>

              </div>
              <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
@endsection

@push('js')
<script>
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
      }
  });

  $(".upload-resi .btn-upload").click(function(){
    serializeData = {
      id: $(this).data('id'),
      resi: $(this).parent().parent().find('input[name="resi"]').val()
    }
    $.post("{{ route('resi.upload') }}", serializeData, function(data){
      location.reload();
    })
  });

  $(".btn-cek").click(function(){
    let noresi = $(this).parent().parent().find('input[name="resi"]').val();
    $.get("{{ url('admin-panel/transaksi/resi/cek') }}"+'/'+ noresi, function(data){
      console.log(data);
      var manifest ="";
      // Manifest
      for(var x=0; x<data["manifest"].length; x++){
        manifest += `<tr>
                    <td>`+data["manifest"][x]["manifest_date"]+`</td>
                    <td>`+data["manifest"][x]["manifest_description"]+`</td>
                  </tr>`;
      }

      html =`<h4 class="text-center">Expedisi JNE</h4>
              <b>I. Informasi Pengiriman</b>
              <table class="table">
                <tbody>
                  <tr>
                    <td>No Resi</td>
                    <td>:</td>
                    <td><b>`+data["summary"]["waybill_number"]+`</b></td>
                  </tr>
                  <tr>
                    <td>Status</td>
                    <td>:</td>
                    <td><b>`+data["summary"]["status"]+`</b></td>
                  </tr>
                  <tr>
                    <td>Service</td>
                    <td>:</td>
                    <td>`+data["summary"]["service_code"]+`</td>
                  </tr>
                  <tr>
                    <td>Dikirim tanggal</td>
                    <td>:</td>
                    <td>`+data["summary"]["waybill_date"]+`</td>
                  </tr>
                  <tr>
                    <td>Dikirim ke</td>
                    <td>:</td>
                    <td>`+data["summary"]["receiver_name"]+`</td>
                  </tr>
                </tbody>
              </table>

              <hr>
              <b>II. Delivery Time</b>
              <table class="table">
                <tbody>
                  <tr style="text-align: left">
                    <th width="30%">Tanggal</th>
                    <th width="70%">Keterangan</th>
                  </tr>
                  
                  `+manifest+`
                </tbody>
              </table>`;

      $('#cekResi .info-pengiriman').empty();
      $('#cekResi .info-pengiriman').append(html);
      $('#cekResi').modal();      
    })
  });

  $("#cetakSemua").click(function(){
    var selected = new Array();
    var $cbs = $('input[name="print"]');
    $cbs.each(function(data) {
        if ($(this).is(':checked'))

        selected.push($(this).val());
    });
    var w = window.open('cetak/'+selected);
    w.alert("Cetak menggunakan kertas A4 yang di bagi 2, Lalu set margin dan sesuaikan dengan panjang lembar invoice");
    w.print();
  });

  $(".btn-edit").click(function(){
    alert('Maaf, Fitur sedang dibuat');
  });

  $(".btn-confirm").click(function(){
    if (confirm('Anda yakin ingin menyelesaikan transaksi ini?')) {
      let id = $(this).data('id');
      $.get("{{ url('admin-panel/transaksi/resi/confirm') }}"+'/'+ id, function(data){
        console.log(data);
        if(data.status = "success"){
          alert('Mantap Njay');
        }
      })
    } else {
        alert('Dibatalkan');
    }
  });


</script>
@endpush