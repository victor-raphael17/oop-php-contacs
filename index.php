<?php

require_once __DIR__ . '/src/Contato.php';
require_once __DIR__ . '/src/Validador.php';
require_once __DIR__ . '/src/ContatoRepository.php';
require_once __DIR__ . '/src/Menu.php';
require_once __DIR__ . '/src/Acoes/AcaoInterface.php';
require_once __DIR__ . '/src/Acoes/CadastrarContato.php';
require_once __DIR__ . '/src/Acoes/ListarContatos.php';
require_once __DIR__ . '/src/Acoes/BuscarContato.php';
require_once __DIR__ . '/src/Acoes/EditarContato.php';
require_once __DIR__ . '/src/Acoes/RemoverContato.php';
require_once __DIR__ . '/src/Acoes/ExibirEstatisticas.php';
require_once __DIR__ . '/src/App.php';

$app = new App(__DIR__ . '/dados/contatos.json');
$app->executar();
