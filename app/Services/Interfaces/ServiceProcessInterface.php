<?php

namespace App\Services\Interfaces;

use Illuminate\Http\Request;

interface ServiceProcessInterface
{
    public function process(Request $request);
}
