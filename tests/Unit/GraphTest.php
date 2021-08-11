<?php

use Astrotomic\GraphqlQueryBuilder\Graph;
use Astrotomic\GraphqlQueryBuilder\Query;

it('returns empty graph')
    ->expect(Graph::query())
    ->toBeStringable()
    ->toMatchSnapshot();

it('returns graph with one query')
    ->expect(Graph::query(
        Query::from('user')
    ))
    ->toBeStringable()
    ->toMatchSnapshot();

it('returns graph with multiple queries')
    ->expect(Graph::query(
        Query::from('viewer'),
        Query::from('user')->with(['login' => 'Gummibeer'])
    ))
    ->toBeStringable()
    ->toMatchSnapshot();
