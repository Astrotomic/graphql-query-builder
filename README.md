# GraphQL Query Builder

This package is an opinionated GraphQL Query Builder not fully compatible with all GraphQL specs (yet).
In case you miss a feature you can open an issue so we can discuss a solution.

## Installation

```bash
composer require astrotomic/graphql-query-builder
```

## Usage

```php
use Astrotomic\GraphqlQueryBuilder\Graph;
use Astrotomic\GraphqlQueryBuilder\Query;

Graph::query(
    Query::from('user')
        ->with(['login' => 'Gummibeer'])
        ->select(
            Query::from('sponsorshipsAsMaintainer')
                ->with(['first' => 100, 'after' => 'ABC'])
                ->select(
                    Query::from('pageInfo')->select('hasNextPage', 'endCursor'),
                    Query::from('nodes')->select(
                        Query::from('sponsorEntity')->select(
                            '__typename',
                            Query::for('User')->select('login', 'avatarUrl', 'databaseId', 'name'),
                            Query::for('Organization')->select('login', 'avatarUrl', 'databaseId', 'name'),
                        )
                    )
                )
        )
)
```

```graphql
query {
  user(login: "Gummibeer") {
    sponsorshipsAsMaintainer(first: 100, after: "ABC") {
      pageInfo {
        hasNextPage
        endCursor
      }
      nodes {
        sponsorEntity {
          __typename
          ... on User {
            login
            avatarUrl
            databaseId
            name
          }
          ... on Organization {
            login
            avatarUrl
            databaseId
            name
          }
        }
      }
    }
  }
}
```