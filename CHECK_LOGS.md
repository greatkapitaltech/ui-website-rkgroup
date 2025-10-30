# 📋 How to Check Error Logs

The Kint library error is masking the real error. Here's how to find the actual problem:

## Method 1: Check CodeIgniter Logs

### Via cPanel File Manager:
1. Navigate to: `/home4/tempucqs/public_html/rkgroup.biz/new_site/writable/logs/`
2. Look for today's log file: `log-2025-10-30.log`
3. Open it and look for ERROR or CRITICAL entries
4. **Send me the last 50 lines of this file**

### Via SSH:
```bash
tail -50 /home4/tempucqs/public_html/rkgroup.biz/new_site/writable/logs/log-2025-10-30.log
```

## Method 2: Test Database Connection

Upload and visit: `testdb.php`
- **Upload:** `/Applications/XAMPP/xamppfiles/htdocs/rkgroup.biz/testdb.php`
- **To:** `/home4/tempucqs/public_html/rkgroup.biz/new_site/testdb.php`
- **Visit:** https://rkgroup.biz/new_site/testdb.php

This will show if database is the problem.

## Method 3: Check Writable Folder Permissions

The `writable` folder needs write permissions for logs and cache.

### Via cPanel:
1. Go to File Manager
2. Right-click `/writable/` folder
3. Change Permissions
4. Set to `755` or `777` (for testing)
5. Check "Recurse into subdirectories"
6. Click "Change Permissions"

### Via SSH:
```bash
chmod -R 755 /home4/tempucqs/public_html/rkgroup.biz/new_site/writable/
```

## Method 4: Check if All Files Are Uploaded

Make sure these critical files exist on server:
- ✅ `/index.php` (root, not in /public)
- ✅ `/app/Config/App.php`
- ✅ `/app/Config/Database.php`
- ✅ `/app/Config/Routes.php`
- ✅ `/app/Controllers/Frontend.php`
- ✅ `/app/Controllers/Admin.php`
- ✅ `/system/` (entire folder from CI4 4.4.8)
- ✅ `/.env`

## Most Likely Issues:

### 1. Writable Folder Permissions
If the writable folder doesn't have correct permissions, CI4 can't write logs or create cache files.

**Fix:**
```bash
chmod -R 755 writable/
```

### 2. Missing Database Tables
If admin or other tables aren't imported, the app will crash.

**Fix:** Import these SQL files:
- `admin_table.sql` (creates admin authentication table)
- `database_schema.sql` (creates all website content tables)

### 3. Incorrect Base URL
If baseURL in App.php doesn't match your actual URL.

**Check:** `/app/Config/App.php` line 19 should be:
```php
public string $baseURL = 'https://rkgroup.biz/new_site/';
```

## 📧 Send Me:

1. **Last 50 lines from `/writable/logs/log-YYYY-MM-DD.log`**
2. **Result from `testdb.php`**
3. **Screenshot of writable folder permissions**

This will help me identify the exact issue! 🔍
