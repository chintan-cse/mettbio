<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@index', function () {
    return view('home');
})->middleware('auth');
Auth::routes();


Route::group(['middleware' => ['auth','check.permission']], function () {
	//Route::group(['middleware' => 'auth'], function () {
	Route::get('/home', 'HomeController@index')->name('home');


	Route::get('/profile', 'ProfileController@index')->name('profile');
	Route::resource('/users','UserController');
	Route::resource('/company', 'CompanyController');
	Route::resource('/role','RoleController');

	//master controller
	Route::resource('/testtype','TestTypeController');

	//sample controller
	Route::get('/sample/getmethods','SampleController@gettypemethods')->name('sample.gettypemethods');
	Route::get('/sample/getsubmethods','SampleController@gettypesubmethods')->name('sample.gettypesubmethods');
	Route::resource('/sample','SampleController');


	//sampleAssignment controller
	Route::get('/sampleassignment','SampleAssignmentController@index')->name('sampleassignment.index');
	Route::post('/sampleassignment/changeto','SampleAssignmentController@sampleassignto')->name('sampleassignment.change');

	//Row PDF Generation controller
	Route::get('/rowpdfgenerate','RowDataPdfController@index')->name('rowpdfgenerate.index');
	Route::post('/rowpdfgenerate/print','RowDataPdfController@rowpdfprint')->name('rowpdfgenerate.print');
	
	
	//Test Certification Controller
	Route::get('/testcertification','TestCertificationController@index')->name('testcertification.index');
	Route::post('/testcertification/generatetest','TestCertificationController@generatetest')->name('testcertification.generatetest');
	Route::get('/testcertification/afterselectsample','TestCertificationController@afterselectsample')->name('testcertification.afterselectsample');
	Route::post('/testcertification/testdataentry','TestCertificationController@testdataentry')->name('testcertification.testdataentry');
	
	//Review Sample controller
	Route::resource('/reviewsample','ReviewSampleController');
	Route::post('/reviewsample/finalised','ReviewSampleController@finalised')->name('reviewsample.finalised');


	Route::post('permission', 'RoleController@permission')->name('role.permission');
	Route::get('/role/{id}/editrole', 'RoleController@editrole')->name('role.editrole');
	Route::get('getrolebycompanyid', 'RoleController@getrolesfromcompanyid')->name('getrolebycompanyid');

	//mass delete
	Route::get('ajaxdata/massuserdelete', 'AjaxdataController@massuserdelete')->name('ajaxdata.massuserdelete');
	Route::get('ajaxdata/massglassdelete', 'AjaxdataController@massglassdelete')->name('ajaxdata.massglassdelete');
	Route::get('ajaxdata/massfinishdelete', 'AjaxdataController@massfinishdelete')->name('ajaxdata.massfinishdelete');
	Route::get('ajaxdata/masshandledelete', 'AjaxdataController@masshandledelete')->name('ajaxdata.masshandledelete');
	Route::get('ajaxdata/masstemplatedelete', 'AjaxdataController@masstemplatedelete')->name('ajaxdata.masstemplatedelete');
	Route::get('ajaxdata/massitemsdelete', 'AjaxdataController@massitemsdelete')->name('ajaxdata.massitemdelete');
	Route::get('ajaxdata/masshardwarecategorydelete', 'AjaxdataController@masshardwarecategorydelete')->name('ajaxdata.masshardwarecategorydelete');
	Route::get('ajaxdata/massmiterdelete', 'AjaxdataController@massmiterdelete')->name('ajaxdata.massmiterdelete');
	Route::get('ajaxdata/massroledelete', 'AjaxdataController@massroledelete')->name('ajaxdata.massroledelete');
	Route::get('ajaxdata/masscompanydelete', 'AjaxdataController@masscompanydelete')->name('ajaxdata.masscompanydelete');
	Route::get('ajaxdata/masstesttypedelete', 'AjaxdataController@masstesttypedelete')->name('ajaxdata.masstesttypedelete');
	Route::get('ajaxdata/masssampledelete', 'AjaxdataController@masssampledelete')->name('ajaxdata.masssampledelete');
	Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout'); 
});