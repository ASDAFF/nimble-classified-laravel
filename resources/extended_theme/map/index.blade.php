@extends('layouts.app')
@section('content')
    <style>
        #map {  margin-top: 0; height: 550px;  }
        .controls{  width: 50% !important; background-color: #eeeeee; color: black; padding: 5px; }
        .map_img{ height: 100px; width: 130px; }
        #map-canvas {
            margin: 0;
            padding: 0;
            height: 400px;
            max-width: none;
        }
        #map-canvas img {
            max-width: none !important;
        }
        .gm-style-iw {
            width: 350px !important;
            top: 15px !important;
            left: 0px !important;
            background-color: #fff;
            box-shadow: 0 1px 6px rgba(178, 178, 178, 0.6);
            border: 1px solid rgba(72, 181, 233, 0.6);
            border-radius: 2px 2px 10px 10px;
        }
        #iw-container {
            margin-bottom: 10px;
        }
        #iw-container .iw-title {
            font-family: 'Open Sans Condensed', sans-serif;
            font-size: 22px;
            font-weight: 400;
            padding: 10px;
            background-color: #48b5e9;
            color: white;
            margin: 0;
            border-radius: 2px 2px 0 0;
        }
        #iw-container .iw-content {
            font-size: 13px;
            font-weight: 400;
            margin-right: 1px;
            padding: 15px 5px 20px 15px;
            max-height: 140px;
            overflow-y: auto;
            overflow-x: hidden;
        }
        #iw-container .iw-content p{
            margin: 0;
            padding: 0;
        }
        .iw-content img {
            float: right;
            width: 50%;
            margin: 0 5px 5px 10px;
        }
        .iw-subTitle {
            font-size: 16px;
            font-weight: 700;
            padding: 5px 0;
        }
        .iw-bottom-gradient {
            position: absolute;
            width: 326px;
            height: 25px;
            bottom: 10px;
            right: 18px;
            background: linear-gradient(to bottom, rgba(255,255,255,0) 0%, rgba(255,255,255,1) 100%);
            background: -webkit-linear-gradient(top, rgba(255,255,255,0) 0%, rgba(255,255,255,1) 100%);
            background: -moz-linear-gradient(top, rgba(255,255,255,0) 0%, rgba(255,255,255,1) 100%);
            background: -ms-linear-gradient(top, rgba(255,255,255,0) 0%, rgba(255,255,255,1) 100%);
        }
        .link{
            color: inherit;
        }
        .link:hover{ text-decoration: none}

    </style>
    <section id="main" class="clearfix ">
        <div class="container">
            <div class="main-container m-t-30">
                <div class="container section">
                    <div class="row">
                       <div class="col-md-12">
                               <h4 class="card-title"><b>Search locations to view Listings</b></h4>
                           <div class="form-group">
                               <input id="pac-input" type="text" class="form-control controls" placeholder="Search Location">
                           </div>

                           <div id="map"></div>
                           <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script type="text/javascript">
        var markers = [
            {!! $marker !!}
        ];
        function initMap() {
            var mapOptions = {
                center: new google.maps.LatLng(markers[0].lat, markers[0].lng),
                zoom: 3,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };
            var map = new google.maps.Map(document.getElementById("map"), mapOptions);


            // Create the search box and link it to the UI element.
            var input = document.getElementById('pac-input');
            var searchBox = new google.maps.places.SearchBox(input);
            map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

            // Bias the SearchBox results towards current map's viewport.
            map.addListener('bounds_changed', function() {
                searchBox.setBounds(map.getBounds());
            });

            searchBox.addListener('places_changed', function() {
                var places = searchBox.getPlaces();

                if (places.length == 0) {
                    return;
                }


                markers = [];

                // For each place, get the icon, name and location.
                var bounds = new google.maps.LatLngBounds();
                places.forEach(function(place) {
                    if (!place.geometry) {
                        console.log("Returned place contains no geometry");
                        return;
                    }

                    if (place.geometry.viewport) {
                        // Only geocodes have viewport.
                        bounds.union(place.geometry.viewport);
                    } else {
                        bounds.extend(place.geometry.location);
                    }
                });
                map.fitBounds(bounds);
            });

            //Create and open InfoWindow.
            var infoWindow = new google.maps.InfoWindow();

            for (var i = 0; i < markers.length; i++) {
                var data = markers[i];
                var myLatlng = new google.maps.LatLng(data.lat, data.lng);
                var marker = new google.maps.Marker({
                    position: myLatlng,
                    map: map,
                    title: data.title,
                    icon: "{{asset('assets/images/map-marker.png')}}"
                });

                //Attach click event to the marker.
                (function (marker, data) {
                    google.maps.event.addListener(marker, "click", function (e) {
                        //Wrap the content inside an HTML DIV in order to set height and width of InfoWindow.
                        infoWindow.setContent('<div id="iw-container">' +
                            '<a class="link" href="'+data.href+'">'+
                            '<div class="iw-title">'+ data.title +'</div>' +
                            '<div class="iw-content">' +
                            '<div class="iw-subTitle">Description @if(DB::table('setting')->value('hide_price') == 0) <span class="pull-right">'+data.price+'</span> @endif </div>' +
                            '<img src="'+data.image+'" alt="Porcelain Factory of Vista Alegre" height="115" width="83">' +
                            '<p>'+ data.description +'</p>' +
                            '<div class="iw-subTitle">Contacts</div>' +
                            '<p><strong>Address:</strong> '+data.address+'</p>'+
                            '<p><strong>Phone:</strong> '+data.phone+'</p>'+
                            '</div>' +
                            '<div class="iw-bottom-gradient"></div>' +
                            '</div></a>');
                        infoWindow.open(map, marker);
                    });

                    google.maps.event.addListener(infoWindow, 'domready', function() {
                        // Reference to the DIV that wraps the bottom of infowindow
                        var iwOuter = $('.gm-style-iw');
                        /* Since this div is in a position prior to .gm-div style-iw.
                         * We use jQuery and create a iwBackground variable,
                         * and took advantage of the existing reference .gm-style-iw for the previous div with .prev().
                        */
                        var iwBackground = iwOuter.prev();
                        // Removes background shadow DIV
                        iwBackground.children(':nth-child(2)').css({'display' : 'none'});
                        // Removes white background DIV
                        iwBackground.children(':nth-child(4)').css({'display' : 'none'});
                        // Reference to the div that groups the close button elements.
                        var iwCloseBtn = iwOuter.next();
                        // Apply the desired effect to the close button
                        iwCloseBtn.css({width: '18px',height: '18px', opacity: '1', right: '38px', top: '3px', border: '2px solid #48b5e9', 'border-radius': '13px', 'box-shadow': '0 0 5px #3990B9'});

                        // If the content of infowindow not exceed the set maximum height, then the gradient is removed.
                        if($('.iw-content').height() < 140){
                            $('.iw-bottom-gradient').css({display: 'none'});
                        }

                        // The API automatically applies 0.7 opacity to the button after the mouseout event. This function reverses this event to the desired value.
                        iwCloseBtn.mouseout(function(){
                            $(this).css({opacity: '1'});
                        });
                    });



                })(marker, data);
            }
        }
    </script>

<script async defer  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCAwX5DJjr0fC7_vp6_WVO6Ut16hXTuK1g&libraries=places&callback=initMap"></script>

@endsection