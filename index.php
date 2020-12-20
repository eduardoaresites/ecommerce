<?php 

session_start();

//busca as dependencias composer
require_once("vendor/autoload.php");

//sao namespace e solicitando quais as que eu quero ou melhor quais class que eu quero
//USE É uma forma de organizar as classes da aplicação. O use indica que determinada classe vai ser importada e usada por um arquivo/script específico. Já o require, require_once, include ou include_once permite a inclusão de qualquer trecho de código presente em outro arquivo
use \Slim\Slim;
use \Hcode\Page;
use \Hcode\PageAdmin;
use \Hcode\Model\User;

//rotas facilitadas
$app = new Slim();

$app->config('debug', true);
//qual a rota que estou chamando 1 rota
$app->get('/', function() {
    
    //vai chamar o construc vai adicionar header pois esta instanciando a class page
	$page = new Page();

	//adicionar arquivo h1
	$page->setTpl("index");

	//footer


});
//rotas ou route pasta admin index
$app->get('/admin/', function() {

	User::verifyLogin();
    
    //aqui vai adicionar os templates corretos 
	$page = new PageAdmin();

	//adicionar arquivo h1
	$page->setTpl("index");

	//footer


});
//pasta admin login.html

$app->get('/admin/login', function() {
    
    //aqui vai adicionar os templates corretos 
    //vamos desabilitar os header e footers da pageadmin
	$page = new PageAdmin([
		"header"=>false,
		"footer"=>false
	]);

	//adicionar arquivo h1
	$page->setTpl("login");

	//footer


});

//post
$app->post('/admin/login', function() {
	//validar o login na pg admin/login
	//foi usado metodo static
	User::login($_POST["login"], $_POST['password']);
	header("location: /admin");
	exit;
});

$app->get('/admin/logout', function() {
    	
    	User::logout();
    	header("location: /admin/login");
    	exit;
   

});

$app->run();

?>