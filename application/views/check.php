<!DOCTYPE html>
<html lang="jp">
<head>
	<meta charset="utf-8">
	<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
	<script src="/static/js/EnjinApi.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<title>check</title>
	<script type="text/javascript" >


		function getApiUrl(key, method){
			return $("#"+key).find('.method-'+method).find('.api-url-'+key).val();
		}

		function getData(key, method){
			return $("#"+key).find('.method-'+method).find('.post-data-'+key).val();
		}


		function replaceAll(find, replace, str) {
			return str.replace(new RegExp(find, 'g'), replace);
		}

		function runApi(key,method){
			var api = EnjinApi.getApi(key);
			var dataString = $("#"+key).find('.method-'+method).find('.post-data-'+key).val();
			var methodObject = api.methods[method];
			var data = false;
			if (dataString){
				data = JSON.parse(dataString);
				methodObject.setData(data);
			}

			EnjinApi.apiKey = $("#apikeysample").val();
			EnjinApi.companyId = $("#company-id").val();

			methodObject.setUrl(getApiUrl(key,method));
			methodObject.execute(function(res){
				$('.method-'+method +' .result-'+key).html("<pre><code>"+JSON.stringify(res, null, 2)+"</code></pre>");
			});
		}

		$(document).ready(function(){
			var template = $("#accordion").html();

			var methodTemplate = $("#accordion").find(".panel-body").html();
			$("#accordion").html('');
			for(var key in APIList){
				var apiObject = APIList[key];
				var html = replaceAll('{APIName}', apiObject.name, template);
				html = replaceAll('{apiNameKey}', key, html);
				var methodHtmlBody = '';
				for (j in apiObject.methods){
					var method = apiObject.methods[j];
					var subHtml = methodTemplate.replace('{methodType}', method.type);
					subHtml = subHtml.replace('{APIURL}', method.url);
					subHtml = subHtml.replace('{MethodName}', j);
					subHtml = subHtml.replace('{APIName}', apiObject.name);
					subHtml = replaceAll('{apiNameKey}', key, subHtml);
					var dataPost = '';
					if (method.data){
						dataPost = JSON.stringify(method.data,null,2);
					}
					subHtml = subHtml.replace('{dataString}', dataPost);
					subHtml = replaceAll('{method}', j, subHtml);
					methodHtmlBody += subHtml;
				}
				html = $(html).clone();
				html.find('.panel-body').html(methodHtmlBody);

				$("#accordion").append(html);

			}
		});

	</script>
</head>
<body>
<h1>program check</h1>
<div class="panel" >
	<div class="row">
		<div class="col-md-2"><label for="apikeysample" >APIKey</label></div>
		<div class="col-md-2"><input id="apikeysample" class="form-control input-sm" value="apikeysample" /><br></div>
	</div>
	<div class="row">
		<div class="col-md-2"><label for="apikeysample" >Company ID</label></div>
		<div class="col-md-2">	<input id="company-id" class="form-control input-sm" value="1" /><br></div>
	</div>

</div>
<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
	<div class="panel panel-default">
		<div class="panel-heading" role="tab" id="headingOne">
			<h3 class="panel-title">
				<a role="button" data-toggle="collapse" data-parent="#accordion" href="#{apiNameKey}" aria-expanded="true" aria-controls="collapseOne" style="font-size: 28px;font-weight: bold;">
					{APIName}
				</a>
			</h3>
		</div>
		<div id="{apiNameKey}" class="panel-collapse collapse out" role="tabpanel" aria-labelledby="headingOne">
			<div class="panel-body">
				<div class="method-{method}">
					<h4>Method: {MethodName}</h4>
					<p>Type: {methodType}</p>
					<p>URL: <input class="form-control api-url-{apiNameKey}" value="{APIURL}" /> </p>
					<h4>Post data:</h4>
					<textarea class="form-control post-data-{apiNameKey}" >{dataString}</textarea>

					<h4>Result</h4>
					<div class='result-{apiNameKey}'></div><br>
					<button onclick="runApi('{apiNameKey}', '{method}')" class='btn btn-success'>Run</button>
				</div>
			</div>

		</div>
	</div>

</div>


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
	var company_id = 1;
	var token,_xhr;

	var param = {
		api_key: apikey,
		rec_company_id: company_id
	}

	$.ajax({
		url: "/Token" ,
		async: false ,
		dataType: "json" ,
        type:"Post",
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
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>
</html>