<pre>
    INSERT INTO `enjin_db`.`businesses` (`id`, `name`, `status`, `created`, `modified`) VALUES (NULL, 'data test', '0', '2015-07-14 00:00:00', '2015-07-14 00:00:00'), (NULL, 'data test 2', '0', '2015-07-14 00:00:00', '2015-07-14 00:00:00');
</pre>
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

<pre>getdata("/Businesses/list");
</pre>

<pre>getdata("/Businesses/?business_id=2");
</pre>