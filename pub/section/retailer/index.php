<?php 
if (isset($_SERVER['HTTP_SECTION_ID'])) {header("SECTION_ID:".$_SERVER['HTTP_SECTION_ID']);}
require_once $_SERVER['DOCUMENT_ROOT'] . '/pub/section/loader.min.php';
$cat_lst = $_GET['P1'];
?>

<div id="map" style='width:100%;height:400px;'></div>

<script>
// Initialize and add the map
    let map;

    async function initMap() {
    // The location of Uluru
    const position = { lat: -25.344, lng: 131.031 };
    // Request needed libraries.
    //@ts-ignore
    const { Map } = await google.maps.importLibrary("maps");
    const { AdvancedMarkerView } = await google.maps.importLibrary("marker");

    // The map, centered at Uluru
    map = new Map(document.getElementById("map"), {
        zoom: 4,
        center: position,
        mapId: "<?php echo $CIE_GMAP_MAP; ?>",
    });

    // The marker, positioned at Uluru
    const marker = new AdvancedMarkerView({
        map: map,
        position: position,
        title: "Uluru",
    });
    }

    initMap();
</script>

<?php if ($CIE_GMAP_KEY!=""){ ?>
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $CIE_GMAP_KEY; ?>&callback=initMap"></script>
<?php } ?>