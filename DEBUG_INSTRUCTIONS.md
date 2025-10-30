# 🔍 Debug Instructions for "Whoops!" Error

The "Whoops! We seem to have hit a snag" message means CodeIgniter is hiding the actual error because you're in production mode.

## Step 1: Enable Debug Mode (Temporarily)

**Upload this file to server:**
- **Local:** `/Applications/XAMPP/xamppfiles/htdocs/rkgroup.biz/.env.debug`
- **Server:** `/home4/tempucqs/public_html/rkgroup.biz/new_site/.env`
- **Action:** Rename `.env` to `.env.backup`, then upload `.env.debug` as `.env`

This will show the actual error message. **Once you see the error, send it to me.**

---

## Step 2: Common Issues to Check

### 1. Writable Folder Permissions
The `writable` folder needs proper permissions:

```bash
chmod -R 755 /home4/tempucqs/public_html/rkgroup.biz/new_site/writable/
```

Or via cPanel File Manager:
- Right-click `writable` folder
- Change Permissions to `755` (or `777` temporarily for testing)

### 2. Missing Config Files
Ensure these files exist on server:
- ✅ `app/Config/App.php`
- ✅ `app/Config/Exceptions.php`
- ✅ `app/Config/Paths.php`
- ✅ `app/Config/Database.php`
- ✅ `app/Config/Routes.php`

### 3. Database Connection
Test database connection:
- Database: `tempucqs_rkgroup_new_website`
- Username: `tempucqs_rkgroup_new_website`
- Password: `TzA!&xgx[plp\`

### 4. Admin Table
Make sure admin table is imported:
```sql
-- Check if table exists
SHOW TABLES LIKE 'admin';

-- Check if user exists
SELECT * FROM admin;
```

### 5. Base URL in App.php
Check `/app/Config/App.php` line 19:
```php
public string $baseURL = 'https://rkgroup.biz/new_site/';
```

### 6. System Folder
Ensure entire `system` folder is uploaded (CI4 4.4.8)

---

## Step 3: Check Error Logs

### CodeIgniter Logs
Check: `/home4/tempucqs/public_html/rkgroup.biz/new_site/writable/logs/`

Look for files like: `log-2025-10-30.log`

### Apache Error Logs
Via cPanel: Metrics → Errors

Or check: `/home4/tempucqs/logs/error_log`

---

## Step 4: Quick Test Files

### Test 1: PHP Info
Create file: `/home4/tempucqs/public_html/rkgroup.biz/new_site/phpinfo.php`
```php
<?php
phpinfo();
```

Visit: `https://rkgroup.biz/new_site/phpinfo.php`
- Check PHP version (should be 7.4+)
- Check if `mysqli` extension is enabled

### Test 2: Database Connection
Create file: `/home4/tempucqs/public_html/rkgroup.biz/new_site/testdb.php`
```php
<?php
$mysqli = new mysqli("localhost", "tempucqs_rkgroup_new_website", "TzA!&xgx[plp\\", "tempucqs_rkgroup_new_website");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
echo "Database connected successfully!";
$mysqli->close();
```

Visit: `https://rkgroup.biz/new_site/testdb.php`

---

## Step 5: After Debugging

Once fixed, **restore production mode**:
1. Rename `.env` to `.env.debug`
2. Rename `.env.backup` to `.env`
3. Delete `phpinfo.php` and `testdb.php`

---

## 📧 Send Me This Info:

1. **Error message** after enabling debug mode (Step 1)
2. **Writable folder permissions** (output of `ls -la writable/`)
3. **CodeIgniter log files** (latest entries from `writable/logs/`)
4. **PHP version** (from phpinfo.php or cPanel)
5. **Database test result** (from testdb.php)

This will help me identify the exact issue! 🔍
