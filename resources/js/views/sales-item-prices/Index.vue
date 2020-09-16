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
                            <th scope="col">Item</th>
                            <th scope="col">Stock Keeping Unit</th>
                            <th scope="col">Universal Product Code</th>
                            <th scope="col">Identifier</th>
                            <th scope="col">Brand</th>
                            <th scope="col">Item Classification</th>
                            <th scope="col">Item Type</th>
                            <th scope="col">Measuring Mass</th>
                            <th scope="col">Unit of Measurement</th>
                            <th scope="col">Price</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </template>
                    <template v-slot:tbody v-bind:data="$data">
                        <tr :id="salesItemPrice.id" :key="salesItemPrice.id" v-for="salesItemPrice in data.data">
                            <td>{{ salesItemPrice.item.name }}</td>
                            <td>{{ salesItemPrice.item.stock_keeping_unit }}</td>
                            <td>{{ salesItemPrice.item.universal_product_code }}</td>
                            <td>{{ salesItemPrice.item.identifier }}</td>
                            <td>{{ salesItemPrice.item.brand.display_name }}</td>
                            <td>{{ salesItemPrice.item.item_classification.display_name }}</td>
                            <td>{{ salesItemPrice.item.item_type.display_name }}</td>
                            <td>{{ salesItemPrice.measuring_mass.mass }}</td>
                            <td>{{ salesItemPrice.unit_of_measurement.name }}</td>
                            <td>{{ salesItemPrice.price }}</td>
                            <td><data-table-row-action :routePrefixName="routePrefixName" :object="salesItemPrice"></data-table-row-action></td>
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
                    <div class="col-md-3 form-group">
                        <label for="item">Item</label>
                        <input id="item" type="text" class="form-control" v-model="$data.name_from_item" autocomplete="off" maxlength="255">
                    </div>
                    <div class="col-md-3 form-group">
                        <label for="measuring-mass">Measuring Mass</label>
                        <input id="measuring-mass" type="text" class="form-control" v-model="$data.mass_from_measuring_mass" autocomplete="off" maxlength="255">
                    </div>
                    <div class="col-md-3 form-group">
                        <label for="unit-of-measurement">Unit of Measurement</label>
                        <input id="unit-of-measurement" type="text" class="form-control" v-model="$data.name_from_unit_of_measurement" autocomplete="off" maxlength="255">
                    </div>
                    <div class="col-md-3 form-group">
                        <label for="price">Price</label>
                        <input id="price" type="number" class="form-control" v-model="$data.price" autocomplete="off" minlength="2" maxlength="255" step=".01" placeholder="0.00" required>
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
                title:                         'Sales Item Prices',
                singularName:                  'Sales Item Price',
                pluralName:                    'Sales Item Prices',
                apiPath:                       '/api/sales-item-prices',
                routeName:                     'sales-item-prices.index',
                routePrefixName:               'sales-item-prices',
                useName:                       'plural',
                showProgress:                  false,
                order_by:                      'desc',
                data:                          null,
                name_from_item:                null,
                mass_from_measuring_mass:      null,
                name_from_unit_of_measurement: null,
                price:                         null
            };
        },

        beforeRouteEnter(to, from, next) {
            if (to.query.per_page == null) {
                next(vm => vm.getData({
                    page:                          to.query.page,
                    per_page:                      15,
                    name_from_item:                to.query.name_from_item,
                    mass_from_measuring_mass:      to.query.mass_from_measuring_mass,
                    name_from_unit_of_measurement: to.query.name_from_unit_of_measurement,
                    price:                         to.query.price,
                    order_by:                      to.query.order_by
                }));
            } else {
                next(vm => vm.getData({
                    page:                          to.query.page,
                    per_page:                      to.query.per_page,
                    name_from_item:                to.query.name_from_item,
                    mass_from_measuring_mass:      to.query.mass_from_measuring_mass,
                    name_from_unit_of_measurement: to.query.name_from_unit_of_measurement,
                    price:                         to.query.price,
                    order_by:                      to.query.order_by
                }));
            }
        },

        beforeRouteUpdate(to, from, next) {
            this.getData({
                page:                          to.query.page,
                per_page:                      this.data.meta.per_page,
                name_from_item:                this.name_from_item,
                mass_from_measuring_mass:      this.mass_from_measuring_mass,
                name_from_unit_of_measurement: this.name_from_unit_of_measurement,
                price:                         this.price,
                order_by:                      this.order_by
            });

            next();
        },

        methods: {
            getData(params) {
                this.showProgress                  = true;
                this.name_from_item                = params.name_from_item;
                this.mass_from_measuring_mass      = params.mass_from_measuring_mass;
                this.name_from_unit_of_measurement = params.name_from_unit_of_measurement;
                this.price                         = params.price;
                
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
                    name_from_item:                this.name_from_item,
                    mass_from_measuring_mass:      this.mass_from_measuring_mass,
                    name_from_unit_of_measurement: this.name_from_unit_of_measurement,
                    price:                         this.price
                };
            },
            clearParameters() {
                this.name_from_item                = '';
                this.mass_from_measuring_mass      = '';
                this.name_from_unit_of_measurement = '';
                this.price                         = '';
                this.order_by                      = 'desc';
            }
        }
    }
</script>

