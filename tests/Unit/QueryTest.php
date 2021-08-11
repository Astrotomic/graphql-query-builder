<?php

use Astrotomic\GraphqlQueryBuilder\Query;

it('returns query from resource')
    ->expect(Query::from('viewer'))
    ->toBeStringable()
    ->toMatchSnapshot();

it('returns query from resource with selected field')
    ->expect(Query::from('sponsorEntity')->select('__typename'))
    ->toBeStringable()
    ->toMatchSnapshot();

it('returns query from resource with selected field and fragment')
    ->expect(Query::from('sponsorEntity')->select(
        '__typename',
        Query::for('User')->select('login', 'name', 'databaseId'),
    ))
    ->toBeStringable()
    ->toMatchSnapshot();

it('returns query from resource with sub resource')
    ->expect(Query::from('nodes')->select(
        Query::from('sponsorEntity')->select('__typename')
    ))
    ->toBeStringable()
    ->toMatchSnapshot();