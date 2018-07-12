<template>
    <b-table striped hover :items="feeds.data" :fields="fields"></b-table>
</template>
<script>
  import gql from 'graphql-tag'
  export default {
    name: 'Feed',
    apollo: {
      // Simple query that will update the 'hello' vue property
      feeds: {
        query: gql`query fetchFeeds($limit: Int!, $page: Int!) {
            feeds(limit: $limit, page: $page) {
               data {
                  id,
                  message_formatted,
                  message,
                  type,
                  retweet,
                  social,
                  parent_id,
                  user {
                    name
                  }
                },
                current_page,
                total
              }
            }`,
        variables: {
            limit: 100,
            page: 1,
        },
      }
    },
    data: () => ({
      fields: [
        {
          key: 'message_formatted',
          sortable: false,
          label: 'Message'
        },
        {
          key: 'social',
          sortable: false,
          label: 'Social'
        },
        {
          key: 'retweet',
          sortable: false,
          label: 'Retweet'
        },
        {
          key: 'user.name',
          sortable: false,
          label: 'Name'
        },
      ],
      feeds: [],
      limit: 10,
      page: 1
    })
  }
</script>