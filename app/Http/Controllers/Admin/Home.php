<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\TransactionModel;

use Carbon\Carbon;

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
    if ($this->data['auth_data']['temp_password']) {
      // Create a Carbon instance for your specific date (Date 1)
      $expiredAt = Carbon::parse($this->data['auth_data']['temp_password_expired_at']);
  
      // Get the current date and time
      $now = Carbon::now();

      // Calculate the difference in days
      $this->data['intervalInDays'] = $expiredAt->diffInDays($now);
    }

    return view('admin/home.v_index', $this->data);
  }
}
