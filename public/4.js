webpackJsonp([4],{BZTz:function(t,e,s){"use strict";Object.defineProperty(e,"__esModule",{value:!0}),e.default={data:function(){return{ifReady:!1,user:""}},mounted:function(){var t=this;new Promise(function(e,s){axios.get("/api/users/"+t.$route.params.id).then(function(s){t.user=s.data.user,e()})}).then(function(){t.ifReady=!0})},methods:{openDeleteUserModal:function(){$("#delete-modal").modal("show")},deleteUser:function(){var t=this;$("#delete-modal").modal("hide"),axios.delete("/api/users/"+this.$route.params.id).then(function(e){Broadcast.$emit("ToastMessage",{message:"User Deleted Successfully"}),t.$router.push({name:"users.index"})}).catch(function(t){console.log(t)})}}}},ZuW4:function(t,e,s){var a=s("VU/8")(s("BZTz"),s("onMs"),!1,null,null,null);t.exports=a.exports},onMs:function(t,e){t.exports={render:function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",[s("div",{staticClass:"card"},[s("div",{staticClass:"card-header"},[s("router-link",{staticClass:"text-primary",attrs:{to:{name:"users.index"}}},[t._v("Users")]),t._v("\n            /\n            "),s("span",{staticClass:"text-secondary"},[t._v("View User")])],1),t._v(" "),s("div",{staticClass:"card-body"},[t.ifReady?s("div",[s("fieldset",{attrs:{disabled:""}},[s("div",{staticClass:"row"},[s("div",{staticClass:"col-lg-6"},[s("div",{staticClass:"form-group"},[s("label",[t._v("Name")]),t._v(" "),s("input",{directives:[{name:"model",rawName:"v-model",value:t.user.name,expression:"user.name"}],staticClass:"form-control",attrs:{type:"text"},domProps:{value:t.user.name},on:{input:function(e){e.target.composing||t.$set(t.user,"name",e.target.value)}}})])]),t._v(" "),s("div",{staticClass:"col-lg-6"},[s("div",{staticClass:"form-group"},[s("label",[t._v("Email Address")]),t._v(" "),s("input",{directives:[{name:"model",rawName:"v-model",value:t.user.email,expression:"user.email"}],staticClass:"form-control",attrs:{type:"email"},domProps:{value:t.user.email},on:{input:function(e){e.target.composing||t.$set(t.user,"email",e.target.value)}}})])])])]),t._v(" "),s("br"),t._v(" "),s("router-link",{staticClass:"btn btn-outline-secondary btn-sm",attrs:{to:{name:"users.index"}}},[s("i",{staticClass:"fas fa-chevron-left"}),t._v("  Back")]),t._v(" "),s("router-link",{staticClass:"btn btn-primary btn-sm",attrs:{to:{name:"users.edit",params:{id:t.user.id}}}},[s("i",{staticClass:"fas fa-edit"}),t._v("  Edit User")]),t._v(" "),s("button",{staticClass:"btn btn-danger btn-sm",attrs:{type:"button"},on:{click:function(e){return!e.type.indexOf("key")&&t._k(e.keyCode,"default",void 0,e.key,void 0)?null:(e.preventDefault(),t.openDeleteUserModal())}}},[s("i",{staticClass:"fas fa-trash-alt"}),t._v("  Delete User")])],1):s("div",[t._m(0)])])]),t._v(" "),s("div",{staticClass:"modal fade",attrs:{id:"delete-modal",tabindex:"-1",role:"dialog","aria-labelledby":"deleteUserTitle","aria-hidden":"true"}},[s("div",{staticClass:"modal-dialog modal-dialog-centered",attrs:{role:"document"}},[s("div",{staticClass:"modal-content"},[t._m(1),t._v(" "),s("div",{staticClass:"modal-body"},[t._v("\n                    Are you sure you want to delete this User?\n                ")]),t._v(" "),s("div",{staticClass:"modal-footer"},[s("button",{staticClass:"btn btn-danger btn-sm",attrs:{type:"button"},on:{click:function(e){return!e.type.indexOf("key")&&t._k(e.keyCode,"default",void 0,e.key,void 0)?null:(e.preventDefault(),t.deleteUser())}}},[t._v("Confirm Delete")]),t._v(" "),s("button",{staticClass:"btn btn-secondary btn-sm",attrs:{type:"button","data-dismiss":"modal"}},[t._v("Close")])])])])])])},staticRenderFns:[function(){var t=this.$createElement,e=this._self._c||t;return e("div",{staticClass:"progress"},[e("div",{staticClass:"progress-bar progress-bar-striped progress-bar-animated",staticStyle:{width:"100%"},attrs:{role:"progressbar","aria-valuenow":"100","aria-valuemin":"0","aria-valuemax":"100"}})])},function(){var t=this.$createElement,e=this._self._c||t;return e("div",{staticClass:"modal-header"},[e("h5",{staticClass:"modal-title",attrs:{id:"exampleModalLongTitle"}},[this._v("You're about to delete this User?")]),this._v(" "),e("button",{staticClass:"close",attrs:{type:"button","data-dismiss":"modal","aria-label":"Close"}},[e("span",{attrs:{"aria-hidden":"true"}},[this._v("×")])])])}]}}});