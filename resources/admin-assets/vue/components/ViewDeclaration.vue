<template>
    <div class="modal fade" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body" :class="{'loading-box': loading}" style="min-height: 100px;">
                    <spinner />
                    <table class="table table-bordered printable">
                        <tbody>
                        <tr>

                            <td>
                                {{'tracking_number'|translate}}
                            </td>
                            <td>
                                {{order.tracking_number}}
                            </td>
                        </tr>
                        <tr>

                            <td>
                                {{'price'|translate}}
                            </td>
                            <td>
                                {{order.obtain_cost}} {{order.obtain_currency}}
                            </td>
                        </tr>
                        <tr>

                            <td>
                                {{'country_from'|translate}}
                            </td>
                            <td>
                                {{order.sender ? order.sender.country.name : ""}}
                            </td>
                        </tr>
                        <tr>

                            <td>
                                {{'country_to'|translate}}
                            </td>
                            <td>
                                {{order.user ? order.user.country.name : ""}}
                            </td>
                        </tr>
                        <tr>

                            <td>
                                {{'website'|translate}}
                            </td>
                            <td>
                                {{order.obtain_webstore}}
                            </td>
                        </tr>
                        <tr>

                            <td>
                                {{'categories'|translate}}
                            </td>
                            <td>
                                {{categories}}
                            </td>
                        </tr>
                        <tr>

                            <td>
                                {{'comment'|translate}}
                            </td>
                            <td>
                                {{order.comment}}
                            </td>
                        </tr>
                        <tr v-if="order.obtain_invoice">
                            <td>
                                {{'invoice'|translate}}
                            </td>
                            <td>
                                <a :href="'/json/orders/'+order.id" target="_blank">{{'view'|translate}}</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
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