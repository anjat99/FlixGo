$(document).ready(function(){
   
    var urlDoAdmin="https://flix-go4movies.000webhostapp.com/sajt-flixGo/";
    let location = this.location.href;
    console.log(location);


        ispisiSveZanrove();
    $("#dodajZanr").click(ispisiAddFormuGenre);

    ispisiSveRezolucije();
    $("#dodajRezoluciju").click(ispisiAddFormuQuality);

    ispisiSveDrzave();
    $("#dodajDrzavu").click(ispisiAddFormuCountry);

    ispisiSvaOgranicenjaGodina();
    $("#dodajLimitGodina").click(ispisiAddFormuLimitAge);

    ispisiSveNavLinkove();
    $("#dodajNavLink").click(ispisiAddFormuNav);

    $(".obrisiFilm").on("click",obrisiFilm);
    function obrisiFilm(e){
        e.preventDefault();
        let poslati=confirm("Da li ste sigurni da zelite da obrisete film?");
        let movie=$(this).data("movie");
        console.log("Film: " + movie);
         if(poslati){
             console.log("Obrisano");
            $.ajax({
                 url: urlDoAdmin+"models/movies/delete.php",
                method:"post",
                dataType:"json",
                data:{
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
 ispisiSveKorisnike();
    ispisiSvePoruke();

    $(".obrisiReview").on("click",obrisiReview);
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
                 url: urlDoAdmin+"models/reviews/delete_admin.php",
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

    $("#detaljiReview").hide();
    $(".detaljiReview").on("click",prikaziDetaljeReview);

    function prikaziDetaljeReview(e){
        console.log("Detalji");
        e.preventDefault();
        let korisnik=$(this).data("user");
        let review=$(this).data("id");
        let movie=$(this).data("movie");
        console.log("Korisnik: " + korisnik + "- Review: " + review + "- Film: " + movie);

            $.ajax({
                url: urlDoAdmin+"models/reviews/get_one.php",
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
                        $("#detaljiReview").hide();
                        $("#detaljiReview").html(detaljiJedanReviewTabela(data))
                        $("#detaljiReview").slideDown("slow");
    
                        $("#sakrijFormuSaDetaljimaReview").click(function(){
                            $("#detaljiReview").slideUp("slow");
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
                                            <div class="main__table-text text-white text-centar">${data.film}</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-white">USER</td>
                                        <td>
                                            <div class="main__table-text text-bela  text-centar">${data.username}</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-white">TITLE</td>
                                        <td>
                                            <div class="main__table-text text-bela text-centar">${data.title}</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-white align-middle" >REVIEW</td>
                                        <td>
                                            <div class="main__table-text text-justify main__table-text--green text-bela  text-centar">${data.tekstReview}</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-white">DATE OF REVIEW</td>
                                        <td class="align-middle">
                                            <div class="main__table-text text-bela  text-centar">${data.datumReview}</div>
                                        </td>
                                    </tr>
                            </table>
                            <button type="button" id="sakrijFormuSaDetaljimaReview"
                        class="btn btn-primary mt-4 ml-4">Hide</button>
                        </div>`;
            return ispis;
           }
       }


 //------------------- ISPIS ZANROVA ---------------//
    function ispisiSveZanrove(){
        console.log("ispisSvihZantova");
        $.ajax({
            url: urlDoAdmin + "models/genres/get_all.php",
            dataType:"json",
            method:"post",
            success:function(data){
                $(".podaciJedanZanr").click(ispisiJedanZanr);
                $("#sakrijFormuZaZanrove").click(function(){
                    $("#podaciGenresEdit").slideUp("slow");
                 });
                $("#sakrijFormuZaZanroveDodaj").click(function(){
                    $("#podaciGenresAdd").slideUp("slow");
                 });
            },
            error:function(xhr,status,data){
                console.log(xhr.status + status);
            }
        });
    }
    
    //------------------- ISPIS REZOLUCIJA ---------------//
    function ispisiSveRezolucije(){
        console.log("ispisSvihRez");
        $.ajax({
            url: urlDoAdmin + "models/quality/get_all.php",
            dataType:"json",
            method:"post",
            success:function(data){
                $(".podaciJedanQuality").click(ispisiJedanQuality);
                $("#sakrijFormuZaRezolucije").click(function(){
                    $("#podaciQualityEdit").slideUp("slow");
                 });
                $("#sakrijFormuZaRezolucijeDodaj").click(function(){
                    $("#podaciQualityAdd").slideUp("slow");
                 });
            },
            error:function(xhr,status,data){
                console.log(xhr.status + status);
            }
        });
    }

    //------------------- ISPIS DRZAVA ---------------//
    function ispisiSveDrzave(){
        console.log("ispisSveDrzave");
        $.ajax({
            url: urlDoAdmin + "models/country/get_all.php",
            dataType:"json",
            method:"post",
            success:function(data){
                $(".podaciJednaDrzava").click(ispisiJednaDrzava);
                $("#sakrijFormuZaDrzavu").click(function(){
                    $("#podaciCountryEdit").slideUp("slow");
                 });
                $("#sakrijFormuZaDrzavuDodaj").click(function(){
                    $("#podaciCountryAdd").slideUp("slow");
                 });
            },
            error:function(xhr,status,data){
                console.log(xhr.status + status);
            }
        });
    }

//------------------- ISPIS limit AGES ---------------//
    function ispisiSvaOgranicenjaGodina(){
        console.log("OgranicenjaGodina");
        $.ajax({
            url: urlDoAdmin + "models/limit-ages/get_all.php",
            dataType:"json",
            method:"post",
            success:function(data){
                $(".podaciJednoOgranicenjeGodina").click(ispisiJedanLimitAge);
                $("#sakrijFormuZaLimit").click(function(){
                    $("#podaciLimitAgeEdit").slideUp("slow");
                 });
                $("#sakrijFormuZaLimitDodaj").click(function(){
                    $("#podaciLimitAgeAdd").slideUp("slow");
                 });
            },
            error:function(xhr,status,data){
                console.log(xhr.status + status);
            }
        });
    }
    
    //------------------- ISPIS LINKOVA MENIJA ---------------//
    function ispisiSveNavLinkove(){
        console.log("nAV MENI");
        $.ajax({
            url: urlDoAdmin + "models/menu/get_all.php",
            dataType:"json",
            method:"post",
            success:function(data){
                $(".podaciJedanLink").click(ispisiJedanNavLink);
                $("#sakrijFormuZaNav").click(function(){
                    $("#podaciNavEdit").slideUp("slow");
                 });
                $("#sakrijFormuZaNavDodaj").click(function(){
                    $("#podaciNavAdd").slideUp("slow");
                 });
            },
            error:function(xhr,status,data){
                console.log(xhr.status + status);
            }
        });
    }

//------------------- ISPIS KORISNIKA ---------------//
    function ispisiSveKorisnike(){
        console.log("korisnici");
        $.ajax({
            url: urlDoAdmin + "models/users/get_all.php",
            dataType:"json",
            method:"post",
            success:function(data){
                $(".obrisi").click(obrisiKorisnika);
                $(".podaciJedanKorisnik").click(ispisiJednogKorisnika);
    
                    $("#sakrijFormu").click(function(){
                        $("#podaci").slideUp("slow");
                     });
    
            },
            error:function(xhr,status,data){
                console.log(xhr.status + status);
                // alert("greska ispisSvih korisnika");
            }
        });
    }
    function obrisiKorisnika(e){
        var urlDoAdmin="https://flix-go4movies.000webhostapp.com/sajt-flixGo/";
        // alert("OBRISI");
        e.preventDefault();
        let poslati=confirm("Da li ste sigurni da zelite da obrisete korisnika?");
        let id=$(this).data("id");
            if(poslati){
                $.ajax({
                    url : urlDoAdmin+"models/users/delete.php",
                    method : "post",
                    data:{
                        id:id
                    },
                    success:function(data){
                        ispisiSveKorisnike();
                        window.location.reload();
                    },
                    error:function(xhr,status,data){
                        if(xhr.status==409){
                            $(".odgovorUpdate").html("Ne možete obrisati korisnika");
                        } 
                        else{
                            alert(xhr.status + status);
                        }
                    }
                });
             }
    }

    //---------------- PORUKE --------------------//
     function ispisiSvePoruke(){
        //  alert("Sve poruke");
        $.ajax({
             url: urlDoAdmin + "models/contact/get_all.php",
            dataType:"json",
            method:"post",
            success:function(data){
                $(".obrisi-poruku").click(obrisiPoruku);
                 $("#detalji-poruke").hide();
                $(".detalji-poruke").click(prikaziDetaljePoruke);
            },
            error:function(xhr,status,data){
                alert(xhr.status + status);
                alert("greska ispisSvih poruka");
            }
        }); 
     }

    function prikaziDetaljePoruke(e){
        //  alert("Detalji");
        e.preventDefault();
        let id=$(this).data("id");
            $.ajax({
               url: urlDoAdmin + "models/contact/get_one.php",
                dataType:"json",
                method:"post",
                data:{
                    id:id
                },
                success:function(data){
                   $("#detalji-poruke").hide();
                    $("#detalji-poruke").html(detaljiJednePorukeTabela(data))
                    $("#detalji-poruke").slideDown("slow");

                    $("#sakrijFormuSaDetaljimaPoruke").click(function(){
                        $("#detalji-poruke").slideUp("slow");
                    })
                },
                error:function(xhr,status,data){
                    alert(xhr.status + status);
                }
            });
       }
       function detaljiJednePorukeTabela(data){
        let ispis=`<div class="col-12">
					<div class="main__table-wrap">
						<table class="main__table detalji">
                                <tr>
									<td class="text-white">SENDER</td>
                                    <td>
										<div class="main__table-text">${data.email}</div>
									</td>
                                </tr>
                                <tr>
									<td class="text-white">SUBJECT</td>
                                    <td>
										<div class="main__table-text">${data.title}</div>
									</td>
                                </tr>
                                <tr>
									<td class="text-white">MESSAGE</td>
                                    <td>
										<div class="main__table-text main__table-text--green">${data.message}</div>
									</td>
                                </tr>
                                <tr>
									<td class="text-white">DATE OF SENT</td>
									<td>
										<div class="main__table-text">${data.date}</div>
									</td>
                                </tr>
						</table>
                        <button type="button" id="sakrijFormuSaDetaljimaPoruke"
                    class="btn btn-primary">Hide</button>
					</div>
				</div>`;
        return ispis;
       }
       function obrisiPoruku(e){
            var urlDoAdmin="https://flix-go4movies.000webhostapp.com/sajt-flixGo/";
            // alert("OBRISI");
            e.preventDefault();
            let poslati=confirm("Da li ste sigurni da zelite da obrisete poruku?");
            let id=$(this).data("id");
             if(poslati){
                $.ajax({
                     url : urlDoAdmin+"models/contact/delete.php",
                    method:"post",
                    data:{
                        id:id,
                    },
                    success:function(data){
                            // console.log(data);
                            ispisiSvePoruke()
                             window.location.reload();
                    },
                    error:function(xhr,status,data){
                            console.log(xhr.status + status);
                            ispisiSvePoruke()
                            window.location.reload();
                    }
                });
             }
       }
       
});

function ispisiAddFormuGenre(e){
    console.log("add")
    e.preventDefault();
    $("#podaciGenresAdd").slideDown("slow");
    $('html,body').animate({
        scrollTop: $("#podaciGenresAdd").offset().top
    },'fast');
}

function ispisiJedanZanr(e){
    var urlDoAdmin="https://flix-go4movies.000webhostapp.com/sajt-flixGo/";
    console.log("edit");
    e.preventDefault();
    $("#podaciGenresEdit").slideDown("slow");
    var id=$(this).data('id');
    console.log(id)
  
        $.ajax({
            url : urlDoAdmin+"models/genres/get_one.php",
            method : "post",
            data: {
                id:id
            },
            success : function(data) {
                console.log(data);
                console.log("Success");
                $("#tbNazivZanr").val(data.name);
                $("#skrivenoPoljeZanr").val(data.id_genre);
            },
            error : function(xhr, status, error) {
                switch(xhr.status){
                    case 404:
                        alert("Stranica nije pronadjena");
                        break;
                    case 500:
                        alert("Greska na serveru.Trenutno nije moguce azurirati podatke o zanrovima");
                        break;
                    default:
                        alert("Greska:"+xhr.status+"-"+status);
                        break;
                }

                console.log(xhr.status + status);
            }
        });

}


function ispisiAddFormuQuality(e){
    console.log("add")
    e.preventDefault();
    $("#podaciQualityAdd").slideDown("slow");
    $('html,body').animate({
        scrollTop: $("#podaciQualityAdd").offset().top
    },'fast');
}

function ispisiJedanQuality(e){
    var urlDoAdmin="https://flix-go4movies.000webhostapp.com/sajt-flixGo/";
    console.log("edit");
    e.preventDefault();
    $("#podaciQualityEdit").slideDown("slow");
    var id=$(this).data('id');
    console.log(id)
  
        $.ajax({
            url : urlDoAdmin+"models/quality/get_one.php",
            method : "post",
            data: {
                id:id
            },
            success : function(data) {
                console.log(data);
                console.log("Success");
                $("#tbNazivRezolucija").val(data.value);
                $("#skrivenoPoljeRezolucija").val(data.id_quality);
            },
            error : function(xhr, status, error) {
                switch(xhr.status){
                    case 404:
                        alert("Stranica nije pronadjena");
                        break;
                    case 500:
                        alert("Greska na serveru.Trenutno nije moguce azurirati podatke o zanrovima");
                        break;
                    default:
                        alert("Greska:"+xhr.status+"-"+status);
                        break;
                }

                console.log(xhr.status + status);
            }
        });

}


function ispisiAddFormuCountry(e){
    console.log("add")
    e.preventDefault();
    $("#podaciCountryAdd").slideDown("slow");
    $('html,body').animate({
        scrollTop: $("#podaciCountryAdd").offset().top
    },'fast');
}

function ispisiJednaDrzava(e){
    var urlDoAdmin="https://flix-go4movies.000webhostapp.com/sajt-flixGo/";
    console.log("edit");
    e.preventDefault();
    $("#podaciCountryEdit").slideDown("slow");
    var id=$(this).data('id');
    console.log(id)
  
        $.ajax({
            url : urlDoAdmin+"models/country/get_one.php",
            method : "post",
            data: {
                id:id
            },
            success : function(data) {
                console.log(data);
                console.log("Success");
                $("#tbNazivDrzava").val(data.name);
                $("#skrivenoPoljeDrzava").val(data.id_country);
            },
            error : function(xhr, status, error) {
                switch(xhr.status){
                    case 404:
                        alert("Stranica nije pronadjena");
                        break;
                    case 500:
                        alert("Greska na serveru.Trenutno nije moguce azurirati podatke o zanrovima");
                        break;
                    default:
                        alert("Greska:"+xhr.status+"-"+status);
                        break;
                }

                console.log(xhr.status + status);
            }
        });

}


function ispisiAddFormuLimitAge(e){
    console.log("add")
    e.preventDefault();
    $("#podaciLimitAgeAdd").slideDown("slow");
    $('html,body').animate({
        scrollTop: $("#podaciLimitAgeAdd").offset().top
    },'fast');
}

function ispisiJedanLimitAge(e){
    var urlDoAdmin="https://flix-go4movies.000webhostapp.com/sajt-flixGo/";
    console.log("edit");
    e.preventDefault();
    $("#podaciLimitAgeEdit").slideDown("slow");
    var id=$(this).data('id');
    console.log(id)
  
        $.ajax({
            url : urlDoAdmin+"models/limit-ages/get_one.php",
            method : "post",
            data: {
                id:id
            },
            success : function(data) {
                console.log(data);
                console.log("Success");
                $("#tbNazivLimit").val(data.value);
                $("#skrivenoPoljeLimit").val(data.id_limit_age);
            },
            error : function(xhr, status, error) {
                switch(xhr.status){
                    case 404:
                        alert("Stranica nije pronadjena");
                        break;
                    case 500:
                        alert("Greska na serveru.Trenutno nije moguce azurirati podatke o zanrovima");
                        break;
                    default:
                        alert("Greska:"+xhr.status+"-"+status);
                        break;
                }

                console.log(xhr.status + status);
            }
        });

}


function ispisiAddFormuNav(e){
    console.log("add")
    e.preventDefault();
    $("#podaciNavAdd").slideDown("slow");
    $('html,body').animate({
        scrollTop: $("#podaciNavAdd").offset().top
    },'fast');
}

function ispisiJedanNavLink(e){
    var urlDoAdmin="https://flix-go4movies.000webhostapp.com/sajt-flixGo/";
    console.log("edit");
    e.preventDefault();
    $("#podaciNavEdit").slideDown("slow");
    var id=$(this).data('id');
    console.log(id)
  
        $.ajax({
            url : urlDoAdmin+"models/menu/get_one.php",
            method : "post",
            data: {
                id:id
            },
            success : function(data) {
                console.log(data);
                console.log("Success");
                $("#tbNameNav").val(data.name);
                $("#skrivenoPoljeNavs").val(data.id_menu);
            },
            error : function(xhr, status, error) {
                switch(xhr.status){
                    case 404:
                        alert("Stranica nije pronadjena");
                        break;
                    case 500:
                        alert("Greska na serveru.Trenutno nije moguce azurirati podatke o zanrovima");
                        break;
                    default:
                        alert("Greska:"+xhr.status+"-"+status);
                        break;
                }

                console.log(xhr.status + status);
            }
        });

}


//---------- KORISNICI ---------------//


function ispisiJednogKorisnika(e){
    var urlDoAdmin="https://flix-go4movies.000webhostapp.com/sajt-flixGo/";
    console.log("edit");

    e.preventDefault();
    $("#podaci").slideDown("slow");
    var id=$(this).data('id');
    console.log(id);
        $.ajax({
            url : urlDoAdmin+"models/users/get_one.php",
            method : "post",
            dataType:"json",
            data:{
                id:id
            },
            success : function(data) {
                console.log("successfully updated user");
                console.log(data);
                $("#tbIme").val(data.name);
                $("#tbPrezime").val(data.surname);
                $("#tbEmail").val(data.email);
                $("#tbUsername").val(data.username);
                $("#ddlUloga").val(data.id_role);
                $("#skrivenoPolje").val(data.id_user);
            },
            error : function(xhr, status, error) {
                switch(xhr.status){
                    case 404:
                        alert("Stranica nije pronadjena");
                        break;
                    case 500:
                        alert("Greska na serveru.Trenutno nije moguce azurirati podatke o korisniku");
                        break;
                    default:
                        alert("Greska:"+xhr.status+"-"+status);
                        break;
                }
            }
        });

}