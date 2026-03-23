<?php

require_once __DIR__ . '/../src/Contact.php';
require_once __DIR__ . '/../src/Validator.php';
require_once __DIR__ . '/../src/ContactRepository.php';
require_once __DIR__ . '/../src/Menu.php';
require_once __DIR__ . '/../src/Actions/ActionInterface.php';
require_once __DIR__ . '/../src/Actions/CreateContact.php';
require_once __DIR__ . '/../src/Actions/ListContacts.php';
require_once __DIR__ . '/../src/Actions/SearchContact.php';
require_once __DIR__ . '/../src/Actions/EditContact.php';
require_once __DIR__ . '/../src/Actions/DeleteContact.php';
require_once __DIR__ . '/../src/Actions/ShowStatistics.php';
require_once __DIR__ . '/../src/App.php';

$app = new App(__DIR__ . '/../data/contacts.json');
$app->run();
