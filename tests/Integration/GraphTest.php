<?php

use Astrotomic\GraphqlQueryBuilder\Graph;
use Astrotomic\GraphqlQueryBuilder\Query;

test('GitHub Sponsors query')
    ->expect(Graph::query(
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
    ))
    ->toBeStringable()
    ->toMatchSnapshot();