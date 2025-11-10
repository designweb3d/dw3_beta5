<script>
setTimeout(init_historic, 1000);
setTimeout(init_realisation, 500);

//HISTORIC
const eventsMinDistance = 100;
function init_historic() {
    var timelines = document.getElementsByClassName('cd-horizontal-timeline');
    if (timelines.length > 0){
        (timelines.length > 0) && initTimeline(timelines);
    }
}

function initTimeline() {
    var timelinez = jQuery('.cd-horizontal-timeline');
    //var timelinez = document.getElementsByClassName("cd-horizontal-timeline");
		timelinez.each(function(){
			var timeline = jQuery(this),
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
				jQuery(this).addClass('selected');
				updateOlderEvents(jQuery(this));
				updateFilling(jQuery(this), timelineComponents['fillingLine'], timelineTotWidth);
				updateVisibleContent(jQuery(this), timelineComponents['eventsContent']);
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
			jQuery(document).keyup(function(event){
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
        timelineComponents['timelineEvents'].eq(i).css('left', (distanceNorm*min)-100+'px');
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
        var dateComp = jQuery(this).data('date').split('/'),
            newDate = new Date(dateComp[2], dateComp[1]-1, dateComp[0]);
        dateArrays.push(newDate);
    });
    return dateArrays;
}

function parseDate2(events) {
    var dateArrays = [];
    events.each(function(){
        var singleDate = jQuery(this),
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

//-------------------------------------------------------------------------------------------------
//-------------------------------------------------------------------------------------------------
//REALISATION
//-------------------------------------------------------------------------------------------------
function init_realisation() {
    var section_realisation = document.getElementsByClassName('timeline2');
    if (section_realisation.length > 0){
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
    }
}
//timeline2 //Realisation
function timeline(collection, options) {
    const timelines = [];
    const warningLabel = 'Timeline:';
    let winWidth = window.innerWidth;
    let resizeTimer;
    let currentIndex = 0;
    // Set default settings
    const defaultSettings = {
      forceVerticalMode: {
        type: 'integer',
        defaultValue: 600
      },
      horizontalStartPosition: {
        type: 'string',
        acceptedValues: ['bottom', 'top'],
        defaultValue: 'top'
      },
      mode: {
        type: 'string',
        acceptedValues: ['horizontal', 'vertical'],
        defaultValue: 'vertical'
      },
      moveItems: {
        type: 'integer',
        defaultValue: 1
      },
      rtlMode: {
        type: 'boolean',
        acceptedValues: [true, false],
        defaultValue: false
      },
      startIndex: {
        type: 'integer',
        defaultValue: 0
      },
      verticalStartPosition: {
        type: 'string',
        acceptedValues: ['left', 'right'],
        defaultValue: 'left'
      },
      verticalTrigger: {
        type: 'string',
        defaultValue: '15%'
      },
      visibleItems: {
        type: 'integer',
        defaultValue: 3
      }
    };
  
    // Helper function to test whether values are an integer
    function testValues(value, settingName) {
      if (typeof value !== 'number' && value % 1 !== 0) {
        console.warn(`${warningLabel} The value "${value}" entered for the setting "${settingName}" is not an integer.`);
        return false;
      }
      return true;
    }
  
    // Helper function to wrap an element in another HTML element
    function itemWrap(el, wrapper, classes) {
      wrapper.classList.add(classes);
      el.parentNode.insertBefore(wrapper, el);
      wrapper.appendChild(el);
    }
  
    // Helper function to wrap each element in a group with other HTML elements
    function wrapElements(items) {
      items.forEach((item) => {
        itemWrap(item.querySelector('.timeline__content'), document.createElement('div'), 'timeline__content__wrap');
        itemWrap(item.querySelector('.timeline__content__wrap'), document.createElement('div'), 'timeline__item__inner');
      });
    }
  
    // Helper function to check if an element is partially in the viewport
    function isElementInViewport(el, triggerPosition) {
      const rect = el.getBoundingClientRect();
      const windowHeight = window.innerHeight || document.documentElement.clientHeight;
      const defaultTrigger = defaultSettings.verticalTrigger.defaultValue.match(/(\d*\.?\d*)(.*)/);
      let triggerUnit = triggerPosition.unit;
      let triggerValue = triggerPosition.value;
      let trigger = windowHeight;
      if (triggerUnit === 'px' && triggerValue >= windowHeight) {
        console.warn('The value entered for the setting "verticalTrigger" is larger than the window height. The default value will be used instead.');
        [, triggerValue, triggerUnit] = defaultTrigger;
      }
      if (triggerUnit === 'px') {
        trigger = parseInt(trigger - triggerValue, 10);
      } else if (triggerUnit === '%') {
        trigger = parseInt(trigger * ((100 - triggerValue) / 100), 10);
      }
      return (
        rect.top <= trigger
        && rect.left <= (window.innerWidth || document.documentElement.clientWidth)
        && (rect.top + rect.height) >= 0
        && (rect.left + rect.width) >= 0
      );
    }
  
    // Helper function to add transform styles
    function addTransforms(el, transform) {
      el.style.webkitTransform = transform;
      el.style.msTransform = transform;
      el.style.transform = transform;
    }
  
    // Create timelines
    function createTimelines(timelineEl) {
      const timelineName = timelineEl.id ? `#${timelineEl.id}` : `.${timelineEl.className}`;
      const errorPart = 'could not be found as a direct descendant of';
      const data = timelineEl.dataset;
      let wrap;
      let scroller;
      let items;
      const settings = {};
  
      // Test for correct HTML structure
      try {
        wrap = timelineEl.querySelector('.timeline__wrap');
        if (!wrap) {
          throw new Error(`${warningLabel} .timeline__wrap ${errorPart} ${timelineName}`);
        } else {
          scroller = wrap.querySelector('.timeline__items');
          if (!scroller) {
            throw new Error(`${warningLabel} .timeline__items ${errorPart} .timeline__wrap`);
          } else {
            items = [].slice.call(scroller.children, 0);
          }
        }
      } catch (e) {
        console.warn(e.message);
        return false;
      }
  
      // Test setting input values
      Object.keys(defaultSettings).forEach((key) => {
        settings[key] = defaultSettings[key].defaultValue;
  
        if (data[key]) {
          settings[key] = data[key];
        } else if (options && options[key]) {
          settings[key] = options[key];
        }
  
        if (defaultSettings[key].type === 'integer') {
          if (!settings[key] || !testValues(settings[key], key)) {
            settings[key] = defaultSettings[key].defaultValue;
          }
        } else if (defaultSettings[key].type === 'string') {
          if (defaultSettings[key].acceptedValues && defaultSettings[key].acceptedValues.indexOf(settings[key]) === -1) {
            console.warn(`${warningLabel} The value "${settings[key]}" entered for the setting "${key}" was not recognised.`);
            settings[key] = defaultSettings[key].defaultValue;
          }
        }
      });
  
      // Further specific testing of input values
      const defaultTrigger = defaultSettings.verticalTrigger.defaultValue.match(/(\d*\.?\d*)(.*)/);
      const triggerArray = settings.verticalTrigger.match(/(\d*\.?\d*)(.*)/);
      let [, triggerValue, triggerUnit] = triggerArray;
      let triggerValid = true;
      if (!triggerValue) {
        console.warn(`${warningLabel} No numercial value entered for the 'verticalTrigger' setting.`);
        triggerValid = false;
      }
      if (triggerUnit !== 'px' && triggerUnit !== '%') {
        console.warn(`${warningLabel} The setting 'verticalTrigger' must be a percentage or pixel value.`);
        triggerValid = false;
      }
      if (triggerUnit === '%' && (triggerValue > 100 || triggerValue < 0)) {
        console.warn(`${warningLabel} The 'verticalTrigger' setting value must be between 0 and 100 if using a percentage value.`);
        triggerValid = false;
      } else if (triggerUnit === 'px' && triggerValue < 0) {
        console.warn(`${warningLabel} The 'verticalTrigger' setting value must be above 0 if using a pixel value.`);
        triggerValid = false;
      }
  
      if (triggerValid === false) {
        [, triggerValue, triggerUnit] = defaultTrigger;
      }
  
      settings.verticalTrigger = {
        unit: triggerUnit,
        value: triggerValue
      };
  
      if (settings.moveItems > settings.visibleItems) {
        console.warn(`${warningLabel} The value of "moveItems" (${settings.moveItems}) is larger than the number of "visibleItems" (${settings.visibleItems}). The value of "visibleItems" has been used instead.`);
        settings.moveItems = settings.visibleItems;
      }
  
      if (settings.startIndex > (items.length - settings.visibleItems) && items.length > settings.visibleItems) {
        console.warn(`${warningLabel} The 'startIndex' setting must be between 0 and ${items.length - settings.visibleItems} for this timeline. The value of ${items.length - settings.visibleItems} has been used instead.`);
        settings.startIndex = items.length - settings.visibleItems;
      } else if (items.length <= settings.visibleItems) {
        console.warn(`${warningLabel} The number of items in the timeline must exceed the number of visible items to use the 'startIndex' option.`);
        settings.startIndex = 0;
      } else if (settings.startIndex < 0) {
        console.warn(`${warningLabel} The 'startIndex' setting must be between 0 and ${items.length - settings.visibleItems} for this timeline. The value of 0 has been used instead.`);
        settings.startIndex = 0;
      }
  
      timelines.push({
        timelineEl,
        wrap,
        scroller,
        items,
        settings
      });
    }
  
    if (collection.length) {
      [].forEach.call(collection, createTimelines);
    }
  
    // Set height and widths of timeline elements and viewport
    function setHeightandWidths(tl) {
      // Set widths of items and viewport
      function setWidths() {
        tl.itemWidth = tl.wrap.offsetWidth / tl.settings.visibleItems;
        tl.items.forEach((item) => {
          item.style.width = `${tl.itemWidth}px`;
        });
        tl.scrollerWidth = tl.itemWidth * tl.items.length;
        tl.scroller.style.width = `${tl.scrollerWidth}px`;
      }
  
      // Set height of items and viewport
      function setHeights() {
        let oddIndexTallest = 0;
        let evenIndexTallest = 0;
        tl.items.forEach((item, i) => {
          item.style.height = 'auto';
          const height = item.offsetHeight;
          if (i % 2 === 0) {
            evenIndexTallest = height > evenIndexTallest ? height : evenIndexTallest;
          } else {
            oddIndexTallest = height > oddIndexTallest ? height : oddIndexTallest;
          }
        });
  
        const transformString = `translateY(${evenIndexTallest}px)`;
        tl.items.forEach((item, i) => {
          if (i % 2 === 0) {
            item.style.height = `${evenIndexTallest}px`;
            if (tl.settings.horizontalStartPosition === 'bottom') {
              item.classList.add('timeline__item--bottom');
              addTransforms(item, transformString);
            } else {
              item.classList.add('timeline__item--top');
            }
          } else {
            item.style.height = `${oddIndexTallest}px`;
            if (tl.settings.horizontalStartPosition !== 'bottom') {
              item.classList.add('timeline__item--bottom');
              addTransforms(item, transformString);
            } else {
              item.classList.add('timeline__item--top');
            }
          }
        });
        tl.scroller.style.height = `${evenIndexTallest + oddIndexTallest}px`;
      }
  
      //if (window.innerWidth > tl.settings.forceVerticalMode) {
        setWidths();
        //setHeights();
      //}
    }
  
    // Create and add arrow controls to horizontal timeline
    function addNavigation(tl) {
      if (tl.items.length > tl.settings.visibleItems) {
        const prevArrow = document.createElement('button');
        const nextArrow = document.createElement('button');
        const topPosition = tl.items[0].offsetHeight -20;
        prevArrow.className = 'timeline-nav-button timeline-nav-button--prev';
        nextArrow.className = 'timeline-nav-button timeline-nav-button--next';
        prevArrow.textContent = 'Previous';
        nextArrow.textContent = 'Next';
        prevArrow.style.top = `${topPosition}px`;
        nextArrow.style.top = `${topPosition}px`;
        if (currentIndex === 0) {
          prevArrow.disabled = true;
        } else if (currentIndex === (tl.items.length - tl.settings.visibleItems)) {
          nextArrow.disabled = true;
        }
        tl.timelineEl.appendChild(prevArrow);
        tl.timelineEl.appendChild(nextArrow);
      }
    }
  
    // Add the centre line to the horizontal timeline
    function addHorizontalDivider(tl) {
      const divider = tl.timelineEl.querySelector('.timeline-divider');
      if (divider) {
        tl.timelineEl.removeChild(divider);
      }
      const topPosition = tl.items[0].offsetHeight;
      const horizontalDivider = document.createElement('span');
      horizontalDivider.className = 'timeline-divider';
      horizontalDivider.style.top = `${topPosition}px`;
      tl.timelineEl.appendChild(horizontalDivider);
    }
  
    // Calculate the new position of the horizontal timeline
    function timelinePosition(tl) {
      const position = tl.items[currentIndex].offsetLeft;
      const str = `translate3d(-${position}px, 0, 0)`;
      addTransforms(tl.scroller, str);
    }
  
    // Make the horizontal timeline slide
    function slideTimeline(tl) {
      const navArrows = tl.timelineEl.querySelectorAll('.timeline-nav-button');
      const arrowPrev = tl.timelineEl.querySelector('.timeline-nav-button--prev');
      const arrowNext = tl.timelineEl.querySelector('.timeline-nav-button--next');
      const maxIndex = tl.items.length - tl.settings.visibleItems;
      const moveItems = parseInt(tl.settings.moveItems, 10);
      [].forEach.call(navArrows, (arrow) => {
        arrow.addEventListener('click', function(e) {
          e.preventDefault();
          currentIndex = this.classList.contains('timeline-nav-button--next') ? (currentIndex += moveItems) : (currentIndex -= moveItems);
          if (currentIndex === 0 || currentIndex < 0) {
            currentIndex = 0;
            arrowPrev.disabled = true;
            arrowNext.disabled = false;
          } else if (currentIndex === maxIndex || currentIndex > maxIndex) {
            currentIndex = maxIndex;
            arrowPrev.disabled = false;
            arrowNext.disabled = true;
          } else {
            arrowPrev.disabled = false;
            arrowNext.disabled = false;
          }
          timelinePosition(tl);
        });
      });
    }
  
    // Set up horizontal timeline
    function setUpHorinzontalTimeline(tl) {
      if (tl.settings.rtlMode) {
        currentIndex = tl.items.length > tl.settings.visibleItems ? tl.items.length - tl.settings.visibleItems : 0;
      } else {
        currentIndex = tl.settings.startIndex;
      }
      tl.timelineEl.classList.add('timeline--horizontal');
      setHeightandWidths(tl);
      timelinePosition(tl);
      addNavigation(tl);
      addHorizontalDivider(tl);
      slideTimeline(tl);
    }
  
    // Set up vertical timeline
    function setUpVerticalTimeline(tl) {
      let lastVisibleIndex = 0;
      tl.items.forEach((item, i) => {
        item.classList.remove('animated', 'fadeIn');
        if (!isElementInViewport(item, tl.settings.verticalTrigger) && i > 0) {
          item.classList.add('animated');
        } else {
          lastVisibleIndex = i;
        }
        const divider = tl.settings.verticalStartPosition === 'left' ? 1 : 0;
        if (i % 2 === divider && window.innerWidth > tl.settings.forceVerticalMode) {
          item.classList.add('timeline__item--right');
        } else {
          item.classList.add('timeline__item--left');
        }
      });
      for (let i = 0; i < lastVisibleIndex; i += 1) {
        tl.items[i].classList.remove('animated', 'fadeIn');
      }
      // Bring elements into view as the page is scrolled
      window.addEventListener('scroll', () => {
        tl.items.forEach((item) => {
          if (isElementInViewport(item, tl.settings.verticalTrigger)) {
            item.classList.add('fadeIn');
          }
        });
      });
    }
  
    // Reset timelines
    function resetTimelines(tl) {
      tl.timelineEl.classList.remove('timeline--horizontal', 'timeline--mobile');
      tl.scroller.removeAttribute('style');
      tl.items.forEach((item) => {
        item.removeAttribute('style');
        item.classList.remove('animated', 'fadeIn', 'timeline__item--left', 'timeline__item--right');
      });
      const navArrows = tl.timelineEl.querySelectorAll('.timeline-nav-button');
      [].forEach.call(navArrows, (arrow) => {
        arrow.parentNode.removeChild(arrow);
      });
    }
  
    // Set up the timelines
    function setUpTimelines() {
      timelines.forEach((tl) => {
        tl.timelineEl.style.opacity = 0;
        if (!tl.timelineEl.classList.contains('timeline--loaded')) {
          wrapElements(tl.items);
        }
        resetTimelines(tl);
        //if (window.innerWidth <= tl.settings.forceVerticalMode) {
          //tl.timelineEl.classList.add('timeline--mobile');
        //}
        //if (tl.settings.mode === 'horizontal' && window.innerWidth > tl.settings.forceVerticalMode) {
          setUpHorinzontalTimeline(tl);
        //} else {
        //  setUpVerticalTimeline(tl);
        //}
        tl.timelineEl.classList.add('timeline--loaded');
        setTimeout(() => {
          tl.timelineEl.style.opacity = 1;
        }, 500);
      });
    }
  
    // Initialise the timelines on the page
    setUpTimelines();
    window.addEventListener('resize', () => {
        var newWidth = window.innerWidth;
        if (newWidth !== prevWidth) {
            prevWidth = newWidth;
            setTimeout(setSubMenusPos, 1000);
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(() => {
            const newWinWidth = window.innerWidth;
            if (newWinWidth !== winWidth) {
                setUpTimelines();
                winWidth = newWinWidth;
            }
            }, 250);
            init_realisation();
        }
    });
}
var prevWidth = window.innerWidth;

// Register as a jQuery plugin if the jQuery library is present
  if (window.jQuery) {
    (($) => {
      $.fn.timeline = function(opts) {
        timeline(this, opts);
        return this;
      };
    })(window.jQuery);
    }
</script>