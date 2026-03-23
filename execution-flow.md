# Execution Flow - Contact Management System

## Overview

This is a **CLI-based Contact Management System** written in pure PHP. It runs as an interactive terminal application with JSON file persistence. The project consists of:

- `public/index.php` — Entry point, requires all source files
- `src/` — All business logic classes (App, Menu, Contact, ContactRepository, Validator, Actions)
- `data/contacts.json` — JSON file for persistent contact storage

---

## 1. Application Startup

```
$ php public/index.php
```

```
public/index.php
│
├── require_once all src/ classes     ← Loads all classes into scope
├── $app = new App('data/contacts.json')
│   ├── new Menu()
│   ├── new ContactRepository(file)   ← Loads contacts from JSON file (or empty array if file missing)
│   └── Register action handlers (1-6)
└── $app->run()
    ├── echo "Welcome..."             ← Welcome message
    └── while (true) { ... }          ← Enters infinite main loop
```

---

## 2. Main Loop (Event Cycle)

Each iteration of the loop follows this sequence:

```
┌─────────────────────────────────────────────┐
│              Menu::display()                │
│  Prints the numbered menu (options 0-6)     │
└──────────────────┬──────────────────────────┘
                   ▼
┌─────────────────────────────────────────────┐
│  $option = Menu::readInput("Choose an       │
│  option: ")                                 │
│  readline() → trim() → returns string       │
└──────────────────┬──────────────────────────┘
                   ▼
┌─────────────────────────────────────────────┐
│            Action dispatch                  │
│                                             │
│  '1' → CreateContact::execute()    (Create + Save) │
│  '2' → ListContacts::execute()     (List)          │
│  '3' → SearchContact::execute()    (Search)        │
│  '4' → EditContact::execute()      (Update + Save) │
│  '5' → DeleteContact::execute()    (Delete + Save) │
│  '6' → ShowStatistics::execute()   (Stats)         │
│  '0' → echo goodbye → exit(0)                      │
│  default → "Invalid option"                         │
└──────────────────┬──────────────────────────┘
                   ▼
            Loop repeats
```

The loop only breaks when the user selects `'0'`, which calls `exit(0)`.

---

## 3. Data Structure

Contacts are stored in memory as `Contact` objects and serialized to JSON as associative arrays:

```php
// In memory: Contact object with typed properties
Contact(
    id: int,       // Auto-generated, starts at 1
    name: string,  // Name
    email: string, // Email
    phone: string, // Phone
    age: int,      // Age (1-150)
    active: bool,  // Active status (default: true)
)

// In JSON (data/contacts.json):
{ "id": 1, "name": "...", "email": "...", "phone": "...", "age": 30, "active": true }
```

Data is loaded from `data/contacts.json` on startup and saved back to the file after every create, edit, and delete operation. Contacts persist across sessions.

---

## 4. Class Map

### Core Classes

| Class | Purpose |
|---|---|
| `App` | Main application: initializes dependencies, runs main loop |
| `Menu` | Handles display and user input (`readline` + `trim`) |
| `Contact` | Entity with getters/setters and array serialization |
| `ContactRepository` | Loads, saves, queries, and manages contacts |
| `Validator` | Static validation methods: `validateName`, `validateEmail`, `validatePhone`, `validateAge`, `validateAgeInput` |

### Action Classes (implement `ActionInterface`)

| Class | Purpose |
|---|---|
| `CreateContact` | Create a new contact |
| `ListContacts` | List all contacts (sorted) |
| `SearchContact` | Search by name (partial, case-insensitive) |
| `EditContact` | Update a contact by ID |
| `DeleteContact` | Delete a contact by ID (with confirmation) |
| `ShowStatistics` | Show total, active, inactive, avg age |

---

## 5. Detailed Flow per Operation

### [1] Create — `CreateContact::execute()`

```
Prompt "Name" → Validator::validateName()
    ↓ (fail → "Name cannot be empty." → return)
Prompt "Email" → Validator::validateEmail()
    ↓ (fail → "Invalid email..." → return)
Prompt "Phone" → Validator::validatePhone()
    ↓ (fail → "Phone cannot be empty." → return)
Prompt "Age" → Validator::validateAgeInput()
    ↓ (fail → "Invalid age..." → return)
ContactRepository::add(name, email, phone, age)
    ├── Creates Contact with auto-incremented ID
    ├── Adds to contacts array
    └── Saves to JSON file
Echo "Contact created successfully! (ID: ...)"
```

### [2] List — `ListContacts::execute()`

```
Check total === 0 → "No contacts registered" → return
    ↓
ContactRepository::listSorted()  ← sorts alphabetically by name (case-insensitive)
    ↓
foreach → Menu::displayContact() for each contact
    ↓
Echo total count
```

### [3] Search — `SearchContact::execute()`

```
Check total === 0 → "No contacts registered." → return
Prompt search term → validate non-empty
    ↓ (empty → "Search term cannot be empty." → return)
ContactRepository::searchByName(term)
    ├── strtolower on term
    └── array_filter with str_contains() on lowercase name
    ↓
No results → "No contacts found for ..." → return
    ↓
Echo "N contact(s) found:"
foreach → Menu::displayContact() for each result
```

### [4] Edit — `EditContact::execute()`

```
Check total === 0 → "No contacts registered." → return
Prompt ID → cast to int
    ↓
ContactRepository::findById(id)
    ↓
Not found → echo error → return
    ↓
Echo "Editing: {name} (press Enter to keep current value)"
    ↓
Prompt "Name [current]"   → empty keeps current, otherwise sets directly
Prompt "Email [current]"  → empty keeps current, otherwise Validator::validateEmail()
Prompt "Phone [current]"  → empty keeps current, otherwise sets directly
Prompt "Age [current]"    → empty keeps current, otherwise Validator::validateAgeInput()
Prompt "Status (1=Active, 0=Inactive) [current]" → empty keeps current, '1' = active, anything else = inactive
    ↓
ContactRepository::save()  ← persists to JSON file
Echo "Contact updated successfully!"
```

### [5] Delete — `DeleteContact::execute()`

```
Check total === 0 → return
Prompt ID → cast to int → findById
    ↓
Not found → echo error → return
    ↓
Prompt confirmation "y/n"
    ↓
'y' → ContactRepository::remove(id) → reindex → save → echo success
other → echo "Deletion cancelled"
```

### [6] Statistics — `ShowStatistics::execute()`

```
$total = ContactRepository::total()
    ↓
total === 0 → return
    ↓
$active = ContactRepository::totalActive()
$inactive = $total - $active
$averageAge = ContactRepository::averageAge()
    ↓
Echo: total, active, inactive, average age (1 decimal place)
```

---

## 6. Validation Rules

| Field | Validator Method | Rule | Error Message |
|---|---|---|---|
| Name | `validateName()` | `!== ''` | "Name cannot be empty." |
| Email | `validateEmail()` | `filter_var(FILTER_VALIDATE_EMAIL)` | "Invalid email." |
| Phone | `validatePhone()` | `strlen > 0` | "Phone cannot be empty." |
| Age | `validateAgeInput()` | `ctype_digit()` + `int > 0` AND `<= 150` | "Invalid age. Must be a number between 1 and 150." |

Validation failures cause an **early return** — no data is saved.

---

## 7. Key Design Characteristics

- **JSON file persistence** — contacts are saved to `data/contacts.json` after every mutation (create, edit, delete)
- **No database** — PHP objects + JSON file
- **OOP architecture** — classes with single responsibility, Action pattern for menu operations
- **No framework** — pure PHP with `readline()` for CLI interaction
- **No authentication** — single-user terminal application
- **Repository pattern** — `ContactRepository` encapsulates all data access and persistence
- **Interface-based actions** — all menu actions implement `ActionInterface`
