<script>
import { Line, mixins } from 'vue-chartjs'
import VueCharts from 'vue-chartjs'

export default {
  mixins: [mixins.reactiveProp],
  extends: Line,
  props: {
    chartData: {
      type: Object,
      required: false,
      default: null
    },
    options: {
      type: Object,
      required: false,
      default:() =>  ({
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
      })
    },
  },
  mounted () {
    this.renderChart(this.chartData, this.options)
  },

  watch: {
    chartData: function() {
      this.$data._chart.destroy()
      this.renderChart(this.chartData, this.options)
    }
  }
}
</script>