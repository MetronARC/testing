<?php

use Illuminate\Support\Facades\Route;

$host = request()->getHost();
$port = request()->getPort();

$userControllerPath   = 'App\Http\Controllers\User';
$adminControllerPath  = 'App\Http\Controllers\Admin';
$vendorControllerPath = 'App\Http\Controllers\Vendor';
$authControllerPath   = 'App\Http\Controllers\Auth';

if ($host == env('DOMAIN_ADMIN') || (env('APP_ENV') != 'production' && $port == 8001)) {
  adminRoute($adminControllerPath);
} elseif ($host == env('DOMAIN_VENDOR') || (env('APP_ENV') != 'production' && $port == 8002)) {
  vendorRoute($vendorControllerPath);
} elseif ($host == env('DOMAIN_AUTH') || (env('APP_ENV') != 'production' && $port == 8003)) {
  authRoute($authControllerPath);
} else {
  userRoute($userControllerPath);
}

function userRoute($userControllerPath)
{
  // default route
  Route::any('/', $userControllerPath . '\Home@index')->name('homeIndex');

  // search route
  Route::group(['prefix' => 'search', 'as' => 'search.'], function ()  use ($userControllerPath) {
    Route::any('/', $userControllerPath . '\Search@index')->name('searchIndex');
  });

  // shipyard route
  Route::group(['prefix' => 'shipyard', 'as' => 'shipyard.'], function ()  use ($userControllerPath) {
    Route::any('/', $userControllerPath . '\Shipyard@index')->name('shipyardIndex');
    Route::any('/datatable', $userControllerPath . '\Shipyard@datatable')->name('shipyardDatatable');
    Route::any('/contact/{id?}', $userControllerPath . '\Shipyard@contact')->name('shipyardContact');
    Route::any('/pdf/{id?}', $userControllerPath . '\Shipyard@pdf')->name('shipyardPdf');
    Route::any('/{id?}/{slug?}', $userControllerPath . '\Shipyard@detail')->name('shipyardDetail');
  });

  // tender route
  Route::group(['prefix' => 'tender', 'as' => 'tender.'], function ()  use ($userControllerPath) {
    Route::any('/', $userControllerPath . '\Tender@index')->name('tenderIndex');
    Route::any('/datatable', $userControllerPath . '\Tender@datatable')->name('tenderDatatable');
    Route::any('/contact/{id?}', $userControllerPath . '\Tender@contact')->name('tenderContact');
    Route::any('/{id?}/{tenderNumber?}', $userControllerPath . '\Tender@detail')->name('tenderDetail');
  });

  // job route
  Route::group(['prefix' => 'job-vacancy', 'as' => 'job.'], function ()  use ($userControllerPath) {
    Route::any('/', $userControllerPath . '\Job@index')->name('jobIndex');
    Route::any('/datatable', $userControllerPath . '\Job@datatable')->name('jobDatatable');
    Route::any('/{id?}/{slug?}', $userControllerPath . '\Job@detail')->name('jobDetail');
  });

  // vendor route
  Route::group(['prefix' => 'marine-vendor', 'as' => 'vendor.'], function ()  use ($userControllerPath) {
    Route::any('/', $userControllerPath . '\Vendor@index')->name('vendorIndex');
    Route::any('/datatable', $userControllerPath . '\Vendor@datatable')->name('vendorDatatable');
    Route::any('/{id?}/{slug?}', $userControllerPath . '\Vendor@detail')->name('vendorDetail');
  });

  // service route
  Route::group(['prefix' => 'service', 'as' => 'service.'], function ()  use ($userControllerPath) {
    Route::any('/', $userControllerPath . '\Service@index')->name('serviceIndex');
  });

  // sale route
  Route::group(['prefix' => 'for-sale', 'as' => 'sale.'], function ()  use ($userControllerPath) {
    Route::any('/', $userControllerPath . '\ForSale@index')->name('saleIndex');
  });

  // news route
  Route::group(['prefix' => 'news', 'as' => 'news.'], function ()  use ($userControllerPath) {
    Route::any('/', $userControllerPath . '\News@index')->name('newsIndex');
  });

  Route::group(['prefix' => 'read', 'as' => 'read.'], function ()  use ($userControllerPath) {
    Route::any('/{year}/{month}/{date}/{id}/{slug}', $userControllerPath . '\News@detail')->name('newsDetail');
  });

  // cronmail route
  Route::group(['prefix' => 'cron-mail', 'as' => 'cronmail.'], function ()  use ($userControllerPath) {
    Route::any('/pending-registration', $userControllerPath . '\CronMail@pendingRegistration')->name('pendingRegistration');
    Route::any('/temporary-password', $userControllerPath . '\CronMail@temporaryPassword')->name('temporaryPassword');
    Route::any('/rfq', $userControllerPath . '\CronMail@rfq')->name('rfq');
  });
}

function adminRoute($adminControllerPath)
{
  // home page
  Route::any('/', $adminControllerPath . '\Home@index')->name('homeIndex');

  // faq page
  Route::group(['prefix' => 'faq', 'as' => 'faq.'], function ()  use ($adminControllerPath) {
    Route::any('/', $adminControllerPath . '\Faq@index')->name('faqIndex');
    Route::any('/add', $adminControllerPath . '\Faq@add')->name('faqAdd');
    Route::any('/detail/{faq_id}', $adminControllerPath . '\Faq@detail')->name('faqDetail');
    Route::any('/delete/{faq_id}', $adminControllerPath . '\Faq@delete')->name('faqDelete');
    Route::any('/move/{faq_id}/{order}', $adminControllerPath . '\Faq@move')->name('faqMove');
  });

  // term page
  Route::group(['prefix' => 'term', 'as' => 'term.'], function ()  use ($adminControllerPath) {
    Route::any('/', $adminControllerPath . '\TermCondition@index')->name('termIndex');
    Route::any('/add', $adminControllerPath . '\TermCondition@add')->name('termAdd');
    Route::any('/detail/{id}', $adminControllerPath . '\TermCondition@detail')->name('termDetail');
    Route::any('/delete/{id}', $adminControllerPath . '\TermCondition@delete')->name('termDelete');
    Route::any('/move/{id}/{order}', $adminControllerPath . '\TermCondition@move')->name('termMove');
  });

  // privacy page
  Route::group(['prefix' => 'privacy', 'as' => 'privacy.'], function ()  use ($adminControllerPath) {
    Route::any('/', $adminControllerPath . '\PrivacyPolicy@index')->name('privacyIndex');
    Route::any('/add', $adminControllerPath . '\PrivacyPolicy@add')->name('privacyAdd');
    Route::any('/detail/{id}', $adminControllerPath . '\PrivacyPolicy@detail')->name('privacyDetail');
    Route::any('/delete/{id}', $adminControllerPath . '\PrivacyPolicy@delete')->name('privacyDelete');
    Route::any('/move/{id}/{order}', $adminControllerPath . '\PrivacyPolicy@move')->name('privacyMove');
  });

  // Route::group(['prefix' => 'dashboard', 'as' => 'dashboard.'], function ()  use ($adminControllerPath) {
  //   Route::any('/', $adminControllerPath.'\Dashboard@index')->name('dashboardIndex');
  // });

  Route::group(['prefix' => 'email', 'as' => 'email.'], function ()  use ($adminControllerPath) {
    Route::any('/', $adminControllerPath . '\Email@index')->name('emailIndex');
  });

  Route::group(['prefix' => 'user', 'as' => 'user.'], function ()  use ($adminControllerPath) {
    Route::any('/', $adminControllerPath . '\User@index')->name('userIndex');
    Route::any('/detail/{id?}', $adminControllerPath . '\User@detail')->name('userDetail');
    Route::any('/datatable', $adminControllerPath . '\User@datatable')->name('userDatatable');
    Route::any('/verify', $adminControllerPath . '\User@verify')->name('userVerify');
    Route::any('/change-password', $adminControllerPath . '\User@changePassword')->name('userChangePassword');
  });

  Route::group(['prefix' => 'shipyard', 'as' => 'shipyard.'], function ()  use ($adminControllerPath) {
    Route::any('/', $adminControllerPath . '\Shipyard@index')->name('shipyardIndex');
    Route::any('/add', $adminControllerPath . '\Shipyard@add')->name('shipyardAdd');
    Route::any('/detail/{id?}', $adminControllerPath . '\Shipyard@detail')->name('shipyardDetail');
    Route::any('/delete/{id?}', $adminControllerPath . '\Shipyard@delete')->name('shipyardDelete');
    Route::any('/datatable', $adminControllerPath . '\Shipyard@datatable')->name('shipyardDatatable');
  });

  Route::group(['prefix' => 'vd', 'as' => 'vendor.'], function ()  use ($adminControllerPath) {
    Route::any('/', $adminControllerPath . '\Vendor@index')->name('vendorIndex');
    Route::any('/add', $adminControllerPath . '\Vendor@add')->name('vendorAdd');
    Route::any('/detail/{id?}', $adminControllerPath . '\Vendor@detail')->name('vendorDetail');
    Route::any('/delete/{id?}', $adminControllerPath . '\Vendor@delete')->name('vendorDelete');
    Route::any('/datatable', $adminControllerPath . '\Vendor@datatable')->name('vendorDatatable');
  });

  Route::group(['prefix' => 'ship', 'as' => 'ship.'], function ()  use ($adminControllerPath) {
    Route::any('/', $adminControllerPath . '\Ship@index')->name('shipIndex');
  });

  Route::group(['prefix' => 'tender', 'as' => 'tender.'], function ()  use ($adminControllerPath) {
    Route::any('/', $adminControllerPath . '\Tender@index')->name('tenderIndex');
    Route::any('/add', $adminControllerPath . '\Tender@add')->name('tenderAdd');
    Route::any('/detail/{id?}', $adminControllerPath . '\Tender@detail')->name('tenderDetail');
    Route::any('/delete/{id?}', $adminControllerPath . '\Tender@delete')->name('tenderDelete');
    Route::any('/datatable', $adminControllerPath . '\Tender@datatable')->name('tenderDatatable');
  });

  Route::group(['prefix' => 'job', 'as' => 'job.'], function ()  use ($adminControllerPath) {
    Route::any('/', $adminControllerPath . '\Job@index')->name('jobIndex');
    Route::any('/add', $adminControllerPath . '\Job@add')->name('jobAdd');
    Route::any('/detail/{id?}', $adminControllerPath . '\Job@detail')->name('jobDetail');
    Route::any('/delete/{id?}', $adminControllerPath . '\Job@delete')->name('jobDelete');
    Route::any('/datatable', $adminControllerPath . '\Job@datatable')->name('jobDatatable');
  });

  Route::group(['prefix' => 'service', 'as' => 'service.'], function ()  use ($adminControllerPath) {
    Route::any('/', $adminControllerPath . '\Service@index')->name('serviceIndex');
  });

  Route::group(['prefix' => 'sale', 'as' => 'sale.'], function ()  use ($adminControllerPath) {
    Route::any('/', $adminControllerPath . '\ForSale@index')->name('saleIndex');
  });

  Route::group(['prefix' => 'news', 'as' => 'news.'], function ()  use ($adminControllerPath) {
    Route::any('/', $adminControllerPath . '\News@index')->name('newsIndex');
    Route::any('/add', $adminControllerPath . '\News@add')->name('newsAdd');
    Route::any('/detail/{id?}', $adminControllerPath . '\News@detail')->name('newsDetail');
    Route::any('/delete/{id?}', $adminControllerPath . '\News@delete')->name('newsDelete');
    Route::any('/datatable', $adminControllerPath . '\News@datatable')->name('newsDatatable');
  });

  Route::group(['prefix' => 'archive', 'as' => 'archive.'], function ()  use ($adminControllerPath) {
    Route::any('/', $adminControllerPath . '\Archive@index')->name('archiveIndex');
  });

  Route::group(['prefix' => 'log', 'as' => 'log.'], function ()  use ($adminControllerPath) {
    Route::any('/', $adminControllerPath . '\Log@index')->name('logIndex');
  });
}

function vendorRoute($vendorControllerPath)
{
}

function authRoute($authControllerPath)
{
  // home page
  Route::any('/', $authControllerPath . '\Home@index')->name('homeIndex');

  // authentication page
  Route::any('/login', $authControllerPath . '\Login@index')->name('loginIndex');
  Route::any('/logout', $authControllerPath . '\Logout@index')->name('logoutIndex');
  Route::any('/register', $authControllerPath . '\Register@index')->name('registerIndex');
  Route::any('/register/{category}/{type}', $authControllerPath . '\Register@category')->name('registerCategory');
  Route::any('/register/finish', $authControllerPath . '\Register@finish')->name('registerFinish');
}
