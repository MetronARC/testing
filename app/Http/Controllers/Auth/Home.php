<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\TransactionModel;

/**
 * Controller
 * 
 * @author Saka Mahendra Arioka
 *         saka@sakarioka.com
 *         +6285338845666
 */
class Home extends Controller {

  public function __construct()
  {
    parent::__construct();
    
    $this->data['title'] = 'Dashboard';
  }

  // method index (default)
  public function index(Request $request)
  {
    return redirect()->route('loginIndex');
  }
}
