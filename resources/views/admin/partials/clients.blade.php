<section class="col-lg-12 ">

    <!-- Activities -->
    <div class="box box-primary">
        <div class="box-header">
            <i class="ion ion-clipboard"></i>

            <h3 class="box-title">კლიენტები</h3>
            <h3 class="box-title pull-right" style="margin: 0 5px;"><a href="#" data-toggle="modal" id="addCustomer" data-target="#CustomerModal"><i class="fa fa-plus-circle"></i></a></h3>
            <h3 class="box-title pull-right" style="margin: 0 5px;"><a href="#" data-toggle="modal" id="addCustomer" data-target="#CustomerModal"><i class="fa fa-pencil"></i></a></h3>

        </div>
        <!-- /.box-header -->
        <div class="box-body">

            <table id="Activities" class="table rangeDate actionioni table-striped table-bordered table-hover dataTables-example-activities " >
                <thead>
                    <tr>
                        <th></th>
                        <th>#</th>
                        <th>სახელი</th>
                        <th>ორგანიზაცია</th>
                        <th>პ.ნ/ს.კ</th>
                        <th>ტელეფონი</th>
                        <th>მისამართი</th>
                        <th>სტატუსი</th>
                        <th>ბალანსი</th>
                        <th>ტარიფი</th>
                    </tr>
                </thead>
                <tbody>

                    @if(count($customers) > 0)
                        @foreach($customers as $customer)
                            <tr>
                                <td></td>
                                <td>{{ $customer['id'] }}</td>
                                <td><a href="/clients/{{ $customer['id'] }}">{{ $customer['name_lat'] }} {{ $customer['lastname_lat'] }}</a></td>
                                <td>
                                    @if($customer['organisation_lat'] !== '')

                                        {{ $customer['organisation_lat'] }}

                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ $customer['pers_num'] }}</td>
                                <td>{{ $customer['mob_num'] }}</td>
                                <td>{{ $customer['address_geo'] }}</td>
                                <td>
                                    @if($customer['verification'])
                                        ვერიფიცირებული
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ $customer['balance'] }}</td>
                                <td>0</td>
                            </tr>
                        @endforeach
                    @endif


                </tbody>

                <tfoot>
                <tr>
                    <th></th>
                    <th>#</th>
                    <th>სახელი</th>
                    <th>ორგანიზაცია</th>
                    <th>პ.ნ/ს.კ</th>
                    <th>ტელეფონი</th>
                    <th>მისამართი</th>
                    <th>სტატუსი</th>
                    <th>ბალანსი</th>
                    <th>ფასდაკლება(%)</th>
                </tr>
                </tfoot>
            </table>
            <div class="modal fade modal-fullscreen" id="CustomerModal" tabindex="-1" role="dialog" aria-labelledby="">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">რედაქტირება</div>
                        <div class="modal-body">
                            <form class="form-horizontal" action="#" method="POST">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">ტიპი</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" name="" id="">
                                            <option value="1">ფიზიკური</option>
                                            <option value="2">ორგანიზაცია</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">დასახელება</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">პ.ნ./ს.კ.</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">ტელეფონის ნომერი</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">ელ-ფოსტა</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="" placeholder="">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">მისამართი</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">(%)</label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control" id="" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">

                            <button type="submit" style="margin-left: 10px;" class="btn btn-success pull-right">save</button>

                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                        </div>
                    </div>
                </div>
            </div>



            {{-- Modal form uncomment foreach --}}
            <div class="modal fade modal-fullscreen" id="mapModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Map </h4>
                        </div>
                        <div class="modal-body">
                            <div class="newMapShow" id="newMap"  style="height: 100% !important;">text of div</div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade bd-example-modal-lg" id="dr-check" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myLargeModalLabel"> ექიმი / წარმომადგენელი </h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">

                                <div class="col-md-12">

                                    <!-- App-users -->
                                    <div class="box">
                                        <div class="box-header">
                                            <i class="ion ion-clipboard"></i>

                                            <h3 class="box-title">ექიმი & წარმომადგენელი</h3>
                                        </div>
                                        <!-- /.box-header -->
                                        <div class="box-body">
                                            {{-- Row for doctors comments --}}
                                            <div class="row" style="margin-bottom: 40px;">
                                                <div class="col-lg-6 col-md-12">
                                                    <table id="CurierVsDoctor" class="table rangeDate table-striped table-bordered table-hover curiers-datatable dataTables-CurierVsDoctor" >
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>ექიმი</th>
                                                                <th>წარმომადგენელი</th>
                                                                <th>კომენტარი</th>
                                                                <th>თარიღი</th>

                                                                {{--<th>თარიღი</th>--}}
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>ექიმი</th>
                                                                <th>წარმომადგენელი</th>
                                                                <th>კომენტარი</th>
                                                                <th>თარიღი</th>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                                <div class="col-lg-6 col-md-12  ">
                                                    <table id="CurierVsDoctorComment" class="table rangeDate table-striped table-bordered table-hover curiers-datatable dataTables-CurierVsDoctorComment" >
                                                        <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>წარმომადგენელი</th>
                                                            <th>ექიმი</th>
                                                            <th>მედიკამენტი</th>
                                                            <th>კომენტარი</th>
                                                            <th>თარიღი</th>

                                                            {{--<th>თარიღი</th>--}}
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                        <tfoot>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>წარმომადგენელი</th>
                                                            <th>ექიმი</th>
                                                            <th>მედიკამენტი</th>
                                                            <th>კომენტარი</th>
                                                            <th>თარიღი</th>
                                                        </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                            {{-- Row for doctors medicaments comment --}}
                                            <div class="row">

                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.box -->

                                </div>

                                <div class="clearfix"></div>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default closeButtonDialog" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- /.box -->

</section>