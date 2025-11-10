<?php 



//USE /page/location/index.php INSTEAD FOR NOW



 require_once $_SERVER['DOCUMENT_ROOT'] . '/pub/page/loader.php';
 require_once $_SERVER['DOCUMENT_ROOT'] . $SECTION_HEADER;
 require_once $_SERVER['DOCUMENT_ROOT'] . '/pub/section/common_div.php';
 $dw3_sections = json_decode($dw3_section, TRUE);
 
 require_once $_SERVER['DOCUMENT_ROOT'] . "/pub/page/page.js.php"; 
    if ($SECTION_IMG != ""){
        echo "<div style=\"text-align:center;background-repeat:no-repeat;background-image:url('/pub/upload/".$SECTION_IMG."');background-size:cover;background-position: center;\">
        <div style='font-family:Teko, Helvetica, Arial, Lucida, sans-serif;display:inline-block;width:90%;height:100%;background-image: linear-gradient(rgba(0,0,0,0.4) 0%, rgba(0,0,0,0) 70%);color:white;'>
        ";
        if($USER_LANG == "FR"){
          if($SECTION_HTML_FR == ""){
            echo "<div style='margin-top:25%;margin-bottom:25%;display:inline-block;font-weight: 500;text-align:left;width:80%;font-size:9vw;text-transform: uppercase;text-shadow: 0em 0.38em 0.27em rgba(0, 0, 0, 0.68);'>".$SECTION_TITLE."</div>";
          }else{
            echo $SECTION_HTML_FR;
          }
        }else {
          if($SECTION_HTML_EN == ""){
            echo "<div style='margin-top:25%;margin-bottom:25%;display:inline-block;font-weight: 500;text-align:left;width:80%;font-size:9vw;text-transform: uppercase;text-shadow: 0em 0.38em 0.27em rgba(0, 0, 0, 0.68);'>".$SECTION_TITLE_EN."</div>";
          } else {
            echo $SECTION_HTML_EN;
          }
        }
        echo"</div></div>";
    }
 ?>
<div style='width:100%;text-align:center;background-color:#FFF;'>
    <div style='display:inline-block;max-width:1080px;'>
        <div id="map" style='visibility:hidden;width:100%;height:400px;border:0px;'></div>
        <div ><input type="text" onkeyup="dw3_table_filter(this,'tbl_retailers')" placeholder="<?php if($USER_LANG == "FR"){echo "Chercher un détaillant.."; }else{echo "Search a retailer..";}?>">
        <?php 
            $sql = "SELECT * FROM customer WHERE type='RETAILER' and stat = 0 and longitude <> '' and latitude <> '' ORDER BY company";   

        $MarkerLink = 0;
        $result = $dw3_conn->query($sql);
        echo  '<div style="max-width:1080px;"><table id="tbl_retailers" class="tblSEL2">';
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                if (substr($row['web'],0,4) != "http"){$weblink = "https://".$row['web'];}else{$weblink = $row['web'];}
                echo '<tr onclick="ListClickInfoWindow('.$MarkerLink.')"><td style="font-family: Montserrat, Helvetica, Arial, Lucida, sans-serif;font-size:14px;font-weight:bold;vertical-align:top;">'. $row['company'] .'</td>
                <td style="vertical-align:top;font-family: Montserrat, Helvetica, Arial, Lucida, sans-serif;font-size:14px;">'.dw3_decrypt($row['adr1']).' '.$row['city'].' '.$row['province'].' '.$row['counter'].' '.$row['postal_code'].'</td>
                <td style="vertical-align:top;font-family: Montserrat, Helvetica, Arial, Lucida, sans-serif;font-size:14px;">'.dw3_decrypt($row['tel1']).'<br><a href="'.$weblink.'" style="color:red;" target="_blank">'.$row['web'].'</a></td></tr>';
                $MarkerLink++;
            }
        }
        echo "</table>";
        ?>
            <span style='visibility:hidden'>If you wish to purchase a vehicle or spare parts, please note that you must absolutely go through one of our retailers, we do not do direct sales.</span>
        </div>
    </div>
</div>
<script>
$(document).ready(function (){
    document.getElementById("dw3_body").innerHTML = "";
    document.getElementsByTagName("body")[0].style.background = "#FFF";
    bREADY = true;
    let infoWindow;
    initMap();
});
var CART = <?php if(isset($_COOKIE["CART"])) { echo $_COOKIE["CART"]; }  else {echo "[]";} ?>;

// Initialize and add the map
let map;
var markers = [];

async function initMap() {
  // Request needed libraries.
  const { Map, InfoWindow } = await google.maps.importLibrary("maps");
  const { AdvancedMarkerElement, PinElement } = await google.maps.importLibrary(
    "marker",
  );
  const map = new Map(document.getElementById("map"), {
    zoom: 4,
    center: { lat:52, lng:-94 },
    mapId: "<?php echo $CIE_GMAP_MAP; ?>",
  });
  
  
/*     var country = "Canada";
    var geocoder = new google.maps.Geocoder();

    geocoder.geocode( {'address' : country}, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            map.setCenter(results[0].geometry.location);
        }
    }); */

  if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(
        (position) => {
          const pos = {
            lat: position.coords.latitude,
            lng: position.coords.longitude,
          };
          map.setCenter(pos);
          map.setZoom(7);
          setTimeout(() => {
            document.getElementById("map").style.visibility= "visible";
            }, 2000);
        },
        () => {
            setTimeout(() => {
            document.getElementById("map").style.visibility= "visible";
            }, 2000);
          //handleLocationError(true, infoWindow, map.getCenter());
        }
      );
    }

  // Set LatLng and title text for the markers. The first marker (Boynton Pass)
  // receives the initial focus when tab is pressed. Use arrow keys to
  // move between markers; press tab again to cycle through the map controls.
  const tourStops = [
    <?php
    $sql = "SELECT * FROM customer WHERE type='RETAILER' and stat = 0 and longitude <> '' and latitude <> '' ORDER BY company";
    $result = $dw3_conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
          if (substr($row['web'],0,4) != "http"){$weblink = "https://".$row['web'];}else{$weblink = $row['web'];}
            echo '{
                position: {lat: '.$row["latitude"].', lng: '.$row["longitude"].'},
                title: "<div style=\'position:absolute;top:5px;right:5px;background-color:#fff;z-index:+1;cursor:pointer;\' onclick=\'infoWindow.close()\'> X </div><div style=\'text-align:left;margin:0px 10px 10px 10px;box-shadow:0px 0px 5px 5px white;\'><strong>'.$row["company"].'</strong><br><div style=\'height:10px;\'></div>'.dw3_decrypt($row["adr1"]).', '.$row["city"].'<br>'.$row["province"].', '.$row["country"].' '.$row["postal_code"].'<br><a href=\'tel:'.dw3_decrypt($row["tel1"]).'\'>'.dw3_decrypt($row["tel1"]).'</a><br><div style=\'height:10px;\'></div><a href=\''.$weblink.'\' style=\'color:red;\' target=\'_blank\'>'.$row["web"].'</a></div><div style=\'position:absolute;bottom:6px;right:0px;left:0px;background-color:#fff;z-index:+1;\'></div>"
            },';
        }
    } 

    
    ?>
  ];
  // Create an info window to share between markers.
    infoWindow = new InfoWindow();
  // Create the markers.
  tourStops.forEach(({ position, title }, i) => {
    const pin = new PinElement({
      glyph: `${i + 1}`,
      scale: 1.5,
    });
    const image = document.createElement("img");
    image.src = "https://<?php echo $_SERVER['SERVER_NAME']; ?>/pub/upload/gmap_marker.png";
    markers[i] = new AdvancedMarkerElement({
      position,
      map,
      title: `${title}`,
      content: image,
      
    });

    // Add a click listener for each marker, and set up the info window.
    markers[i].addListener("click", () => {
      //const { target } = domEvent;
      infoWindow.setContent(markers[i].title);
      infoWindow.open(markers[i].map, markers[i]);
      setTimeout(() => {
        document.getElementsByClassName('gm-ui-hover-effect')[0].remove();
        //document.getElementsByClassName('gm-style-iw')[0].style.border = "0px";
        document.getElementsByClassName('gm-style-iw')[0].style.overflow="hidden";
        document.getElementsByClassName('gm-style-iw-d')[0].style.overflow="hidden";
        document.getElementsByClassName('gm-style-iw')[0].style.maxWidth="350px";
        document.getElementsByClassName('gm-style-iw-c')[0].style.maxWidth="350px";
        document.getElementsByClassName('gm-style-iw-d')[0].style.maxHeight="300px";
        document.getElementsByClassName('gm-style-iw')[0].style.padding="0px";
        document.getElementsByClassName('gm-style-iw')[0].style.border="0px";
        document.getElementsByClassName('gm-style-iw-c')[0].style.padding="0px";
        document.getElementsByClassName('gm-style-iw-d')[0].style.padding="0px";
        document.getElementsByClassName('gm-style-iw-c')[0].style.border="0px";
        document.getElementsByClassName('gm-style-iw-d')[0].style.border="0px";
        //document.getElementsByClassName('gm-ui-hover-effect')[0].style.right="0px";
        //document.getElementsByClassName('gm-ui-hover-effect')[0].style.width="20px";
        }, 10);
    });
  });
}

function ListClickInfoWindow(id){
    document.getElementById('map').scrollIntoView({
        block: 'center',
        behavior: 'smooth'
    });
        google.maps.event.trigger(markers[id], 'click');
}

//window.initMap = initMap;

</script>
<?php if ($CIE_GMAP_KEY!=""){ ?>
    <script>(g=>{var h,a,k,p="The Google Maps JavaScript API",c="google",l="importLibrary",q="__ib__",m=document,b=window;b=b[c]||(b[c]={});var d=b.maps||(b.maps={}),r=new Set,e=new URLSearchParams,u=()=>h||(h=new Promise(async(f,n)=>{await (a=m.createElement("script"));e.set("libraries",[...r]+"");for(k in g)e.set(k.replace(/[A-Z]/g,t=>"_"+t[0].toLowerCase()),g[k]);e.set("callback",c+".maps."+q);a.src=`https://maps.${c}apis.com/maps/api/js?`+e;d[q]=f;a.onerror=()=>h=n(Error(p+" could not load."));a.nonce=m.querySelector("script[nonce]")?.nonce||"";m.head.append(a)}));d[l]?console.warn(p+" only loads once. Ignoring:",g):d[l]=(f,...n)=>r.add(f)&&u().then(()=>d[l](f,...n))})
        ({key: "<?php echo $CIE_GMAP_KEY; ?>", v: "beta"});</script>
<?php } ?>
<?php 
    require_once $_SERVER['DOCUMENT_ROOT'] . $INDEX_FOOTER;
    exit; 
?>