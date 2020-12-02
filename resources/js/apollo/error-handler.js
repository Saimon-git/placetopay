import { onError } from "apollo-link-error";

const errorHandler = onError(({ graphQLErrors, networkError }) => {
    if (graphQLErrors)
        graphQLErrors.forEach( ( err ) => {
            switch ( err.extensions.category ) {
            case 'authentication':
                window.location.href = '/login';
                break;

            case 'validation':
                if(err.extensions.validation) {
                    console.log(err.extensions.validation);
                }

                if(err.extensions.errors) {
                    console.log(err.extensions.errors);
                }
                break;

            default:
          console.log( `[GraphQL error]: ${err}` ); // eslint-disable-line
            }
        } );

    if (networkError) console.log(`[Network error]: ${networkError}`);
});

export default errorHandler;
