@extends ('admin.app')


@section ('content')

<div class="content-wrapper">
    <section class="content-header">
    </section>
    <section class="content">

        {{-- @include('partials.statistics') --}}

        <div class="row">

            <section class="col-lg-12">
                <div class="nav-tabs-custom" id="configuration">
                    <ul class="nav nav-tabs pull-right">
                        <li><a href="#personal" data-toggle="tab">პირადი</a></li>
                        <li  class="active"><a href="#online" data-toggle="tab">ონლაინი</a></li>
                        <li class="pull-left header"><i class="fa fa-inbox"></i> ამანათის დამატება</li>
                    </ul>
                    <div class="tab-content no-padding" id="configuration-forms">
                        <!-- Morris chart - Sales -->
                        <div class="chart tab-pane " data-customid="#personalmodal" id="personal" style="position: relative; height: 850px; overflow: scroll;">
                            {{--organisation--}}
                            <div class="col-xs-12">

                                {{--todo - form --}}

                                <form class="form-horizontal" action="#" method="POST" style="margin: 20px 0">
                                    {{ csrf_field() }}
                                    {{--<div class="form-group">--}}
                                        {{--<label class="col-sm-2">მიმღები კომპანია</label>--}}
                                        {{--<div class="col-sm-10">--}}
                                            {{--<select name="" id="" class="form-control">--}}
                                                {{--<option value="#"></option>--}}
                                                {{--<option value="#">EU2GEORGIA</option>--}}
                                                {{--<option value="#">SENDEX</option>--}}
                                                {{--<option value="#">TRANSPORTER</option>--}}
                                            {{--</select>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                    <div class="form-group">
                                        <label class="col-sm-2">გზავნილის ნომერი</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" placeholder="">
                                        </div>
                                    </div>
                                    <br><br>
                                    <div class="form-group">
                                        <label class="col-sm-2">გამგზავნი</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control" placeholder="სახელი">
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" placeholder="პ.ნ/ს.კ">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2"></label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" placeholder="მისამართი">
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" placeholder="ქალაქი">
                                        </div>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control" placeholder="ინდექსი">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2"></label>
                                        <div class="col-sm-5">
                                            <select name="" id="" class="form-control">
                                                <option value="#">ა.შ.შ.</option>
                                                <option value="#">გერმანია</option>
                                                <option value="#">ბრიტანეთი</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" placeholder="ტელეფონის ნომერი">
                                        </div>
                                    </div>
                                    <br><br>
                                    <div class="form-group">
                                        <label class="col-sm-2">მიმღები</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control" placeholder="სახელი">
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" placeholder="პ.ნ/ს.კ">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2"></label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" placeholder="მისამართი">
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" placeholder="ქალაქი">
                                        </div>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control" placeholder="ინდექსი">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2"></label>
                                        <div class="col-sm-5">
                                            <select name="" id="" class="form-control">
                                                <option value="#">ა.შ.შ.</option>
                                                <option value="#">გერმანია</option>
                                                <option value="#">ბრიტანეთი</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" placeholder="ტელეფონის ნომერი">
                                        </div>
                                    </div>
                                    <br><br>
                                    <div class="form-group">
                                        <label for="" class="col-sm-2">პროდუქცია</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" placeholder="აღწერილობა">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="" class="col-sm-2"></label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control"placeholder="ღირებულება" >
                                        </div>
                                        <div class="col-sm-2">
                                            <select name="" id="" class="form-control">
                                                <option value="#">USD</option>
                                                <option value="#">EUR</option>
                                                <option value="#">GBP</option>
                                            </select>
                                        </div>
                                    </div>
                                    <br><br>
                                    <div class="form-group">
                                        <label class="col-sm-2">წონა</label>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control" placeholder="რეალური წონა">
                                        </div>
                                        <div class="col-sm-2"></div>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control" placeholder="სიგრძე">
                                        </div>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control" placeholder="სიგანე">
                                        </div>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control" placeholder="სიმაღლე">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2">ღირებულება</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" readonly="" placeholder="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-12 ">
                                            <a class="btn btn-danger pull-right"><i class="fa fa-print"></i> ბეჭდვა</a>
                                            <a class="btn btn-primary pull-right" style="margin-right: 5px"><i class="fa fa-save"></i> შენახვა</a>
                                        </div>
                                    </div>
                                </form>

                            </div>
                            {{-- End-organisation modal--}}
                        </div>

                        {{--  employees  --}}

                        <div class="chart tab-pane active" data-customid="#online"  id="online" style="position: relative; height: 400px; overflow: scroll;">

                            <div class="col-xs-12">

                                {{--todo - form --}}

                                <form class="form-horizontal" action="#" method="POST" style="margin: 20px 0;">
                                    {{ csrf_field() }}

                                    {{--<div class="form-group">--}}
                                        {{--<label class="col-sm-2">მიმღები კომპანია</label>--}}
                                        {{--<div class="col-sm-10">--}}
                                            {{--<select name="" id="" class="form-control">--}}
                                                {{--<option value="#"></option>--}}
                                                {{--<option value="#">EU2GEORGIA</option>--}}
                                                {{--<option value="#">SENDEX</option>--}}
                                                {{--<option value="#">TRANSPORTER</option>--}}
                                            {{--</select>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}

                                    <div class="form-group">
                                        <label class="col-sm-2">გზავნილის ნომერი</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" placeholder="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2">ოთახის ნომერი</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" placeholder="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2">მიმღები</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" >
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2">წონა</label>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control" placeholder="რეალური წონა">
                                        </div>
                                        <div class="col-sm-2"></div>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control" placeholder="სიგრძე">
                                        </div>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control" placeholder="სიგანე">
                                        </div>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control" placeholder="სიმაღლე">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2">ღირებულება</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" readonly="" placeholder="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-12 ">
                                            <a class="btn btn-danger pull-right"><i class="fa fa-print"></i> ბეჭდვა</a>
                                            <a class="btn btn-primary pull-right" style="margin-right: 5px"><i class="fa fa-save"></i> შენახვა</a>
                                        </div>
                                    </div>
                                </form>

                            </div>

                        </div>

                        {{--  End-employees modal  --}}

                        {{--  Dealer modal  --}}

                        {{-- End-Dealer --}}

                    </div>
                </div>
            </section>

            <section class="col-lg-12">
                {{-- @if(count(@$activities) > 0) --}}
                <div class="box box-primary">
                    <div class="box-header">
                        <i class="ion ion-clipboard"></i>

                        <h3 class="box-title">ბოლო ჩანაწერები</h3>
                        <h3 class="box-title pull-right" style="margin: 0 5px;"><a href="#" data-toggle="modal" id="addCustomer" data-target="#CustomerModal"><i class="fa fa-pencil"></i></a></h3>

                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">

                        <form class="form-horizontal" action="#" method="POST">
                            {{ csrf_field() }}
                            <table id="Activities" class="table rangeDate actionioni table-striped table-bordered table-hover dataTables-example-activities " >
                                <thead>
                                <tr>
                                    <th><input type="checkbox" class="example-select-all" name="id[]"></th>
                                    <th>#</th>
                                    <th>თარიღი</th>
                                    <th>
                                        <select name="" id="" class="nostyleSelectBox">
                                            <option value="1">GER</option>
                                            <option value="1">USA</option>
                                        </select>
                                    </th>
                                    <th>გზავნილის ნომერი</th>
                                    <th>ოთახი</th>
                                    <th>მფლობელი</th>
                                    <th>პ.ნ/ს.კ</th>
                                    <th>წონა</th>
                                    <th>ფასი</th>
                                    <th>რეისი</th>
                                    <th>საკურიერო</th>
                                    <th>შეჩერება</th>
                                    <th>სტატუსი</th>
                                </tr>
                                </thead>
                                <tbody>


                                </tbody>

                                <tfoot>
                                <tr>
                                    <th><input type="checkbox" class="example-select-all" name="id[]"></th>
                                    <th>#</th>
                                    <th>თარიღი</th>
                                    <th>
                                        <select name="" id="" class="nostyleSelectBox">
                                            <option value="1">GER</option>
                                            <option value="1">USA</option>
                                        </select>
                                    </th>
                                    <th>გზავნილის ნომერი</th>
                                    <th>ოთახი</th>
                                    <th>მფლობელი</th>
                                    <th>პ.ნ/ს.კ</th>
                                    <th>წონა</th>
                                    <th>ფასი</th>
                                    <th>რეისი</th>
                                    <th>საკურიერო</th>
                                    <th>შეჩერება</th>
                                    <th>სტატუსი</th>
                                </tr>
                                </tfoot>
                            </table>

                        </form>

                    </div>


                </div>
                <!-- /.box -->
            </section>
        </div>
        <!-- /.row (main row) -->
    </section>
    <!-- /.content -->
</div>
    @endsection