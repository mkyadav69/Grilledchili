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
    @if (session()->has('customer_message'))
        <div class="sufee-alert alert with-close alert-success alert-dismissible fade show">
            {{ session('customer_message') }}
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
    @if(!empty($errors->cutomer_add->any()))
        <script>
            $(document).ready(function(){
                $('#addModal').modal({show: true});
            });
        </script>
    @endif
@endif  

@if(Session::has('errors'))
    @if($errors->cutomer_update->any()))
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
            $('div #customer_name').val(data['st_cust_fname']);
            $('div #customer_last_name').val(data['st_cust_lname']);
            $('div #customer_company_name').val(data['st_com_name']);
            $('div #customer_email').val(data['st_cust_email']);
            $('div #customer_region').val(data['st_regions']);
            $('div #customer_mobile').val(data['st_cust_mobile']);
            $('div #gst_no').val(data['cust_pin_no']);
            $('div #tin_no').val(data['cust_tin_no']);

            $('div #persion1_name').val(data['st_con_person1']);
            $('div #persion1_email').val(data['st_con_person1_email']);
            $('div #persion1_mobile').val(data['st_con_person1_mobile']);

            $('div #persion2_name').val(data['st_con_person2']);
            $('div #persion2_email').val(data['st_con_person2_email']);
            $('div #persion2_mobile').val(data['st_con_person2_mobile']);

            $('div #customer_address').val(data['st_com_address']);
            $('div #customer_city').val(data['st_cust_city']);
            $('div #customer_state').val(data['st_cust_state']);
            $('div #customer_pincode').val(data['in_pincode']);
            $('div #customer_contry').val(data['st_country']);
            $('div #customer_branch').val(data['in_branch']);

            $('#editForm').attr('action', '/edit-customer/'+data['in_cust_id']);
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
            $('#deleteForm').attr('action', '/delete-customer/'+data['in_cust_id']);
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
            <h5 class="modal-title" id="largeModalLabel">Add Customer</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="card">
                <form action="{{route('store_trucks')}}" method="post">
                    @csrf
                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="file-input" class=" form-control-label required">Customer Name</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="text" name="customer_name" id="customer_name" required placeholder="Name" value="{{old('customer_name')}}" class="form-control">
                            @if ($errors->cutomer_add->has('customer_name'))
                                <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                    <span class="badge badge-pill badge-danger">Error</span>
                                    {{ $errors->cutomer_add->first('customer_name') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="file-input" class=" form-control-label required">Last Name</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="text" name="customer_last_name"  required  placeholder="Last name" value="{{old('customer_last_name')}}" class="form-control">
                            @if ($errors->cutomer_add->has('customer_last_name'))
                                <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                    <span class="badge badge-pill badge-danger">Error</span>
                                    {{ $errors->cutomer_add->first('customer_last_name') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>


                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="file-input" class=" form-control-label required">Company Name</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="text" name="customer_company_name"  required  placeholder="company name" value="{{old('customer_company_name')}}" class="form-control">
                            @if ($errors->cutomer_add->has('customer_company_name'))
                                <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                    <span class="badge badge-pill badge-danger">Error</span>
                                    {{ $errors->cutomer_add->first('customer_company_name') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="file-input" class=" form-control-label required">Email</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="email" name="customer_email"  required  placeholder="Email" value="{{old('customer_email')}}" class="form-control">
                            @if ($errors->cutomer_add->has('customer_email'))
                                <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                    <span class="badge badge-pill badge-danger">Error</span>
                                    {{ $errors->cutomer_add->first('customer_email') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="file-input" class=" form-control-label">Mobile No.</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="text"  name="customer_mobile"  placeholder="Mobile" value="{{old('customer_mobile')}}" maxlength="10" pattern="\d{10}" title="Please enter exactly 10 digits"  class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                            @if ($errors->cutomer_add->has('customer_mobile'))
                                <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                    <span class="badge badge-pill badge-danger">Error</span>
                                    {{ $errors->cutomer_add->first('customer_mobile') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                   
                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="file-input" class=" form-control-label required">First Person Details</label>
                        </div>
                    
                        <div class="col-3">
                            <div class="form-group">
                                <input type="text" name="persion1_name"  required  placeholder="Name" value="{{old('persion1_name')}}"  class="form-control">
                                @if ($errors->cutomer_add->has('persion1_name'))
                                    <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                        <span class="badge badge-pill badge-danger">Error</span>
                                        {{ $errors->cutomer_add->first('persion1_name') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                          
                        <div class="col-3">
                            <div class="form-group">
                                <input type="email" name="persion1_email"  required  placeholder="Email" value="{{old('persion1_email')}}"  class="form-control">
                                @if ($errors->cutomer_add->has('persion1_email'))
                                    <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                        <span class="badge badge-pill badge-danger">Error</span>
                                        {{ $errors->cutomer_add->first('persion1_email') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                            
                        <div class="col-3">
                            <div class="form-group">
                                <input type="text"  name="persion1_mobile"  placeholder="Mobile" value="{{old('persion1_mobile')}}"  class="form-control" maxlength="10" pattern="\d{10}" title="Please enter exactly 10 digits"  class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                                @if ($errors->cutomer_add->has('persion1_mobile'))
                                    <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                        <span class="badge badge-pill badge-danger">Error</span>
                                        {{ $errors->cutomer_add->first('persion1_mobile') }}
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
                            <label for="file-input" class="form-control-label required">Second Person Details</label>
                        </div>
                       
                        <div class="col-3">
                            <div class="form-group">
                                <input type="text" name="persion2_name"  required  placeholder="Name" value="{{old('persion2_name')}}" class="form-control">
                                @if ($errors->cutomer_add->has('persion2_name'))
                                    <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                        <span class="badge badge-pill badge-danger">Error</span>
                                        {{ $errors->cutomer_add->first('persion2_name') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                            
                        <div class="col-3">
                            <div class="form-group">
                                <input type="email" name= "persion2_email"  required  value="{{old('persion2_email')}}" placeholder="email" class="form-control">
                                @if ($errors->cutomer_add->has('persion2_email'))
                                    <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                        <span class="badge badge-pill badge-danger">Error</span>
                                        {{ $errors->cutomer_add->first('persion2_email') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                           
                        <div class="col-3">
                            <div class="form-group">
                                <input type="text"  name="persion2_mobile"  value="{{old('persion2_mobile')}}" placeholder="Mobile" class="form-control" maxlength="10" pattern="\d{10}" title="Please enter exactly 10 digits"  class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                                @if ($errors->cutomer_add->has('persion2_mobile'))
                                    <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                        <span class="badge badge-pill badge-danger">Error</span>
                                        {{ $errors->cutomer_add->first('persion2_mobile') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row form-group" id="country">
                        <div class="col col-md-3">
                            <label for="file-input" class=" form-control-label required">Country</label>
                        </div>
                        <div class="col-12 col-md-9">
                            @if(!empty($countries))
                                <select name="customer_country" id="customer_country" class="form-control"  required >
                                    <option value="">Select Country</option>
                                    @foreach($countries as $kb=>$vb)
                                        <option  value="{{$kb}}"  {{ ($kb == old('customer_country',$vb))?'selected':'' }} >{{$vb}}</option>
                                    @endforeach
                                </select>
                            @endif
                            @if ($errors->cutomer_add->has('customer_country'))
                                <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                    <span class="badge badge-pill badge-danger">Error</span>
                                    {{ $errors->cutomer_add->first('customer_country') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="file-input" class=" form-control-label required">City</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="text" name= "customer_city" placeholder="City"  required  value="{{old('customer_city')}}" class="form-control">
                            @if ($errors->cutomer_add->has('customer_city'))
                                <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                    <span class="badge badge-pill badge-danger">Error</span>
                                    {{ $errors->cutomer_add->first('customer_city') }}
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
                            <textarea type="text" name="customer_address"  required  placeholder="Address . . . !" value="{{old('customer_address')}}" class="form-control"></textarea>
                            @if ($errors->cutomer_add->has('customer_address'))
                                <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                    <span class="badge badge-pill badge-danger">Error</span>
                                    {{ $errors->cutomer_add->first('customer_address') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <div class="row form-group" id="pincode">
                        <div class="col col-md-3">
                            <label for="file-input" class=" form-control-label required">Pin Code</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="text"  name="customer_pincode"  required  placeholder="Pin Code" value="{{old('customer_pincode')}}" class="form-control">
                            @if ($errors->cutomer_add->has('customer_pincode'))
                                <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                    <span class="badge badge-pill badge-danger">Error</span>
                                    {{ $errors->cutomer_add->first('customer_pincode') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="file-input" class=" form-control-label required">Customer Classification</label>
                        </div>
                        <div class="col-12 col-md-9">
                            @if(!empty($customer_classifications))
                                <select name="customer_classification" class="form-control"  required >
                                    <option value="">Select Classification</option>
                                    @foreach($customer_classifications as $kb=>$vb)
                                        <option  value="{{$kb}}"  {{ ($kb == old('customer_classification',$vb))?'selected':'' }} >{{$vb}}</option>
                                    @endforeach
                                </select>
                            @endif
                            @if ($errors->cutomer_add->has('customer_classification'))
                                <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                    <span class="badge badge-pill badge-danger">Error</span>
                                    {{ $errors->cutomer_add->first('customer_classification') }}
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
<!-- edit records -->
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="largeModalLabel">Update Customer</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="card">
                <form method="post" id="editForm">
                    @csrf
                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="file-input" class=" form-control-label required">Customer Name</label>
                        </div>
                        <div class="col-12 col-md-9">
                        <input type="text" id="customer_name" name="update_customer_name" value="{{old('update_customer_name')}}" placeholder="name" class="form-control">
                            @if ($errors->cutomer_add->has('customer_name'))
                                <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                    <span class="badge badge-pill badge-danger">Error</span>
                                    {{ $errors->cutomer_add->first('customer_name') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="file-input" class=" form-control-label required">Last Name</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="text" id="customer_last_name" name="update_customer_last_name"  required  placeholder="Last name" value="{{old('update_customer_last_name')}}" class="form-control">
                            @if ($errors->cutomer_add->has('update_customer_last_name'))
                                <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                    <span class="badge badge-pill badge-danger">Error</span>
                                    {{ $errors->cutomer_add->first('update_customer_last_name') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>


                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="file-input" class=" form-control-label required">Company Name</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="text" id="customer_company_name" name="update_customer_company_name"  required  placeholder="company name" value="{{old('update_customer_company_name')}}" class="form-control">
                            @if ($errors->cutomer_add->has('update_customer_company_name'))
                                <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                    <span class="badge badge-pill badge-danger">Error</span>
                                    {{ $errors->cutomer_add->first('update_customer_company_name') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="file-input" class=" form-control-label required">Email</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="text" id="customer_email" name="update_customer_email"  required  placeholder="Email" value="{{old('update_customer_email')}}" class="form-control">
                            @if ($errors->cutomer_add->has('update_customer_email'))
                                <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                    <span class="badge badge-pill badge-danger">Error</span>
                                    {{ $errors->cutomer_add->first('update_customer_email') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="file-input" class=" form-control-label required">Mobile No.</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="text"  id="customer_mobile" name="update_customer_mobile"  required  placeholder="Mobile" value="{{old('update_customer_mobile')}}" maxlength="10" pattern="\d{10}" title="Please enter exactly 10 digits"  class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                            @if ($errors->cutomer_add->has('update_customer_mobile'))
                                <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                    <span class="badge badge-pill badge-danger">Error</span>
                                    {{ $errors->cutomer_add->first('update_customer_mobile') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="file-input" class=" form-control-label required">GST No.</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="text"  id="gst_no" name="update_gst_no"  required  placeholder="GST No." maxlength="15" value="{{old('update_gst_no')}}" class="form-control" >
                            @if ($errors->cutomer_add->has('update_gst_no'))
                                <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                    <span class="badge badge-pill badge-danger">Error</span>
                                    {{ $errors->cutomer_add->first('update_gst_no') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="file-input" class=" form-control-label required">Tin No.</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="text"  id="tin_no" name="update_tin_no" placeholder="Tin No."  required  maxlength="15" value="{{old('update_tin_no')}}" class="form-control" >
                            @if ($errors->cutomer_add->has('update_tin_no'))
                                <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                    <span class="badge badge-pill badge-danger">Error</span>
                                    {{ $errors->cutomer_add->first('update_tin_no') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="file-input" class=" form-control-label required">First Person Details</label>
                        </div>
                        <div class="card cd">
                            <div class="col-12">
                                <div class="form-group">
                                    <input type="text" id="persion1_name" name="update_persion1_name"  required  placeholder="Name" value="{{old('persion1_name')}}"  class="form-control">
                                    @if ($errors->cutomer_add->has('update_persion1_name'))
                                        <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                            <span class="badge badge-pill badge-danger">Error</span>
                                            {{ $errors->cutomer_add->first('update_persion1_name') }}
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        
                            <div class="col-12">
                                <div class="form-group">
                                    <input type="text" id="persion1_email" name="update_persion1_email"  required  placeholder="Email" value="{{old('update_persion1_email')}}"  class="form-control">
                                    @if ($errors->cutomer_add->has('update_persion1_email'))
                                        <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                            <span class="badge badge-pill badge-danger">Error</span>
                                            {{ $errors->cutomer_add->first('update_persion1_email') }}
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                       
                            <div class="col-12">
                                <div class="form-group">
                                    <input type="text"  id="persion1_mobile" name="update_persion1_mobile"  required  placeholder="Mobile" value="{{old('update_persion1_mobile')}}"  class="form-control" maxlength="10" pattern="\d{10}" title="Please enter exactly 10 digits"  class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                                    @if ($errors->cutomer_add->has('update_persion1_mobile'))
                                        <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                            <span class="badge badge-pill badge-danger">Error</span>
                                            {{ $errors->cutomer_add->first('update_persion1_mobile') }}
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="file-input" class="form-control-label required">Second Person Details</label>
                        </div>
                        <div class="card cd">
                            <div class="col-12">
                                <div class="form-group">
                                    <input type="text" id="persion2_name" name="update_persion2_name"  required  placeholder="name" value="{{old('update_persion2_name')}}" class="form-control">
                                    @if ($errors->cutomer_add->has('update_persion2_name'))
                                        <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                            <span class="badge badge-pill badge-danger">Error</span>
                                            {{ $errors->cutomer_add->first('update_persion2_name') }}
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <div class="form-group">
                                    <input type="text" id="persion2_email" name="update_persion2_email"  required  value="{{old('update_persion2_email')}}" placeholder="email" class="form-control">
                                    @if ($errors->cutomer_add->has('update_persion2_email'))
                                        <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                            <span class="badge badge-pill badge-danger">Error</span>
                                            {{ $errors->cutomer_add->first('update_persion2_email') }}
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                       
                            <div class="col-12">
                                <div class="form-group">
                                    <input type="text"  id="persion2_mobile" name="update_persion2_mobile"  required  value="{{old('update_persion2_mobile')}}" placeholder="Mobile" class="form-control" maxlength="10" pattern="\d{10}" title="Please enter exactly 10 digits"  class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                                    @if ($errors->cutomer_add->has('update_persion2_mobile'))
                                        <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                            <span class="badge badge-pill badge-danger">Error</span>
                                            {{ $errors->cutomer_add->first('update_persion2_mobile') }}
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="file-input" class=" form-control-label required">City</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="text" id="customer_city" name="update_customer_city" placeholder="city"  required  value="{{old('update_customer_city')}}" class="form-control">
                            @if ($errors->cutomer_add->has('update_customer_city'))
                                <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                    <span class="badge badge-pill badge-danger">Error</span>
                                    {{ $errors->cutomer_add->first('update_customer_city') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="file-input" class=" form-control-label required">State</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="text"  id="customer_state" name="update_customer_state" placeholder="State"  required  value="{{old('update_customer_state')}}" class="form-control">
                            @if ($errors->cutomer_add->has('update_customer_state'))
                                <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                    <span class="badge badge-pill badge-danger">Error</span>
                                    {{ $errors->cutomer_add->first('update_customer_state') }}
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
                            <textarea type="text" id="customer_address" name="update_customer_address"  required  placeholder="Address . . . !" value="{{old('update_customer_address')}}" class="form-control"></textarea>
                            @if ($errors->cutomer_add->has('update_customer_address'))
                                <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                    <span class="badge badge-pill badge-danger">Error</span>
                                    {{ $errors->cutomer_add->first('update_customer_address') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="file-input" class=" form-control-label required">Pin Code</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="text"  id="customer_pincode" name="update_customer_pincode"  required  placeholder="Pin Code" value="{{old('update_customer_pincode')}}" class="form-control">
                            @if ($errors->cutomer_add->has('update_customer_pincode'))
                                <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                    <span class="badge badge-pill badge-danger">Error</span>
                                    {{ $errors->cutomer_add->first('update_customer_pincode') }}
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
<script>
    $(document).ready(function(){
        $('#customer_country').on('change', function(){
            var country = $( "#customer_country option:selected" ).val();
            if(country != '' && country == 'IN'){
                $('#input_state').remove();
                var gst = '<div class="row form-group" id="gst_no"><div class="col col-md-3"><label for="file-input" class=" form-control-label required">GST No.</label></div><div class="col-12 col-md-9"><input type="text"  id="gst_no_new" name="gst_no"  required  placeholder="GST No." maxlength="15" value="{{old("gst_no")}}" class="form-control" >@if ($errors->cutomer_add->has("gst_no"))<div class="sufee-alert alert with-close alert-danger alert-dismissible fade show"><span class="badge badge-pill badge-danger">Error</span>{{ $errors->cutomer_add->first("gst_no") }}<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>@endif</div></div>';
                $(gst).insertAfter('#pincode');
                
                var state =  '<div class="row form-group add_state" id="state"><div class="col col-md-3"><label for="file-input" class=" form-control-label required">State</label></div><div class="col-12 col-md-9">@if(!empty($indian_all_states))<select name="customer_state" class="form-control"  required><option value="">Select State</option>@foreach($indian_all_states as $kb=>$vb)<option  value="{{$kb}}" {{ ($kb == old("customer_state",$vb))?"selected":'' }}>{{$vb}}</option>@endforeach</select>@endif @if ($errors->cutomer_add->has("customer_state"))<div class="sufee-alert alert with-close alert-danger alert-dismissible fade show"><span class="badge badge-pill badge-danger">Error</span>{{ $errors->cutomer_add->first("customer_state") }}<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>@endif</div></div>';
                $(state).insertAfter('#country');
            }else{
               
                if (!$("div").hasClass("input_state")) {
                    var input_state = '<div class="row form-group input_state" id="input_state"><div class="col col-md-3"><label for="file-input" class=" form-control-label required">State</label></div><div class="col-12 col-md-9"><input type="text"  name="customer_state"  required  placeholder="State" maxlength="15" value="{{old("customer_state")}}" class="form-control" >@if ($errors->cutomer_add->has("customer_state"))<div class="sufee-alert alert with-close alert-danger alert-dismissible fade show"><span class="badge badge-pill badge-danger">Error</span>{{ $errors->cutomer_add->first("customer_state") }}<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>@endif</div></div>';
                    $(input_state).insertAfter('#country');
                    $('#gst_no').remove();
                    $('#state').remove();
                }
            }
        });
    });
</script>
@endsection