<template>
    <div>
        <div class="row mt-3">
            <div class="col-12">
                <div class="row">
                    <div class="col-md-3 col-sm-12">
                        <div class="card card-min">
                            <div class="card-body row">
                                <div class="col-md-12 col-sm-12 text-center  center">
                                    <h1 v-if="totalTransactions">{{ totalTransactions.length }}</h1>
                                    <div v-else class="fa-3x">
                                      <i class="fas fa-spinner fa-pulse"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-center">
                                <strong>
                                    Today's Transactions
                                </strong>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-12">
                        <div class="card card-min">
                            <div class="card-body row">
                                <div class="col-md-12 col-sm-12 text-center  center">
                                    <h1 v-if="totalTransactions">{{ total_sales_today }} PHP</h1>
                                    <div v-else class="fa-3x">
                                      <i class="fas fa-spinner fa-pulse"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-center">
                                <strong>
                                    Today's Total Sales
                                </strong>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-12">
                        <div class="card card-min">
                            <div class="card-body row">
                                <div class="col-md-12 col-sm-12 text-center  center">
                                    <h1 v-if="totalWeekTransactions">{{ total_sales_week }} PHP</h1>
                                    <div v-else class="fa-3x">
                                      <i class="fas fa-spinner fa-pulse"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-center">
                                <strong>
                                    This Week's Total Sales
                                </strong>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-12">
                        <div class="card card-min">
                            <div class="card-body row">
                                <div class="col-md-12 col-sm-12 text-center  center">
                                    <h1 v-if="totalMonthTransactions">{{ total_sales_month }} PHP</h1>
                                    <div v-else class="fa-3x">
                                      <i class="fas fa-spinner fa-pulse"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-center">
                                <strong>
                                    This Month's Total Sales
                                </strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="total_sales_month != 0" class="mt-5">
          <h1 class="text-center">{{ currentMonth }} Sales</h1>
          <br>
          <div class="container">
            <line-chart v-if="chartdata.labels" :chartData="chartdata"  :height="200"/>
          </div>
        </div>
    </div>
</template>

<script>
    export default {
      data() {
          return {
            totalTransactions: null,
            totalWeekTransactions: null,
            totalMonthTransactions: null,

            currentMonth: '',
            dates: null,
            filteredDates: null,
            startDates: [],
            chartDataset: [],

            loaded: true
          };
      },

      mounted() {
        let promise = new Promise((resolve, reject) => {
          //Get All Transactions Today
          this.getFilteredTransactionList(this.getCurrentDateStart(), this.getCurrentDateEnd(), 'today');

          //Get All Transactions This Week
          this.getFilteredTransactionList(this.getWeekStartDate(), this.getCurrentDateEnd(), 'week');

          //Get All Transactions This Month
          this.getFilteredTransactionList(this.getMonthStartDate(), this.getCurrentDateEnd(), 'month');
        });
      },

      computed:{
        chartdata: function() {
          return {
            labels: this.filteredDates,
            datasets: [
              {
                label: 'Sales For This Day',
                backgroundColor: '#03254c',
                data: this.chartDataset
              }
            ]
          }
        },

        total_sales_today: function () {
          if (this.totalTransactions){
            return this.totalTransactions.reduce((totalAmount, transaction_item) => {
              return totalAmount += parseFloat(transaction_item.grand_total_amount);
            }, 0);
          }
          return 0;
        },

        total_sales_week: function () {
          if (this.totalWeekTransactions){
            return this.totalWeekTransactions.reduce((totalAmount, transaction_item) => {
                    return totalAmount += parseFloat(transaction_item.grand_total_amount);
            }, 0);
          }
          return 0;
        },

        total_sales_month: function () {
          if (this.totalMonthTransactions){
            return this.totalMonthTransactions.reduce((totalAmount, transaction_item) => {
                    return totalAmount += parseFloat(transaction_item.grand_total_amount);
            }, 0);
          }
          return 0;
        },
      },

      methods:{
        getFilteredTransactionList(start, end, span){
          var data = {
            startDate: start,
            endDate: end
          }
          axios.post('/api/transactions/get-total-transactions', data ).then(res => {
              switch(span){
                case 'today':
                  this.totalTransactions = res.data.transaction;
                  break;
                case 'week':
                  this.totalWeekTransactions = res.data.transaction;
                  break;
                case 'month':
                  this.totalMonthTransactions = res.data.transaction;
                  this.generateMonthlyStatistics();
                  break;
              }
              
              resolve();
          }).catch(err => {
              return err;
          });
        },

        getCurrentDateStart(){
          return this.formatDate(new Date(), true);
        },

        getWeekStartDate() {
          var d = new Date();
          var day = d.getDay(),
          diff = d.getDate() - day + (day == 0 ? -6:1); // adjust when day is sunday

          var date = new Date(d.setDate(diff))
          var userTimezoneOffset = date.getTimezoneOffset() * 60000;
          var x = new Date(date.getTime() - userTimezoneOffset);
          var firstDay = new Date(x.toDateString())

          return this.formatDate(firstDay, true)
        },

        getMonthStartDate(){
          var date = new Date();
          var firstDay = new Date(date.getFullYear(), date.getMonth(), 1);

          return this.formatDate(firstDay, true)
        },

        getCurrentDateEnd(){
          var tzoffset = (new Date()).getTimezoneOffset() * 60000; //offset in milliseconds
          var localISOTime = (new Date(Date.now() - tzoffset)).toISOString().slice(0, -1);

          return localISOTime;
        },

        formatDate(date, isIso){
          var today = date;
          var dd = today.getDate();
          var mm = today.getMonth()+1;
          var yyyy = today.getFullYear();

          if(dd<10) dd='0'+dd;
          if(mm<10) mm='0'+mm;

          if(isIso){
            return (yyyy+'-'+mm+'-'+dd+'T00:00:00');
          }
          return (yyyy+'-'+mm+'-'+dd);
        },

        generateMonthlyStatistics(){
          const monthNames = ["January", "February", "March", "April", "May", "June",
                  "July", "August", "September", "October", "November", "December"
                ];
                
          var monthTransaction = this.totalMonthTransactions;

          this.dates = monthTransaction.map(function (e) {
            return new Date(e.created_at);
          });

          for (var i = 0; i < this.dates.length; i++) {
            this.dates[i] = this.formatDate(this.dates[i], false)
          }

          this.filteredDates = this.dates.filter((item, index) => {
            return this.dates.indexOf(item) === index;
          })

          for (var i = 0; i < this.filteredDates.length; i++) {
            this.startDates[i] = this.formatDate(new Date(this.filteredDates[i]), false)
            this.chartDataset[i] = monthTransaction.filter(({created_at}) => this.formatDate(new Date(created_at), false) == this.startDates[i])
                                                   .reduce((sum, transaction_item) => {
                                                     return sum += parseFloat(transaction_item.grand_total_amount);
                                                    }, 0);
          }   
          this.currentMonth = monthNames[new Date(this.dates[0]).getMonth()];
        }
      },
    }
</script>
