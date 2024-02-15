<?php
$requestUri = $_SERVER['REQUEST_URI'];

// Map routes to respective PHP files
$routes = [
    '/api/appointments/appointment' => 'api/appointments/appointment.php',
    '/api/payments/create' => 'api/payments/payments.php',
    '/api/journals' => 'api/journals/journals.php',
    '/api/users/create' => 'api/users/userdata.php',
    '/api/users/update' => 'api/users/users.php',
    '/api/users/get' => 'api/users/users.php',
    '/api/register' => 'api/register/register.php',
    '/api/register/gp' => 'api/register/registergp.php',
    '/api/login' => 'api/login/login.php',
    '/api/patient' => 'api/patient/patient.php',
    '/api/patient/update' => 'api/patient/updatepatient.php',
    '/api/links' => 'api/links/links.php',
    '/api/uploads' => 'api/uploads/upload.php',
    '/api/profile' => 'api/profile/profile.php',

];

// Route request to appropriate file
if (array_key_exists($requestUri, $routes)) {
    require $routes[$requestUri];
} else {
    http_response_code(404);
    echo "Route not found";
}
?>
