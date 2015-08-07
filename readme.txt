■追加プログラム
application
	config
		restcode.php : エラーコード記述
		settings.php : 開発用制御設定
	controllers
		Requestsample.php : RESTサンプルプログラム
		Cities.php : 市町村区取得プログラム
		Token.php : token取得プログラム
		Check.php : サンプルプログラム
	libraries
		Enjin_Controller.php : Enjin用コントローラー
		REST_Controller.php : REST通信用コントローラー
	models
		Authcompany_model.php : ユーザー企業認証model
		Cities_model.php : 市町村区model
		Token_model.php : token model
	views
		check.php : サンプルプログラムページ


■コントローラーの種類
CI_Controller : デフォルトのコントローラー
REST_Controller : REST通信ようのコントローラー
	https://github.com/chriskacerguis/codeigniter-restserver
	action
		get    -> action_get()
		put    -> action_put()
		post   -> action_post()
		delete -> action_delete()
Enjin_Controller
	Enjinプロジェクト用コントローラー
	ssl,apikey,token制御

■開発用設定情報
application - config - settings.php
	SSL通信チェック
		$config["ssl_protocol_required"] = false; チェックをスキップ
		$config["ssl_protocol_required"] = true;  チェックする
	token チェック
		$config["token_check_requied"] = fakse; tokenのチェックをスキップ
		$config["token_check_requied"] = true;  チェックする

■REST通信サンプル
http://開発用ホスト名/Check へアクセス
	例： http://192.168.33.22/Check
	ページ上の表示に従い実行、chromeやfirefoxのコンソールを使用する

