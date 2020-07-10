<template>
    <div>
        <div class="card">
            <div class="card-header">
                <router-link class="text-primary" :to="{ name: 'settings.index' }">Settings</router-link>
                /
                <router-link class="text-primary" :to="{ name: 'corporations.index' }">Corporations</router-link>
                /
                <span class="text-secondary">Edit Corporation</span>
            </div>
            <div class="card-body">
                <div v-if="ifReady">
                    <form v-on:submit.prevent="updateCorporation()">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" v-model="name" autocomplete="off" minlength="2" maxlength="255" required>
                        </div>

                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control" v-model="description" required></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Street</label>
                                    <input type="text" class="form-control" v-model="street" autocomplete="off" minlength="2" maxlength="255">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>City</label>
                                    <input type="text" class="form-control" v-model="city" autocomplete="off" minlength="2" maxlength="255">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>State</label>
                                    <input type="text" class="form-control" v-model="state" autocomplete="off" minlength="2" maxlength="255">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="zip_code">Zip Code</label>
                                    <input type="text" class="form-control" v-model="zip_code" autocomplete="off" minlength="2" maxlength="255">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="country">Country</label>
                                    <input type="text" class="form-control" v-model="country" autocomplete="off" minlength="2" maxlength="255" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="fax">Fax</label>
                                    <input type="text" class="form-control" v-model="fax" autocomplete="off" minlength="2" maxlength="255">
                                </div>
                            </div>
                        </div>

                        <button type="button" class="btn btn-outline-secondary btn-sm" @click.prevent.default="viewCorporation()"><i class="fas fa-chevron-left"></i>&nbsp; Back</button>
                        <button type="button" class="btn btn-success btn-sm"><i class="fas fa-edit"></i>&nbsp; Update Corporation</button>
                    </form>
                </div>
                <div v-else>
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                ifReady: false,
                id: '',
                name:'',
                description: '',
                street: '',
                city: '',
                state: '',
                zip_code: '',
                country: '',
                fax: ''
            };
        },

        mounted() {
            let promise = new Promise((resolve, reject) => {
                axios.get('/api/corporations/' + this.$route.params.id).then(res => {
                    if (! res.data.response) { return; }

                    this.id          = res.data.corporation.id;
                    this.name        = res.data.corporation.name;
                    this.description = res.data.corporation.description;
                    this.street      = res.data.corporation.street;
                    this.city        = res.data.corporation.city;
                    this.state       = res.data.corporation.state;
                    this.zip_code    = res.data.corporation.zip_code;
                    this.country     = res.data.corporation.country;
                    this.fax         = res.data.corporation.fax;
                    resolve();
                });
            });

            promise.then(() => {
                this.ifReady = true;
            });
        },

        methods: {
            viewCorporation() {
                this.$router.push({
                    name: 'corporations.view',
                    params: { id: this.$route.params.id }
                });
            },
            updateCorporation() {
                axios.patch('/api/corporations/' + this.$route.params.id, this.$data).then(res => {
                    if (! res.data.response) { return; }

                    this.$router.push({
                        name: 'corporations.view',
                        params: { id: this.$route.params.id }
                    });
                });
            }
        }
    }
</script>
