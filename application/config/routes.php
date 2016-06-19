<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

//Rotas para testes: 
$route['teste/get/(:any)'] = 'teste/get/$1'; 
$route['teste/post']       = 'teste/post'; 

//Rotas para clientes; 
$route['c/cadastrar'] = 'cliente/cadastrar'; 

//Rotas para Itens; 
$route['i/cadastrar'] = 'item/cadastrar'; 
$route['i/deletar'  ] = 'item/deletar';  
$route['item'       ] = 'item'; 

//Rotas para pedido; 
$route['p/criar'    ] = 'pedido/criar'; 
$route['pedido'     ] = 'pedido'; 
//Rotas para garcom
$route['g/cadastrar'] = 'garcom/cadastrar';
$route['g/deletar'  ] = 'garcom/deletar';  
$route['garcom'     ] = 'garcom'; 

//Rotas para o login: 
$route['a/autenticar'] = 'autenticar/auth'; 
$route['a/sair']       = 'autenticar/sair'; 
$route['login'       ] = 'autenticar'; 

//Rotas para a home: 
$route['home']         = 'home'; 


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