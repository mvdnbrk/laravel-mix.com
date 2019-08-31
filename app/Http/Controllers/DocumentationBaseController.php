<?php

namespace App\Http\Controllers;

use App\Documentation;

class DocumentationBaseController
{
    /**
     * The documentation repository.
     *
     * @var \App\Documentation
     */
    protected $documentation;

    /**
     * Create a new controller instance.
     *
     * @param  \App\Documentation  $documentation
     * @return void
     */
    public function __construct(Documentation $documentation)
    {
        $this->documentation = $documentation;
    }
}
