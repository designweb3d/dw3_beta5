<div style='width:100%;height:auto;text-align:left;padding:0;background-color:<?php echo $SECTION_BG; ?>;color:<?php echo $SECTION_FG; ?>;width:100%;text-align:center;margin:<?php echo $SECTION_MARGIN; ?>;display:inline-block;text-align:center;height:auto;border-radius:<?php echo $SECTION_RADIUS; ?>;max-width:<?php echo $SECTION_MAXW; ?>;box-shadow: <?php echo $SECTION_SHADOW; ?>;'>
    <?php 
        if ($SECTION_HTML_FR != ""){
            if ($USER_LANG == "FR"){
                echo "<div class='dw3_wide_view_parent'><div class='dw3_wide_view_div' style='line-height:1.5em;'>".$SECTION_HTML_FR."</div><div class='dw3_wide_view_div'>" ;
            } else {
                echo "<div class='dw3_wide_view_parent'><div class='dw3_wide_view_div' style='line-height:1.5em;'>".$SECTION_HTML_EN."</div><div class='dw3_wide_view_div'>" ;
            }
        }

    ?>
    <div id="slideshow4-container">
        <?php 
        $img_counter4 = 0;
        $dw3_sql = "SELECT * FROM slideshow WHERE index_id='".$SECTION_ID."' ORDER BY sort_by ASC, id ASC";
        $dw3_result = $dw3_conn->query($dw3_sql);
            if ($dw3_result->num_rows > 0) {
                while($row = $dw3_result->fetch_assoc()) {
                    $img_counter4++;
                    if ($img_counter4 == 1){
                        echo "<img src='".$row["media_link"]."' class='active'>";
                    } else {
                        echo "<img src='".$row["media_link"]."'>";
                    }
                }
            }
        ?>
        <?php if ($SECTION_HTML_FR != ""){ echo "</div></div>";} ?>
    </div>
</div>

<script>
const gallery = document.getElementById('slideshow4-container');
const images = gallery.getElementsByTagName('img');
let currentImageIndex = 0;

function nextImage() {
    if (images[currentImageIndex].clientHeight > 0){
        images[currentImageIndex].parentElement.style.minHeight = images[currentImageIndex].clientHeight + "px";
    }

  // Remove 'active' class from the current image
  images[currentImageIndex].classList.remove('active');

  // Increment index, loop back to the beginning if necessary
  currentImageIndex = (currentImageIndex + 1) % images.length;

  // Add 'active' class to the next image
  images[currentImageIndex].classList.add('active');
}

// Initial setup: show the first image
if (images[currentImageIndex].clientHeight > 0){
    images[currentImageIndex].parentElement.style.minHeight = images[currentImageIndex].clientHeight + "px";
}
images[currentImageIndex].classList.add('active');

// Set interval for automatic slideshow
setInterval(nextImage, 3000); // Change image every 3 seconds
</script>