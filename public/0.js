webpackJsonp([0],{"DsX+":function(t,e){t.exports={render:function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",[a("div",{staticClass:"card"},[a("div",{staticClass:"card-header clearfix"},[a("div",{staticClass:"float-left"},[a("router-link",{staticClass:"text-primary",attrs:{to:{number:"transaction_history.index"}}},[t._v("Transaction History")]),t._v("\n                /\n                "),a("span",{staticClass:"text-secondary"},[t._v("View Transaction History")])],1),t._v(" "),a("div",{staticClass:"float-right"},[a("button",{staticClass:"btn btn-primary btn-sm",attrs:{type:"button"},on:{click:function(e){return!e.type.indexOf("key")&&t._k(e.keyCode,"default",void 0,e.key,void 0)?null:(e.preventDefault(),t.openSearchModal())}}},[a("i",{staticClass:"fas fa-search"}),t._v(" \n                    Search Transaction History\n                ")])])]),t._v(" "),a("div",{staticClass:"card-body"},[a("table",{staticClass:"table table-hover table-sm"},[a("caption",[a("div",{staticClass:"row"},[a("div",{staticClass:"col-md-9"},[t._v("\n                            List of Transactions - Total Items "+t._s(this.meta.total)+"\n                        ")]),t._v(" "),a("div",{staticClass:"col-md-3"},[t.showProgress?a("div",{staticClass:"progress",attrs:{height:"30px;"}},[a("div",{staticClass:"progress-bar progress-bar-striped progress-bar-animated",staticStyle:{width:"100%"},attrs:{role:"progressbar","aria-valuenow":"100","aria-valuemin":"0","aria-valuemax":"100"}})]):t._e()])])]),t._v(" "),t._m(0),t._v(" "),t.transaction_history?a("tbody",t._l(t.transaction_history,function(e){return a("tr",[a("td",[t._v(t._s(e.number))]),t._v(" "),a("td",[t._v(t._s(e.total_amount))]),t._v(" "),a("td",[t._v(t._s(t.formatDate(e.created_at)))]),t._v(" "),a("td",[a("label",{staticClass:"text-secondary clickableText",on:{click:function(a){return!a.type.indexOf("key")&&t._k(a.keyCode,"default",void 0,a.key,void 0)?null:(a.preventDefault(),t.openTransactionItemModal(e.id))}}},[a("i",{staticClass:"fas fa-eye"}),t._v(" \n                                "),a("strong",[t._v("View")])])])])}),0):t._e()])])]),t._v(" "),a("br"),t._v(" "),a("div",{staticClass:"clearfix"},[(t.pageCount,a("div",[a("nav",{staticClass:"float-left"},[a("ul",{staticClass:"pagination"},[a("li",{staticClass:"page-item",class:t.isPrevDisabled},[a("a",{staticClass:"page-link",attrs:{href:"#",disabled:""},on:{click:function(e){return e.preventDefault(),t.goToPreviousPage(e)}}},[a("strong",[t._v("Previous")])])]),t._v(" "),a("li",{staticClass:"page-item"},[a("a",{staticClass:"page-link",attrs:{href:"#"},on:{click:function(e){return e.preventDefault(),t.goToFirstPage(e)}}},[a("strong",[t._v("First")])])]),t._v(" "),t._l(t.pageNumbers,function(e){return a("li",{staticClass:"page-item",class:t.isPageActive(e)},[a("a",{staticClass:"page-link",attrs:{href:"#"},on:{click:function(a){return a.preventDefault(),t.goToPage(e)}}},[a("strong",[t._v(t._s(e))])])])}),t._v(" "),a("li",{staticClass:"page-item",class:t.isNextDisabled},[a("a",{staticClass:"page-link",attrs:{href:"#"},on:{click:function(e){return e.preventDefault(),t.goToLastPage(e)}}},[a("strong",[t._v("Last")])])]),t._v(" "),a("li",{staticClass:"page-item",class:t.isNextDisabled},[a("a",{staticClass:"page-link",attrs:{href:"#"},on:{click:function(e){return e.preventDefault(),t.goToNextPage(e)}}},[a("strong",[t._v("Next")])])])],2)])])),t._v(" "),a("div",{staticClass:"float-right"},[a("form",{staticClass:"form-inline"},[a("label",{staticClass:"sr-only",attrs:{for:"number_of_items"}},[t._v("Number of Item")]),t._v(" "),a("div",{staticClass:"input-group"},[t._m(1),t._v(" "),a("select",{directives:[{name:"model",rawName:"v-model",value:t.meta.per_page,expression:"meta.per_page"}],staticClass:"custom-select",attrs:{id:"number_of_items"},on:{change:[function(e){var a=Array.prototype.filter.call(e.target.options,function(t){return t.selected}).map(function(t){return"_value"in t?t._value:t.value});t.$set(t.meta,"per_page",e.target.multiple?a:a[0])},t.changePerPage]}},[a("option",{attrs:{value:"10"}},[t._v("10")]),t._v(" "),a("option",{attrs:{value:"15"}},[t._v("15")]),t._v(" "),a("option",{attrs:{value:"20"}},[t._v("20")]),t._v(" "),a("option",{attrs:{value:"25"}},[t._v("25")])])])])])]),t._v(" "),a("div",{staticClass:"modal fade",attrs:{id:"transaction-items-modal",tabindex:"-1",role:"dialog","aria-labelledby":"transactionItems","aria-hidden":"true"}},[a("div",{staticClass:"modal-dialog modal-dialog-centered modal-lg",attrs:{role:"document"}},[a("div",{staticClass:"modal-content"},[a("div",{staticClass:"modal-header"},[a("h5",{staticClass:"modal-title",attrs:{id:"transactionItems"}},[t._v("Transaction "+t._s(t.transactionItems.number))]),t._v(" "),t._m(2)]),t._v(" "),a("div",{staticClass:"col-md-12"},[t.ifReady?a("div",{staticClass:"progress",attrs:{height:"30px;"}},[a("div",{staticClass:"progress-bar progress-bar-striped progress-bar-animated",staticStyle:{width:"100%"},attrs:{role:"progressbar","aria-valuenow":"100","aria-valuemin":"0","aria-valuemax":"100"}})]):t._e()]),t._v(" "),a("div",{staticClass:"modal-body"},[t.transactionItems?a("table",{staticClass:"table table-hover table-sm"},[t._m(3),t._v(" "),t._m(4),t._v(" "),a("tbody",t._l(t.transactionItems.transaction_items,function(e){return a("tr",[a("td",[t._v(t._s(e.item.name))]),t._v(" "),a("td",[t._v(t._s(e.quantity))]),t._v(" "),a("td",[t._v(t._s(e.item.amount))])])}),0)]):t._e(),t._v(" "),t.transactionItems?a("div",{staticClass:"float-right"},[a("div",[a("strong",[t._v("Total Revenue:")]),t._v("\n                            "+t._s(t.transactionItems.total_amount)+"\n                        ")])]):t._e()])])])]),t._v(" "),a("div",{staticClass:"modal fade",attrs:{id:"search-modal",tabindex:"-1",role:"dialog","aria-labelledby":"search","aria-hidden":"true"}},[a("div",{staticClass:"modal-dialog modal-dialog-centered modal-lg",attrs:{role:"document"}},[a("div",{staticClass:"modal-content"},[t._m(5),t._v(" "),a("div",{staticClass:"modal-body"},[a("div",{staticClass:"form-group"},[a("label",[t._v("number")]),t._v(" "),a("input",{directives:[{name:"model",rawName:"v-model",value:t.number,expression:"number"}],staticClass:"form-control",attrs:{type:"text",autocomplete:"off",maxlength:"255"},domProps:{value:t.number},on:{input:function(e){e.target.composing||(t.number=e.target.value)}}})]),t._v(" "),a("div",{staticClass:"form-group"},[a("label",[t._v("Amount")]),t._v(" "),a("input",{directives:[{name:"model",rawName:"v-model",value:t.total_amount,expression:"total_amount"}],staticClass:"form-control",attrs:{type:"text",autocomplete:"off",maxlength:"255"},domProps:{value:t.total_amount},on:{input:function(e){e.target.composing||(t.total_amount=e.target.value)}}})]),t._v(" "),a("div",{staticClass:"form-group"},[a("label",[t._v("Order By")]),t._v(" "),a("select",{directives:[{name:"model",rawName:"v-model",value:t.order_by,expression:"order_by"}],staticClass:"form-control",on:{change:function(e){var a=Array.prototype.filter.call(e.target.options,function(t){return t.selected}).map(function(t){return"_value"in t?t._value:t.value});t.order_by=e.target.multiple?a:a[0]}}},[a("option",{attrs:{value:"desc"}},[t._v("Newest")]),t._v(" "),a("option",{attrs:{value:"asc"}},[t._v("Oldest")])])])]),t._v(" "),a("div",{staticClass:"modal-footer"},[a("button",{staticClass:"btn btn-danger btn-sm",attrs:{type:"button"},on:{click:function(e){return!e.type.indexOf("key")&&t._k(e.keyCode,"default",void 0,e.key,void 0)?null:(e.preventDefault(),t.clear(e))}}},[t._v("Clear")]),t._v(" "),a("button",{staticClass:"btn btn-success btn-sm",attrs:{type:"button"},on:{click:function(e){return!e.type.indexOf("key")&&t._k(e.keyCode,"default",void 0,e.key,void 0)?null:(e.preventDefault(),t.search(e))}}},[t._v("Search")]),t._v(" "),a("button",{staticClass:"btn btn-secondary btn-sm",attrs:{type:"button","data-dismiss":"modal"}},[t._v("Close")])])])])])])},staticRenderFns:[function(){var t=this.$createElement,e=this._self._c||t;return e("thead",[e("tr",[e("th",{attrs:{scope:"col"}},[this._v("Transaction Number")]),this._v(" "),e("th",{attrs:{scope:"col"}},[this._v("Total Revenue")]),this._v(" "),e("th",{attrs:{scope:"col"}},[this._v("Transaction Date")]),this._v(" "),e("th",{attrs:{scope:"col"}},[this._v("Options")])])])},function(){var t=this.$createElement,e=this._self._c||t;return e("div",{staticClass:"input-group-prepend"},[e("div",{staticClass:"input-group-text"},[this._v("Items per page")])])},function(){var t=this.$createElement,e=this._self._c||t;return e("button",{staticClass:"close",attrs:{type:"button","data-dismiss":"modal","aria-label":"Close"}},[e("span",{attrs:{"aria-hidden":"true"}},[this._v("×")])])},function(){var t=this.$createElement,e=this._self._c||t;return e("caption",[e("div",{staticClass:"row"})])},function(){var t=this.$createElement,e=this._self._c||t;return e("thead",[e("tr",[e("th",{attrs:{scope:"col"}},[this._v("Name")]),this._v(" "),e("th",{attrs:{scope:"col"}},[this._v("qty")]),this._v(" "),e("th",{attrs:{scope:"col"}},[this._v("Price")])])])},function(){var t=this.$createElement,e=this._self._c||t;return e("div",{staticClass:"modal-header"},[e("h5",{staticClass:"modal-title",attrs:{id:"search"}},[this._v("Search Transaction History")]),this._v(" "),e("button",{staticClass:"close",attrs:{type:"button","data-dismiss":"modal","aria-label":"Close"}},[e("span",{attrs:{"aria-hidden":"true"}},[this._v("×")])])])}]}},HyqV:function(t,e,a){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var s=function(t,e,a,s,r,i){var n={page:t,per_page:e,number:a,total_amount:s,order_by:r};axios.get("/api/transactions",{params:n}).then(function(t){i(null,t.data)}).catch(function(t){401==t.response.status&&location.reload(),500==t.response.status&&alert("Kindly report this issue to the devs.")})};e.default={data:function(){return{transaction_history:null,number:"",transactionItems:"",total_amount:"",transactionID:"",ifReady:!1,order_by:"desc",meta:{current_page:null,from:null,last_page:null,path:null,per_page:10,to:null,total:null},links:{first:null,last:null,next:null,prev:null},error:null,showProgress:!1,pageNumbers:[]}},beforeRouteEnter:function(t,e,a){null==t.query.per_page?s(t.query.page,10,t.query.number,t.query.total_amount,t.query.order_by,function(t,e){a(function(a){return a.setData(t,e)})}):s(t.query.page,t.query.per_page,t.query.number,t.query.total_amount,t.query.order_by,function(t,e){a(function(a){return a.setData(t,e)})})},beforeRouteUpdate:function(t,e,a){var r=this;s(t.query.page,this.meta.per_page,this.number,this.total_amount,this.order_by,function(t,e){r.setData(t,e),a()})},computed:{nextPage:function(){return this.meta.current_page+1},prevPage:function(){return this.meta.current_page-1},paginatonCount:function(){if(this.meta){var t=this.meta;return t.current_page+" of "+t.last_page}},pageCount:function(){return!(this.meta.last_page>10)},isPrevDisabled:function(){if(null==this.links.prev)return"disabled"},isNextDisabled:function(){if(null==this.links.next)return"disabled"}},methods:{goToFirstPage:function(){this.showProgress=!0,this.$router.push({number:"transaction_history.index",query:{page:1,per_page:this.meta.per_page,number:this.number,total_amount:this.total_amount,order_by:this.order_by}})},goToPage:function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:null;this.showProgress=!0,this.$router.push({number:"transaction_history.index",query:{page:t,per_page:this.meta.per_page,number:this.number,total_amount:this.total_amount,order_by:this.order_by}})},goToLastPage:function(){this.showProgress=!0,this.$router.push({number:"transaction_history.index",query:{page:this.meta.last_page,per_page:this.meta.per_page,number:this.number,total_amount:this.total_amount,order_by:this.order_by}})},goToNextPage:function(){this.showProgress=!0,this.$router.push({number:"transaction_history.index",query:{page:this.nextPage,per_page:this.meta.per_page,number:this.number,total_amount:this.total_amount,order_by:this.order_by}})},goToPreviousPage:function(){this.showProgress=!0,this.$router.push({number:"transaction_history.index",query:{page:this.prevPage,per_page:this.meta.per_page,number:this.number,total_amount:this.total_amount,order_by:this.order_by}})},setData:function(t,e){var a=e.data,s=e.links,r=e.meta;this.pageNumbers=[],t?this.error=t.toString():(this.transaction_history=a,console.log(this.transaction_history),this.links=s,this.meta=r),this.showProgress=!1,this.populatePages()},populatePages:function(){if(this.pageCount)for(var t=1;t<=this.meta.last_page;t++)this.pageNumbers.push(t);else if(this.meta.current_page<=6){this.pageNumbers.push(1),this.pageNumbers.push(2),this.pageNumbers.push(3),this.pageNumbers.push(4),this.pageNumbers.push(5),this.pageNumbers.push(6),this.pageNumbers.push(7),this.pageNumbers.push("..."),this.pageNumbers.push(this.meta.last_page-1),this.pageNumbers.push(this.meta.last_page)}else this.meta.current_page+6>=this.meta.last_page?(this.pageNumbers.push(1),this.pageNumbers.push(2),this.pageNumbers.push("..."),this.pageNumbers.push(this.meta.last_page-7),this.pageNumbers.push(this.meta.last_page-6),this.pageNumbers.push(this.meta.last_page-5),this.pageNumbers.push(this.meta.last_page-4),this.pageNumbers.push(this.meta.last_page-3),this.pageNumbers.push(this.meta.last_page-2),this.pageNumbers.push(this.meta.last_page-1),this.pageNumbers.push(this.meta.last_page)):(this.pageNumbers.push(1),this.pageNumbers.push(2),this.pageNumbers.push("..."),this.pageNumbers.push(this.meta.current_page-2),this.pageNumbers.push(this.meta.current_page-1),this.pageNumbers.push(this.meta.current_page),this.pageNumbers.push(this.meta.current_page+1),this.pageNumbers.push(this.meta.current_page+2),this.pageNumbers.push("..."),this.pageNumbers.push(this.meta.last_page-1),this.pageNumbers.push(this.meta.last_page))},isPageActive:function(t){if(t==this.$route.query.page||1==t&&null==this.$route.query.page)return"active"},changePerPage:function(){this.showProgress=!0,this.$router.push({number:"transaction_history.index",query:{page:1,per_page:this.meta.per_page,number:this.number,total_amount:this.total_amount,order_by:this.order_by}})},search:function(){$("#search-modal").modal("hide"),this.showProgress=!0,this.$router.push({number:"transaction_history.index",query:{page:1,per_page:this.meta.per_page,number:this.number,total_amount:this.total_amount,order_by:this.order_by}})},clear:function(){this.number="",this.total_amount="",this.order_by="desc"},openSearchModal:function(){$("#search-modal").modal("show")},openTransactionItemModal:function(t){var e=this;this.transactionItems="",this.ifReady=!0,$("#transaction-items-modal").modal("show"),new Promise(function(a,s){axios.get("/api/transactions/"+t).then(function(t){e.transactionItems=t.data.transaction,a()})}).then(function(){e.ifReady=!1})},formatDate:function(t){var e=new Date(t);return e.getMonth()+1+"/"+e.getDate()+"/"+e.getFullYear()}}}},fOZK:function(t,e,a){(t.exports=a("FZ+f")(!1)).push([t.i,".clickableText[data-v-e694f6b2]:hover{text-decoration:underline;cursor:pointer}",""])},"jb/7":function(t,e,a){var s=a("VU/8")(a("HyqV"),a("DsX+"),!1,function(t){a("oVOg")},"data-v-e694f6b2",null);t.exports=s.exports},oVOg:function(t,e,a){var s=a("fOZK");"string"==typeof s&&(s=[[t.i,s,""]]),s.locals&&(t.exports=s.locals);a("rjj0")("15a2dfc1",s,!0,{})},rjj0:function(t,e,a){var s="undefined"!=typeof document;if("undefined"!=typeof DEBUG&&DEBUG&&!s)throw new Error("vue-style-loader cannot be used in a non-browser environment. Use { target: 'node' } in your Webpack config to indicate a server-rendering environment.");var r=a("tTVk"),i={},n=s&&(document.head||document.getElementsByTagName("head")[0]),o=null,l=0,u=!1,c=function(){},p=null,h="data-vue-ssr-id",d="undefined"!=typeof navigator&&/msie [6-9]\b/.test(navigator.userAgent.toLowerCase());function m(t){for(var e=0;e<t.length;e++){var a=t[e],s=i[a.id];if(s){s.refs++;for(var r=0;r<s.parts.length;r++)s.parts[r](a.parts[r]);for(;r<a.parts.length;r++)s.parts.push(v(a.parts[r]));s.parts.length>a.parts.length&&(s.parts.length=a.parts.length)}else{var n=[];for(r=0;r<a.parts.length;r++)n.push(v(a.parts[r]));i[a.id]={id:a.id,refs:1,parts:n}}}}function _(){var t=document.createElement("style");return t.type="text/css",n.appendChild(t),t}function v(t){var e,a,s=document.querySelector("style["+h+'~="'+t.id+'"]');if(s){if(u)return c;s.parentNode.removeChild(s)}if(d){var r=l++;s=o||(o=_()),e=b.bind(null,s,r,!1),a=b.bind(null,s,r,!0)}else s=_(),e=function(t,e){var a=e.css,s=e.media,r=e.sourceMap;s&&t.setAttribute("media",s);p.ssrId&&t.setAttribute(h,e.id);r&&(a+="\n/*# sourceURL="+r.sources[0]+" */",a+="\n/*# sourceMappingURL=data:application/json;base64,"+btoa(unescape(encodeURIComponent(JSON.stringify(r))))+" */");if(t.styleSheet)t.styleSheet.cssText=a;else{for(;t.firstChild;)t.removeChild(t.firstChild);t.appendChild(document.createTextNode(a))}}.bind(null,s),a=function(){s.parentNode.removeChild(s)};return e(t),function(s){if(s){if(s.css===t.css&&s.media===t.media&&s.sourceMap===t.sourceMap)return;e(t=s)}else a()}}t.exports=function(t,e,a,s){u=a,p=s||{};var n=r(t,e);return m(n),function(e){for(var a=[],s=0;s<n.length;s++){var o=n[s];(l=i[o.id]).refs--,a.push(l)}e?m(n=r(t,e)):n=[];for(s=0;s<a.length;s++){var l;if(0===(l=a[s]).refs){for(var u=0;u<l.parts.length;u++)l.parts[u]();delete i[l.id]}}}};var g,f=(g=[],function(t,e){return g[t]=e,g.filter(Boolean).join("\n")});function b(t,e,a,s){var r=a?"":s.css;if(t.styleSheet)t.styleSheet.cssText=f(e,r);else{var i=document.createTextNode(r),n=t.childNodes;n[e]&&t.removeChild(n[e]),n.length?t.insertBefore(i,n[e]):t.appendChild(i)}}},tTVk:function(t,e){t.exports=function(t,e){for(var a=[],s={},r=0;r<e.length;r++){var i=e[r],n=i[0],o={id:t+":"+r,css:i[1],media:i[2],sourceMap:i[3]};s[n]?s[n].parts.push(o):a.push(s[n]={id:n,parts:[o]})}return a}}});