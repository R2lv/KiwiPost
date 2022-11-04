<script>

let LoginComponent = Vue.extend(require("./Login.vue")),
    EditEmailComponent = Vue.extend(require("./EmailEdit.vue")),
    PaymentComponent = Vue.extend(require("./Payment.vue")),
    PayParcelComponent = Vue.extend(require("./PayParcel.vue")),
    ContactComponent = Vue.extend(require("./Contact.vue")),
    PasswordRecoveryComponent = Vue.extend(require("./PasswordReset.vue")),
    EditProfileComponent = Vue.extend(require("./EditProfile.vue")),
    RegisterComponent = Vue.extend(require("./Register.vue")),
    AddParcelComponent = Vue.extend(require("./AddParcel.vue"));

let iOS = !!navigator.platform && /iPad|iPhone|iPod/.test(navigator.platform);
export default {
    methods: {
        showLoginWindow() {

            if(this.checkDevice('login')) return;

            let p = showPopup(false, "<div id='login-container'></div>", false);
            let self = this;
            let c = new LoginComponent({
                el: $(p.root).find("#login-container").get(0),
                mounted() {
                    p.show();
                },
                data() {
                    return {
                        showRegButton: false
                    }
                },
                methods: {
                    showRegistrationWindow() {
                        p.exit();
                        self.showRegistrationWindow();
                    },
                    showPasswordRecoveryWindow() {
                        p.exit();
                        self.showPasswordRecoveryWindow();
                    }
                }
            });
        },
        showRegistrationWindow() {

            if(this.checkDevice('register')) return;

            let p = showPopup(false, "<div id='registration-container'></div>", false);
            let self = this;
            let c = new RegisterComponent({
                el: $(p.root).find("#registration-container").get(0),
                mounted() {
                    p.show();

                    $(window).trigger("resize");
                },
                methods: {
                    showLoginWindow() {
                        p.exit();
                        self.showLoginWindow();
                    }
                }
            });
        },
        showEditEmailWindow() {
            let p = showPopup(false, "<div id='edit-email-container'></div>", false);
            let c = new EditEmailComponent({
                el: $(p.root).find("#edit-email-container").get(0),
                mounted() {
                    p.show();

                    $(window).trigger("resize");
                }
            });
        },
        showPaymentWindow() {
            let p = showPopup("Add payment", "<div id='payment-container'></div>");
            let c = new PaymentComponent({
                el: $(p.root).find("#payment-container").get(0),
                mounted() {
                    p.show();

                    $(window).trigger("resize");
                }
            });
        },
        showPayParcelWindow(parcel) {
            let p = showPopup(this.lang('add_payment'), "<div id='pay-parcel-container'></div>");
            let c = new PayParcelComponent({
                el: $(p.root).find("#pay-parcel-container").get(0),
                mounted() {
                    p.show();
                    $(window).trigger("resize");
                },
                props: {
                    parcel: {
                        'default'() {return parcel;}
                    }
                }
            });
        },
        showContactWindow(country) {
            if(this.checkDevice('contact', country)) return;

            let p = showPopup(false, "<div id='contact-container'></div>", false);
            let c = new ContactComponent({
                el: $(p.root).find("#contact-container").get(0),
                mounted() {
                    p.show();
                    $(window).trigger("resize");
                },
                props: {
                    customData: {
                        'default': country
                    },
                    p: {
                        'default'() {
                            return p;
                        }
                    }
                }
            });
        },
        showPasswordRecoveryWindow() {
            let p = showPopup(false, "<div id='pass-recovery-container'></div>", false);
            let c = new PasswordRecoveryComponent({
                el: $(p.root).find("#pass-recovery-container").get(0),
                mounted() {
                    p.show();

                    $(window).trigger("resize");
                }
            });

            $(p.root).find(".login-btn").click(function(e) {
                e.preventDefault();
                p.exit();
                this.showLoginWindow();
            }.bind(this));
        },
        showProfileEditWindow(e, view) {
            if(this.checkDevice('edit-profile', view)) return;

            if(e)
                $(e.currentTarget).parent().parent().removeClass("open");
            let p = showPopup(this.lang("profile_options"), "<div id='edit-profile-container'></div>", false, ['profile-edit-popup']);
            let c = new EditProfileComponent({
                el: $(p.root).find("#edit-profile-container").get(0),
                data() {
                    return {
                        autoStep: view || 'main',
                        popup: p
                    }
                }
            });
        },

        showAddParcelWindow() {

            if(this.checkDevice('add-package')) return;

            let p = showPopup(false, "<div id='add-parcel-container'></div>",false,'declaration-popup');

            let reg = new AddParcelComponent({
                el: $(p.root).find("#add-parcel-container").get(0),
                mounted() {
                    p.show();
                }
            });
        },

        checkDevice(page, data) {
            if(!data) data = '';
            else data = "?data="+data;
            if($(window).width() <= 600 || iOS) {
                location.href = '/component/'+page+data;
                return true;
            }

            return false;
        }
    },
    components: {
        Login: LoginComponent,
        Register: RegisterComponent,
        AddPackage: AddParcelComponent,
        EditProfile: EditProfileComponent,
        Contact: ContactComponent
    }
}
</script>