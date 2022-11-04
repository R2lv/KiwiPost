<template>
    <div>
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>{{stats.all_parcels ? stats.all_parcels : 0}}</h3>

                    <p>ამანათები</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="#" class="small-box-footer"> </a>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{{stats.total_income ? stats.total_income : 0}}<sup style="font-size: 20px"></sup></h3>

                    <p>შემოსავალი</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="#" class="small-box-footer"></a>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>{{usr_stats.registered ? usr_stats.registered : 0}} - {{usr_stats.users_total ? usr_stats.users_total : 0}}</h3>

                    <p>მომხმარებლები</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="#" class="small-box-footer"></a>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-red">
                <div class="inner">
                    <h3 >{{stats.total_ows ? stats.total_ows : 0}}</h3>

                    <p>დავალიანება</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
                <a href="#" class="small-box-footer"></a>
            </div>
        </div>
    </div>
    <!-- solid sales graph -->
    <div class="box box-solid bg-teal-gradient">
        <div class="box-header">
            <i class="fa fa-th"></i>

            <h3 class="box-title">Sales Graph</h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn bg-teal btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn bg-teal btn-sm" data-widget="remove"><i class="fa fa-times"></i>
                </button>
            </div>
        </div>
        <div class="box-body border-radius-none">
            <div class="chart" id="line-chart" style="height: 250px;"></div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer no-border">
            <div class="row">
                <div class="col-xs-4 text-center" style="border-right: 1px solid #f4f4f4">
                    <input type="text" class="knob" data-readonly="true" value="20" data-width="60" data-height="60" data-fgColor="#39CCCC">

                    <div class="knob-label">Mail-Orders</div>
                </div>
                <!-- ./col -->
                <div class="col-xs-4 text-center" style="border-right: 1px solid #f4f4f4">
                    <input type="text" class="knob" data-readonly="true" value="50" data-width="60" data-height="60" data-fgColor="#39CCCC">

                    <div class="knob-label">Online</div>
                </div>
                <!-- ./col -->
                <div class="col-xs-4 text-center">
                    <input type="text" class="knob" data-readonly="true" value="30" data-width="60" data-height="60" data-fgColor="#39CCCC">

                    <div class="knob-label">In-Store</div>
                </div>
                <!-- ./col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.box-footer -->
    </div>
    <!-- /.box -->
    </div>
</template>
<script>
export default {
    data() {
        return {
            stats: {},
            usr_stats: {},
            displayData:[
                {"year_week":'2018 W0','personal':1599,"online":212},
                {"year_week":'2018 W1','personal':159,"online":2122},
                {"year_week":'2018 W2','personal':15499,"online":0},
                {"year_week":'2018 W2','personal':0,"online":17612},
                {"year_week":'2018 W4','personal':15939,"online":55212},
            ]
        }
    },
    mounted() {




        $(this.$el).find('.knob').knob();

        axios.get("/stats")
            .then(res => {
                if(res.data.success) {
                    this.stats = res.data.result;
                    this.displayData = res.data.result.dt;


                    let element = $(this.$el).find("#line-chart").get(0);
                    let line = new Morris.Line({
                        element: element,
                        resize: true,
                        data:
                            this.displayData
                        ,
                        xkey: 'year_week',
                        ykeys: ['personal','online'],
                        labels: ['personal','online'],
                        lineColors: ['#37288c','#981515'],
                        lineWidth: 2,
                        hideHover: 'auto',
                        gridTextColor: '#000',
                        gridStrokeWidth: 0.8,
                        pointSize: 4,
                        pointStrokeColors: ['#37288c','#981515'],
                        gridLineColor: '#efefff',
                        gridTextFamily: 'Open Sans',
                        gridTextSize: 10
                    });
                }


            });

        axios.get("/usrStats")
            .then(res => {
                if(res.data.success) {
                    this.usr_stats = res.data.result;
                }


            });

    }
}
</script>