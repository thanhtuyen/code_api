<?php
/**
 * Created by PhpStorm.
 * User: tuyennt
 * Date: 7/14/15
 * Time: 10:30 AM
 */
?>
<pre>
    INSERT INTO `enjin_db`.`undergraduates` (`id`, `rec_company_id`, `name`, `rec_recruiter_id`, `status`, `created`, `modified`) VALUES (NULL, '2', '学部マ', NULL, '0', '2015-07-14 00:00:00', '2015-07-14 00:00:00'), (NULL, '2', '学部', NULL, '0', '2015-07-14 00:00:00', '2015-07-14 00:00:00');
</pre>
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

<pre>getdata("/Undergraduates/list");
</pre>

<pre>getdata("/Undergraduates/?undergraduates_id=1");
</pre>
