<template>
    <div>
        <breadcrumbs :routePrefixName="routePrefixName" :action="action" :singularName="singularName" :pluralName="pluralName" :useName="useName"></breadcrumbs>

        <div class="card">
            <div class="card-body">
                <form-title :routePrefixName="routePrefixName" :title="title" :singularName="singularName" :pluralName="pluralName" v-bind:showRightSide="true" :parameters="getParameters()"></form-title>
                <br>
                <data-table :pluralName="pluralName">
                    <template v-slot:thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Stock Keeping Unit</th>
                            <th scope="col">Item Classification</th>
                            <th scope="col">Item Type</th>
                            <th scope="col">Brand</th>
                            <th scope="col">Action</th>
                        </tr>
                    </template>
                    <template v-slot:tbody v-bind:data="data">
                        <tr :id="item.id" :key="item.id" v-for="item in data.data">
                            <td>{{ item.name }}</td>
                            <td>{{ item.stock_keeping_unit }}</td>
                            <td>{{ item.item_classification.display_name }}</td>
                            <td>{{ item.item_type.display_name }}</td>
                            <td>{{ item.brand.display_name }}</td>
                            <td><data-table-row-action :routePrefixName="routePrefixName" :object="item"></data-table-row-action></td>
                        </tr>
                    </template>
                </data-table>
            </div>
        </div>

        <br>
        
        <pagination v-if="data" :routeName="routeName" :meta="data.meta" :links="data.links" :parameters="getParameters()"></pagination>

        <search-modal v-if="data" :routeName="routeName" idAttribute="search-modal" ref="searchModal" :title="singularName" :parameters="getParameters()" @ClearParameters="clearParameters()">
            <template v-bind:data="$data">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" v-model="$data.name" maxlength="255" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Stock Keeping Unit</label>
                            <input class="form-control" v-model="$data.stock_keeping_unit" maxlength="100" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Identifier</label>
                            <input class="form-control" v-model="$data.identifier" maxlength="1000" autocomplete="off">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control" v-model="$data.description" maxlength="1000" autocomplete="off"></textarea>
                        </div>
                    </div>

                    <div class="col-md-4 form-group">
                        <label for="item-classification">Item Classification</label>
                        <input type="text" class="form-control" v-model="$data.name_from_classification" maxlength="255" autocomplete="off">
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="item-type">Item Type</label>
                        <input type="text" class="form-control" v-model="$data.name_from_item_type" maxlength="255" autocomplete="off">
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="brand">Brand</label>
                        <input type="text" class="form-control" v-model="$data.name_from_brand" maxlength="255" autocomplete="off">
                    </div>
                </div>
            </template>
        </search-modal>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                action:                        'View',
                title:                         'Items',
                singularName:                  'Item',
                pluralName:                    'Items',
                apiPath:                       '/api/items',
                routeName:                     'items.index',
                routePrefixName:               'items',
                useName:                       'plural',
                showProgress:                  false,
                data:                          null,
                order_by:                      'desc',
                name:                          null,
                stock_keeping_unit:            null,
                identifier:                    null,
                description:                   null,
                name_from_item_classification: null,
                name_from_item_type:           null,
                name_from_brand:               null
            };
        },

        beforeRouteEnter(to, from, next) {
            if (to.query.per_page == null) {
                next(vm => vm.getData({
                    page:                          to.query.page,
                    per_page:                      15,
                    name:                          to.query.name,
                    stock_keeping_unit:            to.query.stock_keeping_unit,
                    identifier:                    to.query.identifier,
                    description:                   to.query.description,
                    name_from_item_classification: to.query.name_from_item_classification,
                    name_from_item_type:           to.query.name_from_item_type,
                    name_from_brand:               to.query.name_from_brand,
                    order_by:                      to.query.order_by
                }));
            } else {
                next(vm => vm.getData({
                    page:                          to.query.page,
                    per_page:                      to.query.per_page,
                    name:                          to.query.name,
                    stock_keeping_unit:            to.query.stock_keeping_unit,
                    identifier:                    to.query.identifier,
                    description:                   to.query.description,
                    name_from_item_classification: to.query.name_from_item_classification,
                    name_from_item_type:           to.query.name_from_item_type,
                    name_from_brand:               to.query.name_from_brand,
                    order_by:                      to.query.order_by
                }));
            }
        },

        beforeRouteUpdate(to, from, next) {
            this.getData({
                page:                          to.query.page,
                per_page:                      this.data.meta.per_page,
                name:                          this.name,
                stock_keeping_unit:            this.stock_keeping_unit,
                identifier:                    this.identifier,
                description:                   this.description,
                name_from_item_classification: this.name_from_item_classification,
                name_from_item_type:           this.name_from_item_type,
                name_from_brand:               this.name_from_brand,
                order_by:                      this.order_by
            });

            next();
        },

        methods: {
            getData(params) {
                this.showProgress                  = true;
                this.name                          = params.name;
                this.stock_keeping_unit            = params.stock_keeping_unit;
                this.identifier                    = params.identifier;
                this.description                   = params.description;
                this.name_from_item_classification = params.name_from_item_classification;
                this.name_from_item_type           = params.name_from_item_type;
                this.name_from_brand               = params.name_from_brand;
                
                (typeof params.order_by === 'undefined' || params.order_by == 'desc') ? this.order_by = 'desc' : this.order_by = 'asc';

                axios.get(this.apiPath, { params }).then(res => {
                    this.data         = res.data;
                    this.data.data    = res.data.data;
                    this.showProgress = false;
                }).catch(error => {
                    if (error.response.status == 401) {
                        location.reload();
                    }

                    if (error.response.status == 500) {
                        alert('Kindly report this issue to the devs.');
                    }
                });
            },
            getParameters() {
                return {
                    name:                          this.name,
                    stock_keeping_unit:            this.stock_keeping_unit,
                    identifier:                    this.identifier,
                    description:                   this.description,
                    name_from_item_classification: this.name_from_item_classification,
                    name_from_item_type:           this.name_from_item_type,
                    name_from_brand:               this.name_from_brand
                };
            },
            clearParameters() {
                this.name                          = '';
                this.stock_keeping_unit            = '';
                this.identifier                    = '';
                this.description                   = '';
                this.name_from_item_classification = '';
                this.name_from_item_type           = '';
                this.name_from_brand               = '';
                this.order_by                      = 'desc';
            }
        }
    }
</script>

