<template>
    <div>
        <breadcrumbs :routePrefixName="routePrefixName" :action="action" :singularName="singularName" :pluralName="pluralName" :useName="useName"></breadcrumbs>

        <div class="card">
            <div class="card-body">
                <form-title :routePrefixName="routePrefixName" :title="title" v-bind:showRightSide="false"></form-title>
                <br>
                <form-edit :apiPath="apiPath" :routePrefixName="routePrefixName" :singularName="singularName" :toastMessage="toastMessage" :fieldColumns="getFieldColumns()">
                    <template v-bind:data="$data">
                        <div class="form-group">
                            <label for="name">Name <small class="text-danger">* Required</small></label>
                            <input id="name" type="text" class="form-control" v-model="$data.name" autocomplete="off" minlength="2" maxlength="255" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea id="description" class="form-control" v-model="$data.description" maxlength="1000"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="street">Street</label>
                                    <input id="street" type="text" class="form-control" v-model="$data.street" autocomplete="off" minlength="2" maxlength="255">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="city">City</label>
                                    <input id="city" type="text" class="form-control" v-model="$data.city" autocomplete="off" minlength="2" maxlength="255">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="state">State</label>
                                    <input id="state" type="text" class="form-control" v-model="$data.state" autocomplete="off" minlength="2" maxlength="255">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="zip_code">Zip Code</label>
                                    <input id="zip_code" type="text" class="form-control" v-model="$data.zip_code" autocomplete="off" minlength="2" maxlength="255">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="country">Country <small class="text-danger">* Required</small></label>
                                    <input id="country" type="text" class="form-control" v-model="$data.country" autocomplete="off" minlength="2" maxlength="255" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="fax">Fax</label>
                                    <input id="fax" type="text" class="form-control" v-model="$data.fax" autocomplete="off" minlength="2" maxlength="255">
                                </div>
                            </div>
                        </div>
                    </template>
                </form-edit>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                ifReady:          false,
                action:           'Edit',
                title:            'Edit Corporation',
                singularName:     'Corporation',
                pluralName:       'Corporations',
                apiPath:          '/api/corporations',
                routePrefixName:  'corporations',
                useName:          'singular',
                selectedProperty: 'name',
                toastMessage:     'Corporation',
                name:            null,
                description:     null,
                street:          null,
                city:            null,
                state:           null,
                zip_code:        null,
                country:         null,
                fax:             null,
            };
        },

        mounted() {
            let promise = new Promise((resolve, reject) => {
                axios.get(this.apiPath + '/' + this.$route.params.id).then(res => {
                    this.name        = res.data.corporation.name;
                    this.description = res.data.corporation.description;
                    this.street      = res.data.corporation.street;
                    this.city        = res.data.corporation.city;
                    this.state       = res.data.corporation.state;
                    this.zip_code    = res.data.corporation.zip_code;
                    this.country     = res.data.corporation.country;
                    this.fax         = res.data.corporation.fax;

                    resolve();
                }).catch(err => {
                    reject();
                });
            });

            promise.then(() => {
                this.ifReady = true;
            });
        },

        methods: {
            getFieldColumns() {
                return {
                    name:            this.name,
                    description:     this.description,
                    street:          this.street,
                    city:            this.city,
                    state:           this.state,
                    zip_code:        this.zip_code,
                    country:         this.country,
                    fax:             this.fax,
                }
            }
        }
    }
</script>

