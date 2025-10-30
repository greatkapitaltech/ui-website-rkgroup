# 📁 CREATE UPLOAD DIRECTORIES

## Required for File Uploads

After uploading all files, you need to create these directories on production with proper permissions.

---

## 🗂️ Directories to Create

Create these directories in: `/home4/tempucqs/public_html/rkgroup.biz/new_site/`

### 1. Companies Logos
```bash
mkdir -p assets/uploads/companies
chmod 755 assets/uploads/companies
```

### 2. Partners Logos
```bash
mkdir -p assets/uploads/partners
chmod 755 assets/uploads/partners
```

### 3. Board Members Photos
```bash
mkdir -p assets/uploads/board_members
chmod 755 assets/uploads/board_members
```

### 4. Timeline Images
```bash
mkdir -p assets/uploads/timeline
chmod 755 assets/uploads/timeline
```

---

## 🔐 Set Permissions

Make sure the web server can write to these directories:

```bash
chmod 755 assets/uploads
chmod 755 assets/uploads/companies
chmod 755 assets/uploads/partners
chmod 755 assets/uploads/board_members
chmod 755 assets/uploads/timeline
```

Or via cPanel File Manager:
1. Navigate to each folder
2. Right-click → Change Permissions
3. Set to **755** (Owner: Read, Write, Execute | Group: Read, Execute | World: Read, Execute)

---

## ✅ How File Upload Works Now

### Companies
- **Field:** Logo
- **Upload to:** `assets/uploads/companies/`
- **Display:** Thumbnail 100x50px in grid
- **Frontend URL:** `base_url('assets/uploads/companies/filename.jpg')`

### Partners
- **Field:** Logo
- **Upload to:** `assets/uploads/partners/`
- **Display:** Thumbnail 100x50px in grid
- **Frontend URL:** `base_url('assets/uploads/partners/filename.png')`
- **Note:** Still supports external URLs (e.g., Clearbit logos)

### Board Members
- **Field:** Photo
- **Upload to:** `assets/uploads/board_members/`
- **Display:** Circular thumbnail 80x80px in grid
- **Frontend URL:** `base_url('assets/uploads/board_members/filename.jpg')`
- **Note:** Still supports external URLs

---

## 🧪 Testing File Upload

After creating directories:

1. Login to admin panel
2. Go to **Companies** → Click **Add**
3. Fill in company name
4. Click **Choose File** for Logo field
5. Select an image (JPG, PNG, GIF, WebP)
6. Click **Save**
7. Logo should appear as thumbnail in the grid

Repeat for Partners and Board Members.

---

## 📸 Supported File Types

GroceryCRUD allows these image formats by default:
- `.jpg` / `.jpeg`
- `.png`
- `.gif`
- `.webp`
- `.svg`

Max file size: Typically 2MB (depends on PHP settings)

---

## 🐛 Troubleshooting

### Issue: "Permission denied" error when uploading
**Solution:**
```bash
chmod 755 assets/uploads/companies
chmod 755 assets/uploads/partners
chmod 755 assets/uploads/board_members
```

### Issue: Upload works but images don't display
**Solution:**
1. Check if files exist: `ls -la assets/uploads/companies/`
2. Verify file permissions: `chmod 644 assets/uploads/companies/*`
3. Check path in browser: `https://rkgroup.biz/new_site/assets/uploads/companies/filename.jpg`

### Issue: Large files failing to upload
**Solution:** Increase PHP upload limits in `php.ini` or `.htaccess`:
```apache
php_value upload_max_filesize 10M
php_value post_max_size 10M
```

---

## 📋 Quick Setup via SSH

If you have SSH access:

```bash
cd /home4/tempucqs/public_html/rkgroup.biz/new_site/

# Create all directories at once
mkdir -p assets/uploads/{companies,partners,board_members,timeline}

# Set permissions
chmod 755 assets/uploads
chmod 755 assets/uploads/companies
chmod 755 assets/uploads/partners
chmod 755 assets/uploads/board_members
chmod 755 assets/uploads/timeline

# Verify
ls -la assets/uploads/
```

Expected output:
```
drwxr-xr-x 5 user group 4096 Jan 15 12:00 .
drwxr-xr-x 8 user group 4096 Jan 15 12:00 ..
drwxr-xr-x 2 user group 4096 Jan 15 12:00 board_members
drwxr-xr-x 2 user group 4096 Jan 15 12:00 companies
drwxr-xr-x 2 user group 4096 Jan 15 12:00 partners
```

---

## ✅ CHECKLIST

Before testing file uploads:

- [ ] Created `assets/uploads/` directory
- [ ] Created `assets/uploads/companies/` subdirectory
- [ ] Created `assets/uploads/partners/` subdirectory
- [ ] Created `assets/uploads/board_members/` subdirectory
- [ ] Set permissions to 755 on all upload directories
- [ ] Uploaded updated `Admin.php` with file upload code
- [ ] Tested uploading a company logo
- [ ] Verified logo appears as thumbnail in grid
- [ ] Checked frontend displays uploaded logos correctly

Once all checked, your file upload system is fully functional! 🎉
