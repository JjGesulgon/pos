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
                            <th scope="col">Description</th>
                            <th scope="col">Address</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </template>
                    <template v-slot:tbody v-bind:data="$data">
                        <tr :id="corporations.id" v-for="corporations in data.data" :key="corporations.id">
                            <td>{{ corporations.name }}</td>
                            <td>{{ corporations.description }}</td>
                            <td>{{ corporations.street }}, {{ corporations.country}}, {{ corporations.zip_code }}</td>
                            <td><data-table-row-action :routePrefixName="routePrefixName" :object="corporations"></data-table-row-action></td>
                        </tr>
                    </template>
                </data-table>
            </div>
        </div>

        <br>

        <pagination v-if="data" :routeName="routeName" :meta="data.meta" :links="data.links" :parameters="getParameters()"></pagination>

        <search-modal v-if="data" :routeName="routeName" idAttribute="search-modal" ref="searchModal" :title="singularName" :parameters="getParameters()" @ClearParameters="clearParameters()">
            <template v-bind:data="$data">
                <div class="form-group">
                    <label>Name</label>
                    <input id="name" type="text" class="form-control" v-model="$data.name" autocomplete="off" minlength="2" maxlength="255">
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea id="description" class="form-control" v-model="$data.description" maxlength="1000"></textarea>
                </div>
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label for="street">Street</label>
                        <input id="street" type="text" class="form-control" v-model="$data.street" autocomplete="off">
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="city">City</label>
                        <input id="city" type="text" class="form-control" v-model="$data.city" autocomplete="off">
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="state">State</label>
                        <input id="state" type="text" class="form-control" v-model="$data.state" autocomplete="off">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label for="zip_code">Zip Code</label>
                        <input id="zip_code" type="text" class="form-control" v-model="$data.zip_code" autocomplete="off">
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="country">Country</label>
                        <input id="country" type="text" class="form-control" v-model="$data.country" autocomplete="off">
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="fax">Fax</label>
                        <input id="fax" type="text" class="form-control" v-model="$data.fax" autocomplete="off">
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
                data:            null,
                action:          'View',
                title:           'Corporation',
                pluralName:      'Corporations',
                singularName:    'Corporation',
                apiPath:         '/api/corporations',
                routeName:       'corporations.index',
                routePrefixName: 'corporations',
                useName:         'plural',
                name:            null,
                description:     null,
                street:          null,
                city:            null,
                state:           null,
                zip_code:        null,
                country:         null,
                fax:             null,
                order_by:        'desc',
                error:           null,
                showProgress:    false,
                pageNumbers:     [],
            };
        },

        beforeRouteEnter(to, from, next) {
            if (to.query.per_page == null) {
                next(vm => vm.getData({
                    page:            to.query.page,
                    per_page:        15,
                    name:            to.query.name,
                    description:     to.query.description,
                    street:          to.query.street,
                    city:            to.query.city,
                    state:           to.query.state,
                    zip_code:        to.query.zip_code,
                    country:         to.query.country,
                    fax:             to.query.fax,
                    order_by:        to.query.order_by
                }));
            } else {
                next(vm => vm.getData({
                    page:            to.query.page,
                    per_page:        to.query.per_page,
                    name:            to.query.name,
                    description:     to.query.description,
                    street:          to.query.street,
                    city:            to.query.city,
                    state:           to.query.state,
                    zip_code:        to.query.zip_code,
                    country:         to.query.country,
                    fax:             to.query.fax,
                    order_by:        to.query.order_by
                }));
            }
        },

        beforeRouteUpdate(to, from, next) {
            this.getData({
                page:            to.query.page,
                per_page:        this.data.meta.per_page,
                name:            this.name,
                description:     this.description,
                street:          this.street,
                city:            this.city,
                state:           this.state,
                zip_code:        this.zip_code,
                country:         this.country,
                fax:             this.fax,
                order_by:        this.order_by
            });

            next();
        },

        methods: {
            getData(params) {
                this.showProgress = true;
                this.name         = params.name;
                this.description  = params.description;
                this.street       = params.street;
                this.city         = params.city;
                this.state        = params.state;
                this.zip_code     = params.zip_code;
                this.country      = params.country;
                this.fax          = params.fax;
                this.order_by     = params.order_by;
                
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
                    name:            this.name,
                    description:     this.description,
                    street:          this.street,
                    city:            this.city,
                    state:           this.state,
                    zip_code:        this.zip_code,
                    country:         this.country,
                    fax:             this.fax,
                    order_by:        this.order_by
                };
            },
            clearParameters() {
                this.name         = '';
                this.description = '';
                this.street       = '';
                this.city         = '';
                this.state        = '';
                this.zip_code     = '';
                this.country      = '';
                this.fax          = '';
                this.order_by     = 'desc';
            }
        }
    }
</script>