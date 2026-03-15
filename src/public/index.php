<?php

require_once __DIR__ . '/../Contact.php';
require_once __DIR__ . '/../Validator.php';
require_once __DIR__ . '/../ContactRepository.php';
require_once __DIR__ . '/../Menu.php';
require_once __DIR__ . '/../Actions/ActionInterface.php';
require_once __DIR__ . '/../Actions/CreateContact.php';
require_once __DIR__ . '/../Actions/ListContacts.php';
require_once __DIR__ . '/../Actions/SearchContact.php';
require_once __DIR__ . '/../Actions/EditContact.php';
require_once __DIR__ . '/../Actions/DeleteContact.php';
require_once __DIR__ . '/../Actions/ShowStatistics.php';
require_once __DIR__ . '/../App.php';

$app = new App(__DIR__ . '/dados/contatos.json');
$app->run();
