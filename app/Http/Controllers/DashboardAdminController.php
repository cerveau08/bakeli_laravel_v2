<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class DashboardAdminController extends AppBaseController
{
    /**
     * Dashboard admin
     */
    public function indexDashboard(){
        return view('admin-dashboard.index');
    }

}