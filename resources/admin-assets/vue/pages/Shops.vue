<template>
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                Shops
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> მთავარი</a></li>
            </ol>
        </section>
        <section class="content">

            <div class="row">
                <section class="col-lg-6">
                    <!-- Activities -->
                    <div class="box box-primary">
                        <div class="box-header">
                            <i class="ion ion-clipboard"></i>

                            <h3 class="box-title">Add Categories</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body" :class="{'loading-box': loading_categories}">
                            <spinner></spinner>
                            <table id="dataTable-categories" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>TITLE EN</th>
                                    <th>TITLE KA</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="category in categories">
                                    <td>{{ category.title_en}}</td>
                                    <td>{{ category.title_ka}}</td>
                                </tr>
                                </tbody>
                            </table>
                            <hr>
                            <div class="row" :class="{'loading-box': catsAdding}">

                                <spinner></spinner>
                                <div class="col-md-5 col-sm-12">
                                    <div class="form-group" :class="{'has-error':catsErrorEn}">
                                        <input type="text"  v-model="cats.title_en" class="form-control" placeholder="Title En">
                                    </div>
                                </div>
                                <div class="col-md-5 col-sm-12">
                                    <div class="form-group" :class="{'has-error':catsErrorKa}">
                                        <input type="text"  class="form-control" v-model="cats.title_ka" placeholder="Title Ka">
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-success col-md-12 col-sm-12" @click.prevent="AddNewCategory()">Save</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </section>
                <section class="col-lg-6">
                    <!-- Activities -->
                    <div class="box box-primary">
                        <div class="box-header">
                            <i class="ion ion-clipboard"></i>

                            <h3 class="box-title">Add Shops</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body" :class="{'loading-box': loading_shops}">
                            <spinner></spinner>
                            <table id="dataTable-shops" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>TITLE</th>
                                    <th>Categories</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="shop in shopsList">
                                    <td><a href="#">{{ shop.title }}</a></td>
                                    <td>
                                        <span v-for="cat in shop.categories">{{ cat.title }} | </span>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <hr>
                            <div class="row" :class="{'loading-box': shopsAdding}">
                                <spinner></spinner>
                                <div class="col-md-3 col-sm-12">
                                    <div class="form-group" :class="{'has-error':shopsErrorTitle}">
                                        <input type="text" v-model="shops.title_en" class="form-control" placeholder="Title En">
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group" :class="{'has-error':shopsErrorUrl}">
                                        <input type="text" v-model="shops.url" class="form-control" placeholder="URL">
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-12">
                                    <div class="form-group" :class="{'has-error':shopsErrorCategories}">
                                        <select-2 class="form-control"  :options="{width: '100%', dropdownAutoWidth: true,placeholder:'კატეგორიები'}" multiple @change="catsChanged">
                                            <option v-for="category in categories" :value="category.id">{{ category.title_en }}</option>
                                        </select-2>
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-12">
                                    <div class="form-group">
                                        <button class="btn btn-success col-md-12 col-sm-12" @click.prevent="AddNewShop()">Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </section>


    </div>
</template>

<script>
    export default {
        data(){
            return{
                loading_shops:true,
                loading_categories:true,
                catsAdding:false,
                shopsAdding:false,
                shopsList:[],
                categories:[],
                cats:{"title_en":'',"title_ka":''},
                shops:{"title_en":'',"url":'',categoryIds:[]},
                catsErrorKa:false,
                catsErrorEn:false,
                shopsErrorTitle:false,
                shopsErrorUrl:false,
                shopsErrorCategories:false,
                csrf_token:"",

            }
        },
        methods:{
            getShops(){
                this.loading_shops = true;
                axios.get("/shops")
                    .then(res => {
                        if(res.data.success) {
                            this.shopsList = res.data.result;
                            this.loading_shops = false;
                            setTimeout(()=>{
                                $("#dataTable-shops").dataTable().fnDestroy();
                                $("#dataTable-shops").DataTable({
                                    scrollY:        '30vh',
                                    scrollCollapse: true,
                                    "order": [[ 0, "asc" ]],
                                    "pageLength" : 550,
                                    'lengthChange': true,
                                    'searching'   : true,
                                    'ordering'    : true,
                                    'info'        : true,
                                    'autoWidth'   : false
                                });
                            },300);

                        }
                    });
            },
            getCategories(){
                this.loading_categories = true;
                axios.get("/categories")
                    .then(res => {
                        if(res.data.success) {
                            this.categories = res.data.result;
                            this.loading_categories = false;
                            setTimeout(()=>{
                                $("#dataTable-categories").dataTable().fnDestroy();
                                setTimeout(()=>{
                                    $("#dataTable-categories").DataTable({
                                        scrollY:        '30vh',
                                        scrollCollapse: true,
                                        "order": [[ 0, "asc" ]],
                                        "pageLength" : 550,
                                        'paging'      : false,
                                        'lengthChange': false,
                                        'searching'   : true,
                                        'ordering'    : true,
                                        'info'        : true,
                                        'autoWidth'   : false
                                    });
                                },4000);
                            },300);
                        }
                    });
            },
            AddNewShop(){

                this.shopsErrorTitle = false;
                this.shopsErrorUrl = false;
                if(this.shops.title_en == "") this.shopsErrorTitle = true;
                if(this.shops.url == "") this.shopsErrorUrl = true;
                if(this.shops.title_en !="" && this.shops.url !="") {

                    this.shopsAdding = true;
                    axios.post("/shops",{
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        'title': this.shops.title_en,
                        'url': this.shops.url,
                        'category_ids':this.shops.categoryIds,
                        '_token': this.csrf_token
                    })
                        .then(res => {
                            if(res.data.success) {
                                this.shops.title_en = '';
                                this.shops.url = '';
                                this.shops.categoryIds.length = 0;
                                this.shopsAdding = false;
                                $(".select2-selection__choice").each(function(){ $(".select2-selection__choice .select2-selection__choice__remove").click(); });
                                setTimeout(()=>{
                                    this.getShops();
                                },300);

                            }
                        });


                }
            },
            AddNewCategory(){
                this.catsErrorEn = false;
                this.catsErrorKa = false;
                if(this.cats.title_en == "") this.catsErrorEn = true;
                if(this.cats.title_ka == "") this.catsErrorKa = true;
                if(this.cats.title_en != "" && this.cats.title_ka !="") {

                    console.log("cats added");
                    console.log(this.cats.title_en + " and " + this.cats.title_ka);
                    this.catsAdding = true;
                    axios.post("/categories",{
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        'title_en': this.cats.title_en,
                        'title_ka': this.cats.title_ka,
                        '_token': this.csrf_token
                    })
                        .then(res => {
                            if(res.data.success) {
                                this.getCategories();
                                this.cats.title_en = '';
                                this.cats.title_ka = '';
                                this.catsAdding = false;
                            }
                        });


                }
            },
            catsChanged(e) {
                this.shops.categoryIds = $(e.currentTarget).val();
            }
        },
        mounted(){
            this.getShops();
            this.getCategories();
            this.csrf_token = $('meta[name="csrf-token"]').attr('content');
        }
    }
</script>

<style scoped>

</style>