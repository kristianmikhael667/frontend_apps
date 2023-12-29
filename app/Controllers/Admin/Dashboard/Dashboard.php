<?php

namespace App\Controllers\Admin\Dashboard;

use App\Controllers\Base\BaseController;

class Dashboard extends BaseController
{
    public function index()
    {
        $data = array();
        $data['title'] = "Dashboard";
        return view('dashboard/index', $data);
    }
}
