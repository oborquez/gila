//var API_HOST = "http://127.0.0.1:3000/";
var API_HOST = "http://omarborquez.com/gila/";

var isLoged = {
    init: function init(){
        api_token = localStorage.getItem('api_token');
        console.log(api_token);
        if(api_token!=null){

            $.ajaxSetup({
                
                headers: {
                    'Access-Control-Allow-Origin': '*',
                    'Accept': 'application/json',
                    'token': api_token,
                    'Cache-Control': 'no-cache, no-store, must-revalidate', 
                    'Pragma': 'no-cache', 
                    'Expires': '0'                    
                }
            });

            $.post(API_HOST+'isLoged',function(response){
                if(response.status == 'ok'){
                    console.log('isLoged ok');
                    dash.init();
                }else{
                    login.init();        
                }
            },'json')

        }else{
            login.init();
            
        }          
    }
}

var login = {

    init: function init(){
        $("#login").show();
        $('#loginForm').on('submit',function(){
            event.preventDefault();
            $serializedData = $(this).serialize();
            $.post(API_HOST+'login',$serializedData,function(response){
                console.log(response);
                if(response.status == 'ok'){
                    localStorage.setItem('api_token', response.userData.token); 
                    location.reload();
                }
            },'json')

        })

    }
}

var dash = {

    init: function init(){
        $("#dash").show();
        $.getJSON(API_HOST+'vehicle',function(response){
            vehicle.populate( response.data )
        });
        this.changeCategory();
        $("#showForm").on("click",function(){

            $("#dash").hide();
            $("#formContainer").show();
            
            vehicleForm.init();

        })
    },

    changeCategory: function changeCategory(){
        $("#category").on("change",function(){
            category = $(this).val();

            $.getJSON(API_HOST+category,function(response){
                
                switch(category){
                    case 'vehicle': vehicle.populate(response.data); break;
                    case 'moto': moto.populate(response.data); break;
                    case 'sedan': sedan.populate(response.data); break;
                }
                    
            })
    


        })
    }
}



var vehicle = {

    populate: function populate( data ){
        $("#table-vehicle tbody").text("");
        $.each(data, function( k,v ){
            $("#table-vehicle tbody").append(
                $("<tr>").append( $("<td>").text( v.color ))
                .append( $("<td>").text(v.wheels_number))
                .append( $("<td>").text(v.horsepower))
                .append( $("<td>").text(v.registration))
                .append( $("<td>").text(v.model)
                )
            )    
        })
        
        $("#table-vehicle").show();
        $("#table-moto").hide();
        $("#table-sedan").hide();

    }

}

var moto = {
    populate: function populate( data ){
        $("#table-moto tbody").text("");
        $.each(data, function( k,v ){
            $("#table-moto tbody").append(
                $("<tr>").append( $("<td>").text( v.color ))
                .append( $("<td>").text(v.wheels_number))
                .append( $("<td>").text(v.horsepower))
                .append( $("<td>").text(v.registration))
                .append( $("<td>").text(v.model))
                .append( $("<td>").text( moto.typeText(v.motoType)))
            )    
        })
        
        $("#table-vehicle").hide();
        $("#table-moto").show();
        $("#table-sedan").hide();
    },

    typeText : function typeText( motoType ){
        motoTypes = [];
        motoTypes[0] = '';
        motoTypes[1] = "Chooper";
        motoTypes[2] = "Sport";
        motoTypes[3] = "Scooter";
        return motoTypes[motoType];      
    }

}

var sedan = {
    
    populate: function populate( data ){
        $("#table-sedan tbody").text("");
        $.each(data, function( k,v ){
            $("#table-sedan tbody").append(
                $("<tr>").append( $("<td>").text( v.color ))
                .append( $("<td>").text(v.wheels_number))
                .append( $("<td>").text(v.horsepower))
                .append( $("<td>").text(v.registration))
                .append( $("<td>").text(v.model))
                .append( $("<td>").text(v.doors_number))
                .append( $("<td>").text(v.sunroof))
            )    
        })
        
        $("#table-vehicle").hide();
        $("#table-moto").hide();
        $("#table-sedan").show();

    }
}

var vehicleForm = {
    init : function init(){
        $("#cancelForm").on("click",function(){
            location.reload();
        })

        $("#wheels_number").on("change",function(){

            if($(this).val() < 4){
                $(".sedan-field").hide();
                $(".moto-field").show();
                $("#vehicle-type").val('moto');
            }else{
                $(".sedan-field").show();
                $(".moto-field").hide();
                $("#vehicle-type").val('sedan');
            }
        })

        $("#vehicle-form").on('submit',function(){
            event.preventDefault();
            serializedData = $(this).serialize();
            typeVehicle = $("#vehicle-type").val();
            create_url = API_HOST+typeVehicle+'/create'; 
            console.log(serializedData);
            $.post(create_url,serializedData,function(response){
                console.log(response);
                
                if(response.status == 'ok'){
                    location.reload();
                }else{
                    $("#errors").text('');  
                    $.each(response.errorData,function(k, errorMessage){
                        $("#errors").append($("<div>").text(errorMessage));
                    })
                }
                    

            },'json')

        })

    },

    clear : function clear(){
        
    },

    cancelForm : function cancelForm(){

    }


}

$(document).ready(function(){
    
    isLoged.init();

})

