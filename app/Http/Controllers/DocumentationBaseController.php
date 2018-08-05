<?php

namespace App\Http\Controllers;

use App\Documentation;
use App\Http\Controllers\Controller as BaseController;

class DocumentationBaseController extends BaseController
{
    /**
     * The documentation repository.
     *
     * @var Documentation
     */
    protected $documentation;

    /**
     * Create a new controller instance.
     *
     * @param  Documentation  $docs
     * @return void
     */
    public function __construct(Documentation $documentation)
    {
        $this->documentation = $documentation;
    }
}
