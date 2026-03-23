# Project: Terminal Management System

## Assignment

Create a management system that runs in the terminal using pure PHP (no frameworks). The system must have an **interactive menu** with the following features:

- **Create** a new record with at least 4 fields (at least 1 string, 1 integer, and 1 boolean)
- **List** all registered records, sorted alphabetically
- **Search** records by name (partial and case-insensitive search)
- **Edit** an existing record (allowing to keep current values by pressing Enter)
- **Delete** a record with confirmation before removing
- **Statistics** — display at least 3 calculated pieces of information from the data (e.g.: total, average, count by status)

### Rules

1. Data must be stored in an **array of associative arrays**
2. Each record must have a unique **auto-generated ID**
3. All user inputs must be **validated** before saving
4. The code must be separated into **two files**: one for functions and another for the main loop
5. The menu must run in an **infinite loop** until the user chooses to exit

### Theme Examples

You can create a management system for any theme. Some examples:

- Contacts (name, email, phone, age)
- Books (title, author, pages, read/unread)
- Tasks (description, priority, deadline, completed)
- Products (name, price, quantity, available)
- Students (name, enrollment, grade, approved)

Choose a theme different from the example given in class.

---

## Reference Project Description

Contact Management System via terminal. The user interacts with a numbered menu to create, list, search, edit, and delete contacts. Data is persisted in a JSON file (`contacts.json`).

### File Structure

```
public/
  index.php      -> Entry point (requires source files)
src/
  App.php        -> Application class with main loop
  Menu.php       -> Menu display and input handling
  Contact.php    -> Contact entity
  ContactRepository.php -> Data persistence and queries
  Validator.php  -> Input validation
  Actions/       -> Action classes (Create, List, Search, Edit, Delete, Statistics)
data/
  contacts.json  -> Persistent contact storage
```

### Technologies and Concepts Applied

| Topic | How it was used |
|---|---|
| Basic syntax | `echo` for output, `readline()` for user input |
| Data types | `string` (name, email, phone), `int` (age, ID), `bool` (active/inactive) |
| Variables | `$contacts` (main array), `$idCounter` (ID generator), `$option` (menu control), `$contactsFile` (JSON path) |
| Operators | Comparison (`===`, `>`, `<=`) for validations, concatenation for displaying data, arithmetic for IDs and averages |
| Control structures | `switch` for the menu, `if/else` for validations (email, phone, age, contact existence) |
| Loop structures | `while(true)` for the menu loop, `foreach` for iterating contacts |
| Functions | Each action in a separate function: `createContact()`, `listContacts()`, `searchContact()`, `editContact()`, `deleteContact()`, `showStatistics()`, `loadContacts()`, `saveContacts()` |
| File manipulation | `file_exists()`, `file_get_contents()`, `file_put_contents()` for JSON persistence |
| Pass by reference | `&$contacts` and `&$counter` for modifying arrays and variables within functions |
| Type hints | Types in parameters (`string`, `array`, `int`, `bool`) and return (`: void`, `: string`, `: int`, `: bool`) |

### Native Functions Used

| Function | Where it was used |
|---|---|
| `trim()` | Clean whitespace from inputs |
| `strtolower()` | Case-insensitive search |
| `ucwords()` | Format names in listing |
| `str_contains()` | Partial name search |
| `strlen()` | Email and phone validation |
| `array_push()` | Add contact to array |
| `array_filter()` | Filter contacts in search and count active ones |
| `array_values()` | Reindex array after removal |
| `count()` | Total contacts and statistics |
| `usort()` | Sort contacts by name |
| `strcmp()` | String comparison for sorting |
| `number_format()` | Format age average |
| `unset()` | Remove contact from array |
| `file_exists()` | Check if JSON file exists before loading |
| `file_get_contents()` | Read JSON file contents |
| `file_put_contents()` | Save contacts to JSON file |
| `json_decode()` | Convert JSON to PHP array |
| `json_encode()` | Convert PHP array to JSON |
| `array_column()` | Extract ID column to calculate next ID |
| `max()` | Find the highest existing ID |

### System Menu

```
========================================
   CONTACT MANAGEMENT
========================================
 [1] Create contact
 [2] List contacts
 [3] Search contact
 [4] Edit contact
 [5] Delete contact
 [6] Statistics
 [0] Exit
========================================
```
