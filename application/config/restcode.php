<?php

define( 'REST_ER_JSON_FORMAT' , 9000 );
define( 'REST_ER_APIKEY_AUTH' , 9010 );
define( 'REST_ER_NO_APIKEY'   , 9011 );
define( 'REST_ER_NO_TOKEN'    , 9012 );
define( 'REST_ER_NAME_ERROR'  , 9013 );
define( 'REST_ER_AUTH_ERROR'  , 9014 );

define( 'REST_ER_INPUT_VALIDATE' , 9020 );
define( 'REST_ER_PARAM_FORMAT'   , 9021 );
define( 'REST_ER_PARAM_REQUIRED' , 9022 );
define( 'REST_ER_PARAM_OTHER'    , 9023 );
define( 'REST_ER_INPUT_REQUIRED' , 9030 );
define( 'REST_ER_TRANSACTION_ERROR' , 9035 );

define( 'REST_ER_PAGE_NOTFOUND'  , 9041 );
define( 'REST_ER_NOSSL_PROTOCOL' , 9042 );

define( 'REST_ST_MAINTENANCE'    , 9903 );


define( 'REST_RESPOND_SUCCESS'    , 0 );
define( 'REST_RESPOND_CANNOT_LOCK'    , 100 );



$config['rest_error_messages'] = array(
		REST_ER_JSON_FORMAT => 'invalid json format' ,
		REST_ER_APIKEY_AUTH => 'apikey auth error' ,
		REST_ER_NO_APIKEY => 'no apikey' ,
		REST_ER_NO_TOKEN => 'no token' ,
		REST_ER_NAME_ERROR => 'no $name' ,
		REST_ER_AUTH_ERROR => 'authentication error' ,
		REST_ER_INPUT_VALIDATE => 'invalid data format' ,
		REST_ER_PARAM_FORMAT => '$param format is $format' ,
		REST_ER_PARAM_REQUIRED => '$param is required' ,
		REST_ER_PARAM_OTHER => '$param …' ,
		REST_ER_INPUT_REQUIRED => 'required error' ,
		REST_ER_PAGE_NOTFOUND => 'not found' ,
		REST_ER_NOSSL_PROTOCOL => 'not ssl connection' ,
		REST_ST_MAINTENANCE => 'maintenance' ,
);
