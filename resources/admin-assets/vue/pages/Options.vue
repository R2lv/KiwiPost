<template>
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

            <div class="row">

                <section class="col-lg-12 connectedSortable">

                    <div class="nav-tabs-custom" id="configuration">
                        <ul class="nav nav-tabs pull-right">
                            <li><a href="#"  data-toggle="modal" id="addCustomConfigs" data-target="#operatorsModal"><i class="fa fa-plus"></i></a></li>
                            <li class="active"><a href="#operator" data-toggle="tab">ორგანიზაცია</a></li>
                            <li><a href="#group" data-toggle="tab">თანამშრომლები</a></li>
                            <li class="pull-left header"><i class="fa fa-inbox"></i> კონფიგურაცია</li>
                        </ul>
                        <div class="tab-content no-padding" id="configuration-forms">
                            <!-- Morris chart - Sales -->
                            <div class="chart tab-pane active" data-customid="#operatorsModal" id="operator" style="position: relative;">

                                <div class="col-xs-12">
                                    <div class="scrollPane">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>დასახელება</th>
                                                    <th>საიდენტიფიკაციო კოდი</th>
                                                    <th>ტელეფონის ნომერი</th>
                                                    <th>მისამართი</th>
                                                    <th><i class="fa fa-pencil"></i></th>
                                                </tr>
                                            </thead>
                                            <tbody>
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
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="modal fade modal-fullscreen" id="operatorsModal" tabindex="-1" role="dialog" aria-labelledby="">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    ორგანიზაცია
                                                </div>
                                                <div class="modal-body">
                                                    <form class="form-horizontal" action="#" method="POST">
                                                        <!--{{ csrf_field() }}-->
                                                        <div class="form-group">
                                                            <label class="col-sm-4 control-label">ორგანიზაცია</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control" placeholder="Berlinparts.com">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-4 control-label">საიდენტიფიკაციო კოდი</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control" placeholder="">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-4 control-label">ტელეფონის ნომერი</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control" placeholder="">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-4 control-label">მისამართი</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control" placeholder="">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-4 control-label">ინდექსი</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control" placeholder="">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-4 control-label">ტარიფი</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control" placeholder="">
                                                            </div>
                                                        </div>


                                                        <div class="form-group">
                                                            <div class="col-sm-offset-4 col-sm-8">
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">

                                                    <button style="margin-left: 10px;" class="btn btn-success pull-right">save</button>

                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>

                            <div class="chart tab-pane" data-customid="#groupsModal"  id="group" style="position: relative; max-height: 500px; overflow-y: auto;">

                                <div class="col-xs-12">
                                    <div class="scrollPane">
                                    <table class="table table-hover">
                                        <thead>
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
                                        </thead>
                                        <tbody>
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
                                        </tbody>

                                    </table>
                                    </div>

                                    <div class="modal fade modal-fullscreen " id="groupsModal" tabindex="-1" role="dialog" aria-labelledby="">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">

                                                    თანამშრომლის დამატება

                                                </div>
                                                <div class="modal-body">
                                                    <form class="form-horizontal" >

                                                        <div class="form-group">
                                                            <label class="col-sm-2 control-label">სახელი</label>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control" name="" placeholder="თანამშრომლის სახელი">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-2 control-label">გვარი</label>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control" name="" placeholder="თანამშრომლის გვარი">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-2 control-label">ტელეფონის ნომერი</label>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control" name="" placeholder="თანამშრომლის ტელ. ნომერი">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-2 control-label">ელ-ფოსტა</label>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control" name="" placeholder="თანამშრომლის ელ-ფოსტა">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-2 control-label">ორგანიზაცია</label>
                                                            <div class="col-sm-10">
                                                                <select  class="form-control" id="districtSelectAction">
                                                                    <option value=""></option>

                                                                    <option value="1">Berlinparts</option>
                                                                    <option value="id">Aka motors</option>

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



                            <div class="chart tab-pane " data-customid="#districtsModal"  id="district" style="position: relative; max-height: 500px; overflow-y: auto;">
                                <div class="col-xs-12">
                                    <table class="table table-hover ">
                                        <tr>
                                            <th>#</th>
                                            <th>დასახელება</th>
                                            <th>ელ-ფოსტა</th>
                                            <th>ფასნამატი (%)</th>
                                            <th><i class="fa fa-pencil"></i></th>
                                        </tr>

                                        <tr>
                                            <td>1</td>
                                            <td><a href="#">გარი</a></td>
                                            <td><a href="#">gariGermany@gmail.com</a></td>
                                            <td><a href="#">15</a></td>
                                            <td><a href="#"><i class="fa fa-pencil"></i></a></td>
                                        </tr>

                                    </table>
                                    <div class="modal fade modal-fullscreen" id="districtsModal" tabindex="-1" role="dialog" aria-labelledby="">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">

                                                    მომწოდებლის დამატება

                                                </div>
                                                <div class="modal-body">
                                                    <form class="form-horizontal">

                                                        <div class="form-group">
                                                            <label class="col-sm-2 control-label">დასახელება</label>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control" name="" placeholder="მომწოდებლის დასახელება">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-2 control-label">ელ-ფოსტა</label>
                                                            <div class="col-sm-10">
                                                                <input type="email" class="form-control" name="" placeholder="მომწოდებლის ელ-ფოსტა">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-2 control-label">ფასნამატი</label>
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



                        </div>
                    </div>
                </section>

                <!-- /.Left col -->


                <!-- right col (We are only adding the ID to make the widgets sortable)-->
                <section class="col-lg-12 connectedSortable">

                    <div class="box box-primary">
                        <div class="box-header">
                            <i class="ion ion-clipboard"></i>

                            <h3 class="box-title">გლობალური პარამეტრები</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <form class="form-horizontal">
                                <!--{{ csrf_field() }}-->
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">ტარიფი</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="" value="6.5" placeholder="ძირითადი ფასნამატი">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">ორგანიზაცია</label>
                                    <div class="col-sm-9">
                                        <select  class="form-control" id="districtSelectAction2">
                                            <option value=""></option>

                                            <option value="1" selected>SENDEX</option>
                                            <option value="id">GZAVNILI</option>

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
</template>

<script>
export default {
    mounted() {
        $(this.$el).find('.connectedSortable').sortable({
            placeholder         : 'sort-highlight',
            connectWith         : '.connectedSortable',
            handle              : '.box-header, .nav-tabs',
            forcePlaceholderSize: true,
            zIndex              : 999999
        });
        $(this.$el).find('.connectedSortable .box-header, .connectedSortable .ui-sortable-handle').css('cursor', 'move');
        $(this.$el).find(".scrollPane").slimScroll({
            height: 500
        });
    }
}
</script>