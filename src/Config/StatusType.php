<?php

namespace App\Config;

enum StatusType: string
{
    case draft = 'draft';
    case published = 'published';
}