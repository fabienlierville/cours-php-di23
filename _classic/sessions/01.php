<?php
session_start();
$_SESSION['masession'] = [
    'Email' => 'flierville@cesi.Fr',
    'roles' => ['redacteur','relecteur'],
    'nickname' => 'flierville',
] ;