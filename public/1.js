webpackJsonp([1],{"4/N9":function(t,e,a){(t.exports=a("FZ+f")(!1)).push([t.i,".clickableText[data-v-1949c4d6]:hover{text-decoration:underline;cursor:pointer}.table>tbody>tr.no-border>td[data-v-1949c4d6],.table>tbody>tr.no-border>th[data-v-1949c4d6]{border-top:none}",""])},"5kXo":function(t,e){t.exports={render:function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"row"},[a("div",{staticClass:"col-md-6"},[a("div",{staticClass:"card"},[a("div",{staticClass:"card-header clearfix"},[a("div",{staticClass:"row"},[a("div",{staticClass:"col-md-6"},[a("router-link",{staticClass:"text-primary",attrs:{to:{name:"transactions.index"}}},[t._v("Transactions")]),t._v("\n                        /\n                        "),a("span",{staticClass:"text-secondary"},[t._v("Item List")])],1),t._v(" "),a("div",{staticClass:"float-right col-md-6"},[a("input",{directives:[{name:"model",rawName:"v-model",value:t.itemName,expression:"itemName"}],staticClass:"form-control form-control-sm",attrs:{type:"text",placeholder:"Search"},domProps:{value:t.itemName},on:{input:[function(e){e.target.composing||(t.itemName=e.target.value)},t.onSearch]}})])])]),t._v(" "),a("div",{staticClass:"card-body"},[a("table",{staticClass:"table table-hover table-sm"},[a("caption",[a("div",{staticClass:"row"},[a("div",{staticClass:"col-md-9"},[t._v("\n                                List of Items\n                                ")]),t._v(" "),a("div",{staticClass:"col-md-3"},[t.showProgress?a("div",{staticClass:"progress",attrs:{height:"30px;"}},[a("div",{staticClass:"progress-bar progress-bar-striped progress-bar-animated",staticStyle:{width:"100%"},attrs:{role:"progressbar","aria-valuenow":"100","aria-valuemin":"0","aria-valuemax":"100"}})]):t._e()])])]),t._v(" "),t._m(0),t._v(" "),t.items?a("tbody",t._l(t.items,function(e){return a("tr",[a("td",[t._v(t._s(e.name))]),t._v(" "),a("td",[t._v(t._s(e.amount))]),t._v(" "),a("td",[t._v(t._s(e.stocks_available))]),t._v(" "),a("td",[0!=e.stocks_available?a("div",[a("label",{staticClass:"text-secondary clickableText",on:{click:function(a){return!a.type.indexOf("key")&&t._k(a.keyCode,"default",void 0,a.key,void 0)?null:(a.preventDefault(),t.addToCart(e))}}},[a("i",{staticClass:"fas fa-cart-arrow-down"}),t._v(" \n                                        "),a("strong",[t._v("Add to cart")])])]):a("div",[t._m(1,!0)])])])}),0):t._e()])])]),t._v(" "),a("br"),t._v(" "),a("div",{staticClass:"clearfix"},[(t.pageCount,a("div",[a("nav",{staticClass:"float-left"},[a("ul",{staticClass:"pagination"},[a("li",{staticClass:"page-item",class:t.isPrevDisabled},[a("a",{staticClass:"page-link",attrs:{href:"#",disabled:""},on:{click:function(e){return e.preventDefault(),t.goToPreviousPage(e)}}},[a("strong",[t._v("Previous")])])]),t._v(" "),a("li",{staticClass:"page-item"},[a("a",{staticClass:"page-link",attrs:{href:"#"},on:{click:function(e){return e.preventDefault(),t.goToFirstPage(e)}}},[a("strong",[t._v("First")])])]),t._v(" "),t._l(t.pageNumbers,function(e){return a("li",{staticClass:"page-item",class:t.isPageActive(e)},[a("a",{staticClass:"page-link",attrs:{href:"#"},on:{click:function(a){return a.preventDefault(),t.goToPage(e)}}},[a("strong",[t._v(t._s(e))])])])}),t._v(" "),a("li",{staticClass:"page-item",class:t.isNextDisabled},[a("a",{staticClass:"page-link",attrs:{href:"#"},on:{click:function(e){return e.preventDefault(),t.goToLastPage(e)}}},[a("strong",[t._v("Last")])])]),t._v(" "),a("li",{staticClass:"page-item",class:t.isNextDisabled},[a("a",{staticClass:"page-link",attrs:{href:"#"},on:{click:function(e){return e.preventDefault(),t.goToNextPage(e)}}},[a("strong",[t._v("Next")])])])],2)])])),t._v(" "),a("div",{staticClass:"float-right"},[a("form",{staticClass:"form-inline"},[a("label",{staticClass:"sr-only",attrs:{for:"number_of_items"}},[t._v("Number of Item")]),t._v(" "),a("div",{staticClass:"input-group"},[t._m(2),t._v(" "),a("select",{directives:[{name:"model",rawName:"v-model",value:t.meta.per_page,expression:"meta.per_page"}],staticClass:"custom-select",attrs:{id:"number_of_items"},on:{change:[function(e){var a=Array.prototype.filter.call(e.target.options,function(t){return t.selected}).map(function(t){return"_value"in t?t._value:t.value});t.$set(t.meta,"per_page",e.target.multiple?a:a[0])},t.changePerPage]}},[a("option",{attrs:{value:"10"}},[t._v("10")]),t._v(" "),a("option",{attrs:{value:"15"}},[t._v("15")]),t._v(" "),a("option",{attrs:{value:"20"}},[t._v("20")]),t._v(" "),a("option",{attrs:{value:"25"}},[t._v("25")])])])])])]),t._v(" "),a("div",{staticClass:"modal fade",attrs:{id:"search-modal",tabindex:"-1",role:"dialog","aria-labelledby":"search","aria-hidden":"true"}},[a("div",{staticClass:"modal-dialog modal-dialog-centered modal-lg",attrs:{role:"document"}},[a("div",{staticClass:"modal-content"},[t._m(3),t._v(" "),a("div",{staticClass:"modal-body"},[a("div",{staticClass:"form-group"},[a("label",[t._v("Name")]),t._v(" "),a("input",{directives:[{name:"model",rawName:"v-model",value:t.name,expression:"name"}],staticClass:"form-control",attrs:{type:"text",autocomplete:"off",maxlength:"255"},domProps:{value:t.name},on:{input:function(e){e.target.composing||(t.name=e.target.value)}}})]),t._v(" "),a("div",{staticClass:"form-group"},[a("label",[t._v("Amount")]),t._v(" "),a("input",{directives:[{name:"model",rawName:"v-model",value:t.amount,expression:"amount"}],staticClass:"form-control",attrs:{type:"text",autocomplete:"off",maxlength:"255"},domProps:{value:t.amount},on:{input:function(e){e.target.composing||(t.amount=e.target.value)}}})]),t._v(" "),a("div",{staticClass:"form-group"},[a("label",[t._v("Order By")]),t._v(" "),a("select",{directives:[{name:"model",rawName:"v-model",value:t.order_by,expression:"order_by"}],staticClass:"form-control",on:{change:function(e){var a=Array.prototype.filter.call(e.target.options,function(t){return t.selected}).map(function(t){return"_value"in t?t._value:t.value});t.order_by=e.target.multiple?a:a[0]}}},[a("option",{attrs:{value:"desc"}},[t._v("Newest")]),t._v(" "),a("option",{attrs:{value:"asc"}},[t._v("Oldest")])])])]),t._v(" "),a("div",{staticClass:"modal-footer"},[a("button",{staticClass:"btn btn-danger btn-sm",attrs:{type:"button"},on:{click:function(e){return!e.type.indexOf("key")&&t._k(e.keyCode,"default",void 0,e.key,void 0)?null:(e.preventDefault(),t.clear(e))}}},[t._v("Clear")]),t._v(" "),a("button",{staticClass:"btn btn-success btn-sm",attrs:{type:"button"},on:{click:function(e){return!e.type.indexOf("key")&&t._k(e.keyCode,"default",void 0,e.key,void 0)?null:(e.preventDefault(),t.search(e))}}},[t._v("Search")]),t._v(" "),a("button",{staticClass:"btn btn-secondary btn-sm",attrs:{type:"button","data-dismiss":"modal"}},[t._v("Close")])])])])]),t._v(" "),a("div",{staticClass:"modal fade",attrs:{id:"checkout-modal",tabindex:"-1",role:"dialog","aria-labelledby":"checkout","aria-hidden":"true"}},[a("div",{staticClass:"modal-dialog modal-dialog-centered modal-lg",attrs:{role:"document"}},[a("div",{staticClass:"modal-content"},[t._m(4),t._v(" "),a("div",{staticClass:"modal-body"},[a("table",{staticClass:"table table-hover table-sm card-title"},[t._m(5),t._v(" "),t.cart?a("tbody",t._l(t.cart,function(e){return a("tr",[a("td",[t._v(t._s(e.name))]),t._v(" "),a("td",[t._v(t._s(e.amount))]),t._v(" "),a("td",[t._v(t._s(e.qty))]),t._v(" "),a("td",[t._v("\n                                        "+t._s((e.qty*e.amount).toFixed(2))+"\n                                    ")])])}),0):t._e()]),t._v(" "),a("div",{staticClass:"card-text"},[a("br"),a("br"),t._v(" "),a("div",{staticClass:"float-right"},[a("div",[a("strong",[t._v("Total Bill:")]),t._v("\n                                    "+t._s(t.priceSummation())+"\n                                ")]),t._v(" "),a("div",[a("strong",[t._v("Cash:")]),t._v(" "),a("input",{directives:[{name:"model",rawName:"v-model",value:t.cash,expression:"cash"}],attrs:{type:"number",id:"cash",name:"cash",disabled:""},domProps:{value:t.cash},on:{input:function(e){e.target.composing||(t.cash=e.target.value)}}})]),t._v(" "),a("div",[a("strong",[t._v("Change:")]),t._v("\n                                    "+t._s((this.cash-t.priceSummation()).toFixed(2))+"\n                                ")])])])]),t._v(" "),this.ifReady?a("div",{staticClass:"container mb-4"},[t._m(6)]):a("div",{staticClass:"modal-footer"},[a("button",{staticClass:"btn btn-success btn-sm",attrs:{type:"button"},on:{click:function(e){return!e.type.indexOf("key")&&t._k(e.keyCode,"default",void 0,e.key,void 0)?null:(e.preventDefault(),t.createTransaction())}}},[t._v("Proceed")])])])])]),t._v(" "),a("div",{staticClass:"modal fade",attrs:{id:"delete-modal",tabindex:"-1",role:"dialog","aria-labelledby":"deleteItemTitle","aria-hidden":"true"}},[a("div",{staticClass:"modal-dialog modal-dialog-centered",attrs:{role:"document"}},[a("div",{staticClass:"modal-content"},[t._m(7),t._v(" "),a("div",{staticClass:"modal-body"},[t._v("\n                        Are you sure you want to delete this Item?\n                    ")]),t._v(" "),a("div",{staticClass:"modal-footer"},[a("button",{staticClass:"btn btn-danger btn-sm",attrs:{type:"button"},on:{click:function(e){return!e.type.indexOf("key")&&t._k(e.keyCode,"default",void 0,e.key,void 0)?null:(e.preventDefault(),t.deleteItem())}}},[t._v("Confirm Delete")]),t._v(" "),a("button",{staticClass:"btn btn-secondary btn-sm",attrs:{type:"button","data-dismiss":"modal"}},[t._v("Close")])])])])])]),t._v(" "),a("div",{staticClass:"col-md-6"},[a("div",{staticClass:"card"},[t._m(8),t._v(" "),a("div",{staticClass:"card-body"},[a("table",{staticClass:"table table-hover table-sm card-title"},[t._m(9),t._v(" "),t.cart?a("tbody",[t._l(t.cart,function(e){return a("tr",[a("td",[t._v(t._s(e.name))]),t._v(" "),a("td",[t._v(t._s(e.amount))]),t._v(" "),a("td",[a("input",{directives:[{name:"model",rawName:"v-model",value:e.qty,expression:"item.qty"}],attrs:{type:"number",id:"qty",name:"quantity",max:e.stocks_available},domProps:{value:e.qty},on:{input:function(a){a.target.composing||t.$set(e,"qty",a.target.value)}}})]),t._v(" "),a("td",[t._v("\n                                "+t._s((e.qty*e.amount).toFixed(2))+"\n                            ")]),t._v(" "),a("td",[a("label",{staticClass:"text-danger clickableText",on:{click:function(a){return!a.type.indexOf("key")&&t._k(a.keyCode,"default",void 0,a.key,void 0)?null:(a.preventDefault(),t.removeFromCart(e))}}},[a("i",{staticClass:"fas fa-trash-alt"}),t._v(" \n                                    "),a("strong",[t._v("Remove")])])])])}),t._v(" "),0!=t.priceSummation()?a("tr",[t._m(10)]):t._e(),t._v(" "),0!=t.priceSummation()?a("tr",[a("td",{attrs:{scope:"row",colspan:"5"}})]):t._e(),t._v(" "),0!=t.priceSummation()?a("tr",{staticClass:"no-border"},[a("td",{attrs:{scope:"row",colspan:"4"}}),t._v(" "),a("td",{attrs:{scope:"row"}},[a("strong",[t._v("Total Bill:")]),t._v("\n                                    "+t._s(t.priceSummation())+"\n                            ")])]):t._e(),t._v(" "),0!=t.priceSummation()?a("tr",{staticClass:"no-border"},[a("td",{attrs:{scope:"row",colspan:"4"}}),t._v(" "),a("td",{attrs:{scope:"row"}},[a("strong",[t._v("Cash:")]),t._v(" "),a("input",{directives:[{name:"model",rawName:"v-model",value:t.cash,expression:"cash"}],attrs:{type:"number",id:"cash",name:"cash"},domProps:{value:t.cash},on:{input:function(e){e.target.composing||(t.cash=e.target.value)}}})])]):t._e(),t._v(" "),0!=t.priceSummation()?a("tr",{staticClass:"no-border"},[a("td",{attrs:{scope:"row",colspan:"4"}}),t._v(" "),a("td",{attrs:{scope:"row"}},[a("strong",[t._v("Change:")]),t._v("\n                                "+t._s((this.cash-t.priceSummation()).toFixed(2))+"\n                            ")])]):t._e(),t._v(" "),0!=t.priceSummation()?a("tr",{staticClass:"no-border"},[a("td",{attrs:{scope:"row",colspan:"4"}}),t._v(" "),a("td",{attrs:{scope:"row"}},[a("button",{staticClass:"btn btn-success btn-sm",attrs:{type:"button"},on:{click:function(e){return!e.type.indexOf("key")&&t._k(e.keyCode,"default",void 0,e.key,void 0)?null:(e.preventDefault(),t.openCheckoutModal())}}},[a("i",{staticClass:"fas fa-cash-register"}),t._v(" \n                                    Checkout\n                                ")])])]):t._e()],2):t._e()])])])])])},staticRenderFns:[function(){var t=this.$createElement,e=this._self._c||t;return e("thead",[e("tr",[e("th",{attrs:{scope:"col"}},[this._v("Name")]),this._v(" "),e("th",{attrs:{scope:"col"}},[this._v("Price")]),this._v(" "),e("th",{attrs:{scope:"col"}},[this._v("Stocks Available")]),this._v(" "),e("th",{attrs:{scope:"col"}},[this._v("Options")])])])},function(){var t=this.$createElement,e=this._self._c||t;return e("label",{staticClass:"text-danger"},[e("i",{staticClass:"fas fa-exclamation-circle"}),this._v(" \n                                        "),e("strong",[this._v("Not Available")])])},function(){var t=this.$createElement,e=this._self._c||t;return e("div",{staticClass:"input-group-prepend"},[e("div",{staticClass:"input-group-text"},[this._v("Items per page")])])},function(){var t=this.$createElement,e=this._self._c||t;return e("div",{staticClass:"modal-header"},[e("h5",{staticClass:"modal-title",attrs:{id:"search"}},[this._v("Search Item")]),this._v(" "),e("button",{staticClass:"close",attrs:{type:"button","data-dismiss":"modal","aria-label":"Close"}},[e("span",{attrs:{"aria-hidden":"true"}},[this._v("×")])])])},function(){var t=this.$createElement,e=this._self._c||t;return e("div",{staticClass:"modal-header"},[e("h5",{staticClass:"modal-title",attrs:{id:"search"}},[this._v("Confirm Payment")]),this._v(" "),e("button",{staticClass:"close",attrs:{type:"button","data-dismiss":"modal","aria-label":"Close"}},[e("span",{attrs:{"aria-hidden":"true"}},[this._v("×")])])])},function(){var t=this.$createElement,e=this._self._c||t;return e("thead",[e("tr",[e("th",{attrs:{scope:"col"}},[this._v("Name")]),this._v(" "),e("th",{attrs:{scope:"col"}},[this._v("Price")]),this._v(" "),e("th",{attrs:{scope:"col"}},[this._v("qty")]),this._v(" "),e("th",{attrs:{scope:"col"}},[this._v("Total Price")])])])},function(){var t=this.$createElement,e=this._self._c||t;return e("div",{staticClass:"progress",attrs:{height:"30px;"}},[e("div",{staticClass:"progress-bar progress-bar-striped progress-bar-animated",staticStyle:{width:"100%"},attrs:{role:"progressbar","aria-valuenow":"100","aria-valuemin":"0","aria-valuemax":"100"}})])},function(){var t=this.$createElement,e=this._self._c||t;return e("div",{staticClass:"modal-header"},[e("h5",{staticClass:"modal-title",attrs:{id:"exampleModalLongTitle"}},[this._v("You're about to delete this Item")]),this._v(" "),e("button",{staticClass:"close",attrs:{type:"button","data-dismiss":"modal","aria-label":"Close"}},[e("span",{attrs:{"aria-hidden":"true"}},[this._v("×")])])])},function(){var t=this.$createElement,e=this._self._c||t;return e("div",{staticClass:"card-header"},[e("i",{staticClass:"fas fa-shopping-cart"}),this._v("  Cart")])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("thead",[a("tr",[a("th",{attrs:{scope:"col"}},[t._v("Name")]),t._v(" "),a("th",{attrs:{scope:"col"}},[t._v("Price")]),t._v(" "),a("th",{attrs:{scope:"col"}},[t._v("qty")]),t._v(" "),a("th",{attrs:{scope:"col"}},[t._v("Total Price")]),t._v(" "),a("th",{attrs:{scope:"col"}},[t._v("Options")])])])},function(){var t=this.$createElement,e=this._self._c||t;return e("td",{attrs:{scope:"row",colspan:"5"}},[e("br")])}]}},rjj0:function(t,e,a){var s="undefined"!=typeof document;if("undefined"!=typeof DEBUG&&DEBUG&&!s)throw new Error("vue-style-loader cannot be used in a non-browser environment. Use { target: 'node' } in your Webpack config to indicate a server-rendering environment.");var r=a("tTVk"),i={},n=s&&(document.head||document.getElementsByTagName("head")[0]),o=null,l=0,c=!1,u=function(){},d=null,m="data-vue-ssr-id",p="undefined"!=typeof navigator&&/msie [6-9]\b/.test(navigator.userAgent.toLowerCase());function h(t){for(var e=0;e<t.length;e++){var a=t[e],s=i[a.id];if(s){s.refs++;for(var r=0;r<s.parts.length;r++)s.parts[r](a.parts[r]);for(;r<a.parts.length;r++)s.parts.push(_(a.parts[r]));s.parts.length>a.parts.length&&(s.parts.length=a.parts.length)}else{var n=[];for(r=0;r<a.parts.length;r++)n.push(_(a.parts[r]));i[a.id]={id:a.id,refs:1,parts:n}}}}function v(){var t=document.createElement("style");return t.type="text/css",n.appendChild(t),t}function _(t){var e,a,s=document.querySelector("style["+m+'~="'+t.id+'"]');if(s){if(c)return u;s.parentNode.removeChild(s)}if(p){var r=l++;s=o||(o=v()),e=b.bind(null,s,r,!1),a=b.bind(null,s,r,!0)}else s=v(),e=function(t,e){var a=e.css,s=e.media,r=e.sourceMap;s&&t.setAttribute("media",s);d.ssrId&&t.setAttribute(m,e.id);r&&(a+="\n/*# sourceURL="+r.sources[0]+" */",a+="\n/*# sourceMappingURL=data:application/json;base64,"+btoa(unescape(encodeURIComponent(JSON.stringify(r))))+" */");if(t.styleSheet)t.styleSheet.cssText=a;else{for(;t.firstChild;)t.removeChild(t.firstChild);t.appendChild(document.createTextNode(a))}}.bind(null,s),a=function(){s.parentNode.removeChild(s)};return e(t),function(s){if(s){if(s.css===t.css&&s.media===t.media&&s.sourceMap===t.sourceMap)return;e(t=s)}else a()}}t.exports=function(t,e,a,s){c=a,d=s||{};var n=r(t,e);return h(n),function(e){for(var a=[],s=0;s<n.length;s++){var o=n[s];(l=i[o.id]).refs--,a.push(l)}e?h(n=r(t,e)):n=[];for(s=0;s<a.length;s++){var l;if(0===(l=a[s]).refs){for(var c=0;c<l.parts.length;c++)l.parts[c]();delete i[l.id]}}}};var g,f=(g=[],function(t,e){return g[t]=e,g.filter(Boolean).join("\n")});function b(t,e,a,s){var r=a?"":s.css;if(t.styleSheet)t.styleSheet.cssText=f(e,r);else{var i=document.createTextNode(r),n=t.childNodes;n[e]&&t.removeChild(n[e]),n.length?t.insertBefore(i,n[e]):t.appendChild(i)}}},"s7+s":function(t,e,a){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var s=function(t,e,a,s,r,i){var n={page:t,per_page:e,name:a,amount:s,order_by:r};axios.get("/api/items",{params:n}).then(function(t){i(null,t.data)}).catch(function(t){401==t.response.status&&location.reload(),500==t.response.status&&alert("Kindly report this issue to the devs.")})};e.default={data:function(){return{items:null,name:"",amount:"",itemName:"",itemID:"",totalBill:"",cart:[],cash:0,order_by:"desc",meta:{current_page:null,from:null,last_page:null,path:null,per_page:10,to:null,total:null},links:{first:null,last:null,next:null,prev:null},error:null,showProgress:!1,pageNumbers:[],ifReady:!1}},beforeRouteEnter:function(t,e,a){null==t.query.per_page?s(t.query.page,10,t.query.name,t.query.amount,t.query.order_by,function(t,e){a(function(a){return a.setData(t,e)})}):s(t.query.page,t.query.per_page,t.query.name,t.query.amount,t.query.order_by,function(t,e){a(function(a){return a.setData(t,e)})})},beforeRouteUpdate:function(t,e,a){var r=this;s(t.query.page,this.meta.per_page,this.name,this.amount,this.order_by,function(t,e){r.setData(t,e),a()})},computed:{nextPage:function(){return this.meta.current_page+1},prevPage:function(){return this.meta.current_page-1},paginatonCount:function(){if(this.meta){var t=this.meta;return t.current_page+" of "+t.last_page}},pageCount:function(){return!(this.meta.last_page>10)},isPrevDisabled:function(){if(null==this.links.prev)return"disabled"},isNextDisabled:function(){if(null==this.links.next)return"disabled"}},methods:{goToFirstPage:function(){this.showProgress=!0,this.$router.push({name:"transactions.index",query:{page:1,per_page:this.meta.per_page,name:this.name,amount:this.amount,order_by:this.order_by}})},goToPage:function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:null;this.showProgress=!0,this.$router.push({name:"transactions.index",query:{page:t,per_page:this.meta.per_page,name:this.name,amount:this.amount,order_by:this.order_by}})},goToLastPage:function(){this.showProgress=!0,this.$router.push({name:"transactions.index",query:{page:this.meta.last_page,per_page:this.meta.per_page,name:this.name,amount:this.amount,order_by:this.order_by}})},goToNextPage:function(){this.showProgress=!0,this.$router.push({name:"transactions.index",query:{page:this.nextPage,per_page:this.meta.per_page,name:this.name,amount:this.amount,order_by:this.order_by}})},goToPreviousPage:function(){this.showProgress=!0,this.$router.push({name:"transactions.index",query:{page:this.prevPage,per_page:this.meta.per_page,name:this.name,amount:this.amount,order_by:this.order_by}})},setData:function(t,e){var a=e.data,s=e.links,r=e.meta;this.pageNumbers=[],t?this.error=t.toString():(this.items=a,this.links=s,this.meta=r),this.showProgress=!1,this.populatePages()},populatePages:function(){if(this.pageCount)for(var t=1;t<=this.meta.last_page;t++)this.pageNumbers.push(t);else if(this.meta.current_page<=6){this.pageNumbers.push(1),this.pageNumbers.push(2),this.pageNumbers.push(3),this.pageNumbers.push(4),this.pageNumbers.push(5),this.pageNumbers.push(6),this.pageNumbers.push(7),this.pageNumbers.push("..."),this.pageNumbers.push(this.meta.last_page-1),this.pageNumbers.push(this.meta.last_page)}else this.meta.current_page+6>=this.meta.last_page?(this.pageNumbers.push(1),this.pageNumbers.push(2),this.pageNumbers.push("..."),this.pageNumbers.push(this.meta.last_page-7),this.pageNumbers.push(this.meta.last_page-6),this.pageNumbers.push(this.meta.last_page-5),this.pageNumbers.push(this.meta.last_page-4),this.pageNumbers.push(this.meta.last_page-3),this.pageNumbers.push(this.meta.last_page-2),this.pageNumbers.push(this.meta.last_page-1),this.pageNumbers.push(this.meta.last_page)):(this.pageNumbers.push(1),this.pageNumbers.push(2),this.pageNumbers.push("..."),this.pageNumbers.push(this.meta.current_page-2),this.pageNumbers.push(this.meta.current_page-1),this.pageNumbers.push(this.meta.current_page),this.pageNumbers.push(this.meta.current_page+1),this.pageNumbers.push(this.meta.current_page+2),this.pageNumbers.push("..."),this.pageNumbers.push(this.meta.last_page-1),this.pageNumbers.push(this.meta.last_page))},isPageActive:function(t){if(t==this.$route.query.page||1==t&&null==this.$route.query.page)return"active"},changePerPage:function(){this.showProgress=!0,this.$router.push({name:"transactions.index",query:{page:1,per_page:this.meta.per_page,name:this.name,amount:this.amount,order_by:this.order_by}})},onSearch:function(){this.search(this.itemName,this)},search:_.debounce(function(t,e){axios.get("/api/items/search?value="+escape(t)).then(function(t){e.items=t.data})},250),clear:function(){this.name="",this.amount="",this.order_by="desc"},openSearchModal:function(){$("#search-modal").modal("show")},openCheckoutModal:function(){parseInt(this.cash).toFixed(2)-this.priceSummation()<0?alert("Insufficient Funds"):$("#checkout-modal").modal("show")},addToCart:function(t){if(this.cart.some(function(e){return e.id===t.id}))alert("Item already exists in cart");else{var e={id:t.id,name:t.name,amount:t.amount,stocks_available:t.stocks_available,qty:1};this.cart.push(e),console.log(this.cart)}},deleteItem:function(){var t=this;$("#delete-modal").modal("hide"),axios.delete("/api/items/"+this.itemID).then(function(e){Broadcast.$emit("ToastMessage",{message:"Item Deleted Successfully"}),t.$router.go()}).catch(function(t){console.log(t)})},priceSummation:function(){var t=0;return this.cart.forEach(function(e){t+=e.amount*e.qty}),t.toFixed(2)},removeFromCart:function(t){this.cart.splice(this.cart.findIndex(function(e){return e.id=t.id}),1)},createTransaction:function(){var t=this;if(parseInt(this.cash).toFixed(2)-this.priceSummation()<0)alert("Insufficient Funds");else{this.ifReady=!0;var e={total_amount:this.priceSummation(),cart:this.cart};axios.post("/api/transactions",e).then(function(e){for(var a=0;a<t.cart.length;a++){var s={name:t.cart[a].name,amount:t.cart[a].amount,stocks_available:t.cart[a].stocks_available-t.cart[a].qty};axios.patch("/api/items/"+t.cart[a].id,s).then(function(t){console.log("Item Update Successful")}).catch(function(t){console.log(t)})}$("#checkout-modal").modal("hide"),Broadcast.$emit("ToastMessage",{message:"Transaction Created Successfully"}),t.cart=[],t.cash="",t.$router.go()}).catch(function(e){t.ifReady=!0,console.log(e)})}}}}},tTVk:function(t,e){t.exports=function(t,e){for(var a=[],s={},r=0;r<e.length;r++){var i=e[r],n=i[0],o={id:t+":"+r,css:i[1],media:i[2],sourceMap:i[3]};s[n]?s[n].parts.push(o):a.push(s[n]={id:n,parts:[o]})}return a}},wU08:function(t,e,a){var s=a("4/N9");"string"==typeof s&&(s=[[t.i,s,""]]),s.locals&&(t.exports=s.locals);a("rjj0")("782c43c5",s,!0,{})},z67m:function(t,e,a){var s=a("VU/8")(a("s7+s"),a("5kXo"),!1,function(t){a("wU08")},"data-v-1949c4d6",null);t.exports=s.exports}});