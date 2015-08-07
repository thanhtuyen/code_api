<?php
/**
 * Created by PhpStorm.
 * User: tuyennt
 * Date: 7/14/15
 * Time: 3:33 PM
 */
?>
<script type="text/javascript">
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
    getdata("/Countries/list");
    getdata("/Countries/?country_id=10");
</script>