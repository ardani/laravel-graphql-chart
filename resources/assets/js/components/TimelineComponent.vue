<template>
    <highcharts :constructor-type="'chart'" :options="chartOptions" :updateArgs="updateArgs"></highcharts>
</template>
<script>
  import gql from 'graphql-tag'
  import moment from 'moment'
  import _ from 'lodash'

  export default {
    name: 'timelines',
    apollo: {
      facebook: {
        query: gql`query fetchTimelines($start_at: String!, $end_at: String!) {
              facebook: timelines(type: 1, start_at: $start_at, end_at: $end_at) {
                id
                count: feed_count
                date
              }
            }
            `,
        variables: {
          start_at: moment().format('YYYY-M-1'),
          end_at: moment().endOf('month').format('YYYY-M-D')
          ,
        },
      },
      twitter: {
        query: gql`query fetchTimelines($start_at: String!, $end_at: String!) {
              twitter: timelines(type: 2, start_at: $start_at, end_at: $end_at) {
                id
                count: feed_count
                date
              }
            }
            `,
        variables: {
          start_at: moment().format('YYYY-M-1'),
          end_at: moment().endOf('month').format('YYYY-M-D')
          ,
        },
      },
      retweet: {
        query: gql`query fetchTimelines($start_at: String!, $end_at: String!) {
              retweet: timelines(type: 2, start_at: $start_at, end_at: $end_at) {
                id
                count: feed_retweet_count
                date
              }
            }
            `,
        variables: {
          start_at: moment().format('YYYY-M-1'),
          end_at: moment().endOf('month').format('YYYY-M-D')
          ,
        },
      }
    },
    created: function () {
      let last = moment().daysInMonth();
      const days = [];
      let i;
      for (i = 1; i <= last; i++) {
        if (i < 10) {
          days.push(`0${i}`)
        }else {
          days.push(`${i}`)
        }
      }
      this.chartOptions.xAxis.categories = days
    },
    watch: {
      facebook: function (vals) {
        const count = this.filterData(vals);
        this.chartOptions.series.push({
          name: 'facebook',
          data: count
        })
      },
      twitter: function (vals) {
        const count = this.filterData(vals);
        this.chartOptions.series.push({
          name: 'twitter',
          data: count
        })
      },
      retweet: function (vals) {
        const count = this.filterData(vals);
        this.chartOptions.series.push({
          name: 'retweet',
          data: count
        })
      }
    },
    data: () => ({
      updateArgs: [true, true, {duration: 1000}],
      facebook: null,
      twitter: null,
      retweet: null,
      chartOptions: {
        title: {
          text: 'Facebook Twitter Metrics'
        },
        chart: {
          type: 'line'
        },
        xAxis: {
          categories: [],
          scrollbar: {
            enabled: true
          },
        },
        yAxis: {
          title: {
            text: 'count'
          }
        },
        plotOptions: {
          line: {
            dataLabels: {
              enabled: true
            },
            enableMouseTracking: false
          }
        },
        series: []
      }
    }),
    methods: {
      filterData: (vals) => {
        let last = moment().daysInMonth();
        const count = [];
        let i;
        for (i = 1; i <= last; i++) {
          const date = moment().format(`YYYY-MM-${i}`);
          let index = _.findIndex(vals, { 'date': date});
          if (index >= 0) {
            count.push(vals[index].count)
          } else {
            count.push(0)
          }
        }
        return count
      }
    }
  }
</script>