#Mountain Transit Theme Reference

This guide is intended to cover the layout and features of the Mountain Transit Theme. Any changes in functionality or additional template pages should be reflected here. Known site issues and suggestions for improvement should be submitted via Github's issue tracker.  

###Contents

* [Theme Features](#theme-features)
* [GTFS Update](#gtfs-update)
* [Template Files](#template-files)
* [Plugins](#plugins)
* [Credits](#credits)

##Theme Features

The Mountain Transit theme has many features editable from the wp-admin area, including adding News and Service Alerts, customizing the footer menus, uploading board meeting agendas and minutes, and editing timetables. Route pages are automatically created using `TSV Site Update`. 

####Adding Alerts

Alerts are created by adding a new News post and tagging it with the appropriate *Alert Zone(s)*. Possible Alert Zones can be found under *News:Alert Zone*.

##GTFS Update

TSV Site Update uses GTFS data to automatically create route pages. The data must be located in `wp-content/transit-data/route_data.tsv`. Additionally, the *Advanced Custom Fields* plugin must be installed for route pages to function. 

Errors in GTFS update indicate errors in GTFS feed data and should be corrected there; however, they may be temporarily fixed by editing fields in the appropriate **Route** page. 

##Template Files

- **404.php**
- **archive-alert.php**
- **archive-custom_type.php**
- **archive-dar.php**
- **archive-route.php**
- **archive.php**
- **big-bear-mapAreaCoords.php**
- **comments.php**
- **dar-table.php**
- **fares.php**
- **generic-page-bottom.php**
- **generic-page-top.php**
- **generic-sidebar.php**
- **header.php**
- **home-planner-mobile.php**
- **home-planner.php**
- **home-route-list-mobile.php**
- **home-route-list.php**
- **home.php**
- **index.php**
- **mapAreaCoords.php**
- **page-board-meetings.php**
- **page-custom.php**
- **page-home.php**
- **page-route.php**
- **page-routes-and-schedules.php**
- **page.php**
- **rim-mapAreaCoords.php**
- **route-header.php**
- **route-list.php**
- **routes\_and\_schedules\_table.php**
- **routes-page-map.php**
- **search.php**
- **secondary-icon-links.php**
- **sidebar.php**
- **single-custom-type.php**
- **single-dar.php**
- **single-route.php**
- **single-timetable.php**
- **single.php**
- **sml\_mapAreaCoords.php**
- **taxonomy-custom\_cat.php**
- **template-routes-and-schedules.php**

##Plugins

- Admin Menu Editor
- Advanced Custom Fields
- Contact Form 7

##Credits

Theme built by Trillium Solutions, Inc for Mountain Transit. 

This theme was built on top of Bones, a flexible, minimalist Wordpress theme for developers. 
Author: Eddie Machado
URL: http://themble.com/bones/
