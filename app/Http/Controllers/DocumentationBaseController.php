<?php

namespace App\Http\Controllers;

use Mvdnbrk\Documentation\Documentation;

class DocumentationBaseController
{
    protected Documentation $documentation;

    public function __construct(Documentation $documentation)
    {
        $this->documentation = $documentation;
    }
}
