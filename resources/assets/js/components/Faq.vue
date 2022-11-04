<template>
    <div class="faq geo">
        <!--
        <div class="faq-answers">
            <div class="msg static">
                გამარჯობა, რით შეგვიძლია დაგეხმაროთ? აირჩიეთ  სასურველი კითხვა
            </div>
            <div class="msg q" v-show="activeQuestion.q">
                {{activeQuestion.q}}
            </div>
            <div class="msg a" v-show="activeQuestion.a">
                {{activeQuestion.a}}
            </div>
        </div>
        -->
        <div class="faq-questions">
            <ul class="qList geo"  >
                <li :class="{'loading-box': loading}" v-if="loading" style="margin-top: 40px;">
                    <spinner></spinner>
                </li>
                <li v-for="q in questions" @click.prevent="activateQuestion(q)">
                    <a href="#" class="upper">{{ q.q }} <img src="/images/arr-down-tiny-grey.png" alt=""></a>
                    <div class="msg a lower" style="display: none;" v-html="q.a"></div>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            loading:true,
            questions: [],
            activeQuestion: {}
        }
    },
    mounted() {/*
        $(this.$el).find(".qList").find(".msg").each((i,e) => {
            $(e).css({height: $(e).outerHeight()});
            this.activateQuestion(this.questions[i]);
            setTimeout(()=> {
                this.questions[i].initialized = true;
                $(e).parent().addClass("initialized");
            });
        });*/

        this.getQuestions();
    },
    methods: {
        activateQuestion(q) {
//            q.active = !q.active;
        },
        getQuestions(){
            axios.get("/json/faq")
                .then(res => {
                    if(res.data.success) {
                        this.questions = res.data.result.questions;
                        // console.log(res.data);
                        this.loading = false;
                        setTimeout(()=>{
                            this.activateEventListeners();
                        });
                    }
                })
                .catch((err) => {
                    this.loading = false;
                    console.log("Error", err);
                })
        },
        activateEventListeners(){
            $(this.$el).find(".qList").find("li").find("a").click(function(e){
//            console.log($(this).parent());
                $(this).parent().toggleClass("active");
                $(this).parent().find(".a").slideToggle();
            });
        }
    }
}
</script>

