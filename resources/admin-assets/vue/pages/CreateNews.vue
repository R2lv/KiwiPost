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

                            <form @submit.prevent="save" ref="form" class="form-horizontal" action="#" enctype="multipart/form-data" method="POST" style="margin: 20px 0;">
                                <div v-show="hasType('en')" data-customid="#online"  id="en" style="position: relative;" class="clearfix">

                                    <div class="form-group">
                                        <label class="col-sm-2">სათაური</label>
                                        <div class="col-sm-10">
                                            <input name="title_en" class="form-control" placeholder="">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2">მოკლე აღწერა</label>
                                        <div class="col-sm-10">
                                            <textarea name="list_description_en" class="form-control" style="resize: vertical;" rows="4"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2">მოკლე აღწერა</label>
                                        <div class="col-sm-10">
                                            <textarea name="full_description_en" id="post"></textarea>
                                        </div>
                                    </div>

                                </div>


                                <div v-show="hasType('ka')" data-customid="#online" id="ka" style="position: relative;" class="clearfix">


                                    <div class="form-group">
                                        <label class="col-sm-2">სათაური</label>
                                        <div class="col-sm-10">
                                            <input name="title_ka" class="form-control" placeholder="">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2">მოკლე აღწერა</label>
                                        <div class="col-sm-10">
                                            <textarea name="list_description_ka" class="form-control" style="resize: vertical;" rows="4"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2">მოკლე აღწერა</label>
                                        <div class="col-sm-10">
                                            <textarea name="full_description_ka" id="post2"></textarea>
                                        </div>
                                    </div>

                                </div>

                                <div class="form-group">
                                    <label class="col-md-2">სურათი</label>
                                    <div class="col-md-10">
                                        <input type="file" name="image" accept="image/*" class="form-control">
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
    data() {
        return {
            type: 'en',
            loading: false
        }
    },
    methods: {
        save() {
            CKEDITOR.instances.post.updateElement();
            CKEDITOR.instances.post2.updateElement();

            let formData = new FormData(this.$refs.form);

            axios.post("/news", formData)
                .then(res => {
                    if(res.data.success) {
                        toastr.success("Post added successfully");
                        this.$refs.form.reset();
                    } else {
                        toastr.error(_(res.data.error).values().value().join("<br>"));
                    }
                })
        },
        setType(type) {
            this.type = type;
        },
        hasType(type) {
            return this.type===type;
        }
    },
    mounted() {
        CKEDITOR.replace('post');
        CKEDITOR.replace('post2');
    }
}
</script>