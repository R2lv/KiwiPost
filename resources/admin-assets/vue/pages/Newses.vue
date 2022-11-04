<template>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            სიახლეები
            <small>სამართავი პანელი</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> მთავარი</a></li>
        </ol>
    </section>
    <section class="content">

        <div class="row">
            <section class="col-lg-12">

                <!-- Activities -->
                <div class="box box-primary">
                    <div class="box-header">
                        <i class="ion ion-clipboard"></i>

                        <h3 class="box-title">სიახლეები</h3>
                        <h3 class="box-title pull-right" style="margin: 0 5px;"><router-link :to="'/news/create'"><i class="fa fa-plus-circle"></i></router-link></h3>
                        <h3 class="box-title pull-right" style="margin: 0 5px;"><a href="#"><i class="fa fa-pencil"></i></a></h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body" :class="{'loading-box': loading}">
                        <spinner></spinner>

                        <ul class="products-list products-list-in-box">
                            <li class="item" v-for="item in list">
                                <div class="product-img">
                                    <img :src="item.image_url" alt="Product Image">
                                </div>
                                <div class="product-info">
                                    <a href="javascript:void(0)" class="product-title">
                                        {{item.title}}

                                        <div class="btn-group btn-group-xs pull-right">
                                            <router-link tag="button" :to="'/news/'+item.id+'/edit'" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i></router-link>
                                            <button class="btn btn-danger btn-xs" @click.prevent="deleteItem(item)"><i class="fa fa-close"></i></button>
                                        </div>
                                    </a>
                                    <span class="product-description">
                                        {{item.list_description}}
                                    </span>
                                </div>
                            </li>
                        </ul>

                        <ul class="pagination pull-right" v-if="pagination.last_page!=1">
                            <li v-if="1 < pagination.current_page - pagination.radius"><a @click.prevent="fetch(1)" href="#">&laquo;</a></li>
                            <li v-for="page in pagination.pages" :class="{active: pagination.current_page === page}"><a @click.prevent="fetch(page)" href="#">{{page}}</a></li>
                            <li v-if="pagination.last_page > pagination.current_page + pagination.radius"><a @click.prevent="fetch(pagination.last_page)" href="#">&raquo;</a></li>
                        </ul>

                    </div>
                </div>
                <!-- /.box -->

            </section>
        </div>
    </section>

    <div class="modal modal-danger fade" id="delete-modal" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Removing post</h4>
                </div>
                <div class="modal-body">
                    <p>You are deleting post {{deleting && deleting.title}}, this action can not be undone, are you sure ?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-outline" @click="confirmDelete">Delete</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>
</template>

<script>

export default {
    beforeCreate() {
    },
    data() {
        return {
            list: [],
            page: 1,
            length: 20,
            mdl: {},
            pagination: {
                radius: 3
            },
            loading: true,
            deleting: {}
        }
    },
    methods: {
        fetch(page, force) {
            if(this.pagination.current_page === page && !force) return;
            this.loading = true;
            axios.get("/news?page="+page)
                .then(res => {
                    if(res.data.success) {
                        this.list = res.data.result.data;

                        this.pagination.pages = [];
                        this.pagination.current_page = res.data.result.current_page;

                        for(let i = res.data.result.current_page - this.pagination.radius; i <= res.data.result.current_page+this.pagination.radius; i++) {
                            if(i>0 && i <= res.data.result.last_page) {
                                this.pagination.pages.push(i);
                            }
                        }

                        this.pagination.last_page = res.data.result.last_page;
                        this.pagination.first_page = res.data.result.first_page;

                        this.loading = false;

                    }
                })
        },

        deleteItem(item) {
            this.deleting = item;
            $("#delete-modal").modal("show");
        },

        confirmDelete() {
            axios.delete("/news/"+this.deleting.id)
                .then(res => {
                    if(res.data.success) {
                        $("#delete-modal").modal("hide");
                        toastr.success("News deleted successfully","Deleted successfully");
                        this.fetch(this.pagination.current_page, true);
                    }
                });
        }
    },
    mounted() {
        this.fetch(1);
        $("#delete-modal").on("hidden.bs.modal", e => {
            this.deleting = {};
        })
    }
}
</script>