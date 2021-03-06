<html>
<head><title><?=__('Kono is fetching your location')?></title></head>
<body>
<h1 style="display: block;width: 100%"><?=__('Kono is fetching your location...')?></h1>
<script type="text/javascript" src="/node_modules/geolocator/dist/geolocator.min.js"></script>
<script type="text/javascript">

    geolocator.config({
        language: "en",
        google: {
            version: "3",
            key: "<?= Yii::app()->params['google-api-key']?>"
        }
    });
    
    window.onload = function () {
        
        var options = {
            enableHighAccuracy: true,
            timeout: 5000,
            maximumWait: 10000,     // max wait time for desired accuracy
            maximumAge: 0,          // disable cache
            desiredAccuracy: 30,    // meters
            fallbackToIP: true,     // fallback to IP if Geolocation fails or rejected
            addressLookup: true,    // requires Google API key if true
            timezone: true,         // requires Google API key if true
            map: false,      // interactive map element id (or options object)
            staticMap: true         // map image URL (boolean or options object)
        };
        geolocator.locate(options, function (err, location) {
            if (err) return console.log(err);
            console.log(location);
            var frm = document.getElementById('floc');
            
            frm.elements['address'].value =JSON.stringify(location.address); 
            frm.elements['coords'].value =JSON.stringify(location.coords);
            frm.submit();
        });
    };

</script>
<form method="post" action="/" id="floc">
<input name="address" type="hidden"/>
<input name="coords" type="hidden"/>
</form>
<div id="map-canvas" style="width:600px;height:400px"></div>
</body>