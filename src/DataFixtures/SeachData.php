<?php

namespace App\DataFixtures;

use App\Entity\Tag;

class SeachData
{
    /**
     * @var int
     */
    public $page =1;

    /**
     * @var string
     */
    public $q = '';

    /**
     * @var Tag[]
     */
    public $tags = [];

}