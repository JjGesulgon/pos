<template>
  <div>
    <breadcrumbs
      :routePrefixName="routePrefixName"
      :action="action"
      :singularName="singularName"
      :pluralName="pluralName"
      :useName="useName"
    ></breadcrumbs>
    <div class="card">
      <div class="card-body">
        <form-title :routePrefixName="routePrefixName" :title="title" v-bind:showRightSide="false"></form-title>

        <!-- Select Branch / Warehouse | Select Contact -->
        <div class="row">
          <div class="col-md-6 form-group">
            <label for="from">
              From
              &nbsp;
              <div class="form-check form-check-inline">
                <div>
                  <input
                    id="from-branch"
                    type="radio"
                    v-model="from_selected_radio_button"
                    value="branch"
                  />
                  <label for="from-branch" class="form-check-label">&nbsp; Branch</label>
                </div>
              </div>
              <div class="form-check form-check-inline">
                <div>
                  <input
                    id="from-warehouse"
                    type="radio"
                    v-model="from_selected_radio_button"
                    value="warehouse"
                  />
                  <label for="from-warehouse" class="form-check-label">&nbsp; Warehouse</label>
                </div>
              </div>
            </label>
            <search
              apiPath="/api/branches/search"
              idAttribute="from"
              styleClass="form-control"
              labelAttribute="name"
              searchColumn="name"
              placeholder="Search Branches"
              v-show="from_selected_radio_button === 'branch'"
              @SelectOption="selectFromBranch($event)"
            ></search>
            <search
              apiPath="/api/warehouses/search"
              idAttribute="from"
              styleClass="form-control"
              labelAttribute="name"
              searchColumn="name"
              placeholder="Search Warehouses"
              v-show="from_selected_radio_button === 'warehouse'"
              @SelectOption="selectFromWarehouse($event)"
            ></search>
          </div>
          <div class="col-md-6 form-group">
            <label id="contact">Contact</label>
            <search
              apiPath="/api/contacts/search"
              idAttribute="contact"
              styleClass="form-control"
              labelAttribute="name"
              searchColumn="name"
              placeholder="Search Contacts"
              @SelectOption="selectContact($event)"
            ></search>
          </div>
          <div class="col-md-6 form-group">
            <label for="number">Number Slip</label>
            <input
              id="number"
              type="text"
              class="form-control"
              v-model="$data.number"
              readonly
              required
            />
          </div>
          <div class="col-md-6 form-group">
            <label for="reference-number">Reference Number</label>
            <input
              id="reference-number"
              type="text"
              class="form-control"
              v-model="$data.reference_number"
              readonly
              required
            />
          </div>
        </div>

        <br />

        <!-- Discount and Taxation -->
        <div class="row">
          <!-- Discount -->
          <div class="col-md-6 form-group">
            <div class="custom-control custom-switch">
              <input
                type="checkbox"
                class="custom-control-input"
                id="discountableSwitch"
                @change="toggleIfDiscountable()"
              />
              <label class="custom-control-label" for="discountableSwitch">Check if Discountable</label>
            </div>

            <br v-if="is_discountable" />

            <div class="row" v-if="is_discountable">
              <div class="col">
                <div class="custom-control custom-radio custom-control-inline">
                  <input
                    type="radio"
                    id="default-discount"
                    class="custom-control-input"
                    v-model="discount_type"
                    value="Total"
                  />
                  <label class="custom-control-label" for="default-discount">Total</label>
                </div>
              </div>
              <div class="col">
                <div class="custom-control custom-radio custom-control-inline">
                  <input
                    type="radio"
                    id="item-discount"
                    class="custom-control-input"
                    v-model="discount_type"
                    value="Per Item"
                  />
                  <label class="custom-control-label" for="item-discount">Per Item</label>
                </div>
              </div>
              <div class="col">
                <div class="custom-control custom-radio custom-control-inline">
                  <input
                    type="radio"
                    id="brand-discount"
                    class="custom-control-input"
                    v-model="discount_type"
                    value="Per Brand"
                  />
                  <label class="custom-control-label" for="brand-discount">Per Brand</label>
                </div>
              </div>
              <div class="col">
                <div class="custom-control custom-radio custom-control-inline">
                  <input
                    type="radio"
                    id="mixed-discount"
                    class="custom-control-input"
                    v-model="discount_type"
                    value="Mixed"
                  />
                  <label class="custom-control-label" for="mixed-discount">Mixed All</label>
                </div>
              </div>
            </div>

            <br />

            <div class="row">
              <div class="col-md-6">
                <div class="input-group" v-if="is_discountable">
                  <div class="input-group-prepend">
                    <div class="input-group-text" id="btnGroupAddon">Discount %</div>
                  </div>
                  <input
                    type="number"
                    class="form-control"
                    min="0"
                    max="100"
                    v-model="discount_percent"
                  />
                </div>
              </div>
            </div>

            <br v-if="is_discountable" />
          </div>

          <!-- Tax -->
          <div class="col-md-6">
            <div class="row">
              <div class="col-md-6">
                <div class="custom-control custom-switch">
                  <input
                    type="checkbox"
                    class="custom-control-input"
                    id="taxable-switch"
                    :checked="is_taxable"
                    @change="toggleIfTaxable()"
                  />
                  <label class="custom-control-label" for="taxable-switch">Check if Taxable</label>
                </div>
              </div>
              <div class="col-md-6">
                <div v-if="is_taxable" class="custom-control custom-switch">
                  <input
                    type="checkbox"
                    class="custom-control-input"
                    id="is-tax-inclusive"
                    :checked="is_tax_inclusive"
                    @change="toggleIsTaxInclusive()"
                  />
                  <label
                    class="custom-control-label"
                    for="is-tax-inclusive"
                  >Is Tax Inclusive (Included)</label>
                </div>
              </div>
            </div>

            <br v-if="is_taxable" />

            <div class="row" v-if="is_taxable">
              <div class="col">
                <div class="custom-control custom-radio custom-control-inline">
                  <input
                    type="radio"
                    id="default-tax"
                    class="custom-control-input"
                    v-model="tax_type"
                    value="Total"
                  />
                  <label class="custom-control-label" for="default-tax">Total</label>
                </div>
              </div>
              <div class="col">
                <div class="custom-control custom-radio custom-control-inline">
                  <input
                    type="radio"
                    id="item-tax"
                    class="custom-control-input"
                    v-model="tax_type"
                    value="Per Item"
                  />
                  <label class="custom-control-label" for="item-tax">Per Item</label>
                </div>
              </div>
              <div class="col">
                <div class="custom-control custom-radio custom-control-inline">
                  <input
                    type="radio"
                    id="mixed-tax"
                    class="custom-control-input"
                    v-model="tax_type"
                    value="Mixed"
                  />
                  <label class="custom-control-label" for="mixed-tax">Mixed Both</label>
                </div>
              </div>
            </div>

            <br />

            <div class="row">
              <div class="col-md-6">
                <div
                  class="input-group"
                  v-if="is_taxable && (tax_type == 'Total' || tax_type == 'Mixed')"
                >
                  <div class="input-group-prepend">
                    <div class="input-group-text" id="btnGroupAddon">Tax %</div>
                  </div>
                  <input type="number" class="form-control" min="0" max="100" v-model="tax_percent" />
                </div>
              </div>
            </div>

            <br v-if="is_taxable" />
          </div>
        </div>

        <!-- Original Code (Item Search and Cart) -->
        <div class="row">
          <!-- Cart -->
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <i class="fas fa-shopping-cart"></i>&nbsp; Cart
                <button
                  type="button"
                  class="btn btn-success btn-sm float-right"
                  @click.prevent="isShow = !isShow"
                >Search Items</button>
              </div>
              <div class="card-body">
                <table class="table table-hover table-sm card-title">
                  <thead class="thead-light">
                    <tr>
                      <th scope="col">Name</th>
                      <th scope="col">Price</th>
                      <th scope="col">qty</th>
                      <th scope="col">Total Price</th>
                      <th scope="col">Options</th>
                    </tr>
                  </thead>
                  <tbody v-if="cart">
                    <tr v-for="item in cart" :key="item.id">
                      <td>{{ item.name }}</td>
                      <td>{{ item.amount }}</td>
                      <td>
                        <input
                          type="number"
                          id="qty"
                          name="quantity"
                          v-model="item.qty"
                          v-bind:max="item.stocks_available"
                        />
                      </td>
                      <td>{{ (item.qty * item.amount).toFixed(2) }}</td>
                      <td>
                        <label
                          class="text-danger clickableText"
                          @click.prevent="removeFromCart(item)"
                        >
                          <i class="fas fa-trash-alt"></i>&nbsp;
                          <strong>Remove</strong>
                        </label>
                      </td>
                    </tr>
                    <tr v-if="priceSummation() != 0">
                      <td scope="row" colspan="5">
                        <br />
                      </td>
                    </tr>
                    <tr v-if="priceSummation() != 0">
                      <td scope="row" colspan="5"></td>
                    </tr>
                    <tr class="no-border" v-if="priceSummation() != 0">
                      <td scope="row" colspan="4"></td>
                      <td scope="row">
                        <strong>Total Bill:</strong>
                        {{ priceSummation() }}
                      </td>
                    </tr>
                    <tr class="no-border" v-if="priceSummation() != 0">
                      <td scope="row" colspan="4"></td>
                      <td scope="row">
                        <strong>Cash:</strong>
                        <input type="number" id="cash" name="cash" v-model="cash" />
                      </td>
                    </tr>
                    <tr class="no-border" v-if="priceSummation() != 0">
                      <td scope="row" colspan="4"></td>
                      <td scope="row">
                        <strong>Change:</strong>
                        {{ (this.cash - priceSummation()).toFixed(2)}}
                      </td>
                    </tr>
                    <tr class="no-border" v-if="priceSummation() != 0">
                      <td scope="row" colspan="4"></td>
                      <td scope="row">
                        <button
                          type="button"
                          class="btn btn-success btn-sm"
                          @click.prevent="openCheckoutModal()"
                        >
                          <i class="fas fa-cash-register"></i>&nbsp;
                          Checkout
                        </button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>

            <br />

            <!-- Item List Snackbar -->
            <div id="snackbar">
              <div class="card">
                <div class="card-header">
                  <div class="row clearfix">
                    <div class="float-left col-md-6">Items</div>
                    <div class="float-right col-md-6">
                      <input
                        type="text"
                        class="form-control form-control-sm"
                        v-model="itemName"
                        @input="onSearch"
                        placeholder="Search Item"
                      />
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <table class="table table-hover table-sm">
                    <caption>
                      <div class="row">
                        <div class="col-md-9">List of Items</div>
                        <div class="col-md-3">
                          <div class="progress" height="30px;" v-if="showProgress">
                            <div
                              class="progress-bar progress-bar-striped progress-bar-animated"
                              role="progressbar"
                              aria-valuenow="100"
                              aria-valuemin="0"
                              aria-valuemax="100"
                              style="width: 100%;"
                            ></div>
                          </div>
                        </div>
                      </div>
                    </caption>
                    <thead class="thead-light">
                      <tr>
                        <th scope="col">Brand Name</th>
                        <th scope="col">Name</th>
                        <th scope="col">Measuring Mass</th>
                        <th scope="col">Unit Of Measurement</th>
                        <th scope="col">Price</th>
                        <th scope="col">Options</th>
                      </tr>
                    </thead>
                    <tbody v-if="items">
                      <tr v-for="item in items" :key="item.id">
                        <td>{{ item.brand.display_name }}</td>
                        <td>{{ item.name_identifier }}</td>
                        <td>{{ item.sales_item_prices[0].measuring_mass.mass }}</td>
                        <td>{{ item.sales_item_prices[0].unit_of_measurement.abbreviation }}</td>
                        <td
                          v-if="item.default_sales_item_price"
                        >{{ item.default_sales_item_price.price }}</td>
                        <td v-else>{{ item.sales_item_prices[0].price }}</td>
                        <td>
                          <div v-if="item.stocks_available != 0">
                            <label
                              class="text-secondary clickableText"
                              @click.prevent="addToCart(item)"
                            >
                              <i class="fas fa-cart-arrow-down"></i>&nbsp;
                              <strong>Add to Cart</strong>
                            </label>
                          </div>
                          <div v-else>
                            <label class="text-danger">
                              <i class="fas fa-exclamation-circle"></i>&nbsp;
                              <strong>Not Available</strong>
                            </label>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <!-- Confirm Cart Modal -->
          <div
            class="modal fade"
            id="checkout-modal"
            tabindex="-1"
            role="dialog"
            aria-labelledby="checkout"
            aria-hidden="true"
          >
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="search">Confirm Payment</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <table class="table table-hover table-sm card-title">
                    <thead>
                      <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Price</th>
                        <th scope="col">qty</th>
                        <th scope="col">Total Price</th>
                      </tr>
                    </thead>
                    <tbody v-if="cart">
                      <tr v-for="item in cart" :key="item.id">
                        <td>{{ item.name }}</td>
                        <td>{{ item.amount }}</td>
                        <td>{{ item.qty }}</td>
                        <td>{{ (item.qty * item.amount).toFixed(2) }}</td>
                      </tr>
                    </tbody>
                  </table>
                  <div class="card-text">
                    <br />
                    <br />
                    <div class="float-right">
                      <div>
                        <strong>Total Bill:</strong>
                        {{ priceSummation() }}
                      </div>
                      <div>
                        <strong>Cash:</strong>
                        <input type="number" id="cash" name="cash" v-model="cash" disabled />
                      </div>
                      <div>
                        <strong>Change:</strong>
                        {{ (this.cash - priceSummation()).toFixed(2)}}
                      </div>
                    </div>
                  </div>
                </div>
                <div class="container mb-4" v-if="this.ifReady">
                  <div class="progress" height="30px;">
                    <div
                      class="progress-bar progress-bar-striped progress-bar-animated"
                      role="progressbar"
                      aria-valuenow="100"
                      aria-valuemin="0"
                      aria-valuemax="100"
                      style="width: 100%;"
                    ></div>
                  </div>
                </div>
                <div class="modal-footer" v-else>
                  <button
                    type="button"
                    class="btn btn-success btn-sm"
                    @click.prevent="createNewTransaction()"
                  >Proceed</button>
                </div>
              </div>
            </div>
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
      items: null,
      name: "",
      itemName: "",
      cart: [],
      cash: 0,
      order_by: "desc",
      error: null,
      showProgress: false,
      pageNumbers: [],
      ifReady: false,

      action: "Create New",
      title: "Create New Transaction",
      singularName: "Transaction",
      pluralName: "Transactions",
      apiPath: "/api/transactions",
      routePrefixName: "transactions",
      useName: "singular",
      toastMessage: "Quotation",
      from_selected_radio_button: "branch",
      contact_id: null,
      transactionable_from_id: null,
      transactionable_from_type: null,
      number: null,
      reference_number: null,
      is_discountable: false,
      discount_type: "Total",
      discount_percent: 0,
      is_taxable: true,
      is_tax_inclusive: true,
      tax_type: "Total",
      tax_percent: 12,
      isShow: false,
    };
  },

  mounted() {
    Broadcast.$on("NewTransactionNumberGenerated", (event) => {
      this.number = event.number;
    });

    Broadcast.$on("NewTransactionReferenceNumberGenerated", (event) => {
      this.reference_number = event.referenceNumber;
    });
  },

  watch: {
    isShow: function (val) {
      this.showItemList(val)
    },
  },

  computed: {
    // subTotalAmount() {
    //     return this.purchase_order_items.map((purchase_order_item) => {
    //         return (purchase_order_item.quantity * purchase_order_item.unit_price);
    //     });
    // },
    // totalAmount() {
    //     return this.purchase_order_items.reduce((total, purchase_order_item) => {
    //         return total + (purchase_order_item.quantity * purchase_order_item.unit_price);
    //     }, 0);
    // }
  },

  methods: {
    selectContact(contact) {
      if (typeof contact === "object") {
        this.reference_number = "Generating New Reference Number";
        this.contact_id = contact.id;

        this.$generate.referenceNumber("transaction", {
          contact_id: contact.id,
        });
      }
    },
    selectFromWarehouse(warehouse) {
      if (typeof warehouse === "object") {
        this.transactionable_from_id = warehouse.id;
        this.transactionable_from_type = "App\\Warehouse";
        this.number = "Generating New Number Slip";

        this.$generate.number("transaction", { warehouse_id: warehouse.id });
      }
    },
    selectFromBranch(branch) {
      if (typeof branch === "object") {
        this.transactionable_from_id = branch.id;
        this.transactionable_from_type = "App\\Branch";
        this.number = "Generating New Number Slip";

        this.$generate.number("transaction", { branch_id: branch.id });
      }
    },
    toggleIfDiscountable() {
      if (this.is_discountable) {
        this.is_discountable = false;
      } else {
        this.is_discountable = true;
      }
    },
    toggleIfTaxable() {
      if (this.is_taxable) {
        this.is_taxable = false;
      } else {
        this.is_taxable = true;
      }
    },
    toggleIsTaxInclusive() {
      if (this.is_tax_inclusive) {
        this.is_tax_inclusive = false;
      } else {
        this.is_tax_inclusive = true;
      }
    },

    showItemList(isShow) {
      var el = document.getElementById("snackbar");
      isShow ? el.className = "show" : el.className = ""
    },

    // Original Code
    onSearch() {
      this.search(this.itemName, this);
    },
    search: _.debounce((itemName, vm) => {
      axios
        .get("/api/items/search-for-sales", {
          params: {
            name: itemName,
            identifier: itemName,
            name_from_item_type: itemName,
            name_from_brand: itemName,
          },
        })
        .then((res) => {
          vm.items = res.data;
        });
    }, 250),
    clear() {
      this.name = "";
      this.amount = "";
      this.order_by = "desc";
    },
    openSearchModal() {
      $("#search-modal").modal("show");
    },
    openCheckoutModal() {
      if (parseInt(this.cash).toFixed(2) - this.priceSummation() < 0) {
        alert("Insufficient Funds");
      } else {
        $("#checkout-modal").modal("show");
      }
    },
    addToCart(item) {
      const found = this.cart.some((el) => el.id === item.id);
      if (!found) {
        var cartItem = {
          id: item.id,
          name: item.name,
          amount: item.default_sales_item_price
            ? item.default_sales_item_price
            : item.sales_item_prices[0].price,
          stocks_available: item.stock_keeping_unit,
          qty: 1,
        };
        this.cart.push(cartItem);
        console.log(this.cart);
      } else {
        alert("Item already exists in cart");
      }
    },
    priceSummation() {
      var total = 0;
      this.cart.forEach((el) => {
        total += el.amount * el.qty;
      });
      return total.toFixed(2);
    },
    removeFromCart(item) {
      this.cart.splice(
        this.cart.findIndex((x) => (x.id = item.id)),
        1
      );
    },
    createNewTransaction() {
      if (parseInt(this.cash).toFixed(2) - this.priceSummation() < 0) {
        alert("Insufficient Funds");
      } else {
        this.ifReady = true;
        var transaction = {
          total_amount: this.priceSummation(),
          cart: this.cart,
        };

        axios
          .post("/api/transactions", transaction)
          .then((res) => {
            for (let cartItem = 0; cartItem < this.cart.length; cartItem++) {
              let data = {
                name: this.cart[cartItem].name,
                amount: this.cart[cartItem].amount,
                stocks_available:
                  this.cart[cartItem].stocks_available -
                  this.cart[cartItem].qty,
              };

              axios
                .patch("/api/items/" + this.cart[cartItem].id, data)
                .then((res) => {
                  console.log("Item Update Successful");
                })
                .catch((err) => {
                  console.log(err);
                });
            }

            $("#checkout-modal").modal("hide");

            Broadcast.$emit("ToastMessage", {
              message: "Transaction Created Successfully",
            });

            this.cart = [];
            this.cash = "";

            this.$router.go();
          })
          .catch((err) => {
            this.ifReady = true;
            console.log(err);
          });
      }
    },
  },
};
</script>

<style>
.clickableText:hover {
  text-decoration: underline;
  cursor: pointer;
}

.table > tbody > tr.no-border > td,
.table > tbody > tr.no-border > th {
  border-top: none;
}

#snackbar {
  visibility: hidden;
  position: fixed;
  left: 0;
  right: 0;
  bottom: 0;
}

#snackbar.show {
  visibility: visible;
  -webkit-animation: fadein 0.5s;
  animation: fadein 0.5s;
}
</style>
