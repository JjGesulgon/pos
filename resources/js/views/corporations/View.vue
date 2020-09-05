<template>
    <div>
      <breadcrumbs :routePrefixName="routePrefixName" :action="action" :singularName="singularName" :pluralName="pluralName" :useName="useName"></breadcrumbs>

      <div class="card">
          <div class="card-body">
              <form-title :routePrefixName="routePrefixName" :title="title" v-bind:showRightSide="false"></form-title>
              <br>
              <form-view :apiPath="apiPath" :routePrefixName="routePrefixName" :singularName="singularName" :object="corporation" :selectedProperty="selectedProperty" :toastMessage="toastMessage">
                  <template v-bind:corporation="corporation">
                      <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" v-model="corporation.name" readonly>
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" v-model="corporation.description" readonly></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="street">Street</label>
                                    <input type="text" class="form-control" v-model="corporation.street" readonly>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="city">City</label>
                                    <input type="text" class="form-control" v-model="corporation.city" readonly>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="state">State</label>
                                    <input type="text" class="form-control" v-model="corporation.state" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="zip_code">Zip Code</label>
                                    <input type="text" class="form-control" v-model="corporation.zip_code" readonly>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="country">Country</label>
                                    <input type="text" class="form-control" v-model="corporation.country" readonly>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="fax">Fax</label>
                                    <input type="text" class="form-control" v-model="corporation.fax" readonly>
                                </div>
                            </div>
                        </div>
                  </template>
              </form-view>
          </div>
      </div> 

    </div>
</template>

<script>
    export default {
        data() {
            return {
                ifReady:          false,
                action:           'View',
                title:            'View Corporation',
                singularName:     'Corporation',
                pluralName:       'Corporations',
                apiPath:          '/api/corporations',
                routePrefixName:  'corporations',
                useName:          'singular',
                selectedProperty: 'name',
                toastMessage:     'Corporation',
                corporation:            {}
            };
        },

        mounted() {
            let promise = new Promise((resolve, reject) => {
                axios.get(this.apiPath + '/' + this.$route.params.id).then(res => {
                    this.corporation = res.data.corporation;
                    resolve();
                }).catch(err => {
                    reject();
                });
            });

            promise.then(() => {
                this.ifReady = true;
            });
        }
    }
</script>
