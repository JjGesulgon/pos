<template>
    <div>
        <div class="card">
            <div class="card-header">
                <router-link class="text-primary" :to="{ name: 'settings.index' }">Settings</router-link>
                /
                <router-link class="text-primary" :to="{ name: 'corporations.index' }">Corporations</router-link>
                /
                <span class="text-secondary">Create New Corporation</span>
            </div>
            <div class="card-body">
                <div v-if="ifReady">
                    <form v-on:submit.prevent="createNewCorporation()">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" v-model="name" autocomplete="off" minlength="2" maxlength="255" required>
                        </div>

                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control" v-model="description" maxlength="1000" required></textarea>
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
                                    <label>Zip Code</label>
                                    <input type="text" class="form-control" v-model="zip_code" autocomplete="off" minlength="2" maxlength="255">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Country</label>
                                    <input type="text" class="form-control" v-model="country" autocomplete="off" minlength="2" maxlength="255" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Fax</label>
                                    <input type="text" class="form-control" v-model="fax" autocomplete="off" minlength="2" maxlength="255">
                                </div>
                            </div>
                        </div>

                        <br>

                        <button type="button" class="btn btn-outline-secondary btn-sm" @click.prevent="viewCorporations()"><i class="fas fa-chevron-left"></i>&nbsp; Back</button>
                        <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-plus"></i>&nbsp; Create New Corporation</button>
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
                ifReady: true,
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

        methods: {
            viewCorporations() {
                this.$router.push({ name: 'corporations.index' });
            },
            createNewCorporation() {
                this.ifReady = false;
                
                axios.post('/api/corporations', this.$data).then(res => {
                    this.$router.push({ name: 'corporations.index' });
                    Broadcast.$emit('NewCorporationCreated', {});
                }).catch(err => {
                    console.log(err);
                });
            }
        }
    }
</script>
