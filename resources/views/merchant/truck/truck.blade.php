@extends('theme.layout.base_layout')
@section('title', 'Manage Trucks')
@section('content')
<style>
.required:after {
    content: '*';
    color: red;
    padding-left: 5px;
}
.td-limit {
    max-width: 150px;
    text-overflow: ellipsis;
    white-space: nowrap;
    overflow: hidden;
}
.card{
    padding-left: 10px;
}

.cd{
    padding-left: 0px;
}
.modal-content {
    width: 120%;
}
table.dataTable > thead > tr > th:not(.sorting_disabled), table.dataTable > thead > tr > td:not(.sorting_disabled) {
    padding-right: 106px;
}
</style>
<div class="row">
    @if (session()->has('truck_message'))
        <div class="sufee-alert alert with-close alert-success alert-dismissible fade show">
            {{ session('truck_message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <div class="col-md-12">
        <h3 class="title-5 m-b-35">Manage Trucks</h3>
        <div class="table-data__tool">
            <div class="table-data__tool-right">
               
                    <button class="au-btn-filter mb-1 add_modal" data-toggle="modal" data-target="#addModal">
                        <i class="zmdi zmdi-plus"></i> Add Trucks
                    </button>
               
                    <input type="file" class="au-btn-filter">
                    <button class="au-btn-filter">
                        <i class="zmdi zmdi-upload"></i> Import Trucks
                    </button>
               

            </div>
        </div>
    </div>
 
    <div class="table-responsive table--no-card m-b-30">
        <table id="customer" class="table table-borderless table--no-card m-b-30 table-striped table-earning" style="width:100%">
       
        </table>
    </div>
                       
</div>
@if(Session::has('errors'))
    @if(!empty($errors->add_truck->any()))
        <script>
            $(document).ready(function(){
                $('#addModal').modal({show: true});
            });
        </script>
    @endif
@endif  

@if(Session::has('errors'))
    @if($errors->update_truck->any()))
        <script>
            $('#editModal').modal('show');  
        </script>
    @endif
@endif 

<script>
    $(document).ready(function(){
        table = $('#customer').DataTable({
                processing: true,
                orderCellsTop: true,
                fixedHeader: true,
                sort : true,
                scrollX: true,
                bDestroy: true,
                destroy: true,
                sort : true,
                cache: true,
                scrollX: true,
                responsive: true,
                ajax: {
                    url:'{{ route("get_trucks") }}',
                },
                pageLength: 10,
                columnDefs: [{ 
                    'orderable': true,
                    'targets': [0]
                }, {
                    "searchable": true,
                    "targets": [0]
                }],
                aaSorting: [[0, 'desc']],
                language: {
                    processing: '<i class="fa fa-spinner fa-spin fa-4x fa-fw" style="font-size:60px;"></i>'
                },
                lengthMenu: [
                    [10, 20, 30, -1],
                    [10, 20, 30, "All"]
                ],
                columns:[
                    { data: 'name', className: "text td_ellipsis td-limit", title : 'Truck Name'},
                    { data: 'alias', className: "text td_ellipsis td-limit", title : 'Truck Alias'},
                    { data: 'latitude', className: "text td_ellipsis td-limit", title : 'Latitude'},
                    { data: 'longitude', className: "text td_ellipsis td-limit", title : 'Longitude'},
                    { data: 'description', className: "text td_ellipsis td-limit", title : 'Description'},
                    { data: 'phone', className: "text td_ellipsis td-limit", title : 'Phone'},
                    { data: 'website', className: "text td_ellipsis td-limit", title : 'Website'},
                    { data: 'address', className: "text td_ellipsis td-limit", title : 'Address'},
                    { data: 'operatingtime', className: "text td_ellipsis td-limit", title : 'Operating Time'},
                    { data: 'weekdaytime', className: "text td_ellipsis td-limit", title : 'Weekday Time'},
                    { data: 'weekendtime', className: "text td_ellipsis td-limit", title : 'Weekend Time'},
                    { data: 'rating', className: "text td_ellipsis td-limit", title : 'Ratings'},
                    { data: 'created_at', title : 'Created At'},
                    { data: 'actions', title : 'Actions'},
                    
                ], 
                "drawCallback": function( settings ) {
                    $('td.td_ellipsis').css('text-overflow', 'ellipsis');
                    $('td.td_ellipsis').css('overflow', 'hidden');
                    $('td.td_ellipsis').css('white-space', 'nowrap'); 
                    $('td.td_ellipsis').addClass('ellipsisd'); 
                    $('td.td_ellipsis').unbind('click');
                    $('td.date').addClass('date_format');
                    $('td.td_ellipsis').click(function(){
                        if($(this).hasClass('ellipsisd')){
                            $(this).removeAttr('style');
                            $(this).removeClass('ellipsisd'); 
                        }
                        else{
                            $(this).css('text-overflow', 'ellipsis');
                            $(this).css('overflow', 'hidden');
                            $(this).css('white-space', 'nowrap'); 
                            $(this).addClass('ellipsisd'); 
                        }
                    });
                    if($('div').hasClass('dataTables_info')){
                        var getcount = $('div.dataTables_info').text();
                        if(getcount !== ''){
                            var n = getcount.indexOf('of');
                            var lst = getcount.indexOf("entries");
                            var result = getcount.slice(n, lst);
                            var exact_count = result.match(/\d+/g).map(Number);
                            var obj_yo_num = String(exact_count);
                            var sting_num = obj_yo_num.split(',').join('');
                            var r_count = Number(sting_num);
                            if(r_count > 50000){
                                $('div.handle_count').hide();
                                $('div.handle_count1').show();
                            }else{
                                $('div.handle_count').show();
                                $('div.handle_count1').hide();
                            }  
                        }
                    };
                },
                initComplete: function () {
                    this.api().columns().every(function () {
                        var column = this;
                        if ($(column.header()).hasClass('select')) {
                            console.log(column);
                            var select = $('<select  tyle="width:150px; height: 30px;  font-weight: normal;  border-radius: 5px;" class="js-select2" ><option value="">' + $(column.header()).html() + '</option></select>')
                                    .appendTo($(column.header()).empty())
                                    .on('change', function (e) {
                                        e.stopImmediatePropagation();
                                        var val = $.fn.dataTable.util.escapeRegex($(this).val());
                                        column.search(val ? '^' + val + '$' : '', true, false).draw();
                                        return false;
                                    });
                            column.data().unique().sort().each(function (d, j) {
                                select.append('<option value="' + d + '">' + d + '</option>');
                            });
                        }else if ($(column.header()).hasClass('text')) {
                            var text = $('<input style="width:150px; height: 30px;  font-weight: normal;  border-radius: 5px;" type="text" placeholder="' + $(column.header()).html() + '" />')
                            .appendTo($(column.header()).empty())
                            .on('keypress', function () {
                                var val = $.fn.dataTable.util.escapeRegex($(this).val());
                                if (column.search() !== this.value) {
                                    column.search(val).draw();
                                }
                                return false;
                            });
                        }
                    });
                },
                drawCallback: function( settings ) {
                    $('td.td_ellipsis').css('text-overflow', 'ellipsis');
                    $('td.td_ellipsis').css('overflow', 'hidden');
                    $('td.td_ellipsis').css('white-space', 'nowrap'); 
                    $('td.td_ellipsis').addClass('ellipsisd'); 
                    $('td.td_ellipsis').unbind('click');
                    $('td.date').addClass('date_format');
                    $('td.td_ellipsis').click(function(){
                        if($(this).hasClass('ellipsisd')){
                            $(this).removeAttr('style');
                            $(this).removeClass('ellipsisd'); 
                        }
                        else{
                            $(this).css('text-overflow', 'ellipsis');
                            $(this).css('overflow', 'hidden');
                            $(this).css('white-space', 'nowrap'); 
                            $(this).addClass('ellipsisd'); 
                        }
                    });
            } 
        });
        table.on('click', '.edit', function(){
            $tr = $(this).closest('tr');
            if($($tr).hasClass('child')){
                $tr = $tr.prev('.parent');
            }
            var data = table.row($tr).data();
            console.log(data);
            $('div #truck_name').val(data['name']);
            $('div #truck_alias').val(data['alias']);
            $('div #latitude').val(data['latitude']);
            $('div #longitude').val(data['longitude']);
            $('div #longitude').val(data['longitude']);
            $('div #phone').val(data['phone']);
            $('div #descriptions').val(data['description']);
            $('div #website').val(data['website']);
            $('div #address').val(data['address']);
            $('div #operating_time').val(data['operatingtime']);
            $('div #weekdays_time').val(data['weekdaytime']);
            $('div #weekend_time').val(data['weekendtime']);
            $('div #rating').val(data['rating']);

            $('#editForm').attr('action', '/edit-trucks/'+data['id']);
            $('#editModal').modal({
                backdrop: 'static'
            });
            $('#editModal').modal('show');  
        });

        table.on('click', '.delete', function(){
            $tr = $(this).closest('tr');
            if($($tr).hasClass('child')){
                $tr = $tr.prev('.parent');
            }
            var data = table.row($tr).data();
            $('#deleteForm').attr('action', '/delete-trucks/'+data['id']);
            $('#deleteModal').modal({
                backdrop: 'static'
            });
            $('#deleteModal').modal('show');  
        });
    });
    
</script>
@endsection

@section('addModal')
<!-- add records -->
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="largeModalLabel">Add Trucks</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="card">
                <form action="{{route('store_trucks')}}" method="post">
                    @csrf
                    <input type="hidden" name="vendor_id" id="vendor_id" value="1" class="form-control">
                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="file-input" class=" form-control-label required">Truck Name</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="text" name="truck_name" required placeholder="Truck Name" value="{{old('truck_name')}}" class="form-control">
                            @if ($errors->add_truck->has('truck_name'))
                                <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                    <span class="badge badge-pill badge-danger">Error</span>
                                    {{ $errors->cutomer_add->first('truck_name') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="file-input" class=" form-control-label required">Truck Alias</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="text" name="truck_alias"  required  placeholder="Truck Alias" value="{{old('truck_alias')}}" class="form-control">
                            @if ($errors->add_truck->has('truck_alias'))
                                <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                    <span class="badge badge-pill badge-danger">Error</span>
                                    {{ $errors->add_truck->first('truck_alias') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>


                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="file-input" class=" form-control-label required">Latitude</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="text" name="latitude" required  placeholder="Latitude" value="{{old('latitude')}}"  title="Please enter valid latitude" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="form-control">
                            @if ($errors->add_truck->has('latitude'))
                                <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                    <span class="badge badge-pill badge-danger">Error</span>
                                    {{ $errors->add_truck->first('latitude') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div> 

                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="file-input" class=" form-control-label">Longitude</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="text" name="longitude" placeholder="Longitude" value="{{old('longitude')}}"   title="Please enter valid latitude" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                            @if ($errors->add_truck->has('longitude'))
                                <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                    <span class="badge badge-pill badge-danger">Error</span>
                                    {{ $errors->add_truck->first('longitude') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="file-input" class=" form-control-label required">Descriptions</label>
                        </div>
                    
                        <div class="col-12 col-md-9">
                            <div class="form-group">
                            <textarea type="text" name="descriptions" required placeholder="Descriptions . . . !" class="form-control">{{old('descriptions')}}</textarea>
                                @if ($errors->add_truck->has('descriptions'))
                                    <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                        <span class="badge badge-pill badge-danger">Error</span>
                                        {{ $errors->add_truck->first('descriptions') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="file-input" class=" form-control-label required">Website</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="text" name="website" required placeholder="https://" value="{{old('website')}}" class="form-control">
                            @if ($errors->add_truck->has('website'))
                                <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                    <span class="badge badge-pill badge-danger">Error</span>
                                    {{ $errors->add_truck->first('website') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>


                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="file-input" class=" form-control-label required">Address</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <textarea type="text" name="address" required placeholder="Address . . . !" value="{{old('address')}}" class="form-control"></textarea>                             
                            @if ($errors->add_truck->has('address'))
                                <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                    <span class="badge badge-pill badge-danger">Error</span>
                                    {{ $errors->add_truck->first('address') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="file-input" class=" form-control-label required">Operating Time</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="text" name="operating_time"  required  placeholder="Operating Time" value="{{old('operating_time')}}" class="form-control">
                            @if ($errors->add_truck->has('operating_time'))
                                <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                    <span class="badge badge-pill badge-danger">Error</span>
                                    {{ $errors->add_truck->first('operating_time') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="file-input" class="form-control-label required">Phone</label>
                        </div>
                       
                        <div class="col-12 col-md-9">
                            <div class="form-group">
                                <input type="text" name="phone"  required  placeholder="Phone" value="{{old('phone')}}" pattern="\d{10}" title="Please enter exactly 10 digits"  class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" title="Please enter exactly 10 digits" maxlength="10"  class="form-control">
                                @if ($errors->add_truck->has('phone'))
                                    <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                        <span class="badge badge-pill badge-danger">Error</span>
                                        {{ $errors->add_truck->first('phone') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="file-input" class=" form-control-label required">Weekdays Time</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="text" name= "weekdays_time" placeholder="Weekdays Time" required  value="{{old('weekdays_time')}}" class="form-control">
                            @if ($errors->add_truck->has('weekdays_time'))
                                <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                    <span class="badge badge-pill badge-danger">Error</span>
                                    {{ $errors->add_truck->first('weekdays_time') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="file-input" class=" form-control-label required">Weekends Time</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="text" name= "weekend_time" placeholder="Weekends Time" required  value="{{old('weekend_time')}}" class="form-control">
                            @if ($errors->add_truck->has('weekend_time'))
                                <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                    <span class="badge badge-pill badge-danger">Error</span>
                                    {{ $errors->add_truck->first('weekend_time') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <div class="row form-group" id="pincode">
                        <div class="col col-md-3">
                            <label for="file-input" class=" form-control-label required">Ratings</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="text"  name="ratings"  required  placeholder="Ratings" pattern="\d{1}" title="Please enter rating in single digits"  class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="{{old('ratings')}}" class="form-control">
                            @if ($errors->add_truck->has('ratings'))
                                <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                    <span class="badge badge-pill badge-danger">Error</span>
                                    {{ $errors->add_truck->first('ratings') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Confirm</button>
                    </div>
                </form>
            </div>
        </div>
        
    </div>
    
<!-- end add record -->
@endsection


@section('editModal')
<!-- add records -->
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="largeModalLabel">Update Trucks</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="card">
                <form method="post" id="editForm">
                    @csrf
                    <input type="hidden" name="vendor_id" id="vendor_id" value="1" class="form-control">
                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="file-input" class=" form-control-label required">Truck Name</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="text" name="truck_name" id="truck_name" required placeholder="Truck Name" value="{{old('truck_name')}}" class="form-control">
                            @if ($errors->add_truck->has('truck_name'))
                                <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                    <span class="badge badge-pill badge-danger">Error</span>
                                    {{ $errors->cutomer_add->first('truck_name') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="file-input" class=" form-control-label required">Truck Alias</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="text" name="truck_alias" id="truck_alias" required  placeholder="Truck Alias" value="{{old('truck_alias')}}" class="form-control">
                            @if ($errors->add_truck->has('truck_alias'))
                                <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                    <span class="badge badge-pill badge-danger">Error</span>
                                    {{ $errors->add_truck->first('truck_alias') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>


                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="file-input" class=" form-control-label required">Latitude</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="text" name="latitude" id="latitude" required  placeholder="Latitude" value="{{old('latitude')}}"   title="Please enter valid latitude" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="form-control">
                            @if ($errors->add_truck->has('latitude'))
                                <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                    <span class="badge badge-pill badge-danger">Error</span>
                                    {{ $errors->add_truck->first('latitude') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div> 

                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="file-input" class=" form-control-label">Longitude</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="text" name="longitude" id="longitude" placeholder="Longitude" value="{{old('longitude')}}"   title="Please enter valid latitude" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                            @if ($errors->add_truck->has('longitude'))
                                <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                    <span class="badge badge-pill badge-danger">Error</span>
                                    {{ $errors->add_truck->first('longitude') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="file-input" class=" form-control-label required">Descriptions</label>
                        </div>
                    
                        <div class="col-12 col-md-9">
                            <div class="form-group">
                            <textarea type="text" name="descriptions" id="descriptions" required placeholder="Descriptions . . . !" class="form-control">{{old('descriptions')}}</textarea>
                                @if ($errors->add_truck->has('descriptions'))
                                    <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                        <span class="badge badge-pill badge-danger">Error</span>
                                        {{ $errors->add_truck->first('descriptions') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="file-input" class=" form-control-label required">Website</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="text" name="website" id="website" required placeholder="https://" value="{{old('website')}}" class="form-control">
                            @if ($errors->add_truck->has('website'))
                                <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                    <span class="badge badge-pill badge-danger">Error</span>
                                    {{ $errors->add_truck->first('website') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>


                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="file-input" class=" form-control-label required">Address</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <textarea type="text" name="address" id="address" required placeholder="Address . . . !" value="{{old('address')}}" class="form-control"></textarea>                             
                            @if ($errors->add_truck->has('address'))
                                <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                    <span class="badge badge-pill badge-danger">Error</span>
                                    {{ $errors->add_truck->first('address') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="file-input" class=" form-control-label required">Operating Time</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="text" name="operating_time"  id="operating_time" required  placeholder="Operating Time" value="{{old('operating_time')}}" class="form-control">
                            @if ($errors->add_truck->has('operating_time'))
                                <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                    <span class="badge badge-pill badge-danger">Error</span>
                                    {{ $errors->add_truck->first('operating_time') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="file-input" class="form-control-label required">Phone</label>
                        </div>
                       
                        <div class="col-12 col-md-9">
                            <div class="form-group">
                                <input type="text" name="phone"  id="phone" required  placeholder="Phone" value="{{old('phone')}}" pattern="\d{10}" title="Please enter exactly 10 digits"  class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" title="Please enter exactly 10 digits" maxlength="10"  class="form-control">
                                @if ($errors->add_truck->has('phone'))
                                    <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                        <span class="badge badge-pill badge-danger">Error</span>
                                        {{ $errors->add_truck->first('phone') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="file-input" class=" form-control-label required">Weekdays Time</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="text" name="weekdays_time" id="weekdays_time" placeholder="Weekdays Time" required  value="{{old('weekdays_time')}}" class="form-control">
                            @if ($errors->add_truck->has('weekdays_time'))
                                <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                    <span class="badge badge-pill badge-danger">Error</span>
                                    {{ $errors->add_truck->first('weekdays_time') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="file-input" class=" form-control-label required">Weekends Time</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="text" name= "weekend_time" id="weekend_time" placeholder="Weekends Time" required  value="{{old('weekend_time')}}" class="form-control">
                            @if ($errors->add_truck->has('weekend_time'))
                                <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                    <span class="badge badge-pill badge-danger">Error</span>
                                    {{ $errors->add_truck->first('weekend_time') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <div class="row form-group" id="pincode">
                        <div class="col col-md-3">
                            <label for="file-input" class=" form-control-label required">Ratings</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="text"  name="ratings" id="rating" required  placeholder="Ratings" pattern="\d{1}" title="Please enter rating in single digits"  class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="{{old('ratings')}}" class="form-control">
                            @if ($errors->add_truck->has('ratings'))
                                <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                    <span class="badge badge-pill badge-danger">Error</span>
                                    {{ $errors->add_truck->first('ratings') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Confirm</button>
                    </div>
                </form>
            </div>
        </div>
        
    </div>
    
<!-- end add record -->
@endsection

@section('deleteModal')
<!-- Delete-->
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="largeModalLabel">Delete</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form method="post" id="deleteForm">
            @csrf
            <div class="modal-body">
                <p>Are you sure to delete the record ?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Confirm</button>
            </div>
        </form>
    </div>
<!-- end modal large -->
@endsection