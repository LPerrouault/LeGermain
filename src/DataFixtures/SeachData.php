<?php

namespace App\DataFixtures;

use App\Entity\tag;

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
     * @var tag[]
     */
    public $tags = [];

}