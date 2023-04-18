@extends('layouts.contentNavbarLayout')
@section('title', 'Calendar')

@section('page-style')
  <!-- Page -->
  <link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-calendar.css')}}">
@endsection

@section('vendor-style')
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/calendar/toastui-calendar.min.css')}}">
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/calendar/tui-time-picker.min.css')}}">
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/calendar/tui-date-picker.min.css')}}">

@endsection

@section('vendor-script')

  <script src="{{asset('assets/vendor/libs/momentjs/moment.min.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/chance/chance.min.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/calendar/tui-time-picker.min.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/calendar/tui-date-picker.min.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/calendar/toastui-calendar.min.js')}}"></script>
@endsection


@section('content')
  <div class="shadow-sm p-3 mb-5 bg-white rounded">
    <article class="content">
      <aside class="sidebar">
        <div class="sidebar-item">
          <input class="checkbox-all" type="checkbox" id="all" value="all" checked="">
          <label class="checkbox checkbox-all" for="all" style="--checkbox-all:#fff;">View all</label>
        </div>
        <hr>
        <div class="sidebar-item">
          <input type="checkbox" id="1" value="1" checked="">
          <label class="checkbox checkbox-calendar checkbox-1" for="1" style="--checkbox-1:#fff;">My
            Calendar</label>
        </div>
        <div class="sidebar-item">
          <input type="checkbox" id="2" value="2" checked="">
          <label class="checkbox checkbox-calendar checkbox-2" for="2" style="--checkbox-2:#fff;">Work</label>
        </div>
        <div class="sidebar-item">
          <input type="checkbox" id="3" value="3" checked="">
          <label class="checkbox checkbox-calendar checkbox-3" for="3" style="--checkbox-3:#fff;">Family</label>
        </div>
        <div class="sidebar-item">
          <input type="checkbox" id="4" value="4" checked="">
          <label class="checkbox checkbox-calendar checkbox-4" for="4" style="--checkbox-4:#fff;">Friends</label>
        </div>
        <div class="sidebar-item">
          <input type="checkbox" id="5" value="5" checked="">
          <label class="checkbox checkbox-calendar checkbox-5" for="5" style="--checkbox-5:#fff;">Travel</label>
        </div>
        <hr>
        <div class="app-footer">© NHN Cloud Corp.</div>
      </aside>
      <section class="app-column">
        <nav class="navbar">
          <div class="dropdown">
            <div class="dropdown-trigger">
              <button class="btn btn-outline-primary" aria-haspopup="true" aria-controls="dropdown-menu">
                <span class="button-text">Weekly</span>
                <span class="dropdown-icon toastui-calendar-icon toastui-calendar-ic-dropdown-arrow"></span>
              </button>
            </div>
            <div class="dropdown-menu">
              <div class="dropdown-content">
                <a href="#" class="dropdown-item" data-view-name="month">Monthly</a>
                <a href="#" class="dropdown-item" data-view-name="week">Weekly</a>
                <a href="#" class="dropdown-item" data-view-name="day">Daily</a>
              </div>
            </div>
          </div>
          <button class="btn btn-outline-primary today me-2">Today</button>

          <button class="btn rounded-pill btn-icon btn-outline-primary me-1 prev">
            <i class='bx bx-chevron-left'></i>
          </button>
          <button class="btn rounded-pill btn-icon btn-outline-primary next">
            <i class='bx bx-chevron-right'></i>
          </button>
          <span class="navbar--range">2023-04-16 ~ 2023-04-22</span>
          <div class="nav-checkbox">
            <input class="checkbox-collapse" type="checkbox" id="collapse" value="collapse">
            <label for="collapse" style="--checkbox-collapse:#fff;">Collapse duplicate events and disable the detail
              popup</label>
          </div>
        </nav>
        <main id="app" style="height: 60vh"></main>
      </section>
    </article>
  </div>
@endsection

@section('page-script')
  <script src="{{ asset('assets/js/mock-data.js') }}"></script>
  <script src="{{ asset('assets/js/utils.js') }}"></script>

  <script>

      (function (Calendar) {
          var cal;
          // Constants
          var CALENDAR_CSS_PREFIX = 'toastui-calendar-';
          var cls = function (className) {
              return CALENDAR_CSS_PREFIX + className;
          };

          // Elements
          var navbarRange = $('.navbar--range');
          var prevButton = $('.prev');
          var nextButton = $('.next');
          var todayButton = $('.today');
          var dropdown = $('.app-column .dropdown');
          var dropdownTrigger = $('.dropdown-trigger');
          var dropdownTriggerIcon = $('.dropdown-icon');
          var dropdownContent = $('.dropdown-content');
          var checkboxCollapse = $('.checkbox-collapse');
          var sidebar = $('.sidebar');

          // App State
          var appState = {
              activeCalendarIds: MOCK_CALENDARS.map(function (calendar) {
                  return calendar.id;
              }),
              isDropdownActive: false,
          };

          // functions to handle calendar behaviors
          function reloadEvents() {
              var randomEvents;

              cal.clear();
              randomEvents = generateRandomEvents(
                  cal.getViewName(),
                  cal.getDateRangeStart(),
                  cal.getDateRangeEnd()
              );
              cal.createEvents(randomEvents);
          }

          function getReadableViewName(viewType) {
              switch (viewType) {
                  case 'month':
                      return 'Monthly';
                  case 'week':
                      return 'Weekly';
                  case 'day':
                      return 'Daily';
                  default:
                      throw new Error('no view type');
              }
          }

          function displayRenderRange() {
              let rangeStart = cal.getDateRangeStart();
              let rangeEnd = cal.getDateRangeEnd();

              navbarRange.textContent = getNavbarRange(rangeStart, rangeEnd, cal.getViewName());
          }

          function setDropdownTriggerText() {
              var viewName = cal.getViewName();
              var buttonText = $('.dropdown .button-text');
              buttonText.textContent = getReadableViewName(viewName);
          }

          function toggleDropdownState() {
              appState.isDropdownActive = !appState.isDropdownActive;
              dropdown.classList.toggle('is-active', appState.isDropdownActive);
              dropdownTriggerIcon.classList.toggle(cls('open'), appState.isDropdownActive);
              dropdown.querySelector('.dropdown-menu').style.display = appState.isDropdownActive ? 'block' : 'none';
          }

          function setAllCheckboxes(checked) {
              var checkboxes = $$('.sidebar-item > input[type="checkbox"]');

              checkboxes.forEach(function (checkbox) {
                  checkbox.checked = checked;
                  setCheckboxBackgroundColor(checkbox);
              });
          }

          function setCheckboxBackgroundColor(checkbox) {
              var calendarId = checkbox.value;
              var label = checkbox.nextElementSibling;
              var calendarInfo = MOCK_CALENDARS.find(function (calendar) {
                  return calendar.id === calendarId;
              });

              if (!calendarInfo) {
                  calendarInfo = {
                      backgroundColor: '#2a4fa7',
                  };
              }

              label.style.setProperty(
                  '--checkbox-' + calendarId,
                  checkbox.checked ? calendarInfo.backgroundColor : '#fff'
              );
          }

          function update() {
              setDropdownTriggerText();
              displayRenderRange();
              reloadEvents();
          }

          function bindAppEvents() {
              dropdownTrigger.addEventListener('click', toggleDropdownState);

              prevButton.addEventListener('click', function () {
                  cal.prev();
                  update();
              });

              nextButton.addEventListener('click', function () {
                  cal.next();
                  update();
              });

              todayButton.addEventListener('click', function () {
                  cal.today();
                  update();
              });

              dropdownContent.addEventListener('click', function (e) {
                  var targetViewName;

                  if ('viewName' in e.target.dataset) {
                      targetViewName = e.target.dataset.viewName;
                      cal.changeView(targetViewName);
                      checkboxCollapse.disabled = targetViewName === 'month';
                      toggleDropdownState();
                      update();
                  }
              });

              checkboxCollapse.addEventListener('change', function (e) {
                  if ('checked' in e.target) {
                      cal.setOptions({
                          week: {
                              collapseDuplicateEvents: !!e.target.checked,
                          },
                          useDetailPopup: !e.target.checked,
                      });
                  }
              });

              sidebar.addEventListener('click', function (e) {
                  if ('value' in e.target) {
                      if (e.target.value === 'all') {
                          if (appState.activeCalendarIds.length > 0) {
                              cal.setCalendarVisibility(appState.activeCalendarIds, false);
                              appState.activeCalendarIds = [];
                              setAllCheckboxes(false);
                          } else {
                              appState.activeCalendarIds = MOCK_CALENDARS.map(function (calendar) {
                                  return calendar.id;
                              });
                              cal.setCalendarVisibility(appState.activeCalendarIds, true);
                              setAllCheckboxes(true);
                          }
                      } else if (appState.activeCalendarIds.indexOf(e.target.value) > -1) {
                          appState.activeCalendarIds.splice(appState.activeCalendarIds.indexOf(e.target.value), 1);
                          cal.setCalendarVisibility(e.target.value, false);
                          setCheckboxBackgroundColor(e.target);
                      } else {
                          appState.activeCalendarIds.push(e.target.value);
                          cal.setCalendarVisibility(e.target.value, true);
                          setCheckboxBackgroundColor(e.target);
                      }
                  }
              });
          }

          function bindInstanceEvents() {
              cal.on({
                  clickMoreEventsBtn: function (btnInfo) {
                      console.log('clickMoreEventsBtn', btnInfo);
                  },
                  clickEvent: function (eventInfo) {
                      console.log('clickEvent', eventInfo);
                  },
                  clickDayName: function (dayNameInfo) {
                      console.log('clickDayName', dayNameInfo);
                  },
                  selectDateTime: function (dateTimeInfo) {
                      console.log('selectDateTime', dateTimeInfo);
                  },
                  beforeCreateEvent: function (event) {
                      console.log('beforeCreateEvent', event);
                      event.id = chance.guid();

                      cal.createEvents([event]);
                      cal.clearGridSelections();
                  },
                  beforeUpdateEvent: function (eventInfo) {
                      var event, changes;

                      console.log('beforeUpdateEvent', eventInfo);

                      event = eventInfo.event;
                      changes = eventInfo.changes;

                      cal.updateEvent(event.id, event.calendarId, changes);
                  },
                  beforeDeleteEvent: function (eventInfo) {
                      console.log('beforeDeleteEvent', eventInfo);

                      cal.deleteEvent(eventInfo.id, eventInfo.calendarId);
                  },
              });
          }

          function initCheckbox() {
              var checkboxes = $$('input[type="checkbox"]');

              checkboxes.forEach(function (checkbox) {
                  setCheckboxBackgroundColor(checkbox);
              });
          }

          function getEventTemplate(event, isAllday) {
              var html = [];
              var start = moment(event.start.toDate().toUTCString());
              if (!isAllday) {
                  html.push('<strong>' + start.format('HH:mm') + '</strong> ');
              }

              if (event.isPrivate) {
                  html.push('<span class="calendar-font-icon ic-lock-b"></span>');
                  html.push(' Private');
              } else {
                  if (event.recurrenceRule) {
                      html.push('<span class="calendar-font-icon ic-repeat-b"></span>');
                  } else if (event.attendees.length > 0) {
                      html.push('<span class="calendar-font-icon ic-user-b"></span>');
                  } else if (event.location) {
                      html.push('<span class="calendar-font-icon ic-location-b"></span>');
                  }
                  html.push(' ' + event.title);
              }

              return html.join('');
          }

          // Calendar instance with options
          // eslint-disable-next-line no-undef
          cal = new Calendar('#app', {
              calendars: MOCK_CALENDARS,
              useFormPopup: true,
              useDetailPopup: true,
              eventFilter: function (event) {
                  var currentView = cal.getViewName();
                  if (currentView === 'month') {
                      return ['allday', 'time'].includes(event.category) && event.isVisible;
                  }

                  return event.isVisible;
              },
              template: {
                  allday: function (event) {
                      return getEventTemplate(event, true);
                  },
                  time: function (event) {
                      return getEventTemplate(event, false);
                  },
              },
          });

          // Init
          bindInstanceEvents();
          bindAppEvents();
          initCheckbox();
          update();
      })(tui.Calendar);
  </script>
@endsection