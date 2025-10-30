# 📝 ADMIN EDITABLE CONTENT GUIDE

## Overview
**EVERYTHING on the website is now editable through the admin panel!**

The admin can manage all website content without touching any code:
- ✅ All text content via Site Settings
- ✅ Companies via Companies CRUD
- ✅ Partners via Partners CRUD
- ✅ Board Members via Board Members CRUD
- ✅ Advisory Board via Board Members CRUD
- ✅ Timeline Events via Timeline CRUD
- ✅ News & Updates via News CRUD

## 🏠 HOMEPAGE - Editable Content

### Hero Section (Site Settings)
| Setting Key | Description | Current Value |
|------------|-------------|---------------|
| `hero_title` | Main heading | "Scaling New Heights" |
| `hero_subtitle` | Subtitle | "Where Ambition Meets Experience in Every Venture" |
| `hero_description` | Description paragraph | "Leading India's e-commerce revolution..." |
| `hero_stat_brands` | Brands count (stats) | "400" |

### Business Section (Site Settings)
| Setting Key | Description | Current Value |
|------------|-------------|---------------|
| `business_title` | Section title | "BUSINESS" |
| `business_subtitle` | Section subtitle | "Our Companies" |

**Companies:** Edit via Admin > Companies (add/edit/delete/upload logos)

### Partnerships Section (Site Settings)
| Setting Key | Description | Current Value |
|------------|-------------|---------------|
| `partnerships_title` | Section title | "Partnerships" |

**Partners:** Edit via Admin > Partners (add/edit/delete/upload logos)

### CSR Section (Site Settings)
| Setting Key | Description |
|------------|-------------|
| `csr_title` | Main title ("RK Trust") |
| `csr_subtitle` | Subtitle ("CSR Philosophy") |
| `csr_intro` | First intro paragraph |
| `csr_paragraph_1` | Second paragraph |
| `csr_initiatives_title` | Initiatives heading |
| `csr_initiative_1` through `csr_initiative_8` | Each initiative bullet point |
| `csr_paragraph_2` | Third paragraph |
| `csr_paragraph_3` | Closing paragraph |
| `csr_button_text` | Button text ("Know More") |
| `csr_button_url` | Button link URL |
| `csr_image` | Image file path |

### News Section (Site Settings)
| Setting Key | Description |
|------------|-------------|
| `news_title` | Section title |
| `news_description` | Section description |
| `news_linkedin_title` | LinkedIn card title |
| `news_linkedin_url` | LinkedIn profile URL |
| `news_linkedin_embed` | LinkedIn embed URL |
| `news_instagram_title` | Instagram card title |

**News Items:** Edit via Admin > News & Updates (add/edit news with images)

---

## 📖 ABOUT PAGE - Editable Content

### Vision Hero Section (Site Settings)
| Setting Key | Description | Current Value |
|------------|-------------|---------------|
| `about_vision_title` | Hero title | "OUR VISION" |
| `about_vision_subtitle` | Hero subtitle | "The Guiding Vision At RK Group..." |

### RK Group Intro (Site Settings)
| Setting Key | Description | Current Value |
|------------|-------------|---------------|
| `about_intro_title` | Section title | "RK GROUP" |
| `about_intro_tagline` | Tagline | "- Excellence Is Our Passion..." |
| `about_intro_description` | Intro paragraph | "We are constantly pushing boundaries..." |

### Journey Timeline Section (Site Settings)
| Setting Key | Description | Current Value |
|------------|-------------|---------------|
| `about_journey_title` | Section title | "JOURNEY OF RK GROUP" |
| `about_journey_subtitle` | Section subtitle | "Decades of Excellence and Growth" |

**Timeline Events:** Edit via Admin > Timeline (add/edit/delete/upload images)

### People Section (Site Settings)
| Setting Key | Description | Current Value |
|------------|-------------|---------------|
| `about_people_title` | Section title | "PEOPLE" |
| `about_people_description` | Section description | "A Passion For Excellence..." |

**Board Members:** Edit via Admin > Board Members (filter by member_type = 'board')

### Advisory Board Section (Site Settings)
| Setting Key | Description | Current Value |
|------------|-------------|---------------|
| `about_advisory_title` | Section title | "ADVISORY BOARD" |

**Advisory Members:** Edit via Admin > Board Members (filter by member_type = 'advisory')

### Our Companies Section (Site Settings)
| Setting Key | Description | Current Value |
|------------|-------------|---------------|
| `about_companies_title` | Section title | "OUR COMPANIES" |
| `about_companies_subtitle` | Section subtitle | "Powering innovation across diverse industries" |

**Companies:** Same data as homepage, from Admin > Companies

### Partnerships Section (Site Settings)
| Setting Key | Description | Current Value |
|------------|-------------|---------------|
| `about_partnerships_title` | Section title | "PARTNERSHIPS AND BRANDS" |

**Partners:** Same data as homepage, from Admin > Partners

### Careers CTA Section (Site Settings)
| Setting Key | Description | Current Value |
|------------|-------------|---------------|
| `about_careers_title` | Section title | "JOIN OUR TEAM" |
| `about_careers_description` | Description paragraph | "Explore exciting career opportunities..." |
| `about_careers_button` | Button text | "Join Us!" |

---

## 🎯 HOW TO EDIT CONTENT

### Method 1: Edit Text Content (Site Settings)
1. Go to **Admin > Settings**
2. Find the setting you want to edit
3. Click **Edit**
4. Update the `setting_value` field
5. Click **Update**
6. Refresh the frontend page to see changes

### Method 2: Edit Companies
1. Go to **Admin > Companies**
2. Click **Add Company** or **Edit** existing
3. Fill in:
   - **Name** - Company name
   - **Logo** - Upload image file
   - **Description** - Company description (shows on homepage carousel)
   - **Website URL** - Company website link (optional)
   - **Display Order** - Number for sorting
   - **Active** - Toggle to show/hide
4. Save

### Method 3: Edit Partners
1. Go to **Admin > Partners**
2. Click **Add Partner** or **Edit** existing
3. Fill in:
   - **Name** - Partner name
   - **Logo** - Upload image file
   - **Website URL** - Partner website (optional)
   - **Display Order** - Number for sorting
   - **Active** - Toggle to show/hide
4. Save

### Method 4: Edit Board Members
1. Go to **Admin > Board Members**
2. Click **Add Board Member** or **Edit** existing
3. Fill in:
   - **Name** - Member name
   - **Position** - Job title/role
   - **Photo** - Upload image file
   - **Bio** - Short biography
   - **Education** - Educational background
   - **Member Type** - Choose "Board" or "Advisory"
   - **Display Order** - Number for sorting
   - **Active** - Toggle to show/hide
4. Save

### Method 5: Edit Timeline Events
1. Go to **Admin > Timeline**
2. Click **Add Timeline Event** or **Edit** existing
3. Fill in:
   - **Year** - Event year (e.g., "2015")
   - **Title** - Event title
   - **Description** - Event description
   - **Image URL** - Upload image file
   - **Alignment** - Choose "left" or "right"
   - **Display Order** - Number for sorting
   - **Active** - Toggle to show/hide
4. Save

### Method 6: Edit News Items
1. Go to **Admin > News & Updates**
2. Click **Add News Item** or **Edit** existing
3. Fill in:
   - **Title** - News title
   - **Content** - Full news content
   - **Image** - Upload image file
   - **Embed URL** - LinkedIn/Instagram embed URL
   - **Embed Type** - Choose platform
   - **Category** - News category
   - **Is Featured** - Show on homepage?
   - **Active** - Toggle to show/hide
4. Save

---

## 📊 Database Setup

Run the SQL file to create all settings:

```bash
# Via MySQL command line:
mysql -u root -p tempucqs_rkgroup_new_website < site_settings_complete.sql

# Or via phpMyAdmin:
# 1. Open phpMyAdmin
# 2. Select database: tempucqs_rkgroup_new_website
# 3. Click "SQL" tab
# 4. Paste contents of site_settings_complete.sql
# 5. Click "Go"
```

---

## 🔄 How It Works

### Frontend Views
All frontend views now check for settings and load content dynamically:

```php
// Example: Hero title with fallback
<?= isset($settings['hero_title']) ? esc($settings['hero_title']) : 'Scaling New Heights' ?>
```

### Benefits
1. **No Code Changes Needed** - Edit content through admin panel
2. **Fallback Values** - Page works even if settings not configured
3. **Type Safety** - All values escaped for security
4. **Flexible** - Add new settings without changing code
5. **Consistent** - Single source of truth for all content

---

## 📋 Content Management Workflow

### To Update Homepage Hero:
1. Admin > Settings
2. Edit `hero_title`, `hero_subtitle`, `hero_description`
3. Save
4. Check frontend

### To Add a New Company:
1. Admin > Companies
2. Click "Add Company"
3. Fill in name, upload logo, add description
4. Set display_order (higher numbers show later)
5. Set Active = Yes
6. Save
7. Company appears on both homepage and about page

### To Edit CSR Content:
1. Admin > Settings
2. Edit any `csr_*` setting
3. Can edit title, paragraphs, initiatives, button text/URL
4. Save
5. Check homepage CSR section

### To Add Timeline Event:
1. Admin > Timeline
2. Add event with year, title, description, image
3. Set alignment (left/right for alternating design)
4. Save
5. Appears on about page timeline

---

## ✅ What's Editable Summary

**Homepage:**
- ✅ Hero section (title, subtitle, description, stats)
- ✅ Business section title
- ✅ Companies (full CRUD with images)
- ✅ Partnerships title
- ✅ Partners (full CRUD with images)
- ✅ CSR section (all text, initiatives, button, image)
- ✅ News section (title, description, embeds)

**About Page:**
- ✅ Vision hero (title, subtitle)
- ✅ RK Group intro (title, tagline, description)
- ✅ Journey timeline (title, subtitle, events)
- ✅ Timeline events (full CRUD with images)
- ✅ People section (title, description)
- ✅ Board members (full CRUD with photos)
- ✅ Advisory board title
- ✅ Advisory members (full CRUD with photos)
- ✅ Companies section (title, subtitle)
- ✅ Partnerships title
- ✅ Careers CTA (title, description, button)

---

## 🚀 Next Steps

1. **Run SQL File** - Import all site settings
2. **Test Admin Panel** - Try editing each setting
3. **Check Frontend** - Verify changes appear
4. **Upload Production** - Deploy files to live server
5. **Train Admin** - Show how to edit content

**Everything is ready for complete content management through the admin panel!**
