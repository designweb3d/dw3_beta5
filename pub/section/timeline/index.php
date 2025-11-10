<?php
/** https://infotronix.ca/profil
 +---------------------------------------------------------------------------------+
 |  All Rights Reserved                                                            |
 |  Copyright © 2023 Infotronix                                                    | 
 +---------------------------------------------------------------------------------+
 | Author: Julien Béliveau <info@dw3.ca>                                           |
 +---------------------------------------------------------------------------------+*/
 require_once $_SERVER['DOCUMENT_ROOT'] . '/index_header.php';
?>
<!-- MAIN --> 
<div class='content'><br><br>
    <!-- QUI SOMMES-NOUS --> 
    <div class='paragraf4' style='margin:15px;display:inline-block;text-align:left;line-height:30px;color:#666;vertical-align:top;'>
        <div style='font-size:2em;'><?php echo $txtProfil1; ?><br style='content: "";display: block;margin-top:-20px;'><div style="display:inline-block;width:50px;height:5px;border-radius:2px;background:#f17144;"> </div></div>
        <div style='padding-top:10px;'><?php echo $txtProfil2; ?></div>
    </div>
    <div class='paragraf4' style='margin:60px 15px 15px 15px;display:inline-block;text-align:left;line-height:30px;color:#666;vertical-align:top;'>
        <?php echo $txtProfil3; ?>        <br>
            <br>
    </div>
    <!-- MISSION --> 
    <div class='fixed-bg' style='width:100%;float:right;'>
        <div style='width:100%;background-color:rgba(0,25,70,0.75);color:#fff;'>
            <h2 style='padding:42px 0px 0px 0px;text-align:center;letter-spacing:.2rem;'>Mission</h2>
            <div style='width:100%;text-align:center;margin-bottom:20px;'>
                <div style="display:inline-block;width:50px;height:5px;border-radius:2px;background:#f17144;"> </div>
            </div>
            <div style='line-height: 180%;padding:10px 30px 20px 30px;text-align:left;max-width:1020px;display:inline-block;'><?php echo $txtProfil4; ?></div>
            <br>
            <br>
        </div>
    </div>
    <!-- VALEURS --> 
    <br><div style='width:100%;font-size:2em;'><div style='display:inline-block;max-width:1020px;text-align:left;width:95%;margin-top:40px;'><?php echo $txtProfil5; ?><br style='content: "";display: block;margin-top:-20px;'><div style="display:inline-block;width:40px;height:5px;border-radius:2px;background:#f17144;"> </div></div></div>
    <div class='paragraf2' style='max-width:1020px;margin:15px;display:inline-block;text-align:left;line-height:30px;color:#666;vertical-align:top;'>
        <?php echo $txtProfil6; ?>
    </div>
    <!-- HISTORIQUE -->
    <div style='width:100%;float:right;'>
        <section class="cd-horizontal-timeline">
        <div style='width:100%;font-size:2em;'><div style='display:inline-block;text-align:center;width:100%;margin-top:20px;'><?php echo $txtProfil7; ?><br style='content: "";display: block;margin-top:-20px;'><div style="display:inline-block;width:40px;height:5px;border-radius:2px;background:#f17144;"> </div></div></div>
        <div class='paragraf2' style='margin:15px;display:inline-block;max-width:1020px;text-align:left;line-height:30px;color:#fff;vertical-align:top;'>
            <?php echo $txtProfil8; ?>        
            <br><br>
        </div>
            <div class="timeline">
                <div class="events-wrapper">
                    <div class="events">
                        <ol>
                            <li><a href="#0" data-date="01/01/2020" class="selected"><?php echo $txtProfil9Date1; ?> </a></li>
                            <li><a href="#0" data-date="01/01/2019">Sept 2019</a></li>
                            <li><a href="#0" data-date="01/01/2018"><?php echo $txtProfil9Date2; ?></a></li>
                            <li><a href="#0" data-date="01/01/2017"><?php echo $txtProfil9Date3; ?></a></li>
                            <li><a href="#0" data-date="01/01/2016"><?php echo $txtProfil9Date4; ?></a></li>
                            <li><a href="#0" data-date="01/01/2015">2012</a></li>
                            <li><a href="#0" data-date="01/01/2014"><?php echo $txtProfil9Date5; ?></a></li>
                            <li><a href="#0" data-date="01/01/2013"><?php echo $txtProfil9Date6; ?></a></li>
                            <li><a href="#0" data-date="01/01/2012"><?php echo $txtProfil9Date7; ?></a></li>
                            <li><a href="#0" data-date="01/01/2011"><?php echo $txtProfil9Date8; ?></a></li>
                            <li><a href="#0" data-date="01/01/2010"><?php echo $txtProfil9Date9; ?></a></li>
                            <li><a href="#0" data-date="01/01/2009">Sept 1999</a></li>
                            <li><a href="#0" data-date="01/01/2008">Jan 1998</a></li>
                            <li><a href="#0" data-date="01/01/2007"><?php echo $txtProfil9Date10; ?></a></li>
                            <li><a href="#0" data-date="01/01/2006"><?php echo $txtProfil9Date11; ?></a></li>
                            <li><a href="#0" data-date="01/01/2005"><?php echo $txtProfil9Date12; ?></a></li>
                            <li><a href="#0" data-date="01/01/2004">Sept 1994</a></li>
                        </ol>

                        <span class="filling-line" aria-hidden="true"></span>
                    </div> <!-- .events -->
                </div> <!-- .events-wrapper -->
                    
                <ul class="cd-timeline-navigation">
                    <li><a href="#0" class="prev inactive">Prev</a><div style='position:absolute;top:36px;left:14px;font-size:22px;color:#f17144;'>&#60;</div></li>
                    <li><a href="#0" class="next">Next</a><div style='position:absolute;top:36px;right:13px;font-size:22px;color:#f17144;'>&#62;</div></li>
                </ul> <!-- .cd-timeline-navigation -->
            </div> <!-- .timeline -->

            <div class="events-content">
                <ol>
                    <li class="selected" data-date="01/01/2020"><p><?php echo $txtProfil10; ?></p></li>
                    <li data-date="01/01/2019"><p><?php echo $txtProfil11; ?></p></li>
                    <li data-date="01/01/2018"><p><?php echo $txtProfil12; ?></p></li>
                    <li data-date="01/01/2017"><p><?php echo $txtProfil13; ?></p></li>
                    <li data-date="01/01/2016"><p><?php echo $txtProfil14; ?></p></li>
                    <li data-date="01/01/2015"><p><?php echo $txtProfil15; ?></p></li>
                    <li data-date="01/01/2014"><p><?php echo $txtProfil16; ?></p></li>
                    <li data-date="01/01/2013"><p><?php echo $txtProfil17; ?></p></li>
                    <li data-date="01/01/2012"><p><?php echo $txtProfil18; ?></p></li>
                    <li data-date="01/01/2011"><p><?php echo $txtProfil19; ?></p></li>
                    <li data-date="01/01/2010"><p><?php echo $txtProfil20; ?></p></li>
                    <li data-date="01/01/2009"><p><?php echo $txtProfil21; ?></p></li>
                    <li data-date="01/01/2008"><p><?php echo $txtProfil22; ?></p></li>
                    <li data-date="01/01/2007"><p><?php echo $txtProfil23; ?></p></li>
                    <li data-date="01/01/2006"><p><?php echo $txtProfil24; ?></p></li>
                    <li data-date="01/01/2005"><p><?php echo $txtProfil25; ?></p></li>
                    <li data-date="01/01/2004"><p><?php echo $txtProfil26; ?></p></li>
                </ol>
            </div> <!-- .events-content -->
        </section>
    </div>
    <div style='width:100%;float:right;'>
    <br>
    <br>
    <br>
    <!-- RÉALISATIONS -->
    <div style='width:100%;float:right;'>
    <br><h2 style='width:100%;text-align:center;letter-spacing:.2rem;color:#333;'><?php echo $txtProfil27; ?></h2>
            <div style='width:100%;text-align:center;margin-bottom:40px;margin-top:-5px;'>
                <div style="display:inline-block;width:50px;height:5px;border-radius:2px;background:#f17144;"> </div>
            </div>
            <div style='display:inline-block;max-width:1020px;color:#888;padding:0px 60px 40px 60px;'><?php echo $txtProfil28; ?></div><br>
        <div class="timeline2"  style='display:inline-block;max-width:1080px;width:100%;'>
        <div class="timeline__wrap">
            <div class="timeline__items">
                <div class="timeline__item">
                    <div class="timeline__content">
                    2020
                    </div>
                    <div style='position:absolute;top:120px;left:10px;right:10px;'>
                    <?php echo $txtProfil29; ?>
                    </div>
                </div>
                <div class="timeline__item">
                    <div class="timeline__content">
                    2020
                    </div>
                    <div style='cursor:pointer;position:absolute;top:120px;left:10px;right:10px;'>
                    <?php echo $txtProfil30; ?>
                    </div>
                </div>
                <div class="timeline__item">
                    <div class="timeline__content">
                    2019
                    </div>
                    <div style='cursor:pointer;position:absolute;top:120px;left:10px;right:10px;'>
                    <?php echo $txtProfil31; ?>
                    </div>
                </div>
                <div class="timeline__item">
                    <div class="timeline__content">
                    2019
                    </div>
                    <div style='cursor:pointer;position:absolute;top:120px;left:10px;right:10px;'>
                    <?php echo $txtProfil32; ?>
                    </div>
                </div>
                <div class="timeline__item">
                    <div class="timeline__content">
                    2018
                    </div>
                    <div style='cursor:pointer;position:absolute;top:120px;left:10px;right:10px;'>
                    <?php echo $txtProfil33; ?>
                    </div>
                </div>
                <div class="timeline__item">
                    <div class="timeline__content">
                    2018
                    </div>
                    <div style='cursor:pointer;position:absolute;top:120px;left:10px;right:10px;'>
                    <?php echo $txtProfil34; ?>
                    </div>
                </div>
                <div class="timeline__item">
                    <div class="timeline__content">
                    2018
                    </div>
                    <div style='cursor:pointer;position:absolute;top:120px;left:10px;right:10px;'>
                    <?php echo $txtProfil35; ?>
                    </div>
                </div>
                <div class="timeline__item">
                    <div class="timeline__content">
                    2017
                    </div>
                    <div style='cursor:pointer;position:absolute;top:120px;left:10px;right:10px;'>
                    <?php echo $txtProfil36; ?>
                    </div>
                </div>
                <div class="timeline__item">
                    <div class="timeline__content">
                    2016
                    </div>
                    <div style='cursor:pointer;position:absolute;top:120px;left:10px;right:10px;'>
                    <?php echo $txtProfil37; ?>
                    </div>
                </div>
                <div class="timeline__item">
                    <div class="timeline__content">
                    2015
                    </div>
                    <div style='cursor:pointer;position:absolute;top:120px;left:10px;right:10px;'>
                    <?php echo $txtProfil38; ?>
                    </div>
                </div>
                <div class="timeline__item">
                    <div class="timeline__content">
                    2013-2014
                    </div>
                    <div style='cursor:pointer;position:absolute;top:120px;left:10px;right:10px;'>
                    <?php echo $txtProfil39; ?>
                    </div>
                </div>
                <div class="timeline__item">
                    <div class="timeline__content">
                    2011
                    </div>
                    <div style='cursor:pointer;position:absolute;top:120px;left:10px;right:10px;'>
                    <?php echo $txtProfil40; ?>
                    </div>
                </div>
                <div class="timeline__item">
                    <div class="timeline__content">
                    2009-2010
                    </div>
                    <div style='cursor:pointer;position:absolute;top:120px;left:10px;right:10px;'>
                    <?php echo $txtProfil41; ?>
                    </div>
                </div>
                <div class="timeline__item">
                    <div class="timeline__content">
                    2008
                    </div>
                    <div style='cursor:pointer;position:absolute;top:120px;left:10px;right:10px;'>
                    <?php echo $txtProfil42; ?>
                    </div>
                </div>
                <div class="timeline__item">
                    <div class="timeline__content">
                    2007
                    </div>
                    <div style='cursor:pointer;position:absolute;top:120px;left:10px;right:10px;'>
                    <?php echo $txtProfil43; ?>
                    </div>
                </div>
                <div class="timeline__item">
                    <div class="timeline__content">
                    2004
                    </div>
                    <div style='cursor:pointer;position:absolute;top:120px;left:10px;right:10px;'>
                    <?php echo $txtProfil44; ?> 
                    </div>
                </div>
                <div class="timeline__item">
                    <div class="timeline__content" >
                    2003
                    </div>
                    <div style='cursor:pointer;position:absolute;top:120px;left:10px;right:10px;'>
                    <?php echo $txtProfil45; ?> 
                    </div>
                </div>
                <div class="timeline__item">
                    <div class="timeline__content">
                    2003
                    </div>
                    <div style='cursor:pointer;position:absolute;top:120px;left:10px;right:10px;'>
                    <?php echo $txtProfil46; ?> 
                    </div>
                </div>
                <div class="timeline__item">
                    <div class="timeline__content">
                    2002
                    </div>
                    <div style='cursor:pointer;position:absolute;top:120px;left:10px;right:10px;'>
                    <?php echo $txtProfil47; ?>  
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>

    <br>
    <br>
    <br>
    </div>
    <!-- CONTACT -->
    <div style='width:100%;background-color:rgb(241, 113, 68);color:#fff;float:right;min-height:100px;'>
        <table style='width:100%;table-layout: fixed;text-align:center;max-width:1080px;margin-right:auto;margin-left:auto;'><tr>
            <td width='*' style='line-height: 150%;text-align:left;padding-left:15px;'><br><?php echo $txtContact2; ?></td>
            <td width='200'><br><br><button class='contact_button' onclick='window.open("/contact","_self")' style='float:right;margin-right:15px;background-color:rgb(241, 113, 68);border:2px solid #fff;border-radius:2px;'><?php echo $txtContact; ?></button></td>
        </tr></table><br>
    </div> 


<!-- FOOTER -->  
<?php
 require_once $_SERVER['DOCUMENT_ROOT'] . '/index_footer.php';
?>
</div>
    <div id='divFADE'></div>
    <div id='divFrame' class='dw3_form' style='min-height:250px;max-height:250px;'>
        <div id='divFrame_HEADER' class='dw3_form_head'></div>
        <button onclick='closeFrame();' class='dw3_form_close'><span class='material-icons' style='margin-top:2px;'>close</span></button>
        <div class='dw3_form_data' id='divFrameData' style='height:250px;'></div>
        <div class='dw3_form_foot'><button class='dw3_form_cancel' onclick='closeFrame()'>Ok</button></div>                    
    </div>

<script src="/timeline2.js?t=7777sddd"></script>
<script src='/main.js?t=<?php echo(rand());?>'></script>
<script>

window.addEventListener('resize', function(event) {
    //dragElement(document.getElementById("divFrame"));
    if ( window.innerWidth > 600){
        timeline(document.querySelectorAll('.timeline2'), {
        mode: 'horizontal',
        visibleItems: 4
    });
    }else{
        timeline(document.querySelectorAll('.timeline2'), {
        mode: 'horizontal',
        visibleItems: 2
    });
    }
}, true);

jQuery(document).ready(function($){

    //dragElement(document.getElementById("divFrame"));
    if ( window.innerWidth > 600){
        timeline(document.querySelectorAll('.timeline2'), {
        mode: 'horizontal',
        visibleItems: 4
    });
    }else{
        timeline(document.querySelectorAll('.timeline2'), {
        mode: 'horizontal',
        visibleItems: 2
    });
    }


	var timelines = $('.cd-horizontal-timeline'),
		eventsMinDistance = 120;

	(timelines.length > 0) && initTimeline(timelines);

	function initTimeline(timelines) {
		timelines.each(function(){
			var timeline = $(this),
				timelineComponents = {};
			//cache timeline components 
			timelineComponents['timelineWrapper'] = timeline.find('.events-wrapper');
			timelineComponents['eventsWrapper'] = timelineComponents['timelineWrapper'].children('.events');
			timelineComponents['fillingLine'] = timelineComponents['eventsWrapper'].children('.filling-line');
			timelineComponents['timelineEvents'] = timelineComponents['eventsWrapper'].find('a');
			timelineComponents['timelineDates'] = parseDate(timelineComponents['timelineEvents']);
			timelineComponents['eventsMinLapse'] = minLapse(timelineComponents['timelineDates']);
			timelineComponents['timelineNavigation'] = timeline.find('.cd-timeline-navigation');
			timelineComponents['eventsContent'] = timeline.children('.events-content');

			//assign a left postion to the single events along the timeline
			setDatePosition(timelineComponents, eventsMinDistance);
			//assign a width to the timeline
			var timelineTotWidth = setTimelineWidth(timelineComponents, eventsMinDistance);
			//the timeline has been initialize - show it
			timeline.addClass('loaded');

			//detect click on the next arrow
			timelineComponents['timelineNavigation'].on('click', '.next', function(event){
				event.preventDefault();
				updateSlide(timelineComponents, timelineTotWidth, 'next');
			});
			//detect click on the prev arrow
			timelineComponents['timelineNavigation'].on('click', '.prev', function(event){
				event.preventDefault();
				updateSlide(timelineComponents, timelineTotWidth, 'prev');
			});
			//detect click on the a single event - show new event content
			timelineComponents['eventsWrapper'].on('click', 'a', function(event){
				event.preventDefault();
				timelineComponents['timelineEvents'].removeClass('selected');
				$(this).addClass('selected');
				updateOlderEvents($(this));
				updateFilling($(this), timelineComponents['fillingLine'], timelineTotWidth);
				updateVisibleContent($(this), timelineComponents['eventsContent']);
			});

			//on swipe, show next/prev event content
			timelineComponents['eventsContent'].on('swipeleft', function(){
				var mq = checkMQ();
				( mq == 'mobile' ) && showNewContent(timelineComponents, timelineTotWidth, 'next');
			});
			timelineComponents['eventsContent'].on('swiperight', function(){
				var mq = checkMQ();
				( mq == 'mobile' ) && showNewContent(timelineComponents, timelineTotWidth, 'prev');
			});

			//keyboard navigation
			$(document).keyup(function(event){
				if(event.which=='37' && elementInViewport(timeline.get(0)) ) {
					showNewContent(timelineComponents, timelineTotWidth, 'prev');
				} else if( event.which=='39' && elementInViewport(timeline.get(0))) {
					showNewContent(timelineComponents, timelineTotWidth, 'next');
				}
			});
		});
	}

	function updateSlide(timelineComponents, timelineTotWidth, string) {
		//retrieve translateX value of timelineComponents['eventsWrapper']
		var translateValue = getTranslateValue(timelineComponents['eventsWrapper']),
			wrapperWidth = Number(timelineComponents['timelineWrapper'].css('width').replace('px', ''));
		//translate the timeline to the left('next')/right('prev') 
		(string == 'next') 
			? translateTimeline(timelineComponents, translateValue - wrapperWidth + eventsMinDistance, wrapperWidth - timelineTotWidth)
			: translateTimeline(timelineComponents, translateValue + wrapperWidth - eventsMinDistance);
	}

	function showNewContent(timelineComponents, timelineTotWidth, string) {
		//go from one event to the next/previous one
		var visibleContent =  timelineComponents['eventsContent'].find('.selected'),
			newContent = ( string == 'next' ) ? visibleContent.next() : visibleContent.prev();

		if ( newContent.length > 0 ) { //if there's a next/prev event - show it
			var selectedDate = timelineComponents['eventsWrapper'].find('.selected'),
				newEvent = ( string == 'next' ) ? selectedDate.parent('li').next('li').children('a') : selectedDate.parent('li').prev('li').children('a');
			
			updateFilling(newEvent, timelineComponents['fillingLine'], timelineTotWidth);
			updateVisibleContent(newEvent, timelineComponents['eventsContent']);
			newEvent.addClass('selected');
			selectedDate.removeClass('selected');
			updateOlderEvents(newEvent);
			updateTimelinePosition(string, newEvent, timelineComponents, timelineTotWidth);
		}
	}

	function updateTimelinePosition(string, event, timelineComponents, timelineTotWidth) {
		//translate timeline to the left/right according to the position of the selected event
		var eventStyle = window.getComputedStyle(event.get(0), null),
			eventLeft = Number(eventStyle.getPropertyValue("left").replace('px', '')),
			timelineWidth = Number(timelineComponents['timelineWrapper'].css('width').replace('px', '')),
			timelineTotWidth = Number(timelineComponents['eventsWrapper'].css('width').replace('px', ''));
		var timelineTranslate = getTranslateValue(timelineComponents['eventsWrapper']);

        if( (string == 'next' && eventLeft > timelineWidth - timelineTranslate) || (string == 'prev' && eventLeft < - timelineTranslate) ) {
        	translateTimeline(timelineComponents, - eventLeft + timelineWidth/2, timelineWidth - timelineTotWidth);
        }
	}

	function translateTimeline(timelineComponents, value, totWidth) {
		var eventsWrapper = timelineComponents['eventsWrapper'].get(0);
		value = (value > 0) ? 0 : value; //only negative translate value
		value = ( !(typeof totWidth === 'undefined') &&  value < totWidth ) ? totWidth : value; //do not translate more than timeline width
		setTransformValue(eventsWrapper, 'translateX', value+'px');
		//update navigation arrows visibility
		(value == 0 ) ? timelineComponents['timelineNavigation'].find('.prev').addClass('inactive') : timelineComponents['timelineNavigation'].find('.prev').removeClass('inactive');
		(value == totWidth ) ? timelineComponents['timelineNavigation'].find('.next').addClass('inactive') : timelineComponents['timelineNavigation'].find('.next').removeClass('inactive');
	}

	function updateFilling(selectedEvent, filling, totWidth) {
		//change .filling-line length according to the selected event
		var eventStyle = window.getComputedStyle(selectedEvent.get(0), null),
			eventLeft = eventStyle.getPropertyValue("left"),
			eventWidth = eventStyle.getPropertyValue("width");
		eventLeft = (Number(eventLeft.replace('px', '')) + Number(eventWidth.replace('px', ''))/2);
		var scaleValue = eventLeft/totWidth;
		setTransformValue(filling.get(0), 'scaleX', scaleValue);
	}

	function setDatePosition(timelineComponents, min) {
		for (i = 0; i < timelineComponents['timelineDates'].length; i++) { 
		    var distance = daydiff(timelineComponents['timelineDates'][0], timelineComponents['timelineDates'][i]),
		    	distanceNorm = Math.round(distance/timelineComponents['eventsMinLapse']) + 2;
		    timelineComponents['timelineEvents'].eq(i).css('left', (distanceNorm*min)-120+'px');
		}
	}

	function setTimelineWidth(timelineComponents, width) {
		var timeSpan = daydiff(timelineComponents['timelineDates'][0], timelineComponents['timelineDates'][timelineComponents['timelineDates'].length-1]),
			timeSpanNorm = timeSpan/timelineComponents['eventsMinLapse'],
			timeSpanNorm = Math.round(timeSpanNorm) + 4,
			totalWidth = timeSpanNorm*width;
		timelineComponents['eventsWrapper'].css('width', totalWidth+'px');
		updateFilling(timelineComponents['timelineEvents'].eq(0), timelineComponents['fillingLine'], totalWidth);
	
		return totalWidth;
	}

	function updateVisibleContent(event, eventsContent) {
		var eventDate = event.data('date'),
			visibleContent = eventsContent.find('.selected'),
			selectedContent = eventsContent.find('[data-date="'+ eventDate +'"]'),
			selectedContentHeight = selectedContent.height();

		if (selectedContent.index() > visibleContent.index()) {
			var classEnetering = 'selected enter-right',
				classLeaving = 'leave-left';
		} else {
			var classEnetering = 'selected enter-left',
				classLeaving = 'leave-right';
		}

		selectedContent.attr('class', classEnetering);
		visibleContent.attr('class', classLeaving).one('webkitAnimationEnd oanimationend msAnimationEnd animationend', function(){
			visibleContent.removeClass('leave-right leave-left');
			selectedContent.removeClass('enter-left enter-right');
		});
		eventsContent.css('height', selectedContentHeight+'px');
	}

	function updateOlderEvents(event) {
		event.parent('li').prevAll('li').children('a').addClass('older-event').end().end().nextAll('li').children('a').removeClass('older-event');
	}

	function getTranslateValue(timeline) {
		var timelineStyle = window.getComputedStyle(timeline.get(0), null),
			timelineTranslate = timelineStyle.getPropertyValue("-webkit-transform") ||
         		timelineStyle.getPropertyValue("-moz-transform") ||
         		timelineStyle.getPropertyValue("-ms-transform") ||
         		timelineStyle.getPropertyValue("-o-transform") ||
         		timelineStyle.getPropertyValue("transform");

        if( timelineTranslate.indexOf('(') >=0 ) {
        	var timelineTranslate = timelineTranslate.split('(')[1];
    		timelineTranslate = timelineTranslate.split(')')[0];
    		timelineTranslate = timelineTranslate.split(',');
    		var translateValue = timelineTranslate[4];
        } else {
        	var translateValue = 0;
        }

        return Number(translateValue);
	}

	function setTransformValue(element, property, value) {
		element.style["-webkit-transform"] = property+"("+value+")";
		element.style["-moz-transform"] = property+"("+value+")";
		element.style["-ms-transform"] = property+"("+value+")";
		element.style["-o-transform"] = property+"("+value+")";
		element.style["transform"] = property+"("+value+")";
	}

	//based on http://stackoverflow.com/questions/542938/how-do-i-get-the-number-of-days-between-two-dates-in-javascript
	function parseDate(events) {
		var dateArrays = [];
		events.each(function(){
			var dateComp = $(this).data('date').split('/'),
				newDate = new Date(dateComp[2], dateComp[1]-1, dateComp[0]);
			dateArrays.push(newDate);
		});
	    return dateArrays;
	}

	function parseDate2(events) {
		var dateArrays = [];
		events.each(function(){
			var singleDate = $(this),
				dateComp = singleDate.data('date').split('T');
			if( dateComp.length > 1 ) { //both DD/MM/YEAR and time are provided
				var dayComp = dateComp[0].split('/'),
					timeComp = dateComp[1].split(':');
			} else if( dateComp[0].indexOf(':') >=0 ) { //only time is provide
				var dayComp = ["2000", "0", "0"],
					timeComp = dateComp[0].split(':');
			} else { //only DD/MM/YEAR
				var dayComp = dateComp[0].split('/'),
					timeComp = ["0", "0"];
			}
			var	newDate = new Date(dayComp[2], dayComp[1]-1, dayComp[0], timeComp[0], timeComp[1]);
			dateArrays.push(newDate);
		});
	    return dateArrays;
	}

	function daydiff(first, second) {
	    return Math.round((second-first));
	}

	function minLapse(dates) {
		//determine the minimum distance among events
		var dateDistances = [];
		for (i = 1; i < dates.length; i++) { 
		    var distance = daydiff(dates[i-1], dates[i]);
		    dateDistances.push(distance);
		}
		return Math.min.apply(null, dateDistances);
	}

	/*
		How to tell if a DOM element is visible in the current viewport?
		http://stackoverflow.com/questions/123999/how-to-tell-if-a-dom-element-is-visible-in-the-current-viewport
	*/
	function elementInViewport(el) {
		var top = el.offsetTop;
		var left = el.offsetLeft;
		var width = el.offsetWidth;
		var height = el.offsetHeight;

		while(el.offsetParent) {
		    el = el.offsetParent;
		    top += el.offsetTop;
		    left += el.offsetLeft;
		}

		return (
		    top < (window.pageYOffset + window.innerHeight) &&
		    left < (window.pageXOffset + window.innerWidth) &&
		    (top + height) > window.pageYOffset &&
		    (left + width) > window.pageXOffset
		);
	}

	function checkMQ() {
		//check if mobile or desktop device
		return window.getComputedStyle(document.querySelector('.cd-horizontal-timeline'), '::before').getPropertyValue('content').replace(/'/g, "").replace(/"/g, "");
	}
});

    </script>
  </body>
</html>