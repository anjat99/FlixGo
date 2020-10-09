
$(document).ready(function(){
   
    //index.php?page=pocetna
    var url="https://flix-go4movies.000webhostapp.com/sajt-flixGo/";
    var urlDoAdmin="https://flix-go4movies.000webhostapp.com/sajt-flixGo/views/pages/";
    let location = this.location.href;
    console.log(location);

    //portfolio(autor page)
    document.getElementById("otvoriNoviTab").addEventListener("click", function(){
        window.open("https://tomicanja-portfolio.netlify.com/", "_blank");
    });
   
    var linkAutor=document.getElementById("autor");
    var zatvori=document.getElementById("zatvori0");
    linkAutor.addEventListener("click",otvoriModal);
    zatvori.addEventListener("click",zatvoriModal);

    //modal - autor page
    function otvoriModal(){
        document.getElementById("modal0").style.display="block";
    }
    function zatvoriModal(){
        document.getElementById("modal0").style.display="none";
    }

    var modal = document.getElementById('modal0');
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    };


      //index.php?page=pocetna & page=catalog (SHOW MORE)
    $("#dodatak").hide();
    $("#prikaziViseFilmova").click(function(e) {
        e.preventDefault();
        $("#dodatak").slideToggle(500);
    });

    $("#btnSubscribe").click(subscription);

    // Newsletter
    function subscription(e){
        e.preventDefault();
        let validNewsletter = true;

        let emailPolje = document.getElementById("notification");
        let emailValue = emailPolje.value.trim();
        console.log(emailValue);
       
        // let reEmail = /^\w([\.-]?\w+\d*)*\@\w+\.\w{2,7}\.\w{2,4}$/
        // let emailGreska = document.querySelector(".emailVestigreska");

        // //Validacija email-a
        // let isValidEmailVesti = reEmail.test(emailValue);
        // if(isValidEmailVesti){
        //     console.log("true");
        //     emailGreska.textContent = "Thank you for your subscription! We hope that you are going to enyoy on the latest news from us.";
        //     document.getElementById("notification").value="";
        //     emailGreska.style.display='none';
        // }
        // else{
        //     emailGreska.style.display='block';
        //     validNewsletter = false;
        //     emailPolje.focus();
        //     console.log("false");
        // }
        $.ajax({
            url: url+"models/users/subscription.php",
            method: "POST",
            data: {
                email: emailValue,
                send: true
            },
            success: function(data){
                console.log(data.message);
                alert(data.message);
                $("#notification").val("");
            },
            error: function(xhr, errType, errMsg){
                console.log(xhr.responseText);
                alert ("Already subscribed to our newsletter!");
    
                $("#notification").val("");
                
            }
        });
       }
       
        //---------------------------- REVIEWS OF MOVIES --------------------------------------//
        $("#btnAddReview").click(ispisiAddFormuReview);
        function ispisiAddFormuReview(e){
            console.log("add review");
            e.preventDefault();
            $("#formaReview").slideToggle("500");
        }
        
        $("#btnSendReview").on("click", posaljiReview);
        function posaljiReview(e){
            console.log("posalji review");
            e.preventDefault();
            let naslov = $("#tbTitleReview").val().trim();
            let poruka = $("#taMessageReview").val().trim();
            let movie = $(this).data("movie");

            console.log("Naslov: " + naslov);
            console.log("Poruka: " + poruka);

            let naslovGreska = document.querySelector("#naslovGreska");
            let porukaGreska = document.querySelector("#porukaGreska");

            let greske=[];
            let valid=true;

            if(naslov == ''){
                greske.push("<b>The field for the title is required!");
                naslovGreska.textContent = "The field for the title is required!";
                alert ("The field for the title is required!")
                valid = false;
            }
            if(poruka == ''){
                greske.push("<b>The field for the text of review is required!</b>");
                porukaGreska.textContent = "The field for the text of review is required!";
                alert ("The field for the text of review is required!");
                valid = false;
            }

            $.ajax({
                url: url+"models/reviews/add.php",
                method: "POST",
                dataType: "json",
                data: {
                    naslov: naslov,
                    poruka: poruka,
                    movie: movie,
                    send: true
                },
                success: function (data, xhr) {
                    console.log(data);
                    console.log(data.message);
                    if(data.kod == 422){
                        window.location.reload();
                    }else{
                        alert("Review successfully sent");
                        document.getElementById("tbTitleReview").value="";
                        document.getElementById("taMessageReview").value="";
                        window.location.reload();
                        location.replace('https://flix-go4movies.000webhostapp.com/sajt-flixGo/movieDetail.php?id='+movie);
                    }
                },
                error: function (xhr, error,status) {
                    let code = xhr.status;
                    console.log(xhr.responseText);
                    switch (code) {
                        case 500:
                            alert("Server error, please try again");
                            break;
                        default:
                            console.log("Error: " + code + ", " + error)
                            break;
                    }
                }
            })
        }
  
        //---------------------------- CATALOG --------------------------------------//
      //  if(window.location.href==url+"index.php?page=catalog" || window.location.href==url+"index.php?page=catalog#"){
            
        $(".ddls").on("change", upariSortIFilterValue);
        $("#ddlSort").on("change", sortiraj);
        $("#ddlGenre").on("change", filterByGenre);
        // alert("s");
        var idZanr;
        var sort;
        var strana;

        console.log("film");

            //catalog - pretraga filma po nazivu
            $("#search").keyup(function(){
                let value = this.value.toLowerCase();
                console.log(value);
                $.ajax({
                    url: "models/catalog/search.php",
                    method: "POST",
                    dataType:"json", //OVOOOOO MORAAA DA STOJI
                    data:{
                        keyword:value
                    },
                    success: function(podaci){
                        console.log(podaci);
                        ispisFilmova(podaci);
                        if((podaci.movie).length == 0){
                            $("#sviFilmovi").html("<h2 class='text-white'>Sorry, the movie with your search doesn't exists yet in our catalog. Please contact administrator in case you want to add that movie to our collection...</h2>");
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                        console.log(xhr.responseText);
                        console.log(xhr.status);
                    }
                });
            });

      
      //  }
      //---------------------------- // END CATALOG --------------------------------------//

      function upariSortIFilterValue(){
        idZanr = Number($("#ddlGenre").val());
        console.log(idZanr);
        sort = Number($("#ddlSort").val());
        console.log(sort);
        strana = $(this).find(":selected").data("str");
        console.log(strana); 
        
  }

    function sortiraj() {
        let sort = $(this).val();
        let idZanrValue = idZanr;
        let _strana = strana;
        console.log(_strana);

            $.ajax({
                url: url+"models/catalog/sort_i_filter.php",
                method: "POST",
                data: {
                    idZanr: idZanrValue,
                    sortValue: sort,
                    strana: _strana,
                    send: true
                },
                dataType: "json",
                success: function (podaci) {
                    console.log(podaci);
                    ispisFilmova(podaci);
                },
                error: function (xhr, error, status) {
                    let code = xhr.status;
                    console.log(xhr.responseText);
                    switch (code) {
                        case 422:
                            alert("Invalid data, please check your entered data.");
                            break;
                        case 500:
                            alert("Server error, please try again.");
                            break;
                        default:
                            alert("Error: " + code + ", " + error);
                            break;
                    }
                }
            });
    }

    function filterByGenre() {
        let idZanr = $(this).val();
        let sortValue = sort;
         let _strana = strana;
        console.log(_strana);

            $.ajax({
                url: url+"models/catalog/sort_i_filter.php",
                method: "POST",
                data: {
                    idZanr: idZanr,
                    sortValue: sortValue,
                    strana: _strana,
                    send: true
                },
                dataType: "json",
                success: function (podaci) {
                    console.log(podaci);
                    ispisFilmova(podaci);
                    if((podaci.movie).length == 0){
                        $("#sviFilmovi").html("<h2 class='text-white'>Sorry, the movie with this filter doesn't exists yet in our catalog. Please contact administrator in case you want to add that movie to our collection...</h2>");
                    }
                },
                error: function (xhr, error, status) {
                    let code = xhr.status;
                    switch (code) {
                        case 422:
                            alert("Invalid data, please check your entered data.");
                            break;
                        case 500:
                            alert("Server error, please try again");
                            break;
                        default:
                            alert("Error: " + code + ", " + error);
                            break;
                    }
                }
            });
    }


     //catalog - prikaz svih filmova
    function ispisFilmova(podaci){
        let html = ` <div class="row" id="filmovi">`;
    //col-6 col-sm-4 col-lg-3 col-xl-2
        for(let film of podaci.movie){
            html += `
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2">
                        <div class="card">
                            <div class="card__cover">
                                <img src="${film.coverName}" alt="${film.filmName}">
                                <a href="index.php?page=movieDetails&id=${film.id_movie}" class="card__play">
                                    <i class="icon ion-ios-play"></i>
                                </a>
                            </div>
                            <div class="card__content">
                                <h3 class="card__title">
                                    <a href="index.php?page=movieDetails&id=${film.id}" data-id="${film.id}">${film.filmName}</a></h3>
                                <span class="card__category">
                                    <a href="#">${obradaZanrova(podaci.zanrovi)}</a>
                                </span>
                                <span class="card__rate"><i class="icon ion-ios-star"></i>
                                    ${obradaRating(film.prosek)}
                                </span>
                            </div>
                        </div>
                    </div>`;
                    function obradaZanrova(zanrovi){
                        for (let item of zanrovi) {
                            if(item.id_movie == film.id){
                                return item.genres;
                            }
                        }
                    }
                    function obradaRating(prosek){
                            if(prosek == null){
                                return "0 votes";
                            }else{
                                return prosek;
                            }
                    }
        }
        html+=`</div>`;
        
            
         html += `<div class=" row col-12">
                    <ul class="paginator" id="paginationCatalog">`;
                    for (let i = 1; i <= podaci.numOfPages; i++){
                        let active = podaci.strana == i ? "paginator__item--active" : "";
                        html += ` <li class="paginator__item ${active}">
                                <a class="${active}" href="index.php?page=catalog&strana=${i}" data-id="${i}" >${i}</a>
                            </li> `;
                    }
        html += `</ul>
        </div>`;
        $("#sviFilmovi").html(html);
        }

       
        $(".fa-star").click(function(){
            var rate=$(this).data("id");
            var movie=$(this).data("movie");
            console.log(rate);
            console.log(movie);

                $.ajax({
                    url:url+"models/catalog/rating.php",
                    method:"post",
                    dataType:"json",
                    data:{
                        movie:movie,
                        ocena:rate,
                        send:true
                    },
                    success:function(data){
                            console.log(data.length)
                            console.log(data)
                            if(data=='ok'){
                                alert("successfully rated");
                                window.location.reload();
                            }
                        },
                    error:function(){
                        console.log("nije ok");
                        alert("Already rated this movie!");
                            // window.location.reload();
                            $("#greskaOcena").html("Already rated this movie");
                    }
                })
           })



            //---------------------------- REGISTER --------------------------------------//
        if(window.location.href==url+"index.php?page=register" || window.location.href==url+"index.php?page=register#"){
        //------------------ Registracija ----------------//
            $("#btnRegistracija").on("click",function(){
                console.log("btn");
                // alert("btn");

                function unosKorisnika(){
                    console.log("unos");
                    // alert("unos");

                    let ime=$("#ime").val();
                    let prezime=$("#prezime").val();
                    let email=$("#email").val();
                    let username=$("#username").val();
                    let lozinka=$("#lozinka").val();
                    let datum=$("#dateofbirth").val();
            
                    let reIme = /^[A-ZŠĐŽČĆ][a-zšđžčć]{2,29}(\s[A-ZŠĐŽČĆ][a-zšđžčć]{2,29})*$/;
                    let rePrezime = /^[A-ZŠĐŽČĆ][a-zšđžčć]{2,49}(\s[A-ZŠĐŽČĆ][a-zšđžčć]{2,49})*$/;
                    let reEmail = /^[a-z]{3,}(\.)?[a-z\d]{1,}(\.[a-z0-9]{1,})*\@[a-z]{2,7}\.[a-z]{2,3}(\.[a-z]{2,3})?$/;
                    let reUsername = /^[\d\w\_\-\.]{4,30}$/;
                    let reLozinka = /^\S{5,50}$/;
            
                    var greske=[];
                    var valid=true;
     
                    let imeGreska = document.querySelector("#imeGreskaRegister");
                    let prezimeGreska = document.querySelector("#prezimeGreskaRegister");
                    let usernameGreska = document.querySelector("#usernameGreskaRegister");
                    let emailGreska = document.querySelector("#emailGreskaRegister");
                    let lozinkaGreska = document.querySelector("#lozinkaGreskaRegister");
                    let datumGreska = document.querySelector("#datumGreskaRegister");
                
    
                    if(datum == ''){
                        greske.push("<b class='text-bela'>The field for birthdate is required!</b>");
                        datumGreska.textContent = "The field for birthdate is required!";
                        valid = false;
                    }
                    if(ime == ''){
                        greske.push("<b class='text-bela'>The field for name is required!</b>");
                        imeGreska.textContent = "The field for name is required!";
                        valid = false;
                    }else {
                        if(!reIme.test(ime)){
                            valid = false;
                            greske.push("<b class='text-bela'>Name has to start with uppercase and person can write in it more name </b>");
                            imeGreska.textContent = "*Name has to start with uppercase and person can write in it more name";
                        }else{
                            imeGreska.textContent = "";
                        }
                    }

                    if(prezime == ''){
                        greske.push("<b class='text-bela'>The field for surname is required!</b>");
                        prezimeGreska.textContent = "The field for surname is required!";
                        valid = false;
                    }else {
                        if(!rePrezime.test(prezime)){
                            valid = false;
                            greske.push("<b class='text-bela'>Surname has to start with uppercase and person can write in it more name </b>");
                            prezimeGreska.textContent = "*Surname has to start with uppercase and person can write in it more surname";
                        }else{
                            prezimeGreska.textContent = "";
                        }
                    }

                    if(username == ''){
                        greske.push("<b class='text-bela'>The field for username is required!</b>");
                        usernameGreska.textContent = "The field for username is required!";
                        valid = false;
                    }else {
                        if(!reUsername.test(username)){
                            valid = false;
                            greske.push("<b class='text-bela'>Username is free mind (symbol @ isn't supported) </b>");
                            usernameGreska.textContent = "*Username is free mind (symbol @ isn't supported)";
                        }else{
                            usernameGreska.textContent = "";
                        }
                    }
            
                    if(email==''){
                        greske.push("<b class='text-bela'>The field for email is required!</b>");
                        emailGreska.textContent="The field for email is required!";
                        valid = false;
                    }else {
                        if(!reEmail.test(email)){
                            valid = false;
                            greske.push("<b class='text-bela'>Email address  has to be in format for example. -> somebody@gmail.com </b>");
                            emailGreska.textContent="*Email address  has to be in format for example. -> somebody@gmail.com";
                        }else{
                            emailGreska.textContent = "";
                        }
                    }

                    
                if(lozinka == ''){
                    greske.push("<b class='text-bela'>The field for password is required!</b>");
                    lozinkaGreska.textContent = "The field for password is required!";
                    valid = false;
                }else {
                    if(!reLozinka.test(lozinka)){
                        valid = false;
                        greske.push("<b class='text-bela'>Password has to have more than 8 characters</b>");
                        lozinkaGreska.textContent = "*Password has to have more than 8 characters";
                    }else{
                        lozinkaGreska.textContent = "";
                    }
                }
            
                    if(greske.length){
                        let ispis=`<ul>`;
                            for(let greska of greske){
                                ispis+=`<li>${greska}</li>`
                            }
                            ispis+=`</ul>`;
                            $("#poruka").html(ispis);
                    }
                    
                    var obj={
                        ime:ime,
                        prezime:prezime,
                        email:email,
                        username:username,
                        lozinka:lozinka,
                        datum:datum,
                        send:true
                    };
                    return obj;
                }
            
                function callAjax(obj){
                    console.log("ajax");
                    $.ajax({
                        url : "models/register.php",
                        method : "POST",
                        dataType:"json",
                        data:obj,
                        success : function(data) {
                            console.log(data);
                            if(data.message=="User successfully registred"){
                                alert("Successful registration");
                            $("#poruka").html("Successful registration");
                            
                            window.location.replace('https://flix-go4movies.000webhostapp.com/sajt-flixGo/index.php?page=login');
                            }
                            
                        },
                        error : function(xhr, status, error) {
                            let poruka="Doslo je do greske";
                            console.log(status);
                            alert(poruka);
                                switch(xhr.status){
                                    case 404:
                                        poruka="Stranica nije pronadjena";
                                        break;
                                    case 409:
                                        poruka="Username ili email vec postoji";
                                        break;
                                    case 422:
                                        poruka="Podaci nisu validni";
                                        break;
                                    case 500:
                                        poruka="Greska";
                                        break;
                                }
                                $("#poruka").html(poruka);
                                console.log(poruka);
                                console.log(xhr.responseText)
                                console.log(xhr.status)
                        }
                    });
                }
                var formData = unosKorisnika();
                callAjax(formData);
            });
        }

        //------------------------------------ KONTAKT ---------------------------------//
        if(window.location.href==url+"index.php?page=contact" || window.location.href==url+"index.php?page=contact#"){
            $("#btnKontakt").click(function(){
                var reSubj = /^[A-ZŠĐŽČĆa-zšđžčć\.\d\s\-]{1,299}$/
                var reEmail = /^[a-z]{3,}(\.)?[a-z\d]{1,}(\.[a-z0-9]{1,})*\@[a-z]{2,7}\.[a-z]{2,3}(\.[a-z]{2,3})?$/
                // var rePitanja = /^[A-ZZŠĐŽČĆ][a-zšđžčć\.\d\s\-\?]{1,}$/
        
    
                var subj=$("#subj").val();
                var email=$("#email").val();
                var message=$("#message").val();
        
                //smestanje greske
                let subjGreska, emailGreska, pitanjaGreska;
       
                subjGreska = document.querySelector("#subjGreska");
                emailGreska = document.querySelector("#emailGreska");
                pitanjaGreska = document.querySelector("#pitanjaGreska")
            
                var valid = true;
                var greske=[];
                var podaci=[];


                if(subj==''){
                    greske.push("<b>Morate da unesete naslov poruke!</b>");
                    subjGreska.textContent = "Morate da unesete naslov poruke!";
                    valid = false;
                }else {
                    if(!reSubj.test(subj)){
                        valid = false;
                        greske.push("Naslov nije u dobrom formatu -> dozvoljena su mala i velika slova, brojevi, kao i crtica, tačka. Max: 300 karaktera");
                        subjGreska.textContent = "*Naslov nije validan --:  Max: 300 karaktera, dozvoljena su mala i velika slova, brojevi, kao i crtica, tačka.";
                    }else{
                        subjGreska.textContent = "";
                        podaci.push(subj);
                    }
                }
        
                if(email==''){
                    greske.push("<b>Morate da unesete email!</b>");
                    emailGreska.textContent="Morate da unesete email!";
                    valid = false;
                }else {
                    if(!reEmail.test(email)){
                        valid = false;
                        greske.push("Email nije u dobrom formatu -> Mora da bude ispisan malim slovima u formatu poput: nesto@gmail.com ");
                        emailGreska.textContent="*Email adresa nije validna. Mora da bude ispisana malim slovima u formatu poput: nesto@gmail.com .";
                    }else{
                        emailGreska.textContent = "";
                        podaci.push(email);
                    }
                }
        
                if(message==''){
                    greske.push("<b>Morate da unesete tekst poruke!</b>");
                    pitanjaGreska.textContent="Morate da unesete tekst poruke!";
                    valid = false;
                }else {
                        // alert("The message has been sent");
                        pitanjaGreska.textContent = "";
                        podaci.push(message);
                }
        
                if(greske.length){
                    let ispis='';
                    for (let i = 0; i < greske.length; i++) {
                        ispis+=greske[i] + "<br>";
                    }
                    $("#success").html(ispis);
                }else{
                    $.ajax({
                        url:"models/contact/insertMessage.php",
                        method:"post",
                        dataType:"json",
                        data:{
                            // name:name,
                            subj:subj,
                            email:email,
                            message:message,
                            send:true
                        },
                        success:function(data,status,xhr){
                            if(xhr.status==201){
                                // $("#name").val("");
                                console.log(data.success);
                                $("#subj").val("");
                                $("#email").val("");
                                $("#message").val("");
                                alert("Message send successfully to admin!");
                                window.location.reload();
                            }
                        },
                        error:function(xhr,status,data){
                            console.log(xhr.status + status);
                            // $("#subj").val("");
                            // $("#email").val("");
                            // $("#message").val("");
                            // alert("Message send successfully to admin!");
                            // window.location.reload();
                        }
                    });
                }
            });
        }

        //------------------------------------ Logovanje ---------------------------------//
       if(window.location.href==url+"index.php?page=login" || window.location.href==url+"index.php?page=login#"){
            $("#btnLogin").click(proveraLogin);
            function proveraLogin(){
                console.log("btnLogin");
                console.log("unos");
                
                let email=$("#tbEmail").val();
                let lozinka=$("#tbLozinka").val();
            
                let reEmail = /^[a-z]{3,}(\.)?[a-z\d]{1,}(\.[a-z0-9]{1,})*\@[a-z]{2,7}\.[a-z]{2,3}(\.[a-z]{2,3})?$/;
                let reLozinka = /^\S{5,50}$/;

                let emailGreska = document.querySelector("#emailGreskaLogin");
                let lozinkaGreska = document.querySelector("#lozinkaGreskaLogin");
            
                var greske=[];
                var valid = true;

                if(lozinka == ''){
                    greske.push("<b class='text-bela'>The field for password is required!</b>");
                    lozinkaGreska.textContent = "The field for password is required!";
                    valid = false;
                }else {
                    if(!reLozinka.test(lozinka)){
                        valid = false;
                        greske.push("<b class='text-bela'>Password has to have more than 8 characters</b>");
                        lozinkaGreska.textContent = "*Password has to have more than 8 characters";
                    }else{
                        lozinkaGreska.textContent = "";
                    }
                }
        
                if(email==''){
                    greske.push("<b class='text-bela'>The field for email is required!</b>");
                    emailGreska.textContent="The field for email is required!";
                    valid = false;
                }else {
                    if(!reEmail.test(email)){
                        valid = false;
                        greske.push("<b class='text-bela'>Email address  has to be in format for example. -> somebody@gmail.com </b>");
                        emailGreska.textContent="*Email address  has to be in format for example. -> somebody@gmail.com.";
                    }else{
                        emailGreska.textContent = "";
                    }
                }
            
                // if(greske.length){
                //     let ispis=`<ul>`;
                //         for(let greska of greske){
                //             ispis+=`<li>${greska}</li>`
                //         }
                //         ispis+=`</ul>`;
                //         $("#porukaGreskeLogin").html(ispis);
                // }


                if(greske.length){
                    let ispis='';
                    for (let i = 0; i < greske.length; i++) {
                        ispis+=greske[i] + "<br>";
                    }
                    $("#porukaGreskeLogin").html(ispis);
                }else{
                    $.ajax({
                        url:url+"models/login.php",
                        method:"post",
                        data:{
                            email:email,
                            lozinka:lozinka,
                            send:true
                        },
                        success:function(data){
                            console.log(data);
                            $("#tbEmail").val("");
                            $("#tbLozinka").val("");
                            alert("Successfully login to our website!");
                            window.location.reload();
                            $("#poruka").html("Successfully login to our website!");
                            if(data == "user"){
window.location.replace('https://flix-go4movies.000webhostapp.com/sajt-flixGo/index.php?page=home');
                            }else{
window.location.replace('https://flix-go4movies.000webhostapp.com/sajt-flixGo/views/pages/admin.php');

                            }
                            
                        },
                        error:function(xhr,status,data){
                            console.log(xhr.status + status);
                            console.log(xhr.responseText)
                            $("#tbEmail").val("");
                            $("#tbLozinka").val("");
                            window.location.reload();
                            let poruka = "Some error is made...";
                            window.location.replace('https://flix-go4movies.000webhostapp.com/sajt-flixGo/index.php?page=home');
                            switch(xhr.status){
                                case 404:
                                    poruka="Page not found";
                                    break;
                                case 422:
                                    poruka="To login, first you need to be registred..!";
                                    window.location.replace('https://flix-go4movies.000webhostapp.com/sajt-flixGo/index.php?page=register');
                                    break;
                                case 500:
                                    poruka="Server error, please contact the administrator";
                                    break;
                            }
                            $("#porukaGreskeLogin").html(poruka);
                            console.log(poruka);
                            alert(poruka);   
                         
                        }
                    });
                }
            }
        }  
        
         //------------------------------------ Reviews - korisnik---------------------------------//
        if(window.location.href==url+"index.php?page=user" || window.location.href==url+"index.php?page=user#"){
            // ispisiSveReviews();
            $(".obrisi-review").on("click",obrisiReview);
            function obrisiReview(e){
                e.preventDefault();
                let poslati=confirm("Da li ste sigurni da zelite da obrisete poruku?");
                let korisnik=$(this).data("user");
                let review=$(this).data("id");
                let movie=$(this).data("movie");
                console.log("Korisnik: " + korisnik + "- Review: " + review + "- Film: " + movie);
                 if(poslati){
                     console.log("Obrisano");
                    $.ajax({
                         url: url+"models/reviews/delete.php",
                        method:"post",
                        dataType:"json",
                        data:{
                            id:review,
                            korisnik:korisnik,
                            movie:movie,
                            send:true
                        },
                        success:function(data){
                                console.log(data);
                                 window.location.reload();
                        },
                        error:function(xhr,status,data){
                                console.log(xhr.status + status);
                                window.location.reload();
                        }
                    });
                 }
           }

            $("#detalji-review").hide();
            $(".detalji-review").on("click",prikaziDetaljeReview);

            function prikaziDetaljeReview(e){
                console.log("Detalji");
                e.preventDefault();
                let korisnik=$(this).data("user");
                let review=$(this).data("id");
                let movie=$(this).data("movie");
                console.log("Korisnik: " + korisnik + "- Review: " + review + "- Film: " + movie);

                    $.ajax({
                        url: url+"models/reviews/get_one.php",
                       method:"post",
                       dataType:"json",
                       data:{
                           id:review,
                           korisnik:korisnik,
                           movie:movie,
                           send:true
                       },
                       success:function(data){
                               console.log(data);
                                $("#detalji-review").hide();
                                $("#detalji-review").html(detaljiJedanReviewTabela(data))
                                $("#detalji-review").slideDown("slow");
            
                                $("#sakrijFormuSaDetaljimaReview").click(function(){
                                    $("#detalji-review").slideUp("slow");
                                })
                       },
                       error:function(xhr,status,data){
                               console.log(xhr.status + status);
                            //    window.location.reload();
                       }
                   });
                   function detaljiJedanReviewTabela(data){
                    let ispis=`
                                <div class="main__table-wrap">
                                    <table class="main__table mt-4 text-center d-flex flex-column justify-content-center align-content-center detalji table" border="1">
                                            <tr>
                                                <td class="text-white">MOVIE </td>
                                                <td>
                                                    <div class="main__table-text text-white">${data.film}</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-white">TITLE</td>
                                                <td>
                                                    <div class="main__table-text text-bela">${data.title}</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-white align-middle" >REVIEW</td>
                                                <td>
                                                    <div class="main__table-text text-justify main__table-text--green text-bela">${data.tekstReview}</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-white">DATE OF REVIEW</td>
                                                <td class="align-middle">
                                                    <div class="main__table-text text-bela ">${data.datumReview}</div>
                                                </td>
                                            </tr>
                                    </table>
                                    <button type="button" id="sakrijFormuSaDetaljimaReview"
                                class="btn btn-primary mt-4 ml-4">Hide</button>
                                </div>`;
                    return ispis;
                   }
               }
              

            
              
        }
        
        
        
    });