<section class="col-lg-12 ">

    <!-- Activities -->
    <div class="box box-primary">
        <div class="box-header">
            <i class="ion ion-clipboard"></i>

            <h3 class="box-title">შეკვეთები</h3>
            <h3 class="box-title pull-right" style="margin: 0 5px;"><a href="/orders/create"><i class="fa fa-plus-circle"></i></a></h3>
            <h3 class="box-title pull-right" style="margin: 0 5px;"><a href="#"><i class="fa fa-pencil"></i></a></h3>


        </div>
        <!-- /.box-header -->
        <div class="box-body">

            <input type="text" class="form-control" id="reportrange" placeholder="MIN" style="margin-bottom: 5px;">
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
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
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

            <div class="modal fade modal-fullscreen" id="orderInfo" tabindex="-1" role="dialog" aria-labelledby="">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">დეკლარაცია</div>
                        <div class="modal-body">
                            <form class="form-horizontal" action="#" method="POST">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">მაღაზია</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control onlineStore" >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">ყიდვის ფასი</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control shopPrice" id="" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">კატეგორია</label>
                                    <div class="col-sm-10">
                                        <select name="" id=""  class="form-control category" >
                                            <option value=""></option>
                                            <option value="ავტო ნაწილები">ავტო ნაწილები</option>
                                            <option value="ბიჟუტერია">ბიჟუტერია</option>
                                            <option value="განათება,ჭაღები,ლამპები,ფარები">განათება, ჭაღები, ლამპები, ფარები</option>
                                            <option value="იარაღები და ხელის ინსტრუმენტები">იარაღები და ხელის ინსტრუმენტები</option>
                                            <option value="კომპიუტერი, ლეპტოპი და მათი ნაწილები">კომპიუტერი, ლეპტოპი და მათი ნაწილები</option>
                                            <option value="მედიკამენტები">მედიკამენტები</option>
                                            <option value="მინის ნაწარმი">მინის ნაწარმი</option>
                                            <option value="მუსიკალური ინსტრუმენტები და მათი ნაწილები">მუსიკალური ინსტრუმენტები და მათი ნაწილები</option>
                                            <option value="მცენარეები">მცენარეები</option>
                                            <option value="ნაბეჭდი პროდუქცია, წიგნები, ბროშურა">ნაბეჭდი პროდუქცია, წიგნები, ბროშურა</option>
                                            <option value="ოპტიკური და ფოტო აპარატურა">ოპტიკური და ფოტო აპარატურა</option>
                                            <option value="პარფიუმერია და კოსმეტიკა">პარფიუმერია და კოსმეტიკა</option>
                                            <option value="საათები">საათები</option>
                                            <option value="სათამაშოები და სპორტული ინვენტარი">სათამაშოები და სპორტული ინვენტარი</option>
                                            <option value="საკვები დანამატები">საკვები დანამატები</option>
                                            <option value="ტანსაცმელი, ყველა ტიპის სამოსი">ტანსაცმელი, ყველა ტიპის სამოსი</option>
                                            <option value="ტელეფონი და ქსელური მოსწყობილობები">ტელეფონი და ქსელური მოსწყობილობები</option>
                                            <option value="ფეხსაცმელი">ფეხსაცმელი</option>
                                            <option value="ჩანთები და ჩასადებები">ჩანთები და ჩასადებები</option>
                                            <option value="სხვადასხვა ელექტრონული მოწყობილობები">სხვადასხვა ელექტრონული მოწყობილობები</option>
                                        </select>
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
    <!-- /.box -->

</section>