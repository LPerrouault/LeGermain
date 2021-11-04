<?php

namespace App\Service;
use App\Entity\tag;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormTypeInterface;

class SearchData
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