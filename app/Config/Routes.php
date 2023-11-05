<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Auth
$routes->get('/auth', 'Auth::index');
$routes->post('/auth/login', 'Auth::login');
$routes->get('/auth/register', 'Auth::register');
$routes->post('/auth/add_register', 'Auth::add_register');
$routes->get('/auth/logout', 'Auth::logout');

// Route track shipment
$routes->get('/', 'Home::index', ['filter' => 'auth']);
$routes->post('/home/get_data_track_shipment', 'Home::get_data_track_shipment');
$routes->post('/home/get_data_dropdown', 'Home::get_data_dropdown');
$routes->post('/home/get_data_portline', 'Home::get_data_portline');
$routes->post('/home/get_vessel_number', 'Home::get_vessel_number');
$routes->post('/home/add_data_shipment', 'Home::add_data_shipment');
$routes->post('/home/delete_tracking', 'Home::delete_tracking');

// Route Tracking Shipment
$routes->get('/tracking/container/(:num)', 'Tracking::container/$1', ['filter' => 'auth']);
$routes->post('/tracking/get_data_track_shipment', 'Tracking::get_data_track_shipment');
$routes->post('/tracking/get_data_dropdown', 'Tracking::get_data_dropdown');
$routes->post('/tracking/get_data_port_name', 'Tracking::get_data_port_name');
$routes->post('/tracking/add_data_tracking_event', 'Tracking::add_data_tracking_event');
$routes->post('/tracking/get_side_tracking', 'Tracking::get_side_tracking');
$routes->post('/tracking/get_data_tracking_events', 'Tracking::get_data_tracking_events');
$routes->post('/tracking/change_status_track', 'Tracking::change_status_track');
$routes->post('/tracking/get_data_containers', 'Tracking::get_data_containers');
$routes->post('/tracking/get_status_direct', 'Tracking::get_status_direct');
$routes->post('/tracking/table_edit_activity', 'Tracking::table_edit_activity');
$routes->post('/tracking/delete_activity_event', 'Tracking::delete_activity_event');
$routes->post('/tracking/add_data_container', 'Tracking::add_data_container');
$routes->post('/tracking/delete_container', 'Tracking::delete_container');
$routes->post('/tracking/table_document', 'Tracking::table_document');
$routes->post('/tracking/delete_file_document', 'Tracking::delete_file_document');
$routes->post('/tracking/add_data_document', 'Tracking::add_data_document');

// Route vessel schedules
$routes->get('/vessel_schedules', 'VesselSchedules::index', ['filter' => 'auth']);
$routes->post('/vessel/get_data_vessel', 'VesselSchedules::get_data_vessel');
$routes->post('/vessel/get_shipping_line', 'VesselSchedules::get_shipping_line');
$routes->post('/vessel/get_port_line', 'VesselSchedules::get_port_line');
$routes->post('/vessel/add_data_vessel', 'VesselSchedules::add_data_vessel');
$routes->post('/vessel/cek_before_delete', 'VesselSchedules::cek_before_delete');
$routes->post('/vessel/delete_vessel', 'VesselSchedules::delete_vessel');
$routes->get('/vessel/edit_vessel/(:num)', 'VesselSchedules::edit_vessel/$1');
$routes->post('/vessel/get_data_vessel_by_id', 'VesselSchedules::get_data_vessel_by_id');
$routes->post('/vessel/get_data_transshipment', 'VesselSchedules::get_data_transshipment');
$routes->post('/vessel/delete_transshipment', 'VesselSchedules::delete_transshipment');
$routes->post('/vessel/add_data_transshipment', 'VesselSchedules::add_data_transshipment');
$routes->post('/vessel/edit_data_vessel', 'VesselSchedules::edit_data_vessel');

// Route data Setup Status
$routes->get('/setup/status', 'DataSetup::status', ['filter' => 'auth']);
$routes->post('/dataSetup/add_data_setup_status', 'DataSetup::add_data_setup_status');
$routes->post('/dataSetup/get_data_setup_status', 'DataSetup::get_data_setup_status');
$routes->post('/dataSetup/delete_data_setup_status', 'DataSetup::delete_data_setup_status');

// Route data Setup Shipping Line
$routes->get('/setup/shippingline', 'DataSetup::shippingline', ['filter' => 'auth']);
$routes->post('/dataSetup/add_data_setup_shippingline', 'DataSetup::add_data_setup_shippingline');
$routes->post('/dataSetup/get_data_setup_shippingline', 'DataSetup::get_data_setup_shippingline');
$routes->post('/dataSetup/delete_data_setup_shippingline', 'DataSetup::delete_data_setup_shippingline');

// Route data Setup shipper
$routes->get('/setup/shipper', 'DataSetup::shipper', ['filter' => 'auth']);
$routes->post('/dataSetup/add_data_setup_shipper', 'DataSetup::add_data_setup_shipper');
$routes->post('/dataSetup/get_data_setup_shipper', 'DataSetup::get_data_setup_shipper');
$routes->post('/dataSetup/delete_data_setup_shipper', 'DataSetup::delete_data_setup_shipper');

// Route data Setup portline
$routes->get('/setup/portline', 'DataSetup::portline', ['filter' => 'auth']);
$routes->post('/dataSetup/add_data_setup_portline', 'DataSetup::add_data_setup_portline');
$routes->post('/dataSetup/get_data_setup_portline', 'DataSetup::get_data_setup_portline');
$routes->post('/dataSetup/delete_data_setup_portline', 'DataSetup::delete_data_setup_portline');

// Route data Setup incoterm
$routes->get('/setup/incoterm', 'DataSetup::incoterm', ['filter' => 'auth']);
$routes->post('/dataSetup/add_data_setup_incoterm', 'DataSetup::add_data_setup_incoterm');
$routes->post('/dataSetup/get_data_setup_incoterm', 'DataSetup::get_data_setup_incoterm');
$routes->post('/dataSetup/delete_data_setup_incoterm', 'DataSetup::delete_data_setup_incoterm');

// Route data Setup profile
$routes->get('/setup/profile', 'DataSetup::profile', ['filter' => 'auth']);
$routes->post('/dataSetup/add_data_setup_profile', 'DataSetup::add_data_setup_profile');
$routes->post('/dataSetup/get_data_setup_profile', 'DataSetup::get_data_setup_profile');

// Route data Setup users
$routes->get('/setup/users', 'DataSetup::users', ['filter' => 'auth']);
$routes->post('/dataSetup/get_data_setup_users', 'DataSetup::get_data_setup_users');
$routes->post('/dataSetup/delete_data_setup_users', 'DataSetup::delete_data_setup_users');
