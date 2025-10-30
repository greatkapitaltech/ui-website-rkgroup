-- ========================================
-- RK Group Website Database Schema
-- ========================================
-- Database: rk-group
-- Created: 2025
-- ========================================

USE `rk-group`;

-- ========================================
-- 1. COMPANIES TABLE
-- ========================================
CREATE TABLE IF NOT EXISTS `companies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `logo` varchar(500) DEFAULT NULL,
  `description` text NOT NULL,
  `website_url` varchar(500) DEFAULT NULL,
  `display_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert sample companies
INSERT INTO `companies` (`name`, `logo`, `description`, `website_url`, `display_order`, `is_active`) VALUES
('RK World Infocom', 'logo-rkwi.png', 'Leading FMCG distribution platform, delivering products across 95% of India''s pin codes. RKWI connects brands with customers with supply chain expertise and trusted partnerships with leading global brands.', NULL, 1, 1),
('Great Kapital Ventura', 'logo-gk.png', 'A fintech platform dedicated to redefining working capital management. Great Kapital provides innovative supply chain finance solutions that enable corporations to optimize cash flow while ensuring timely payments for suppliers.', NULL, 2, 1),
('Valuekart', 'logo-valuekart.png', 'A cross-border e-commerce enabler, providing end-to-end market access solutions for international aspiring to target the Indian markets. ValueKart provides market entry strategy, supply chain and logistics management, order fulfillment, platform integration, and category management.', NULL, 3, 1),
('RK Fabrics', 'logo-rkfabrics.png', 'Pioneers of textile trading in India, leveraging an experienced team, strategic partnerships, and state-of-the-art infrastructure. Driving operational efficiency through exclusive partnerships with global textile brands like Luthai, Penfabric, Stylem, and Monti.', NULL, 4, 1),
('Robust Kommerce', 'logo-robustkommerce.png', 'Myntra''s exclusive partner for international brand collaborations across Retail, Shop-in-Shop, and Digital Marketplace commerce. Offering end-to-end solutions from market entry to retail expansion, delivering world-class fashion through premium retail stores and digital platforms.', NULL, 5, 1),
('Wishery', 'logo-wishery.png', 'A leading wholesale and retail trader of mobile phones, electronics, and lifestyle products. With operations spanning 19 states in India, Wishery has a stronghold in B2B and B2C segments, combining reliable sourcing, efficient distribution, and a technology-driven approach.', NULL, 6, 1),
('Westbury', 'logo-westbury.png', 'Westbury Kommerce provides end-to-end e-commerce and omnichannel solutions for retail and fashion brands. Combining deep industry expertise with scalable solutions allowing brands to grow efficiently, reach wider audiences, and deliver seamless shopping experiences.', NULL, 7, 1),
('Kalandari Capital', 'logo-kalandari.png', 'A new-age financial services platform focused on making lending transparent, quick, and hassle-free. Our mission is to reduce borrowing costs for new-age businesses while ensuring a seamless and efficient experience by leveraging technology for scale.', NULL, 8, 1),
('RisingStar', NULL, 'Rising Star Kommerce partners with suppliers to source a wide range of products across categories for listing and sales on Blinkit, one of India''s leading quick commerce platforms, ensuring fast and reliable delivery to consumers.', NULL, 9, 1),
('RapidKey', NULL, 'An independent TaaS seller for Flipkart, RapidKey is a growth partner for brands, managing the entire e-commerce lifecycle—from procurement and inventory planning to warehousing, delivery, returns, and liquidation. Combining entrepreneurial agility with Flipkart''s ecosystem support.', NULL, 10, 1);

-- ========================================
-- 2. PARTNERS TABLE
-- ========================================
CREATE TABLE IF NOT EXISTS `partners` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `logo` varchar(500) NOT NULL,
  `website_url` varchar(500) DEFAULT NULL,
  `display_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert sample partners
INSERT INTO `partners` (`name`, `logo`, `website_url`, `display_order`, `is_active`) VALUES
('Amazon', 'Amazon_2024.webp', 'https://amazon.in', 1, 1),
('Flipkart', 'flipkart-logo.webp', 'https://flipkart.com', 2, 1),
('Myntra', 'myntra-logo.png', 'https://myntra.com', 3, 1),
('Blinkit', 'https://logo.clearbit.com/blinkit.com', 'https://blinkit.com', 4, 1),
('PharmEasy', 'https://logo.clearbit.com/pharmeasy.in', 'https://pharmeasy.in', 5, 1),
('Cars24', 'CARS24_logo.png', 'https://cars24.com', 6, 1),
('ABFRL', 'https://logo.clearbit.com/abfrl.com', 'https://abfrl.com', 7, 1),
('Nike', 'https://logo.clearbit.com/nike.com', 'https://nike.com', 8, 1),
('Scapia', 'https://logo.clearbit.com/scapia.com', 'https://scapia.com', 9, 1),
('PhonePe', 'https://logo.clearbit.com/phonepe.com', 'https://phonepe.com', 10, 1);

-- ========================================
-- 3. BOARD MEMBERS TABLE
-- ========================================
CREATE TABLE IF NOT EXISTS `board_members` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `photo` varchar(500) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `education` varchar(500) DEFAULT NULL,
  `member_type` enum('board','advisory') DEFAULT 'board',
  `display_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert sample board members
INSERT INTO `board_members` (`name`, `position`, `photo`, `bio`, `education`, `member_type`, `display_order`, `is_active`) VALUES
('Ramesh Kumar Shah', 'Founder & Chairperson - RK Group', 'https://rkgroup.biz/images/team5.png', NULL, 'Harvard Business School', 'board', 1, 1),
('Pavan Chopra', 'Director - RK Group', 'https://rkgroup.biz/images/team1.png', NULL, 'IIM Bangalore', 'board', 2, 1),
('Mahendra Chordia', 'Director - RK Group', 'https://rkworldinfocom.com/assets/images/team/2.png', 'CEO of RK World Infocom | Former VP Finance at RK Group & CFO at Capillary Technologies', 'ICAI, IIM Bangalore', 'board', 3, 1),
('Sonal Shah', 'Director - RK Group', 'https://rkgroup.biz/images/team6.png', 'Founder & CEO of Valuecart | Director at RK World Infocom & Kalandri Capital', 'Columbia Business School', 'board', 4, 1),
('Akshay Shah', 'Director - RK Group', 'https://rkgroup.biz/images/team2.png', 'Founder & CEO of Great Kapital | Director at Valuecart, Westbury Kommerce & Kalandri Capital', 'Columbia University, Tsinghua University', 'board', 5, 1),
('Abhishek Jha', 'CEO - Westbury Kommerce', 'Abhishek Jha.jpg', 'Former AVP at Aditya Birla Fashion & Retail | Former Chief Manager at Reliance BIG Entertainment', NULL, 'board', 6, 1),
('Mallikharjuna Rao Ch', 'COO - Robust Kommerce', 'Mallikharjuna Rao Ch.jpeg', 'Former National Head – New Businesses at Levi Strauss & Co.', 'IIM Kozhikode', 'board', 7, 1);

-- Insert advisory board members
INSERT INTO `board_members` (`name`, `position`, `photo`, `bio`, `education`, `member_type`, `display_order`, `is_active`) VALUES
('Gopalakrishnan Sankar', 'Director - RK Group', 'Gopalakrishnan-Sankar-1-1.jpg', 'Former CEO of Mysore Saree Udyog LLP, Reliance Footprint, Reliance Living, Payless ShoeSource India & M&S India', 'IIM Ahmedabad', 'advisory', 1, 1),
('Prakash Nedungadi', 'Director - RK Group', 'prakash-nedungadi.jpg', 'External Advisor at Bain & Company | Former leadership at Unilever, P&G, and Aditya Birla Group', 'Stanford GSB', 'advisory', 2, 1),
('H. Padamchand Khincha', 'Director - RK Group', 'Padam Khincha.png', 'ITRAF Board Member | Chartered Accountant | Author of Decoding Section 5', 'University of Bangalore (Commerce & Law)', 'advisory', 3, 1);

-- ========================================
-- 4. CONTACT SUBMISSIONS TABLE
-- ========================================
CREATE TABLE IF NOT EXISTS `contact_submissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `interest` enum('jobs','business','csr','other') DEFAULT 'other',
  `subject` varchar(500) NOT NULL,
  `message` text NOT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `status` enum('new','read','replied','archived') DEFAULT 'new',
  `admin_notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_status` (`status`),
  KEY `idx_created` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ========================================
-- 5. SITE SETTINGS TABLE
-- ========================================
CREATE TABLE IF NOT EXISTS `site_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `setting_key` varchar(100) NOT NULL UNIQUE,
  `setting_value` text DEFAULT NULL,
  `setting_type` enum('text','textarea','number','url','email','image','json') DEFAULT 'text',
  `setting_group` varchar(50) DEFAULT 'general',
  `description` varchar(500) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert default site settings
INSERT INTO `site_settings` (`setting_key`, `setting_value`, `setting_type`, `setting_group`, `description`) VALUES
('site_name', 'RK Group', 'text', 'general', 'Website name'),
('site_tagline', 'Where Ambition Meets Experience in Every Venture', 'text', 'general', 'Site tagline'),
('contact_email', 'contact@rkgroup.biz', 'email', 'contact', 'Primary contact email'),
('contact_phone', '+91 80-4264-0241', 'text', 'contact', 'Contact phone number'),
('office_address', 'RK Group, No. 1/1, 3rd floor, Vinayaka towers, Bangalore', 'textarea', 'contact', 'Office address'),
('office_hours', '8:00 AM until 6:00 PM', 'text', 'contact', 'Business hours'),
('linkedin_url', 'https://www.linkedin.com/company/rk-groupp/', 'url', 'social', 'LinkedIn profile URL'),
('instagram_url', '#', 'url', 'social', 'Instagram profile URL'),
('youtube_url', '#', 'url', 'social', 'YouTube channel URL'),
('twitter_url', '#', 'url', 'social', 'Twitter profile URL'),
('hero_title', 'Scaling New Heights', 'text', 'homepage', 'Hero section title'),
('hero_subtitle', 'Where Ambition Meets Experience in Every Venture', 'text', 'homepage', 'Hero section subtitle'),
('hero_description', 'Leading India''s e-commerce revolution with innovative solutions across retail, fintech, and technology', 'textarea', 'homepage', 'Hero section description'),
('stats_companies', '10+', 'text', 'homepage', 'Number of companies stat'),
('stats_brands', '400+', 'text', 'homepage', 'Number of brands stat'),
('rk_trust_url', 'https://www.rktrust.in', 'url', 'general', 'RK Trust website URL'),
('careers_iframe_url', 'https://hr.gkdev.in/public/jobs', 'url', 'careers', 'Careers iframe URL');

-- ========================================
-- 6. NEWS ITEMS TABLE (Optional)
-- ========================================
CREATE TABLE IF NOT EXISTS `news_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(500) NOT NULL,
  `content` text DEFAULT NULL,
  `embed_url` varchar(500) DEFAULT NULL,
  `embed_type` enum('linkedin','instagram','youtube','other') DEFAULT 'other',
  `image` varchar(500) DEFAULT NULL,
  `external_link` varchar(500) DEFAULT NULL,
  `category` varchar(100) DEFAULT 'general',
  `display_order` int(11) DEFAULT 0,
  `is_featured` tinyint(1) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_active` (`is_active`),
  KEY `idx_featured` (`is_featured`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ========================================
-- End of Schema
-- ========================================
