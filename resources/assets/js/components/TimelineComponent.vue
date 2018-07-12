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
               twitter: timelines(type: 2, start_at: $start_at, end_at: $end_at) {
                id
                count: feed_count
                date
              }
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
        },
        update({facebook, twitter, retweet}) {
          return this.timelines = {facebook, twitter, retweet}
        }
      },
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
      timelines: function ({facebook, twitter, retweet}) {
        let count = this.filterData(facebook);
        this.chartOptions.series.push({
          name: 'facebook',
          data: count
        });

        count = this.filterData(twitter);
        this.chartOptions.series.push({
          name: 'twitter',
          data: count
        });

        count = this.filterData(retweet);
        this.chartOptions.series.push({
          name: 'retweet',
          data: count
        });
      },
    },
    data: () => ({
      updateArgs: [true, true, {duration: 1000}],
      timelines: {
        facebook: null,
        twitter: null,
        retweet: null
      },
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