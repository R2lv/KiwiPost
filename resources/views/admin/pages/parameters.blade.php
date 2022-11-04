@extends ('admin.app')

@section ('content')

    <div id="preloade"><div class="bgimg"></div></div>

    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                პარამეტრები
                <small>ძირითადი ფუნქციები</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> პარამეტრები</a></li>
            </ol>
        </section>

        <section class="content">

            {{-- @include('partials.statistics') --}}

            <div class="row">

                <section class="col-lg-7 connectedSortable">
                    {{-- connectedSortable --}}

                    {{-- @if(count(@$districts) > 0) --}}
                    <div class="nav-tabs-custom" id="configuration">
                        <ul class="nav nav-tabs pull-right">
                            <li><a href="#"  data-toggle="modal" id="addCustomConfigs" data-target="#operatorsModal"><i class="fa fa-plus"></i></a></li>
                            <li class="active"><a href="#operator" data-toggle="tab">ორგანიზაცია</a></li>
                            <li><a href="#group" data-toggle="tab">თანამშრომლები</a></li>
                            {{--<li><a href="#district" data-toggle="tab">მომწოდებლები</a></li>--}}
                            <li class="pull-left header"><i class="fa fa-inbox"></i> კონფიგურაცია</li>
                        </ul>
                        <div class="tab-content no-padding" id="configuration-forms">
                            <!-- Morris chart - Sales -->
                            <div class="chart tab-pane active" data-customid="#operatorsModal" id="operator" style="position: relative; height: 300px; overflow: scroll;">
                                {{--organisation--}}
                                <div class="col-xs-12">
                                    <table class="table table-hover">
                                        <tr>
                                            <th>#</th>
                                            <th>დასახელება</th>
                                            <th>საიდენტიფიკაციო კოდი</th>
                                            <th>ტელეფონის ნომერი</th>
                                            <th>მისამართი</th>
                                            <th><i class="fa fa-pencil"></i></th>
                                        </tr>
                                        {{-- @if(count(@$operators) > 0) --}}
                                        {{-- @foreach ($operators as $operator) --}}
                                        <tr>
                                            <td>1</td>
                                            <td><a href="#">SENDEX</a></td>
                                            <td><a href="#">59948342</a></td>
                                            <td>597222223</td>
                                            <td>კანდელაკის #10</td>
                                            <td><a href="#"><i class="fa fa-pencil"></i></a></td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td><a href="#">GZAVNILI</a></td>
                                            <td><a href="#">58889483</a></td>
                                            <td>597222223</td>
                                            <td>10</td>
                                            <td><a href="#"><i class="fa fa-pencil"></i></a></td>
                                        </tr>
                                        {{-- @endforeach --}}
                                        {{-- @endif --}}
                                    </table>

                                    <div class="modal fade modal-fullscreen" id="operatorsModal" tabindex="-1" role="dialog" aria-labelledby="">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">

                                                    ორგანიზაცია

                                                </div>
                                                <div class="modal-body">
                                                    <form class="form-horizontal" action="#" method="POST">
                                                        {{ csrf_field() }}
                                                        <div class="form-group">
                                                            <label for="" class="col-sm-2 control-label">ორგანიზაცია</label>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control" id="" placeholder="Berlinparts.com">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="" class="col-sm-2 control-label">საიდენტიფიკაციო კოდი</label>
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
                                                            <label for="" class="col-sm-2 control-label">მისამართი</label>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control" id="" placeholder="">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="" class="col-sm-2 control-label">ინდექსი</label>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control" id="" placeholder="">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="" class="col-sm-2 control-label">ტარიფი</label>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control" id="" placeholder="">
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

                                </div>
                                {{-- End-organisation modal--}}
                            </div>

                            {{--  employees  --}}

                            <div class="chart tab-pane" data-customid="#groupsModal"  id="group" style="position: relative; height: 300px; overflow: scroll;">

                                <div class="col-xs-12">

                                    <table class="table table-hover">
                                        <tr>
                                            <th>#</th>
                                            <th>სახელი</th>
                                            <th>გვარი</th>
                                            <th>ტელეფონის ნომერი</th>
                                            <th>ელ-ფოსტა</th>
                                            <th>ორგანიზაცია</th>
                                            <th>პაროლი</th>
                                            <th><i class="fa fa-pencil"></i></th>
                                        </tr>
                                        {{-- @if(count(@$groups) > 0) --}}
                                        {{-- @foreach($groups as $group) --}}
                                        <tr>
                                            <td>1</td>
                                            <td>ლაშა</td>
                                            <td>გამყრელიძე</td>
                                            <td>598774733</td>
                                            <td>gamkrelidze90@gmail.com</td>
                                            <td>EU2GEORGIA</td>
                                            <td>**************</td>
                                            <td><a href="#"><i class="fa fa-pencil"></i></a></td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>რევაზ</td>
                                            <td>ლაშქარავა</td>
                                            <td>595595771</td>
                                            <td>rezolashkarava@gmail.com</td>
                                            <td>EU2GEORGIA</td>
                                            <td>**************</td>
                                            <td><a href="#"><i class="fa fa-pencil"></i></a></td>
                                        </tr>
                                        {{-- @endforeach --}}
                                        {{-- @endif --}}
                                    </table>

                                    <div class="modal fade modal-fullscreen " id="groupsModal" tabindex="-1" role="dialog" aria-labelledby="">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">

                                                    თანამშრომლის დამატება

                                                </div>
                                                <div class="modal-body">
                                                    <form class="form-horizontal" >
                                                        {{ csrf_field() }}
                                                        <div class="form-group">
                                                            <label for="" class="col-sm-2 control-label">სახელი</label>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control" name="" placeholder="თანამშრომლის სახელი">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="" class="col-sm-2 control-label">გვარი</label>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control" name="" placeholder="თანამშრომლის გვარი">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="" class="col-sm-2 control-label">ტელეფონის ნომერი</label>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control" name="" placeholder="თანამშრომლის ტელ. ნომერი">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="" class="col-sm-2 control-label">ელ-ფოსტა</label>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control" name="" placeholder="თანამშრომლის ელ-ფოსტა">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="" class="col-sm-2 control-label">ორგანიზაცია</label>
                                                            <div class="col-sm-10">
                                                                <select  class="form-control" id="districtSelectAction">
                                                                    <option value=""></option>
                                                                    {{-- @if (count($districts) > 0) --}}
                                                                    {{-- @foreach ($districts as $district ) --}}
                                                                    <option value="1">Berlinparts</option>
                                                                    <option value="id">Aka motors</option>
                                                                    {{-- @endforeach --}}
                                                                    {{-- @endif --}}
                                                                </select>
                                                            </div>
                                                        </div>

                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" style="margin-left: 10px;" class="btn pull-right  btn-success">save</button>

                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>

                            {{--  End-employees modal  --}}

                            {{--  Dealer modal  --}}

                            <div class="chart tab-pane " data-customid="#districtsModal"  id="district" style="position: relative; height: 300px; overflow: scroll;">
                                <div class="col-xs-12">
                                    <table class="table table-hover ">
                                        <tr>
                                            <th>#</th>
                                            <th>დასახელება</th>
                                            <th>ელ-ფოსტა</th>
                                            <th>ფასნამატი (%)</th>
                                            <th><i class="fa fa-pencil"></i></th>
                                        </tr>
                                        {{--@if(count(@$districts) > 0)--}}
                                        {{--@foreach($districts as $district)--}}
                                        <tr>
                                            <td>1</td>
                                            <td><a href="#">გარი</a></td>
                                            <td><a href="#">gariGermany@gmail.com</a></td>
                                            <td><a href="#">15</a></td>
                                            <td><a href="#"><i class="fa fa-pencil"></i></a></td>
                                        </tr>
                                        {{--@endforeach--}}
                                        {{--@endif--}}
                                    </table>
                                    <div class="modal fade modal-fullscreen" id="districtsModal" tabindex="-1" role="dialog" aria-labelledby="">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">

                                                    მომწოდებლის დამატება

                                                </div>
                                                <div class="modal-body">
                                                    <form class="form-horizontal">
                                                        {{ csrf_field() }}
                                                        <div class="form-group">
                                                            <label for="" class="col-sm-2 control-label">დასახელება</label>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control" name="" placeholder="მომწოდებლის დასახელება">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="" class="col-sm-2 control-label">ელ-ფოსტა</label>
                                                            <div class="col-sm-10">
                                                                <input type="email" class="form-control" name="" placeholder="მომწოდებლის ელ-ფოსტა">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="" class="col-sm-2 control-label">ფასნამატი</label>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control" name="" placeholder="მომწოდებლის ფასნამატი">
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

                                </div>

                            </div>

                            {{-- End-Dealer --}}

                        </div>
                    </div>
                    {{-- @endif --}}

                    {{-- To Do list--}}
                    <div class="box box-primary">
                        <div class="box-header">
                            <i class="ion ion-clipboard"></i>

                            <h3 class="box-title">Notes</h3>

                            <div class="box-tools pull-right">
                                <ul class="pagination pagination-sm inline">
                                    <li><a href="#">&laquo;</a></li>
                                    <li><a href="#">1</a></li>
                                    <li><a href="#">2</a></li>
                                    <li><a href="#">3</a></li>
                                    <li><a href="#">&raquo;</a></li>
                                </ul>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <ul class="todo-list">
                                <li>
                                    <!-- drag handle -->
                                    <span class="handle">
                        <i class="fa fa-ellipsis-v"></i>
                        <i class="fa fa-ellipsis-v"></i>
                      </span>
                                    <!-- checkbox -->
                                    <input type="checkbox" value="">
                                    <!-- todo text -->
                                    <span class="text">Design a nice theme</span>
                                    <!-- Emphasis label -->
                                    <small class="label label-danger"><i class="fa fa-clock-o"></i> 2 mins</small>
                                    <!-- General tools such as edit or delete-->
                                    <div class="tools">
                                        <i class="fa fa-edit"></i>
                                        <i class="fa fa-trash-o"></i>
                                    </div>
                                </li>
                                <li>
                      <span class="handle">
                        <i class="fa fa-ellipsis-v"></i>
                        <i class="fa fa-ellipsis-v"></i>
                      </span>
                                    <input type="checkbox" value="">
                                    <span class="text">Make the theme responsive</span>
                                    <small class="label label-info"><i class="fa fa-clock-o"></i> 4 hours</small>
                                    <div class="tools">
                                        <i class="fa fa-edit"></i>
                                        <i class="fa fa-trash-o"></i>
                                    </div>
                                </li>
                                <li>
                      <span class="handle">
                        <i class="fa fa-ellipsis-v"></i>
                        <i class="fa fa-ellipsis-v"></i>
                      </span>
                                    <input type="checkbox" value="">
                                    <span class="text">Let theme shine like a star</span>
                                    <small class="label label-warning"><i class="fa fa-clock-o"></i> 1 day</small>
                                    <div class="tools">
                                        <i class="fa fa-edit"></i>
                                        <i class="fa fa-trash-o"></i>
                                    </div>
                                </li>
                                <li>
                      <span class="handle">
                        <i class="fa fa-ellipsis-v"></i>
                        <i class="fa fa-ellipsis-v"></i>
                      </span>
                                    <input type="checkbox" value="">
                                    <span class="text">Let theme shine like a star</span>
                                    <small class="label label-success"><i class="fa fa-clock-o"></i> 3 days</small>
                                    <div class="tools">
                                        <i class="fa fa-edit"></i>
                                        <i class="fa fa-trash-o"></i>
                                    </div>
                                </li>
                                <li>
                      <span class="handle">
                        <i class="fa fa-ellipsis-v"></i>
                        <i class="fa fa-ellipsis-v"></i>
                      </span>
                                    <input type="checkbox" value="">
                                    <span class="text">Check your messages and notifications</span>
                                    <small class="label label-primary"><i class="fa fa-clock-o"></i> 1 week</small>
                                    <div class="tools">
                                        <i class="fa fa-edit"></i>
                                        <i class="fa fa-trash-o"></i>
                                    </div>
                                </li>
                                <li>
                      <span class="handle">
                        <i class="fa fa-ellipsis-v"></i>
                        <i class="fa fa-ellipsis-v"></i>
                      </span>
                                    <input type="checkbox" value="">
                                    <span class="text">Let theme shine like a star</span>
                                    <small class="label label-default"><i class="fa fa-clock-o"></i> 1 month</small>
                                    <div class="tools">
                                        <i class="fa fa-edit"></i>
                                        <i class="fa fa-trash-o"></i>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer clearfix no-border">
                            <button type="button" class="btn btn-default pull-right"><i class="fa fa-plus"></i> Add item</button>
                        </div>
                    </div>
                    <!-- /.box -->
                </section>

                <!-- /.Left col -->


                <!-- right col (We are only adding the ID to make the widgets sortable)-->
                <section class="col-lg-5 connectedSortable">

                    <div class="box box-primary">
                        <div class="box-header">
                            <i class="ion ion-clipboard"></i>

                            <h3 class="box-title">გლობალური პარამეტრები</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <form class="form-horizontal">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">ტარიფი</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="" value="6.5" placeholder="ძირითადი ფასნამატი">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">ორგანიზაცია</label>
                                    <div class="col-sm-10">
                                        <select  class="form-control" id="districtSelectAction">
                                            <option value=""></option>
                                            {{-- @if (count($districts) > 0) --}}
                                            {{-- @foreach ($districts as $district ) --}}
                                            <option value="1" selected>SENDEX</option>
                                            <option value="id">GZAVNILI</option>
                                            {{-- @endforeach --}}
                                            {{-- @endif --}}
                                        </select>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>

                </section>
                <!-- right col -->
            </div>
            <!-- /.row (main row) -->
        </section>
        <!-- /.content -->
    </div>
@endsection