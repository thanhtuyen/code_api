■Base Program
application
	config
		restcode.php : error code
		settings.php : Control setting
	controllers
		Requestsample.php : REST sample program
		Cities.php : Cities API program
		Token.php : Get token program
		Check.php : Sample program
	libraries
		Enjin_Controller.php : Controller for ENJIN
		REST_Controller.php : Controller for REST
	models
		Authcompany_model.php : User(client) company authentication model
		Cities_model.php : Cities model
		Token_model.php : Token model
	views
		check.php : Sample page


■Controller
CI_Controller : Default controller
REST_Controller : Controller for REST
	https://github.com/chriskacerguis/codeigniter-restserver
	action
		get    -> action_get()
		put    -> action_put()
		post   -> action_post()
		delete -> action_delete()
Enjin_Controller :
	Controller for ENJIN
	control for ssl,apikey,token

■Configuration for develop
application - config - settings.php
	Check SSL
		$config["ssl_protocol_required"] = false; Skip SSL
		$config["ssl_protocol_required"] = true;  Check SSL
	token チェック
		$config["token_check_requied"] = false; Skip checking token
		$config["token_check_requied"] = true;  Check token

■Check REST API
Please access the below URL.
http://hostname/Check
	for example： http://192.168.33.22/Check
	Please try executing the Javascript which are written in sample page on web browser's console.

