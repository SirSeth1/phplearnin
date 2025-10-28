<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['abouts'] = 'Welcome/demo';

$route['home'] = 'PageController/index';

//************************************************* */

$route['employee'] = 'frontend/EmployeeController/index';
$route['employee/add'] = 'frontend/EmployeeController/create';
$route['employee/store'] = 'frontend/EmployeeController/store';
$route['employee/edit/(:any)'] = 'frontend/EmployeeController/edit/$1';
$route['employee/update/(:any)'] = 'frontend/EmployeeController/update/$1';
$route['employee/delete/(:any)'] = 'frontend/EmployeeController/delete/$1';
$route['employee/confirm_delete/(:any)'] = 'frontend/EmployeeController/confirm_delete/$1';
//************************************************* */

$route['register']['GET']='Auth/RegisterController/index';
$route['register']['POST']='Auth/RegisterController/register';
$route['login']['GET']='Auth/LoginController/index';
$route['login']['POST']='Auth/LoginController/login';

$route['image_uploader'] = 'MainController/image_upload';
$route['ajax_upload'] = 'MainController/ajax_upload';
$route['multiple_image_upload'] = 'MultipleController/index';
$route['multiple_ajax_upload'] = 'MultipleImageController/ajax_upload';


// Default route (equivalent to /)
$route['default_controller'] = 'Shop/index';

// Shop page (explicitly)
$route['shop']['GET'] = 'Shop/index';

// Cart page
$route['cart']['GET'] = 'Cart/index';

// AJAX API routes
$route['cart/add']['POST'] = 'Cart/add';
$route['cart/update']['POST'] = 'Cart/update';
$route['cart/remove']['POST'] = 'Cart/remove';

$route['products/ajax_list']['GET'] = 'myprojectcontrollers/ProductController/ajax_list';
$route['cart/add']['POST'] = 'myprojectcontrollers/CartController/add';
$route['cart/view']['GET'] = 'myprojectcontrollers/CartController/view';
$route['cart/update']['POST'] = 'myprojectcontrollers/CartController/update';
$route['cart/remove']['POST'] = 'myprojectcontrollers/CartController/remove';   
$route['cart/clear']['POST'] = 'myprojectcontrollers/CartController/clear';
$route['cart/count']['GET'] = 'myprojectcontrollers/CartController/count';

// Shop page (where users see products)

$route['shop2']['GET'] = 'myprojectcontrollers/ShopController/index';

// Admin page (where admin adds new products)
$route['admin/add-product'] = 'myprojectcontrollers/AdminController/add_product';

$route['shop/fetch-products'] = 'ShopController/fetch_products';

$route['shop/add-to-cart'] = 'ShopController/add_to_cart';
$route['myauth/login']['GET'] = 'myprojectcontrollers/Auth/LoginController/login';
$route['myauth/logout']['GET'] = 'myprojectcontrollers/Auth/LogoutController/logout';




// $route['register']['GET']='Auth/RegisterController/index';
// $route['register']['POST']='Auth/RegisterController/register';

// $route['login']['GET']='Auth/LoginController/index';
// $route['login']['POST']='Auth/LoginController/login';

// $route['userpage']['GET']='UserController/index';
// $route['adminpage']['GET']='AdminController/index';