<?php

namespace App\Query;

abstract class BaseQueryFactory
{
    protected const DBAL = 'dbal';
    protected const HTTP = 'http';
    protected const AMQP = 'amqp';
}
