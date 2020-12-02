import { ApolloClient } from 'apollo-client';
import { InMemoryCache } from 'apollo-cache-inmemory';
import { ApolloLink } from 'apollo-link';
import { createUploadLink } from 'apollo-upload-client'

import ErrorHandler from './error-handler';

const client = new ApolloClient({
    link: ApolloLink.from([
        ErrorHandler,
        createUploadLink({
            uri: '/graphql',
            credentials: 'same-origin',
            headers: {
                'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest'
            }
        }),
    ]),
    defaultOptions: {
        watchQuery: {
            fetchPolicy: 'network-only'
        },
    },
    cache: new InMemoryCache()
});

export default client;
