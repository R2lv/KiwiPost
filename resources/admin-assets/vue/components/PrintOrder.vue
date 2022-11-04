
<template>
    <div class="modal fade" style="display: none;">
        <div class="modal-dialog" style="width: 650px;">
            <div class="modal-content">
                <div class="modal-body" :class="{'loading-box': loading}" style="min-height: 100px;">
                    <spinner />
                    <table class="table table-bordered printable" v-if="order.type">
                        <tbody>
                        <tr>
                            <td colspan="4">
                                <div class="row">
                                    <div class="col col-xs-4">
                                        <div>KIWIPOST</div>
                                        <div>KIWI STANDARD LTD</div>
                                        <div>19 New College Parade</div>
                                        <div>Finchley Road,</div>
                                        <div>London, NW3 5EP</div>
                                        <div>Tel: +442074490312</div>
                                    </div>
                                    <div class="col col-xs-4 text-center">
                                        <img src="/images/logo.png" alt="">
                                    </div>
                                    <div class="col col-xs-4 text-right">
                                        <div>KIWI LTD</div>
                                        <div>A. Tsagareli street #60</div>
                                        <div>Tbilisi, index 0194</div>
                                        <div>Tel: (+995 032) 2052324</div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>

                            <td colspan="2" class="half">
                                #{{order.id}}
                            </td>
                            <td colspan="2">
                                Date: {{moment(order.created_at).format('Y-M-D')}}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="half text-center">SENDER</td>
                            <td colspan="2" class="half text-center">RECEIVER</td>
                        </tr>
                        <tr>
                            <td width="20%">NAME</td>
                            <td width="30%">{{order.sender.name}}</td>
                            <td width="20%">NAME</td>
                            <td width="30%">{{order.user.name}}</td>
                        </tr>
                        <tr>
                            <td width="20%">SURNAME</td>
                            <td width="30%">{{order.sender.surname}}</td>
                            <td width="20%">SURNAME</td>
                            <td width="30%">{{order.user.surname}}</td>
                        </tr>
                        <tr>
                            <td width="20%">COUNTRY</td>
                            <td width="30%">{{order.sender.country.name}}</td>
                            <td width="20%">COUNTRY</td>
                            <td width="30%">{{order.user.country.name}} &nbsp;{{order.user.city_town}}</td>
                        </tr>
                        <tr>
                            <td class="half" colspan="2"></td>
                            <td width="20%" colspan="1">ADDRESS</td>
                            <td width="30%" colspan="1">{{order.user.address_1}}</td>
                        </tr>

                        <tr>
                            <td width="20%">TEL:</td>
                            <td width="30%">{{order.sender.mobile}}</td>
                            <td width="20%">TEL:</td>
                            <td width="30%">{{order.user.mobile}}</td>
                        </tr>

                        <tr>
                            <td class="half" style="padding: 0" colspan="2">
                                <table class="table inner" border="0">
                                    <tbody>
                                    <tr>
                                        <td width="60%">CHARGEABLE WEIGHT <span class="pull-right">KG</span></td>
                                        <td width="40%">{{order.weight}}</td>
                                    </tr>
                                    <tr>
                                        <td width="60%">TRANSPORTATION COST <span class="pull-right">£</span></td>
                                        <td width="40%">{{order.cost}}</td>
                                    </tr>
                                    <tr>
                                        <td width="60%">VALUE <span class="pull-right">£</span></td>
                                        <td width="40%">{{order.obtain_cost}}</td>
                                    </tr>
                                    <tr>
                                        <td width="60%">PLEASE SIGN the box if you agree with our terms & conditions</td>
                                        <td width="40%"></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </td>
                            <td class="half" colspan="2">{{categories}}</td>
                        </tr>
                        <tr>
                            <td colspan="2" style="vertical-align: middle">CUSTOMER SIGNATURE</td>
                            <td style="vertical-align: middle" rowspan="2" colspan="2" class="text-center">
                                <barcode width="2" height="50" :value="order.tracking_number" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="vertical-align: middle">OPERATOR SIGNATURE</td>
                        </tr>
                        </tbody>
                    </table>
                    <div v-else-if="order.type===0" class="printable">
                        <div class="row">
                            <div class="col col-xs-3 text-center" style="height: 95px; line-height: 95px;">
                                <img src="/images/logo.png" alt="">
                            </div>
                            <div class="col col-xs-9 text-right">
                                <barcode width="2" height="50" v-if="order.tracking_number" :value="order.tracking_number" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" v-if="!loading">
                    <div class="pull-right">
                        <button type="button" class="btn btn-primary" onclick="window.print()">Print</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</template>
<script>
	export default {
		data() {
			return {
				loading: false,
				order: {}
			}
		},
		mounted() {
			$(this.$el).on("hide.bs.modal", this.closing);
			$(this.$el).on("show.bs.modal", this.showing);
		},
		methods: {
			show(id) {
				console.log(this.order);
				$(this.$el).modal("show");
				this.loading = true;
				this.order = {};
				axios.get("/order/"+id)
					.then(res => {
						if(res.data.success) {
							this.order = res.data.result;
						}
						this.loading = false;
					});
			},
			close() {
				$(this.$el).modal("hide");
			},
			closing() {
				this.loading = false;
			},
			showing(e) {

			}
		},
		computed: {
			categories() {
				return _(this.order.category).map(item => {
					return item.name;
				}).join(", ");
			}
		}
	}
</script>