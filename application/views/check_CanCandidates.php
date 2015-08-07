<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="utf-8">
    <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <title>check</title>
    <script type="text/javascript" >
        var getdata = function(path){
            var apikey = "apikeysample";
            var company_id = 2;
            var token,_xhr;

            var param = {
                api_key: apikey,
                rec_company_id: company_id
            }

            $.ajax({
                url: "/Token" ,
                async: false ,
                dataType: "json" ,
                data: param ,
                crossDomain: true,
                cache: false

            }).done(function(d){
                token = d.token;
                console.log(token);
            }).fail(function( xhr, textStatus, errorThrown ){
                token = "";
                _xhr = xhr;
                console.log(xhr);
                console.log(textStatus);
                console.log(errorThrown);
            });

            if( !token ){
                console.log(_xhr.responseJSON);
                console.log(_xhr.responseJSON.error.message);
                return false;
            }

            param.token = token;

            $.get( path , param , function(d){
                console.log(d);
            },"json");

        }

        var postdata = function(path){
            var data = {
                last_name: "last_name",
                last_name_kana: "last_name_kana",
                first_name: "first_name",
                mid_name: "mid_name",
                mail_address:"test6@gmail.com",
                password : "123456",
                home_tel : "1234456789",
                join_possible_date: '2015-7-17',
                unique_id: 5
            }
            var apikey = "apikeysample";
            var company_id = 2;
            var token,_xhr;
            var param = {
                api_key: apikey,
                rec_company_id: company_id
            }

            $.ajax({
                url: "/Token" ,
                async: false ,
                dataType: "json" ,
                data: param ,
                crossDomain: true,
                cache: false

            }).done(function(d){
                token = d.token;
                console.log(token);
            }).fail(function( xhr, textStatus, errorThrown ){
                token = "";
                _xhr = xhr;
                console.log(xhr);
                console.log(textStatus);
                console.log(errorThrown);
            });

            if( !token ){
                console.log(_xhr.responseJSON);
                console.log(_xhr.responseJSON.error.message);
                return false;
            }

            param.token = token;

            param = $.extend(param, data);
            $.ajax({
                url: path,
                async: false ,
                dataType: "json" ,
                type: "PUT",
                data: param ,
                crossDomain: true,
                cache: false

            }).done(function(d){
                console.log(d);
            }).fail(function( xhr, textStatus, errorThrown ){
                token = "";
                _xhr = xhr;
                console.log(xhr);
                console.log(textStatus);
                console.log(errorThrown);
            });


        }

    </script>
</head>
<body>
<h1>program check</h1>

<h2>REST通信確認</h2>
<pre>
//get
$.ajax({
	url: "/Requestsample" ,
	dataType: "json" ,
	type: "GET"

}).done(function(d){
	console.log(d);
});


//post
$.ajax({
	url: "/Requestsample" ,
	dataType: "json" ,
	type: "POST"

}).done(function(d){
	console.log(d);
});


//put
$.ajax({
	url: "/Requestsample" ,
	dataType: "json" ,
	type: "PUT"

}).done(function(d){
	console.log(d);
});

</pre>


<h2>市町村区データ取得サンプル</h2>
<p>サンプルデータ作成</p>
<pre> insert into rec_companies values(1 ,'test company',13,0,'',now(),now(),'03-1234-5678','test@axas-japan.co.jp',200,3000,1,1,1,1,'','','',1,1,'apikeysample',now(),now());</pre>

<p>次のコードをchromeのコンソールより実行</p>
<pre>var getdata = function(path){
	var apikey = "apikeysample";
	var company_id = 2;
	var token,_xhr;

	var param = {
		api_key: apikey,
		rec_company_id: company_id
	}

	$.ajax({
		url: "/Token" ,
		async: false ,
		dataType: "json" ,
		data: param ,
		crossDomain: true,
		cache: false

	}).done(function(d){
			token = d.token;
			console.log(token);
	}).fail(function( xhr, textStatus, errorThrown ){
			token = "";
			_xhr = xhr;
			console.log(xhr);
			console.log(textStatus);
			console.log(errorThrown);
	});

	if( !token ){
		console.log(_xhr.responseJSON);
		console.log(_xhr.responseJSON.error.message);
		return false;
	}

	param.token = token;

	$.get( path , param , function(d){
		console.log(d);
	},"json");

}
	</pre>

<p>次のコードをコンソールで実行すると結果が出ます。</p>
<pre>getdata("/Cities/list");
</pre>

<p>次のコードをコンソールで実行すると結果が出ます。</p>
<pre>getdata("/Cities/?cities_id=13");
</pre>
</body>
</html>