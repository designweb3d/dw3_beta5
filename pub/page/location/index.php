<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/loader.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/pub/section/header_main.php';
require_once $_SERVER['DOCUMENT_ROOT'] . $PAGE_HEADER;
require_once $_SERVER['DOCUMENT_ROOT'] . '/pub/section/common_div.php';
 if ($PAGE_HEADER== '/pub/section/header0.php'){$INDEX_HEADER_HEIGHT = '70';}
 else if ($PAGE_HEADER== '/pub/section/header1.php'){$INDEX_HEADER_HEIGHT = '120';}
 else if ($PAGE_HEADER== '/pub/section/header2.php'){$INDEX_HEADER_HEIGHT = '105';}
 else if ($PAGE_HEADER== '/pub/section/header3.php'){$INDEX_HEADER_HEIGHT = '100';}
 else if ($PAGE_HEADER== '/pub/section/header4.php'){$INDEX_HEADER_HEIGHT = '100';}
 else if ($PAGE_HEADER== '/pub/section/header5.php'){$INDEX_HEADER_HEIGHT = '102';}
 else if ($PAGE_HEADER== '/pub/section/header6.php'){$INDEX_HEADER_HEIGHT = '70';}
 else if ($PAGE_HEADER== '/pub/section/header7.php'){$INDEX_HEADER_HEIGHT = '105';}
 else if ($PAGE_HEADER== '/pub/section/header8.php'){$INDEX_HEADER_HEIGHT = '100';}
 else if ($PAGE_HEADER== '/pub/section/header9.php'){$INDEX_HEADER_HEIGHT = '70';}
 else if ($PAGE_HEADER== '/pub/section/header10.php'){$INDEX_HEADER_HEIGHT = '70';}
 else if ($PAGE_HEADER== '/pub/section/header11.php'){$INDEX_HEADER_HEIGHT = '70';}
 else if ($PAGE_HEADER== '/pub/section/header12.php'){$INDEX_HEADER_HEIGHT = '82';}
 else if ($PAGE_HEADER== '/pub/section/header13.php'){$INDEX_HEADER_HEIGHT = '70';}
 else if ($PAGE_HEADER== '/pub/section/header14.php'){$INDEX_HEADER_HEIGHT = '100';}
 else if ($PAGE_HEADER== '/pub/section/header15.php'){$INDEX_HEADER_HEIGHT = '100';}
 else if ($PAGE_HEADER== '/pub/section/header16.php'){$INDEX_HEADER_HEIGHT = '100';}
 else if ($PAGE_HEADER== '/pub/section/header17.php'){$INDEX_HEADER_HEIGHT = '100';}
 else if ($PAGE_HEADER== '/pub/section/header18.php'){$INDEX_HEADER_HEIGHT = '90';}
 else if ($PAGE_HEADER== '/pub/section/header19.php'){$INDEX_HEADER_HEIGHT = '100';}
 else if ($PAGE_HEADER== '/pub/section/header20.php'){$INDEX_HEADER_HEIGHT = '90';}
 else if ($PAGE_HEADER== '/pub/section/header21.php'){$INDEX_HEADER_HEIGHT = '90';}
 else if ($PAGE_HEADER== '/pub/section/header21.php'){$INDEX_HEADER_HEIGHT = '70';}
 else {$INDEX_HEADER_HEIGHT='70';}
echo "<div style='height:".$INDEX_HEADER_HEIGHT."px;'></div>";
    if ($PAGE_IMG != ""){
        echo "<div style=\"text-align:center;background-repeat:no-repeat;background-image:url('/pub/upload/".$PAGE_IMG."');background-size:cover;background-position: center;\">
        <div style='font-family:Teko, Helvetica, Arial, Lucida, sans-serif;display:inline-block;width:90%;height:100%;background-image: linear-gradient(rgba(0,0,0,0.4) 0%, rgba(0,0,0,0) 70%);color:white;'>
        ";
        if($USER_LANG == "FR"){
          if($PAGE_HTML_FR == ""){
            echo "<div style='margin-top:25%;margin-bottom:25%;display:inline-block;font-weight: 500;text-align:left;width:80%;font-size:9vw;text-transform: uppercase;text-shadow: 0em 0.38em 0.27em rgba(0, 0, 0, 0.68);'>".$PAGE_TITLE."</div>";
          }else{
            echo $PAGE_HTML_FR;
          }
        }else {
          if($PAGE_HTML_EN == ""){
            echo "<div style='margin-top:25%;margin-bottom:25%;display:inline-block;font-weight: 500;text-align:left;width:80%;font-size:9vw;text-transform: uppercase;text-shadow: 0em 0.38em 0.27em rgba(0, 0, 0, 0.68);'>".$PAGE_TITLE_EN."</div>";
          } else {
            echo $PAGE_HTML_EN;
          }
        }
        echo"</div></div>";
    }
 ?>
<div style='width:100%;text-align:center;background-color:#FFF;'>
    <div style='display:inline-block;max-width:1080px;'>
        <div id="map" style='visibility:hidden;width:100%;height:400px;border:0px;'></div>
        <div ><input type="text" onkeyup="dw3_table_filter(this,'tbl_location')" placeholder="<?php if($USER_LANG == "FR"){echo "Chercher une location.."; }else{echo "Search a retailer..";}?>">
        <?php 
            $sql = "SELECT * FROM location WHERE allow_pickup = 1 and stat = 0 and longitude <> '' and latitude <> '' ORDER BY name";   
            $MarkerLink = 0;
            $result = $dw3_conn->query($sql);
            echo  '<div style="max-width:1080px;"><table id="tbl_location" class="tblSEL2">';
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo '<tr><td onclick="ListClickInfoWindow(\''.$MarkerLink.'\');" style="font-family: Montserrat, Helvetica, Arial, Lucida, sans-serif;font-size:14px;font-weight:bold;vertical-align:top;">'. $row['name'] .'<br>'. $row["tel1"] .'</td>
                    <td  onclick="ListClickInfoWindow(\''.$MarkerLink.'\');"style="vertical-align:top;font-family: Montserrat, Helvetica, Arial, Lucida, sans-serif;font-size:14px;">'.$row['adr1'].' '.$row['city'].' '.$row['province'].' '.$row['country'].' '.$row['postal_code'].'<br>'. $row["web"] .'</td>
                    <td style="width:35px;vertical-align:top;font-family: Montserrat, Helvetica, Arial, Lucida, sans-serif;font-size:14px;">
                    <br><button class="no-effect blue" onclick="dw3_set_loc('.$row['id'].')">Choisir</button>
                    </td></tr>';
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
//var CART = <?php if(isset($_COOKIE["CART"])) { echo $_COOKIE["CART"]; }  else {echo "[]";} ?>;

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
    $sql = "SELECT * FROM location WHERE allow_pickup = 1 and stat = 0 and longitude <> '' and latitude <> '' ORDER BY name";
    $result = $dw3_conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $web_url = strtolower(trim($row["web"]));
            if (substr($web_url,0,4)!= "http" && $web_url!=""){
              $web_url = "https://".$web_url;
            }
            echo '{
                position: {lat: '.$row["latitude"].', lng: '.$row["longitude"].'},
                title: "<div style=\'position:absolute;top:5px;right:5px;background-color:#fff;z-index:+1;cursor:pointer;\' onclick=\'infoWindow.close()\'> X </div><div style=\'text-align:left;margin:0px 10px 10px 10px;box-shadow:0px 0px 5px 5px white;\'><strong>'.$row["name"].'</strong><br><div style=\'height:10px;\'></div>'.$row["adr1"].', '.$row["city"].'<br>'.$row["province"].', '.$row["country"].' '.$row["postal_code"].'<br><a href=\'tel:'.$row["tel1"].'\' style=\'color:darkblue;\'>'.$row["tel1"].'</a><br><div style=\'\'><a href=\''.$web_url.'\' target=\'_blank\' style=\'color:darkred;\'>'.$row["web"].'</a></div><button class=\'no-effect\' onclick=\'dw3_set_loc('.$row['id'].')\' style=\'margin-bottom:10px;float:right;\'>Choisir</button></div>"
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
    image.src = "https://<?php echo $_SERVER['SERVER_NAME']; ?>/pub/img/dw3/map_pin.png";
    image.style.height = "25px";
    image.style.width = "25px";
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

function dw3_set_loc(loc_id) {
    if (KEY != "" && USER_TYPE != "USER" && USER_TYPE != "nd"){
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.open('GET', '/pub/page/set_loc.php?KEY=' + KEY + '&ID=' + loc_id , true);
        xmlhttp.send();
    }
    var myDate = new Date();
    myDate.setMonth(myDate.getMonth() + 12);
    document.cookie = "STORE="+loc_id+";expires=" + myDate +";path=/;domain=.<?php echo $_SERVER['SERVER_NAME']; ?>;";
    //dw3_msg_close();
/*     if (document.getElementById('dw3_loc_span')) {
        document.getElementById('dw3_loc_span').innerHTML = "<a href='/pub/page/location/index.php'><div style='border-radius:5px;color:#<?php echo $CIE_COLOR9; ?>'>Magasin préféré: " + loc_name + "</div></a>";
    } */
        document.getElementById("dw3_msg").style.display = "inline-block";
        document.getElementById("dw3_body_fade").style.display = "inline-block";
        document.getElementById("dw3_body_fade").style.opacity = "0.6";
        if (USER_LANG == "FR"){
            document.getElementById("dw3_msg").innerHTML = "<strong>Votre magasin préféré a été modifié.</strong><div style='height:20px;'> </div><button onclick=\"dw3_msg_close();window.open('/client','_self');\"><span class='dw3_font'>)</span><br>Accèder à mon compte</button><button onclick=\"dw3_msg_close();window.open('/','_self');\"><span class='dw3_font'>!</span><br>Aller à l'accueil</button>";
        } else {
            document.getElementById("dw3_msg").innerHTML = "<strong>Your favorite store as been saved.</strong><div style='height:20px;'> </div><button onclick=\"dw3_msg_close();window.open('/client','_self');\"><span class='dw3_font'>)</span><br>Access my account</button><button onclick=\"dw3_msg_close();window.open('/','_self');\"><span class='dw3_font'>!</span></br>Go to to home page</button>";
        }
    /* setTimeout(() => {
        location.reload();
        return false;
    }, "1500"); */
    //dw3_notif_add("Votre magasin préféré a été modifié.");
}

function ListClickInfoWindow(id){
    document.getElementById('map').scrollIntoView({
        block: 'center',
        behavior: 'smooth'
    });
        google.maps.event.trigger(markers[id], 'click');
}

//$(document).ready(function (){
    document.getElementById("dw3_body").innerHTML = "";
    document.getElementsByTagName("body")[0].style.background = "#FFF";
    bREADY = true;
    let infoWindow;
    
//});

</script>
<?php if ($CIE_GMAP_KEY!=""){ ?>
    <script>(g=>{var h,a,k,p="The Google Maps JavaScript API",c="google",l="importLibrary",q="__ib__",m=document,b=window;b=b[c]||(b[c]={});var d=b.maps||(b.maps={}),r=new Set,e=new URLSearchParams,u=()=>h||(h=new Promise(async(f,n)=>{await (a=m.createElement("script"));e.set("libraries",[...r]+"");for(k in g)e.set(k.replace(/[A-Z]/g,t=>"_"+t[0].toLowerCase()),g[k]);e.set("callback",c+".maps."+q);a.src=`https://maps.${c}apis.com/maps/api/js?`+e;d[q]=f;a.onerror=()=>h=n(Error(p+" could not load."));a.nonce=m.querySelector("script[nonce]")?.nonce||"";m.head.append(a)}));d[l]?console.warn(p+" only loads once. Ignoring:",g):d[l]=(f,...n)=>r.add(f)&&u().then(()=>d[l](f,...n))})
        ({key: "<?php echo $CIE_GMAP_KEY; ?>", v: "beta"});
    initMap();    
    </script>
<?php } ?>
<?php 
    require_once $_SERVER['DOCUMENT_ROOT'] . $INDEX_FOOTER;
    exit; 
?>