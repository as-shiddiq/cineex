
![Cineex Logo](https://kodingakan.com/cineex.png)

# Cineex - CodeIgniter Next and Extendable

[![License](https://img.shields.io/badge/license-proprietary-blue.svg)](LICENSE)
[![PHP Version](https://img.shields.io/badge/php-%3E%3D7.4-blue.svg)](https://php.net)
[![CodeIgniter](https://img.shields.io/badge/CodeIgniter-4.6.1-orange.svg)](https://codeigniter.com/)

**Cineex** adalah framework PHP yang dibangun di atas CodeIgniter 4, dirancang untuk mempermudah pembuatan aplikasi web dengan sistem modular (HMVC). Framework ini menyediakan generator otomatis, REST API siap pakai, dan sistem autentikasi yang lengkap.

**Cineex** is a PHP framework built on top of CodeIgniter 4, designed to simplify web application development with a modular system (HMVC). It provides automatic generators, ready-to-use REST API, and complete authentication system.

---

## 📋 Daftar Isi / Table of Contents

- [Fitur Utama / Key Features](#-fitur-utama--key-features)
- [Teknologi / Technology Stack](#-teknologi--technology-stack)
- [Instalasi / Installation](#-instalasi--installation)
  - [Instalasi pada Proyek CodeIgniter Baru](#1-instalasi-pada-proyek-codeigniter-baru)
  - [Instalasi Tanpa CodeIgniter](#2-instalasi-tanpa-codeigniter-terinstall)
- [Konfigurasi / Configuration](#-konfigurasi--configuration)
- [Penggunaan / Usage](#-penggunaan--usage)
  - [Command Line Interface](#1-command-line-interface-cli)
  - [Membuat Module](#2-membuat-module)
  - [Generator Commands](#3-generator-commands)
  - [REST API](#4-rest-api)
- [Struktur Proyek / Project Structure](#-struktur-proyek--project-structure)
- [Dokumentasi Lengkap / Full Documentation](#-dokumentasi-lengkap--full-documentation)
- [Kontribusi / Contributing](#-kontribusi--contributing)
- [Lisensi / License](#-lisensi--license)

---

## ✨ Fitur Utama / Key Features

### 🚀 **Command Line Interface (CLI)**
Cineex menyediakan CLI tool (`run`) yang powerful untuk mempercepat development:
- Generator otomatis untuk Model, Controller, View, Migration, dll.
- Installer otomatis untuk setup database dan seeding
- Template replacer untuk customisasi tampilan

Cineex provides a powerful CLI tool (`run`) to speed up development:
- Automatic generators for Model, Controller, View, Migration, etc.
- Automatic installer for database setup and seeding
- Template replacer for UI customization

### 🧩 **Modular System (HMVC)**
- Sistem modular yang memudahkan kerja tim
- Module dapat digunakan kembali di proyek lain
- Isolasi kode yang lebih baik

Modular system for better team collaboration:
- Modules can be reused in other projects
- Better code isolation

### 🔌 **REST API Ready**
API siap pakai tanpa coding manual untuk:
- ✅ Create, Read, Update, Delete (CRUD)
- ✅ Multi-delete
- ✅ Nested arrays
- ✅ File upload
- ✅ JWT Authentication

Ready-to-use API without manual coding for CRUD operations, file uploads, and JWT authentication.

### 🔐 **Authentication System**
Fitur autentikasi lengkap sudah tersedia:
- Login & Sign up
- Forgot password
- User profile management
- Role-based access control

Complete authentication features out of the box.

### 🎨 **Template System**
- Template dapat diganti sesuai kebutuhan
- Dashboard UI sudah tersedia (Neumorphism UI)
- Support multiple templates

Customizable templates with built-in dashboard UI.

---

## 🛠 Teknologi / Technology Stack

Cineex menggunakan teknologi berikut / Cineex uses the following technologies:

| Teknologi | Versi | Kegunaan / Purpose |
|-----------|-------|-------------------|
| [CodeIgniter 4](https://codeigniter.com/) | 4.6.1 | Core Framework |
| [Neumorphism UI](https://themesberg.com/product/ui-kit/neumorphism-ui-kit-bootstrap) | - | CSS Framework |
| [Dompdf](https://github.com/dompdf/dompdf) | ^2.0 | PDF Generation |
| [UUID](https://github.com/ramsey/uuid) | ^4.0 | UUID Generation |
| [WebP Convert](https://github.com/rosell-dk/webp-convert) | ^2.9 | Image Conversion |
| [Firebase JWT](https://github.com/firebase/php-jwt) | ^5.2 | JWT Authentication |

---

## 📦 Instalasi / Installation

### Persyaratan / Requirements
- PHP >= 7.4
- Composer
- MySQL/MariaDB atau database lain yang didukung CodeIgniter 4
- Web server (Apache/Nginx)

### 1. Instalasi pada Proyek CodeIgniter Baru

Jika Anda sudah memiliki proyek CodeIgniter 4, ikuti langkah berikut:

**If you already have a CodeIgniter 4 project, follow these steps:**

#### Step 1: Install via Composer
```bash
composer require as-shiddiq/cineex
```

#### Step 2: Copy File Run dan Paths.php
```bash
# Copy file run sebagai CLI tool
cp vendor/as-shiddiq/cineex/run run

# Copy konfigurasi Paths.php
cp vendor/as-shiddiq/cineex/src/Default/app/Config/Paths.php app/Config/Paths.php
```

#### Step 3: Replace Default CodeIgniter Files
```bash
# Jalankan command untuk mengganti file default CodeIgniter
php run replace:all
```

> **Catatan / Note:** Command ini akan mengganti beberapa file default CodeIgniter dengan versi Cineex yang sudah dimodifikasi.

#### Step 4: Konfigurasi Environment
Edit file `.env` dan sesuaikan konfigurasi database Anda:

```env
#--------------------------------------------------------------------
# DATABASE
#--------------------------------------------------------------------
database.default.hostname = localhost
database.default.database = nama_database_anda
database.default.username = root
database.default.password = 
database.default.DBDriver = MySQLi

#--------------------------------------------------------------------
# CINEEX MODULES
#--------------------------------------------------------------------
cineex.modules = dashboard,user,settings
```

#### Step 5: Install dan Jalankan
```bash
# Install database, migrations, dan seeders
php run install

# Jalankan development server
php spark serve
```

Aplikasi Anda akan berjalan di `http://localhost:8080`

---

### 2. Instalasi Tanpa CodeIgniter Terinstall

Jika Anda belum menginstall CodeIgniter, ikuti langkah tambahan berikut:

**If you haven't installed CodeIgniter yet, follow these additional steps:**

#### Step 1: Install Cineex via Composer
```bash
composer require as-shiddiq/cineex
```

#### Step 2: Copy Folder CodeIgniter
```bash
# Copy folder public
cp -r vendor/codeigniter4/framework/public public

# Copy folder app
cp -r vendor/codeigniter4/framework/app app

# Copy folder writable
cp -r vendor/codeigniter4/framework/writable writable
```

#### Step 3: Update Paths.php
Edit file `app/Config/Paths.php` dan ubah path systemDirectory:

```php
public string $systemDirectory = __DIR__ . '/../../vendor/codeigniter4/framework/system';
```

#### Step 4: Lanjutkan dengan Step 2-5 dari Instalasi Normal
Ikuti Step 2 sampai Step 5 dari [Instalasi pada Proyek CodeIgniter Baru](#1-instalasi-pada-proyek-codeigniter-baru)

---

## ⚙️ Konfigurasi / Configuration

### File .env

Berikut adalah konfigurasi penting di file `.env`:

```env
#--------------------------------------------------------------------
# ENVIRONMENT
#--------------------------------------------------------------------
CI_ENVIRONMENT = development

#--------------------------------------------------------------------
# APP
#--------------------------------------------------------------------
app.baseURL = 'http://localhost:8080/'
app.indexPage = ''

#--------------------------------------------------------------------
# DATABASE
#--------------------------------------------------------------------
database.default.hostname = localhost
database.default.database = cineex_db
database.default.username = root
database.default.password = 
database.default.DBDriver = MySQLi
database.default.DBPrefix = 

#--------------------------------------------------------------------
# CINEEX CONFIGURATION
#--------------------------------------------------------------------
# Daftar module yang akan diaktifkan (pisahkan dengan koma)
cineex.modules = dashboard,user,blog,product

# Template untuk render (main, admin, dll)
cineex.template.main = neumorphism-ui
cineex.template.admin = neumorphism-ui

#--------------------------------------------------------------------
# RECAPTCHA (Optional)
#--------------------------------------------------------------------
# Untuk keamanan login, daftar di: https://www.google.com/recaptcha/admin
recaptcha.siteKey = your_site_key_here
recaptcha.secretKey = your_secret_key_here
```

---

## 🎯 Penggunaan / Usage

### 1. Command Line Interface (CLI)

Cineex menyediakan berbagai command untuk mempermudah development:

#### Melihat Daftar Command
```bash
php run list
```

#### Command Utama / Main Commands

| Command | Deskripsi / Description |
|---------|------------------------|
| `php run install` | Install database, migrations, dan seeders |
| `php run list` | Tampilkan semua command yang tersedia |
| `php run replace:all` | Replace semua file default CodeIgniter |
| `php run replace:app` | Replace folder app |
| `php run replace:config` | Replace konfigurasi |
| `php run replace:env` | Replace file .env |
| `php run replace:template` | Replace template UI |

---

### 2. Membuat Module

Module adalah komponen independen yang berisi Model, Controller, View, Migration, dll.

**Modules are independent components containing Models, Controllers, Views, Migrations, etc.**

#### Struktur Module
```
modules/
└── NamaModule/
    ├── Config/
    │   ├── Routes.php
    │   └── Filters.php
    ├── Controllers/
    │   └── NamaController.php
    ├── Models/
    │   └── NamaModel.php
    ├── Views/
    │   └── Main/
    │       └── index.php
    ├── Database/
    │   ├── Migrations/
    │   └── Seeds/
    └── Helpers/
```

#### Membuat Module Baru

1. **Buat folder module** di `modules/NamaModule/`
2. **Daftarkan module** di `.env`:
   ```env
   cineex.modules = dashboard,user,NamaModule
   ```
3. **Jalankan install** untuk register module:
   ```bash
   php run install
   ```

---

### 3. Generator Commands

Generator otomatis untuk membuat komponen module:

#### a. Membuat Migration
```bash
php run make:migration --module=Blog --table=posts

# Contoh migration yang dihasilkan:
# modules/Blog/Database/Migrations/2024_01_01_000000_posts.php
```

**File Migration:**
```php
<?php
namespace Modules\Blog\Database\Migrations;

use CodeIgniter\Database\Migration;

class Posts extends Migration
{
    public $table = 'posts';
    
    public $fields = [
        'id' => [
            'type' => 'VARCHAR',
            'constraint' => 36,
        ],
        'title' => [
            'type' => 'VARCHAR',
            'constraint' => 255,
        ],
        'content' => [
            'type' => 'TEXT',
        ],
        'created_at' => [
            'type' => 'DATETIME',
            'null' => true,
        ],
        'updated_at' => [
            'type' => 'DATETIME',
            'null' => true,
        ],
    ];

    public function up()
    {
        $this->forge->addField($this->fields);
        $this->forge->addKey('id', true);
        $this->forge->createTable($this->table);
    }

    public function down()
    {
        $this->forge->dropTable($this->table);
    }
}
```

#### b. Membuat Model
```bash
php run make:model --module=Blog Posts

# Otomatis generate model berdasarkan migration
# modules/Blog/Models/PostsModel.php
```

**Model yang dihasilkan:**
```php
<?php
namespace Modules\Blog\Models;

use CodeIgniter\Model;

class PostsModel extends Model
{
    protected $table = 'posts';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $allowedFields = ['id', 'title', 'content'];
    protected $useTimestamps = true;
    
    // Otomatis generate REST API methods
    public function apiGet($id = null) { ... }
    public function apiPost() { ... }
    public function apiPut($id) { ... }
    public function apiDelete($id) { ... }
}
```

#### c. Membuat Controller
```bash
php run make:controller --module=Blog Posts

# modules/Blog/Controllers/Posts.php
```

**Controller yang dihasilkan:**
```php
<?php
namespace Modules\Blog\Controllers;

use App\Controllers\BaseController;
use Modules\Blog\Models\PostsModel;

class Posts extends BaseController
{
    protected $model;
    
    public function __construct()
    {
        $this->model = new PostsModel();
    }
    
    public function index()
    {
        $data['posts'] = $this->model->findAll();
        return view('Modules\Blog\Views\Main\index', $data);
    }
    
    // CRUD methods otomatis tersedia
}
```

#### d. Membuat View
```bash
php run make:view --module=Blog --controller=Posts index

# modules/Blog/Views/Main/index.php
```

#### e. Membuat Route
```bash
php run make:route --module=Blog

# modules/Blog/Config/Routes.php
```

#### f. Membuat Filter
```bash
php run make:filter --module=Blog Auth

# modules/Blog/Config/Filters.php
```

#### g. Membuat Menu
```bash
php run make:menu --module=Blog

# Otomatis register menu ke database
```

---

### 4. REST API

Cineex menyediakan REST API otomatis untuk setiap model.

**Cineex provides automatic REST API for every model.**

#### Endpoint API Otomatis / Automatic API Endpoints

Setiap model otomatis memiliki endpoint berikut:

| Method | Endpoint | Deskripsi / Description |
|--------|----------|------------------------|
| GET | `/api/posts` | Get all posts |
| GET | `/api/posts/{id}` | Get single post |
| POST | `/api/posts` | Create new post |
| PUT | `/api/posts/{id}` | Update post |
| DELETE | `/api/posts/{id}` | Delete post |
| DELETE | `/api/posts/multi` | Multi-delete posts |

#### Contoh Penggunaan API / API Usage Examples

**1. Get All Data**
```bash
curl -X GET http://localhost:8080/api/posts
```

**Response:**
```json
{
  "status": "success",
  "data": [
    {
      "id": "uuid-1",
      "title": "Post 1",
      "content": "Content 1",
      "created_at": "2024-01-01 10:00:00"
    }
  ]
}
```

**2. Create Data**
```bash
curl -X POST http://localhost:8080/api/posts \
  -H "Content-Type: application/json" \
  -d '{
    "title": "New Post",
    "content": "This is content"
  }'
```

**3. Update Data**
```bash
curl -X PUT http://localhost:8080/api/posts/uuid-1 \
  -H "Content-Type: application/json" \
  -d '{
    "title": "Updated Post"
  }'
```

**4. Delete Data**
```bash
curl -X DELETE http://localhost:8080/api/posts/uuid-1
```

**5. Multi Delete**
```bash
curl -X DELETE http://localhost:8080/api/posts/multi \
  -H "Content-Type: application/json" \
  -d '{
    "ids": ["uuid-1", "uuid-2", "uuid-3"]
  }'
```

#### JWT Authentication

Untuk API yang memerlukan autentikasi:

```bash
# Login untuk mendapatkan token
curl -X POST http://localhost:8080/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "user@example.com",
    "password": "password123"
  }'

# Response:
{
  "status": "success",
  "token": "eyJ0eXAiOiJKV1QiLCJhbGc..."
}

# Gunakan token untuk request berikutnya
curl -X GET http://localhost:8080/api/posts \
  -H "Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGc..."
```

---

## 📁 Struktur Proyek / Project Structure

```
project-root/
├── app/                          # Aplikasi CodeIgniter default
│   ├── Config/
│   │   └── Paths.php            # Konfigurasi path Cineex
│   ├── Controllers/
│   ├── Models/
│   └── Views/
├── modules/                      # Folder untuk semua module
│   ├── Dashboard/
│   ├── User/
│   └── YourModule/
│       ├── Config/
│       │   ├── Routes.php
│       │   └── Filters.php
│       ├── Controllers/
│       ├── Models/
│       ├── Views/
│       │   └── Main/
│       ├── Database/
│       │   ├── Migrations/
│       │   └── Seeds/
│       └── Helpers/
├── public/                       # Public folder (document root)
│   ├── index.php
│   ├── templates/               # Template UI
│   │   └── neumorphism-ui/
│   └── assets/
├── vendor/                       # Composer dependencies
│   └── as-shiddiq/cineex/       # Cineex library
│       ├── src/
│       │   ├── Commands/        # CLI Commands
│       │   ├── Default/         # Default files
│       │   ├── Templates/       # UI Templates
│       │   ├── BaseCommand.php
│       │   ├── Boot.php
│       │   └── Cineex.php
│       └── run                  # CLI tool
├── writable/                     # Writable folder
│   ├── cache/
│   ├── logs/
│   └── uploads/
├── .env                          # Environment configuration
├── composer.json
└── run                           # CLI tool (copied from vendor)
```

---

## 📚 Dokumentasi Lengkap / Full Documentation

### Command Reference

#### Installation Commands
```bash
php run install                    # Install database dan seeders
```

#### Replacer Commands
```bash
php run replace:all               # Replace semua file
php run replace:app               # Replace folder app
php run replace:config            # Replace konfigurasi
php run replace:env               # Replace .env
php run replace:template          # Replace template
php run replace:reset             # Reset ke default
```

#### Generator Commands
```bash
php run make:migration --module=ModuleName --table=table_name
php run make:model --module=ModuleName ModelName
php run make:controller --module=ModuleName ControllerName
php run make:view --module=ModuleName --controller=ControllerName viewname
php run make:route --module=ModuleName
php run make:filter --module=ModuleName FilterName
php run make:menu --module=ModuleName
php run make:sitemap --module=ModuleName
```

#### Converter Commands
```bash
php run convert:module ModuleName  # Convert module
```

### Best Practices

1. **Gunakan Module untuk Setiap Fitur**
   - Pisahkan fitur ke dalam module terpisah
   - Mudah untuk maintenance dan reuse

2. **Ikuti Naming Convention**
   - Module: PascalCase (e.g., `UserManagement`)
   - Controller: PascalCase (e.g., `UserController`)
   - Model: PascalCase + Model suffix (e.g., `UserModel`)
   - Table: snake_case plural (e.g., `users`)

3. **Gunakan Migration untuk Database**
   - Jangan manual create table
   - Gunakan migration agar mudah di-track

4. **Manfaatkan Generator**
   - Gunakan command generator untuk konsistensi
   - Lebih cepat dan mengurangi error

5. **API First Development**
   - Buat model dulu, API otomatis tersedia
   - Frontend bisa langsung consume API

---

## 🤝 Kontribusi / Contributing

Kontribusi sangat diterima! Silakan:

1. Fork repository ini
2. Buat branch fitur (`git checkout -b feature/AmazingFeature`)
3. Commit perubahan (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buat Pull Request

Contributions are welcome! Please:
1. Fork this repository
2. Create feature branch
3. Commit your changes
4. Push to the branch
5. Create Pull Request

---

## 📄 Lisensi / License

Lisensi Proprietary. Lihat file [LICENSE](LICENSE) untuk detail.

Proprietary License. See [LICENSE](LICENSE) file for details.

---

## 👨‍💻 Author

**Nasrullah Siddik (as-shiddiq)**
- Email: nasrullahsiddik@gmail.com
- LinkedIn: [https://id.linkedin.com/in/as-shiddiq](https://id.linkedin.com/in/as-shiddiq)
- GitHub: [https://github.com/as-shiddiq](https://github.com/as-shiddiq)
- GitLab: [https://gitlab.com/as-shiddiq](https://gitlab.com/as-shiddiq)

---

## 🙏 Acknowledgments

- [CodeIgniter 4](https://codeigniter.com/) - Core Framework
- [Neumorphism UI](https://themesberg.com/) - UI Kit
- Semua kontributor dan pengguna Cineex

---

## 📞 Support

Jika Anda memiliki pertanyaan atau menemukan bug, silakan:
- Buat issue di repository ini
- Email ke: nasrullahsiddik@gmail.com

If you have questions or find bugs, please:
- Create an issue in this repository
- Email: nasrullahsiddik@gmail.com

---

**Happy Coding with Cineex! 🚀**