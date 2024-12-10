//alert("JS du fichier script.js général");

$("#Search").autocomplete({
    source: function (request, response){
        $.ajax({
            url: "http://www.cesi.local/ApiArticle/search",
            dataType: "json",
            data: JSON.stringify({"keyword": request.term}),
            type: "POST",
            beforeSend: function () {
                console.log("Waiting ....");
            },
            success: function (data){
                console.log(data);
                response([]);
            },
            error: function (){
                console.error("Erreur appel API");
                response([]);
            }
        })
    }


});