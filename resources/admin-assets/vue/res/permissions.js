let permissions = {
    Permissions: {
        PARCEL_ADD: "PARCEL_ADD",
        PARCEL_DELETE: "PARCEL_DELETE",
        PARCEL_VIEW_ALL: "PARCEL_VIEW_ALL",
        PARCEL_CHANGE_STATUS: "PARCEL_CHANGE_STATUS",
        PARCEL_MAKE_PAYMENT: "PARCEL_MAKE_PAYMENT",
        PARCEL_EXPORT: "PARCEL_EXPORT",
        VIEW_STATISTICS: "VIEW_STATISTICS",
        ARTICLE_ADD: "ARTICLE_ADD",
        SEE_USERS: "SEE_USERS",
        ALL: "ALL",
    },
};
export default {
    install(Vue) {
        Vue.mixin({
            data() {
                return permissions;
            },
            methods: {
                hasPermission(perm) {
                    if(this.isSuperAdmin()) return true;
                    return typeof window.__roles === 'object' && window.__roles[perm];
                },
                hasAnyPermission(...params) {
                    if(this.isSuperAdmin()) return true;
                    let result = false;
                    params.forEach(param=>{
                        if(this.hasPermission(param)) result = true;
                    });

                    return result;
                }, 
                hasAllPermission(...params) {
                    if(this.isSuperAdmin()) return true;
                    let result = true;
                    params.forEach(param=>{
                        if(!this.hasPermission(param)) result = false;
                    });

                    return result;
                },
                isSuperAdmin() {
                    return !!window.__roles['ALL']; 
                }
            }
        });
    }
}