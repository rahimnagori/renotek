<?php
defined('BASEPATH') or exit('No direct script access allowed');

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
|	https://codeigniter.com/user_guide/general/routing.html
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
$route['default_controller'] = 'Home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['About-Us'] = 'Home/about';
$route['Contact-Us'] = 'Home/contact';
$route['Catalogue'] = 'Home/get_catalogue';

$route['Shop'] = 'Home/shop';
$route['Products'] = 'Home/products';
$route['Product-Details/(:any)'] = 'Home/product_details/$1';
$route['Add-To-Cart/(:any)'] = 'Home/add_product_to_cart/$1';
$route['Remove-From-Cart/(:any)'] = 'Home/remove_from_cart/$1';
$route['View-Cart'] = 'Home/cart';
$route['Send-Quotation'] = 'Home/quote';
$route['Submit-Code'] = 'Home/send_quotation';

$route['Contact-Admin'] = 'Home/send_contact_request';

$route['Admin'] = 'Admin';
$route['Update-Admin'] = 'Admin_Dashboard/update_profile';
$route['Update-Admin-Password'] = 'Admin_Dashboard/update_password';
$route['Admin-Login'] = 'Admin/login';
$route['Admin-Logout'] = 'Admin/logout';
$route['Dashboard'] = 'Admin_Dashboard';
$route['Admin-Profile'] = 'Admin_Dashboard/profile';

$route['Admin-Categories'] = 'Admin_Categories';
$route['Admin-Categories/Get/(:any)'] = 'Admin_Categories/get_category/$1';
$route['Admin-Categories/Get-New-Categories/(:any)'] = 'Admin_Categories/get_new_categories/$1';
$route['Admin-Categories/Add'] = 'Admin_Categories/add_category';
$route['Admin-Categories/delete'] = 'Admin_Categories/delete_category';
$route['Admin-Categories/Update'] = 'Admin_Categories/update_category';

$route['Admin-Products'] = 'Admin_Products';
$route['Admin-Products/Get/(:any)'] = 'Admin_Products/get_product/$1';
$route['Admin-Products/Add'] = 'Admin_Products/add_product';
$route['Admin-Products/delete'] = 'Admin_Products/delete_product';
$route['Admin-Products/Update'] = 'Admin_Products/update_product';

$route['Admin-Image/(:any)'] = 'Admin_Products/image/$1';
$route['Image-Admin/Get/(:any)'] = 'Admin_Products/get_image/$1';
$route['Image-Admin/Add'] = 'Admin_Products/add_image';
$route['Image-Admin/delete'] = 'Admin_Products/delete_image';
$route['Image-Admin/Update'] = 'Admin_Products/update_image';

$route['Admin-Settings'] = 'Admin_Settings';
$route['Admin-Social-Update'] = 'Admin_Settings/update_social';
$route['Admin-About-Update'] = 'Admin_Settings/update_about';
$route['Update-Catalogue'] = 'Admin_Settings/update_catalogue';

$route['Slider'] = 'Admin_Slider';
$route['Slider/Get/(:any)'] = 'Admin_Slider/get_slider/$1';
$route['Slider/Add'] = 'Admin_Slider/add_slider';
$route['Slider/delete'] = 'Admin_Slider/delete_slider';
$route['Slider/Update'] = 'Admin_Slider/update_slider';

$route['Admin-Contact'] = 'Admin_Contact';
// $route['Admin-Contact/Get/(:any)'] = 'Admin_Contact/get_product/$1';
// $route['Admin-Contact/Add'] = 'Admin_Contact/add_product';
// $route['Admin-Contact/delete'] = 'Admin_Contact/delete_product';
// $route['Admin-Contact/Update'] = 'Admin_Contact/update_product';