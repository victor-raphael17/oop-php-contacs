# Execution Flow - Sistema de Gerenciamento de Contatos

## Overview

This is a **CLI-based Contact Management System** written in pure PHP. It runs as an interactive terminal application with JSON file persistence. The project consists of three files:

- `index.php` — Entry point, main loop, and routing
- `funcoes.php` — All business logic functions (14 functions)
- `contatos.json` — JSON file for persistent contact storage

---

## 1. Application Startup

```
$ php index.php
```

```
index.php
│
├── require_once 'funcoes.php'      ← Loads all 14 functions into scope
├── $arquivoContatos = 'contatos.json'
├── $contatos = carregarContatos()  ← Loads contacts from JSON file (or empty array if file missing)
├── $contadorId = max(IDs) + 1     ← Calculates next ID from existing contacts (or 1 if empty)
├── echo "Bem-vindo..."             ← Welcome message
│
└── while (true) { ... }           ← Enters infinite main loop
```

---

## 2. Main Loop (Event Cycle)

Each iteration of the loop follows this sequence:

```
┌─────────────────────────────────────────────┐
│              exibirMenu()                   │
│  Prints the numbered menu (options 0-6)     │
└──────────────────┬──────────────────────────┘
                   ▼
┌─────────────────────────────────────────────┐
│  $opcao = lerEntrada("Escolha uma opção: ") │
│  readline() → trim() → returns string       │
└──────────────────┬──────────────────────────┘
                   ▼
┌─────────────────────────────────────────────┐
│            switch ($opcao)                  │
│                                             │
│  '1' → cadastrarContato() → salvarContatos()  (Create + Save) │
│  '2' → listarContatos()                       (List)          │
│  '3' → buscarContato()                        (Search)        │
│  '4' → editarContato()  → salvarContatos()    (Update + Save) │
│  '5' → removerContato() → salvarContatos()    (Delete + Save) │
│  '6' → exibirEstatisticas()                   (Stats)         │
│  '0' → echo goodbye → exit(0)              │
│  default → "Opção inválida"                 │
└──────────────────┬──────────────────────────┘
                   ▼
            Loop repeats
```

The loop only breaks when the user selects `'0'`, which calls `exit(0)`.

---

## 3. Data Structure

Contacts are stored as an array of associative arrays. Each contact:

```php
[
    'id'       => int,    // Auto-generated, starts at 1
    'nome'     => string, // Name
    'email'    => string, // Email
    'telefone' => string, // Phone
    'idade'    => int,    // Age (1-150)
    'ativo'    => bool,   // Active status (default: true)
]
```

Data is loaded from `contatos.json` on startup and saved back to the file after every create, edit, and delete operation. Contacts persist across sessions.

---

## 4. Function Map

### Utility Functions

| Function | Signature | Purpose |
|---|---|---|
| `exibirMenu` | `(): void` | Prints the menu options |
| `lerEntrada` | `(string $msg): string` | Wraps `readline()` + `trim()` |
| `gerarId` | `(int &$contador): int` | Returns current ID, then increments (`$contador++`) |
| `validarEmail` | `(string $email): bool` | Checks for `@` and `strlen >= 5` |
| `validarTelefone` | `(string $tel): bool` | Checks `strlen > 0` |
| `ordenarContatos` | `(array &$contatos): void` | `usort` alphabetically by name (case-insensitive) |
| `carregarContatos` | `(string $arquivo): array` | Reads contacts from JSON file (returns `[]` if file missing) |
| `salvarContatos` | `(string $arquivo, array $contatos): void` | Writes contacts to JSON file with pretty print |

### CRUD Functions

| Function | Signature | Purpose |
|---|---|---|
| `cadastrarContato` | `(array &$contatos, int &$contador): void` | Create a new contact |
| `listarContatos` | `(array $contatos): void` | List all contacts (sorted) |
| `buscarContato` | `(array $contatos): void` | Search by name (partial, case-insensitive) |
| `editarContato` | `(array &$contatos): void` | Update a contact by ID |
| `removerContato` | `(array &$contatos): void` | Delete a contact by ID (with confirmation) |
| `exibirEstatisticas` | `(array $contatos): void` | Show total, active, inactive, avg age |

> Functions that modify data receive `&$contatos` (pass-by-reference).
> Functions that only read data receive `$contatos` (pass-by-value).

---

## 5. Detailed Flow per Operation

### [1] Create — `cadastrarContato(&$contatos, &$contador)`

```
Prompt "Nome" → validate non-empty
    ↓ (fail → echo error → return)
Prompt "Email" → validarEmail()
    ↓ (fail → echo error → return)
Prompt "Telefone" → validarTelefone()
    ↓ (fail → echo error → return)
Prompt "Idade" → cast to int → check 0 < idade <= 150
    ↓ (fail → echo error → return)
$id = gerarId(&$contador)   ← returns current value, increments counter
Build $contato associative array (ativo defaults to true)
array_push($contatos, $contato)
Echo success with ID
    ↓
salvarContatos()  ← persists to JSON file
```

### [2] List — `listarContatos($contatos)`

```
Check count === 0 → "Nenhum contato" → return
    ↓
ordenarContatos($contatos)  ← sorts alphabetically by name (case-insensitive)
    ↓
foreach → format and print each contact
    ↓
Echo total count
```

### [3] Search — `buscarContato($contatos)`

```
Check count === 0 → return
Prompt search term → validate non-empty
    ↓
$termoLower = strtolower($termo)
array_filter() with str_contains() on lowercase name
    ↓
No results → echo "not found" → return
    ↓
foreach → print matching contacts
```

### [4] Edit — `editarContato(&$contatos)`

```
Check count === 0 → return
Prompt ID → cast to int
    ↓
foreach to find index by ID
    ↓
Not found → echo error → return
    ↓
For each field (nome, email, telefone, idade, ativo):
  - Show current value as default in prompt
  - If user presses Enter (empty input) → keep current value
  - If user types new value → validate → update or echo error
    ↓
Echo "Contato atualizado com sucesso!"
    ↓
salvarContatos()  ← persists to JSON file
```

### [5] Delete — `removerContato(&$contatos)`

```
Check count === 0 → return
Prompt ID → cast to int → find index
    ↓
Not found → echo error → return
    ↓
Prompt confirmation "s/n"
    ↓
's' → unset($contatos[$indice]) → array_values() to reindex → echo success
other → echo "Remoção cancelada"
    ↓
salvarContatos()  ← persists to JSON file
```

### [6] Statistics — `exibirEstatisticas($contatos)`

```
$total = count($contatos)
    ↓
total === 0 → return
    ↓
$ativos = count(array_filter(...)) where ativo === true
$inativos = $total - $ativos
$mediaIdade = sum of all ages / $total
    ↓
Echo: total, ativos, inativos, média (1 decimal place)
```

---

## 6. Validation Rules

| Field | Rule | Error Message |
|---|---|---|
| Nome | `!== ''` | "Nome não pode ser vazio." |
| Email | contains `@` AND `strlen >= 5` | "Email inválido..." |
| Telefone | `strlen > 0` | "Telefone não pode ser vazio." |
| Idade | `int`, `> 0` AND `<= 150` | "Idade inválida." |

Validation failures cause an **early return** — no data is saved.

---

## 7. Key Design Characteristics

- **JSON file persistence** — contacts are saved to `contatos.json` after every mutation (create, edit, delete)
- **No database** — pure PHP arrays + JSON file
- **No OOP** — procedural functions only
- **No framework** — pure PHP with `readline()` for CLI interaction
- **No authentication** — single-user terminal application
- **Pass-by-reference** (`&`) for functions that mutate the contacts array or the ID counter
- **Linear search** — contacts are found by iterating with `foreach`, not indexed lookups
