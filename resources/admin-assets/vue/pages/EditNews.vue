<template>
    <div class="content-wrapper">
        <section class="content">

            <div class="row">

                <section class="col-lg-12" :class="{'loading-box': loading}">
                    <spinner></spinner>
                    <div class="nav-tabs-custom" id="configuration">
                        <ul class="nav nav-tabs pull-right">
                            <li class="pull-left header"><i class="fa fa-inbox"></i> სიახლის დამატება</li>
                            <li :class="{'active': hasType('ka')}"><a href="#" @click.prevent="setType('ka')">ქართული</a></li>
                            <li :class="{'active': hasType('en')}"><a href="#" @click.prevent="setType('en')">ინგლისური</a></li>

                        </ul>
                        <div class="tab-content col-md-12" id="configuration-forms">

                            <form @submit.prevent="save" ref="form" class="form-horizontal" action="#" method="POST" style="margin: 20px 0;">
                                <div v-show="hasType('en')" data-customid="#online"  id="en" style="position: relative;" class="clearfix">

                                    <div class="form-group">
                                        <label class="col-sm-2">სათაური</label>
                                        <div class="col-sm-10">
                                            <input v-model="mdl.title_en" class="form-control" placeholder="">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2">მოკლე აღწერა</label>
                                        <div class="col-sm-10">
                                            <textarea v-model="mdl.list_description_en" class="form-control" style="resize: vertical;" rows="4"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2">სრული სტატია</label>
                                        <div class="col-sm-10">
                                            <textarea v-model="mdl.full_description_en" v-cloak class="form-control" id="post"></textarea>
                                        </div>
                                    </div>

                                </div>


                                <div v-show="hasType('ka')" data-customid="#online" id="ka" style="position: relative;" class="clearfix">


                                    <div class="form-group">
                                        <label class="col-sm-2">სათაური</label>
                                        <div class="col-sm-10">
                                            <input v-model="mdl.title_ka" class="form-control" placeholder="">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2">მოკლე აღწერა</label>
                                        <div class="col-sm-10">
                                            <textarea v-model="mdl.list_description_ka" class="form-control" style="resize: vertical;" rows="4"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2">სრული სტატია</label>
                                        <div class="col-sm-10">
                                            <textarea v-model="mdl.full_description_ka" class="form-control" id="post2"></textarea>
                                        </div>
                                    </div>

                                </div>

                                <div class="form-group">
                                    <label class="col-md-2">სურათი</label>
                                    <div class="col-md-10">
                                        <input type="file" ref="image" accept="image/*" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-lg-12 ">
                                        <button class="btn btn-primary pull-right" style="margin-right: 5px"><i class="fa fa-save"></i>&nbsp;&nbsp; შენახვა</button>
                                    </div>
                                </div>

                            </form>

                        </div>
                    </div>
                </section>

            </div>
            <!-- /.row (main row) -->
        </section>
        <!-- /.content -->
    </div>

</template>

<script>
export default {
    mounted() {
        axios.get("/news/"+this.$route.params.id+"/edit")
            .then(res => {
                if(res.data.success) {
                    this.mdl = res.data.result;

                    setTimeout(()=>{
                        CKEDITOR.replace('post');
                        CKEDITOR.replace('post2');

                        this.loading = false;
                    })
                }
            })
    },
    data() {
        return {
            mdl: {
                name_en: "",
                name_ka: "",

                list_description_en: "",
                list_description_ka: "",

                full_description_en: "",
                full_description_ka: "",
            },
            type: 'en',
            loading: true
        }
    },
    methods: {
        setType(type) {
            this.type = type;
        },
        hasType(type) {
            return this.type===type;
        },
        save() {
            CKEDITOR.instances.post.updateElement();
            CKEDITOR.instances.post2.updateElement();

            this.mdl.full_description_en = CKEDITOR.instances.post.getData();
            this.mdl.full_description_ka = CKEDITOR.instances.post2.getData();
            let formData = new FormData();

            _(this.mdl).forOwn((val,key) => {
                formData.append(key,val);
            });
            if(this.$refs.image.files.length)
                formData.append("image", this.$refs.image.files[0]);
            formData.append("_method", "PUT");

            axios.post("/news/"+this.$route.params.id, formData)
                .then(res => {
                    if(res.data.success) {
                        toastr.success("Success");
                    } else {
                        toastr.error(_(res.data.error).values().join("<br>"));
                    }
                })

        }
    }
}
</script>